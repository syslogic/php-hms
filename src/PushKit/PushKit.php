<?php
namespace HMS\PushKit;

use HMS\Core\Wrapper;
use HMS\PushKit\Android\AndroidConfig;
use HMS\PushKit\Android\AndroidNotification;
use JetBrains\PhpStorm\ArrayShape;
use stdClass;

/**
 * Class HMS PushKit Wrapper
 *
 * @author Martin Zeitler
 */
class PushKit extends Wrapper {

    private string $url_message_send;
    private string $url_topics_list;
    private string $url_topic_subscribe;
    private string $url_topic_unsubscribe;
    private string $url_token_data_query;
    private string $url_token_data_delete;

    /** Constructor. */
    public function __construct( array|string $config ) {
        parent::__construct( $config );
        $app_id = $config['client_id']; /* The oAuth2 `client_id` actually is the `app_id`. */
        $this->url_message_send      = str_replace('{appId}', $app_id, Constants::PUSHKIT_MESSAGE_SEND);
        $this->url_topics_list       = str_replace('{appId}', $app_id, Constants::PUSHKIT_TOPICS_LIST);
        $this->url_topic_subscribe   = str_replace('{appId}', $app_id, Constants::PUSHKIT_TOPIC_SUBSCRIBE);
        $this->url_topic_unsubscribe = str_replace('{appId}', $app_id, Constants::PUSHKIT_TOPIC_UNSUBSCRIBE);
        $this->url_token_data_query  = str_replace('{appId}', $app_id, Constants::PUSHKIT_TOKEN_DATA_QUERY);
        $this->url_token_data_delete = str_replace('{appId}', $app_id, Constants::PUSHKIT_TOKEN_DATA_DELETE);
    }

    /**
     * Querying the Topic Subscription List.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/topic-list-api-0000001050706152">Querying the Topic Subscription List</a>
     * @param string $token
     * @return stdClass
     */
    public function topics_list( string $token ): stdClass {
        $payload = ['token' => $token];
        return $this->curl_request('POST', $this->url_topics_list, $payload, $this->auth_header());
    }

    /**
     * Subscribing to a Topic.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/topic-sub-api-0000001051066122">Subscribing to a Topic</a>
     * @param string $topic_name
     * @param string|array $tokens
     * @return stdClass
     */
    public function topic_subscribe( string $topic_name, string|array $tokens ): stdClass {
        if (is_string($tokens)) {$tokens = [ $tokens ];}
        $payload = ['topic' => $topic_name, 'tokenArray' => $tokens];
        return $this->curl_request('POST', $this->url_topic_subscribe, $payload, $this->auth_header());
    }

    /**
     * Unsubscribing from a Topic.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/topic-unsub-api-0000001050746185">Unsubscribing from a Topic</a>
     * @param string $topic_name
     * @param string|array $tokens
     * @return stdClass
     */
    public function topic_unsubscribe( string $topic_name, string|array $tokens ): stdClass {
        if (is_string($tokens)) {$tokens = [ $tokens ];}
        $payload = ['topic' => $topic_name, 'tokenArray' => $tokens];
        return $this->curl_request('POST', $this->url_topic_unsubscribe, $payload, $this->auth_header());
    }

    /**
     * Sending Downstream Messages to Token.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/https-send-api-0000001050986197">Sending Downstream Messages</a>
     * @param string|array $token
     * @param string       $title
     * @param string       $body
     * @param string|null  $image
     * @return stdClass
     */
    public function send_message_to_token( string|array $token, string $title, string $body, string|null $image=null ): stdClass {
        if (is_string($token)) {$token = [ $token ];}
        $payload = $this->get_payload_by_mode( 'token', $token, $title, $body, $image );
        return $this->curl_request('POST', $this->url_message_send, $payload, $this->auth_header());
    }

    /**
     * Sending Downstream Messages to Topic.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/https-send-api-0000001050986197">Sending Downstream Messages</a>
     * @param string       $topic
     * @param string       $title
     * @param string       $body
     * @param string|null  $image
     * @return stdClass
     */
    public function send_message_to_topic( string $topic, string $title, string $body, string|null $image=null ): stdClass {
        $payload = $this->get_payload_by_mode( 'topic', $topic, $title, $body, $image );
        return $this->curl_request('POST', $this->url_message_send, $payload, $this->auth_header());
    }

    /**
     * Sending Downstream Messages to Condition.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/https-send-api-0000001050986197">Sending Downstream Messages</a>
     * @param string       $condition
     * @param string       $title
     * @param string       $body
     * @param string|null  $image
     * @return stdClass
     */
    public function send_message_to_condition( string $condition, string $title, string $body, string|null $image=null ): stdClass {
        $payload = $this->get_payload_by_mode( 'condition', $condition, $title, $body, $image );
        return $this->curl_request('POST', $this->url_message_send, $payload, $this->auth_header());
    }

    #[ArrayShape(['validate_only' => "bool", 'message' => "object"])]
    private function get_payload_by_mode( string $mode, string|array $argument, string $title, string $body, string|null $image=null ): array {
        if (! in_array( $mode , ['token', 'topic', 'condition'] ) ) {return [];}
        $notification = new Notification( $title, $body, $image );
        $android = new AndroidConfig([
            'notification' => AndroidNotification::fromArray([
                'click_action' => [
                    'type' => 2,
                    'url' => 'https://syslogic.io'
                ]
            ])
        ]);
        return [
            'validate_only' => false,
            'message' => (object) [
                $mode          => $argument, // one of: token, topic, condition.
                'notification' => $notification->asObject(),
                'data'         => '',
                'android'      => $android->asObject()
            ]
        ];
    }

    /**
     * Querying Data as a Data Controller.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/query-data-api-0000001051066126">Querying Data as a Data Controller</a>
     * @param string $token
     * @return stdClass
     */
    public function token_data_query( string $token ): stdClass {
        $payload =['token' => $token];
        return $this->curl_request('POST', $this->url_token_data_query, $payload, $this->auth_header());
    }

    /**
     * Deleting Data as a Data Controller.
     *
     * @see <a href="https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/del-data-api-0000001050746189">Deleting Data as a Data Controller</a>
     * @param string $token
     * @return stdClass
     */
    public function token_data_delete( string $token ): stdClass {
        $payload = ['token' => $token];
        return $this->curl_request('POST', $this->url_token_data_delete, $payload, $this->auth_header());
    }
}
