<?php
    
   //Permet de garder les variables de la session
   session_start();
   require 'includes/connect_db.php';
   //Permet de récuprer le contenu du fichier connect_db.php 

   $lien = 'Location: deconnexion';

//Restrindre l'accés à cette page au personne non connecté
 if(!isset($_SESSION['id'])) {

         header('Location: errorConnexion.html');
         exit;
      
   }

   if(isset($_POST['formsupp'])) {

       if(!empty($_POST['question'])){
            if($_POST['question'] == "non") {

                     $message = '<a href="profil.php">Cliquer ici pour revenir sur votre profil</a>';
            }
            elseif ($_POST['question'] == "oui") {

                    //Supprimer la personne
                     $userid = $_SESSION['id'];
                     $usrpseudo= $_SESSION['pseudo'];
                     $req = $bdd->query('DELETE FROM utilisateur WHERE ID_Utilisateur ="'.$userid.'"');
                    //Supprimer les documents de l'utilisateur si l'option est cochée
                     if(!empty($_POST['scales'])){
                            
                            $req = $bdd->query('DELETE FROM documents WHERE ID_Auteur ="'.$usrpseudo.'"');
                            
                     }
                     //Supprimer les genres de l'utilisateur si l'option est cochée
/*                     if(!empty($_POST['scales2'])){
                        
                            $req = $db->query('DELETE FROM genre WHERE pseudo ="'.$usrpseudo.'"');
                            
                    }*/
                     $message = "Compte supprimé ! ";
                     header($lien);
            }
             
         } else {
            $message = "Choisiez entre oui ou non";
         }
   
   }


?>
<html>
<head>
    <title>Supprimer votre compte</title>
    @include('includes.navbar')
</head>
<body>

<div class="container">
      <div align="center" style="margin: 150px" class="animated bounceInDown delay-100ms">
         <h2>Êtes-vous sûrs de vouloir supprimer votre compte ?</h2>
          <i class="fa fa-user fa-5x"></i></br>


         <form method="POST" action="" enctype="multipart/form-data">
         @csrf
         </br>

         </br>
             <button type="button" class="btn btn-success"> Oui <input type="radio" class="btn btn-success" name="question" value="oui" id="oui" /></button>
             <button type="button" class="btn btn-warning"> Non <input type="radio" class="btn btn-success" name="question" value="non" id="non" /></button>
         </br>
         </br>
             <button type="submit" class="btn btn-danger" value="Supprimer le compte" name="formsupp"/>Supprimer le compte</button>
         </br>
         </br>

         <div>
                    <input type="checkbox" id="scales" name="scales">
                            <label for="scales">Supprimer les documents associés à votre compte ? </label>

                    </br>

<!--                     <input type="checkbox" id="scales2" name="scales2">
                            <label for="scales2">Supprimer les genres associés à votre compte ? </label>
                    </div> -->
           <?php
              if(isset($message)) {
              echo '<font color="red">'.$message."</font>";
              }
            ?>
            
         </form>
      </div>
      </div>
   </body>
</html>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/bs-animation.js"></script>
<script src="assets/js/bs-charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>