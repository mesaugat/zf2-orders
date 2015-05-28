ZendOrdersApplication
=======================

[![Code Climate](https://codeclimate.com/github/mesaugat/zf2-orders/badges/gpa.svg)](https://codeclimate.com/github/mesaugat/zf2-orders)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9487a85f-d66b-4ba5-9538-8b3fcf1c4c22/mini.png)](https://insight.sensiolabs.com/projects/9487a85f-d66b-4ba5-9538-8b3fcf1c4c22)

Introduction
------------
This is a simple, orders application using the ZF2 MVC layer and module
systems.

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies from the root of the directory:

    composer install

Configuration Files
-------------------

First create an empty database in Postgresql.

Make a copy of .example configuration files located at config/autoload directory and fill
in the required credentials if any.

    cp config/autoload/doctrine.local.php.example config/autoload/doctrine.local.php
    cp config/autoload/zdt.local.php.example config/autoload/zdt.local.php

Import Default users & roles
--------------------
Run this command to sync the database with entities

    vendor/bin/doctrine-module orm:schema-tool:update --force

Import default users and roles for ACL from the Postgresql dump file.

    psql -U <username> -d <db name> -a -f data/userroles.sql

Web Server Setup
----------------

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-orders.localhost
        DocumentRoot /path/to/zf2-orders/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/zf2-orders/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

If you are using apache make a copy of `public/.htaccess.example` as `.htaccess`

Tests
------------

### Configuration Files

Create a separate database for testing purpose.

Make a copy of .example configuration files located at:

	cp config/autoload/doctrine.testing.php.example config/autoload/doctrine.testing.php
	cp tests/codeception.yml.example tests/codeception.yml

Fill in the required credentials for the test database. 

Once again run these to sync up the test db with entities

    tests/doctrine-module orm:schema-tool:update --force

Keep in mind that we're execuring `tests/doctrine-module` here not `vendor/bin/doctrine-module`.

Import default users & roles into test database

    psql -U <username> -d <test db> -a -f data/userroles.sql
    

### Running Tests

From the root of the directory `vendor/bin/codecept run`. For further information on running specific tests look at [Codeception docs](http://codeception.com/docs/02-GettingStarted).



Single Page Application with AngularJS
------------
Following programs should be present

	node
	npm
	
Bower is used for package management and Gulp is used for automating tasks.

Install bower and gulp globally

	npm install -g bower
	npm install -g gulp

To build the front end app

	project-dir/frontend: gulp build
	
