<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.css"  media="all"/>
    <title>La Grammondsion</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
    <?php
      session_unset (); // Detruit les variables
      session_destroy () // detruit la session
      ?>
      <div class="container">
        <div class="row text-center">
          <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Vous partez déjà ! A bientôt !</h1>
                    <h2>
                      Déconnexion</h2>
                      <div class="error-details">
                        Vous allez être redirigés vers la page d'authentification
                      </div>
                      <div class="error-actions">
                        <a href="./index.php" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>  <!-- Bouton renvoyant sur index.php-->
                          Revenir à l'accueil </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </body>
</html>
