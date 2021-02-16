<?php
//Permet de garder les variables de la session
session_start();
//Permet de récuprer le contenu du fichier connect_db.php 
require 'includes/connect_db.php';
//Connexion à notre base de donnée
$bdd = new PDO('mysql:host=ls-0f927a463e6d389cf0f567dc4d5a58f8ca59fcd7.cq7na6hxonpd.eu-central-1.rds.amazonaws.com;dbname=ShareBook', 'sharebookuser', 'uA?BL6P8;t=P-JKl)]Su>L3Gj$[mz0q]');
//Restrindre l'accés à cette page au personne non connecté

 if(!isset($_SESSION['id'])) {

         header('Location: errorConnexion.html');
         exit;
      
   }

?>


<!doctype html>
<html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
            <title>Bibliothèque</title>
            <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
            <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
            <link rel="stylesheet" href="assets/css/contact.css">
            <link rel="stylesheet" href="assets/css/footer.css">
            <link rel="stylesheet" href="assets/css/navigation.css">
            <link rel="stylesheet" href="assets/css/profil.css">
            <link rel="stylesheet" href="assets/css/animate.css">
            <link rel="stylesheet" type="text/css" href="assets/css/print.min.css">




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
                 //Rajout de la barre d'administration si la personne un administrateur

                if (strcasecmp($_SESSION['droit'], 'admin') == 0){


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

<section style="background-image: url(&quot;assets/img/3image.jpg&quot;);">
    <div class="animated bounceInDown delay-100ms">
    <h1 class="text-capitalize text-center" data-aos="fade" data-aos-duration="3000" style="color: #ffffff;font-size: 100px;"><strong>Bibliothèque</strong></h1>
    <hr style="color: #ffffff;font-size: 27px;background-color: #ffffff;width: 700px;height: 3px;">
    <p class="text-center" style="color: #f1f7fc;"><strong>Découvrer notre catalogue d'oeuvre disponible</strong></p>
    <p class="text-center" style="color: #f1f7fc;"><i class="fa fa-file-o bounce animated" style="font-size: 50px;margin-bottom: 35px;color: rgb(225,197,48);"></i></p>
</div>
</section>


<section id="portfolio" class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-uppercase section-heading">Oeuvres disponibles</h2>
                <h3 class="section-subheading text-muted">Découvrer la collection des nouvelles oeuvres disponibles !</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4 portfolio-item">
                <a class="portfolio-link" data-toggle="modal" href="#portfolioModal1">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content"><i class="fa fa-plus fa-3x"></i></div>
                    </div><img class="img-fluid" src="assets/img/cover_livre.jpg" /></a>
                <div class="portfolio-caption">
                    <h4>Nom oeuvre 1</h4>
                    <p class="text-muted">Auteur</p>
                    <p class="text-muted">Thème</p>

                </div>
            </div>
            <div class="col-sm-6 col-md-4 portfolio-item">
                <a class="portfolio-link" data-toggle="modal" href="#portfolioModal2">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content"><i class="fa fa-plus fa-3x"></i></div>
                    </div><img class="img-fluid" src="assets/img/cover_livre.jpg" /></a>
                <div class="portfolio-caption">
                    <h4>Nom oeuvre 2<br /></h4>
                    <p class="text-muted">Auteur</p>
                    <p class="text-muted">Thème</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 portfolio-item">
                <a class="portfolio-link" data-toggle="modal" href="#portfolioModal3">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content"><i class="fa fa-plus fa-3x"></i></div>
                    </div><img class="img-fluid" src="assets/img/cover_livre.jpg" /></a>
                <div class="portfolio-caption">
                    <h4>Nom oeuvre 3</h4>
                    <p class="text-muted">Auteur</p>
                    <p class="text-muted">Thème</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 portfolio-item">
                <a class="portfolio-link" data-toggle="modal" href="#portfolioModal4">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content"><i class="fa fa-plus fa-3x"></i></div>
                    </div><img class="img-fluid" src="assets/img/cover_livre.jpg" /></a>
                <div class="portfolio-caption">
                    <h4>Nom oeuvre 4</h4>
                    <p class="text-muted">Auteur</p>
                    <p class="text-muted">Thème</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 portfolio-item">
                <a class="portfolio-link" data-toggle="modal" href="#portfolioModal5">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content"><i class="fa fa-plus fa-3x"></i></div>
                    </div><img class="img-fluid img-fluid" src="assets/img/cover_livre.jpg" /></a>
                <div class="portfolio-caption">
                    <h4>Nom oeuvre 5</h4>
                    <p class="text-muted">Auteur</p>
                    <p class="text-muted">Thème</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 portfolio-item">
                <a class="portfolio-link" data-toggle="modal" href="#portfolioModal6">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content"><i class="fa fa-plus fa-3x"></i></div>
                    </div><img class="img-fluid" src="assets/img/cover_livre.jpg" /></a>
                <div class="portfolio-caption">
                    <h4>Nom oeuvre 6</h4>
                    <p class="text-muted">Auteur</p>
                    <p class="text-muted">Thème</p>
                </div>
            </div>
        </div>
    </div>
</section>





<form method="POST" enctype="multipart/form-data" style="margin-top: 50px">
    <div align="center">


    <div class="input-group" style="max-width: 400px; min-width: 200px">

        <select class="form-control custom-select" id="exampleFormControlSelect1" name="choix">
            <?php
            //Permet de récuperer et d'afficher l'extension de tout les documents 
            $reponse = $bdd->query('SELECT DISTINCT extension FROM files  WHERE visibilite = "public"');

            while ($donnees = $reponse->fetch())
            {

                ?>
                <option value="<?php echo $donnees['extension']; ?>"> <?php echo $donnees['extension']; ?></option>
                <?php
            }

            ?>
        </select>
        <div class="input-group-append">
            <label class="input-group-text" for="inputGroupSelect02">Choix</label>
        </div>
    </div>
        <br>
    <button type="button" class="btn btn-info"><input type="submit" class="btn btn-info" value="Afficher les documents" name="extension"/></button><br/>
    </div>
</form>


     <div class="container" style="overflow-x:auto;">



                    <table id="example" class="table table-striped table-bordered" style="width:100%">

                        <thead>
                        <tr>


     <?php
               
            //Permet d'afficher les grilles des tableaux en fonction de l'extension des documents
                if(isset($_POST['extension'])) {

                    if(!empty($_POST['choix'])){

                       

                        $extension = $_POST['choix'];

                         if (strcmp($extension, ".pdf") == 0) {


                            echo  ' 

                                        <th>Nom du fichier</th>
                                        <th>Fichier</th>
                                        <th>Auteur</th>
                                        <th>Genre</th>
                                        <th>Date upload</th> 
                                        <th>Aperçu</th>
                                        <th>Lancer Impression</th>

                             ';

                         } else {

                               echo  '  


                                         <th>Nom du fichier</th>
                                         <th>Fichier</th>
                                         <th>Auteur</th>
                                         <th>Genre</th>
                                         <th>Date upload</th>   

                           ';


                         }
                        }
                    }

               ?>




                </tr>
                </thead>
                <tbody>

                <?php

                //Permet d'afficher les documents en fonctin de l'extension
                if(isset($_POST['extension'])) {

                    if(!empty($_POST['choix'])){

                     $ext=$_POST['choix'];

                    $req = $db->query('SELECT name, file_url, genre, date, heure, pseudo, lower(extension) FROM files WHERE (visibilite ="public" AND extension="'.$ext.'")');

                    while($data = $req->fetch()){
                         echo '<tr>';

                        echo '<th>'.$data['name'].'</th>';
                        echo '<th><a href="'.$data['file_url'].'" target="_blank">'.$data['name'].'</a></th>';
                        echo '<th>'.$data['pseudo'].'<br/></th>';
                        echo '<th>'.$data['genre'].'</th>';
                        echo '<th>'.$data['date'].' à '.$data['heure'].'</th>';


                        if(strcmp($data['lower(extension)'], ".pdf") == 0){

                             $path="'".$data['file_url']."'";

                            echo '<th><iframe src="'.$data['file_url'].'" id="test" frameborder="0"></iframe></th>';
                            echo '<th><input type="button" id="bt" onclick="print('.$path.')" value="Imprimer le PDF" /></th>';
                        }


                       
                  
                    }
                    }
                }

                    ?>

                 

                    </tbody>

                </table>
            </div>

        </body>


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
</div>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/bs-animation.js"></script>
<script src="assets/js/bs-charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
<script src="assets/js/jquery-3.3.1.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>

<script>
    //Fonction pour afficher et imprimer les documents PDF
    function print(doc) {
        var objFra = document.createElement('iframe');   // Create an IFrame.
        objFra.style.visibility = "hidden";    // Hide the frame.
        objFra.src = doc;                      // Set source.
        document.body.appendChild(objFra);  // Add the frame to the web page.
        objFra.contentWindow.focus();       // Set focus.
        objFra.contentWindow.print();      // Print it.
    }
</script>


</html>
