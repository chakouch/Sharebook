<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class BookController extends Controller
{
    
    public function stream($filename, Request $request)
    {
        return view('document.stream')->with(['file' => $filename]);
    }

    public function read($filename, Request $request)
    {
        return view('document.read')->with(['file' => $filename]);
    }
    public function list(Request $request)
    {
        session_start();

        $documents_buy = $documents_rent =  $documents = [];

        $achats = DB::select("SELECT * FROM achat WHERE ID_Utilisateur = ?", [$_SESSION['id']]);
        foreach($achats as $achat){
            $document = DB::select("SELECT * FROM documents WHERE ID_Document = ?", [$achat->ID_Document])[0];
            $auteur = DB::select("SELECT Nom FROM auteur WHERE ID_Auteur = ?", [$document->ID_Auteur])[0];
            $document->Prix=$achat->Prix;
            $document->Date_debut=$achat->Date;
            $document->Type="Acheté";
            $document->Auteur=$auteur->Nom;
            $documents_buy[] = $document;
        }

        $locations = DB::select("SELECT * FROM louer WHERE ID_Utilisateur = ?", [$_SESSION['id']]);
        foreach($locations as $location){
            $document = DB::select("SELECT * FROM documents WHERE ID_Document = ?", [$location->ID_Document])[0];
            $auteur = DB::select("SELECT Nom FROM auteur WHERE ID_Auteur = ?", [$document->ID_Auteur])[0];
            $document->Prix=$location->Prix;
            $document->Date_debut=$location->Date_debut;
            $document->Date_fin=$location->Date_fin;
            $document->Type="Loué";
            $document->Auteur=$auteur->Nom;
            $documents_rent[] = $document;
        }

        if($request->choix == "docs_buy"){
            $documents = $documents_buy;
        }
        elseif($request->choix == "docs_rent"){
            $documents = $documents_rent;
        }
        elseif($request->choix == "docs_all"){
            $documents = array_merge($documents_buy, $documents_rent);
        }

        return view('mydocument')->with(['documents' => $documents, 'choix' => $request->choix]);

        // $file->loadHTML('<h1>Test</h1>');
        // return $file->stream();
    }
}