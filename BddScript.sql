DROP table if exists Produits;
DROP table if exists Personnes;
DROP table if exists Ventes;


CREATE table Produits(
    idProduit SERIAL,
    nomP Varchar(50),
    Quantite integer,
    prix float,
    primary key (idP)
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
    foreign key (idPer) references Personne(idPer)
);

CREATE table Personnes(
    idPer SERIAL,
    prenom Varchar(50),
    nom Varchar(50),
    mdp Varchar(50),
    RoleP Varchar(50),
    PRIMARY KEY (idPer)
);

INSERT INTO Personnes values (
    DEFAULT,
    "Amadou",
    "Dia",
    "MotDePasse",
    "Client"
);
INSERT INTO Personnes values (
    DEFAULT,
    "Mamadou",
    "Dia",
    "MotDePasse",
    "Admin"
);
INSERT INTO Personnes values (
    DEFAULT,
    "Ahmed",
    "Dia",
    "MotDePasse",
    "Membre"
);
INSERT INTO Produits values(
    DEFAULT,
    "Oreo",
    3,
    1.50
);



