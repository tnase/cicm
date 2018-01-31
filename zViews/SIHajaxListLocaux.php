<?php

$champ = array (" code_service","standing","prix_unitaire","statut","prix_achat");
    $table = "services" ;
    $clausesChambres = array(" services.categorie='chambre'"  ," services.desription='pivot'");
    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
    $resultSetChambres=$instance->pdo->query($queryChambres);
    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
    $i=0;
    while($p=$resultSetChambres->fetch()){
        if ($p->statut=="libre"){
            echo "<tr>" ;
                echo"<th scope=row ><input type='checkbox' id=".str_replace(".","-",$p->code_service)." name=idChambre".$i." value=".$p->code_service." ></th>" ;
                echo"<td  prix-achat-directive='".$p->prix_achat."' ><u>".$p->code_service."</u></td>" ;
                echo"<td>".$p->standing."</td>" ;
                echo"<td>".$p->prix_unitaire."</td>" ;
                echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
            echo "</tr>" ;
        } else if ($p->statut=="occupee"){
                echo "<tr>" ;
                echo"<th scope=row ><input type='checkbox'  id=".str_replace(".","-",$p->code_service)." name=idChambre".$i." value=".$p->code_service."  ></th>" ;
                echo"<td ><u>".$p->code_service."</u></td>" ;
                echo"<td>".$p->standing."</td>" ;
                echo"<td>".$p->prix_unitaire."</td>" ;
                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
            echo "</tr>" ; 
        }else if ($p->statut=="indisponible"){
            echo "<tr>" ;
                echo"<th scope=row ><input type='checkbox' name=idChambre".$i." id=".str_replace(".","-",$p->code_service)." value=".$p->code_service." id=".$p->code_service."></th>" ;
                echo"<td ><u>".$p->code_service."</u></td>" ;
                echo"<td>".$p->standing."</td>" ;
                echo"<td>".$p->prix_unitaire."</td>" ;
                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
            echo "</tr>" ;
        }
        $i++;
    }

    ?>