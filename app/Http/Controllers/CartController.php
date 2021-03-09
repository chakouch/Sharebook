<?php

namespace App\Http\Controllers;

#use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $cartCollection = \Cart::getContent();
        //dd($cartCollection);
        return view('cart')->with(['cartCollection' => $cartCollection]);
    }

    public function store($livre, Request $request){

        $docinfo = DB::select("SELECT * FROM documents WHERE ID_Document = ?", [$livre])[0];

        \Cart::add(array(
            'id' => $livre,
            'name' => $docinfo->Titre,
            'price' => 10,
            'quantity' => 1,
            'attributes' => array(
                'type' => "buy"
            )
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Item is Added to Cart!');
    }

    public function rent($livre, Request $request){

        $docinfo = DB::select("SELECT * FROM documents WHERE ID_Document = ?", [$livre])[0];

        \Cart::remove($livre);
        
        \Cart::add(array(
            'id' => $livre,
            'name' => $docinfo->Titre,
            'price' => $request->cost,
            'quantity' => 1,
            'attributes' => array(
                'type' => "rent",
                'days' => $request->days
            )
        ));

        return redirect()->route('cart.index')->with('success_msg', 'Item is Added to Cart!');
    }

    public function destroy($livre, Request $request){

        \Cart::remove($livre);

        return redirect()->route('cart.index');
    }

    public function valid(){

        session_start();
        
        $cartCollection = \Cart::getContent();

        foreach($cartCollection as $document){

            if($document->attributes->type == "rent"){
                $date_debut = date("Y-m-d");
                $date_fin = date("Y-m-d", time() + 86400 * $document->attributes->days);
                $prix = $document->price;
                $id = $document->id;
                DB::insert("INSERT INTO louer(Prix, Date_debut, Date_fin, ID_Document, ID_Utilisateur) VALUES(?, ?, ?, ?, ?)", [$prix, $date_debut, $date_fin, $id, $_SESSION['id']]);
            }

            if($document->attributes->type == "buy"){
                $date = date("Y-m-d");
                $prix = $document->price;
                $id = $document->id;
                DB::insert("INSERT INTO achat(Prix, ID_Document, ID_Utilisateur, Date) VALUES(?, ?, ?, ?)", [$prix, $id, $_SESSION['id'], $date]);
            }
        }

        // Clearing the cart
        \Cart::clear();

        return redirect()->route('cart.index');
    }

}