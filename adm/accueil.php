<?php
  if (!isset ($_SESSION)) // regarde si une session est deja en cours
  session_start ();
  require_once ('connexionBD.php');
  $requete = "SELECT Nom FROM Course"; // sélectionne toutes les courses de la base de donnée
  $tableauRequete = traiterRequete ($requete);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.css" media="all"/>
    <title>La Grammondsion</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
    <h1 class='display-3 text-center'>Profil administrateur</h1>
    <p class='display-4 text-center'>
      Bienvenue <?php print $_SESSION ["slogin"];?>
      <!-- Affiche le pseudo de l'administrateur connecté -->
    </p>
    <form method="post" action="espacePerso.php">
      <input  class="btn btn-dark btn-outline-primary col-6 offset-3" type="submit" value="Liste des utilisateurs" name="liste_utilisateur">
    </form>
    <!-- formulaire qui permet d'afficher la liste des utilisateurs-->
    <form method="post" action="espacePerso.php"></br>
      <p class="text-center">
      <label for="liste_course">Veuillez saisir une course pour plus de détail</label>
    </p>
      <select class="custom-select col-6 offset-3" name="liste_course" id="liste_course">
          <?php
            foreach ($tableauRequete as $key => $value) { // boucle qui permet de parcourir le tableau des courses
              if ($key != 0){ // si la ligne du tableau est différente de l'entête
                print ('<option value="'.$value['Nom'].'">'.$value ['Nom'].'</option>'); // affiche la liste des courses dans un menu déroulant
              }
            }
          ?>
          <!-- affiche la liste des courses -->
      </select>
      <input class="btn btn-dark btn-outline-light col-6 offset-3" type="Submit" name="voir_course" value="Voir course">
    </form>
    <!-- formulaire qui permet d'afficher les informations sur une course-->
    <form method="post" action="espacePerso.php">
      <input  class="btn btn-dark btn-outline-light col-6 offset-3" type="submit" name="voir_adherent" value="Liste des adhérents">
    </form>
    <!-- formulaire qui permet d'afficher la liste des ahérents-->
    <form method="post" action="espacePerso.php">
      <input  class="btn btn-dark btn-outline-light col-6 offset-3" type="submit" name="voir_resultat" value="Voir les résultats des courses">
    </form>
    <!-- formulaire qui permet d'afficher les résultats-->
    <form method="post" action="espacePerso.php">
      <input  class="btn btn-dark btn-outline-light col-6 offset-3" type="submit" name="importer_resultat" value="Importer résultat">
    </form>
    <!-- formulaire qui permet d'importer des scripts sql-->
    <?php
      if (isset ($_POST["modifier_edition"]) OR isset ($_POST["valider_modification_edition"]) OR isset ($_POST["modifier_course"]) OR isset ($_POST["valider_modification_course"])){
        include ('./adm/course.php');
      }
      // si l'utilisateur veut modifier une édition ou modifier une course alors le fichier course.php sera inclus
      if (isset ($_POST["voir_adherent"]) OR isset($_POST ["Supprimer"]) OR isset($_POST ["ajouter_adherent"]) OR isset ($_POST["valider_ajout_adherent"])){
        include ('./adm/adherents.php');
      }
      // si l'utilisateur veut voir la liste des adhérents,supprimer un adhérent ou ajouter un adhérent alors la dichier adherents.php sera inclus
      if (isset ($_POST["modifier_adherent"]) OR isset ($_POST["valider_modifier_adherent"])){
        include ('./adm/adherent.php');
      }
      // si l'utilisateur veut modifier un adhérents alors le fichier adherent.php sera inclus
      if (isset ($_POST["voir_course"]) OR isset($_POST["Supprimer_course"]) OR isset($_POST["Supprimer_edition"]) OR isset ($_POST["Ajouter_course"]) OR isset ($_POST["Ajouter_edition"]) OR isset ($_POST["valider_ajout_edition"])){
        include ('./adm/courses.php');
      }
      // si l'utilisateur veut voir les informations sur une course,supprimer une course ou ajouter une course alors le fichier courses.php sera inclus
      if(isset ($_POST["liste_utilisateur"]) OR isset($_POST["modifier_utilisateur"]) OR isset ($_POST["valider_modification_utilisateur"]) OR isset($_POST ["supprimer_utilisateur"]) OR isset ($_POST["valider_ajout_utilisateur"]) OR isset ($_POST["ajouter_utilisateur"])){
        include ('./adm/utilisateur.php');
      }
      // si l'utilisateur veut voir la liste des utilisateurs,modifier un utilisateur,supprimer un utilisateur ou ajouter un utilisateur alors le fichier utilisateur.php sera inclus
      if (isset ($_POST["voir_resultat"]) OR isset ($_POST["valider_voir_resultat"])){
        include ('./adm/resultats.php');
      }
      // si l'utilisateur veut voir les résultats alors le fichier resultats.php sera inclus
      if (isset ($_POST ["importer_resultat"]) or isset($_POST ["valider_import"])){
        include ('./adm/import.php');
      }
      // si l'utilisateur veut voir les résultats alors le fichier resultats.php sera inclus
    ?>
    <form method="post" action="deconnexion.php">
      <input type="submit" class="form-control btn btn-dark btn-outline-warning col-6 offset-3" value ="Deconnexion">
    </form>
    <!-- formulaire qui permet de se déconnecter -->
  </body>
</html>
