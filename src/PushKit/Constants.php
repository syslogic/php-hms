<?php
namespace HMS\PushKit;

/**
 * Class HMS PushKit Constants
 *
 * @author Martin Zeitler
 */
class Constants {

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/https-send-api-0000001050986197 Sending Downstream Messages */
    public const PUSHKIT_MESSAGE_SEND = "https://push-api.cloud.huawei.com/v1/{appId}/messages:send";

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/topic-list-api-0000001050706152 Querying the Topic Subscription List */
    public const PUSHKIT_TOPICS_LIST = "https://push-api.cloud.huawei.com/v1/{appId}/topic:list";

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/topic-sub-api-0000001051066122 Subscribing to a Topic */
    public const PUSHKIT_TOPIC_SUBSCRIBE = "https://push-api.cloud.huawei.com/v1/{appId}/topic:subscribe";

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/topic-unsub-api-00000010507461856122">Unsubscribing from a Topic */
    public const PUSHKIT_TOPIC_UNSUBSCRIBE = "https://push-api.cloud.huawei.com/v1/{appId}/topic:unsubscribe";

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/query-data-api-0000001051066126 Querying Data as a Data Controller */
    public const PUSHKIT_TOKEN_DATA_QUERY = "https://push-api.cloud.huawei.com/v1/{appId}/token:query";

    /** @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-References/del-data-api-0000001050746189 Deleting Data as a Data Controller */
    public const PUSHKIT_TOKEN_DATA_DELETE = "https://push-api.cloud.huawei.com/v1/{appId}/token:delete";
}
