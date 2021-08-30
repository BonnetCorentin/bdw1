1) SELECT * FROM Course; -- Selectionne toutes les courses

2) SELECT Nom FROM Course; -- Selectionne tous les nom de course

4) SELECT
    AVG(E1.nbParticipant) -- Selectionne le nombre moyen de particpants à une course
FROM
    Edition E1
JOIN Edition E2 ON
    E1.idC = E2.idC
JOIN Course C ON
    E1.idC = C.idC
WHERE
    C.nom = "Marathon De Paris";

5) SELECT
    E.annee,E.nbParticipant,E.adresseDepart,E.dateInscription,E.dateDepotCertificat,E.dateRecupDossard,E.url -- requete pour afficher les info relatives à une édition sur une course
FROM
    Edition E
JOIN Course C ON
    E.idC=C.idC
WHERE C.nom="'.$_POST["liste_course"].'";


6) SELECT -- requete pour trouver l'idA en fonction du login
    idA
FROM
    Utilisateur
WHERE pseudo='".$_SESSION["slogin"]."';


7) SELECT -- requete pour trouver le nom et prenom de l'adherent
    nom,prenom
FROM
    Adherent
WHERE ida = $idA;

8) SELECT  -- requete pour compter le nombre de course que l'adherent en question a parcouru
    COUNT(*)
FROM
    Resultat
WHERE nom='".$nom."' AND prenom ='".$prenom."';

9) SELECT -- requete donnant les informations relatives aux courses et editions parcouru par l'adherent
    E.Annee,Ty.distance,C.nom, MAX(Te.temps) AS temps
FROM
    Course C
NATURAL JOIN Edition E
NATURAL JOIN Epreuve Ep
NATURAL JOIN TypeEpreuve Ty
JOIN Resultat R
  ON R.idEdition = E.idEdition AND R.idE = Ep.idE
JOIN TempsPassage Te
  ON Te.idEdition = E.idEdition AND Te.idE = Ep.idE AND Te.dossard = R.dossard
WHERE R.nom= '".$nom."' AND R.prenom = '".$prenom."'
  GROUP BY R.dossard
  ORDER BY E.annee DESC, Ty.distance DESC,Te.temps;

10) SELECT -- requete pour selectionner l'idA de l'adherent en question
    idA
FROM Utilisateur
  WHERE pseudo = '".$_SESSION["slogin"]."';

11) INSERT INTO -- requete pour inserer un nouvel adherent en fonction des données rentrées
    Adherent (nom, prenom, date_naissance, sexe, adresse, date_validite_certificat, nom_club)
    VALUES ('".$_POST["nom"]."','".$_POST["prenom"]."','".$_POST["date"]."','".$_POST["sexe"]."','".$_POST["adresse"]."','".$_POST["date_certificat"]."','".$_POST["club"]."');

12) SELECT -- requete pour selectionner l'idA d'un adherent qui vient de se connecter
    idA
    FROM Adherent
    WHERE nom = '".$_POST["nom"]."' AND prenom = '".$_POST["prenom"]."';

13) UPDATE -- requete pour mettre à jour l'idA d'un utilisateur apres sa premiere connexion
  Utilisateur SET idA = $idA
  WHERE pseudo = '".$_SESSION["slogin"]."';

14) UPDATE -- requete pour mettre à jour les informations d'un adhérent
  Adherent
  SET nom = '".$_POST["nom"]."', prenom = '".$_POST["prenom"]."', date_naissance = '".$_POST["date"]."',
  sexe = '".$_POST["sexe"]."', adresse = '".$_POST["adresse"]."' , date_validite_certificat = '".$_POST["date_certificat"]."',
  nom_club = '".$_POST["club"]."'
  WHERE idA = '".$tableauu[1]["idA"]."';

15) SELECT  -- requete pour selectionner les informations d'un adherent identifie par son idA
    nom,prenom,date_naissance,sexe,adresse,date_validite_certificat,nom_club
    FROM Adherent
    WHERE idA = '".$ida."';

16) SELECT -- recupere les resultat pour une certaine course
    R.dossard,R.rang,R.nom,R.prenom,R.sexe, MAX(T.temps) AS temps
    FROM Resultat R
    NATURAL JOIN Edition E
    NATURAL JOIN Epreuve Ep
    NATURAL JOIN TypeEpreuve Ty
    JOIN TempsPassage T
    WHERE Ep.idE= $idEpreuve AND T.dossard = R.dossard
      AND R.rang IS NOT NULL
    GROUP BY R.prenom
    ORDER BY T.Temps ASC;

17) SELECT  -- recupere les noms de toutes les courses
    Nom
