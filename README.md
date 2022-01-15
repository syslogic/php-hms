### PHP SDK for Huawei REST API

Disclaimer: This product is **not** officially endorsed or certified by Huawei Technologies.<br/>
The trademarks are being referenced for identification purposes only, in terms of a nominative fair use.

<details>
<summary>Project Status</summary>
<p>

| API | Current Status |
| ---: | --- |
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
</p>
</details>

<details>
<summary>Installation</summary>
<p>

The package is **not** yet published, else that would be:

    composer require syslogic/php-hms

In the meanwhile one still can manually check out into project directory `lib`:

````
mkdir lib
git clone git@github.com:syslogic/php-hms ./lib/php-hms
````

Then one can map namespace `HMS` in the `composer.json` PSR-4 `autoload` block:

````
"autoload": {
  "psr-4": {
    "App\\": "src/",
    "HMS\\": "lib/php-hms/src/"
  }
}
````

Running code coverage:
````
cd ./lib/php-hms
composer install
composer run-script test
````
</p>
</details>

<details>
<summary>Support</summary>
<p>

- [Stack Overflow](https://stackoverflow.com/questions/tagged/huawei-mobile-services)
- [Issue Tracker](https://github.com/syslogic/php-hms/issues)
</p>
</details>

<details>
<summary>License</summary>
<p>

The SDK for Huawei REST API is licensed under the [MIT License](LICENSE).
</p>
</details>

