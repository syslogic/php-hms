## PHP SDK for Huawei REST API

Legal Disclaimer: This product is **NOT** officially endorsed or certified by Huawei Technologies Co., Ltd.<br/>
The trademarks are being referenced for identification purposes only, in terms of a nominative fair use.

The official Huawei repositories can be found there: [@HMS-Core](https://github.com/orgs/HMS-Core/repositories).

### Goal

This project aims to abstract Huawei REST API, according to the official API documentation.

### Project Status

|                                                                                                Class |                                     Status                                      |
|-----------------------------------------------------------------------------------------------------:|:-------------------------------------------------------------------------------:|
|                           [`Core\Wrapper`](https://github.com/syslogic/php-hms/blob/master/src/Core) |                                     working                                     |
|                       [`AccountKit`](https://github.com/syslogic/php-hms/blob/master/src/AccountKit) |                                     working                                     |
|                             [`PushKit`](https://github.com/syslogic/php-hms/blob/master/src/PushKit) |                                     working                                     |
|                               [`MapKit`](https://github.com/syslogic/php-hms/blob/master/src/MapKit) |                                    partially                                    |
|                     [`LocationKit`](https://github.com/syslogic/php-hms/blob/master/src/LocationKit) |                                  inapplicable                                   |
|                               [`AdsKit`](https://github.com/syslogic/php-hms/blob/master/src/AdsKit) |                                                                                 |
|                   [`AnalyticsKit`](https://github.com/syslogic/php-hms/blob/master/src/AnalyticsKit) |                                                                                 |
|       [`AppGallery\Connect`](https://github.com/syslogic/php-hms/tree/master/src/AppGallery/Connect) |                                                                                 |
| [`AppGallery\Publishing`](https://github.com/syslogic/php-hms/tree/master/src/AppGallery/Publishing) | [Gradle plugin](https://github.com/syslogic/agconnect-publishing-gradle-plugin) |
|                           [`DriveKit`](https://github.com/syslogic/php-hms/tree/master/src/DriveKit) |                                                                                 |
|                     [`GameService`](https://github.com/syslogic/php-hms/tree/master/src/GameService) |                                                                                 |
|                         [`SearchKit`](https://github.com/syslogic/php-hms/blob/master/src/SearchKit) |                                                                                 |
|                         [`WalletKit`](https://github.com/syslogic/php-hms/blob/master/src/WalletKit) |                                                                                 |

[![PHP Composer](https://github.com/syslogic/php-hms/actions/workflows/ci-php.yml/badge.svg)](https://github.com/syslogic/php-hms/actions/workflows/ci-php.yml)

### Prerequisites

This library depends on the following environmental variables:

#### AppGallery Connect API:

- `HUAWEI_CONNECT_API_CLIENT_ID`<br/>
  The client ID can be obtained on the [console](https://developer.huawei.com/consumer/en/service/josp/agc/index.html) <br/>below `Users and permissions` > `API key` > `Connect API`.

- `HUAWEI_CONNECT_API_CLIENT_SECRET`<br/>
  The client key can be obtained on the [console](https://developer.huawei.com/consumer/en/service/josp/agc/index.html) <br/>below `Users and permissions` > `API key` > `Connect API`.

When creating the API client, project should be set to value "N/A".

#### MapKit API:

- `HUAWEI_MAPKIT_API_KEY`<br/>

- `HUAWEI_MAPKIT_SIGNATURE_KEY`<br/>

#### PushKit API Client
- `HUAWEI_OAUTH2_CLIENT_ID` The "App ID" is being passed as the Oauth2 `client_id`.
- `HUAWEI_OAUTH2_CLIENT_SECRET` The "App Secret" is being passed as the Oauth2 `client_secret`.

Please refer to the documentation, which explains how to obtain these values: <br/>[Viewing App Basic Information](https://developer.huawei.com/consumer/en/doc/distribution/app/agc-help-appinfo-0000001100014694).

#### PushKit API Server

 - `HUAWEI_HMAC_VERIFICATION_KEY` (optional)<br/>
   The HMAC verification key is unique to each upstream message webhook. <br/>The value can be obtained from each such webhook configuration form.

#### AnalyticsKit API:

- `HUAWEI_CONNECT_PRODUCT_ID`  

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
export HUAWEI_OAUTH2_CLIENT_ID=...
export HUAWEI_OAUTH2_CLIENT_SECRET=...
export HUAWEI_CONNECT_API_CLIENT_ID=...
export HUAWEI_CONNECT_API_CLIENT_SECRET=...
export HUAWEI_CONNECT_PRODUCT_ID=...
export HUAWEI_HMAC_VERIFICATION_KEY=...
export HUAWEI_MAPKIT_API_KEY=...
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
Enabling the desired API on the [AppGallery Connect](https://developer.huawei.com/consumer/en/service/josp/agc/index.html) console should help.

### License
The PHP SDK for Huawei REST API (the library) is licensed under the [MIT License](LICENSE).<br/>
The usage of these APIs depends on the [HUAWEI Developers Service Agreement](https://developer.huawei.com/consumer/en/doc/start/agreement-0000001052728169).

### Support
- [Documentation](https://developer.huawei.com/consumer/en/doc/landing/development)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/huawei-developers)
- [Issue Tracker](https://github.com/syslogic/php-hms/issues)
