CREATE TABLE Course (

  idC INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR (100),
  anneeCreation INT,
  mois VARCHAR(100)
);

CREATE TABLE Edition (

  idEdition INT PRIMARY KEY AUTO_INCREMENT,
  idC INT NOT NULL,
  FOREIGN KEY (idC) REFERENCES Course(idC)
    ON DELETE CASCADE,
  annee INT,
  nbParticipant INT,
  adresseDepart VARCHAR (255),
  dateInscription VARCHAR (100),
  dateDepotCertificat VARCHAR(255),
  dateRecupDossard VARCHAR (255),
  url VARCHAR (255)
);

CREATE TABLE TypeEpreuve (

  idTypeE INT PRIMARY KEY AUTO_INCREMENT,
  typeEpreuve VARCHAR (100),
  distance INT
);

CREATE TABLE Epreuve(

  idE INT PRIMARY KEY AUTO_INCREMENT,
  idTypeE INT,
  FOREIGN KEY (idTypeE) REFERENCES TypeEpreuve(idTypeE),
  denivele INT,
  idEdition INT,
  FOREIGN KEY (idEdition) REFERENCES Edition (idEdition)
    ON DELETE CASCADE
);

CREATE TABLE Tarifs(
  age INT,
  tarif INT,
  idE INT,
  FOREIGN KEY (idE) REFERENCES Edition(idEdition),
  idTypeE INT,
  FOREIGN KEY (idTypeE) REFERENCES TypeEpreuve(idTypeE)
);

CREATE TABLE Resultat(

  dossard INT,
  rang INT,
  nom VARCHAR (100),
  prenom VARCHAR (100),
  sexe VARCHAR (100),
  idEdition INT,
  FOREIGN KEY (idEdition) REFERENCES Edition(idEdition)
    ON DELETE CASCADE,
  idE INT,
  FOREIGN KEY (idE) REFERENCES Epreuve(idE)
    ON DELETE CASCADE
);

CREATE TABLE TempsPassage (


  FOREIGN KEY (idEdition) REFERENCES Edition(idEdition)
    ON DELETE CASCADE,
  dossard INT,
  km INT,
  temps FLOAT,
  idEdition INT,
  idE INT,
  FOREIGN KEY (idE) REFERENCES Epreuve(idE)
    ON DELETE CASCADE
);

CREATE TABLE Adherent (

  idA INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR (100),
  prenom VARCHAR (100),
  date_naissance VARCHAR(100),
  sexe VARCHAR (100),
  adresse VARCHAR (100),
  date_validite_certificat VARCHAR (100),
  nom_club VARCHAR (100)

);

CREATE TABLE Utilisateur(
  pseudo VARCHAR(100) PRIMARY KEY,
  mot_de_passe VARCHAR(100),
  role VARCHAR(100),
  idA INT,
  FOREIGN KEY (idA) REFERENCES Adherent(idA)

);
