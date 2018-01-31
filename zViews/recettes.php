
<?php session_start(true);  ?>
<?php include "../zBusinness/utilitaire.php" ?>
<?php require_once ("../zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>

<?php /* $a=new utilitaire(); $a->getAllPropertiesOfReservation(date('Y'));*/ ?>
<?php 
     $addresse = $utilitaire->getIp() ; 
     header ("location: http://cicm.cm/cicm/connexion.php" ) ;
     if (isset($_POST['jeton'])){
           
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
<section class='row bg-warning' style=' padding:1em'>
        <div class='col-lg-4'>
            <img style="margin-left: 5em"  src="../img/logo.png" width="55" height="55" alt="">
            <span style="color: #333;">Maison Provincial C.I.C.M </span>
        </div>
        <div class='col-lg-4'></div>
        <div class='col-lg-4'>
                <legend><strong>Bonjour</strong> <?php echo $_SESSION['nom_personne']; ?> 
                <a href="http://cicm.cm/cicm/connexion.php" >
                    <img src="../img/pic-lock.png" width="40px" height="40px"/> 
                </a></legend>
        </div>
</section>


<div class="lineStraight_admin "  ></div>
<!-- <br/> <br/> -->
<section class='container- text-center' id='container-recettes'>

      <div class='row '  id='bloc-periode' >
           <div class='col-lg-4'> 
                <span style='font-weight:bold; font-size:1.2em; color:#555'> Période de visualation </span  >     
           </div>
           <div class='col-lg-3'> 
                <input type='date' placeholder='Début' class='form-control' />
           </div>
           <div class='col-lg-3'  >  
                <input type='date' placeholder='Fin'  class='form-control'/>
           </div>
      </div>
</section>

<section class='container- text-center' id='container-custmers' style='height:570px; overflow:auto'>

      <div class='row '  id='bloc-customers' >
           <div class='col-lg-1'> 
           </div>
           <div class='col-lg-10'> 
                <table class='table table-bordered'>
                    <tr> <th>Noms du client </th> <th>Nationalité</th> <th>Indice de régularité</th> <th> Valeur des recettes  </th><th width='10px'>Etat</th></tr>
                    <tr> <td>John doe </td> <td> Cameroun</td> <td> 5</td> <td> 620400 </td> <td><strong style='font-size:1.1em'> + <strong> </td> </tr>
                    <tr> 
                        <td></td>
                        <td colspan='4'>
                            <table class='table table-bordered '>
                                <tr> <th>Date</th>  <th>Code</th>  <th>Nom du service</th> <th> Quantité </th> <th>Montant</th> </tr>
                                <tr> <td>01/01/2017</td> <td>pedj</td> <td>Petit dejeuner 1500</td> <td>4</td> <td>6005000</td> </tr>
                                <tr> <td>01/01/2017</td> <td>pedj</td> <td>Petit dejeuner 1500</td> <td>4</td> <td>6005000</td> </tr>
                                <tr> <td>01/01/2017</td> <td>pedj</td> <td>Petit dejeuner 1500</td> <td>4</td> <td>6005000</td> </tr>
                                <tr> <td>01/01/2017</td> <td>pedj</td> <td>Petit dejeuner 1500</td> <td>4</td> <td>6005000</td> </tr>
                            
                            </table>
                        </td> 
                    </tr>
                    <tr> <td>John doe </td> <td> Cameroun</td> <td> 5</td> <td> 620400 </td> <td><strong style='font-size:1.1em'> + <strong> </td> </tr>
                    <tr> 
                        <td></td>
                        <td colspan='4'>
                           
                        </td> 
                    </tr>
                    <tr> <td>John doe </td> <td> Cameroun</td> <td> 5</td> <td> 620400 </td> <td><strong style='font-size:1.1em'> + <strong> </td> </tr>
                    <tr> 
                        <td></td>
                        <td colspan='4'>
                            
                        </td> 
                    </tr>
                </table>
           </div>
           <div class='col-lg-1'> 
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
        }
?>
