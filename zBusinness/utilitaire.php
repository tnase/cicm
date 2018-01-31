
<?php   

include_once "persistance.php";

    
class utilitaire{
   //public  $instance;


    public  function getAttributes($pkService){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "services" ;
        $clausesChambres = array("services.code_service='$pkService'");
        $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
        $resultSetChambres=$instance->pdo->query($queryChambres);
        $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
        $objStr="";
        if($p=$resultSetChambres->fetch()){
            $objStr=$p->nom_service."#@#".
                    $p->prix_unitaire."#@#".
                    $p->categorie."#@#".
                    $p->statut."#@#".
                    $p->photos."#@#".
                    $p->standing."#@#".
                    $p->quantite_stock."#@#".
                    $p->desription."#@#".
                    $p->beneficiaire."#@#".
                    $p->date_attribution_service."#@#".
                    $p->date_liberation_service."#@#".
                    $p->deliver_service_agent;
        }
       return $objStr;
    }

    
    public function getAllPropertiesOfReservation($annee,$code_service,$categorie){
        $instance=persistance::getInstance('root','','cicm');
        
       // $annee=date("Y") ;
       //$annee="2018";
        $champ = array ("bgcolor","cni_personne","date_attribution_service","date_liberation_service","annee","code_service","categorie");
        $table = "calendrier" ;
        $clause = array(" calendrier.annee='$annee'"," calendrier.code_service='$code_service'"," calendrier.categorie='$categorie'") ; 
        $queryChambres = $instance->selectBD($table,$champ,$clause);
        $resultSetChambres=$instance->pdo->query($queryChambres);
        $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
        $objsTab=[];

        while($p=$resultSetChambres->fetch()){
            $objStr=array(
                'bgcolor'=>$p->bgcolor,
                'cni_personne'=>$p->cni_personne,
                'date_attribution_service'=>$p->date_attribution_service,
                'date_liberation_service'=>$p->date_liberation_service,
                'code_service'=>$p->code_service,
                'categorie'=>$p->categorie
            );
           array_push($objsTab,$objStr);

        }
        //print_r (json_encode($objsTab));
        $data=json_encode($objsTab);
        $fp = fopen("../data.json","w+"); 
        fputs($fp, $data); 
        fclose($fp);
    }

