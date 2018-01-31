<?php

require_once("conn.php");

$personnes=array();
$query=$pdo->query("SELECT * FROM personne WHERE personne.categorie='customer' order by nom_personne ASC " );
while($all=$query->fetch())
{
    $personnes[]=$all;
}

foreach($personnes as $personne)
{
   
    ?>

    <table class="table table-bordered table-striped" >
        <tr >
            <td><photo><img src="../img/<?php  echo $personne['photo']  ?>"  width="20px" height="20px" style="border-radius: 3em"></photo></td>
            <td class="nomP" ><nom><?php  echo $personne['nom_personne'] ?></nom></td>
            <td><nationalite><?php  echo $personne['nationalite'] ?></nationalite></td>
            <td><contact><?php  echo $personne['contact'] ?></contact></td>
            <td><email><?php  echo $personne['email'] ?></contact></td>
            <td><vehicules><?php  echo $personne['vehicules'] ?></vehicules></td>
            <td>
                <img  title="éditer ses informations" width=20 height=20   class="btn-edit-customer"     name-customer-directive=<?php echo $personne['nom_personne'] ?> id-customer-directive=<?php echo $personne['cni_personne'] ?>  src='../img/modifier.png'/>&nbsp;&nbsp;&nbsp;
                <img  title="supprimer ce client"     width=20 height=20   id="btn-delete-customer"      name-customer-directive=<?php echo $personne['nom_personne'] ?> id-customer-directive=<?php echo $personne['cni_personne'] ?>  src='../img/trash.png'/>
            </td>
        </tr>
    </table>

  <?php
}

?>

