<?php
//Permet de garder les variables de la session
session_start();
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
    
    <div class="container"><a class="navbar-brand" href="index" style="color: #ffffff;">ShareBook</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav mr-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                        Mon profil
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="profil">Afficher mon profil</a>
                        <a class="dropdown-item" href="editionprofil">Editer mon profil</a>
                        <a class="dropdown-item" href="supp_account">Supprimer mon compte</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                        Documents
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="document">Afficher la Bibliothèque Publique</a>
                        <a class="dropdown-item" href="mydocument">Afficher ma Bibliothèque Privée</a>
                        <a class="dropdown-item" href="upload">Ajouter un ouvrage</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                        Statistiques
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="stat_extension">Par extension</a>
                        <a class="dropdown-item" href="stat_public">Publiques / Privés</a>
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
                        <a class="dropdown-item" href="utilisateurs_admin">Afficher tous les utilisateurs</a>
                        <a class="dropdown-item" href="affich_docs">Afficher les ouvrages des utilisateurs</a>
                        <a class="dropdown-item" href="modif_utlisateurs_admin">Modifier / Supprimer un utilisateur</a>
                        <a class="dropdown-item" href="create_utilisateurs">Créer un utilisateur</a>
                        <a class="dropdown-item" href="stat_admin">Statistiques des utilisateurs</a>
                    </div>
                </li>';


                }
                ?>

          

            </ul><span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="deconnexion">Déconnexion</a></span>

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
                <?php
                use Illuminate\Support\Facades\DB;
                use Illuminate\Support\Collection;
                //Permet d'afficher les documents 
                $documents = DB::select("SELECT * FROM documents");
                    foreach($documents as $document){
                        
                        $req_auteur = DB::select("SELECT Nom FROM auteur WHERE ID_Auteur = ?", [$document->ID_Auteur]);
                        $req_langue = DB::select("SELECT Nom_Court FROM langues WHERE ID_Langue = ?", [$document->ID_Langue]);
                        $auteur = collect($req_auteur[0]);
                        $langue = collect($req_langue[0]);
                        echo '
                        <div class="col-sm-6 col-md-4 portfolio-item">
                            <a class="portfolio-link" href="ouvrage/'.$document->ID_Document.'" >
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fa fa-plus fa-3x"></i></div>
                                </div><img class="img-fluid" src="'.$document->Image.'" /></a>
                            <div class="portfolio-caption">
                                <h4>'.$document->Titre.'</h4>
                                <p class="text-muted">Auteur : '.collect($auteur)['Nom'].'</p>
                                <p class="text-muted">Nombre de page : '.$document->Nombre_Pages.'</p>
                                <p class="text-muted">Langue : <img src="./flag/'.collect($langue)['Nom_Court'].'.png" height="15" width="20" /></p>

                            </div>
                        </div>
                        ';
                
                      }
            ?>          
         </div>
    </div>
</section>

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
