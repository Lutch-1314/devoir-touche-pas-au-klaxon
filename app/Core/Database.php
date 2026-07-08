<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Gère la connexion à la base de données.
 */
class Database
{
    /**
     * Instance PDO.
     *
     * @var PDO|null
     */
    private static ?PDO $pdo = null;

    /**
     * Retourne une connexion PDO unique.
     *
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {

            $config = require __DIR__ . '/../../config/config.php';

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['dbname'],
                $config['charset']
            );

            try {

                self::$pdo = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );

            } catch (PDOException $e) {

                die('Erreur de connexion : ' . $e->getMessage());

            }
        }

        return self::$pdo;
    }
}