### Unofficial SDK for Huawei REST API

#### Project Status:

This project is still in an early pre-alpha stage...

so far [`PushKit`](https://github.com/syslogic/php-hms/blob/master/src/PushKit) and [`Connect`](https://github.com/syslogic/php-hms/tree/master/src/Connect) API are being partially supported.

#### Installation:

The package is **not** yet available on Packagist. Once it is, that would be:

    composer require syslogic/php-hms

One still can map `namespace HMS` locally, eg. when checking out into directory `lib`:

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
