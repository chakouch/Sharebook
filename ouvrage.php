<?php
//Permet de garder les variables de la session
session_start();
//Connexion à notre base de donnée
$bdd = new PDO('mysql:host=ls-0f927a463e6d389cf0f567dc4d5a58f8ca59fcd7.cq7na6hxonpd.eu-central-1.rds.amazonaws.com;dbname=ShareBook', 'sharebookuser', 'uA?BL6P8;t=P-JKl)]Su>L3Gj$[mz0q]');

//Restrindre l'accés à cette page au personne non connecté



$docs = $bdd->prepare('SELECT ID_Document FROM documents');
$docs->execute();
$id_docs = $docs->fetchAll();

$ids = array();
foreach($id_docs as $result) { 
//  echo $result['ID_Document'], '<br>'; 
  array_push($ids, $result['ID_Document']);
}

if (!in_array($_GET['id'], $ids)) { 

  header('Location: document.php');
  exit;
}

if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $get_id_doc = intval($_GET['id']);
   $req_doc = $bdd->prepare('SELECT * FROM documents WHERE ID_Document = ?');
   $req_doc->execute(array($get_id_doc));
   $docinfo = $req_doc->fetch();



?>

<html>
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
       <title>SmartDoc - Profil</title>
       <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
       <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
       <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
       <link rel="stylesheet" href="assets/css/contact.css">
       <link rel="stylesheet" href="assets/css/footer.css">
       <link rel="stylesheet" href="assets/css/navigation.css">
       <link rel="stylesheet" href="assets/css/profil.css">
       <link rel="stylesheet" href="assets/css/animate.css">

    
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Team-Boxed.css">
    <link rel="stylesheet" href="assets/css/navigation.css">



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
                           <a class="dropdown-item" href="document.php">Afficher la Bibliothèque Publique</a>
                           <a class="dropdown-item" href="mydocument.php">Afficher ma Bibliothèque Privée</a>
                           <a class="dropdown-item" href="upload.php">Ajouter un ouvrage</a>
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

                //Rajout de la barre d'administration si la personne un administrateur
                 if(isset($_SESSION['id'])) {

       

                     if (strcasecmp($_SESSION['Roles'], 'admin') == 0 OR strcasecmp($_SESSION['Roles'], 'gestionnaire') == 0) {
                     
                     
                        echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                            Administration
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="utilisateurs_admin.php">Afficher tous les utilisateurs</a>
                            <a class="dropdown-item" href="modif_utlisateurs_admin.php">Modifier / Supprimer un utilisateur</a>
                            <a class="dropdown-item" href="create_utilisateurs.php">Créer un utilisateur</a>
                            <a class="dropdown-item" href="stat_admin.php">Statistiques des utilisateurs</a>
                        </div>
                     </li>';

                     }

                     if (strcasecmp($_SESSION['Roles'], 'admin') == 0 OR strcasecmp($_SESSION['Roles'], 'validateur') == 0) {

                        echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                            Validation
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="affich_docs.php">Afficher les ouvrages des utilisateurs</a>
                            <a class="dropdown-item" href="docs_non_valide.php">Documents non validés</a>
                            <a class="dropdown-item" href="docs_refuse.php">Documents refusés</a>
                        </div>
                     </li>';
                     
                     }
                   }
                ?>

                 <?php
                 }
                 ?>

                  </ul><span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="deconnexion.php">Déconnexion</a></span>

             </div>
       </div>
   </nav>
   <div class="">
      <div class="animated bounceInDown delay-100ms">
       
          <br /><br />
        
     
   
         <?php 
          $req_auteur = $bdd->prepare('SELECT Nom FROM auteur WHERE ID_Auteur = ?');
          $req_auteur->execute(array($docinfo['ID_Auteur']));
          $auteur = $req_auteur->fetch();
     
          $req_genre = $bdd->prepare('SELECT ID_Genre FROM genre_Documents WHERE ID_Document = ?');
          $req_genre->execute(array($docinfo['ID_Document']));
          $ids_du_genre = $req_genre->fetchAll();

          $ids_du_genre_list = array();

          foreach($ids_du_genre as $result) { 
            //echo $result['ID_Genre'], '<br>'; 
            array_push($ids_du_genre_list, $result['ID_Genre']);
          }



          $req_types = $bdd->prepare('SELECT Nom FROM types WHERE ID_Types = ?');
          $req_types->execute(array($docinfo['ID_types']));
          $types = $req_types->fetch();
   
          $req_editeur = $bdd->prepare('SELECT Nom FROM editeur WHERE ID_Editeur = ?');
          $req_editeur->execute(array($docinfo['ID_Editeur']));
          $editeur = $req_editeur->fetch();

          $req_collection = $bdd->prepare('SELECT Nom FROM collection WHERE ID_Collection = ?');
          $req_collection->execute(array($docinfo['ID_Collection']));
          $collection = $req_collection->fetch();
        
          $req_collection = $bdd->prepare('SELECT Nom FROM collection WHERE ID_Collection = ?');
          $req_collection->execute(array($docinfo['ID_Collection']));
          $collection = $req_collection->fetch();

          $req_langue = $bdd->prepare('SELECT Nom_Court FROM langues WHERE ID_Langue = ?');
          $req_langue->execute(array($docinfo['ID_Langue']));
          $langue = $req_langue->fetch();
        
         ?> 

 
      </div>
   </div>


