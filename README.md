ZendOrdersApplication
=======================
[![Code Climate](https://codeclimate.com/github/mesaugat/zf2-orders/badges/gpa.svg)](https://codeclimate.com/github/mesaugat/zf2-orders)

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

    php composer.phar install

Configuration Files
-------------------
Make a copy of .example configuration files located at config/autoload directory and fill
in the required credentials if any.

    cp config/autoload/doctrine.local.php.example config/autoload/doctrine.local.php
    cp config/autoload/zdt.local.php.example config/autoload/zdt.local.php

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
