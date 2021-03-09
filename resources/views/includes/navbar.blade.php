<?php
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

$cartCollection = \Cart::getContent();
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
<nav class="navbar navbar-light navbar-expand-md shadow-lg navigation-clean-button" style="background-color: #313437;">
        
    <div class="container"><a class="navbar-brand" href="/index" style="color: #ffffff;">ShareBook</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
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
                        <!-- <a class="dropdown-item" href="{{ url('stat_public') }}">Publiques / Privés</a> -->
                    </div>
                </li>


                <?php
                     //Rajout de la barre d'administration si la personne est un administrateur

                     if (strcasecmp($_SESSION['Roles'], 'admin') == 0 OR strcasecmp($_SESSION['Roles'], 'gestionnaire') == 0) {
                     
                     
                        echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                            Administration
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/utilisateurs_admin">Afficher tous les utilisateurs</a>
                            <a class="dropdown-item" href="/modif_utlisateurs_admin">Modifier / Supprimer un utilisateur</a>
                            <a class="dropdown-item" href="/create_utilisateurs">Créer un utilisateur</a>
                            <a class="dropdown-item" href="/stat_admin">Statistiques des utilisateurs</a>
                        </div>
                     </li>';

                     }

                     if (strcasecmp($_SESSION['Roles'], 'admin') == 0 OR strcasecmp($_SESSION['Roles'], 'validateur') == 0) {

                        echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white !important;">
                            Validation
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/affich_docs">Afficher les ouvrages des utilisateurs</a>
                            <a class="dropdown-item" href="/docs_non_valide">Documents non validés</a>
                            <a class="dropdown-item" href="/docs_refuse">Documents refusés</a>
                        </div>
                     </li>';
                     
                     }
                     ?>

        
            </ul>

        </div>
    </div>
    <div>  
        <ul class="nav navbar-nav navbar-right" style="margin-right: 30px;">
            <li class="dropdown">
            <a href="cart" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="fa fa-gift bigicon"></span> Articles dans le panier<span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-cart" role="menu">
                <?php
                    //Permet d'afficher les documents 
                        foreach($cartCollection as $item){
                            $document = DB::select("SELECT * FROM documents WHERE ID_Document = ?", [$item->id])[0];
                            echo '
                            <li>
                                <span class="item">
                                    <span class="item-left">
                                        <img src="'.$document->Image.'" alt width="70" class="img-fluid rounded shadow-sm" />
                                        <span class="item-info">
                                            <span>Titre : '.$document->Titre.'</span>
                                            <span>Prix : '.$item->price.' €</span>
                                        </span>
                                    </span>
                                </span>
                            </li>
                            ';
                        }
                ?>
                <li class="divider"></li>
                <li><a class="text-center" href="{{ url('cart') }}"">Voir le panier</a></li>
            </ul>
            </li>
        </ul>
    </div>
    <span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="/deconnexion">Déconnexion</a></span>
</nav>

<style>
/* .bigicon {    
    color:white;
} */

.mix{
    min-height:370px;
}

ul.dropdown-cart{
    min-width:250px;
    border: 2px solid #343434;
    padding: 2px;
    margin: 7px;
    margin-top: 11px;
}
ul.dropdown-cart li .item{
    display:block;
    padding:3px 10px;
    margin: 3px 0;
    
}
ul.dropdown-cart li .item:hover{
    background-color:#c3c5c5;
    
}
ul.dropdown-cart li .item:after{
    visibility: hidden;
    display: block;
    font-size: 0;
    content: " ";
    clear: both;
    height: 0;
}

ul.dropdown-cart li .item-left{
    float:left;
}
ul.dropdown-cart li .item-left img,
ul.dropdown-cart li .item-left span.item-info{
    float:left;
}
ul.dropdown-cart li .item-left span.item-info{
    margin-left:10px;   
}
ul.dropdown-cart li .item-left span.item-info span{
    display:block;
}
ul.dropdown-cart li .item-right{
    float:right;
}
ul.dropdown-cart li .item-right button{
    margin-top:14px;
}   
</style>