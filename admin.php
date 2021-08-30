<?php require_once('connexionBD.php');
  $requete = "SELECT * FROM Course;";
  $tableauRequete = traiterRequete ($requete);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all"/>
    <title>Association</title>
  </head>
  <body>
    <h1>Profil administrateur</h1>
    <p>
      Bienvenue <?php print $_SESSION ["slogin"];
                      print $tableauRequete [1][O];
                ?>
    </p>
    <a href="./deconnexion.php">Déconnexion</a>
  </body>
</html>
