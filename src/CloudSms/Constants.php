<?php /** @noinspection PhpUnused */
namespace HMS\CloudSms;

/**
 * Class HMS SmsService Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    // https://support.huaweicloud.com/intl/en-us/api-msgsms/sms_05_0001.html
    public const SMS_SEND_MESSAGE_URL  = "https://smsapi.ap-southeast-1.myhuaweicloud.com:443/sms/batchSendSms/v1";
    public const SMS_BATCH_SEND_MESSAGE_URL  = "https://smsapi.ap-southeast-1.myhuaweicloud.com:443/sms/batchSendDiffSms/v1";

    public const SMS_SEND_TEMPLATE_MESSAGE_URL  = "https://smsapi.ap-southeast-1.myhuaweicloud.com:443/common/sms/sendTemplateMessage";
    public const SMS_NOTIFY_REPORT_MESSAGE_URL  = "https://smsapi.ap-southeast-1.myhuaweicloud.com:443/common/sms/notifyReportMessage";
    public const SMS_NOTIFY_SMS_MESSAGE_URL  = "https://smsapi.ap-southeast-1.myhuaweicloud.com:443/common/sms/notifySmsMessage";
}
