<?php
   //Permet de garder les variables de la session
   session_start();
   //Connexion à notre base de donnée
   $bdd = new PDO('mysql:host=ls-0f927a463e6d389cf0f567dc4d5a58f8ca59fcd7.cq7na6hxonpd.eu-central-1.rds.amazonaws.com;dbname=ShareBook', 'sharebookuser', 'uA?BL6P8;t=P-JKl)]Su>L3Gj$[mz0q]');
   
   //Restrindre l'accés à cette page au personne non connecté
    if(!isset($_SESSION['id'])) {
   
            header('Location: errorConnexion.html');
            exit;
         
      }
   
   



   $query= "SELECT * FROM documents WHERE ID_Document = '".$id."' ORDER BY Validateur DESC LIMIT 0,5 ";

   $commentaire = $bdd->query($query);
   
   $docs = $bdd->prepare('SELECT ID_Document FROM documents');
   $docs->execute();
   $id_docs = $docs->fetchAll();
   
   $ids = array();
   foreach($id_docs as $result) { 
   //  echo $result['ID_Document'], '<br>'; 
     array_push($ids, $result['ID_Document']);
   }
   
   if (!in_array($id, $ids)) { 
   
     header('Location: document.php');
     exit;
   }
   
   if(isset($id) AND $id > 0) {
      $get_id_doc = intval($id);
      $req_doc = $bdd->prepare('SELECT * FROM documents WHERE ID_Document = ?');
      $req_doc->execute(array($get_id_doc));
      $docinfo = $req_doc->fetch();
   
   
   if(isset($_POST['formupload'])) {
     $req_valudation = $bdd->prepare('INSERT INTO documents(Titre, Nombre_Pages, Resume, Date_Parution, Chemin, Image, Date_soumission, ID_Auteur, ID_Types, ID_Editeur, ID_Collection, ID_Utilisateur, ID_Langue) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)');
     $req_valudation->execute(array($nom_ouvrage, $page, $resume, $date_parution, $file_dest, $miniature_dest, $date, $id_auteur, $id_type, $id_editeur, $id_collection, $id_user, $langue));
   
   /*  echo "\nPDOStatement::errorInfo():\n";
     $arr = $req_valudation->errorInfo();
     print_r($arr);*/
   }

   }
   
   ?>
