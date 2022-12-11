DROP table if exists Produits;
DROP table if exists Personnes;
DROP table if exists Ventes;
DROP table if exists Client;


CREATE table Produits(
    idProduit SERIAL,
    nomP Varchar(50),
    Quantite integer,
    prix float,
    primary key (idProduit)
);

CREATE table Ventes(
    numCommande SERIAL,
    DateV date,
    idPer integer references Personnes(idPer),
    prix float,
    primary key (numCommande)
);

CREATE table Client(
    idPer integer,
    pointF integer,
    foreign key (idPer) references Personnes(idPer)
);

CREATE table Personnes(
    idPer SERIAL,
    prenom Varchar(50),
    nom Varchar(50),
    mdp longText,
    RoleP Varchar(50),
    PRIMARY KEY (idPer)
);

INSERT INTO Personnes values (
    DEFAULT,
    "Amadou",
    "Dia",
    "$2y$10$XkvJ5T.e3IjKz4AT.KSyHOtTLDOmyoVuQvjLassst8ApoBWYaCbyy",
    "Client"
);
INSERT INTO Personnes values (
    DEFAULT,
    "Mamadou",
    "Dia",
    "$2y$10$XkvJ5T.e3IjKz4AT.KSyHOtTLDOmyoVuQvjLassst8ApoBWYaCbyy",
    "Admin"
);
INSERT INTO Personnes values (
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
    1.50
);



