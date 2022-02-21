## PHP SDK for Huawei REST API

Legal Disclaimer: This product is **NOT** officially endorsed or certified by Huawei Technologies Co., Ltd.<br/>
The trademarks are being referenced for identification purposes only, in terms of a nominative fair use.

<details>
<summary>Project Status</summary>
<p>

[![PHP Composer](https://github.com/syslogic/php-hms/actions/workflows/ci-php.yml/badge.svg)](https://github.com/syslogic/php-hms/actions/workflows/ci-php.yml)

| Class | Status |
| ---: | --- |
| [`AccountKit`](https://github.com/syslogic/php-hms/blob/master/src/AccountKit)                | in progress |
| [`AdsKit`](https://github.com/syslogic/php-hms/blob/master/src/AdsKit)                        |             |
| [`AnalyticsKit`](https://github.com/syslogic/php-hms/blob/master/src/AnalyticsKit)            | in progress |
| [`AppGallery\Connect`](https://github.com/syslogic/php-hms/tree/master/src/AppGallery/Connect)| in progress |
| [`DriveKit`](https://github.com/syslogic/php-hms/tree/master/src/DriveKit)                    |             |
| [`GameService`](https://github.com/syslogic/php-hms/tree/master/src/GameService)              |             |
| [`LocationKit`](https://github.com/syslogic/php-hms/blob/master/src/LocationKit)              |             |
| [`MapKit`](https://github.com/syslogic/php-hms/blob/master/src/MapKit)                        |             |
| [`PushKit`](https://github.com/syslogic/php-hms/blob/master/src/PushKit)                      | working     |
| [`SearchKit`](https://github.com/syslogic/php-hms/blob/master/src/SearchKit)                  |             |
| [`WalletKit`](https://github.com/syslogic/php-hms/blob/master/src/WalletKit)                  |             |
| [`Core\Wrapper`](https://github.com/syslogic/php-hms/blob/master/src/Core)                    | working     |
</p>
</details>

### Prerequisites

This library depends on the following environmental variables:

#### PushKit API
- `HUAWEI_APP_ID`<br/>
  The "App ID" is being passed as the `client_id`.<br/>
- `HUAWEI_APP_SECRET`<br/>
  The "App Secret" is being passed as the `client_secret`. This value is not contained in `agconnect-services.json` and therefore must be provided. Please refer to the documentation, which explains how to obtain it: [Viewing App Basic Information](https://developer.huawei.com/consumer/en/doc/distribution/app/agc-help-appinfo-0000001100014694).
- `HUAWEI_APPLICATION_CREDENTIALS` (optional)<br/>
  The path to JSON configuration file `agconnect-services.json`.<br/>This file can be obtained from the AppGallery Connect console.<br/>

 - `HUAWEI_HMAC_VERIFICATION_KEY` (optional)<br/>
   The HMAC verification key is unique to each upstream message webhook. The value can also be obtained from there.

#### AppGallery Connect API:

 - `HUAWEI_CONNECT_API_CLIENT_ID`<br/>
    The client ID for the REST API client can be obtained on the [console](https://developer.huawei.com/consumer/en/service/josp/agc/index.html) <br/>below `Users and permissions` > `API key` > `Connect API`.
 
 - `HUAWEI_CONNECT_API_CLIENT_KEY`<br/>
   The client key for the REST API client can be obtained on the [console](https://developer.huawei.com/consumer/en/service/josp/agc/index.html) <br/>below `Users and permissions` > `API key` > `Connect API`.
 
<details>
<summary>Installation</summary>
<p>

One can manually check out into project directory `lib`:
````shell
mkdir lib
git clone git@github.com:syslogic/php-hms ./lib/php-hms
````

And then map namespace `HMS` in `composer.json` PSR-4 `autoload` block:
````json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/",
      "HMS\\": "lib/php-hms/src/"
    }
  }
}
````

To set up the environment, for example `nano ~/.bashrc`:

````bash
# PHP SDK for Huawei REST API
export HUAWEI_APP_ID=...
export HUAWEI_APP_SECRET=...
export HUAWEI_APPLICATION_CREDENTIALS=...
export HUAWEI_HMAC_VERIFICATION_KEY=...
````
</p>
</details>

<details>
<summary>PHPUnit Test Suite</summary>
<p>

The test suite depends on further environmental variables:

| Test Case | Environmental Variable | Description |
| ---: | --- | --- |
| `PushKitTest` | `PHPUNIT_HCM_TEST_DEVICE_TOKEN` | The HCM device registration ID, to which the test will push notifications to.  |

````bash
# PHP SDK for Huawei REST API
export PHPUNIT_HCM_TEST_HMAC_VERIFICATION_KEY=...
export PHPUNIT_HCM_TEST_DEVICE_TOKEN=...
````

Running tests:
````shell
composer run-script test
````

Running tests with code coverage:
````shell
composer run-script coverage
````

</details>

<details>
<summary>Usage</summary>
<p>
...
</p>
</details>


### Known Issues
When receiving an `Error 10021: Invalid clientId` this may suggest,<br/>that the API which one tries to access is not enabled for the project.<br/>
Enabling the desired API on [AppGallery Connect](https://developer.huawei.com/consumer/en/service/josp/agc/index.html) should help.

### License
The PHP SDK for Huawei REST API (the library) is licensed under the [MIT License](LICENSE).<br/>
The usage of these APIs depends on the [HUAWEI Developers Service Agreement](https://developer.huawei.com/consumer/en/doc/start/agreement-0000001052728169).

### Support
- [Documentation](https://developer.huawei.com/consumer/en/doc/landing/development)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/huawei-developers)
- [Issue Tracker](https://github.com/syslogic/php-hms/issues)