<div class="container-fluid">
    <h3 class="text-dark mb-4">Titre de l'ouvrage : <?php echo $docinfo['Titre']; ?></h3>
    <div class="row mb-3">

        <div class="col-lg-4">
            <div class="card mb-3">

              <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Vue miniature</p>
        </div>
       
                <div class="card-body text-center shadow"><?php echo '<img class="img-fluid" src="'.$docinfo['Image'].'" /> ' ?>
                </div>
            </div>
            
        </div>
        <div class="col-lg-8">
            <div class="row mb-3 d-none">
                <div class="col">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="m-0">Peformance</p>
                                    <p class="m-0"><strong>65.2%</strong></p>
                                </div>
                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                            </div>
                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last month</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col">
                                    <p class="m-0">Peformance</p>
                                    <p class="m-0"><strong>65.2%</strong></p>
                                </div>
                                <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                            </div>
                            <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last month</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Infos essentielles</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="auteur"><strong>Auteur</strong></label></br>
                                        <?php echo $auteur[0]; ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="email"><strong>Nombre de pages</strong></label></br><?php echo $docinfo['Nombre_Pages']; ?></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="first_name"><strong>Date de parution</strong></label></br><?php echo $docinfo['Date_Parution']; ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="last_name"><strong>Langue</strong></label> </br>

                                          <?php echo '<img src="./flag/'.$langue[0].'.png" height="25" width="40" />'; ?>

                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Détails sur l'oeuvre</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group"><label for="address"><strong>Résumé</strong></label></br><?php echo $docinfo['Resume']; ?></div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Genre</strong></label></br>
                                          <?php           
                                               foreach($ids_du_genre_list as $result) { 
                                                   $genre_affichage = $bdd->prepare('SELECT Nom FROM genre_litteraire WHERE ID_Genre = ?');
                                                   $genre_affichage->execute(array($result));
                                                   $genre_affichage = $genre_affichage->fetch();
                                                   echo $genre_affichage[0].'<br>';

                                                }

                                          ?>
                                    </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Type</strong></label></br><?php echo $types[0]; ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Editeur</strong></label></br><?php echo $editeur[0]; ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Collection</strong></label></br><?php echo $collection[0]; ?></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--     <div class="card shadow mb-5">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Vue complète de l'oeuvre</p>
        </div>
        <div class="card-body">
             <?php echo '<img class="img-fluid" src="'.$docinfo['Image'].'">'?>
        </div>
    </div> -->


    <div class="card shadow mb-5">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Choix d'accès à l'oeuvre</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form>
                        <div class="form-group"><strong>Comment accéder à l'oeuvre ?</strong><br /></div>
                        <div class="form-group" align="center">
                            <form method="POST" action="" enctype="multipart/form-data">

                                 </br>

                                 </br>
                                     <button type="button" class="btn btn-success"> Achat <input type="radio" class="btn btn-success" name="question" value="achat" id="achat" /></button>
                                     <button type="button" class="btn btn-warning"> Abonnement <input type="radio" class="btn btn-success" name="question" value="abonnement" id="abonnement" /></button>
                                 </br>
                                 </br>
                                     <button type="submit" class="btn btn-danger" value="location" name="formsupp"/>Location</button>
                                 </br>
                                   <div class="form-group col-md-4">
                                  <label for="inputDate" style="font-weight: bold">Date de la location</label>
                                  <input type="date" class="form-control" name="date" placeholder="date" value="">
                                </div>
                                 </br>

                                 <div>
                            
                                   <?php
                                      if(isset($message)) {
                                      echo '<font color="red">'.$message."</font>";
                                      }
                                    ?>
                                    
                          </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="footer">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12 item text">
                    <h3>ShareBook</h3>
                    <p>Start-up innovante, ShareBook a pour ambition de rendre la connaissance accessible et universel.</p>
                </div>

            </div>
            <p class="copyright">ShareBook © 2021</p>
        </div>
    </footer>


   </body>
</html>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>


