<?php

namespace services\db;

use Exception;
use mysqli;
use PDO;

class MYSQLConnection implements DBConnection
{
    const KEY_HOST = 'host';
    const KEY_USER = 'user';
    const KEY_PASSWORD = 'password';
    const KEY_DATABASE = 'database';

    protected $connection;

    public function __construct(array $params)
    {
        $this->connection = $this->create($params);
    }

    public function query($params)
    {
        // TODO: Implement query() method.
    }

    public function get(): PDO
    {
        return $this->connection;
    }

    function create($params)
    {
        $host = $params[self::KEY_HOST] ?? null;
        $user = $params[self::KEY_USER] ?? null;
        $password = $params[self::KEY_PASSWORD] ?? null;
        $dbName = $params[self::KEY_DATABASE] ?? null;
        if (in_array(null, [$host, $user, $password, $dbName])) {
            throw new Exception('Database connection failed. Wrong params used.');
        }

        try {
            $connection = new PDO(
                sprintf('mysql:dbname=%s;host=%s', $dbName, $host),
                $user,
                $password
            );

        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }

      /*  $connection = new mysqli($host, $user, $password, $dbName);
        if ($connection->connect_error) {
            throw new Exception('Database connection failed.');
        }*/

        return $connection;
    }
}