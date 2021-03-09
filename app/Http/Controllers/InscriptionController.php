<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class InscriptionController extends Controller
{
    public function InscriptionForm(){
        return view('inscription');
    }

    public function Inscription(Request $request){
        //Connexion à notre base de donnée
        if(isset($_POST['forminscription'])) {
        //Permet de récuperer les variables du formulaire
        $pseudo = $request->pseudo;
        $nom = $request->nom;
        $prenom = $request->prenom;
        $mail = $request->mail;
        $mail2 = $request->mail2;
        $tel = $request->tel;
        $date_naissance = $request->date_naissance;
        $mdp = sha1($request->mdp);
        $mdp2 = sha1($request->mdp2);
        $droit = "aucun";
        $genre = 0;
        $date_supprimer = null;
        $date_de_creation = date("Y-m-d H:i:s");
            //Permet de rajouter la personne dans la basse de donnée
            if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($date_naissance) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
                $pseudolength = strlen($pseudo);
                if($pseudolength <= 255) {
                    if($mail == $mail2) {
                        if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        $reqpseudo = DB::select("SELECT * FROM utilisateur WHERE Pseudo = ?", [$pseudo]);
                        $collection = collect($reqpseudo);
                        //$reqpseudo->execute(array($pseudo));
                        $pseudoexist = $collection->count();
                        if($pseudoexist == 0) {
                            if($mdp == $mdp2) {
                                $insertmbr = DB::insert("INSERT INTO utilisateur(Pseudo, Nom, Prenom, Email, Tel, Date_Naissance, Genre, Date_de_creation, Date_supprimer, Mdp,Roles) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$pseudo, $nom, $prenom, $mail, $tel, $date_naissance, $genre, $date_de_creation, $date_supprimer, $mdp, $droit]);
                                //$insertmbr->execute(array($pseudo, $nom, $prenom, $mail, $tel, $date_naissance, $date_de_creation, $mdp, $droit));
                                $erreur = "Votre compte a bien été créé ! <a href=\"connexion\">Me connecter</a>";
                                
                            } else {
                                $erreur = "Vos mots de passes ne correspondent pas !";
                            }
                        } else {
                            $erreur = "Pseudo déjà utilisée !";
                        }
                        } else {
                        $erreur = "Votre adresse mail n'est pas valide !";
                        }
                    } else {
                        $erreur = "Vos adresses mail ne correspondent pas !";
                    }
                } else {
                    $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
                }
            } else {
                $erreur = "Tous les champs doivent être complétés !";
            }
        }

        //Permet d'afficher l'erreur en cas de problème
        if(isset($erreur)) {
            //echo '<font color="red">'.$erreur."</font>";
            return view('inscription')->with(compact('erreur'));
        }
    }
}
