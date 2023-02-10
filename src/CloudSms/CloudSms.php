<?php
namespace HMS\CloudSms;

use HMS\AccountKit\AccountKit;
use HMS\Core\Wrapper;

/**
 * Class Huawei Cloud SMS Wrapper
 *
 * Your current account is registered in [Europe or Russia].
 * HUAWEI CLOUD does not support accounts in the above regions for the time being.
 * Please log in with accounts in other regions.
 *
 * @see <a href="https://console-intl.huaweicloud.com/msgsms/">Message & SMS console</a>
 * @see <a href="https://support.huaweicloud.com/intl/en-us/usermanual-msgsms/sms_03_0001.html">Creating an SMS Application</a>
 * @author Martin Zeitler
 */
class CloudSms extends Wrapper {
    public function __construct( array|null $config = null ) {
        parent::__construct( $config );
        $this->post_init();

        /* Obtain an access-token. */
        $account_kit = new AccountKit( $config );
        $this->access_token = $account_kit->get_access_token();
    }

    protected function post_init(): void {}

    /**
     * Sending SMS
     *
     * @see <a href="https://support.huaweicloud.com/intl/en-us/api-msgsms/sms_05_0001.html">SMS Sending API</a>
     */
    public function send_sms(string $channel_id, string $receivers, string $template_id, array $template_params, string $status_callback_url='', string $signature=''): bool|\stdClass
    {
        return $this->request('POST', Constants::SMS_SEND_MESSAGE_URL,  [
            'Authorization' => 'WSSE realm="SDP",profile="UsernameToken",type="Appkey"',
            'X-WSSE' => $this->buildWsseHeader()
            ], [
                'from' => $channel_id,
                'to' => $receivers,
                'templateId' => $template_id,
                'templateParas' => $template_params,
                'statusCallback' => $status_callback_url,
                'signature' => $signature // Required when the universal template for Chinese mainland SMS is being used.
            ] );
    }

    /**
     * Sending SMS in Batches
     *
     * @see <a href="https://support.huaweicloud.com/intl/en-us/api-msgsms/sms_05_0002.html">Batch SMS Sending API</a>
     */
    public function send_batch_sms(string $channel_id, array $sms_content, string $status_callback_url='', string $signature=''): bool|\stdClass
    {
        return $this->request('POST', Constants::SMS_BATCH_SEND_MESSAGE_URL,  [
            'Authorization' => 'WSSE realm="SDP",profile="UsernameToken",type="Appkey"',
            'X-WSSE' => $this->buildWsseHeader()
        ], [
            'from' => $channel_id,
            'smsContent' => $sms_content,
            'statusCallback' => $status_callback_url,
            'signature' => $signature // When the universal template for Chinese mainland SMS is used.
        ] );
    }

    /**
     * Parse the status report data.
     * 'smsMsgId': Unique ID of an SMS
     * 'total': Number of SMS segments
     * 'sequence': Sequence number of an SMS after splitting
     * 'source': Status report source
     * 'updateTime': Resource update time
     * 'status': Enumeration values of the status report
     * 'orgCode': Status code
     * @see <a href="https://support.huaweicloud.com/intl/en-us/api-msgsms/sms_05_0003.html">Status Report Receiving API/a>
     * @param string $data Status report data pushed by the SMS platform.
     */
    public function parse_status_report(string $data): array {
        $result = [];
        parse_str(urldecode($data), $result);
        $result['success'] = false;
        if (strtoupper($result['status']) === 'DELIVRD') {
            $result['success'] = true;
        }
        return $result;
    }

    /**
     * Parse an uplink SMS message.
     * 'smsMsgId': Unique ID of an uplink SMS message
     * 'from': Number used to send an uplink SMS message
     * 'to': Number used to receive an uplink SMS message
     * 'body': Contents in an uplink SMS message
     * @see <a href="https://support.huaweicloud.com/intl/en-us/api-msgsms/sms_05_0004.html">Uplink SMS Receiving API/a>
     * @param string $data Notification data in the uplink SMS message pushed by the SMS platform.
     */
    function parse_uplink_message(string $data): array {
        $result = [];
        parse_str(urldecode($data), $result);
        return $result;
    }

    /**
     * Construct the value of smsContent.
     * @param array $receiver
     * @param string $template_id
     * @param array $template_params
     * @param string $signature Signature name, which must be specified when the universal template for Chinese mainland SMS is used.
     * @return string[]
     */
    public function get_diff_sms(array $receiver, string $template_id, array $template_params, string $signature=''): array {
        if (!empty($signature)  && strlen($signature) > 0) {
            return ['to' => $receiver, 'templateId' => $template_id, 'templateParas' => $template_params, 'signature' => $signature];
        }
        return ['to' => $receiver, 'templateId' => $template_id, 'templateParas' => $template_params];
    }

    /**
     * Construct the value of X-WSSE header.
     * @return string
     */
    function buildWsseHeader(): string {
        date_default_timezone_set('Europe/Berlin');
        $now = date('Y-m-d\TH:i:s\Z'); // Created
        $nonce = uniqid(); // Nonce
        $base64 = base64_encode(hash('sha256', ($nonce . $now . $this->oauth2_client_secret))); // PasswordDigest
        $format = "UsernameToken Username=\"%s\",PasswordDigest=\"%s\",Nonce=\"%s\",Created=\"%s\"";
        return sprintf($format, $this->oauth2_client_id, $base64, $nonce, $now);
    }
}