    public function sendMail($oDestinateur,$oDestinataire,$message1,$message2,$now){
        $mail = $oDestinataire;
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn|gmail|yahoo|facebook|outlook).[a-z]{2,4}$#", $mail)) 
        { $passage_ligne = "\r\n";}
        else{ $passage_ligne = "\n";}
        $message_txt =$message1 ;
        $message_html = "<html><head></head><body><b>CICM SYSTEM </b>, ".$message2. "  ".$now.".</body></html>";
        $boundary = "-----=".md5(rand());
        $sujet = "Notification de facture cliente ";
        $header = "From: \"Fuhrer\"".$oDestinateur.$passage_ligne;
        $header.= "Reply-to: \"Fuhrer\"".$oDestinataire.$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
        $message.= $passage_ligne."--".$boundary.$passage_ligne;
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        mail($mail,$sujet,$message,$header);
    }


    public  function getCustomerAttributes($pkCNIpersonne){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "personne" ;
        $clausesChambres = array("personne.cni_personne='$pkCNIpersonne'");
        $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
        $resultSetChambres=$instance->pdo->query($queryChambres);
        $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
        $objStr="";
        if($p=$resultSetChambres->fetch()){
            $objStr=$p->nom_personne."#@#".
                    $p->nationalite."#@#".
                    $p->sexe."#@#".
                    $p->vehicules."#@#".
                    $p->contact."#@#".
                    $p->email."#@#".
                    $p->login."#@#".
                    $p->don."#@#".
                    $p->categorie."#@#".
                    $p->photo;
        }
       return $objStr;
    }



    public function isCNIintoDatabase ($pkCNIpersonne) {
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "personne" ;
        $clausesChambres = array(" personne.cni_personne='$pkCNIpersonne'"," personne.categorie='customer'");
        $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
        $resultSetChambres=$instance->pdo->query($queryChambres);
        $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
        if($p=$resultSetChambres->fetch()){
            if($p->cni_personne==$pkCNIpersonne){
                return "true" ;
            }
            
        }
        return "false";       
    }


    public function D2isGreaterDateD1 ($date1 , $date2){
         $dateSourceJour  = explode ("/",$date1)[1];
         $dateSourceMois  = explode ("/",$date1)[0];
         $dateSourceAnnee = explode ("/",$date1)[2];

         $dateCibleJour  = explode ("/",$date2)[1];
         $dateCibleMois  = explode ("/",$date2)[0];
         $dateCibleAnnee = explode ("/",$date2)[2];
         $pg = $date1 ; $pp = $date2 ;
         if ($dateCibleAnnee > $dateSourceAnnee){
            return $dateCibleAnnee - $dateSourceAnnee ;
            $pg = $date2 ;  
         }
         else if ($dateCibleAnnee < $dateSourceAnnee){
            return -1*($dateSourceAnnee - $dateCibleAnnee) ;
            $pg = $date1 ;
         }else if ($dateCibleAnnee == $dateSourceAnnee){
            if ($dateCibleMois > $dateSourceMois){
                return $dateCibleMois - $dateSourceMois ;
                $pg = $date2 ; 
            } else if ($dateCibleMois < $dateSourceMois){
                return -1*($dateSourceMois - $dateCibleMois) ;
                $pg = $date1 ;
            }else if ($dateCibleMois == $dateSourceMois){
                if ($dateCibleJour > $dateSourceJour){
                    return $dateCibleJour - $dateSourceJour ;
                    $pg = $date2 ; 
                } else if ($dateCibleJour < $dateSourceJour){
                    return -1*($dateSourceJour - $dateCibleJour) ;
                    $pg = $date1 ;
                }   
            }
        }          

    }

    public function oDateFullWithZeros(){
        $mois = date("m"); 
        $jour = date("d");
        $annee = date('Y');
        $date = $jour."/".$mois."/".$annee ; 
        return $date ;
    }

    public function oGetCurrentMonth($param){
        return date($param);
    }


    public function endCompare ($oDate1 , $oDate2){
       if($this->D2isGreaterDateD1($oDate1,$oDate2) >= 0)
            return "true" ;
        else return "false" ;
    }




    public function bSaveTaxonomy ($libelleTaxonomy){
        $instance=persistance::getInstance('root','','cicm');
        $oFields = array("libelle_taxonomy");
        $oValeurs = array($libelleTaxonomy);
        $instance->insertBD($oFields,$oValeurs,"taxonomie");     
    } 


    
    public  function bGetAllTaxonomy(){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "taxonomie" ;
        $queryTax = $instance->selectBD($table,$champ,null);
        $resultSetTax=$instance->pdo->query($queryTax);
        $resultSetTax->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetTax->fetch()){
            echo "<li class='list-group-item' title='".$p->libelle_taxonomy."' >$p->libelle_taxonomy<span id='".$p->code_taxonomy."' style='position:absolute; right:10px'><img src='../img/trash.png' width='20px' height='20px'></span></li>" ;
        }
    }



    public  function oRemoveTaxonomy($codeTaxonomy){
        $instance=persistance::getInstance('root','','cicm');
        $clause = array(" code_taxonomy='$codeTaxonomy'");
        $instance->deleteBD("taxonomie",$clause) ;
    }


    public  function bGetTaxonomyByName($libelleTaxonomySubStr){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "taxonomie" ;
        $clause = array(" libelle_taxonomy LIKE '%$libelleTaxonomySubStr%' ") ;
        $queryTax = $instance->selectBD($table,$champ,$clause);
        $resultSetTax=$instance->pdo->query($queryTax);
        $resultSetTax->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetTax->fetch()){
            echo "<li class='list-group-item' title='".$p->libelle_taxonomy."' >$p->libelle_taxonomy<span id='".$p->code_taxonomy."' style='position:absolute; right:10px'><img src='../img/trash.png' width='20px' height='20px'></span></li>" ;
        }
    }

    public  function bGetAllProductByTaxonomy($libelleTaxonomy){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "services" ;
        $clause = array(" categorie='$libelleTaxonomy' "," desription='pivot' ") ;
        $queryTax = $instance->selectBD($table,$champ,$clause);
        $resultSetTax=$instance->pdo->query($queryTax);
        $resultSetTax->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetTax->fetch()){
            echo "<tr title='".$p->code_service."' id='".$p->code_service."'>";
                echo "<td>".$p->code_service."</td>";
                echo "<td>".$p->nom_service."</td>";
                echo "<td>".$p->prix_achat."</td>";
                echo "<td>".$p->prix_unitaire."</td>";
                echo "<td>".$p->quantite_stock."</td>";
                echo "<td>".$p->photos."</td>";
                if($p->categorie=="chambre"||$p->categorie=="salle"){
                    echo "<td >".$p->standing."</td>";
                }
                echo "<td class='unified-color-bg'>".$p->quantite_stock."</td>";
               
            echo "</tr>";
           
        }
    }


    public function bSaveProductWithTaxonomy ($codeService,$nomService,$prixUnitaire,$categorie,$statut,$photos,$standing,$quantiteStock,$desription,$beneficiaire,$dateAttributionService,$dateLiberationService,$deliverServiceAgent,$prixAchat){
        $instance=persistance::getInstance('root','','cicm');
        $oFields = array("code_service","nom_service","prix_unitaire","categorie","statut","photos","standing","quantite_stock","desription","beneficiaire","date_attribution_service","date_liberation_service","deliver_service_agent","prix_achat");
        $oValeurs = array($codeService,$nomService,$prixUnitaire,$categorie,$statut,$photos,$standing,$quantiteStock,$desription,$beneficiaire,$dateAttributionService,$dateLiberationService,$deliverServiceAgent,$prixAchat);
        $instance->insertBD($oFields,$oValeurs,"services");     
    } 


     public  function bGetProductByCode($codeProductSubStr,$categorieService){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "services" ;
        $clause = array(" desription='pivot' "," categorie='$categorieService' "," code_service LIKE '%$codeProductSubStr%' ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetSer->fetch()){
            echo "<tr>";
                echo "<td>".$p->code_service."</td>";
                echo "<td>".$p->nom_service."</td>";
                echo "<td>".$p->prix_unitaire."</td>";
                echo "<td>267</td>";
                echo "<td>767</td>";
                echo "<td>767</td>";
                echo "<td class='unified-color-bg'>".$p->quantite_stock."</td>";
            echo "</tr>";
        }
    }


    public  function bGetProductByName($designationProductSubStr,$categorieService){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "services" ;
        $clause = array(" desription='pivot' "," categorie='$categorieService' "," nom_service LIKE '%$designationProductSubStr%' ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetSer->fetch()){
            echo "<tr>";
                echo "<td>".$p->code_service."</td>";
                echo "<td>".$p->nom_service."</td>";
                echo "<td>".$p->prix_unitaire."</td>";
                echo "<td>267</td>";
                echo "<td>767</td>";
                echo "<td>767</td>";
                echo "<td class='unified-color-bg'>".$p->quantite_stock."</td>";
            echo "</tr>";
        }
    }

    public  function bRemoveProduct($codeProduct){
        $instance=persistance::getInstance('root','','cicm');
        $clause = array(" code_service='$codeProduct'"," desription='pivot'");
        $instance->deleteBD("services",$clause) ;
    }




     public  function bUpdateMajStockAfterVente($codeServiceCur,$Qte){
        $instance=persistance::getInstance('root','','cicm');
        $table = "services" ;
        $champsWithValues = array(" quantite_stock='$Qte' ");
        $clause = array(" services.desription='pivot' "," services.code_service='$codeServiceCur' ");
        $instance->updateBD($table,$champsWithValues,$clause);
    }

    public  function bGetQuantiteStock($codeService){
            $instance=persistance::getInstance('root','','cicm');
            $champ = array ("*");
            $table = "services" ;
            $clause = array(" desription='pivot' "," code_service='$codeService' ") ;
            $querySer = $instance->selectBD($table,$champ,$clause);
            $resultSetSer=$instance->pdo->query($querySer);
            $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
            if($p=$resultSetSer->fetch()){
                return $p->quantite_stock;
            }
        }
        ///////////////////////////// Alain Tona 20/01/2018 /////////////////////////////////////////

   public function bSavePersonnel ($cniPersonne,$nomPersonne,$nationalite,$sexe,$photos,$vehicules,$contact,$login,$password,$don,$email,$categorie){
    $instance=persistance::getInstance('root','','cicm');
    $oFields = array("cni_personne","nom_personne","nationalite","sexe","photo","vehicules","contact","login","password","don","email","categorie");
    $oValeurs = array($cniPersonne,$nomPersonne,$nationalite,$sexe,$photos,$vehicules,$contact,$login,$password,$don,$email,$categorie);
    $instance->insertBD($oFields,$oValeurs,"personne");     
}   

