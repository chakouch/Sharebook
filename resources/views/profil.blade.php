<?php
use Illuminate\Support\Facades\DB;
//Permet de garder les variables de la session
if(!isset($_SESSION)) {
    session_start();
}
//Restrindre l'accés à cette page au personne non connecté
 if(!isset($_SESSION['id'])) {

         header('Location: errorConnexion');
         exit;
      
   }

//Permet d'obtenir les informations de l'utilisateur actuel
if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
   $getid = intval($_SESSION['id']);
   $userinfo = DB::select('SELECT * FROM utilisateur WHERE ID_Utilisateur = ?', array($getid))[0];
}
?>

<html>
   <head>
       <title>SmartDoc - Profil</title>
       @include('includes.navbar')
   </head>
   <body>

   <div class="profile">
      <div align="center" class="animated bounceInDown delay-100ms">
         <h2 style="margin:50px;">Profil de <?php echo $userinfo->Pseudo; ?></h2>

          <i class="fa fa-user fa-5x"></i>
          <br /><br />
         Pseudo : <?php echo $userinfo->Pseudo; ?>
         <br />
         Nom : <?php echo $userinfo->Nom; ?>
         <br />
         Prenom : <?php echo $userinfo->Prenom; ?>
         <br />
         Mail : <?php echo $userinfo->Email; ?>
         <br />
         Numéro de Téléphone : <?php echo $userinfo->Tel; ?>
         <br />
         Droit : <?php echo $userinfo->Roles; ?>
         <br />
         <br />         
         <?php
         if(isset($_SESSION['id']) AND $userinfo->ID_Utilisateur == $_SESSION['id']) {
         ?>
         <br />
             <span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="editionprofil.php">Editer mon profil</a></span>
         <br />
             <span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="supp_account.php">Supprimer mon compte</a></span>
             <br />

 
      </div>
   </div>

   </body>



</html>



    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
<?php   
}
?>