FROM
    Course

18) INSERT INTO Course(nom, anneeCreation, mois) -- insère une course
VALUES(
    "'.$_POST[" Nom "].'",
    "'.$_POST[" AnneeCreation "].'",
    "'.$_POST[" Mois "].'"
)

19) SELECT -- recupere l'idC d'une course en fonction d'une édition
    idC
FROM
    Course
WHERE
    nom = "'.$_POST[" valider_ajout_edition_cache "].'"

20) INSERT INTO Edition( -- insere une édition
    idC,
    annee,
    nbParticipant,
    adresseDepart,
    dateInscription,
    dateDepotCertificat,
    dateRecupDossard,
    url
)
VALUES(
    "'.$tableauRequete[1][0].'",
    "'.$_POST[" annee "].'",
    "'.$_POST[" nbParticipant "].'",
    "'.$_POST[" adresseDepart "].'",
    "'.$_POST[" dateInscription "].'",
    "'.$_POST[" dateDepotCertificat "].'",
    "'.$_POST[" dateRecupDossard "].'",
    "'.$_POST[" url "].'"
)

21) DELETE -- supprime une édition
FROM
    Edition
WHERE
    idEdition = "'.$_POST[" suppCache "].'"

22) DELETE --supprime une course
FROM
    Course
WHERE
    idC = "'.$_POST[" supCourseCache "].'"

23) SELECT -- recupere l'année de création et le mois d'une course
    anneeCreation,
    mois
FROM
    Course
WHERE
    nom = "'.$courseSelectionnee.'"

24) SELECT -- recupere le nombre moyen de participant d'une course
    AVG(E1.nbParticipant)
FROM
    Edition E1
JOIN Edition E2 ON
    E1.idC = E2.idC
JOIN Course C ON
    E1.idC = C.idC
WHERE
    C.nom = "'.$courseSelectionnee.'"

25) SELECT -- recupere les informations des éditions d'une course
    E.idEdition,
    E.annee,
    E.nbParticipant,
    E.adresseDepart,
    E.dateInscription,
    E.dateDepotCertificat,
    E.dateRecupDossard,
    E.url
FROM
    Edition E
JOIN Course C ON
    E.idC = C.idC
WHERE
    C.nom = "'.$courseSelectionnee.'"

26) SELECT DISTINCT -- recupere les idE des éditions en fonction d'une course groupé par idE
    idE
FROM
    Resultat
WHERE
    idEdition = "'.$value[" idEdition "].'"
ORDER BY
    idE

27) SELECT -- recupere le nombre total d’adhérents ayant couru l’édition d'une course groupé par idE
    COUNT(*) AS Nombre
FROM
    Adherent A
JOIN Resultat R ON
    A.prenom = R.prenom AND A.nom = R.nom
JOIN Edition E ON
    E.idEdition = R.idEdition
WHERE
    E.idEdition = "'.$value[" idEdition "].'"
GROUP BY
    R.idE

28) SELECT -- recupere le nombre total d'adhérents ayant couru l'édition en étant licencié à un club d'une course groupé par idE
    COUNT(*) AS Nombre
FROM
    Adherent A
JOIN Resultat R ON
    A.prenom = R.prenom AND A.nom = R.nom
JOIN Edition E ON
    E.idEdition = R.idEdition
WHERE
    E.idEdition = "'.$value[" idEdition "].'" AND A.nom_club IS NOT NULL
GROUP BY
    R.idE

29) SELECT -- recupere le nombe de club d'athlétisme représentés durant une édition d'une course
    COUNT(DISTINCT A.nom_club)
FROM
    Adherent A
JOIN Resultat R ON
    A.prenom = R.prenom AND A.nom = R.nom
WHERE
    R.idEdition = "'.$value["idEdition"].'"

30) SELECT -- recupere le temps de passage du vainqueur des éditions d'une course
    MIN(temps)
FROM
    TempsPassage
WHERE
    idEdition = '.$value["idEdition"].' AND idE = '.$tableau[(1,2,3)][0].' AND km = (41,21,10)

31) SELECT -- recupere le temps de passage du pire temps obtenu par un adhérent des éditions d'une course
    MAX(temps)
FROM
    TempsPassage
WHERE
    idEdition = '.$value["idEdition"].' AND idE = '.$tableau[(1,2,3)][0].' AND km = (41,21,10)

32) SELECT -- recupere le pire rang d'un adhérent des éditions d'une course
    MAX(rang)
FROM
    Resultat R
JOIN Adherent A ON
    A.prenom = R.prenom AND R.nom = A.nom
