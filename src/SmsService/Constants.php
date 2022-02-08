<?php /** @noinspection PhpUnused */
namespace HMS\SmsService;

/**
 * Class HMS SmsService Constants
 *
 * @author Martin Zeitler
 */
class Constants {
    public const SMS_SERVICE_SEND_TEMPLATE_URL  = "https://{IP:Port}/common/sms/sendTemplateMessage";
    public const SMS_SERVICE_NOTIFY_REPORT_MESSAGE_URL  = "https://{IP:Port}/common/sms/notifyReportMessage";
    public const SMS_SERVICE_NOTIFY_SMS_MESSAGE_URL  = "https://{IP:Port}/common/sms/notifySmsMessage";
}
