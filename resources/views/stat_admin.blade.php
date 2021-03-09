<?php 
//Permet de garder les variables de la session
session_start();
//Connexion à notre base de donnée
  $bdd = new PDO('mysql:host=ls-0f927a463e6d389cf0f567dc4d5a58f8ca59fcd7.cq7na6hxonpd.eu-central-1.rds.amazonaws.com;dbname=ShareBook', 'sharebookuser', 'uA?BL6P8;t=P-JKl)]Su>L3Gj$[mz0q]');
//Permet de recuperer les pseudo et le nombre de document qu'a cette utilisateur
$membres = $bdd->query('SELECT DISTINCT ID_Utilisateur, COUNT(ID_Utilisateur) as total FROM documents GROUP BY ID_Utilisateur');
$test='pseudo';

//Restrindre l'accés à cette page au personne non connecté

if(!isset($_SESSION['id'])) {

         header('Location: errorConnexion.html');
         exit;
}

//Restrindre l'accés à cette page au personne qui ne sont pas administrateur
if (strcasecmp($_SESSION['Roles'], 'admin') ==! 0 AND strcasecmp($_SESSION['Roles'], 'gestionnaire') ==! 0){

         header('Location: errorAdmin.html');
         exit;    
}


 if(isset($_POST['formupload'])) {

        if(!empty($_POST['genre'])){

            $genre = $_POST['genre'];
            //Permet, en fonction de ce que veux l'utilisateur, d'executer la bonne requete SQL 
            if (strcmp($genre, "nmb_doc_par_utilisateur") == 0) {

                $test = "ID_Utilisateur";
                $test1 = "ID_Utilisateur";
                $test2 = "documents";
                $test3 = "ID_Utilisateur";

                $membres = $bdd->query("SELECT DISTINCT $test, COUNT($test1) as total FROM $test2 GROUP BY $test3");
                $titre = 'Pourcentage de document par utilisateur';

/*                echo "\nPDOStatement::errorInfo():\n";
                $arr = $membres->errorInfo();
                print_r($arr);*/

             } elseif (strcmp($genre, "nmb_genre") == 0) {

                $test = "ID_Genre";
                $test1 = "ID_Genre";
                $test2 = "genre_Documents";
                $test3 = "ID_Genre";

                $membres = $bdd->query("SELECT DISTINCT $test, COUNT($test1) as total FROM $test2 GROUP BY $test3");
                $titre = 'Pourcentage de documents par genre';
  
                             
             } elseif (strcmp($genre, "nmb_right") == 0) {
                
                $test = "Roles";
                $test1 = "Roles";
                $test2 = "utilisateur";
                $test3 = "Roles";

                $membres = $bdd->query("SELECT $test, COUNT($test1) as total FROM $test2 GROUP BY $test3");
                $titre = 'Pourcentage des droits des utilisateurs';

              

            }

          
        }

  }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Statistiques avancées</title>
    @include('includes.navbar')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Country', 'Visits'],
         

 <?php 

 while($m = $membres->fetch()) { 
   if (strcmp($genre, "nmb_doc_par_utilisateur") == 0) {
              $req_utilisateur = $bdd->prepare('SELECT Pseudo FROM utilisateur WHERE ID_Utilisateur = ?');
              $req_utilisateur->execute(array($m[$test]));
              $donnees = $req_utilisateur->fetch();
    }

    elseif (strcmp($genre, "nmb_genre") == 0) {
              $req_genre = $bdd->prepare('SELECT Nom FROM genre_litteraire WHERE ID_Genre = ?');
              $req_genre->execute(array($m[$test]));
              $donnees = $req_genre->fetch();
    }
    elseif (strcmp($genre, "nmb_right") == 0) {
              $req_droit = $bdd->prepare('SELECT Roles FROM utilisateur WHERE Roles = ?');
              $req_droit->execute(array($m[$test]));
              $donnees = $req_droit->fetch();


    }


  ?>
      

        ['<?= $donnees[0] ?>',  <?= $m['total'] ?>],
         
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

<div class="contact" style="background-color: white">

  <div class="container">
    <div align="center">

        <div class="row">
            <div class="col-sm-6">
                <form method="POST" enctype="multipart/form-data" style="margin-top: 50px">
                    <div class="input-group mb-3">

                        <select class="form-control custom-select" id="exampleFormControlSelect1" name="genre">
                            <option value="nmb_doc_par_utilisateur">Pourcentage de document par utilisateur</option>
                            <option value="nmb_genre">Pourcentage de genres crées par utilisateurs</option>
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
