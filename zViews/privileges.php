<?php session_start(true);  ?>
<?php include "../zBusinness/utilitaire.php" ?>
<?php require_once ("../zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php /* $a=new utilitaire(); $a->getAllPropertiesOfReservation(date('Y'));*/ ?>
<?php 
     if ($_SESSION['login']){   
     if (isset($_POST['jeton'])){
        if($_POST['jeton']=="remove_personne"){
            $cniPersonne=$_POST['cni_personne']; 
            $utilitaire->bRemovePersonnel($cniPersonne);
            $utilitaire->bGetAllPersonne();
        }
        elseif ($_POST['jeton']=="update_personne") {
            $cniPersonne=$_POST['cni_personne']; 
            $utilitaire->bSelectForUpdatePersonne($cniPersonne);
        }
        elseif ($_POST['jeton']=="bloque_personne") {
            $cniPersonne=$_POST['cni_personne']; 
            $utilitaire->bBloquePersonne($cniPersonne);
            $utilitaire->bGetAllPersonne();
        }
           
      }else if (isset($_POST['registration'])) {
          
        $nom=$_POST['noms'];
        $cni=$_POST['cni'];
        $email=$_POST['email'];
        $contact=$_POST['contact'];
        $login=$_POST['login'];
        $password=$_POST['password'];
        $nationalite=$_POST['nationalite'];
        $role=$_POST['role'];
        $sexe=$_POST['sexe'];
        $addresse=$utilitaire->getIP();
    $utilitaire->bSavePersonnel($cni,$nom,$nationalite,$sexe,"","",$contact,$login,$password,"",$email,$role);
    header ("location:http://cicm.cm/cicm/zViews/privileges.php" ) ;

   }else if(isset($_POST['update'])){
            $nom=$_POST['noms'];
            $cni=$_POST['cni'];
            $email=$_POST['email'];
            $contact=$_POST['contact'];
            $login=$_POST['login'];
            $password=$_POST['password'];
            $nationalite=$_POST['nationalite'];
            $role=$_POST['role'];
            $sexe=$_POST['sexe'];
            $utilitaire->bUpdatingPersonne($cni,$nom,$nationalite,$sexe,"","",$contact,$login,$password,"",$email,$role);
           header ("location: http://cicm.cm/cicm/zViews/privileges.php" ) ;

   }

    else {
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
                <a href="cicm.cm/cicm/connexion.php?signal=destruire_session" >
                    <img src="../img/pic-lock.png" width="40px" height="40px"/> 
                </a></legend>
        </div>
</section>

<div class="lineStraight_admin "  ></div>

<div class='container-fluid-1' id='container-privileges'>
    <br/>
    <div class='row'>
    
        <div class='col-lg-4' id="register-form">
            <!-- Alain Tona 20/01/2018 -->
         <form method="POST" action="privileges.php">
            <table class='table'>
                <tr> <th colspan="2">Enrégistrement d'un personnel de l'hotel </th> </tr>
                <tr>    
                    <td width='160px'>CNI/Passport :</td>  
                    <td><input type='text' class='form-control' name="cni" /></td> 
                </tr>
                <tr> 
                    <td>Noms et prénoms :</td>  
                    <td><input type='text'  class='form-control' name="noms" /></td> 
                </tr>
                <tr> 
                    <td>Nationalité : </td>  
                    <td>
                        <select class='form-control' name="nationalite">
                            <option >Cameroun</option>
                            <option >Burkina-Faso</option>
                            <option >Tchad</option>
                            <option >Guinnee</option>
                            <option >Nigeria</option>
                            <option >Senegal</option>
                            <option >Tunisie</option>
                            <option >Algérie</option>
                        </select>
                    </td> 
                </tr>
                <tr> 
                    <td>Coordonnées :</td>
                    <td>
                        <div class='row'>
                            <div class='col-lg-7'>
                                <input type='text'  class='police-baissee form-control' placeholder='Email' name="email"/>
                            </div>

                            <div class='col-lg-5'>
                                <input type='text'  class='police-baissee  form-control' placeholder='Contact' name="contact"/>
                            </div>    
                        </div>
                    </td>
                     
                </tr>
                <tr> 
                    <td>Sexe :</td>  
                    <td class='text-center'>
                        <input type='radio' name="sexe" value="M" checked> Masculin
                        <input type='radio' name="sexe" value="F"> Feminin
                    </td> 
                </tr>
                <tr> 
                    <td>Login :</td>  
                    <td><input type='text'  class='form-control' name="login" /></td> 
                </tr>
                <tr> 
                    <td>Mot de passe :</td>
                    <td><input type='text' class='form-control'  placeholder='************' name="password"/></td>
                </tr>
                <tr>
                    <td>Rôle :</td>
                    <td>
                        <select class='form-control' name="role">
                            <option>magasinier</option>
                            <option>secretaire</option>
                            <option>administrateur</option>
                        </select>
                    </td>
                </tr>
                
                <tr> 
                    <td colspan='2' class='text-right'>
                        <input type='reset' class='btn btn-warning btn-size' />
                        <input type='submit' class='btn btn-primary btn-size'  name="registration"/>
                    </td>
                </tr>
             </table>
            </form>
            <!-- Alain Tona 20/01/2018 -->
        </div>
        <div class='col-lg-8' style='height:580px; overflow:auto'>
            <table class='table table-bordered table-striped' id='list-users-privileges'> 
                <thead class='table-color-douce'>
                    <tr><th>CNI/Passeport</th> <th>Noms et prénoms</th> <th>Nationalité</th> <th>Contact</th> <th>login</th>  <th>Rôle</th> <th>Options</th> </tr>
                </thead>
                <tbody >
                   <!-- Alain Tona 20/01/2018 -->
                   <?php  $utilitaire->bGetAllPersonne();   ?>
                   <!-- Alain Tona 20/01/2018 -->
                </tbody>    
            </table>
        </div>
    </div>

</div>

<div id='fScreen' title="CICM SYSTEM">
  Voulez vous vraiment supprimer cette personne ??
  <!-- <input type='text'/> -->
</div>

<div id='bScreen' title="CICM SYSTEM">
  Voulez vous vraiment Bloquer cette personne ??
  <!-- <input type='text'/> -->
</div>

<script type="text/javascript" src="../js/SIHmainJs.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<center>
  <nav id="footer" class="navbar navbar-light footer" style="position: fixed;" > 
      <a class="navbar-brand" href="www.sihouse.cm">
          <sub  class="signer"> powered by SIHOUSE  </sub>
      </a>
  </nav>  
</center>
</body>

  <script>
      
      oRemovePersonne("#list-users-privileges tbody tr img:nth-child(1)","#fScreen");
      oUpdatePersonne("#list-users-privileges tbody tr img:nth-child(3)"); 
      oBloquePersonne("#list-users-privileges tbody tr img:nth-child(2)","#bScreen")
     

  </script>
</html>
<?php 
        }}else {
            $addresse = $utilitaire->getIp() ; 
            header ("location: http://cicm.cm/cicm/connexion.php" ) ;
         }
        
?>
