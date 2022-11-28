<?php

declare(strict_types=1);

namespace App;

use \PDO;

/**
 * @mixin PDO
 */

class DB
{
    private \PDO $pdo;

    public function __construct(array $config) {

        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        //Подключение бд

        try {
            $this->pdo = new PDO(
                $config['driver'] . ":host=" . $config['host'] . ";db_name=" . $config['database'],
                $config["user"], $config["password"],
                $config["options"] ?? $defaultOptions
            );

        }
        catch (\PDOException $ex) {
            throw new \PDOException($ex->getMessage(), $ex->getCode());
        }
    }

    public function __call(string $name, array $arguments) {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }

}