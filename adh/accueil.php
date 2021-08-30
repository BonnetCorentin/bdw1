<?php
  if (session_id()== "") session_start();
?> <!--Regarde si une sessions est déjà ouverte -->
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href= "<?php if (isset ($tableau[1])) print "css/bootstrap/bootstrap.css"; else print "../css/bootstrap/bootstrap.css"; ?>"  media="all"/>
    <title>La Grammondsion</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
    <div class=container>
      <h1 class="display-1 text-center">Profil adhérent  </h1>
        <p class ="display-3 text-center">
          Bienvenue <?php print $_SESSION ["slogin"]; ?>  <!--Affiche le pseudo du profil en titre -->
      </p>
    <div class="card text-white bg-secondary mb-3 mx-auto" style="max-width: 18rem;">
      <div class="card-header">Présentation</div>
        <div class="card-body">
          <h5 class="card-title">Introduction</h5>
          <p class="card-text">Vous vous trouvez actuellemet dans l'accueil de la page adhérent.
            Vous pouvez soit selectionner l'un des différents menus, soit vous déconnecter.</p>
        </div>
    </div>
    <form method="post" >
      <a class = "btn btn-outline-primary col-6 offset-3" name="fiche" href= "./adh/fiche.php"> Modifier mes informations personnelles </a></br>  <!-- Envoie sur le fichier fiche.php pour modifier ses informations -->
    </form>
    <a class="btn btn-dark btn-outline-light col-6 offset-3" href="./adh/courses.php" role="button">Visualiser les édition de course auxquelles vous avez participé</a></br> <!-- Envoi sur courses.php afin de visualiser les courses réalisé par l'adhérent-->
    <a class="btn btn-dark btn-outline-light col-6 offset-3" href="./adh/course.php" role="button">Visualiser les informations relatives à une course ou à une édition</a></br> <!--Envoi sur course.php afin de visualiser les différentes courses et éditions -->
    <a class="btn btn-dark btn-outline-light col-6 offset-3" href="./adh/resultat.php" role="button">Visualiser les temps de parcours d’une édition de course donnée.</a></br> <!-- Envoi sur resultat.php afin de visualiser les différents temps de chaque course-->
    <a class="btn btn-outline-warning col-6 offset-3" href="./deconnexion.php">Déconnexion</a> <!--Permet la déconnexion -->
    </div>
  </body>
</html>
