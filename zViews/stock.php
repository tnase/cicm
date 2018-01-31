<?php session_start(true);  ?>
<?php include "../zBusinness/utilitaire.php" ?>
<?php require_once ("../zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php /* $a=new utilitaire(); $a->getAllPropertiesOfReservation(date('Y'));*/ ?>
<?php 
if ($_SESSION['login']){ 
     if (isset($_POST['jeton'])){
         
           if ($_POST['jeton']=='filtrer_services_en_stock'){
               $search_zone = $_POST['search_zone'] ;
               $utilitaire->bGetAllProduitsEnStockSearch($search_zone);
           }else if ($_POST['jeton']=='filtrer_categories_en_stock'){
            $search_zone = $_POST['search_zone'] ;
            $utilitaire->bGetAllCategoriesEnStockSearch($search_zone);
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



<section class='row bg-warning' style=' padding:1em'>
        <div class='col-lg-4'>
            <img style="margin-left: 5em"  src="../img/logo.png" width="55" height="55" alt="">
            <span style="color: #333;">Maison Provincial C.I.C.M </span>
        </div>
        <div class='col-lg-4'></div>
        <div class='col-lg-4'>
                <legend><strong>Bonjour</strong> <?php echo $_SESSION['nom_personne']; ?> 
                <a href="<?php $utilitaire->getIP()?>/cicm/connexion.php?signal=destruire_session" >
                    <img src="../img/pic-lock.png" width="40px" height="40px"/> 
                </a></legend>
        </div>
</section>


<div class="lineStraight_admin "  ></div>
<!-- <br/> <br/> -->
<section class='container text-center' id='container-stock'>
      <br/>  
      <div class='row '  id='bloc-stocks'  style='height:570px; overflow:auto' >
           
           <div class='col-lg-12'>
               <table class='table table-condensed table-striped table-hover' id='table-stock'>
                     
                    <tr class='bg-info'>
                        <th width='15%'> Code </th>
                        <th width='35%'> 
                            <input type='text' id='s-nom-service' placeholder='Désignation du service' list='list-categories' class='form-control'> 
                            <datalist id='list-categories'>
                            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                <?php  $utilitaire->bGetAllServicesForStockIHM()  ?>
                                <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                            </datalist>
                        </th> 
                        <th width='20%'> 
                            <select class='form-control'  id='s-categorie'>
                                <option selected>-- categorie --</option>
                                <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                                <?php $utilitaire->bGetAllCategoriesForStockIHM() ; ?>
                                <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                            </select>    
                        </th>
                        <th> Quantité actuel en stock </th>
                        <th width='15%'> Statut du stock </th>
                    </tr>
                    <tbody id='list-produits-en-stock'>
                        <?php  $utilitaire->bGetAllProduitsEnStock();  ?>
                    </tbody>
               </table> 
           </div>
           
      </div>
</section>

      







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
      oFiltreNomServiceForStock ("#s-nom-service");
      oFiltreCategorieForStock ("#s-categorie");
  </script>
</html>
<?php 
        
        }}else {
            $addresse = $utilitaire->getIp() ; 
            header ("location: http://$addresse/cicm/connexion.php" ) ;
         }
        
?>
