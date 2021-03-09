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

//Permet d'obtenir les informations de l'utilisateur actuel
if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
   $getid = intval($_SESSION['id']);
   $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE ID_Utilisateur = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
}

if(isset($_SESSION['id'])) {

   $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE ID_Utilisateur = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   //Permet de modifier le pseudo
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $userinfo['Pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE utilisateur SET Pseudo = ? WHERE ID_Utilisateur = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }

   if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $userinfo['Nom']) {
      $newnom = htmlspecialchars($_POST['newnom']);
      $insertnom = $bdd->prepare("UPDATE utilisateur SET Nom = ? WHERE ID_Utilisateur = ?");
      $insertnom->execute(array($newnom, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }

   if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $userinfo['Prenom']) {
      $newprenom = htmlspecialchars($_POST['newprenom']);
      $insertprenom = $bdd->prepare("UPDATE utilisateur SET Prenom = ? WHERE ID_Utilisateur = ?");
      $insertprenom->execute(array($newprenom, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   //Permet de modifier le mail
   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $userinfo['Email']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE utilisateur SET Email = ? WHERE ID_Utilisateur = ?");
      $insertmail->execute(array($newmail, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }

   if(isset($_POST['newtel']) AND !empty($_POST['newtel']) AND $_POST['newtel'] != $userinfo['Tel']) {
      $newtel = htmlspecialchars($_POST['newtel']);
      $inserttel = $bdd->prepare("UPDATE utilisateur SET Tel = ? WHERE ID_Utilisateur = ?");
      $inserttel->execute(array($newtel, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   //Permet de modifier le mot de passe
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE utilisateur SET Mdp = ? WHERE ID_Utilisateur = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }
?>
<html>
<head>
    <title>Édition de votre profil</title>
    @include('includes.navbar')
</head>
<body>
<div class="contact">
   <div align="center" class="animated bounceInDown delay-100ms">

       <form class="shadow" method="post" style="border-radius: 20px 50px 20px 50px;" action="" enctype="multipart/form-data">
        @csrf
           <h2 class="text-center">Edition de mon profil</h2>
           <i class="fa fa-user fa-5x"></i></br>
           <div class="form-group"><input class="form-control" type="text" name="newpseudo" placeholder="Pseudo" value=<?php echo $userinfo['Pseudo']; ?> /></div>
           <div class="form-group"><input class="form-control" type="text" name="newnom" placeholder="Nom" value=<?php echo $userinfo['Nom']; ?> /></div>
           <div class="form-group"><input class="form-control" type="text" name="newprenom" placeholder="Prenom" value=<?php echo $userinfo['Prenom']; ?> /></div>
           <div class="form-group"><input class="form-control" type="text" name="newmail" placeholder="Mail" value=<?php echo $userinfo['Email']; ?> /></div>
           <div class="form-group"><input class="form-control" type="text" name="newtel" placeholder="Tel" value=<?php echo $userinfo['Tel']; ?> /></div>
           <div class="form-group"><input class="form-control" type="password" name="newmdp1" placeholder="Mot de passe"/></input></div>
           <div class="form-group"><input class="form-control" type="password" name="newmdp2" placeholder="Confirmation du mot de passe"/></div>
           <div class="form-group"><input class="btn btn-primary btn-block" type="submit"/></input></div>
         </br>
         <?php if(isset($msg)) { 

          echo '<font color="red">'.$msg."</font>";

        } 

        ?>
  
       </form>
       
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
<?php   
}
else {
   header("Location: connexion.php");
}
?>