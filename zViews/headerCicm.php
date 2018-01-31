<section class='row bg-warning' style='border:1px solid red; padding:1em'>
        <div class='col-lg-4'>
            <img style="margin-left: 5em"  src="../img/logo.png" width="55" height="55" alt="">
            <span style="color: #333;">Maison Provincial C.I.C.M </span>
        </div>
        <div class='col-lg-4'></div>
        <div class='col-lg-4'>
                <legend><strong>Bonjour</strong> <?php echo $_SESSION['nom_personne']; ?> 
                <a href="<?php $utilitaire->getIP()?>/cicm/connexion.php" >
                    <img src="../img/pic-lock.png" width="40px" height="40px"/> 
                </a></legend>
        </div>
</section>
