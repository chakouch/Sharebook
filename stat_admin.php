<?php 
//Permet de garder les variables de la session
session_start();
//Connexion à notre base de donnée
$bdd = new PDO('mysql:host=ls-0f927a463e6d389cf0f567dc4d5a58f8ca59fcd7.cq7na6hxonpd.eu-central-1.rds.amazonaws.com;dbname=ShareBook', 'sharebookuser', 'uA?BL6P8;t=P-JKl)]Su>L3Gj$[mz0q]');

//Permet de recuperer les pseudo et le nombre de document qu'a cette utilisateur
$membres = $bdd->query('SELECT DISTINCT pseudo, COUNT(pseudo) as total FROM files GROUP BY pseudo');
$test='pseudo';

//Restrindre l'accés à cette page au personne non connecté

if(!isset($_SESSION['id'])) {

         header('Location: errorConnexion.html');
         exit;
}

//Restrindre l'accés à cette page au personne qui ne sont pas administrateur
if (strcasecmp($_SESSION['Roles'], 'admin') ==! 0){

         header('Location: errorAdmin.html');
         exit;    
}


 if(isset($_POST['formupload'])) {

        if(!empty($_POST['genre'])){

            $genre = $_POST['genre'];
            //Permet, en fonction de ce que veux l'utilisateur, d'executer la bonne requete SQL 
            if (strcmp($genre, "nmb_document") == 0) {

                $test = "pseudo";
                $test1 = "pseudo";
                $test2 = "files";
                $test3 = "pseudo";

                $membres = $bdd->query("SELECT DISTINCT $test, COUNT($test1) as total FROM $test2 GROUP BY $test3");
                $titre = 'Pourcentage de document par utilisateurs';
  
            } elseif (strcmp($genre, "nmb_genre") == 0) {

                $test = "pseudo";
                $test1 = "pseudo";
                $test2 = "genre";
                $test3 = "pseudo";

                $membres = $bdd->query("SELECT DISTINCT $test, COUNT($test1) as total FROM $test2 GROUP BY $test3");
                $titre = 'Pourcentage de genres crées par utilisateurs';
  
                
              
            } elseif (strcmp($genre, "nmb_priv") == 0) {

                $test = "pseudo";
                $test1 = "visibilite";
    


                $membres = $bdd->query("SELECT $test, COUNT($test1) as total from files WHERE visibilite='private' GROUP BY pseudo");
                $titre = 'Pourcentage de documents privées par utilisateurs';
  
                 
                
             } elseif (strcmp($genre, "nmb_public") == 0) {

                $test = "pseudo";
                $test1 = "visibilite";
    


                $membres = $bdd->query("SELECT $test, COUNT($test1) as total from files WHERE visibilite='public' GROUP BY pseudo");
                $titre = 'Pourcentage de documents public par utilisateurs';
  
                 
                
            } elseif (strcmp($genre, "nmb_right") == 0) {

                $test = "droit";
                $test1 = "droit";

                $membres = $bdd->query("SELECT $test, COUNT($test1) as total from membres GROUP BY droit");
                $titre = 'Pourcentage des droits des utilisateurs';
                
               

            } else {

                $test = "pseudo";
                $test1 = "pseudo";
                $test2 = "membres";
                $test3 = "pseudo";
  

                             
            }

          
        }

  }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Statistiques avancées</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/profil.css">
    <link rel="stylesheet" href="assets/css/animate.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Country', 'Visits'],
         

 <?php while($m = $membres->fetch()) { ?>
      

        ['<?= $m[$test] ?>',  <?= $m['total'] ?>],
         
      <?php

      } 
      ?>

 



        ]);

        var options = {
          title:   <?php echo "'".$titre."'"; ?>,
          is3D:true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
 <body>
<nav class="navbar navbar-light navbar-expand-md shadow-lg navigation-clean-button" style="background-color: #313437;">
    <div class="container"><a class="navbar-brand" href="index.php" style="color: #ffffff;">ShareBook</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav mr-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                        Mon profil
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="profil.php">Afficher mon profil</a>
                        <a class="dropdown-item" href="editionprofil.php">Editer mon profil</a>
                        <a class="dropdown-item" href="supp_account.php">Supprimer mon compte</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                        Documents
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="document.php">Afficher les documents publiques</a>
                        <a class="dropdown-item" href="mydocument.php">Afficher mes documents</a>
                        <a class="dropdown-item" href="upload.php">Upload un document</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                        Statistiques
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="stat_extension.php">Par extension</a>
                        <a class="dropdown-item" href="stat_public.php">Publiques / Privés</a>
                    </div>
                </li>




                <?php
                 //Rajout de la barre d'administration si la personne est un administrateur
                if (strcasecmp($_SESSION['Roles'], 'admin') == 0){


                    echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                        Administration
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="utilisateurs_admin.php">Afficher tous les utilisateurs</a>
                        <a class="dropdown-item" href="affich_docs.php">Afficher les documents des utilisateurs</a>
                        <a class="dropdown-item" href="modif_utlisateurs_admin.php">Modifier / Supprimer un utilisateur</a>
                        <a class="dropdown-item" href="create_utilisateurs.php">Créer un utilisateur</a>
                        <a class="dropdown-item" href="stat_admin.php">Statistiques des utilisateurs</a>
                    </div>
                </li>';


                }
                ?>


            </ul><span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="deconnexion.php">Déconnexion</a></span>

        </div>
    </div>
</nav>


<div class="contact" style="background-color: white">

  <div class="container">
    <div align="center">

        <div class="row">
            <div class="col-sm-6">
                <form method="POST" enctype="multipart/form-data" style="margin-top: 50px">
                    <div class="input-group mb-3">

                        <select class="form-control custom-select" id="exampleFormControlSelect1" name="genre">
                            <option value="nmb_document">Pourcentage de document par utilisateurs</option>
                            <option value="nmb_genre">Pourcentage de genres crées par utilisateurs</option>
                            <option value="nmb_priv">Pourcentage de documents privées par utilisateurs</option>
                            <option value="nmb_public">Pourcentage de documents publics par utilisateur</option>
                            <option value="nmb_right">Pourcentage des droits des utilisateurs</option>
                        </select>
                        <div class="input-group-append">
                            <label class="input-group-text" for="inputGroupSelect02">Choix</label> 
                        </div>
                    </div>
                    </br></br>
                    <input type="submit" value="Génerer le graphique" name="formupload"/>
                </form>

            </div>
            <div class="col-sm-6">
                <div id="piechart" style="width: 900px; height: 500px; background-color: transparent !important;"></div>
            </div>
        </div>

        </div>
    </div>
    </div>
</form>

<div class="footer">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12 item text">
                    <h3>ShareBook</h3>
                    <p>Start-up innovante, ShareBook a pour ambition de rendre la connaissance accessible et universel</p>
                </div>

            </div>
            <p class="copyright">ShareBook © 2021</p>
        </div>
    </footer>
</div>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
