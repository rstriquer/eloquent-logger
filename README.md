# Eloquent Logger

A package to allow logging of all SQL queries executed by an application built
in Laravel by the eloquent ORM component.

This package builds a Laravel provider inside "vendors" folder which attaches a
listener to the Eloquent Console Manager that writes ane query to a log output.

As the package is in vendors and installed in the dev, the developer does not
need to worry about adding or removing codes from providers, as recommended in
some pages on the internet, thus facilitating his day-to-day bases;

**IMPORTANT**:

-   This module is not recommended for production use. It was built only for
    DEVELOPMENT environment;
-   Considering the package writes all queries, it is recommended to keep it
    turned off, even in a development environment, and turn it on only when
    performing query improvement work since it may consume a considerable
    amount of size on HDD when running uninterruptedly;
-   In very extreme and specific cases, where you are writing very (very) large
    contents (such as longtext fields or similar) it is possible that there are
    situations in which the plugin results in recording failures, depending on
    the limitations of your operating system (in old windows versions depending
    on FAT32 it may limit the size of the output file to less then 4gb);
-   By and large at the end the log file is not that big but there is no
    logrotate functionality set therefore I recommend you monitor the log file
    size and delete it whenever necessary;

## Minimum Requirements

This plugin was built when using Laravel version 8.0 and should work properly
with any Laravel version after 8.

If you have the opportunity to successfully use this plugin in a previous
laravel release please consider opening an
[issue](https://github.com/rstriquer/eloquent-logger/issues)
to report your experience.

If you have any problems with this plugin please report it by following the
steps on "Contributing" below.

## How to install

Just run the following:

```bash
composer require rstriquer/eloquent-logger --dev
```

If you want you can personalize the log filename by setting the environment
variable `DB_LOGGER_FILE`. It works with `.end` file and the file must be
placed at storage directory.

## how to use the plugin

Just set the environment variable `DB_LOGGER_ACTIVE` to true in your
`.env` file and run the application. The file set on `DB_LOGGER_FILE`
variable (which defaults to '/logs/query.log' located at the storage directory
at your application root folder) should contain all the queries performed by
that run sequentially.

To restrict the log file to the lasting 10 lines you can run the following
sequence of commands:

```bash
tail -n 10 storage/logs/query.log > storage/logs/query.tmp && \
    cat storage/logs/query.tmp > storage/logs/query.log && \
    rm storage/logs/query.tmp
```

## Contributing

The code is located in the Git repository at
[github](https://github.com/rstriquer/eloquent-logger). Contributions are most
welcome by forking the repository and sending a pull request.

Discussions are done on
[GitHub issue tracker](https://github.com/rstriquer/eloquent-logger/issues)

Always remember to check on lint and types before post code:

```bash
composer run test:lint
composer run test:types
```

PS: If necessary to fix lint you can just run `composer run lint` a couple of
times till it passes green and it will fix itself automatically.

To test a specific change you may configure your composer.json file in your
project like [described
here](https://gist.github.com/rstriquer/541cf089ce51d3bcb9125af50ff68160)

## How to unit-test

This package make use of in memory sqlite to test its feature therefore be sure
to have ext-sqlite installed on your system before running tests.

```bash
composer run test:unit
```

## Code of Conduct

We follow and support the Laravel Code of Conduct and in order to ensure that
the Laravel community is welcoming to all, please review and abide by the
[Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Authors and License

This is an open source project by
[@rstriquer](https://rstriquer.github.io/portfolio/)
and licensed under
[MIT](https://github.com/rstriquer/eloquent-logger/blob/main/LICENSE)
license.

rstriquer reserves the right to change the license in future releases without
prior notification, but understand and agree that versions until such time
remain under the MIT license as here described.
