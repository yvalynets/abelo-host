<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    private static ?PDO $pdo = null;

    /**
     * @param array{
     *     host:string,
     *     port:int,
     *     name:string,
     *     user:string,
     *     pass:string,
     *     charset:string
     * } $config
     */
    public static function connect(array $config): PDO
    {
        if (self::$pdo === null) {
            $dsn = 'mysql:' . implode(';', [
                    'host=' . $config['host'],
                    'port=' . $config['port'],
                    'dbname=' . $config['name'],
                    'charset=' . $config['charset'],
                ]);

            self::$pdo = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        return self::$pdo;
    }
}
