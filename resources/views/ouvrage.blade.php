<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
//Permet de garder les variables de la session
session_start();
//Restrindre l'accés à cette page au personne non connecté
  if(!isset($_SESSION['id'])) {

          header('Location: errorConnexion.html');
          exit;
      
    }

$id_docs = DB::select('SELECT ID_Document FROM documents');
$ids = array();
foreach($id_docs as $result) { 
  array_push($ids, $result->ID_Document);
}

if (!in_array($id, $ids)) { 

  header('Location: document');
  exit;
}

if(isset($id) AND $id > 0) {
    $docinfo = DB::select("SELECT * FROM documents WHERE ID_Document = ?", [$id])[0];  
?>
<!doctype html>
<html>
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
       <title>Sharebook - Profil</title>
       <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome.min.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.min.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/navigation.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/profil.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">    
       <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/Team-Boxed.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/navigation.css') }}">
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
                           <a class="dropdown-item" href="{{ url('profil') }}">Afficher mon profil</a>
                           <a class="dropdown-item" href="{{ url('editionprofil') }}">Editer mon profil</a>
                           <a class="dropdown-item" href="{{ url('supp_account') }}">Supprimer mon compte</a>
                       </div>
                   </li>

                   <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                           Documents
                       </a>
                       <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                           <a class="dropdown-item" href="{{ url('document') }}">Afficher la Bibliothèque Publique</a>
                           <a class="dropdown-item" href="{{ url('mydocument') }}">Afficher ma Bibliothèque Privée</a>
                           <a class="dropdown-item" href="{{ url('upload') }}">Ajouter un ouvrage</a>
                       </div>
                   </li>

                   <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                           Statistiques
                       </a>
                       <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                           <a class="dropdown-item" href="{{ url('stat_extension') }}">Par extension</a>
                           <a class="dropdown-item" href="{{ url('stat_public') }}">Publiques / Privés</a>
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

                 <?php
                 }
                 ?>

                  </ul><span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="deconnexion">Déconnexion</a></span>

             </div>
       </div>
   </nav>
   <div class="">
      <div class="animated bounceInDown delay-100ms">
       
          <br /><br />
        
     
   
         <?php 
          $req_auteur = DB::select("SELECT Nom FROM auteur WHERE ID_Auteur = ?", [$docinfo->ID_Auteur]);
          $auteur = collect($req_auteur)[0];
          $req_genre = DB::select("SELECT ID_Genre FROM genre_Documents WHERE ID_Document = ?", [$docinfo->ID_Document]);
          $ids_du_genre = collect($req_genre);
          $ids_du_genre_list = array();

          foreach($ids_du_genre as $result) { 
            //echo $result['ID_Genre'], '<br>'; 
            array_push($ids_du_genre_list, $result->ID_Genre);
          }

          $req_types = DB::select("SELECT Nom FROM types WHERE ID_Types = ?", [$docinfo->ID_types]);
          $types = collect($req_types)[0];
   
          $req_editeur = DB::select('SELECT Nom FROM editeur WHERE ID_Editeur = ?', [$docinfo->ID_Editeur]);
          $editeur = collect($req_editeur)[0];

          $req_collection = DB::select('SELECT Nom FROM collection WHERE ID_Collection = ?', [$docinfo->ID_Collection]);
          $collection = collect($req_collection)[0];

          $req_langue = DB::select('SELECT Nom_Court FROM langues WHERE ID_Langue = ?', [$docinfo->ID_Langue]);
          $langue = collect($req_langue)[0];
        
         ?> 

 
      </div>
   </div>


<div class="container-fluid">
    <div class="row">
    <h3 class="text-dark mb-4 col-md-10">Titre de l'ouvrage : <?php echo $docinfo->Titre; ?></h3>
    <span class="col-md-2"> <a class="btn btn-light action-button float-right" role="button" href="cart">Ajouter au panier</a></span>
    </div>
    <div class="row mb-3">

        <div class="col-lg-4">
            <div class="card mb-3">

              <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Vue miniature</p>
        </div>
       
                <div class="card-body text-center shadow"><?php echo '<img class="img-fluid" src="'.$docinfo->Image.'" /> ' ?>
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
                                        <?php echo $auteur->Nom; ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="email"><strong>Nombre de pages</strong></label></br><?php echo $docinfo->Nombre_Pages; ?></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="first_name"><strong>Date de parution</strong></label></br><?php echo $docinfo->Date_Parution; ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="last_name"><strong>Langue</strong></label> </br>

                                          <?php echo '<img src="./flag/'.$langue->Nom_Court.'.png" height="25" width="40" />'; ?>

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
                                <div class="form-group"><label for="address"><strong>Résumé</strong></label></br><?php echo $docinfo->Resume; ?></div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group"><label for="city"><strong>Genre</strong></label></br>
                                          <?php           
                                               foreach($ids_du_genre_list as $result) { 
                                                   $genre_affichage = DB::select('SELECT Nom FROM genre_litteraire WHERE ID_Genre = ?', [$result]);
                                                   $genre_affichage = collect($genre_affichage)[0];
                                                   echo $genre_affichage->Nom.'<br>';

                                                }

                                          ?>
                                    </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Type</strong></label></br><?php echo $types->Nom; ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Editeur</strong></label></br><?php echo $editeur->Nom; ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group"><label for="country"><strong>Collection</strong></label></br><?php echo $collection->Nom; ?></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
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
</body>
</html>