<html>
   <head>
      <title>SmartDoc - Validation ouvrage</title>
      @include('includes.navbar')
   </head>
   <body>

      <div class="">
         <div class="animated bounceInDown delay-100ms">
            <br /><br />
            <?php 
               $req_auteur = $bdd->prepare('SELECT Nom FROM auteur WHERE ID_Auteur = ?');
               $req_auteur->execute(array($docinfo['ID_Auteur']));
               $auteur = $req_auteur->fetch();
               
               $req_genre = $bdd->prepare('SELECT ID_Genre FROM genre_Documents WHERE ID_Document = ?');
               $req_genre->execute(array($docinfo['ID_Document']));
               $ids_du_genre = $req_genre->fetchAll();
               
               $ids_du_genre_list = array();
               
               foreach($ids_du_genre as $result) { 
                 //echo $result['ID_Genre'], '<br>'; 
                 array_push($ids_du_genre_list, $result['ID_Genre']);
               }
               
               
               
               $req_types = $bdd->prepare('SELECT Nom FROM types WHERE ID_Types = ?');
               $req_types->execute(array($docinfo['ID_types']));
               $types = $req_types->fetch();
               
               $req_editeur = $bdd->prepare('SELECT Nom FROM editeur WHERE ID_Editeur = ?');
               $req_editeur->execute(array($docinfo['ID_Editeur']));
               $editeur = $req_editeur->fetch();
               
               $req_collection = $bdd->prepare('SELECT Nom FROM collection WHERE ID_Collection = ?');
               $req_collection->execute(array($docinfo['ID_Collection']));
               $collection = $req_collection->fetch();
               
               $req_collection = $bdd->prepare('SELECT Nom FROM collection WHERE ID_Collection = ?');
               $req_collection->execute(array($docinfo['ID_Collection']));
               $collection = $req_collection->fetch();
               
               $req_langue = $bdd->prepare('SELECT Nom_Court FROM langues WHERE ID_Langue = ?');
               $req_langue->execute(array($docinfo['ID_Langue']));
               $langue = $req_langue->fetch();
               
               ?> 
         </div>
      </div>
      <div class="container-fluid">
      <h3 class="text-dark mb-4">Titre de l'ouvrage : <?php echo $docinfo['Titre']; ?></h3>
      <div class="row mb-3">
         <div class="col-lg-4">
            <div class="card mb-3">
               <div class="card-header py-3">
                  <p class="text-primary m-0 font-weight-bold">Vue miniature</p>
               </div>
               <div class="card-body text-center shadow"><?php echo '<img class="img-fluid" src="'.$docinfo['Image'].'" /> ' ?>
               </div>
            </div>
         </div>
         <div class="col-lg-8">
            <div class="row mb-3 d-none">
               <div class="col">
                  <div class="card text-white bg-primary shadow">
                     <div class="card-body">
                        <div class="row mb-2">
                           <div class="col">
                              <p class="m-0">Peformance</p>
                              <p class="m-0"><strong>65.2%</strong></p>
                           </div>
                           <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                        </div>
                        <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last month</p>
                     </div>
                  </div>
               </div>
               <div class="col">
                  <div class="card text-white bg-success shadow">
                     <div class="card-body">
                        <div class="row mb-2">
                           <div class="col">
                              <p class="m-0">Peformance</p>
                              <p class="m-0"><strong>65.2%</strong></p>
                           </div>
                           <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                        </div>
                        <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i> 5% since last month</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <div class="card shadow mb-3">
                     <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Infos essentielles</p>
                     </div>
                     <div class="card-body">
                        <form>
                           <div class="form-row">
                              <div class="col">
                                 <div class="form-group"><label for="auteur"><strong>Auteur</strong></label></br>
                                    <?php echo $auteur[0]; ?>
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="form-group"><label for="email"><strong>Nombre de pages</strong></label></br><?php echo $docinfo['Nombre_Pages']; ?></div>
                              </div>
                           </div>
                           <div class="form-row">
                              <div class="col">
                                 <div class="form-group"><label for="first_name"><strong>Date de parution</strong></label></br><?php echo $docinfo['Date_Parution']; ?></div>
                              </div>
                              <div class="col">
                                 <div class="form-group"><label for="last_name"><strong>Langue</strong></label> </br>
                                    <?php echo '<img src="./flag/'.$langue[0].'.png" height="25" width="40" />'; ?>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="card shadow">
                     <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Détails sur l'oeuvre</p>
                     </div>
                     <div class="card-body">
                        <form>
                           <div class="form-group"><label for="address"><strong>Résumé</strong></label></br><?php echo $docinfo['Resume']; ?></div>
                           <div class="form-row">
                              <div class="col">
                                 <div class="form-group"><label for="city"><strong>Genre</strong></label></br>
                                    <?php           
                                       foreach($ids_du_genre_list as $result) { 
                                           $genre_affichage = $bdd->prepare('SELECT Nom FROM genre_litteraire WHERE ID_Genre = ?');
                                           $genre_affichage->execute(array($result));
                                           $genre_affichage = $genre_affichage->fetch();
                                           echo $genre_affichage[0].'<br>';
                                       
                                        }
                                       
                                       ?>
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="form-group"><label for="country"><strong>Type</strong></label></br><?php echo $types[0]; ?></div>
                              </div>
                              <div class="col">
                                 <div class="form-group"><label for="country"><strong>Editeur</strong></label></br><?php echo $editeur[0]; ?></div>
                              </div>
                              <div class="col">
                                 <div class="form-group"><label for="country"><strong>Collection</strong></label></br><?php echo $collection[0]; ?></div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card shadow mb-5">
      <div class="card-header py-3">
         <p class="text-primary m-0 font-weight-bold">Vue complète de l'oeuvre</p>
      </div>
      <div class="card-body">
         <center>
            <table id="example" class="table table-striped table-bordered" width=50%>
               <thead>
                  <tr>
                     <th width=33%>Télécharger</th>
                     <?php 
                        if(strtoupper(pathinfo($docinfo['Chemin'], PATHINFO_EXTENSION)) == "PDF"){
                          $path="'".$docinfo['Chemin']."'";
                          echo '<th width=33%>Affichage du document</th>';
                          echo '<th width=33%>Date de parution</th>';
                        }
                        
                        ?>
                  </tr>
               </thead>
               <tbody>
                  <tr>         
                     <?= '<th><form action="'.$docinfo['Chemin'].'" method="POST" target="_blank"><button type="submit">Cliquez ici</button> </form></th>';?>                     <?php 
                        if(strtoupper(pathinfo($docinfo['Chemin'], PATHINFO_EXTENSION)) == "PDF"){
                              echo '<th><iframe src="'.$docinfo['Chemin'].'" id="test" frameborder="0"></iframe></th>';
                              echo '<th><input type="button" id="bt" onclick="print('.$path.')" value="Imprimer le PDF" /></th>';
                          }
                             ?>  
               </tbody>
            </table>
         </center>
      </div>
      <div class="card shadow mb-5">
      <div class="card-header py-3">
         <p class="text-primary m-0 font-weight-bold">Validation de l'oeuvre</p>
      </div>
      <div class="card-body">
         <form>
            <p>Vous valider le document ? :</p>
            <div>
               <input type="radio" id="contactChoice1"
                  name="reponse" value="oui">
               <label for="contactChoice1">Oui</label>
               <input type="radio" id="contactChoice2"
                  name="reponse" value="non">
               <label for="contactChoice2">Non</label>
               <input type="radio" id="contactChoice3"
                  name="reponse" value="refuse">
               <label for="contactChoice2">Refusé</label>
            </div>
         </form>
 <div class="row" style="background-color: white;">
                  <div class="col-lg-6" >
                     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                     <script type="text/javascript">
                        function sendData()
                       {
                        var commentaire = document.getElementById("commentaire").value;
                        var id_document = <?= intval($id); ?>;
                        var id_user = <?= $_SESSION['id']; ?>;
                        
                        var selectedVal = "";
                        var selected = $("input[type='radio'][name='reponse']:checked");
                         if (selected.length > 0) {
                             selectedVal = selected.val();
            /*                 alert(selectedVal);*/
                         }
                         var choix = selectedVal;
                        
                        $.ajax({
                        type: 'post',
                        url: 'commentaire_validation.php',
                        data: {
                        commentaire:commentaire,
                        choix:choix,
                        id_document:id_document,
                        id_user:id_user
                        },
                        success: function (response) {
                          location.reload();
                        
                        }
                        });

                        return false;
                        }
                     </script>
                    
                        <form method="POST" onsubmit="return sendData();">
                        @csrf
                        <div class="form-group">
                           <label for="inputMessage">Votre commentaire</label>
                           <textarea class="form-control" rows="3" id="commentaire" name="commentaire"  placeholder="Votre commentaire"></textarea>
                        </div>
                        <div class="form-group col-md-3" style="float: right;">
                           <input type="submit" name="submit_form" value="Submit">
                        </div>
                        <div class="col-md-6" style="">
                           <h4 class="text section-heading small_title_text animated revealOnScroll fadeInUp" data-animation="fadeInUp=" style="animation-delay: 2s;">Avis des validateurs <i class="fa fa-users fa-1x"></i> :</h4>
                           </br>
                           <div class="container">
                              <table id="example" class="table table-striped table-bordered" style="width:100%">
                                 <thead>
                                    <tr>
                                       <th>Pseudo Validateur</th>
                                       <th>Date dernier check</th>
                                       <th>Commentaire validation</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php while($m = $commentaire->fetch()) { ?>
                                    <tr>
                                       <th><?php
                                          if(strcasecmp($_SESSION['id'], $m['Validateur']) == 0){
                                           echo "Moi";
                                          }
                                          else{
                                           $req_validateur = $bdd->prepare('SELECT Pseudo FROM utilisateur WHERE ID_Utilisateur= ?');
                                           $req_validateur->execute(array($m['Validateur']));
                                           $validateur = $req_validateur->fetch();
                                           //echo $validateur[0];
                                          }
                                            ?> 
                                       </th>
                                       <th><?= $m['Date_dernier_check'] ?></th>
                                       <th><?= $m['Commentaire_Validation'] ?></th>
                                    </tr>
                                    <?php
                                       }
                                       ?>
                                 </tbody>
                              </table>
                              </br>
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
      </div>
      <p class="copyright">ShareBook © 2021</p>
      </div>
      </footer>
   </body>
   <script src="/assets/js/jquery.min.js"></script>
   <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="/assets/js/chart.min.js"></script>
   <script src="/assets/js/bs-animation.js"></script>
   <script src="/assets/js/bs-charts.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
   <script src="/assets/js/jquery-3.3.1.js"></script>
   <script src="/assets/js/jquery.dataTables.min.js"></script>
   <script src="/assets/js/dataTables.bootstrap4.min.js"></script>
   <script src="/assets/js/print.min.js"></script>

   <script>
      //Fonction pour afficher et imprimer les documents PDF
      function print(doc) {
          var objFra = document.createElement('iframe');   // Create an IFrame.
          objFra.style.visibility = "hidden";    // Hide the frame.
          objFra.src = doc;                      // Set source.
          document.body.appendChild(objFra);  // Add the frame to the web page.
          objFra.contentWindow.focus();       // Set focus.
          objFra.contentWindow.print();      // Print it.
      }
   </script>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>