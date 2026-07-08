<?php

require '../vendor/autoload.php';

use App\Models\Trajet;

$trajets = Trajet::getTrajetsDisponibles();

echo "<pre>";
print_r($trajets);
echo "</pre>";