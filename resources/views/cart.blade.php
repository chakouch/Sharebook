<?php

//Permet de garder les variables de la session
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sharebook - Panier</title>
    @include('includes.navbar')
</head>

<body class="text-secondary">
    <section style="background: url('assets/img/carousel2.jpg') no-repeat fixed; background-size:cover !important;">
        <div style="background-color: rgba(0, 0, 0, 0.5); opacity: 1">
        <div class="container" style="padding-top: 100px; color: white;height: 600px ">
            <div align="center" class="animated bounceInDown delay-100ms">


            <h1 style="font-size: 100px">ShareBook</h1>
                <p style="font-size: 20px">Fini la paperasse, passez au format digital !</p>

                <a href="#sommaire"><i class="fa fa-arrow-circle-down" style="font-size: 50px" data-bs-hover-animate="flash"></i></a>

            </div>

        </div>
        </div>
    </section>


    <div class="shopping-cart">
    <div class="px-4 px-lg-0">
        <div class="pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="p-2 px-3 text-uppercase">Produits achetés</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Prix</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Quantité</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Supprimer</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $somme = 0;                                        
                                            foreach($cartCollection as $item){
                                                //dd($item->attributes->type);
                                                if($item->attributes->type == "buy"){
                                                    $document = DB::select("SELECT * FROM documents WHERE ID_Document = ?", [$item->id])[0];
                                                    $req_auteur = DB::select("SELECT Nom FROM auteur WHERE ID_Auteur = ?", [$document->ID_Auteur]);
                                                    $auteur = collect($req_auteur[0]);
                                                    $somme += $item->price * $item->quantity;
                                                    echo '
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="p-2"><img src="'.$document->Image.'" alt width="70" class="img-fluid rounded shadow-sm" />
                                                                <div class="ml-3 d-inline-block align-middle">
                                                                    <h5 class="mb-0"><a href="#" class="text-dark d-inline-block align-middle">'.$document->Titre.'</a></h5><span class="text-muted font-weight-normal font-italic d-block">'.$auteur['Nom'].'</span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="border-0 align-middle"><strong>'.$item->price.' €</strong></td>
                                                        <td class="border-0 align-middle"><strong>'.$item->quantity.'</strong></td>
                                                        <td class="border-0 align-middle"><a href="cart/destroy/'.$item->id.'" class="text-dark"><i class="fa fa-trash"></i></a></td>
                                                    </tr>
                                                    ';
                                                }
                                            }
                                    ?>  
                                    
                                </tbody>
                            </table>
                            </br>
                            </br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="p-2 px-3 text-uppercase">Produits loués</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Prix</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Durée de location</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Supprimer</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            foreach($cartCollection as $item){
                                                //dd($item->attributes->type);
                                                if($item->attributes->type == "rent"){
                                                    $document = DB::select("SELECT * FROM documents WHERE ID_Document = ?", [$item->id])[0];
                                                    $req_auteur = DB::select("SELECT Nom FROM auteur WHERE ID_Auteur = ?", [$document->ID_Auteur]);
                                                    $auteur = collect($req_auteur[0]);
                                                    $somme += $item->price * $item->quantity;
                                                    echo '
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="p-2"><img src="'.$document->Image.'" alt width="70" class="img-fluid rounded shadow-sm" />
                                                                <div class="ml-3 d-inline-block align-middle">
                                                                    <h5 class="mb-0"><a href="#" class="text-dark d-inline-block align-middle">'.$document->Titre.'</a></h5><span class="text-muted font-weight-normal font-italic d-block">'.$auteur['Nom'].'</span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="border-0 align-middle"><strong>'.$item->price.' €</strong></td>
                                                        <td class="border-0 align-middle"><strong>'.$item->attributes->days.' jours</strong></td>
                                                        <td class="border-0 align-middle"><a href="cart/destroy/'.$item->id.'" class="text-dark"><i class="fa fa-trash"></i></a></td>
                                                    </tr>
                                                    ';
                                                }
                                            }
                                    ?>  
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row py-5 p-4 bg-white rounded shadow-sm">
                    <div class="col-lg-6">
                        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon de réduction</div>
                        <div class="p-4">
                            <p class="font-italic mb-4">Mettre votre coupon de réduction</p>
                            <div class="input-group mb-4 border rounded-pill p-2"><input type="text" placeholder="Coupon" class="form-control border-0" />
                                <div class="input-group-append border-0"><button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Appliquer coupon</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Résumé de la commande </div>
                        <div class="p-4">
                            <p class="font-italic mb-4">Les frais d’expédition et les frais supplémentaires sont calculés en fonction des valeurs que vous avez entrées.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                                    <h5 class="font-weight-bold"><?php echo $somme."€"; ?></h5>
                                </li>
                            </ul><a href="/cart/valid" class="btn btn-dark rounded-pill py-2 btn-block">Procéder au paiement</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="footer">
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 item text">
                        <h3>ShareBook</h3>
                        <p>Start-up innovante, ShareBook a pour ambition de rendre la connaissance accessible et universel.</p>
                    </div>
                    <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
                </div>
                <p class="copyright">ShareBook © 2021</p>
            </div>
        </footer>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>