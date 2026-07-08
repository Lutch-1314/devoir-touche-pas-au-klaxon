<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alnet\DevoirTouchePasAuKlaxon\Core\Database;

try {

    $pdo = Database::getConnection();

    echo "<h1>Connexion à la base de données réussie ! ✅</h1>";

} catch (Exception $e) {

    echo $e->getMessage();

}