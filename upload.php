<?php
    
    //Permet de garder les variables de la session
    session_start();
    //Permet de récuprer le contenu du fichier connect_db.php 
    require 'includes/connect_db.php';
    //Connexion à notre base de donnée

    $bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

    //Restrindre l'accés à cette page au personne non connecté

     if(!isset($_SESSION['id'])) {

             header('Location: errorConnexion.html');
             exit;
          
       }

    if(isset($_POST['formupload'])) {

        if(!empty($_POST['genre'])){

            if(!empty($_FILES)){
                //Permet de récuperer toutes les informations du document
                $file_name = $_FILES['fichier']['name'];
                $file_type = $_FILES['fichier']['type'];
                $file_extension = strrchr($file_name, ".");
                $file_tmp_name = $_FILES['fichier']['tmp_name'];

                $file_dest = 'files/'.$file_name;

                $userpseudo = $_SESSION['pseudo'];

                $genre = $_POST['genre'];

                $visibilite = $_POST['visibilite'];

                setlocale(LC_TIME, 'fra_fra');
                
                $date = strftime('%d %B %Y');
                $heure = strftime('%H:%M:%S'); ;
    

                $extension_autorisees = array('.pdf', '.PDF','.doc','.DOC','.docx','.DOCX','.xlsx','.xlsm','.xlsb');

                //Permet de rajouter le document dans la base de donnée
                if(in_array($file_extension,$extension_autorisees)){
                    if(move_uploaded_file($file_tmp_name, $file_dest)){
                        $file_extension = strtolower($file_extension);
                        $req = $db->prepare('INSERT INTO files(name, file_url, pseudo, genre, visibilite, extension, date, heure) VALUES(?,?,?,?,?,?,?,?)');
                        $req->execute(array($file_name, $file_dest, $userpseudo, $genre, $visibilite, $file_extension, $date, $heure));
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
        $erreurupload =  "entrée un genre";
    }

}

//Permet de rajouter un genre dans la base de donnée
if(isset($_POST['create_genre'])) {

    $genre = $_POST['newgenre'];
    $insert_genre = $bdd->prepare("INSERT INTO genre(pseudo, genre) VALUES(?, ?)");
    $insert_genre->execute(array($_SESSION['pseudo'], $genre));


    $msg_create_genre = "Votre genre à bien été crée";

}

?>


<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Upload d'un document</title>
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
                 //Rajout de la barre d'administration si la personne est un administrateur
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
<div class="contact">
    <div class="container" >
        <div align="center" style="margin: 30px" class="animated bounceInDown delay-100ms">

            <h1> Uploader un fichier</h1>
            <i class="fa fa-file fa-5x"></i></br>

        </br>

        <form method="POST" enctype="multipart/form-data" style="border-radius: 20px 50px 20px 50px;">
            <div class="form-group">
                <label for="exampleFormControlInput1"><strong>Votre document :</strong></label>
                </br>

                <input type="file" class="form-control" id="exampleFormControlInput1" name="fichier">
            </div>
        </br>

       
            <div class="form-group">
                <label for="exampleFormControlSelect1"><strong>Sélectionner la visibilité de votre document :</strong></label>
                </br>

                <select class="form-control" id="exampleFormControlSelect1" name="visibilite">
                    <option value="private">Privée</option>
                    <option value="public">Public</option>
                    
                </select>
            </div>

        </br>

     
            <div class="form-group">
                <label for="exampleFormControlSelect1"><strong>Sélectionner le genre de votre document :</strong></label>
                </br>

                <select class="form-control" id="exampleFormControlSelect1" name="genre">
                    <option value="webbook">Web Book</option>
                    <option value="devoir">Devoir</option>
                    <option value="documentperso">Document Personnelle</option>


                     <?php
                 

                       $req_reponse = $bdd->prepare('SELECT * FROM genre WHERE pseudo = ?');
                       $req_reponse->execute(array($_SESSION['pseudo']));
                      
                         
                        while ($donnees = $req_reponse->fetch())
                        {

                        ?>
                                   <option value="<?php echo $donnees['genre']; ?>"> <?php echo $donnees['genre']; ?></option>
                        <?php
                        }
                         
                    
                    ?>
                </select>
            </div>

             <input type="submit" value="Envoyer le fichier" name="formupload"/>


            </br>
            <?php
              if(isset($erreurupload)) {
              echo '<font color="red">'.$erreurupload."</font>";
              }
            ?>
            </br>


            <label for="exampleFormControlSelect1"><strong>Créer un nouveau genre :</strong></label>
                        </br>

             <form method="POST"> 
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