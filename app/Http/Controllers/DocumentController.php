<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DocumentController extends Controller
{
    public function Index(){
    //Restrindre l'accés à cette page au personne non connecté

    // if(!isset($_SESSION['id'])) {
    //         header('Location: errorConnexion.html');
    //         exit;  
    // }

        return view('document');
    }
}