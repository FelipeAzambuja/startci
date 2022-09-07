![LOGO](https://newbgp.com.br/images/logo%20ci.svg)
# StartCI 4
    CodeIgniter with batteries included.
## What is StartCI?
StartCI is a fork of the CodeIgniter 4.1.5 framework, keeping all the features and adding new ones.
### Main differences

* Functions to speed up work with the database
* Model, seed and migration in a single file
* Library to facilitate communication in AJAX
* Workflow Integration with NuxtJS
* No need to configure for public folder

## ORM

Apenas criando um arquivo na pasta app\Models com **extends** de ORM você 
* No need to configure for public folder

## ORM

To use the ORM Model you must create a Class inside app\Models.
Document your table with fields
Create a function called seed to return the data to be inserted into the
bank only once
Define relationships with the __get magic method
See the example below
You can use the command ``` php spark orm create ModelName``` command to generate this file for you.

```
<?php

namespace App\Models;

/**
 * @property integer $id AutoIncrement
 * @property string $name
 * @property int $intvalue
 * @property string $created_at
 * @property string $updated_at
 * @table example
 */
class Example extends \CodeIgniter\ORM
{

    function seed()
    {
        return [
            [
                'name' => 'Example 1',
                'intvalue' => 1
            ],
            [
                'name' => 'Example 2',
                'intvalue' => 2
            ],
        ];
    }

    function __get($name)
    {
        switch ($name) {
            case '':
                return '';
                break;
        }
    }
}

```
rewrite ^/(.*)\.(gif|jpg|png|jpeg|css|js|swf|svg|woff2|ttf)$ /public/$1.$2 last;
rewrite ^/([\s\S]*)$ /index.php?/$1 last;

## Repository Management

CodeIgniter is developed completely on a volunteer basis. As such, please give up to 7 days
for your issues to be reviewed. If you haven't heard from one of the team in that time period,
feel free to leave a comment on the issue so that it gets brought back to our attention.

We use Github issues to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

If you raise an issue here that pertains to support or a feature request, it will
be closed! If you are not sure if you have found a bug, raise a thread on the forum first -
someone else may have encountered the same thing.

Before raising a new Github issue, please check that your bug hasn't already
been reported or fixed.

We use pull requests (PRs) for CONTRIBUTIONS to the repository.
We are looking for contributions that address one of the reported bugs or
approved work packages.

Do not use a PR as a form of feature request.
Unsolicited contributions will only be considered if they fit nicely
into the framework roadmap.
Remember that some components that were part of CodeIgniter 3 are being moved
to optional packages, with their own repository.

## Contributing

We **are** accepting contributions from the community!

We will try to manage the process somewhat, by adding a ["help wanted" label](https://github.com/codeigniter4/CodeIgniter4/labels/help%20wanted) to those that we are
specifically interested in at any point in time. Join the discussion for those issues and let us know
if you want to take the lead on one of them.

At this time, we are not looking for out-of-scope contributions, only those that would be considered part of our controlled evolution!

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the user guide.

## Server Requirements

PHP version 7.2 or higher is required, with the following extensions installed:


- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- xml (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)

## Running CodeIgniter Tests

Information on running the CodeIgniter test suite can be found in the [README.md](tests/README.md) file in the tests directory.
.........
# Logo made by Kubanek / Freepik
https://br.freepik.com/kubanek
