<?php session_start(true); ?>
<?php include "zBusinness/utilitaire.php" ?>
<?php require_once ("zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php if (isset($_GET['signal'])) { session_destroy() ; }  ?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/SIHajaxifiying.js"></script> 
    <script type="text/javascript" src="js/ajax.js"></script> 
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <link  rel="stylesheet" href="css/jquery-ui.css" />
</head>
<body>

<!--Bar entete -->
<section class='row bg-primary' style=' padding:1em'>
        <div class='col-lg-4'>
            <img style="margin-left: 5em"  src="../cicm/img/logo.png" width="55" height="55" alt="">
            <span class='text-white'> Maison Provincial C.I.C.M </span>
        </div>
        <div class='col-lg-4'></div>
        <div class='col-lg-4'>
                <legend class='text-white'>Interface d'authentification 
                
        </div>
</section>


<div class="lineStraight "  ></div>




<div  class="container-fluid-prim ">

        <div class='row'>
          
          <div class="col-lg-4">
          </div>

          <div class="col-lg-4">
            <table class='table container-fluid-prim centrage'>
              <tr>
                <td class="centrage ">
                    <center>
                        <br/>
                        <img src='../img/logo-vec.png' width='180px' height='180px' />
                    </center> 
                    <form method="POST" action="SIHauth.php">
                      <table class='table'>
                        <tr> 
                            <td>Identifiant</td> 
                            <td><input type='text' class='form-control' name='login'></td> 
                        </tr>
                        <tr> 
                            <td>Mot de passe </td>
                            <td><input type='password' class='form-control' name='password'></td> 
                        </tr>
                        <tr>
                            <td colspan='2' class='text-center'>
                                <input type='reset' value='Annuler' class='btn btn-default btn-same-size'/>
                                <input class="btn btn-primary btn-same-size" type='submit' name='connection' value='Connecter'/>
                            </td> 
                        </tr>
                      </table>
                    </form>
                </td>
              </tr>
            </table>
            
          </div>

          <div class="col-lg-4">
          </div>
            

        </div>
</div>


<script type="text/javascript" src="js/SIHmainJs.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
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
