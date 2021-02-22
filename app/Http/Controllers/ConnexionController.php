<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ConnexionController extends Controller
{
    public function LoginForm(){
        return view('connexion');
    }

    public function Login(Request $request){
        //$title = 'About Us';
        //return view('pages.about')->with('title', $title);
        
        //Permet de garder les variables de la session
        session_start();
        
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
                $requser = DB::select("SELECT * FROM utilisateur WHERE Pseudo = ? AND Mdp = ?", [$pseudoconnect, $mdpconnect]);
                $userexist = collect($requser)->count();
                if($userexist == 1) {
                    $userinfo = collect($requser)[0];
                    $_SESSION['id'] = $userinfo->ID_Utilisateur;
                    $_SESSION['pseudo'] = $userinfo->Pseudo;
                    $_SESSION['mail'] = $userinfo->Email;
                    $_SESSION['droit'] = $userinfo->Roles;
                    header("Location: profil?id=".$_SESSION['id']);
                } else {
                    
                        $reqpseudo = DB::select("SELECT * FROM utilisateur WHERE Pseudo = ?", [$pseudoconnect]);
                        $userexistverif = collect($reqpseudo)->count();

                        if($userexistverif == 1) {

                            $erreur = "Mauvais mot de passe !";

                        } else {
                            $erreur = "L'utilisateur ".$pseudoconnect." n'existe pas !";
                        }

                    

                }
            } else {

                $erreur = "Tous les champs doivent être complétés !";
            }
        }

        //Permet d'afficher l'erreur en cas de problème
        if(isset($erreur)) {
            return view('connexion')->with(compact('erreur'));
        }
        
    }
}