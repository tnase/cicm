<?php session_start(true);  ?>
<?php include_once "zBusinness/persistance.php" ?>
<?php include_once "zBusinness/utilitaire.php" ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php 
    if ($_SESSION['login']){ 
        if (isset($_POST['jeton'])){
            if ($_POST['jeton']=="chargerPrixUnique"){
                $nom_service = $_POST['nom_service'];
                $champ = array ("DISTINCT prix_unitaire","code_service","prix_achat");
                        $table = "services" ;
                        $clause = array("services.nom_service='$nom_service'");
                        $query= $instance->selectBD($table,$champ,$clause);
                        
                        $resultSet=$instance->pdo->query($query);
                        $resultSet->setFetchMode(PDO::FETCH_OBJ);
                        while($p=$resultSet->fetch()){
                            echo $p->prix_unitaire ."#@#".$p->code_service."#@#".$p->prix_achat; 
                        }
            }else if ($_POST['jeton']=="filter_commande"){
            $date_debut=$_POST['date_debut'];
            $date_fin=$_POST['date_fin'];
            $cni_personne = $_POST['cni_personne'] ;
            $champ = array ("DISTINCT personne.nom_personne,personne.cni_personne,services.prix_unitaire*sollicitation.quantite_commandee AS ponderation,sollicitation.date_sollicitation_service");
            $table = "sollicitation,personne,services" ;
            if($cni_personne)
                    $clause = array("sollicitation.date_sollicitation_service between '$date_debut' and '$date_fin'" ," personne.cni_personne='$cni_personne'");
            else $clause = array("sollicitation.date_sollicitation_service between '$date_debut' and '$date_fin'");
            
            $query= $instance->selectBD($table,$champ,$clause);
            $resultSet=$instance->pdo->query($query);
            $resultSet->setFetchMode(PDO::FETCH_OBJ);
                while($p=$resultSet->fetch()){
                    echo "<tr>"; 
                        echo "<th scope='row' style='background:rgba(100,100,15,0.2)'>".$p->nom_personne."</th>";
                        echo "<td>".$p->ponderation."</td>" ;
                        echo "<td>".$p->date_sollicitation_service."</td>";
                    echo "</tr>"; 
                }


            }else if ($_POST['jeton']=="saveCommande"){

                    $obj =  $_POST ;
                    $cniPersonne = $_POST['cni_personne'];
                    $nomPersonne = $utilitaire->bGetNomPersonneByCNI($cniPersonne) ;
                    echo $nomPersonne ;
                    $billString = "<br/>CNI = ". $cniPersonne ;
                    $billString .= "<br/><hr width='68%'/><br/>Bonjour ".$nomPersonne." , Un inventaire de votre commande <br/><br/><br/>";
                    $lTotal = $obj['total_commande'] ;
                    
                    
                    $n = ((int)$obj['nb_enreg']*3)+3 ;   
                    echo "N = ".$n ;
                    $booleenStock="true";
                    $i = 4 ; $j = 0;
                    while ( $i < $n ){
                        $services = $obj["service".$j] ;
                        $quantity = $obj["quantite".$j] ;
                        $uniqprice = $obj["uniqprice".$j] ;
                        $codeService = $obj["serviceCode".$j] ;
                        $prixAchat = $obj["prixachat".$j] ;
                        
                        $oFields = array("code_service","nom_service","cni_personne","date_sollicitation_service","quantite_commandee","prix_unitaire","prix_achat","mois","annee");
                        $oValeurs = array($codeService,$services,$cniPersonne,date("d/m/Y"),$quantity,$uniqprice,$prixAchat,date("m"),date("Y")); 
                        $stock =$utilitaire->bGetQuantiteStock($codeService);
                        $stock-=$quantity;
                        if($stock<0){
                            $booleenStock="false";
                        }
                        else{
                            $instance->insertBD($oFields,$oValeurs,"sollicitation");
                            $utilitaire->bUpdateMajStockAfterVente($codeService,$stock);
                            //echo "Commande enrégistrée !!" ;
                            $billString .=  $services ." x ".$quantity." = ". ($uniqprice*$quantity) ."<br>" ;    
                        }
                        
                        $i += 3;  $j++;
                    }
                    echo "&&".$booleenStock."&&";
                    if ($booleenStock=="true") {
                            $a = new utilitaire();
                            $email = explode("#@#",$a->getCustomerAttributes($cniPersonne))[5];
                        $a->sendMail($email,$email,"Bonjour ".$nomPersonne." / Hello ".$nomPersonne." !!",$billString."<br/>TOTAL : <strong>$lTotal FCFA</strong><br/><br/><br/>CICM vous remercie pour votre confiance, A la prochaine !!","");
                    }
                    
                    
                }else if ($_POST['jeton']=="check_cni_integrity_commandes"){
                    $cni_suggeree = $_POST['cni_personne'];
                    if ($utilitaire->isCNIintoDatabase($cni_suggeree)=="true")
                        echo "ok&&" ;
                    else echo "nok&&" ;
                }
        }
        else {

 ?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <link  rel="stylesheet" href="css/jquery-ui.css" />
</head>
<body>
 
<!--Bar entete -->
<section class='row bg-info' style=' padding:1em'>
        <div class='col-lg-4'>
            <img style="margin-left: 5em"  src="../cicm/img/logo.png" width="55" height="55" alt="">
            <span style="color: #333;">Maison Provincial C.I.C.M </span>
        </div>
        <div class='col-lg-4'></div>
        <div class='col-lg-4'>
                <legend><strong>Bonjour</strong> <?php echo $_SESSION['nom_personne']; ?> 
                <a href="<?php $utilitaire->getIP()?>/cicm/connexion.php" >
                    <img src="../cicm/img/pic-lock.png" width="40px" height="40px"/> 
                </a></legend>
        </div>
</section>

<!-- Fin Bar entete -->
<div class="lineStraight"></div>
<div class="container spacer">

 <!--debut entete CNI-->

    <div style="margin-top: 1em; margin-left: 75%;" class="row">
        <div class="col-xs-4" id="pic-logement-parent">
            <a href="zViews/locaux.php" class="bleu">
            <logement>
                <img id="pic-logement" style="margin-left: 20px;" src="img/house.png" /><br/>
                Logements</logement><br/>
            </a>
        </div>
        <div style="margin-left: 1em" class="col-xs-4" id="pic-commande-parent">
            <a href="#" class="bleu">
            <commandes>
                <img id="pic-commande" style="margin-left: 22px;" src="img/buy.png" /><br/>
                Commandes</commandes><br/>
            </a>
        </div>
        <div style="margin-left: 1em; " class="col-xs-4" >
            <a href="zViews/fideliser.php" class="bleu">
            <fidelites>
                <img id="pic-fidelite" style="margin-left: 22px;" src="img/user.png" /><br/>
                Fidélités</fidelites><br/>
            </a>
        </div>
    </div>
	<div class="row">
		<span  style="color: #036;" id='listener-vente'><a href="#">Rechercher des ventes ......</a></span>
	</div>
	<div class="row" style="margin-top:1em;">
   		<!-- //////////////////// -->
        <div class="col-md-5" style="height:315px; text-align:center"  id='show-splash'>
            <img width='300px' height='300px' src="../img/logo-vec.png"/>
        </div>   

    	<div class="col-md-5" style="height:315px;overflow: auto ; display:none" id='show-ventes' >
                <div style="margin-bottom:5px; text-align:center">
                    <input  id="date-debut" type=text  PLACEHOLDER="mm/jj/aaaa" title="date de debut" >
                    <input type=text id="date-fin" PLACEHOLDER="mm/jj/aaaa" title="date de fin" />
                    <button   type="button"  class="btn btn-success btn-sm "  onclick= "oFilterCommande()" id="btn-filter-commande">filtrer</button>
                </div>
	    		<table class="table table-bordered table-striped">
		            <thead class="bg-info">
		            <tr>
		                <th>Nom & Prenoms</th>
		                <th>Montant(CFA) </th>
                        <th>Date</th>
		            </tr>
		            </thead>
		            <tbody id="commande-filtrer">
                         
                               

                        <?php
                             
                            // $champ = array ("DISTINCT personne.nom_personne,services.prix_unitaire*sollicitation.quantite_commandee AS ponderation,sollicitation.date_sollicitation_service");
                            // $table = "sollicitation,personne,services" ;
                            // $clause = array("sollicitation.date_sollicitation_service between '08/07/2017' and '08/07/2017'");
                            // $query= $instance->selectBD($table,$champ,$clause);
                            // $resultSet=$instance->pdo->query($query);
                            // $resultSet->setFetchMode(PDO::FETCH_OBJ);
                            // while($p=$resultSet->fetch()){
                               
                            //    echo "<tr>"; 
                            //         echo "<th scope='row' style='background:rgba(100,100,15,0.2)'>".$p->nom_personne."</th>";
                            //         echo "<td>".$p->ponderation."</td>" ;
                            //         echo "<td>".$p->date_sollicitation_service."</td>";
                            //    echo "</tr>"; 
                            // }
                        ?>    
                    
                        
                        
                        </tbody>
	        	</table>
    	</div>
        <!-- ///////////////////// -->
    	<div class="col-md-7">
    		<input type="text" list="list-services" class="form-control mb-2 mr-sm-2 mb-sm-0" id="field-services" placeholder="Choisissez un nouveau service svp ...">
            <datalist id="list-services">
                <?php
                    
                    $champ = array ("DISTINCT nom_service","quantite_stock");
                    $table = "services" ;
                    $clause = array (" services.categorie!='chambre' "," services.categorie!='salle'");
                    
                    $query= $instance->selectBD($table,$champ,$clause);
                    echo $query ;
                    $resultSet=$instance->pdo->query($query);
                    $resultSet->setFetchMode(PDO::FETCH_OBJ);
                    while($p=$resultSet->fetch()){
                            
                           echo "<option label='".$p->nom_service. "  [".$p->quantite_stock."]  '>".$p->nom_service."</option>"; 
                    }
                ?>
                
                
            </datalist>
            <input type="hidden" id="zAchat_price" placeholder="Prix achat" value=""/>
            <input type="hidden" id="zUniq_price" placeholder="Prix unitaire" value=""/>
            <input type="hidden" id="zNom_service" placeholder="nom service" value=""/>
            <input type="hidden" id="zQuantity" placeholder="quantity" value="" />
            <input type="hidden" id="zCode_service" placeholder="code service" value=""/>

            <div >Quantite</div>
            <input type="hidden" id='trichZone'/>
            <input type="hidden" id='trichZoneForCode'/>
            <input type='hidden' id='trichZoneForAchatPrice' />
            <form class="form-inline" >
                <input type="number" class="form-control mb-2 mr-sm-2 mb-sm-0" id="field-quantity" placeholder="0" value='0'>
               
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <input type="text" style="width: 13em;" class="form-control" id="field-uniq-price" value='' placeholder="prix pondéré" readonly title="Activer le mode remise en double cliquant sur cette zone !!" >
                </div>
                <span><img  width="35" height="35"  src="img/add1.png " title="Ajouter ce service" id="add-service" /></span>
            </form>

          
            
            <div id="flowToPrint" style="height:200px;overflow: auto">
            <table class="table table-bordered" style="margin-top: 5px;">
                <thead class="bg-warning">
               <tr>
                    <th>CODE</th>
                    <th>Service</th>
                    <th>Quantite</th>
                    <th>Prix</th>
                    <th class="cacher">Actions</th>
                </tr>
                </thead>
                <tbody id='corpsCommande'>
	                <?php
                        if(isset($_GET["jeton"]) && $_GET["jeton"]=="transmission_chambres_for_commandes"){
                            
                            $table="services";
                            $oClauses = array(" quantite_stock < 0");
                    
                            $instance->deleteBD($table,$oClauses);

/////////
                            $champ = array ("*");
                            $table = "services" ;
                            
                            $obj = $_GET ; $i=0;
                            $cni_personne = $_GET["cni_personne"];
                            
                            $concatQuantity = $concatUniqPrice = $concatNomService = $concatCodeService = $concatAchatPrice =""  ;
                            if(isset($cni_personne)){
                                
                                foreach ($obj as $cle => $val){
                                  $idChambre = $val ;
                                   
                                  $clause = array("services.beneficiaire='$cni_personne' "," services.code_service='$idChambre'"," services.desription!='pivot'"," timediff('".date('Y-m-d H:i:s')."',desription) BETWEEN '00:00:00.000000' AND '00:04:00.000000'");
                                  $query= $instance->selectBD($table,$champ,$clause);
                                  $resultSet=$instance->pdo->query($query);
                                  $resultSet->setFetchMode(PDO::FETCH_OBJ);
                                //   print_r($p=$resultSet->fetch()) ;
                                  while($p=$resultSet->fetch()){
                                        
                                        $concatNomService .= "$p->nom_service"."@#@" ;
                                        $concatQuantity .= "$p->quantite_stock"."@#@" ;
                                        $concatUniqPrice .= "$p->prix_unitaire"."@#@" ;
                                        $concatAchatPrice .= "$p->prix_achat"."@#@" ;
                                        $concatCodeService .= "$p->code_service"."@#@" ; 

                                        echo"<div  style='display:block'>";
                                        echo"</div>";
                                        echo"<div style='display:none'><input type='text' class='uio' id='fDateAtt".$i."' title=".$p->date_attribution_service. " value=".$p->date_attribution_service. " >";
                                        echo"<input type='text'  class='uio'  id='fDateLib".$i."' title=".$p->date_liberation_service. " value=".$p->date_liberation_service. " ></div>";
                                        echo "<tr id='corps-commande'>";
                                            echo "<th scope=row style='background: rgba(240, 173, 78, 0.5);'>".$p->code_service."</th>";
                                            echo "<td scope=row id='service'>".$p->nom_service."</td>";
                                            echo "<td id='quantite'></td>";
                                            echo "<td id='prix' title=" . $p->prix_unitaire . ">" . $p->prix_unitaire . "</td>";
                                            echo "<td class='text-center cacher' style='background: rgba(140, 173, 118, 0.3) ;'>";
                                            echo "<img  title=Modifier width=20 height=20  class='btn-edit-commande'  src='img/modifier.png'/>";
                                            echo "<img  width=20 height=20 class='btn-delete-commande' style='margin-left: 15px' src='img/delete.png'/>";
                                            echo "</td>";
                                        echo "</tr>";
                                        $i++;
                                  }
                                  
                                  
                                }
                            }      
                         }
                         if (isset($concatNomService)) echo"<input type='hidden' value='$concatNomService' id='fservAttEnd'>";
                         if (isset($concatCodeService)) echo"<input type='hidden' value='$concatCodeService' id='fcodeAttEnd'>";
                         if (isset($concatQuantity)) echo"<input type='hidden' value='$concatQuantity' id='fqteAttEnd'>";
                         if (isset($concatUniqPrice)) echo"<input type='hidden' value='$concatUniqPrice' id='fpriceAttEnd'>";  
                         if (isset($concatAchatPrice)) echo"<input type='hidden' value='$concatAchatPrice' id='fachatAttEnd'>"; 
                    ?>
           		</tbody>
          </table>
          </div>
          <script> 
                $("#zNom_service").val($("#fservAttEnd").val()); $("#zCode_service").val($("#fcodeAttEnd").val());   $("#zQuantity").val($("#fqteAttEnd").val());   $("#zUniq_price").val($("#fpriceAttEnd").val()); $("#zAchat_price").val($("#fachatAttEnd").val());
          </script>
          <button   type="button"  class="btn btn-success btn-sm btn-same-size" id="btn-reset" >Vider</button>
          <button   type="button"  class="btn btn-primary btn-sm btn-same-size" id="btn-pay">Régler & Imprimer</button>
          <span style="margin-left: 2em; font-size:1.5em" > <u>Prix Total</u> : <strong style="color:blue" id="cout-commande">0</strong> </span>FCFA
    	</div>

        
    </div>
    <input id="zBuffer-cni" type="hidden" value="<?php if(isset($_GET["cni_personne"]) && $_GET["cni_personne"]!="undefined") echo $_GET["cni_personne"]; else echo ""; ?>">
    <div  id="cniModal" title="Confirmez votre CNI svp !!">
            <form>
                <div class="form-group row ">
                    <label class="col-2 col-form-label">CNI</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" value="<?php if(isset($_GET["cni_personne"]) && $_GET["cni_personne"]!="undefined") echo $_GET["cni_personne"]; else echo ""; ?>" id="kCNI" PLACEHOLDER="00000000" >
                        <span id="smsl2"> </span>
                        <span id="codel2"></span>
                    </div>
                </div>
            </form>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" style="color:red;" id="deleteModalLabel">New message</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <img src="img/attention.png" /> <p style="color: red;">Voulez allez supprimer cet article !</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" style="color: blue;" id="editModalLabel">Nouveau message</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row ">
                        <label class="col-2 col-form-label">Quantite</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="number" value="" PLACEHOLDER="5" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Modifier</button>
            </div>
        </div>
    </div>
</div>



</div>



<div id="buffer" type="hidden"></div>
<!--Bar Footer Bar  css assurer par la classe Footer-->
<center>

<nav class="navbar navbar-light footer"  >
    <a class="navbar-brand" href="#">
        <sub  class="signer"> powered by SIHOUSE  </sub>
    </a>
</nav>
<!--Fin Footer bar -->
                        </center>


    <script type="text/javascript" src="js/SIHprinter.js"></script>
    <script type="text/javascript" src="js/jquery.printelement.js"></script>
    <script type="text/javascript" src="js/SIHmainJs.js"></script>
    <script type="text/javascript" src="js/SIHajaxifiying.js"></script>
    <script>
    	redirectToCible_final("logement","locaux.php");  
    	//oExtractFlowForCommands('#btn-printer' , '#flowToPrint' , '.cacher' , 'Message' , 'popup');
        /*oExtractFlowForCommands("#btn-printer" , "#flowToPrintDad" , ".cacher" , "Message" , "popup");*/
        printModalWindow('#cniModal' , 'Confirmez votre CNI svp') ;
        printModalWindow('#editModal' , 'Modifier l\'article ') ;
        oTimesAmount("#field-quantity", "#field-uniq-price");
        oAddService ("#add-service","#flowToPrint tbody");
        oDeleteRowCommande(".btn-delete-commande");
        oDeleteRowCommande(".btn-cancelled");
        oEditRowCommande(".btn-edit-commande");
        oGetCurrentDate("#printer-date-today");
        oNotSubmittingBlankBill();
        oLaodUniqprice("#field-services");
       	//initRecettesJournalieres() ;  
        viderCommande();
        //startCoutCommande ();
         dateBoxOnCommands("#date-debut");
         dateBoxOnCommands("#date-fin");
         oCniLockCommandes();
         purgeBothFieldsCommandes("#field-services","#field-uniq-price","#field-quantity");
         oIntegrityZoneCommandes("#kCNI");
         setDiscountMode ("#field-uniq-price",2,3);
         oShowVentes();

         for(var i=0; i<3; i++){ // seuil facture
            // $("#fDateLib"+i+"").val(inverseDate($("#fDateLib"+i+"").val()));
            // $("#fDateAtt"+i+"").val(inverseDate($("#fDateAtt"+i+"").val()));
            //$("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(3)").css("background","red");
            _da = inverseDateAnglo($("#fDateAtt"+i+"").val());
            _dl = inverseDateAnglo($("#fDateLib"+i+"").val())
            $("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(3)").html(oDateDiff(new Date(_da),new Date(_dl)).day+1);
            //if ($("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(3)").text()>=1)
            $("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(4)").html($("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(3)").text()*$("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(4)").text());
            
             if ($("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(3)").text()=="0" ){
                   $("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(3)").text("1");
                   $("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(4)").text($("#flowToPrint tbody tr:nth-child(" + (i+1) + ") td:nth-child(4)").attr("title"));
                
            }
             oSommeCoutCommande("#cout-commande");
         }
         impressionFacture();
    </script>
</body>
</html>
<?php
    }}
    else {
        $addresse = $utilitaire->getIp() ; 
        header ("location: http://$addresse/cicm/connexion.php" ) ;
     }
?>