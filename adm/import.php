<?php
  header ('content-type: text/html; charset=utf-8');
  if (!isset ($_SESSION)) // si une session n'est pas en cours en démarrer une
  session_start ();
  if (isset ($_POST["valider_import"])){ // si l'utilisateur a importer un fichier
    if (isset($_FILES["fichier"])){ // si le fichier est bien importé
      if ($_FILES['fichier']['error'] > 0) $erreur = "Erreur lors du transfert";
      $tableauRequete=file ($_FILES["fichier"]["tmp_name"]); // crée un tableau avec une ligne de fichier par case du fichier
      $affichage='';
      foreach ($tableauRequete as $key => $value) { // boucle qui parcourt le tableau contenant le fichier
        $affichage.=$value; // crée la requête à partir des cases du tableau
      }
      modifierLaTable ($affichage);
    }
  }
?>
<div class="offset-5 col-3">
<form method="post" action="espacePerso.php" enctype="multipart/form-data" >
  <input type="file" accept =".sql" name="fichier" required></br>
</div>
  <input type="submit" class = "col-3 offset-5 btn btn-outline-light"name="valider_import" class = "btn btn-outline-danger col-3" value="Valider importation">
</form>
<!-- formulaire qui importe un fichier -->