WHERE
    idEdition = '.$value["idEdition"].' AND idE = "'.$tableau[(1,2,3)][0].'"

33) SELECT -- recupere le meilleur rang d'un adhérent des éditions d'une course
    MIN(rang)
FROM
    Resultat R
JOIN Adherent A ON
    A.prenom = R.prenom AND R.nom = A.nom
WHERE
    idEdition = '.$value["idEdition"].' AND idE = "'.$tableau[(1,2,3)][0].'"

34) SELECT -- recupere la moyenne des temps réalisés par les adhérents de l'association
    AVG(T.temps)
FROM
    TempsPassage T
JOIN Resultat R ON
    R.dossard = T.dossard AND R.idEdition = T.idEdition AND R.idE = T.idE
JOIN Adherent A ON
    R.nom = A.nom AND R.prenom = A.prenom
WHERE
    R.idEdition = '.$value["idEdition"].' AND R.idE = '.$tableau[(1,2,3)][0].' AND T.km = (41,21,10)

35) SELECT DISTINCT -- recupere le nombre d'abandon fait par les adhérents de l'association
    COUNT(*)
FROM
    Resultat R
JOIN Adherent A ON
    A.nom = R.nom AND R.prenom = A.prenom
WHERE
    R.rang IS NULL AND R.idEdition = '.$value["idEdition"].' AND R.idE = "'.$tableau[(1,2,3)][0].'"

37) UPDATE -- modifie une édition d'une course
    Edition
SET
    annee = "'.$_POST[" annee "].'",
    nbParticipant = "'.$_POST[" nbParticipant "].'",
    adresseDepart = "'.$_POST[" adresseDepart "].'",
    dateInscription = "'.$_POST[" dateInscription "].'",
    dateDepotCertificat = "'.$_POST[" dateDepotCertificat "].'",
    dateRecupDossard = "'.$_POST[" dateRecupDossard "].'",
    url = "'.$_POST[" url "].'"

38) UPDATE -- modifie une course
    Course
SET
    anneeCreation = "'.$_POST[" anneeCreation "].'",
    mois = "'.$_POST[" mois "].'"

40) SELECT -- recupere le pseudo et le mot de passe des utilisateurs qui ne sont pas administrateur
    pseudo,
    mot_de_passe
FROM
    Utilisateur
WHERE
    role != "Administrateur"

41) DELETE -- supprime un utilisateur
FROM
    Utilisateur
WHERE
    pseudo = "'.$_POST[" supprimer_utilisateur_cache "].'"

42) UPDATE -- modifie un utilisateur
    Utilisateur
SET
    pseudo = "'.$_POST[" pseudo "].'",
    mot_de_passe = "'.$_POST[" mot_de_passe "].'"
WHERE
    pseudo = "'.$_POST[" valider_modification_utilisateur_cache "].'"

43) INSERT INTO Utilisateur(pseudo, mot_de_passe, role) -- ajoute un utlisateur
VALUES(
    "'.$_POST[" pseudo "].'",
    "'.$_POST[" mot_de_passe "].'",
    "adherent"
)

44) SELECT -- recupere toutes les informations sur les adhérents
    *
FROM
    Adherent

45) DELETE -- supprime un adhérent
FROM
    Adherent
WHERE
    idA = "'.$_POST[" supprimer_adherent "].'"

46) INSERT INTO Adherent( -- insere un adhérent
    nom,
    prenom,
    date_naissance,
    sexe,
    adresse,
    date_validite_certificat,
    nom_club
)
VALUES(
    '".$_POST["nom"]."',
    '".$_POST["prenom"]."',
    '".$_POST["date"]."',
    '".$_POST["sexe"]."',
    '".$_POST["adresse"]."',
    '".$_POST["date_certificat"]."',
    '".$_POST["club"]."'
)

47) UPDATE -- modife un adhérent
    Adherent
SET
    nom = "'.$_POST[" nom "].'",
    prenom = "'.$_POST[" prenom "].'",
    date_naissance = "'.$_POST[" DATE "].'",
    sexe = "'.$_POST[" sexe "].'",
    adresse = "'.$_POST[" adresse "].'",
    date_validite_certificat = "'.$_POST[" date_certificat "].'",
    nom_club = "'.$_POST[" club "].'"
WHERE
    idA = "'.$_POST[" valider_modifier_adherent_cache "].'"

48) SELECT -- recupere les informations sur un adhérent
    nom,
    prenom,
    date_naissance,
    sexe,
    adresse,
    date_validite_certificat,
    nom_club
FROM
    Adherent
WHERE
    idA = "'.$_POST[" modifier_cache "].'"
