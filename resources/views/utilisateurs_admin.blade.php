<?php

//Permet de garder les variables de la session
session_start();
//Connexion à notre base de donnée
  $bdd = new PDO('mysql:host=ls-0f927a463e6d389cf0f567dc4d5a58f8ca59fcd7.cq7na6hxonpd.eu-central-1.rds.amazonaws.com;dbname=ShareBook', 'sharebookuser', 'uA?BL6P8;t=P-JKl)]Su>L3Gj$[mz0q]');
//Permet de récupere les informations des utilisateurs
$membres = $bdd->query('SELECT * FROM utilisateur ORDER BY ID_Utilisateur DESC LIMIT 0,5');

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
   	

?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil des utilisateurs du site</title>
    @include('includes.navbar')
</head>
<body>

<div align="center">
<div class="container">

  <h1 style="margin-top: 50px">Liste des utilisateurs</h1>
    <i class="fa fa-users fa-5x"></i></br>

  	</br>
  	</br>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
       <th>Id</th>
       <th>Pseudo</th>
       <th>Nom</th>
       <th>Prenom</th>
       <th>Mail</th>
       <th>Téléphone</th>
       <th>Date de naissance</th>
       <th>Date de création</th>
       <th>Droit</th>
   </tr>
        </thead>

        <tbody>
   
      <?php while($m = $membres->fetch()) { ?>
	      <tr>
	      	<th><?= $m['ID_Utilisateur'] ?> </th>
          <th><?= $m['Pseudo'] ?></th>
	      	<th><?= $m['Nom'] ?></th>
	      	<th><?= $m['Prenom'] ?></th>
          <th><?= $m['Email'] ?></th>
          <th><?= $m['Tel'] ?></th>
          <th><?= $m['Date_Naissance'] ?></th>
          <th><?= $m['Date_de_creation'] ?></th>
          <th><?= $m['Roles'] ?></th>
	       </tr>

      <?php
  	  }
  	  ?>
        </tbody>
  	</table>
  	</br>
  	</br>


</div>
</div>

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

</body>
</html>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/bs-animation.js"></script>
<script src="assets/js/bs-charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
<script src="assets/js/jquery-3.3.1.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );

</script>