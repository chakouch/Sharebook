<?php
//Permet de garder les variables de la session
if(!isset($_SESSION)) {
    session_start();
}
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
            <title>Oeuvres déposées</title>
            @include('includes.navbar')
        </head>
<body>

<section style="background-image: url(&quot;assets/img/3image.jpg&quot;);">
    <div class="animated bounceInDown delay-100ms">
    <h1 class="text-capitalize text-center" data-aos="fade" data-aos-duration="3000" style="color: #ffffff;font-size: 100px;"><strong>Mes Oeuvres</strong></h1>
    <hr style="color: #ffffff;font-size: 27px;background-color: #ffffff;width: 700px;height: 3px;">
    <p class="text-center" style="color: #f1f7fc;"><strong>Vue sur vos oeuvres et leurs paramètres</strong></p>
    <p class="text-center" style="color: #f1f7fc;"><i class="fa fa-file-o bounce animated" style="font-size: 50px;margin-bottom: 35px;color: rgb(225,197,48);"></i></p>
</div>
</section>


<form method="POST" action="{{ route('book.list') }}" enctype="multipart/form-data" style="margin-top: 50px">
@csrf
    <div align="center">


        <div class="input-group" style="max-width: 400px; min-width: 200px">

            <select class="form-control custom-select" id="exampleFormControlSelect1" name="choix">
                 <option value="docs_all">Tous</option>
                 <option value="docs_buy">Mes ouvrages achetés</option>
                 <option value="docs_rent">Mes ouvrages loués</option>
            </select>
            <div class="input-group-append">
                <label class="input-group-text" for="inputGroupSelect02">Choix</label>
            </div>
        </div>
        <br>
        <button type="button" class="btn btn-info"><input type="submit" class="btn btn-info" value="Afficher les documents" name="extension"/></button><br/>
    </div>

</form>

</br>
</br>

    <div>
        <table class="table">
            
            <thead>
                <tr>
                    <?php
                        if(isset($choix)){
                            if($choix == "docs_rent"){
                            echo'
                                <th scope="col" class="border-0 bg-light">
                                    <div class="p-2 px-3 text-uppercase">Nom du livre</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Auteur</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Prix</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">debut de location</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">fin de location</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Lecture</div>
                                </th>';
                            }
                            elseif($choix == "docs_buy"){
                                echo'
                                <th scope="col" class="border-0 bg-light">
                                    <div class="p-2 px-3 text-uppercase">Nom du livre</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Auteur</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Prix</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Date d'."'".'achat</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Lecture</div>
                                </th>';
                            }
                            else{
                                echo'
                                <th scope="col" class="border-0 bg-light">
                                    <div class="p-2 px-3 text-uppercase">Nom du livre</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Auteur</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Prix</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Date</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Type d'."'".'acces</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">Lecture</div>
                                </th>';
                            }
                        }
                    ?> 
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($choix)){
                        if($choix == "docs_rent"){
                            $somme = 0;                                        
                            foreach($documents as $document){
                                echo '
                                <tr>
                                    <td class="border-0 align-middle"><strong>'.$document->Titre.'</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Auteur.'</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Prix.' €</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Date_debut.'</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Date_fin.'</strong></td>
                                    <td class="border-0 align-middle"><a href="book/rented/'.$document->Titre.'" class="text-dark"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                ';
                            }
                        }
                        elseif($choix == "docs_buy"){
                            $somme = 0;                                        
                            foreach($documents as $document){
                                echo '
                                <tr>
                                    <td class="border-0 align-middle"><strong>'.$document->Titre.'</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Auteur.'</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Prix.' €</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Date_debut.'</strong></td>
                                    <td class="border-0 align-middle"><a href="book/bought/'.$document->Titre.'" class="text-dark"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                ';
                            }
                        }
                        else{
                            $somme = 0;                                        
                            foreach($documents as $document){
                                echo '
                                <tr>
                                    <td class="border-0 align-middle"><strong>'.$document->Titre.'</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Auteur.'</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Prix.' €</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Date_debut.'</strong></td>
                                    <td class="border-0 align-middle"><strong>'.$document->Type.'</strong></td>
                                    <td class="border-0 align-middle"><a href="book/bought/'.$document->Titre.'" class="text-dark"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                ';
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
                    <p>Start-up innovante, ShareBook a pour ambition de rendre la connaissance accessible et universel</p>
                </div>

            </div>
            <p class="copyright">SmartDoc © 2019</p>
        </div>
    </footer>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</html>