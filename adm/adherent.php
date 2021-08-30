<?php
  if (!isset ($_SESSION)) // regarde si une session est deja en cours
  session_start ();
  require_once ('connexionBD.php');
  if (isset ($_POST ["valider_modifier_adherent"])){ // si l'utilisateur a modifé un adhérent
    $requete = 'UPDATE Adherent SET nom = "'.$_POST["nom"].'", prenom = "'.$_POST["prenom"].'", date_naissance = "'.$_POST["date"].'", sexe = "'.$_POST["sexe"].'", adresse ="'.$_POST["adresse"].'" , date_validite_certificat = "'.$_POST["date_certificat"].'", nom_club = "'.$_POST["club"].'" WHERE idA = "'.$_POST["valider_modifier_adherent_cache"].'"';
    // requête qui modifie un adhérent
    modifierLaTable($requete);
  }
  if (isset ($_POST["modifier_cache"])){ // si l'utilisateur veut modifier un adhérent
    $requete='SELECT nom,prenom,date_naissance,sexe,adresse,date_validite_certificat,nom_club FROM Adherent WHERE idA="'.$_POST["modifier_cache"].'"';
    // requête qui permet de récupérer les informations sur un adhérent
    $tableauRequete=traiterRequete ($requete);
?>
    <form method="post" action="espacePerso.php">
   <p>
     <fieldset>
       <legend>Modification de l'adhérent </legend>
       <label for="Nom">Nom :</label>
       <input type="text"  name="nom" value = "<?php print ($tableauRequete[1]["nom"]) ; ?>" required />
       <br />
       <label for="Prenom">Prénom :</label>
       <input type="text" name="prenom" value= "<?php print ($tableauRequete[1]["prenom"]) ;?>"  required/>
       <br/>
       <label for="Naissance">Date de naissance :</label>
       <input type="text" name="date" placeholder="Du type 00/00/2000" value= "<?php print ($tableauRequete[1]["date_naissance"]) ; ?>"  required />
       <br/>
       <label for="Sexe">Sexe :</label>
       <input type="text" name="sexe" placeholder="H ou F" value= "<?php print ($tableauRequete[1]["sexe"]) ;?>" required/>
       <br/>
       <label for="Adresse">Adresse :</label>
       <input type="text" name="adresse" value= "<?php print ($tableauRequete[1]["adresse"]) ; ?>" required/>
       <br/>
       <label for="Date_Certificat">Date de validité du certificat :</label>
       <input type="text" name="date_certificat" placeholder="Du type 00/00/2000"  value= "<?php print ($tableauRequete[1]["date_validite_certificat"]) ; ?>" required />
       <br/>
       <label for="Club">Club :</label>
       <input type ="text" name ="club" placeholder="ClubLyon ou ClubParis" value = "<?php print ($tableauRequete[1]["nom_club"]) ; ?>"  required />
       <br/>
       <input type="hidden" name="valider_modifier_adherent_cache" value="<?php print ($_POST["modifier_cache"]); ?>">
       <input class="btn btn-outline-info" type="submit" name="valider_modifier_adherent" value="Valider">
   </p>
  </fieldset>
  </form>
  <!-- formulaire qui modifie un adhérent -->
<?php
  }
?>
