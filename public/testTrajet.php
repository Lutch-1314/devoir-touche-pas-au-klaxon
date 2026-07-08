<?php

require '../vendor/autoload.php';

use Alnet\DevoirTouchePasAuKlaxon\Models\Trajet;

$trajets = Trajet::getTrajetsDisponibles();

echo "<pre>";
print_r($trajets);
echo "</pre>";