USE touche_pas_au_klaxon;

INSERT INTO utilisateur
(nom, prenom, telephone, email, mot_de_passe, `admin`) 

/* Pour l'insertion des données, on stocke un mot de passe en clair temporaire, mais il sera hashé plus tard dans l'application PHP. */
/* On nomme Martin Alexandre comme administrateur */
 
VALUES
('Martin','Alexandre','0612345678','alexandre.martin@email.fr','$2y$12$sm5sLWgsHSvLlKVBcF5lpOYkkSJXgdqbjG.lT.kCjLiQzdoS4K0oG',1),
('Dubois','Sophie','0698765432','sophie.dubois@email.fr','$2y$12$nzNF/tGTPV6c/5WYXVGds.RaVARO7P4TghvbOfacoF8hBy8QkOeAa',0),
('Bernard','Julien','0622446688','julien.bernard@email.fr','$2y$12$ZveJGR82feErd1K85v5PgOzD.DlvIhUGbPhe8LhKNLxzAjkNWlLOi',0),
('Moreau','Camille','0611223344','camille.moreau@email.fr','$2y$12$QLrOkSjTfm21zbLRJflNNuF4SRzzZsarNEDg/ONOmjwhClTnoZ1nq',0),
('Lefèvre','Lucie','0777889900','lucie.lefevre@email.fr','$2y$12$6qfdj5SZDmFM5PYRIXSZI.klhmbGenRvkqIsUR7wgyeXfQ5SLdm46',0),
('Leroy','Thomas','0655443322','thomas.leroy@email.fr','$2y$12$/bt7wLde23fJMtrj2.n0uOM3iFZeRK0SRPxJmPP7XdZ3RY9DzAe1u',0),
('Roux','Chloé','0633221199','chloe.roux@email.fr','$2y$12$a/utGFFv4LdD9rmqRDYZk.XpjeG4Pk9D3e46xFHvWBAuPfRmg5qhe',0),
('Petit','Maxime','0766778899','maxime.petit@email.fr','$2y$12$3.7Pqf9plGQ19nuB/oQ0/OGj6PcJsOxOq/YiPFjmyQel.mRoVltge',0),
('Garnier','Laura','0688776655','laura.garnier@email.fr','$2y$12$4X5C/2ribl/QIXk5IwM6QuS0w6w.dCTJJ5J.br3xo/baSsuVw6bke',0),
('Dupuis','Antoine','0744556677','antoine.dupuis@email.fr','$2y$12$Vnzn.2XBQ/GKki45cvtLaeNnIS83jAwusN6jZ5fSpU.ISI87Ra2Gu',0),
('Lefebvre','Emma','0699887766','emma.lefebvre@email.fr','$2y$12$s6vEL2TOeqDaHDqF4RIjS.Hl7bWdYljRvuCq0BwTjh9UDbgylheUW',0),
('Fontaine','Louis','0655667788','louis.fontaine@email.fr','$2y$12$5eGSANFqcslIaDvJYPPZwuzTQ/XCxe7zSWUne6DomVgPii2k0DSmm',0),
('Chevalier','Clara','0788990011','clara.chevalier@email.fr','$2y$12$ZYhhHKeMDSiPc14GzeC./utTwyG0jvTdDC1gThrPhWpKT39aXj1Uq',0),
('Robin','Nicolas','0644332211','nicolas.robin@email.fr','$2y$12$7c4.lCxTZ517gNZ6vmURaOXFlQJ/4KKLUUZPBeOpmLEiLVSr2cPkC',0),
('Gauthier','Marine','0677889922','marine.gauthier@email.fr','$2y$12$QcPvNVS5oKJ7AghAX/i00e.xDulyqVaPiTh4o22NbXJusX8v/J1Im',0),
('Fournier','Pierre','0722334455','pierre.fournier@email.fr','$2y$12$NxgK4bodk..Do/Jl22ir5uSoRhQJ6BKiSqpy7b/Y4jA/KtFYraRty',0),
('Girard','Sarah','0688665544','sarah.girard@email.fr','$2y$12$YiLHDng46IsyiQrh5ZRKGe2jDT/JFdecycGN1CShCvMakkQ3aNSqq',0),
('Lambert','Hugo','0611223366','hugo.lambert@email.fr','$2y$12$nnp9l/6ol1aUC2fPKqPdNulv5yHIXPFo57bx1B0CAFQ./s3SmXly2',0),
('Masson','Julie','0733445566','julie.masson@email.fr','$2y$12$Jv5ChQIhx1E2.tAqwk85vui6avu0jrZGtw2c2cBGaJKfN6OAwTj.Kc',0),
('Henry','Arthur','0666554433','arthur.henry@email.fr','$2y$12$kQaAVa6l/venw08p4GUV/uNq2eTAt69/NibYmrlnGHJhm8QcnL5qK',0);

INSERT INTO agence
(ville)
VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Toulouse'),
('Nice'),
('Nantes'),
('Strasbourg'),
('Montpellier'),
('Bordeaux'),
('Lille'),
('Rennes'),
('Reims');

/* Des trajets fictifs sont insérés afin de tester le bon fonctionnement de l'application */

INSERT INTO trajet
(date_heure_depart, date_heure_arrivee, places_totales, places_disponibles, id_utilisateur, id_agence_depart, id_agence_arrivee)
VALUES
('2026-10-18 08:00:00','2026-10-18 15:00:00',4,3,2,1,2),
('2026-12-15 08:00:00','2026-12-15 14:00:00',5,3,5,4,3),
('2026-12-20 10:00:00','2026-12-20 13:00:00',5,2,8,10,12),
('2026-12-23 09:30:00','2026-12-23 15:30:00',4,0,3,7,10),
('2026-12-29 09:00:00','2026-12-29 15:00:00',4,1,12,2,3);
