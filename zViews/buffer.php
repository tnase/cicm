<?php include "../zBusinness/utilitaire.php" ?>
<?php require_once ("../zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php $a=new utilitaire(); ?>
<?php   
$code="-- undefined CODE --"; $categorie="-- undefined CATEGORY --";  


$annee=date("Y") ;
if (isset($_GET['jeton'])){
  if ($_GET['jeton']=="transmission_progress_date"){
      $annee = $_GET['progress_date']; 
      $code=$_GET['code_chambre'];  
      $categorie = $_GET['categorie_chambre']; 
  }else if ($_GET['jeton']=="transmission_progress_date_salle"){
      $annee = $_GET['progress_date_salle']; 
      $code=$_GET['code_salle'];  
      $categorie = $_GET['categorie_salle'] ;  ;
  } 
}

if (isset($_POST['jeton']) && $_POST['jeton']=="transmission_code") {$code = $_POST['code']; $categorie = $_POST['categorie_chambre']; }  ;
if (isset($_POST['jeton']) && $_POST['jeton']=="transmission_code_salle") {$code = $_POST['code_salle']; $categorie = $_POST['categorie_salle'] ;}  ;
//  echo $code ;  echo $annee; echo $categorie ;




$a->getAllPropertiesOfReservation($annee,$code,$categorie);

if (isset($_GET['jeton']) &&$_GET['jeton']=="transmission_progress_date"){
    include "SIHajaxListLocaux.php" ;
}

if (isset($_GET['jeton']) &&$_GET['jeton']=="transmission_progress_date_salle"){
  include "SIHajaxListLocauxSalles.php" ;
}


if (isset($_POST['jeton']) && $_POST['jeton']=="lecture_chambre"){
  	$data="";
    $fp = fopen("../data.json","w"); 
    fputs($fp, $data); 
    fclose($fp);
    include "SIHajaxListLocaux.php" ;
  }else if (isset($_POST['jeton']) && $_POST['jeton']=="lecture_salle"){
  	$data="";
    $fp = fopen("../data.json","w"); 
    fputs($fp, $data); 
    fclose($fp);
    include "SIHajaxListLocauxSalles.php" ;
  }



?>