public  function bGetAllPersonne(){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "personne" ;
        $clause = array(" categorie!='customer' ") ;
        $queryPer = $instance->selectBD($table,$champ,$clause);
        $resultSetPer=$instance->pdo->query($queryPer);
        $resultSetPer->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetPer->fetch()){
            echo "<tr>";
                echo "<th>".$p->cni_personne."</th>";
                echo "<td>".$p->nom_personne."</td>";
                echo "<td>".$p->nationalite."</td>";
                echo "<td>".$p->contact."</td>";
                echo "<td>".$p->login."</td>";
                echo "<td>".$p->categorie."</td>";
            echo "<th><img src='../img/trash.png' width='25%' height='25px' id='".$p->cni_personne."'><img src='../img/attention.png' width='25%' height='25px' title='".$p->cni_personne."'><img src='../img/modifier.png' width='25%' height='25px' title='".$p->cni_personne."'></th>";
               
            echo "</tr>";
           
        }
    }


  public  function bRemovePersonnel($cniPersonnel){
        $instance=persistance::getInstance('root','','cicm');
        $clause = array(" cni_personne='$cniPersonnel' ");
        $instance->deleteBD("personne",$clause) ;
    }   

 public  function bSelectForUpdatePersonne($cniPersonne){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "personne" ;
        $clause = array(" cni_personne='$cniPersonne' ") ;
        $queryTax = $instance->selectBD($table,$champ,$clause);
        $resultSetTax=$instance->pdo->query($queryTax);
        $resultSetTax->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetTax->fetch()){
           echo "<form method='POST' action='privileges.php'>";
           echo "<table class='table'>";
           echo "<tr> <th colspan='2'>Enrégistrement d'un personnel de l'hotel </th> </tr>";
           echo "<tr>";
           echo "<td width='160px'>CNI/Passeport :</td>";
           echo "<td><input type='text' class='form-control' name='cni' value='".$p->cni_personne ."'/></td> ";
           echo "</tr>";
           echo "<tr>";
           echo "<td>Noms et prénoms :</td>";
           echo "<td><input type='text'  class='form-control' name='noms' value='".$p->nom_personne ."'/></td>";
           echo "</tr>";
           echo "<tr>";
           echo "<td>Nationalité : </td>";
           echo "<td>";
           echo "<select class='form-control' name='nationalite' value='".$p->nationalite ."'>
                            <option >Cameroun</option>
                            <option >Burkina-Faso</option>
                            <option >Tchad</option>
                            <option >Guinnee</option>
                            <option >Nigeria</option>
                        </select>";
           echo "  </td> 
                </tr>
                <tr>";
           echo "<td>Coordonnées :</td>
                    <td>
                        <div class='row'>
                            <div class='col-lg-7'>
                                <input type='text'  class='police-baissee form-control' placeholder='Email' name='email' value='".$p->email ."'/>
                            </div>

                            <div class='col-lg-5'>
                                <input type='text'  class='police-baissee  form-control' placeholder='Contact' name='contact' value='".$p->contact ."'/>
                            </div>    
                        </div>
                    </td>
                     
                </tr>"; 
           echo "<tr> 
                    <td>Sexe :</td>  
                    <td class='text-center'>";
                    if($p->sexe=='M'){
                       echo  "<input type='radio' name='sexe' value='M' checked> Masculin
                              <input type='radio' name='sexe' value='F'> Feminin";   
                    }else if($p->sexe=='F'){
                       echo " <input type='radio' name='sexe' value='M'> Masculin
                             <input type='radio' name='sexe' value='F' checked> Feminin";   
                    }  
                     
         echo "</td> 
                </tr>
                <tr> 
                    <td>Login :</td>  
                    <td><input type='text'  class='form-control' name='login' value='".$p->login."' /></td> 
                </tr>
                <tr> 
                    <td>Mot de passe :</td>
                    <td><input type='text' class='form-control'  placeholder='************' name='password'/  value='".$p->password ."'></td>
                </tr>
                <tr>
                    <td>Rôle :</td>
                    <td>";
                    if($p->categorie=="secretaire"){
                        echo "<select class='form-control' name='role'>";
                        echo "<option>secretaire</option>
                            <option>magasinier</option>
                            <option>administrateur</option>
                            <option>Bloquer</option>";
                            echo  "</select></td>";                         
                        }else if($p->categorie=="magasinier"){
                            echo "<select class='form-control' name='role'>";
                                echo " <option>magasinier</option>
                                        <option>secretaire</option>
                                        <option>administrateur</option>
                                        <option>Bloquer</option>";
                                    echo  "</select></td>";
                        }else if($p->categorie=="administrateur"){
                            echo "<select class='form-control' name='role'>";
                                echo "<option>administrateur</option>
                                        <option>magasinier</option>
                                        <option>secretaire</option>
                                        <option>Bloquer</option>";
                                    echo  "</select></td>";
                        }else if($p->categorie=="Bloquer"){
                            echo "<select class='form-control' name='role'>";
                                echo "  <option>Bloquer</option>
                                        <option>administrateur</option>
                                        <option>magasinier</option>
                                        <option>secretaire</option>";
                                echo  "</select></td>";
                        }
                    echo"</td>";
                echo"</tr>";
                echo " <tr> 
                    <td colspan='2' class='text-right'>
                        <input type='reset' class='btn btn-warning btn-size' />
                        <input type='submit' class='btn btn-primary btn-size' value='Modifier'  name='update'/>
                    </td>
                </tr>
             </table>
            </form>";                      
        }
    }


    public  function bUpdatingPersonne($cniPersonne,$nomPersonne,$nationalite,$sexe,$photos,$vehicules,$contact,$login,$password,$don,$email,$categorie){
        $instance=persistance::getInstance('root','','cicm');
        $table = "personne" ;
        $champsWithValues = array(" cni_personne='$cniPersonne' ", "nom_personne='$nomPersonne'", "nationalite='$nationalite'", " sexe='$sexe' ", "photo='$photos' " , "vehicules='$vehicules' ","contact='$contact' ","login='$login' ","password='$password' ","don='$don' ","email='$email' ","categorie='$categorie' " );
        $clause = array(" personne.cni_personne='$cniPersonne' ");
        $instance->updateBD($table,$champsWithValues,$clause);
    }

  public  function bBloquePersonne($cniPersonne){
        $instance=persistance::getInstance('root','','cicm');
        $table = "personne" ;
        $champsWithValues = array(" categorie='Bloquer' ");
        $clause = array(" personne.cni_personne='$cniPersonne' ");
        $instance->updateBD($table,$champsWithValues,$clause);
    }


  
    public function bGetAllProduitsEnStock(){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "services" ;
        $clause = array(" desription='pivot' ORDER BY quantite_stock ASC") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        while ($p=$resultSetSer->fetch()){
            if ($p->quantite_stock==0)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-danger text-white'> Rupture de stock</td></tr>" ;
            else if ($p->quantite_stock<=5)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-warning text-white'> Rupture imminente</td></tr>" ;
            else if ($p->quantite_stock>=6 && $p->quantite_stock<=15)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-success text-white'> Stock en épuisement</td></tr>" ;
            else
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-default'> Stock fourni </td></tr>" ; 
        
        }
    }


    public  function bGetAllCategoriesForStockIHM(){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("DISTINCT categorie");
        $table = "services" ;
        $clause = array(" desription='pivot' ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetSer->fetch()){
            echo "<option>".$p->categorie."</option>";
        }
    }


    public  function bGetAllServicesForStockIHM(){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("DISTINCT nom_service");
        $table = "services" ;
        $clause = array(" desription='pivot' ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        while($p=$resultSetSer->fetch()){
            echo "<option>".$p->nom_service."</option>";
        }
    }

    public function bGetAllProduitsEnStockSearch($nomService){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "services" ;
        $clause = array(" desription='pivot' "," nom_service LIKE '$nomService%' ORDER BY quantite_stock ASC") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        while ($p=$resultSetSer->fetch()){
            if ($p->quantite_stock==0)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-danger text-white'> Rupture de stock</td></tr>" ;
            else if ($p->quantite_stock<=5)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-warning text-white'> Rupture imminente</td></tr>" ;
            else if ($p->quantite_stock>=6 && $p->quantite_stock<=15)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-success text-white'> Stock en épuisement</td></tr>" ;
            else
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-default'> Stock fourni </td></tr>" ; 
        
        }
    }



    public function bGetAllCategoriesEnStockSearch($categorie){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "services" ;
        $clause = array(" desription='pivot' "," categorie LIKE '$categorie%' ORDER BY quantite_stock ASC") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        while ($p=$resultSetSer->fetch()){
            if ($p->quantite_stock==0)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-danger text-white'> Rupture de stock</td></tr>" ;
            else if ($p->quantite_stock<=5)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td  class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-warning text-white'> Rupture imminente</td></tr>" ;
            else if ($p->quantite_stock>=6 && $p->quantite_stock<=15)
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-success text-white'> Stock en épuisement</td></tr>" ;
            else
                echo "<tr><th class='bg-info'>".$p->code_service."</th> <td class='text-right'>".$p->nom_service."</td> <td class='text-left'>".$p->categorie."</td>  <td> ".$p->quantite_stock."</td> <td class='bg-default'> Stock fourni </td></tr>" ; 
        
        }
    }
   
   
    

    public function bGetAmountCaisseChambres ($dateDebut , $dateFin){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("SUM(sollicitation.prix_unitaire) AS recettes");
        $table = "sollicitation,services" ;
        $clause = array(" sollicitation.code_service=services.code_service ", " services.desription='pivot' "," sollicitation.date_sollicitation_service between '$dateDebut' AND '$dateFin' ", " services.categorie='chambre' ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
            if ($resultSetSer->fetch()->recettes==null)
                 echo "<td  id='recettes-chambres'>0</td>";
            else {
                $querySer = $instance->selectBD($table,$champ,$clause);
                $resultSetSer=$instance->pdo->query($querySer);
                $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
                echo "<td  id='recettes-chambres'>".$resultSetSer->fetch()->recettes."</td>";
                }
     
    }
   
    

    public function bGetAmountCaisseSalles ($dateDebut , $dateFin){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("SUM(sollicitation.prix_unitaire) AS recettes");
        $table = "sollicitation,services" ;
        $clause = array(" sollicitation.code_service=services.code_service ", " services.desription='pivot' "," sollicitation.date_sollicitation_service between '$dateDebut' AND '$dateFin' ", " services.categorie='salle' ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        if ($resultSetSer->fetch()->recettes==null)
           echo "<td  id='recettes-salles'>0</td>";
        else {
            $querySer = $instance->selectBD($table,$champ,$clause);
            $resultSetSer=$instance->pdo->query($querySer);
            $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
            echo "<td  id='recettes-salles'>".$resultSetSer->fetch()->recettes."</td>";
            }
        
        
    }
   
          
    public function bGetAmountCaisseAnnexe ($dateDebut , $dateFin){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("SUM(sollicitation.prix_unitaire) AS recettes");
        $table = "sollicitation,services" ;
        $clause = array(" sollicitation.code_service=services.code_service ", " services.desription='pivot' "," sollicitation.date_sollicitation_service between '$dateDebut' AND '$dateFin' ", " services.categorie!='salle' ", " services.categorie!='chambre' ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        if ($resultSetSer->fetch()->recettes==null)
           echo "<td  id='recettes-annexes'>0</td>";
        else {
            $querySer = $instance->selectBD($table,$champ,$clause);
            $resultSetSer=$instance->pdo->query($querySer);
            $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
            
            echo "<td  id='recettes-annexes'>".$resultSetSer->fetch()->recettes."</td>";
            }
        
    }
            
      
    public function bGetAmountCaisseGlobalForPlot ($annee){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("mois","SUM(sollicitation.prix_unitaire) AS recettes");
        $table = "sollicitation" ;
        $clause = array("annee='$annee' GROUP BY mois ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        $echo="";
        while ($p=$resultSetSer->fetch()){
            $echo .= $p->recettes . "###" ; 
        }
        $nb = mb_substr_count($echo,"###") ;
        return ($nb+1)."###".$echo ;  
        
    }
     
    
    public function bGetAmountCaisseHebergementForPlot ($annee){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("mois","SUM(sollicitation.prix_unitaire) AS recettes" );
        $table = "sollicitation,services" ;
        $clause = array(" sollicitation.code_service=services.code_service "," services.desription='pivot' ","( services.categorie='chambre' OR  services.categorie='salle' )"," annee='$annee' GROUP BY mois ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        // print_r($querySer) ;
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        $echo="";
        while ($p=$resultSetSer->fetch()){
            $echo .= $p->recettes . "###" ; 
        }
        $nb = mb_substr_count($echo,"###") ;
        return ($nb+1)."###".$echo ;  
        
    }

    public function bGetAmountCaisseAnnexeForPlot ($annee){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("mois","SUM(sollicitation.prix_unitaire*quantite_commandee) AS recettes" );
        $table = "sollicitation,services" ;
        $clause = array(" sollicitation.code_service=services.code_service "," services.desription='pivot' "," services.categorie!='chambre' AND  services.categorie!='salle' "," annee='$annee' GROUP BY mois ") ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        // print_r($querySer) ;
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        $echo="";
        while ($p=$resultSetSer->fetch()){
            $echo .= $p->recettes . "###" ; 
        }
        $nb = mb_substr_count($echo,"###") ;
        return ($nb+1)."###".$echo ;  
        
    }

    
    public  function bGetAllServicesForUser(){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("DISTINCT nom_service","prix_unitaire","standing");
        $table = "services" ;
        $clause = array(" desription='pivot' " ) ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        
        while($p=$resultSetSer->fetch()){
            echo "<tr>
                    <td width='50%' class='text-right'>".$p->nom_service."<td> 
                    <td class='text-left'>".$p->prix_unitaire."<td> 
                    <td class='text-left'>".$p->standing."<td> 
                </tr>";
        }
        
    }


    public function getIP() {
        $ip = $_SERVER['SERVER_ADDR'];

        if (PHP_OS == 'WINNT'){
            $ip = getHostByName(getHostName());
        }

        if (PHP_OS == 'Linux'){
            $command="/sbin/ifconfig";
            exec($command, $output);

            $pattern = '/inet addr:?([^ ]+)/';

            $ip = array();
            foreach ($output as $key => $subject) {
                $result = preg_match_all($pattern, $subject, $subpattern);
                if ($result == 1) {
                    if ($subpattern[1][0] != "127.0.0.1")
                    $ip = $subpattern[1][0];
                }

            }
        }

        return $ip;
    }


    
    public  function bCheckIfAccountExist($login , $password){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "personne" ;
        $clause = array(" login='$login' "," password='$password' "," categorie!='bloquer' " ) ;
        $querySer = $instance->selectBD($table,$champ,$clause);
        $resultSetSer=$instance->pdo->query($querySer);
        $resultSetSer->setFetchMode(PDO::FETCH_OBJ);
        if($p=$resultSetSer->fetch()){
            if($p->login==$login && $p->password==$password) return $p->categorie ."&&&".$p->nom_personne;
        }else return "undefined" ;
    }


    public  function bGetNomPersonneByCNI($cni){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "personne" ;
        $clause = array(" cni_personne='$cni' ") ;
        $queryPer = $instance->selectBD($table,$champ,$clause);
        $resultSetPer=$instance->pdo->query($queryPer);
        $resultSetPer->setFetchMode(PDO::FETCH_OBJ);
        if ($p=$resultSetPer->fetch()){
            echo $p->nom_personne."####";
        }
    }

}



 $a = new utilitaire();
 echo $a->bGetAmountCaisseHebergementForPlot ("2018");

?>