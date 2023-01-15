DROP table if exists Produits;
DROP table if exists Promo;
DROP table if exists Utilisateur;
DROP table if exists Ventes;


/* Remplacer les serial par des int (juste pour le test)*/

CREATE table Produits(
    idProduit SERIAL,
    nomP Varchar(50),
    Quantite integer,
    prix float,
    image varchar(255),
    primary key (idProduit)
);
SELECT "Produits";
CREATE table Utilisateur(
        idU SERIAL,
        prenom Varchar(50),
        nom Varchar(50),
        mdp varchar(255),
        RoleP Varchar(50),
        PRIMARY KEY (idU)
);

CREATE table Ventes(
    numCommande SERIAL,
    DateV date,
    idU integer references Utilisateur(idU),
    prix float,
    qte int,
    primary key (numCommande)
);

SELECT "ventes";
CREATE table Promo(
    idU SERIAL,
    pointF integer,
    foreign key (idU) references Utilisateur(idU)
);
SELECT "Promo";


INSERT INTO Utilisateur values (
    DEFAULT,
    "Amadou",
    "Dia",
    "$2y$10$XkvJ5T.e3IjKz4AT.KSyHOtTLDOmyoVuQvjLassst8ApoBWYaCbyy",
    "Client"
);
INSERT INTO Utilisateur values (
    DEFAULT,
    "Mamadou",
    "Dia",
    "$2y$10$XkvJ5T.e3IjKz4AT.KSyHOtTLDOmyoVuQvjLassst8ApoBWYaCbyy",
    "Admin"
);
INSERT INTO Utilisateur values (
    DEFAULT,
    "Ahmed",
    "Dia",
    "$2y$10$XkvJ5T.e3IjKz4AT.KSyHOtTLDOmyoVuQvjLassst8ApoBWYaCbyy",
    "Membre"
);
INSERT INTO Produits values(
    DEFAULT,
    "Oreo",
    3,
    1.50,
    "chem"
);



