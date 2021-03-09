<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Inscription ShareBook</title>

    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cabin:700">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">

    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/animate.css">

</head>

<body id="page-top">

<nav class="navbar navbar-light navbar-expand-md shadow-lg navigation-clean-button" style="background-color: #313437;">
    <div class="container"><a class="navbar-brand" href="index" style="color: #ffffff;">ShareBook</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav mr-auto">



                <?php
                if(isset($_SESSION['id'])) {

                    echo '</ul><span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="deconnexion">Vous êtes connectez : Déconnexion</a></span>';


                } else {


                    echo '</ul><span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="connexion">Connectez-vous</a></span>';
                }
                ?>
        </div>
</nav>



<div class="login">
    <form method="POST" style="margin-top:50px" action="{{url('inscription')}}">
    {{ csrf_field() }}
        <h1>ShareBook</h1>
        <img src="assets/img/logo.png" style="margin-left:center" alt="logo"><br/>
        <h2 class="sr-only">Connexion</h2>


        <div class="form-group">


            <input class="form-control" type="text" placeholder="Votre Pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />


        </div>


        <div class="form-group">


            <input class="form-control" type="text" placeholder="Votre Nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />


        </div>

        <div class="form-group">


            <input class="form-control" type="text" placeholder="Votre Prenom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" />


        </div>

        <div class="form-group">



            <input class="form-control"  type="email" placeholder="Votre Mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />

        </div>

        <div class="form-group">

            <input class="form-control" type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />

        </div>

        <div class="form-group">



            <input class="form-control"  type="tel" placeholder="Votre Numéro de Téléphone" id="tel" name="tel" value="<?php if(isset($tel)) { echo $tel; } ?>" />

        </div>

        <div class="form-group">



            <input class="form-control"  type="date" placeholder="Votre Date de Naissance" id="date_naissance" name="date_naissance" value="<?php if(isset($date_naissance)) { echo $date_naissance; } ?>" />

        </div>



        <div class="form-group">
            <input class="form-control" type="password" placeholder="Votre Mot de Passe" id="mdp" name="mdp" />

        </div>

        <div class="form-group">
            <input class="form-control" type="password" placeholder="Confirmez votre mot de passe" id="mdp2" name="mdp2" />


        </div>


        <div class="form-group">

            <button class="btn btn-primary btn-block" type="submit" name="forminscription">Inscription</button>

        </div>

        <?php
        //Permet d'afficher l'erreur en cas de problème
        if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
        }
        ?>

    </form>

</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>