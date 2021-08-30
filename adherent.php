<?php if (!isset ($_SESSION)); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.css"  media="all"/>
    <title>Association</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
    <h1>Profil adhérent</h1>
    <p>
      Bienvenue <?php print $_SESSION ["slogin"]; ?>

      <a href="./informations.php">Modifier mes informations personnelles </a>
    </p>
    <a href="./deconnexion.php">Déconnexion</a>
  </body>
</html>
