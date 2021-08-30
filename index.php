<?php
  if (isset ($_SESSION)){ // Si une session est active, detruit les variables et la session
      session_unset ();
      session_destroy ();
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.css" media="all"/>
    <title>La Grammondsion</title>  <!-- Nom dans l'onglet -->
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
    <h1 class = 'display-1 text-center'>Bienvenue sur le site de votre association, la Grammondsion ! </h1> <!-- Titre principale-->
      <div class ="container">
        <img src= "Grammond.png" class="rounded mx-auto d-block" >
        <p class="text-center">
          Pour accéder à votre compte, veuillez rentrer vos identifiants</p>
          <div class="form-group text-center">
            <form method="post" action="espacePerso.php">  <!-- Formulaire envoyant sur espacePerso-->
              <p>
                <label for="pseudo">Votre pseudo :</label>  <!-- Balise pour le pseudo-->
                <input type="text" name="pLogin" class="form-control col-6 offset-3" />
                <br/>
                <label for="pass">Votre mot de passe :</label>
                <input type="password" name="pPwd" class="form-control col-6 offset-3"/>  <!-- Balise qui crypte le mot de pase lorque celui-ci est rentré-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="autoSizingCheck2">
                  <label class="form-check-label" for="autoSizingCheck2">  <!-- Pour cocher "Se souvenir"-->
                    Se souvenir
                  </label>
                </div>
                <input type="submit" name="pValider" value="Valider" class="form-control col-3 mx-auto">  <!-- valider le formualaire-->
              </p>
            </form>
          </div>
        </div>
  </body>
</html>
