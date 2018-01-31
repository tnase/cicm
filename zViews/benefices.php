<?php session_start(true);  ?>
<?php include "../zBusinness/utilitaire.php" ?>
<?php require_once ("../zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php /* $a=new utilitaire(); $a->getAllPropertiesOfReservation(date('Y'));*/ ?>
<?php 
    if ($_SESSION['login']){
     
     if (isset($_POST['jeton'])){

        if($_POST['jeton']=="filtre_caisse"){
            $dateDeb=$_POST['date_debut'];  
            $dateFin=$_POST['date_fin'];
            print_r ($_POST);
            $utilitaire->bGetAmountCaisseChambres($dateDeb,$dateFin); echo"#@#";
            $utilitaire->bGetAmountCaisseSalles($dateDeb,$dateFin);  echo"#@#";
            $utilitaire->bGetAmountCaisseAnnexe($dateDeb,$dateFin);
        }else  if($_POST['jeton']=="caisse_global") {
            echo $utilitaire->bGetAmountCaisseGlobalForPlot(date("Y")) ; echo "@@@";
            echo $utilitaire->bGetAmountCaisseHebergementForPlot(date("Y")) ; echo "@@@";
            echo $utilitaire->bGetAmountCaisseAnnexeForPlot(date("Y")) ; 
            
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
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.canvasjs.min.js"></script>
    <script src="../js/graphics.js"></script>

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
                <a href="cicm.cm/cicm/connexion.php?signal=destruire_session" >
                    <img src="../img/pic-lock.png" width="40px" height="40px"/> 
                </a></legend>
        </div>
</section>



<div class="lineStraight_admin "  ></div>
<!-- <br/> <br/> -->
<section class='container text-center' id='container-stock'>
      <br/>  
      <div class='row'  id='bloc-benefices'>
      
           <div class='col-lg-5' style='margin-top:4em'>
           <strong class='text-info'> période :</strong>  
                <input type='date' id="cDateDeb" >
                <input type='date' id="cDateFin">
                <input type='submit' value='filtrer' class="btn btn-info  " id="btn-filtrer-benefices">
                <legend  class='text-primary'> <u>Caisse hébergement </u> </legend>
                <!-- Période :  
                <input type='date' >
                <input type='date' >
                 -->
                <table class='table '>
                    <tr class='bg-thead'><th>Recettes chambres</th> <th>Recettes salles</th> </tr>
                    <tr>
                        <?php $dDeb = $dFin = $utilitaire->oDateFullWithZeros() ; ?>
                        <?php $utilitaire->bGetAmountCaisseChambres($dDeb , $dFin); ?>
                        <?php $utilitaire->bGetAmountCaisseSalles($dDeb , $dFin); ?>
                    </tr>
                    
                    
                </table>
                
                <legend  class='text-primary' > <u>Caisse services annexes</u> </legend>
                
                <table class='table '>
                    <tr class='bg-thead'><th>Recettes </th></tr>
                    <tr>
                        <?php $dDeb = $dFin = $utilitaire->oDateFullWithZeros() ; ?>
                        <?php $utilitaire->bGetAmountCaisseAnnexe($dDeb , $dFin); ?>
                    </tr>
                    
                    
                </table>
    
    
                <legend class='text-danger'> <u>Caisse prévisionnelle</u> </legend>
                <legend class='text-dark bg-warning'> <strong id='result-recettes'></strong></legend>
    
            </div>
               

           <div class='col-lg-7' id='graphique'>
                <br/><br/><br/><br/>
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
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
     //oPlotGraphic();
     oComputeRecettes() ;
     oFiltrerCaisse("#btn-filtrer-benefices");
     oGetAmountCaisseGlobal ();
     
  </script>
</html>
<?php 
        }
    }else {
        $addresse = $utilitaire->getIp() ; 
        header ("location: http://cicm.cm/cicm/connexion.php" ) ;
     }
?>
