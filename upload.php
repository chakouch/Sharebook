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



    if(isset($_POST['formupload'])) {
     if(!empty($_POST['nom_ouvrage'])){
      if(!empty($_POST['genre'])){
       if(!empty($_POST['auteur'])){
        if(!empty($_POST['type'])){ 
         if(!empty($_POST['editeur'])){ 
          if(!empty($_POST['collection'])){   
           if(!empty($_FILES['fichier'])){
                //Permet de récuperer toutes les informations du document
                $file_name = $_FILES['fichier']['name'];
                $file_type = $_FILES['fichier']['type'];
                $file_extension = strtoupper(strrchr($file_name, "."));
                $file_tmp_name = $_FILES['fichier']['tmp_name'];
                $file_dest = 'files/'.$file_name;

                if(!empty($_FILES['miniature'])){

                    $miniature_name = $_FILES['miniature']['name'];
                    $miniature_type = $_FILES['miniature']['type'];
                    $miniature_extension = strtoupper(strrchr($miniature_name, "."));
                    $miniature_tmp_name = $_FILES['miniature']['tmp_name'];
                    $miniature_dest = 'miniatures/'.$miniature_name;
                }
            

                $userpseudo = $_SESSION['pseudo'];
                $id_user = (int)$_SESSION['id'];

                $nom_ouvrage = $_POST['nom_ouvrage'];
                $id_genre = $_POST['genre'];
                $id_auteur = $_POST['auteur'];
                $id_type = $_POST['type'];
                $id_editeur = $_POST['editeur'];
                $id_collection = $_POST['collection'];
                $resume =  $_POST['resumeouvrage'];
                $page = intval($_POST['nombredepage']);
/*                echo $id_genre;
                echo $id_auteur;
                echo $id_type;*/
                echo $id_genre      ;
                echo '<td>'."\r\n";
                echo $id_auteur     ;
                echo '<td>'."\r\n";
                echo $id_type       ;
                echo '<td>'."\r\n";
                echo $id_editeur    ;
                echo '<td>'."\r\n";
                echo $id_collection ;
                echo '<td>'."\r\n";
                echo $resume        ;
                echo '<td>'."\r\n";
                echo $page          ;
                echo '<td>'."\r\n";
                setlocale(LC_TIME, 'fra_fra');
                
                $date = strftime('%d %B %Y');
                $heure = strftime('%H:%M:%S'); ;
    

                $extension_autorisees_file = array('.PDF', '.BOOK', '.EPUB');
                $extension_autorisees_miniature = array('.JPEG', '.PNG', '.JPG');
/*                echo $file_extension;
                echo $miniature_extension;*/

                //Permet de rajouter le document dans la base de donnée
                if(in_array($file_extension,$extension_autorisees_file)){
                    if(move_uploaded_file($file_tmp_name, $file_dest)){
                        
                        $file_extension = strtolower($file_extension);

                        if(!empty($_FILES['miniature']) AND in_array($miniature_extension,$extension_autorisees_miniature) ){
                          if(move_uploaded_file($miniature_tmp_name, $miniature_dest)){  
                            $req = $db->prepare('INSERT INTO documents(Titre, Chemin, Image, ID_Auteur, ID_Genre, ID_Types, ID_Utilisateur, ID_Editeur, ID_Collection, ID_Validation, Resume, Nombre_Pages ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
                            $req->execute(array($nom_ouvrage, $file_dest, $miniature_dest, $id_auteur, $id_genre, $id_type, $id_user, $id_editeur, $id_collection, '1', $resume, $page));
                            echo "\nPDOStatement::errorInfo():\n";
                            $arr = $req->errorInfo();
                            print_r($arr);
                           } else {
                              $erreurupload = "Une erreur est survenue lors de l'envoi de la miniature";
                            }

                        } else {
                            $req = $bdd->prepare('INSERT INTO documents(Titre, Chemin, ID_Auteur, ID_Genre, ID_Types, ID_Utilisateur, ID_Editeur, ID_Collection, ID_Validation, Resume, Nombre_Pages) VALUES(?,?,?,?,?,?,?,?,?,?,?)');
                            $req->execute(array($nom_ouvrage, $file_dest, $id_auteur, $id_genre, $id_type, $id_user, $id_editeur, $id_collection, '1', $resume, $page));
                            echo "\nPDOStatement::errorInfo():\n";
                            $arr = $req->errorInfo();
                            print_r($arr);
                        }
                        
                        $erreurupload = "Le fichier '$file_name' a bien était upload ! ";

                    } else {
                        $erreurupload = "Une erreur est survenue lors de l'envoi du fichier";
                    }

                } else{
                    $erreurupload =  "Ce type d'extension n'est pas autorisé";
                }

        } else {
            $erreurupload = "rentrer un fichier";
        } 
    } else {
            $erreurupload = "rentrer un auteur";
        }     
    } else {
            $erreurupload = "rentrer un type";
        } 

    } else {
            $erreurupload = "rentrer un editeur";
        } 

     } else {
            $erreurupload = "rentrer une collection";
        } 
    
    }else {
        $erreurupload =  "entrée un genre";
    }
        }else {
        $erreurupload =  "entrée un genre";
    }

}

//Permet de rajouter un genre dans la base de donnée
if(isset($_POST['create_genre'])) {

    $genre = $_POST['newgenre'];
    $insert_genre = $bdd->prepare("INSERT INTO genre(Nom, ID_Utilisateur) VALUES(?, ?)");
    $insert_genre->execute(array($genre, $_SESSION['pseudo']));

    $msg_create_genre = "Votre genre à bien été crée";

}

?>


<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Déposer une oeuvre</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/profil.css">
    <link rel="stylesheet" href="assets/css/animate.css">
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
                 //Rajout de la barre d'administration si la personne est un administrateur
                if (strcasecmp($_SESSION['droit'], 'admin') == 0){


                    echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                        Administration
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="utilisateurs_admin.php">Afficher tous les utilisateurs</a>
                        <a class="dropdown-item" href="affich_docs.php">Afficher les ouvrages des utilisateurs</a>
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
<div class="contact">
    <div class="container" >
        <div align="center" style="margin: 30px" class="animated bounceInDown delay-100ms">

            <h1>Déposer une oeuvre</h1>
            <i class="fa fa-file fa-5x"></i></br>

        </br>

        <form method="POST" enctype="multipart/form-data" style="border-radius: 20px 50px 20px 50px;">

            <div class="form-group">
                <label for="exampleFormControlInput1"><strong>Sélectionner le nom de votre ouvrage :</strong></label>
                </br>

                <input type="text" class="form-control" id="exampleFormControlInput2" name="nom_ouvrage">
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput1"><strong>Sélectionner votre ouvrage *:</strong></label>
                </br>

                <input type="file" class="form-control" id="exampleFormControlInput1" name="fichier">
            </div>
        </br>

        <form method="POST" enctype="multipart/form-data" style="border-radius: 20px 50px 20px 50px;">
            <div class="form-group">
                <label for="exampleFormControlInput1"><strong>Sélectionner la miniature de votre ouvrage :</strong></label>
                </br>

                <input type="file" class="form-control" id="exampleFormControlInput2" name="miniature">
            </div>
        </br>

       

        <form method="POST" enctype="multipart/form-data" style="border-radius: 20px 50px 20px 50px;">
            <div class="form-group">
                <label for="exampleFormControlInput1"><strong>Sélectionner l'auteur de votre document *:</strong></label>
                </br>
                <select class="form-control" id="exampleFormControlSelect1" name="auteur">
                
                     <?php
                 

                       $req_auteur = $bdd->prepare('SELECT * FROM auteur');
                       $req_auteur->execute(array());
                      
                         
                        while ($donnees = $req_auteur->fetch())
                        {

                        ?>
                                   <option value="<?php echo $donnees['ID_Auteur']; ?>"> <?php echo $donnees['Nom']; ?></option>
                        <?php
                        }
                         
                    
                    ?>
                </select>
            </div>
    
            <div class="form-group">
                <label for="exampleFormControlSelect1"><strong>Sélectionner le genre de votre ouvrage *:</strong></label>
                </br>

                <select class="form-control" id="exampleFormControlSelect1" name="genre">

                     <?php
                 

                       $req_genre = $bdd->prepare('SELECT * FROM genre');
                       $req_genre->execute(array());
                      
                         
                        while ($donnees = $req_genre->fetch())
                        {

                        ?>
                                   <option value="<?php echo $donnees['ID_Genre']; ?>"> <?php echo $donnees['Nom']; ?></option>
                        <?php
                        }
                         
                    
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1"><strong>Sélectionner le type de votre ouvrage *:</strong></label>
                </br>

                <select class="form-control" id="exampleFormControlSelect1" name="type">

                     <?php
                 

                       $req_type = $bdd->prepare('SELECT * FROM types');
                       $req_type->execute(array());
                      
                         
                        while ($donnees = $req_type->fetch())
                        {

                        ?>
                                   <option value="<?php echo $donnees['ID_Types']; ?>"> <?php echo $donnees['Nom']; ?></option>
                        <?php
                        }
                         
                    
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1"><strong>Sélectionner l'editeur de votre ouvrage *:</strong></label>
                </br>

                <select class="form-control" id="exampleFormControlSelect1" name="editeur">

                     <?php
                 

                       $req_editeur = $bdd->prepare('SELECT * FROM editeur');
                       $req_editeur->execute(array());
                      
                         
                        while ($donnees = $req_editeur->fetch())
                        {

                        ?>
                                   <option value="<?php echo $donnees['ID_Editeur']; ?>"> <?php echo $donnees['Nom']; ?></option>
                        <?php
                        }
                         
                    
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1"><strong>Sélectionner la collection de votre ouvrage *:</strong></label>
                </br>

                <select class="form-control" id="exampleFormControlSelect1" name="collection">

                     <?php
                 

                       $req_collection = $bdd->prepare('SELECT * FROM collection');
                       $req_collection->execute(array());
                      
                         
                        while ($donnees = $req_collection->fetch())
                        {

                        ?>
                                   <option value="<?php echo $donnees['ID_Collection']; ?>"> <?php echo $donnees['Nom']; ?></option>
                        <?php
                        }
                         
                    
                    ?>
                </select>
            </div>

            <label for="exampleFormControlSelect1"><strong>Ecrire le résumé de votre ouvrage :</strong></label>
                        </br>

             <form method="POST"> 
                  <input type="text" class="form-control" id="exampleFormControlSelect1" value = "Rentre le résumé de votre ouvrage" name="resumeouvrage">

            </br>

            <label for="exampleFormControlSelect1"><strong>Rentrer le nombre de page :</strong></label>
            </br>

                <input type="number" class="form-control" id="exampleFormControlSelect1" value = "Rentre le nomre de pagae" name="nombredepage">

            </br>

             <input type="submit" value="Envoyer le fichier" name="formupload"/>


            </br>
            <?php
              if(isset($erreurupload)) {
              echo '<font color="red">'.$erreurupload."</font>";
              }
            ?>
            </br>


            <label for="exampleFormControlSelect1"><strong>Créer un nouveau genre *:</strong></label>
                        </br>


                  <input type="text" class="form-control" id="exampleFormControlSelect1" value = "Rentre le nouveau genre" name="newgenre">
                 </br>
                 <input type="submit" value="Créer le genre" name="create_genre"/>


            </br>
            <?php
              if(isset($msg_create_genre)) {
              echo '<font color="red">'.$msg_create_genre."</font>";
              }
            ?>

            



            </br>
            </br>

            <div align="center">
                     <p>Documents autorisés :</p>
                     <i class="fa fa-file-pdf-o fa-4x" aria-hidden="true"></i>
                     <i class="fa fa-file-excel-o fa-4x" aria-hidden="true"></i>
                     <i class="fa fa-file-powerpoint-o fa-4x" aria-hidden="true"></i>

                 </div>
        </form>

        
        </div></div></div>


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


</html>