<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 5/11/15
 * Time: 5:20 PM
 */

return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => array(
                    'host'     => '127.0.0.1',
                    'user'     => 'kabir',
                    'port'      => 5432,
                    'password' => 'kabir',
                    'dbname'   => 'zf2orders_testing',
                )
            )
        )
    ),
);