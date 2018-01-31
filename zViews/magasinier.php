<?php session_start(true);  ?>
<?php include "../zBusinness/utilitaire.php" ?>
<?php require_once ("../zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php /* $a=new utilitaire(); $a->getAllPropertiesOfReservation(date('Y'));*/ ?>
<?php 
   if ($_SESSION['login']){
     if (isset($_POST['jeton'])){
           if($_POST['jeton']=="save_taxonomy"){
              $libelle = $_POST['libelle'] ;
              $utilitaire->bSaveTaxonomy($libelle) ;
              $utilitaire->bGetAllTaxonomy();
           }else if ($_POST['jeton'] == "remove_taxonomy"){
              $codeTaxonomy = $_POST['code_taxonomy'] ;
              $utilitaire->oRemoveTaxonomy($codeTaxonomy) ;
              $utilitaire->bGetAllTaxonomy();
           }else if ($_POST['jeton'] == "search_taxonomy"){
              $subTaxonomy = $_POST['sub_taxonomy'] ;
              $utilitaire->bGetTaxonomyByName($subTaxonomy) ;

           }else if ($_POST['jeton'] == "active_ajaxifing_taxonomy"){
            $libelleTaxonomy = $_POST['libelle_taxonomy'] ;
            $utilitaire->bGetAllProductByTaxonomy($libelleTaxonomy) ;

           }else if ($_POST['jeton'] == "save_produit_with_taxonomy"){
            $libelleTaxonomy = $_POST['libelle_taxonomy'] ;
            $codeService = $_POST['code_service'] ;
            $libelleService = $_POST['libelle_service'] ;
            $statut = $_POST['statut'] ;
            $prixUnitaireAchat = $_POST['prix_unitaire_achat'] ;
            $prixUnitaireVente = $_POST['prix_unitaire_vente'] ;
            $quantite = $_POST['quantite'] ;
            $standing = $_POST['standing'] ;
            $avarie = $_POST['avarie'] ;
            $prixUnitaireAchat = $_POST['prix_unitaire_achat'] ;
            $utilitaire->bSaveProductWithTaxonomy ($codeService,$libelleService,$prixUnitaireVente,$libelleTaxonomy,$statut,$avarie,$standing,$quantite,"pivot","cicm","","","",$prixUnitaireAchat);
            $utilitaire->bGetAllProductByTaxonomy($libelleTaxonomy) ;

           }else if ($_POST['jeton'] == "search_product_by_code"){
              $code_service = $_POST['code_service'] ;
              $nom_service = $_POST['nom_service'] ;
              $utilitaire->bGetProductByCode($code_service,$nom_service) ;
           }else if ($_POST['jeton'] == "search_product_by_name"){
              $categorie_service = $_POST['categorie_service'] ;
              $nom_service = $_POST['nom_service'] ;
              $utilitaire->bGetProductByName($nom_service,$categorie_service) ;
           }else if ($_POST['jeton'] == "remove_product"){
              $code_service         = $_POST['code_service'] ;
              $libelleTaxonomy      = $_POST['categorie_service'] ;
              $utilitaire->bRemoveProduct($code_service) ;
              $utilitaire->bGetAllProductByTaxonomy($libelleTaxonomy) ;
           }


           

           
          
      }else {
?>
           




<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/custom.css" />
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/SIHajaxifiying.js"></script> 
    <script type="text/javascript" src="../js/ajax.js"></script> 
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <link  rel="stylesheet" href="../css/jquery-ui.css" />
</head>
<body>

<!--Bar entete -->
<section class='row bg-success' style=' padding:1em'>
        <div class='col-lg-4'>
            <img style="margin-left: 5em"  src="../img/logo.png" width="55" height="55" alt="">
            <span style="color: #333;">Maison Provincial C.I.C.M </span>
        </div>
        <div class='col-lg-4'></div>
        <div class='col-lg-4'>
                <legend><strong>Bonjour</strong> <?php echo $_SESSION['nom_personne']; ?> 
                <a href="cicm.cm/cicm/connexion.php?signal=destruire_session" >
                    <img src="../img/pic-lock.png" width="40px" height="40px"/> 
                </a></legend>
        </div>
</section>

<div class="lineStraight "  ></div>

  <div class="container-fluid" style="margin-top: 2%;">
    <div class="row">
      <div class="col-xs-6 col-sm-3">
        <div class="form-group">
          <input type="text" class="form-control" id="search-taxonomy" placeholder="Rechercher une categorie" >
          <h5 style="color:cornflowerblue;margin-top: 2%; "> Liste des categories</h5>
          <div id="list-category" style="margin-left: 5%;" class="col-xs-6 ">
            <ul class='list-group'>
                <?php $utilitaire->bGetAllTaxonomy(); ?>
            </ul>  
          </div>
          <button type="button" class="btn btn-success" style="width: 100%;margin-top: 2%;" id="display-category-form">Ajouter des categories</button>
        </div>



        <fieldset id='add-category-container'>
          <form  style="display: none;" id="form-to-add-category">
            <div class="form-group">
              <label for="libelle" >Libellé</label>
              <input type="text" class="form-control" id="libelle" placeholder="libellé" title="Appuyer sur la touche Entree pour AJOUTER">
            </div>
            <div class='text-center'>
              <button   type="button"  class="btn btn-primary btn-sm btn-same-size" id="finish-to-add-category">Fermer</button>
              <button   type="button"  class="btn btn-success btn-sm btn-same-size" id="add-category" >Ajouter</button>
            </div>
            </form>
        </fieldset>



      </div>
      <div class="col-xs-6 col-sm-9" id="tabl-produit" style='height:550px;overflow:auto'>
        <table class="table table-bordered table-striped table-hover" id="table-produits">
          <thead style="background-color: darkseagreen;">
            <!-- <th>#</th> -->
            <th width='15%'><input type='text' class='form-control search-product-background-icon'  placeholder='code' id="product-code"></th>
            <th><input type='text'  class='form-control search-product-background-icon' placeholder='Désignation' id="product-designation"></th>
            <th width='10%'>P.U Achat</th>
            <th width='10%'>P.U Vente</th>
            <th width='10%'>Quantite</th>
            <th width='10%'>Avarie</th>
            <th width='10%' style="display: none;" id="thStanding">Standing</th>
            <th width='10%'>Q. Stock</th>
            
          </thead>
          
          
            <tr id="table-product-form">
              <!-- <td>1</td> -->
              <td><input type='text' placeholder="code du service" id='size-input-text-code'></td>
              <td><input type='text' placeholder="Libellé du service" class='size-input-text-designation' id='libelle-service'></td>
              <td><input type='text'    class='same-size-input-text' id='prix-unitaire-achat'></td>
              <td><input type='text'    class='same-size-input-text' id='prix-unitaire-vente'></td>
              <td><input type='text'    class='same-size-input-text' id='quantite'></td>
              <td><input type='text'    class='same-size-input-text' id='avarie'></td>
              <td id='standing' style="display: none;"><input type='text'    class='same-size-input-text' ></td>
              <td title='Double-cliquez pour régulariser le stock' class='unified-color-bg' ><input type='text '    class='same-size-input-text' readonly style='background:rgba(70, 94, 117, 0.678)' id="qte-stock" value="0"></td>
              <th class='text-center ' style='vertical-align:middle'> <img id='btn-add-produit-taxonomy' src="../img/plus.png" width='40px' height='40px' title="Ajouter un produit"></th>
            </tr>
            <tbody id='tbody-table-produits'>
              
            </tbody>
        </table>
      </div>
      <!-- <div class="col-xs-1 col-sm-1">
      </div> -->
  </div>
</div>

<div class="form-group" style="display: none;" id="nbre-column">
          <label for="code-categorie">Nombre de produits</label>
          <input type="number" class="form-control" id="nbre-produit" placeholder="nombre de produits">
 </div>

 <input type="number" class="form-control" id="test-nbre-produit" style="display: none;">

 <div id='hScreen' title="CICM SYSTEM">
  Choisir l'opération à effectuer !!
</div>


<div id='fScreen' title="CICM SYSTEM">
  Voulez vous vraiment supprimer cette catégorie ??
  <!-- <input type='text'/> -->
</div>

<script type="text/javascript" src="../js/SIHmainJs.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<center>
  <nav id="footer" class="navbar navbar-light footer" >
      <a class="navbar-brand" href="www.sihouse.cm">
          <sub  class="signer"> powered by SIHOUSE  </sub>
      </a>
  </nav>  
</center>
</body>

  <script>
      oFormCategory("#display-category-form","#form-to-add-category");
      oFinishAddCategory("#finish-to-add-category","#form-to-add-category","#display-category-form");
      oAddCategory("#add-cat")
      // oSubmit("#libelle");
      oAddProduit();
      oUDproduct("#tbody-table-produits tr","#hScreen");
      oSaveTaxonomy("#add-category") ;
      oRemoveTaxonomy("#list-category li span","#fScreen") ;
      oSearchTaxonomy('#search-taxonomy') ;
      oActiveAjaxifingTaxonomy("#list-category li");
      oSaveProduitWithTaxonomy("#btn-add-produit-taxonomy");
      oSearchProductByCode("#product-code");
      oSearchProductByName("#product-designation");
  </script>
</html>
<?php 
        }} else {
          $addresse = $utilitaire->getIp() ; 
          header ("location: http://cicm.cm/cicm/connexion.php" ) ;
       }
      
?>
