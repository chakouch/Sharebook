<?php

//Permet de garder les variables de la session
session_start();
//Connexion à notre base de donnée
$bdd = new PDO('mysql:host=ls-0f927a463e6d389cf0f567dc4d5a58f8ca59fcd7.cq7na6hxonpd.eu-central-1.rds.amazonaws.com;dbname=ShareBook', 'sharebookuser', 'uA?BL6P8;t=P-JKl)]Su>L3Gj$[mz0q]');

//Restrindre l'accés à cette page au personne non connecté

 if(!isset($_SESSION['id'])) {

         header('Location: errorConnexion.html');
         exit;
      
   }



//Restrindre l'accés à cette page au personne qui ne sont pas admin

if (strcasecmp($_SESSION['Roles'], 'admin') ==! 0 AND strcasecmp($_SESSION['Roles'], 'gestionnaire') ==! 0){

         header('Location: errorAdmin.html');
         exit;    
}

$membres = $bdd->query('SELECT * FROM utilisateur ORDER BY ID_Utilisateur DESC LIMIT 0,5');

   if(isset($_POST['formadmin'])) {
   		
       if(!empty($_POST['supp_user'])){
            //Permet de supprimer la personne
            $user_a_supp = $_POST['supp_user'];
            $req = $bdd->query('DELETE FROM utilisateur WHERE Pseudo ="'.$user_a_supp.'"');
            //Permet de supprimer les documents de la personne si cette option est choisie
             if(!empty($_POST['choixsupp'])){
                        
                            $req = $bdd->query('DELETE FROM files WHERE pseudo ="'.$user_a_supp.'"');
                            
             }
                //Permet de supprimer les gens de la personne si cette option est choisie
             if(!empty($_POST['choixsupp2'])){
                        
                            $req = $bdd->query('DELETE FROM genre WHERE pseudo ="'.$user_a_supp.'"');
                            
             }

            $msg_modif = "Compte supprimé ! ";        
			   //   header($lien);
             
         } else {
             $msg_modif = "Choisissez une personne";
         }
   
   }

   if(isset($_POST['modifuser'])) {
      
       if(!empty($_POST['supp_user'])){
            //Permet de modifier la personne 
            $user_a_modiff = $_POST['supp_user'];
            $reqid = $bdd->prepare("SELECT ID_Utilisateur FROM utilisateur WHERE Pseudo = ?");
            $reqid->execute(array($user_a_modiff));
            $user_id = $reqid->fetch();
            header("Location: editionprofiladmin.php?id=".$user_id[0]);  
         } 
   
   }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier le profil des utilisateurs</title>
    @include('includes.navbar')
</head>
<body>
<div class="contact">
<div class="container" >
<div align="center" class="animated bounceInDown delay-100ms">




 	<h1>Choisissser un membre</h1>
	</br>

  	<form method="POST" enctype="multipart/form-data" style="border-radius: 20px 50px 20px 50px;">
        <i class="fa fa-user fa-5x"></i></br>

  	<select name="supp_user">
 
		<?php
		 
		$reponse = $bdd->query('SELECT * FROM utilisateur WHERE Pseudo != "'.$_SESSION['pseudo'].'"');
		 
		while ($donnees = $reponse->fetch())
		{

		?>
		           <option value="<?php echo $donnees['Pseudo']; ?>"> <?php echo $donnees['Pseudo']; ?></option>
		<?php
		}
		 
		?>
	</select>
    </br>
    </br>




        <input type="submit" class="btn btn-danger" name="formadmin" value="Supprimer la personne" style="width: 300px"/></br></br>
        <input type="submit" class="btn btn-warning" name="modifuser" value="Modifier la personne" style="width: 300px"/>
        </br>

      </br>

       <input type="checkbox" id="choixsupp" name="choixsupp">
                            <label for="choixsupp">Supprimer les documents associés au compte ? </label>

        <input type="checkbox" id="choixsupp2" name="choixsupp2">
                            <label for="choixsupp2">Supprimer les genres associés au compte ? </label>
                    

          <?php
          //Permet d'afficher l'erreur
              if(isset($msg_modif)) {
              echo '<font color="red">'.$msg_modif."</font>";
              }
          ?>


 	</form>


    </div>

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