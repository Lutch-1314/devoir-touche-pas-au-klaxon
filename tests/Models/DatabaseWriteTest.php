<?php

namespace Tests\Models;

use App\Core\Database;
use App\Models\Agency;
use App\Models\Trip;
use PDO;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

/**
 * Vérifie les opérations d'écriture des modèles avec une base SQLite isolée.
 */
class DatabaseWriteTest extends TestCase
{
    private PDO $pdo;

    /**
     * Prépare le schéma SQLite et l'injecte dans la connexion de l'application.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->pdo = new PDO("sqlite::memory:");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec(
            "CREATE TABLE agence (
                id_agence INTEGER PRIMARY KEY AUTOINCREMENT,
                ville TEXT NOT NULL
            )",
        );
        $this->pdo->exec(
            "CREATE TABLE trajet (
                id_trajet INTEGER PRIMARY KEY AUTOINCREMENT,
                date_heure_depart TEXT NOT NULL,
                date_heure_arrivee TEXT NOT NULL,
                places_totales INTEGER NOT NULL,
                places_disponibles INTEGER NOT NULL,
                id_utilisateur INTEGER NOT NULL,
                id_agence_depart INTEGER NOT NULL,
                id_agence_arrivee INTEGER NOT NULL
            )",
        );

        $connection = new ReflectionProperty(Database::class, "pdo");
        $connection->setValue(null, $this->pdo);
    }

    /**
     * Vérifie qu'une agence est ajoutée en base.
     *
     * @return void
     */
    public function testAgencyCanBeCreated(): void
    {
        Agency::create(["ville" => "Lyon"]);

        self::assertSame(
            "Lyon",
            $this->pdo->query("SELECT ville FROM agence")->fetchColumn(),
        );
    }

    /**
     * Vérifie que les informations d'une agence sont mises à jour.
     *
     * @return void
     */
    public function testAgencyCanBeUpdated(): void
    {
        $this->pdo->exec("INSERT INTO agence (ville) VALUES ('Lyon')");

        Agency::update(["id_agence" => 1, "ville" => "Marseille"]);

        self::assertSame(
            "Marseille",
            $this->pdo->query("SELECT ville FROM agence WHERE id_agence = 1")->fetchColumn(),
        );
    }

    /**
     * Vérifie qu'une agence est supprimée de la base.
     *
     * @return void
     */
    public function testAgencyCanBeDeleted(): void
    {
        $this->pdo->exec("INSERT INTO agence (ville) VALUES ('Lyon')");

        Agency::delete(1);

        self::assertSame(0, (int) $this->pdo->query("SELECT COUNT(*) FROM agence")->fetchColumn());
    }

    /**
     * Vérifie qu'un trajet est créé avec ses données.
     *
     * @return void
     */
    public function testTripCanBeCreated(): void
    {
        self::assertTrue(Trip::create($this->tripData()));
        self::assertSame(
            "2027-01-01 08:00:00",
            $this->pdo->query("SELECT date_heure_depart FROM trajet")->fetchColumn(),
        );
    }

    /**
     * Vérifie que les informations d'un trajet sont mises à jour.
     *
     * @return void
     */
    public function testTripCanBeUpdated(): void
    {
        Trip::create($this->tripData());
        $trip = $this->tripData();
        $trip["id_trajet"] = 1;
        $trip["places_totales"] = 4;
        $trip["places_disponibles"] = 3;

        Trip::update($trip);

        $savedTrip = $this->pdo->query(
            "SELECT places_totales, places_disponibles FROM trajet WHERE id_trajet = 1",
        )->fetch(PDO::FETCH_ASSOC);
        self::assertSame(4, (int) $savedTrip["places_totales"]);
        self::assertSame(3, (int) $savedTrip["places_disponibles"]);
    }

    /**
     * Vérifie qu'un trajet est supprimé de la base.
     *
     * @return void
     */
    public function testTripCanBeDeleted(): void
    {
        Trip::create($this->tripData());

        Trip::delete(1);

        self::assertSame(0, (int) $this->pdo->query("SELECT COUNT(*) FROM trajet")->fetchColumn());
    }

    /**
     * Retourne les données minimales valides d'un trajet.
     *
     * @return array<string, int|string>
     */
    private function tripData(): array
    {
        return [
            "date_heure_depart" => "2027-01-01 08:00:00",
            "date_heure_arrivee" => "2027-01-01 10:00:00",
            "places_totales" => 3,
            "places_disponibles" => 3,
            "id_utilisateur" => 1,
            "id_agence_depart" => 1,
            "id_agence_arrivee" => 2,
        ];
    }
}
