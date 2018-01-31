<?php session_start(true);  ?>
<?php include "../zBusinness/utilitaire.php" ?>
<?php require_once ("../zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php /* $a=new utilitaire(); $a->getAllPropertiesOfReservation(date('Y'));*/ ?>
<?php 
     if ($_SESSION['login']){
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
<section class='row bg-warning' style='padding:1em'>
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
<section class='container text-center' id='container-admin' style='height:650px; overflow:auto'>

      <div class='row'>
            <div class='col-lg-4'>
                <a href='privileges.php'>                    
                    <img src='../img/pics/a-user-icon.png' width='140px' height='140px'>
                    <div class='text-center'>Gestion des privilèges</div> 
                </a>
            </div>
            <div class='col-lg-4'>
                <a href='benefices.php'>                    
                    <img src='../img/pics/a-benefice-icon.png' width='140px' height='140px'>
                    <div class='text-center'>Marges bénéficiaires</div> 
                </a>
            </div>
            <div class='col-lg-4'>
            <a href='stock.php'>                    
                <img src='../img/pics/a-stock-icon.png' width='140px' height='140px'>
                <div class='text-center'>Inventaire du stock</div>
            </a>
            </div>
      </div>


      <div class='row'>
            <!-- <div class='col-lg-4'>
                <a href='recettes.php'>                    
                    <img src='../img/pics/a-ventes-icon.png' width='180px' height='150px'>
                    <div class='text-center'>Recettes</div>
                </a>
            </div> -->
            
            
            <div class='col-lg-4'>
                <a href='fideliser.php'>                    
                    <img src='../img/pics/icon-services-lrg.png' width='140px' height='140px'>
                    <div class='text-center'>Délivrer un service</div> 
                </a>
            </div>
            <div class='col-lg-4'>
                <a href='magasinier.php'>                    
                    <img src='../img/pics/a-appro-icon.png' width='140px' height='140px'>
                    <div class='text-center'>Approvisionnement du stock</div>
                </a>
            </div>
      </div>


      <div class='row'>
            <!-- <div class='col-lg-4'>
                <a href='#'>                    
                    <img src='../img/pics/a-finance-icon.png' width='190px' height='140px'>
                    <div class='text-center'>Monotonie des finances </div>
                </a>
            </div> -->
            <!-- <div class='col-lg-4'>
                <a href='#'>                    
                    <img src='../img/pics/a-travaux-icon.png' width='140px' height='140px'>
                    <div class='text-center'>Réglages généraux </div>
                </a>    
            </div> -->
            <!-- <div class='col-lg-4'>
                <a href='#'>                    
                    <img src='../img/pics/a-aide-icon.png' width='140px' height='140px'>
                    <div class='text-center'>Aide du logiciel</div>
                </a>
            </div> -->
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
  </script>
</html>
<?php 
        }
            
     }else {
        $addresse = $utilitaire->getIp() ; 
        header ("location: http://cicm.cm/cicm/connexion.php" ) ;
     }
     
?>
