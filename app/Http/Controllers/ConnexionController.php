<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Gloudemans\Shoppingcart\Facades\Cart;
use PDO;

class ConnexionController extends Controller
{
    public function LoginForm(){
        return view('connexion');
    }

    public function Login(Request $request){
        //Permet de garder les variables de la session
        session_start();
        //Connexion base de données
        $bdd = new \PDO('mysql:host=ls-0f927a463e6d389cf0f567dc4d5a58f8ca59fcd7.cq7na6hxonpd.eu-central-1.rds.amazonaws.com;dbname=ShareBook', 'sharebookuser', 'uA?BL6P8;t=P-JKl)]Su>L3Gj$[mz0q]');

        //Récuperer les variables du formulaire formconnexion
        if(isset($_POST['formconnexion'])) {

            if (isset($_POST['pseudoconnect'])) { 
                $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']); 
                }
            
            if (isset($_POST['mdpconnect'])) { 
                $mdpconnect = sha1($_POST['mdpconnect']);
                }


            //Vérificatoin de l'existance de la personne et de ces informations de connexion
            if(!empty($pseudoconnect) AND !empty($mdpconnect)) {
                $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE Pseudo = ? AND Mdp = ?");
                $requser->execute(array($pseudoconnect, $mdpconnect));
                $userexist = $requser->rowCount();
                if($userexist == 1) {
                    $userinfo = $requser->fetch();
                    $_SESSION['id'] = $userinfo['ID_Utilisateur'];
                    $_SESSION['pseudo'] = $userinfo['Pseudo'];
                    $_SESSION['nom'] = $userinfo['Nom'];
                    $_SESSION['prenom'] = $userinfo['Prenom'];
                    $_SESSION['mail'] = $userinfo['Email'];
                    $_SESSION['tel'] = $userinfo['Tel'];
                    $_SESSION['Roles'] = $userinfo['Roles'];
                    return view('profil', [$_SESSION['id']]);
                } else {
                    
                        $requserverif = $bdd->prepare("SELECT * FROM utilisateur WHERE Pseudo = ?");
                        $requserverif->execute(array($pseudoconnect));
                        $userexistverif = $requserverif->rowCount(); 

                        if($userexistverif == 1) {

                            $erreur = "Mauvais mot de passe !";

                        } else {
                            $erreur =  "L'utilisateur ".$pseudoconnect." n'existe pas !";
                        }

                    

                }
            } else {

                $erreur = "Tous les champs doivent être complétés !";
            }
        }
        
    }

    public function Deconnexion(){
        //Permet de supprimer le contenu de la variable session et supprimer la session
        session_start();
        $_SESSION = array();
        session_destroy();
        // Clearing user cart
        \Cart::clear();
        return view('connexion');
    }
}