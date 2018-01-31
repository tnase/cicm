<?php session_start(); ?>

<?php include "zBusinness/utilitaire.php" ?>
<?php require_once ("zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['password'] = $_POST['password'];
    $login = $_SESSION['login'] ;
    $password = $_SESSION['password'] ;
    $rightConnected = $_POST['connection'] ;
    $addresse = $utilitaire->getIP() ; 
    


    if (isset($rightConnected)) {
        
        $retourGlobal = $utilitaire->bCheckIfAccountExist($login , $password) ;
        
        if ($retourGlobal!="undefined"){
            $retour = explode("&&&",$retourGlobal)[0];
            $_SESSION['nom_personne'] = explode("&&&",$retourGlobal)[1];
            
            if ($retour == "secretaire") {
                header ("location: http://cicm.cm/cicm/zViews/fideliser.php" ) ;
            }else if ($retour == "magasinier") {
                header ("location: http://cicm.cm/cicm/zViews/magasinier.php" ) ;
            }else if ($retour == "administrateur") {
                header ("location: http://cicm.cm/cicm/zViews/administration.php" ) ;
            }
        }else header ("location: http://cicm.cm/cicm/connexion.php" ) ;
        
    } 
    
?> 