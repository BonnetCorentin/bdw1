<?php
  if (session_id()== "") session_start(); // regarde si une session est deja en cours
  require_once('connexionBD.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.css"  media="all"/>
    <title>Association</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
      <div class="container">
        <form class="was-validated" method ="post" action = "espacePerso.php">
          <div class="form-group">
            <select class="custom-select" name="menu" required>
              <option value="">Open this select menu</option>  <!-- Liste les différentes éditions de courses selon le type d'epreuve-->
              <?php
              $requete = 'SELECT E.annee, C.nom, Ty.typeEpreuve FROM Course C NATURAL JOIN Edition E NATURAL JOIN Epreuve Ep NATURAL JOIN TypeEpreuve Ty';
              // requête qui permet de récuperer les différentes éditions de courses selon le type d'épreuve
              $tableau = traiterRequete($requete);
              foreach ($tableau as $key => $value)// boucle qui permet de parcourir le tableau résultant de la requête
              {
                if ($key!=0)// si la ligne du tableau est différente de l'entête
                {
                  $affichage .= '<option value='.$key.'>'.$value["typeEpreuve"].' du '.$value["nom"].' '.$value["annee"].'</option>';
                }
              }
              print ($affichage);
              // affiche la liste des épreuves des éditions de toutes les courses
              ?>
            </select>
            <div class="invalid-feedback">Aucun menu selectionne</div>
          </div>
          <input class="btn btn-outline-secondary col-6 offset-3" type="submit" name="valider_voir_resultat" value ="Voir">
        </form>
        <!-- Formulaire qui permet de voir les résultats d'une épreuve d'une édition d'une course-->
<?php
  if (isset($_POST["valider_voir_resultat"])){ // si l'utilisateur veut voir les résultats d'une épreuve d'une édition d'une course
    $idEpreuve = $_POST["menu"];
    $requete =" SELECT R.dossard,R.rang,R.nom,R.prenom,R.sexe, MAX(T.temps) AS temps FROM Resultat R NATURAL JOIN Edition E NATURAL JOIN Epreuve Ep NATURAL JOIN TypeEpreuve Ty JOIN TempsPassage T WHERE Ep.idE= $idEpreuve AND T.dossard = R.dossard AND R.rang IS NOT NULL GROUP BY R.prenom ORDER BY T.Temps ASC"; // recupere les resultat pour une certaine course
    // requête qui permet de récuperer tous les résultats d'une épreuve d'une édition d'une course sélectionnée
    $tableau=traiterRequete($requete);
    foreach ($tableau as $key => $value) // boucle qui permet de parcourir le tableau résultant de la requête
    {
      if ($key!= 0){ // affiche dans $resultat le tableau comportant le classement ainsi que le temps
        $resultat='<table class="table table-bordered table-dark"><tr><td>Dossard</td><td>Rang</td><td>Nom</td><td>Prenom</td><td>Sexe</td><td>Temps (min)</td></tr>';
        $resultat.='<tr><td class="col-3">'.$value["dossard"].'</td><td class="col-3">'.$value["rang"].'</td><td class="col-3">'.$value["nom"].'</td><td class="col-3">'.$value["prenom"].'</td><td class="col-3">'.$value["sexe"].'</td><td>'.$value["temps"].'</td></tr></table>';
        print ($resultat);
        // affiche les résultats
      }
    }
  }
?>
  </div>
  </body>
</html>
