<?php
namespace HMS\PushKit;

/**
 * Huawei Message Receipt Status Codes
 * @link https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/msg-receipt-guide-0000001050040176
 *
 * There's even more default error codes:
 * https://developer.huawei.com/consumer/en/doc/development/HMSCore-Guides/commonerror-0000001059816656
 *
 * 0 - Success.
 * N/A
 *
 * 2 - The app is not installed.
 * If the app does not exist after the message is successfully sent to the device, the app has been uninstalled.
 *
 * 5 - The specified token does not belong to the current Android device user.
 * No app token exists in local data storage when the device receives the message.
 *
 * Possible causes are as follows:
 *  - The app is not activated.
 *  - A sub-user has been created and then deleted.
 *  - The token in the received message is different from the local app token. Possible causes are as follows:
 *  - The user clears the local app data.
 *  - The user updates the app by uninstallation and re-installation.
 *  - You have deleted the token by calling the deleteToken method of the Push SDK in the app.
 *  - After the device is restored to factory settings, the user relaunches the preloaded app, or re-installs and launches the non-preloaded app.
 *
 * 6 - Notification messages are not displayed.
 *
 * Possible causes are as follows:
 *  - You called the turnOffPush method of the Push SDK to disable the notification message display function.
 * 	- The user disabled the notification message display function on the device.
 * 	- The user disabled the notification channel specified for notification messages in the app.
 *
 * 10 - Inactive device.
 * If a device is inactive (that is, the device has been connected to the network for less than 30 days), no message is sent to the device.
 *
 * 15 - The message of the offline user is overwritten.
 * A policy of overwriting messages for offline users has been set through collapse_key in the server API.
 * Based on the policy, the message is overwritten and therefore not delivered to the device.
 *
 * 27 - The target app process does not exist on the device.
 * As a result, the data message is cached.
 * 	The target app process does not exist.
 *
 * 102 - The message is discarded due to frequency control.
 * A maximum of 3000 messages can be sent to an app on a device every day.
 * If the number of messages exceeds 3000, extra messages cannot be sent within 24 hours.
 *
 * 144 - The profileId parameter does not exist.
 * Ensure that the profile_id parameter exists when sending a downlink message.
 *
 * 201 - The message is cached due to management control.
 * Messages are controlled by the Push Kit server and cannot be sent.
 * It is recommended that messages be filtered to reduce invalid push messages.
 *
 * Possible causes:
 *  - The token specified in the message does not match the current sign-in user.
 *    (This may occur on a device where the multi-user function is enabled. On the device, different users match different tokens.)
 * 	- The user has disabled the notification message display function.
 * 	- The app has been uninstalled.
 *
 * NOTE: You can find the reason why the message sending is controlled based on the subStatus parameter.
 */
class ReceiptStatus {

    public function get_receipt_state( int $code ): string {

        return match ( $code ) {
              0 => 'Success',
              2 => 'The app is not installed',
              5 => 'The specified token does not belong to the current Android device user',
              6 => 'Notification messages are not displayed',
             10 => 'Inactive device',
             15 => 'The message of the offline user is overwritten',
             27 => 'The target app process does not exist on the device',
            102 => 'The message is discarded due to frequency control',
            144 => 'The profileId parameter does not exist',
            201 => 'The message is cached due to management control',
            default => 'Unknown Code: ' . $code,
        };
    }
}
