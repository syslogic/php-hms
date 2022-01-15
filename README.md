### Unofficial SDK for Huawei REST API

#### Project Status:

This project is still in an early pre-alpha stage:

| API | Current Status |
| --- | --- |
| [`AccountKit`](https://github.com/syslogic/php-hms/blob/master/src/AccountKit) | N/A |
| [`AdsKit`](https://github.com/syslogic/php-hms/blob/master/src/AdsKit) | N/A |
| [`AnalyticsKit`](https://github.com/syslogic/php-hms/blob/master/src/AnalyticsKit) | N/A |
| [`Connect`](https://github.com/syslogic/php-hms/tree/master/src/Connect) | Partial Support |
| [`DriveKit`](https://github.com/syslogic/php-hms/tree/master/src/DriveKit) | N/A |
| [`GameService`](https://github.com/syslogic/php-hms/tree/master/src/GameService) | N/A |
| [`HiAnalytics`](https://github.com/syslogic/php-hms/blob/master/src/HiAnalytics) | N/A * |
| [`LocationKit`](https://github.com/syslogic/php-hms/blob/master/src/LocationKit) | N/A |
| [`MapKit`](https://github.com/syslogic/php-hms/blob/master/src/MapKit) | N/A |
| [`PushKit`](https://github.com/syslogic/php-hms/blob/master/src/PushKit) | Partial Support |
| [`SearchKit`](https://github.com/syslogic/php-hms/blob/master/src/SearchKit) | N/A |
| [`WalletKit`](https://github.com/syslogic/php-hms/blob/master/src/WalletKit) | N/A |
| [`Wrapper`](https://github.com/syslogic/php-hms/blob/master/src/Core) | OK |

#### Installation:

The package is **not** yet available on Packagist. Once it is, that would be:

    composer require syslogic/php-hms

One still can map `namespace HMS` locally, eg. when checking out into project directory `lib`:

````
"autoload": {
  "psr-4": {
    "App\\": "src/",
    "HMS\\": "lib/php-hms/src/"
  }
}
````

#### Support:

- [Stack Overflow](https://stackoverflow.com/questions/tagged/huawei-mobile-services)
- [Issue Tracker](https://github.com/syslogic/php-hms/issues)

#### License:

The PHP SDK for Huawei REST API is licensed under the [MIT License](LICENSE).
