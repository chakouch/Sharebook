<?php
//Permet de garder les variables de la session
session_start();
?>
<!doctype html>
<html>
        <head>
            <title>Bibliothèque</title>
            @include('includes.navbar')
        </head>
<body>

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
