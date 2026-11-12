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

        self::assertSame("Lyon", $this->pdo->query("SELECT ville FROM agence")->fetchColumn());
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

        $savedTrip = $this->pdo
            ->query("SELECT places_totales, places_disponibles FROM trajet WHERE id_trajet = 1")
            ->fetch(PDO::FETCH_ASSOC);
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

    /**
     * Vérifie que toutes les agences sont récupérées par ordre alphabétique.
     *
     * @return void
     */
    public function testGetAllAgencies(): void
    {
        $this->pdo->exec("
        INSERT INTO agence (ville) VALUES
        ('Marseille'),
        ('Lyon'),
        ('Bordeaux')
    ");

        $agencies = Agency::getAll();

        $this->assertCount(3, $agencies);
        $this->assertSame("Bordeaux", $agencies[0]["ville"]);
        $this->assertSame("Lyon", $agencies[1]["ville"]);
        $this->assertSame("Marseille", $agencies[2]["ville"]);
    }

    /**
     * Vérifie qu'une agence peut être retrouvée par son identifiant.
     *
     * @return void
     */
    public function testFindAgencyById(): void
    {
        $this->pdo->exec("
        INSERT INTO agence (ville)
        VALUES ('Lyon')
    ");

        $agency = Agency::findById(1);

        $this->assertIsArray($agency);
        $this->assertSame("Lyon", $agency["ville"]);
    }

    /**
     * Vérifie qu'une agence inexistante retourne false.
     *
     * @return void
     */
    public function testFindAgencyByIdReturnsFalseWhenNotFound(): void
    {
        $agency = Agency::findById(999);

        $this->assertFalse($agency);
    }

    /**
     * Vérifie que seuls les trajets de l'utilisateur demandé sont récupérés.
     *
     * @return void
     */
    public function testGetTripsByUser(): void
    {
        $this->pdo->exec("
        INSERT INTO agence (id_agence, ville)
        VALUES
            (1, 'Bordeaux'),
            (2, 'Lyon'),
            (3, 'Marseille')
        ");

        $this->pdo->exec("
        INSERT INTO trajet (
            date_heure_depart,
            date_heure_arrivee,
            places_totales,
            places_disponibles,
            id_utilisateur,
            id_agence_depart,
            id_agence_arrivee
        ) VALUES
        ('2026-12-01 08:00:00', '2026-12-01 09:00:00', 4, 3, 1, 1, 2),
        ('2026-12-02 08:00:00', '2026-12-02 09:00:00', 4, 2, 1, 2, 3),
        ('2026-12-03 08:00:00', '2026-12-03 09:00:00', 4, 4, 2, 1, 3)
    ");

        $trips = Trip::getTripsByUser(1);

        $this->assertCount(2, $trips);
        $this->assertSame(1, (int) $trips[0]["id_utilisateur"]);
        $this->assertSame(1, (int) $trips[1]["id_utilisateur"]);
    }

    /**
     * Vérifie qu'un trajet appartient bien à l'utilisateur indiqué.
     *
     * @return void
     */
    public function testTripBelongsToUser(): void
    {
        $this->pdo->exec("
        INSERT INTO trajet (
            date_heure_depart,
            date_heure_arrivee,
            places_totales,
            places_disponibles,
            id_utilisateur,
            id_agence_depart,
            id_agence_arrivee
        ) VALUES (
            '2026-12-01 08:00:00',
            '2026-12-01 09:00:00',
            4,
            3,
            1,
            1,
            2
        )
    ");

        $this->assertTrue(Trip::belongsToUser(1, 1));
    }

    /**
     * Vérifie qu'un trajet n'appartient pas à un autre utilisateur.
     *
     * @return void
     */
    public function testTripDoesNotBelongToAnotherUser(): void
    {
        $this->pdo->exec("
        INSERT INTO trajet (
            date_heure_depart,
            date_heure_arrivee,
            places_totales,
            places_disponibles,
            id_utilisateur,
            id_agence_depart,
            id_agence_arrivee
        ) VALUES (
            '2026-12-01 08:00:00',
            '2026-12-01 09:00:00',
            4,
            3,
            1,
            1,
            2
        )
    ");

        $this->assertFalse(Trip::belongsToUser(1, 2));
    }

    /**
     * Vérifie qu'une agence utilisée dans un trajet est identifiée.
     *
     * @return void
     */
    public function testIsAgencyUsed(): void
    {
        $this->pdo->exec("
        INSERT INTO trajet (
            date_heure_depart,
            date_heure_arrivee,
            places_totales,
            places_disponibles,
            id_utilisateur,
            id_agence_depart,
            id_agence_arrivee
        ) VALUES (
            '2026-12-01 08:00:00',
            '2026-12-01 09:00:00',
            4,
            3,
            1,
            1,
            2
        )
    ");

        $this->assertTrue(Trip::isAgencyUsed(1));
    }

    /**
     * Vérifie qu'une agence non utilisée est identifiée comme telle.
     *
     * @return void
     */
    public function testIsAgencyNotUsed(): void
    {
        $this->assertFalse(Trip::isAgencyUsed(999));
    }
    
/**
 * Vérifie que seuls les trajets futurs ayant des places disponibles sont récupérés.
 *
 * @return void
 */
public function testGetAvailableTrips(): void
{
    // Création des agences nécessaires aux jointures.
    $this->pdo->exec("
        INSERT INTO agence (id_agence, ville) VALUES
        (1, 'Bordeaux'),
        (2, 'Lyon')
    ");

    // Création du conducteur.
    $this->pdo->exec("
        CREATE TABLE utilisateur (
            id_utilisateur INTEGER PRIMARY KEY,
            prenom TEXT NOT NULL,
            nom TEXT NOT NULL,
            telephone TEXT NOT NULL,
            email TEXT NOT NULL
        )
    ");

    $this->pdo->exec("
        INSERT INTO utilisateur
        (id_utilisateur, prenom, nom, telephone, email)
        VALUES (1, 'Jean', 'Dupont', '0600000000', 'jean@test.fr')
    ");

    // Dates calculées dynamiquement.
    $tomorrow = date("Y-m-d H:i:s", strtotime("+1 day"));
    $yesterday = date("Y-m-d H:i:s", strtotime("-1 day"));

    // Préparation de l'insertion des trajets.
    $stmt = $this->pdo->prepare("
        INSERT INTO trajet (
            date_heure_depart,
            date_heure_arrivee,
            places_totales,
            places_disponibles,
            id_utilisateur,
            id_agence_depart,
            id_agence_arrivee
        ) VALUES (
            :depart,
            :arrivee,
            :total,
            :disponibles,
            :utilisateur,
            :agence_depart,
            :agence_arrivee
        )
    ");

    // Trajet futur avec des places disponibles.
    $stmt->execute([
        "depart" => $tomorrow,
        "arrivee" => $tomorrow,
        "total" => 4,
        "disponibles" => 3,
        "utilisateur" => 1,
        "agence_depart" => 1,
        "agence_arrivee" => 2,
    ]);

    // Trajet futur complet.
    $stmt->execute([
        "depart" => $tomorrow,
        "arrivee" => $tomorrow,
        "total" => 4,
        "disponibles" => 0,
        "utilisateur" => 1,
        "agence_depart" => 1,
        "agence_arrivee" => 2,
    ]);

    // Trajet passé avec des places disponibles.
    $stmt->execute([
        "depart" => $yesterday,
        "arrivee" => $yesterday,
        "total" => 4,
        "disponibles" => 2,
        "utilisateur" => 1,
        "agence_depart" => 1,
        "agence_arrivee" => 2,
    ]);

    // Récupération des trajets disponibles.
    $trips = Trip::getAvailableTrips();

    // Vérification du résultat.
    $this->assertCount(1, $trips);
    $this->assertSame($tomorrow, $trips[0]["date_heure_depart"]);
    $this->assertSame(3, (int) $trips[0]["places_disponibles"]);
}

}
