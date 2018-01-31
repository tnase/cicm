/**
	Author : Rodrigue Cheumadjeu 
			 Alain Tona
*/

/*@@@@@@@@@@@@@@@@@ Fichier Js contenant la logique fonctionnelle client générique de lapplication @@@@@@@@@@@@@@@@*/

/**
	Fonction d'affichage de la fenêtre modale à isoler et refactoriser
	
*/
function printModalWindow(idModal, title) {




    $(document).on('show.bs.modal', idModal, function(event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this)
        modal.find('.modal-title').text(title)
        modal.find('.modal-body input').val("")

    })
}


/*Cette fonction ne rend un dialogue que si le statut de la chambre est libre */
function oReservationDialogWithConstraint(oForRooms, oColumn, oIdModal, oDpickerField1, oDpickerField2, dStateBusy, dStateFree, dStateUnav, dHTMLkey, dHTMLdirective) {
    $(document).on('click', oColumn, function() {
        if(oForRooms=="ForChambres"){
            var val = $(this).parent().find(dHTMLkey).attr(dHTMLdirective);
            $(oDpickerField1).datepicker({ inline: true });
            $(oDpickerField2).datepicker({ inline: true });
            if (val == dStateBusy) {
                $('#tCode-chambre').val($(this).text());
                oShowDialog5(oColumn, "#occupe");
            }else
            if (val == dStateFree) {
            $('#oBuffer').val($(this).text());
            $('#oPrix-achat').val($(this).attr('prix-achat-directive'));
            
            $('#oBufferChecks').val($('#oBufferChecks').val()+";"+$(this).text());
             var params = "jeton=transmission_code&code="+$(this).text()+"&categorie_chambre="+$("#oCategorie-chambre").text().trim();
             //alert(params);
                ajaxing_native2(params, "POST", "buffer.php", "warningsSuccess", "warningFailure");
                oShowDialog3(oColumn, oIdModal);
			
            } else if (val == dStateUnav) {
                $('#sCode-chambre').val($(this).text());
                oShowDialog4(oColumn, "#unavailable");
            }
        }else if(oForRooms=="ForSalles"){
            
            var val = $(this).parent().find(dHTMLkey).attr(dHTMLdirective);
            $("#datepicker3").datepicker({ inline: true });
            $("#datepicker4").datepicker({ inline: true });
            if (val == dStateBusy) {
                $('#tCode-salle').val($(this).text());
                oShowDialog5(oColumn, "#occupe");
            }else
            if (val == dStateFree) {
            $('#oBuffer-salle').val($(this).text());
            $('#oPrix-achat-salle').val($(this).attr('prix-achat-directive-salle'));

            $('#oBufferChecks-salle').val($('#oBufferChecks-salle').val()+";"+$(this).text());
             var params = "jeton=transmission_code_salle&code_salle="+$(this).text()+"&categorie_salle="+$("#oCategorie-salle").text().trim();
             //alert(params);   
             ajaxing_native2_salles(params, "POST", "buffer.php", "warningsSuccess", "warningFailure");
             oShowDialog3Prim(oColumn, oIdModal);
			
            } else if (val == dStateUnav) {
                $('#sCode-salle').val($(this).text());
                oShowDialog4Prim(oColumn, "#unavailable-salle");
            }
          
        }
        

    });
}





/* Doubler le montant d'un service côté client: Reprendre à cette étape */
function oTimesAmount(oQuantite, oCoutUnitaire) {

    var oOriginalQteValue = $(oQuantite).val();
    $(document).on('change', oQuantite, function() {
        var oAmountOfService = $("#trichZone").val() * $(oQuantite).val();
        $(oCoutUnitaire).val(oAmountOfService);
        
        if ($(oQuantite).val() <= 0) {
            $(oQuantite).val("0");
            $(oCoutUnitaire).val("0");
        }
    });
}



function oExtractFlowForCommands(oListener, oFlowToPrint, oClassToHide, oMessage, oPopup) {
    var $t = $(oFlowToPrint).clone();
    $(oClassToHide).hide();
    printFlow(oListener, oFlowToPrint, oPopup, oMessage);
    //setTimeout(function() {$(oFlowToPrint).html($t);}, 200);

}



function oMisAjourDate(sListener) {
    $(sListener).find('tr').each(function() {
        date1 = new Date($(this).children().eq(2).text());
        date2 = new Date();
        var t = oDateDiff(date1, date2);
        if (!t.day) $(this).children().eq(2).next().text("0 jours ");
        else $(this).children().eq(2).next().text(t.day + "  jours ");
    });
}


function oAddService(oIdService, oRoot) {

    $(document).on('click', oIdService, function() {
        if ($("#field-services").val() != '' && $("#field-uniq-price").val()!='' && $("#field-uniq-price").val()!='0' &&  $("#field-quantity").val()) {
            var tbodyRoot = $(oRoot).html();
            tbodyConnexe = "<tr id='corps-commande'>";
            tbodyConnexe = tbodyConnexe + "<th scope=row id='service' style='background: rgba(240, 173, 78, 0.5);'>" + $("#trichZoneForCode").val() + "</th>";
            tbodyConnexe = tbodyConnexe + "<td scope=row id='service'>" + $("#field-services").val() + "</td>";
            tbodyConnexe = tbodyConnexe + "<td id='quantite'>" + $("#field-quantity").val() + "</td>";
            tbodyConnexe = tbodyConnexe + "<td id='prix'>" + $("#field-uniq-price").val() + "</td>";
            tbodyConnexe = tbodyConnexe + "<td class='text-center cacher' style='background: rgba(140, 173, 118, 0.3);'>";
            tbodyConnexe = tbodyConnexe + "<img  title=Modifier width=20 height=20  class='btn-edit-commande'  src='img/modifier.png'/>";
            tbodyConnexe = tbodyConnexe + "<img  width=20 height=20 class='btn-delete-commande' style='margin-left: 15px' src='img/delete.png'/>";
            tbodyConnexe = tbodyConnexe + "</td>";
            tbodyConnexe = tbodyConnexe + "</tr>";
            $("#flowToPrint tbody").html(tbodyConnexe + tbodyRoot);
            oSommeCoutCommande("#cout-commande");
            $("#zQuantity").val($("#zQuantity").val() + $("#field-quantity").val() + "@#@");
            $("#zNom_service").val($("#zNom_service").val() + $("#field-services").val() + "@#@");
            $("#zCode_service").val($("#zCode_service").val() + $("#trichZoneForCode").val() + "@#@");
            $("#zUniq_price").val($("#zUniq_price").val() + $("#field-uniq-price").val() + "@#@");
            $("#zAchat_price").val($("#zAchat_price").val() + $("#trichZoneForAchatPrice").val() + "@#@");

            $("#field-services").val("");
            $("#field-uniq-price").val("0");
            $("#field-quantity").val("0");
            $("#field-uniq-price").replaceWith("<input type='text' style='width: 13em;' class='form-control' id='field-uniq-price' value='' placeholder='prix pondéré' readonly title='Activer le mode remise en double cliquant sur cette zone !!' >");
            
        } else alert ("Service manquant ou invalide !! ");
    });
    
}

function purgeBothFieldsCommandes (oListener,oCible1,oCible2){
    $(document).on('click', oListener, function() {
        $(oCible1).val("");
        $(oCible2).val("0");
        $(this).val("");
    });
}


function oSommeCoutCommande(oTotal) {
    var som = 0;
    var _SEUIL_ARTICLES = 70; //Le max d'articles sur une commande
    for (var i = 1; i < _SEUIL_ARTICLES; i++) {
        var tmp = $("#flowToPrint tbody tr:nth-child(" + i + ") td:nth-child(4)").text();
        $("#buffer").val(tmp);
        var atmp = parseInt($("#buffer").val());
        if (atmp) {
            som = som + atmp;
        }
        $(oTotal).html(som);
        
    }
    return som ;
}

//fonction qui calcul la difference de date


function oDateDiff(date1, date2) {
    var diff = {}
    var tmp = date2 - date1;
    tmp = Math.floor(tmp / 1000);
    diff.sec = tmp % 60;
    tmp = Math.floor((tmp - diff.sec) / 60);
    diff.min = tmp % 60;
    tmp = Math.floor((tmp - diff.min) / 60);
    diff.hour = tmp % 24;
    tmp = Math.floor((tmp - diff.hour) / 24);
    diff.day = tmp;
    return diff;
}




// oMisAjourDate('tbody');

//Suppression d'une ligne d'articles dans la commande
function oDeleteRowCommande(oListenerClass) {
    $(document).on('click', oListenerClass, function() {
        $(this).parent().parent().remove();
        $("#cout-commande").css("color", "green");
        oSommeCoutCommande("#cout-commande");
    });
}

//Editer une ligne d'articles dans la commande
function oEditRowCommande(oListenerClass) {
    $(document).on('click', oListenerClass, function() {
        var serviceToEdit = $(this).parent().parent().find('#service').html();
        var quantiteToEdit = $(this).parent().parent().find('#quantite').html();
        var prixToEdit = $(this).parent().parent().find('#prix').html();
        $("#field-services").val(serviceToEdit);
        $("#field-quantity").val(quantiteToEdit);
        $("#field-uniq-price").val(prixToEdit);
        $(this).parent().parent().remove();
        oSommeCoutCommande("#cout-commande");
    });
}



// get La date système
function oGetCurrentDate() {
    var now = new Date();
    var day = now.getDate();
    
    var month = now.getMonth() + 1;
    if(month<10)
        month = "0"+month;
    var year = now.getFullYear();
    realDate = day + "/" + month + "/" + year;
    return realDate;
}

function oShowVentes (){
    $(document).on('click', '#listener-vente', function() {
        $('#show-splash').hide();
        $('#show-ventes').show();
    });
}

// Présenter un UI dialogue avancé
function oShowDialog(oListener, oScreen, oMode) {

    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Non": function() {
                $(this).dialog("close");
            },
            "Oui": function() {
                
                var cni_personne = $("#kCNI").val();
                //alert($('#codel2').text()) ;       
                if(cni_personne!=""){  
                    var tQuantities = $("#zQuantity").val();
                    var tServices = $("#zNom_service").val();
                    var cServices = $("#zCode_service").val();
                    var tUniqPrices = $("#zUniq_price").val();
                    var tAchatPrices = $("#zAchat_price").val();
                    var lTotal = $("#cout-commande").text(); 
                    
                    var qteTAB = oUnParseString(tQuantities);
                    var servicesTAB = oUnParseString(tServices);
                    var servicesCodeTAB = oUnParseString(cServices);
                    var uniqPricesTAB = oUnParseString(tUniqPrices);
                    var prixAchatTAB = oUnParseString(tAchatPrices);

                    // Fabrication du query string
                    var params = "";
                    params = "jeton=saveCommande&cni_personne=" + cni_personne + "&total_commande=" + lTotal;
                    var i = 0;
                    var size = qteTAB.length;
                    var temp = "";
                    //alert(size);
                    while (i < size - 1) {
                        temp += "&service" + i + "=" + servicesTAB[i] + "&serviceCode" + i + "=" + servicesCodeTAB[i] + "&quantite" + i + "=" + qteTAB[i] + "&uniqprice" + i + "=" + uniqPricesTAB[i]+ "&prixachat" + i + "=" + prixAchatTAB[i];
                        i++;
                    }
                    params += "&nb_enreg=" + (size - 1);
                    params += temp;
                    // alert(params);
                    ajaxing_save_commande(params, "POST", "index.php", "warningsSuccess", "warningFailure");
                    //var cloneFlowToPrint = $('#flowToPrint').html();
                    //alert($("#flowToPrint tbody tr td:nth-child(4)").html());
                    
                    // $('#flowToPrint').printElement({ leaveOpen: true, printMode: 'popup', pageTitle: 'Facture CICM' });
                    $(this).dialog("close");
                }else alert(" Précisez une CNI valide SVP !!");
                
            }
        }
    });

}


function filtre_statut(oListener, oSearchZone) {
    $(document).on('click', oListener, function() {
        var params = "";
        var search_zone = $(oSearchZone).val();
        params = "jeton=filtrerChambre&search_zone=" + search_zone;
        ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
    });

}

// Présenter un UI dialogue avancé
function oShowDialog1(oListener, oScreen, oMode) {

    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Non": function() {
                $(this).dialog("close");
            },
            "Oui": function() {

                $(this).dialog("close");

            }
        }
    });

}



function hex2rgb(hex) {
        // long version
        r = hex.match(/^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i);
        if (r) {
                return r.slice(1,4).map(function(x) { return parseInt(x, 16); });
        }
        // short version
        r = hex.match(/^#([0-9a-f])([0-9a-f])([0-9a-f])$/i);
        if (r) {
                return r.slice(1,4).map(function(x) { return 0x11 * parseInt(x, 16); });
        }
        return null;
  }


function oShowDialog10(oListener, oScreen,oColor) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Non": function() {
                $(this).dialog("close");
            },
            "Oui": function() {
                $(this).dialog("close");
                $("#dynamic-calendar tbody td").each(function(){
                    var res = hex2rgb(oColor).toString() ; 
                    var par1 = res.split(",")[0] ;
                    var par2 = res.split(",")[1] ;
                    var par3 = res.split(",")[2] ;
                    var RGBcast = "rgb("+par1+", "+par2+", "+par3+")";
                    if( $(this).css("background-color")!="rgba(0, 0, 0, 0)" && $(this).css("background-color")==RGBcast ){
                        var str = $(this).css("background-color") ;
                        
                        var params = "";
                        params ="cni_personne=" +$(this).attr("title") +  "&bgcolor=" +oColor.substring(1) + "&jeton=supprimer_reservation";
                        //alert(params);
                         ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                         $(this).removeAttr("style");
                         $(this).removeAttr("title");

                     }
                });
            }
        }
    });
}

function oShowDialog10Prim(oListener, oScreen,oColor) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Non": function() {
                $(this).dialog("close");
            },
            "Oui": function() {
                $(this).dialog("close");
                $("#dynamic-calendar-salle tbody td").each(function(){
                    var res = hex2rgb(oColor).toString() ; 
                    var par1 = res.split(",")[0] ;
                    var par2 = res.split(",")[1] ;
                    var par3 = res.split(",")[2] ;
                    var RGBcast = "rgb("+par1+", "+par2+", "+par3+")";
                    if( $(this).css("background-color")!="rgba(0, 0, 0, 0)" && $(this).css("background-color")==RGBcast ){
                        var str = $(this).css("background-color") ;
                        
                        var params = "";
                        params ="cni_personne=" +$(this).attr("title") +  "&bgcolor=" +oColor.substring(1) + "&jeton=supprimer_reservation";
                        //alert(params);
                         ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                         $(this).removeAttr("style");
                         $(this).removeAttr("title");

                     }
                });
            }
        }
    });
}


function oShowDialog11(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Quitter": function() {
                $(this).dialog("close");
            }
        }
    });
}

function oChargerLocaux(oListener){
    $(document).on('click',oListener,function(){
        var params = "jeton=lecture_chambre";
        ajaxing_native2(params, "POST", "buffer.php", "warningsSuccess", "warningFailure");
        $("td").each(function(){
            if($(this).css("background-color")!="rgba(0, 0, 0, 0)")
              $(this).css("background-color","rgba(0, 0, 0, 0)"); 
              
        });
    });
}

// Présenter un UI dialogue avancé
function oShowDialog3(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        width : 1250,
        buttons: {
            "Fermer": function() {
                $(this).dialog("close");
                var params = "jeton=lecture_chambre";
                ajaxing_native2(params, "POST", "buffer.php", "warningsSuccess", "warningFailure");
                $("td").each(function(){
                    if($(this).css("background-color")!="rgba(0, 0, 0, 0)")
                      $(this).css("background-color","rgba(0, 0, 0, 0)"); 
                      
                });

            },
            "Travaux": function() {
                var params = "";
                var code_chambre = $("#oBuffer").val();
                params = "code_chambre=" + code_chambre + "&jeton=indisponibleChambre";
                //alert(params);
                ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");

            },
            "Réserver": function() {
                var selecteur1 = $("#oDatepicker1").val();
                var selecteur2 = $("#oDatepicker2").val();
                var date1 = inverseDate(selecteur1) ;
                var date2 = inverseDate(selecteur2) ;
                var t = oDateDiff(new Date(date1), new Date(date2));
                //alert(date1 +" ---- "+date2 + " ---- " + t.day);
                var cni_personne = $("#oCni-personne").val();
                if(selecteur1!="" && selecteur2!="" && cni_personne!="") {
                    selecteur1=inverseDateCalendar(selecteur1);
                    selecteur2=inverseDateCalendar(selecteur2);
                    selecteur1=oDeleteZeroFromDayDate(selecteur1);
                    selecteur2=oDeleteZeroFromDayDate(selecteur2);
                    if(!zChevaucherDate(selecteur1,selecteur2)) {
                        var params = "";
                        var oRGB = fillBusySpaces(selecteur1,selecteur2);
                        var date_attribution =inverseDateTrue($("#oDatepicker1").val());
                        var date_liberation = inverseDateTrue($("#oDatepicker2").val());
                        var code_chambre = $("#oBuffer").val();
                        var quantite_sollicitee = t.day ;
                        var prixAchat = $("#oPrix-achat").val() ;
                        params = "jeton=reserverChambre&cni_personne=" + cni_personne + "&date_attribution=" + date_attribution + "&date_liberation=" + date_liberation + "&code_chambre=" + code_chambre + "&bgcolor=" + oRGB + "&quantite_sollicitee=" + quantite_sollicitee+ "&prix_achat=" + prixAchat;
                        ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                        //$(this).dialog("close");
                    }    
                    else alert("chevauchement de dates , impossible d'effectuer une réservation sur cette plage horaire");
                    
                }else {
                    alert("Certains paramètre(s) sont manquants dans la réservation de la chambre !!");
                }
                
            }
        }
    });

}


function oShowDialog3Prim(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        width:1250,
        buttons: {
            "Fermer": function() {
                $(this).dialog("close");
                var params = "jeton=lecture_salle";
                ajaxing_native_prim(params, "POST", "buffer.php", "warningsSuccess", "warningFailure");
                $("td").each(function(){
                    if($(this).css("background-color")!="rgba(0, 0, 0, 0)")
                      $(this).css("background-color","rgba(0, 0, 0, 0)"); 
                      
                });

            },
            "Travaux": function() {
                var params = "";
                var code_salle = $("#oBuffer-salle").val();
                params = "code_salle=" + code_salle + "&jeton=indisponibleSalle";
                //alert(params);
                ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");

            },
            "Réserver": function() {
                var selecteur1 = $("#datepicker3").val();
                var selecteur2 = $("#datepicker4").val();
                var date1 = inverseDate(selecteur1) ;
                var date2 = inverseDate(selecteur2) ;
                var t = oDateDiff(new Date(date1), new Date(date2));
                var cni_personne = $("#oCni-personne").val();
                if(selecteur1 && selecteur2 && cni_personne) {
                    selecteur1=inverseDateCalendar(selecteur1);
                    selecteur2=inverseDateCalendar(selecteur2);
                    selecteur1=oDeleteZeroFromDayDate(selecteur1);
                    selecteur2=oDeleteZeroFromDayDate(selecteur2);
                    //alert(selecteur1 + "********" + selecteur2);
                    if(!zChevaucherDateSalle(selecteur1,selecteur2)) {
                        var params = "";
                        var oRGB = fillBusySpacesSalles(selecteur1,selecteur2);
                        var date_attribution =inverseDateTrue($("#datepicker3").val());
                        var date_liberation = inverseDateTrue($("#datepicker4").val());
                        var code_salle = $("#oBuffer-salle").val();
                        var quantite_sollicitee = t.day ;
                        var prixAchat = $("#oPrix-achat-salle").val() ;
                        params = "jeton=reserverSalle&cni_personne=" + cni_personne + "&date_attribution=" + date_attribution + "&date_liberation=" + date_liberation + "&code_salle=" + code_salle + "&bgcolor=" + oRGB + "&quantite_sollicitee=" + quantite_sollicitee+ "&prix_achat=" + prixAchat;
                        //alert(params);
                        ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                    } 
                       
                    else alert("chevauchement de dates , impossible d'effectuer une réservation sur cette plage horaire");
                    
                    
                }else {
                    alert("Certains paramètre(s) sont manquants dans la réservation de la chambre !!");
                }

            }
        }
    });

}


function oShowDialog4Prim(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Libérer": function() {
                var params = "";
                var code_salle = $("#sCode-salle").val();

                params = "code_salle=" + code_salle + "&jeton=libererSalle";
                //alert(params);
                ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "quitter": function() {
                $(this).dialog("close");

            }
        }
    });
}



function oShowDialog4(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Libérer": function() {
                var params = "";
                var code_chambre = $("#sCode-chambre").val();

                params = "code_chambre=" + code_chambre + "&jeton=libererChambre";
                //alert(params);
                ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "quitter": function() {
                $(this).dialog("close");

            }
        }
    });
}

function oShowDialog5(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Libérer": function() {
                var params = "";
                var code_chambre = $("#tCode-chambre").val();
                params = "code_chambre=" + code_chambre + "&jeton=libererChambre";
                //alert(params);
                ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "quitter": function() {
                $(this).dialog("close");

            }
        }
    });
}


function oShowDialog5Prim(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Libérer": function() {
                var params = "";
                var code_chambre = $("#tCode-chambre").val();
                params = "code_chambre=" + code_chambre + "&jeton=libererSalle";
                //alert(params);
                ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "quitter": function() {
                $(this).dialog("close");

            }
        }
    });
}



function oNotSubmittingBlankBill() {
    $(document).on('click', "#btn-pay", function() {
        if (!$(this).parent().find("#corps-commande").html()) {
            alert("Commande vide , choisissez au moins un service pour régler !! Merci");
        } else {

            oShowDialog("#btn-pay", "#cniModal", "open");

        }
    });
}


function oLaodUniqprice(oZoneService) {
    $(document).on('blur', oZoneService, function() {
        $("#field-uniq-price").replaceWith("<input type='text' style='width: 13em;' class='form-control' id='field-uniq-price' value='' placeholder='prix pondéré' readonly title='Activer le mode remise en double cliquant sur cette zone !!' >");
        
        var params = "";
        var nom_service = $(oZoneService).val();
        params = "nom_service=" + nom_service + "&jeton=chargerPrixUnique";
        //alert(params);
        ajaxing_commands(params, "POST", "index.php", "warningsSuccess", "warningFailure");
    });
}



function viderCommande() {
    $(document).on('click', "#btn-reset", function() {

        $("#corpsCommande").html("");
        $("#zQuantity").val("");
        $("#zNom_service").val("");
        $("#zUniq_price").val("");
    });
}

function viderCommande_brief() {
    $("#corpsCommande").html("");
    $("#zQuantity").val("");
    $("#zNom_service").val("");
    $("#zUniq_price").val("");
}

function oUnParseString(str) {
    var strToArray = new Array();
    strToArray = str.split("@#@");
    return strToArray;
}


function oShowDialog6(oListener, oScreen) {
    $("#id-delete-confirm-dialog").hide();
    $(document).on('click',oListener,function(){
        $("#message-nom-personne").html($(this).attr("name-customer-directive")) ;
        $("#id-delete-personne").val($(this).attr("id-customer-directive"));
        $(oScreen).dialog({
        modal: true,
        height :200,
        buttons: {
            "OUI": function() {
                var params = "";
                var id_customer_directive = $("#id-delete-personne").val();
                params = "cni_personne=" + id_customer_directive + "&jeton=delete_customer";
                
                ajaxing_customers(params, "POST", "fideliser.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "NON": function() {
                $(this).dialog("close");

            }
        }
    });
    });
    
}


function initUserInfo() {
    //alert($(this).attr("name-customer-directive"));
}



function oShowDialog9(oListener, oScreen) {
    
    $(document).on('click',oListener,function(){
        var nom = $(this).parent().parent().find("nom").text();
        var nationalite = $(this).parent().parent().find("nationalite").text();
        var contact = $(this).parent().parent().find("contact").text();
        var email = $(this).parent().parent().find("email").text();
        var vehicules = $(this).parent().parent().find("vehicules").text();
        var immatriculation = vehicules.split(";")[0];
        var marque = vehicules.split(";")[1];
        var modele = vehicules.split(";")[2];
        $('#cni-client').val($(this).attr("id-customer-directive"));
        $('#nom-client').val(nom);
        $('#nationalite-client').val(nationalite);
        $('#contact-client').val(contact);
        $('#email-client').val(email);
        $('#modele-voiture-client').val(modele);
        $('#marque-voiture-client').val(marque);
        $('#immatriculation-voiture-client').val(immatriculation);

        $("logement").attr("oCni-personne-logement-fidelite",$(this).attr("id-customer-directive"));
        $("commandes").attr("oCni-personne-commandes-fidelite",$(this).attr("id-customer-directive"));
        //alert($("commandes").attr("oCni-personne-commandes-fidelite"));
        $(oScreen).dialog({
        modal: true,
        width : 700,
        buttons: {
            "Annuler": function() {
                $(this).dialog("close");

            },
            "Actualiser": function() {
                var nom_client = $('#nom-client').val();
                var nationalite_client = $('#nationalite-client').val();
                var cni_client = $('#cni-client').val();
                var contact_client = $('#contact-client').val();
                var genre_client= document.querySelector('input[name=genre-client]:checked').value;
                var email_client = $('#email-client').val();
                var immatriculation_voiture_client = $('#immatriculation-voiture-client').val();
                var modele_voiture_client = $('#modele-voiture-client').val();
                var marque_voiture_client = $('#marque-voiture-client').val();
                var voiture_client = modele_voiture_client + ";" + immatriculation_voiture_client + ";" + marque_voiture_client;
                var params = "" ;
                params += "cni_personne="+cni_client+"&nom_personne="+nom_client+"&nationalite_client="+nationalite_client+"&contact_personne="+contact_client ;
                params += "&genre_client="+genre_client+"&email_personne="+email_client+"&vehicules="+ voiture_client ;
                params += "&jeton=update_client";
                
                ajaxing_customers(params,"POST","fideliser.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            }
        }
    });
    });
    
}



function oShowDialog7(oListener, oScreen) {
    $('#nom-client').val("");
    $('#nationalite-client').val("");
    $('#cni-client').val("");
    $('#email-client').val("");
    $('#contact-client').val("");
    $('#immatriculation-voiture-client').val("");
    $('#modele-voiture-client').val("");
    $('#marque-voiture-client').val("");
    
    $(oScreen).dialog({
        modal: true,
        width : 700,
        buttons: {
            
            "Annuler": function() {
                $(this).dialog("close");

            },
            "Fidéliser": function() {
                $("logement").attr("oCni-personne-logement-fidelite",$("#cni-client").val());
                $("commandes").attr("oCni-personne-commandes-fidelite",$("#cni-client").val());
                //alert($("commandes").attr("oCni-personne-commandes-fidelite"));
                var nom_client = $('#nom-client').val();
                var nationalite_client = $('#nationalite-client').val();
                var cni_client = $('#cni-client').val();
                var contact_client = $('#contact-client').val();
                var genre_client= document.querySelector('input[name=genre-client]:checked').value;
                var email_client = $('#email-client').val();
                var immatriculation_voiture_client = $('#immatriculation-voiture-client').val();
                var modele_voiture_client = $('#modele-voiture-client').val();
                var marque_voiture_client = $('#marque-voiture-client').val();
                var voiture_client = modele_voiture_client + ";" + immatriculation_voiture_client + ";" + marque_voiture_client;
                var params = "" ;
                params += "cni_personne="+cni_client+"&nom_personne="+nom_client+"&nationalite_client="+nationalite_client+"&contact_personne="+contact_client ;
                params += "&genre_client="+genre_client+"&email_personne="+email_client+"&vehicules="+ voiture_client ;
                params += "&jeton=save_client";
                ajaxing_save_customers(params,"POST","fideliser.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            }
        }
    });
}




function oFilterCni(oListener){
   $(document).on('keyup',oListener,function(e){
        if(e.keyCode== 13 || e.which == 13) {
            if($(oListener).val()!=""){
                    if($(oListener).val().length==9 || $(oListener).val().length==17){
                        var cni_personne=$(oListener).val();
                        var params ="";
                        params+="cni_personne="+cni_personne+"&jeton=filter_cni";
                    }else if($(oListener).val().length>3 && $(oListener).val().length<50){
                        alert("Longeur de CNI incorrecte");
                        var params ="jeton=read_users";
                    }else if ($(oListener).val().length<3){
                        alert("CNI trop courte");
                        var params ="jeton=read_users";
                    }else  if ($(oListener).val().length>50){
                        alert("CNI trop longue!!");
                        var params ="jeton=read_users";
                    }
                    $("logement").attr("oCni-personne-logement-fidelite",$("#cni-zone").val());
                    $("commandes").attr("oCni-personne-commandes-fidelite",$("#cni-zone").val());
                    //alert($("commandes").attr("oCni-personne-commandes-fidelite"));
            }else{
                alert("Renseignez une CNI svp!");
                var params ="jeton=read_users";
            }
            ajaxing_customers(params,"POST","fideliser.php", "warningsSuccess", "warningFailure");
        }
    });
}

function oFilterName(oListener){
   $(document).on('keyup',oListener,function(e){
        if(e.keyCode== 13 || e.which == 13) {
            
            if($(oListener).val()!=""){
                        var nom_personne=$(oListener).val();
                        var params = "nom_personne="+nom_personne+"&jeton=filter_nom";
                    
                    $("logement").attr("oCni-personne-logement-fidelite",$("#cni-zone").val());
                    $("commandes").attr("oCni-personne-commandes-fidelite",$("#cni-zone").val());
                    //alert($("commandes").attr("oCni-personne-commandes-fidelite"));
            }else{
                alert("Renseignez un nom svp");
                var params ="jeton=read_users";
            }
            ajaxing_customers(params,"POST","fideliser.php", "warningsSuccess", "warningFailure");
        }
    });

}


function enableOrDisableCNIzone (){
    $(document).on('click',"#btn-edit-customer",function(){
        $("#cni-client").attr("readonly","true");
        
    });
    $("#test-fidelite").click(function(){
        $("#cni-client").removeAttr("readonly");
    });
}


function initItemWithCNIForNewCustomer (oListener){
    var params="";
        
    $(document).on('click',oListener,function(){
        $("logement").attr("oCni-personne-logement-fidelite",$("#cni-client").val());
        $("commandes").attr("oCni-personne-commandes-fidelite",$("#cni-client").val());
        // params = "jeton=send_CNI_to_locaux&cni_personne=" +  $("logement").attr("oCni-personne-logement-fidelite");
        // ajaxing_page(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
    });
}


function redirectToCible_1(oListener,oCible){
    $(document).on("click",oListener,function(){
         $(this).parent().parent().find("a").attr("href",oCible+"?jeton=receive_cni_for_logement&cni_personne="+$("logement").attr("oCni-personne-logement-fidelite"));   
    });
    
}

function redirectToCible_final(oListener,oCible){
    $(document).on("click",oListener,function(){
         //window.history.back();
            
        });
    
}

function replaceAll(machaine, chaineARemaplacer, chaineDeRemplacement) {
    return machaine.replace(new RegExp(chaineARemaplacer, 'g'),chaineDeRemplacement);
  }

function oCniLockLogement(oListener){
    $(document).on("click",oListener,function(){
        if($("#oCni-personne").val()){
            $("#oCni-personne").attr("readonly","true");
        }else {
            $("#oCni-personne").removeAttr("readonly");
        } 
    });
}


function oCniLockCommandes(oListener){
    $(document).on("click",oListener,function(){
        if($("#kCNI").val()){
            $("#kCNI").attr("readonly","true");
        }else {
            $("#kCNI").removeAttr("readonly");
        } 
    });
}

function redirectToCible_3 (oListener,oCible,oTbodyItemCheck){
    $(document).on("click",oListener,function(){
          var params = "jeton=transmission_chambres_for_commandes&cni_personne="+$("#oCni-personne").val(); 
          params += $(oTbodyItemCheck).map(function(){return "&"+this.name +"="+this.value; }).get().join().replace(/,/g,"");
          
          $(this).parent().parent().find("a").attr("href",oCible+"?"+params);   
    });
}


function startCoutCommande (){
    $(document).load(function(){
        //alert("toto");
        oSommeCoutCommande("#cout-commande");
    });

}

function inverseDateCalendar(oDateStr){
    var jour = oDateStr.split("/")[1] ;
    var mois = oDateStr.split("/")[0];
    var annee = oDateStr.split("/")[2];
    var dateInverseeStr = jour+"-"+ mois +"-"+ annee;
    return dateInverseeStr ; 
}

function inverseDateCalendar2(oDateStr){
    var jour = oDateStr.split("/")[0] ;
    var mois = oDateStr.split("/")[1];
    var annee = oDateStr.split("/")[2];
    var dateInverseeStr = jour+"-"+ mois +"-"+ annee;
    return dateInverseeStr ; 
}




function inverseDateAnglo(oDateStr){
    var jour = oDateStr.split("/")[2] ;
    var mois = oDateStr.split("/")[1] ; 
    var annee = oDateStr.split("/")[0] ;
    var dateInverseeStr = jour +"/"+ mois +"/"+ annee ;
    return dateInverseeStr ; 
}

function inverseDate(oDateStr){
    var jour = oDateStr.split("/")[1] ;
    var mois = oDateStr.split("/")[0] ;
    var annee = oDateStr.split("/")[2] ;
    var dateInverseeStr = annee +"/"+ mois +"/"+ jour ;
    return dateInverseeStr ; 
}


function inverseDateTrue(oDateStr){
    var jour = oDateStr.split("/")[2] ;
    var mois = oDateStr.split("/")[0] ;
    var annee = oDateStr.split("/")[1] ;
    var dateInverseeStr = annee +"/"+ mois +"/"+ jour ;
    return dateInverseeStr ; 
}

function inverseDateReal(oDateStr){
    var jour = oDateStr.split("-")[0] ;
    var mois = oDateStr.split("-")[1]
    var annee = oDateStr.split("-")[2]
    var dateInverseeStr = annee +"/"+ mois +"/"+ jour ;
    return dateInverseeStr ; 
}


function inverseDateCaisse(oDateStr){
    var jour = oDateStr.split("-")[2] ;
    var mois = oDateStr.split("-")[1]
    var annee = oDateStr.split("-")[0]
    var dateInverseeStr = jour+"/"+mois +"/"+annee ;
    return dateInverseeStr ; 
}

function oFilterCommande(){
   var $date_debut=inverseDateTrue($("#date-debut").val());
   var $date_fin=inverseDateTrue($("#date-fin").val());
   var $cni_personne=$("#zBuffer-cni").val();
   var params="cni_personne="+$cni_personne+"&date_debut="+$date_debut+"&date_fin="+$date_fin+"&jeton=filter_commande";
   ajaxing_filter_commande(params, "POST", "index.php", "warningsSuccess", "warningFailure");

}

function dateBoxOnCommands (oIDZone){
    $(document).on('focus', oIDZone, function() {
        $(oIDZone).datepicker({ inline: true });
    });
}

function lockCheckBoxInLogements(){
    $("table#chambres   tbody tr th").css("background","#49a");//attr("readonly","true");
    $("table#chambres   tbody tr th  input[type=checkbox]").prop("disabled","true");
}

function isBissextile(annee){
   //var datCur=oGetCurrentDate();
  // var annee=datCur.split('/')[2];
   if(annee%4==0)
        return true;
   else
        return false;     
}

function initDimensionCalendar(annee){
    var isBissextilevalue=isBissextile(annee);
    var dimension=365;
    if(isBissextilevalue)
        dimension=366;
    return dimension;        
}

function initCalendarStructure(otbodyRow ,oAnnee){
    var n=initDimensionCalendar(oAnnee);
    var janvier="";var fevrier="";var mars="";var avril="";var mai="";var juin="";var juillet="";var aout="";
    var septembre="";var octobre="";var novembre="";var decembre="";
    for(var i=1;i<=n;i++){
        
         if(i>=1 && i<=31) janvier += "<td id='"+i+"-01-"+oAnnee+"'>"+i+"</td>";
        
        if(!isBissextile(oAnnee)){
                 if (i>=32 && i<=59)     fevrier += "<td id='"+(i-32+1)+"-02-"+oAnnee+"'>"+(i-32+1)+"</td>";
            else if (i>=60 && i<=90)     mars += "<td id='"+(i-60+1)+"-03-"+oAnnee+"'>"+(i-60+1)+"</td>";
            else if (i>=91 && i<=120)    avril += "<td id='"+(i-91+1)+"-04-"+oAnnee+"'>"+(i-91+1)+"</td>";
            else if (i>=121 && i<=151)   mai += "<td id='"+(i-121+1)+"-05-"+oAnnee+"'>"+(i-121+1)+"</td>";
            else if (i>=152 && i<=181)   juin += "<td id='"+(i-152+1)+"-06-"+oAnnee+"'>"+(i-152+1)+"</td>";
            else if (i>=182 && i<=212)   juillet += "<td id='"+(i-182+1)+"-07-"+oAnnee+"'>"+(i-182+1)+"</td>";
            else if (i>=213 && i<=243)   aout += "<td id='"+(i-213+1)+"-08-"+oAnnee+"'>"+(i-213+1)+"</td>";
            else if (i>=244 && i<=273)   septembre += "<td id='"+(i-244+1)+"-09-"+oAnnee+"'>"+(i-244+1)+"</td>";
            else if (i>=274 && i<=304)   octobre += "<td id='"+(i-274+1)+"-10-"+oAnnee+"'>"+(i-274+1)+"</td>";
            else if (i>=305 && i<=334)   novembre += "<td id='"+(i-305+1)+"-11-"+oAnnee+"'>"+(i-305+1)+"</td>";
            else if (i>=335 && i<=365)   decembre += "<td id='"+(i-335+1)+"-12-"+oAnnee+"'>"+(i-335+1)+"</td>";
        } else{
                 if (i>=32 && i<=60)     fevrier += "<td id='"+(i-32+1)+"-02-"+oAnnee+"'>"+(i-32+1)+"</td>";
            else if (i>=61 && i<=91)     mars += "<td id='"+(i-61+1)+"-03-"+oAnnee+"'>"+(i-61+1)+"</td>";
            else if (i>=92 && i<=121)    avril += "<td id='"+(i-92+1)+"-04-"+oAnnee+"'>"+(i-92+1)+"</td>";
            else if (i>=122 && i<=152)   mai += "<td id='"+(i-122+1)+"-05-"+oAnnee+"'>"+(i-122+1)+"</td>";
            else if (i>=153 && i<=182)   juin += "<td id='"+(i-153+1)+"-06-"+oAnnee+"'>"+(i-153+1)+"</td>";
            else if (i>=183 && i<=213)   juillet += "<td id='"+(i-183+1)+"-07-"+oAnnee+"'>"+(i-183+1)+"</td>";
            else if (i>=214 && i<=244)   aout += "<td id='"+(i-214+1)+"-08-"+oAnnee+"'>"+(i-214+1)+"</td>";
            else if (i>=245 && i<=274)   septembre += "<td id='"+(i-245+1)+"-09-"+oAnnee+"'>"+(i-245+1)+"</td>";
            else if (i>=275 && i<=305)   octobre += "<td id='"+(i-275+1)+"-10-"+oAnnee+"'>"+(i-275+1)+"</td>";
            else if (i>=306 && i<=335)   novembre += "<td id='"+(i-306+1)+"-11-"+oAnnee+"'>"+(i-306+1)+"</td>";
            else if (i>=336 && i<=366)   decembre += "<td id='"+(i-336+1)+"-12-"+oAnnee+"'>"+(i-336+1)+"</td>";

        }
       
       
       
        
    }
     var calendarHeader="<tr><th colspan='33' style='text-align:center'> <input  type='button' value='<<' id='btn-date-gauche'> CALENDRIER<span id='progress-date'> "+oAnnee+"</span> <input type='button' value='>>' id='btn-date-droite'> </th></tr>";
     $(otbodyRow).html(calendarHeader);
     $(otbodyRow).append("<tr><th month-number=1>janvier</th><td>"+janvier+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=2>fevrier</th><td>"+fevrier+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=3>mars</th><td>"+mars+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=4>avril</th><td>"+avril+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=5>mai</th><td>"+mai+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=6>juin</th><td>"+juin+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=7>juillet</th><td>"+juillet+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=8>aout</th><td>"+aout+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=9>septembre</th><td>"+septembre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=10>octobre</th><td>"+octobre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=11>novembre</th><td>"+novembre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=12>decembre</th><td>"+decembre+"</td></tr>");
     //$(otbodyRow +" td").css("background-color","rgba(0, 0, 0, 0)");
     
}



function initCalendarStructureSalle(otbodyRow ,oAnnee){
    var n=initDimensionCalendar(oAnnee);
    var janvier="";var fevrier="";var mars="";var avril="";var mai="";var juin="";var juillet="";var aout="";
    var septembre="";var octobre="";var novembre="";var decembre="";
    for(var i=1;i<=n;i++){
        
         if(i>=1 && i<=31) janvier += "<td class='"+i+"-01-"+oAnnee+"'>"+i+"</td>";
        
        if(!isBissextile(oAnnee)){
                 if (i>=32 && i<=59)     fevrier += "<td class='"+(i-32+1)+"-02-"+oAnnee+"'>"+(i-32+1)+"</td>";
            else if (i>=60 && i<=90)     mars += "<td class='"+(i-60+1)+"-03-"+oAnnee+"'>"+(i-60+1)+"</td>";
            else if (i>=91 && i<=120)    avril += "<td class='"+(i-91+1)+"-04-"+oAnnee+"'>"+(i-91+1)+"</td>";
            else if (i>=121 && i<=151)   mai += "<td class='"+(i-121+1)+"-05-"+oAnnee+"'>"+(i-121+1)+"</td>";
            else if (i>=152 && i<=181)   juin += "<td class='"+(i-152+1)+"-06-"+oAnnee+"'>"+(i-152+1)+"</td>";
            else if (i>=182 && i<=212)   juillet += "<td class='"+(i-182+1)+"-07-"+oAnnee+"'>"+(i-182+1)+"</td>";
            else if (i>=213 && i<=243)   aout += "<td class='"+(i-213+1)+"-08-"+oAnnee+"'>"+(i-213+1)+"</td>";
            else if (i>=244 && i<=273)   septembre += "<td class='"+(i-244+1)+"-09-"+oAnnee+"'>"+(i-244+1)+"</td>";
            else if (i>=274 && i<=304)   octobre += "<td class='"+(i-274+1)+"-10-"+oAnnee+"'>"+(i-274+1)+"</td>";
            else if (i>=305 && i<=334)   novembre += "<td class='"+(i-305+1)+"-11-"+oAnnee+"'>"+(i-305+1)+"</td>";
            else if (i>=335 && i<=365)   decembre += "<td class='"+(i-335+1)+"-12-"+oAnnee+"'>"+(i-335+1)+"</td>";
        } else{
                 if (i>=32 && i<=60)     fevrier += "<td class='"+(i-32+1)+"-02-"+oAnnee+"'>"+(i-32+1)+"</td>";
            else if (i>=61 && i<=91)     mars += "<td class='"+(i-61+1)+"-03-"+oAnnee+"'>"+(i-61+1)+"</td>";
            else if (i>=92 && i<=121)    avril += "<td class='"+(i-92+1)+"-04-"+oAnnee+"'>"+(i-92+1)+"</td>";
            else if (i>=122 && i<=152)   mai += "<td class='"+(i-122+1)+"-05-"+oAnnee+"'>"+(i-122+1)+"</td>";
            else if (i>=153 && i<=182)   juin += "<td class='"+(i-153+1)+"-06-"+oAnnee+"'>"+(i-153+1)+"</td>";
            else if (i>=183 && i<=213)   juillet += "<td class='"+(i-183+1)+"-07-"+oAnnee+"'>"+(i-183+1)+"</td>";
            else if (i>=214 && i<=244)   aout += "<td class='"+(i-214+1)+"-08-"+oAnnee+"'>"+(i-214+1)+"</td>";
            else if (i>=245 && i<=274)   septembre += "<td class='"+(i-245+1)+"-09-"+oAnnee+"'>"+(i-245+1)+"</td>";
            else if (i>=275 && i<=305)   octobre += "<td class='"+(i-275+1)+"-10-"+oAnnee+"'>"+(i-275+1)+"</td>";
            else if (i>=306 && i<=335)   novembre += "<td class='"+(i-306+1)+"-11-"+oAnnee+"'>"+(i-306+1)+"</td>";
            else if (i>=336 && i<=366)   decembre += "<td class='"+(i-336+1)+"-12-"+oAnnee+"'>"+(i-336+1)+"</td>";

        }
       
       
       
        
    }
     var calendarHeader="<tr><th colspan='33' style='text-align:center'> <input  type='button' value='<<' id='btn-date-gauche-salle'> CALENDRIER<span id='progress-date-salle'> "+oAnnee+"</span> <input type='button' value='>>' id='btn-date-droite-salle'> </th></tr>";
     $(otbodyRow).html(calendarHeader);
     $(otbodyRow).append("<tr><th month-number=1>janvier</th><td>"+janvier+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=2>fevrier</th><td>"+fevrier+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=3>mars</th><td>"+mars+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=4>avril</th><td>"+avril+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=5>mai</th><td>"+mai+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=6>juin</th><td>"+juin+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=7>juillet</th><td>"+juillet+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=8>aout</th><td>"+aout+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=9>septembre</th><td>"+septembre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=10>octobre</th><td>"+octobre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=11>novembre</th><td>"+novembre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=12>decembre</th><td>"+decembre+"</td></tr>");
     //$(otbodyRow +" td").css("background-color","rgba(0, 0, 0, 0)");
     
}


function oNavigationDate(otbodyRow,oListener){
     $(document).on("click",oListener,function(){
         var res=0;
          var dateActive=$(this).parent().find('span' ).html();
          if(oListener=='#btn-date-droite')   res=parseInt(dateActive)+1;
          else   res=parseInt(dateActive)-1;
          $(this).parent().find('span').html(" "+res);
          dateActive=$("#progress-date").text();
          initCalendarStructure('#dynamic-calendar tbody',dateActive.trim());
          var progressDate = $("#progress-date").text().trim();
          var params = "jeton=transmission_progress_date&progress_date=" + progressDate+"&code_chambre=" + $("#oBuffer").val()+"&categorie_chambre="+$("#oCategorie-chambre").text().trim();
        //alert(params);
         ajaxing_native2(params, "GET", "buffer.php", "warningsSuccess", "warningFailure");
          
          $.getJSON('../data.json',function(data){
            
                 $.each(data,function(index,d){
                    var selecteur1=inverseDateCalendar2(data[index].date_attribution_service);
                     var selecteur2=inverseDateCalendar2(data[index].date_liberation_service);
                     selecteur1=oDeleteZeroFromDayDate(selecteur1);
                     selecteur2=oDeleteZeroFromDayDate(selecteur2);
                     //alert(selecteur1+"======="+selecteur2+"====="+data[1].bgcolor+"====="+data[1].cni_personne);
                     sFillBusySpaces(selecteur1,selecteur2,data[index].bgcolor,data[index].cni_personne);

                 });
          });    
    });
}

function oNavigationDateSalle(otbodyRow,oListener){
    $(document).on("click",oListener,function(){
        var res=0;
         var dateActive=$(this).parent().find('span').html();
         if(oListener=='#btn-date-droite-salle')   res=parseInt(dateActive)+1;
         else   res=parseInt(dateActive)-1;
         $(this).parent().find('span').html(" "+res);
         dateActive=$("#progress-date-salle").text();
         initCalendarStructureSalle('#dynamic-calendar-salle tbody',dateActive.trim());
         var progressDate = $("#progress-date-salle").text().trim();
         var params = "jeton=transmission_progress_date_salle&progress_date_salle=" + progressDate+"&code_salle=" + $("#oBuffer-salle").val()+"&categorie_salle="+$("#oCategorie-salle").text().trim();
        //  alert(params);
         ajaxing_native2_salles(params, "GET", "buffer.php", "warningsSuccess", "warningFailure");
         
         $.getJSON('../data.json',function(data){
           
                $.each(data,function(index,d){
                   var selecteur1=inverseDateCalendar2(data[index].date_attribution_service);
                    var selecteur2=inverseDateCalendar2(data[index].date_liberation_service);
                    selecteur1=oDeleteZeroFromDayDate(selecteur1);
                    selecteur2=oDeleteZeroFromDayDate(selecteur2);
                    //alert(selecteur1+"======="+selecteur2+"====="+data[1].bgcolor+"====="+data[1].cni_personne);
                    sFillBusySpacesSalles(selecteur1,selecteur2,data[index].bgcolor,data[index].cni_personne);

                });

         });
       
   });
 
}


function oDeleteZeroFromDayDate(oDate){
    var jour=oDate.split('-')[0];
    var customJour=parseInt(jour);
    var mois=oDate.split('-')[1];
    var annee=oDate.split('-')[2];
    var customDate=customJour+"-"+mois+"-"+annee;
    return customDate;
}


function oNbreJour(indexMois,oAnnee){
    if(indexMois==1||indexMois==3 || indexMois==5|| indexMois==7|| indexMois==8 || indexMois==10 ||indexMois==12) return 31;
    else if(indexMois==2){
        if(isBissextile(oAnnee)) return 29;
        else return 28;
    }
    else return 30;
}

function fillBusySpaces(oDateDebut,oDateFin){
        var selector; 
        var jourDebut=parseInt(oDateDebut.split("-")[0]);
        var jourFin=parseInt(oDateFin.split("-")[0]);
        var moisDebut=oDateDebut.split("-")[1];
        var moisFin=oDateFin.split("-")[1];
        var currentYear=oDateDebut.split("-")[2];
        var nbreMois=parseInt(moisFin)-parseInt(moisDebut);
        var RGB= generateRandomBValue(111111,999999);
        var indexDebutJour=0;
        var indexFinJour=0;
        var indexMois=moisDebut;
        //alert(moisDebut+"==="+moisFin+"==="+currentYear+"==="+nbreMois);
        if(nbreMois!=0){
            for( indexMois=moisDebut;indexMois<=moisFin;indexMois++){
                
                if(indexMois==moisDebut) {
                     indexDebutJour=jourDebut;
                     indexFinJour=oNbreJour(indexMois,currentYear);
                 }
                else if(indexMois==moisFin){
                    indexDebutJour=1;
                    indexFinJour=jourFin;
                    if(indexMois<10)  indexMois="0"+indexMois;
                 } 
                else{
                    indexDebutJour=1;
                    indexFinJour=oNbreJour(indexMois,currentYear);
                    if(indexMois<10)  indexMois="0"+indexMois;
                  } 
                 for(var i=indexDebutJour;i<=indexFinJour;i++){
                        $("#"+i+"-"+indexMois+"-"+currentYear).css("background-color","#"+RGB+"");
                        $("#"+i+"-"+indexMois+"-"+currentYear).prop("title",$("#oCni-personne").val());
                 }
              }
         }else {
             for(var i=jourDebut;i<=jourFin;i++){
                 selector="#"+i+"-"+indexMois+"-"+currentYear;
                $(selector).css("background-color","#"+RGB+"");
                $(selector).attr("title",$("#oCni-personne").val());
            }
         }
         return RGB ;
         
}

function fillBusySpacesSalles(oDateDebut,oDateFin){
    var selector; 
    var jourDebut=parseInt(oDateDebut.split("-")[0]);
    var jourFin=parseInt(oDateFin.split("-")[0]);
    var moisDebut=oDateDebut.split("-")[1];
    var moisFin=oDateFin.split("-")[1];
    var currentYear=oDateDebut.split("-")[2];
    var nbreMois=parseInt(moisFin)-parseInt(moisDebut);
    var RGB= generateRandomBValue(111111,999999);
    var indexDebutJour=0;
    var indexFinJour=0;
    var indexMois=moisDebut;
    //alert(moisDebut+"==="+moisFin+"==="+currentYear+"==="+nbreMois);
    if(nbreMois!=0){
        for( indexMois=moisDebut;indexMois<=moisFin;indexMois++){
            
            if(indexMois==moisDebut) {
                 indexDebutJour=jourDebut;
                 indexFinJour=oNbreJour(indexMois,currentYear);
             }
            else if(indexMois==moisFin){
                indexDebutJour=1;
                indexFinJour=jourFin;
                if(indexMois<10)  indexMois="0"+indexMois;
             } 
            else{
                indexDebutJour=1;
                indexFinJour=oNbreJour(indexMois,currentYear);
                if(indexMois<10)  indexMois="0"+indexMois;
              } 
             for(var i=indexDebutJour;i<=indexFinJour;i++){
                    $("."+i+"-"+indexMois+"-"+currentYear).css("background-color","#"+RGB+"");
                    $("."+i+"-"+indexMois+"-"+currentYear).prop("title",$("#oCni-personne").val());
             }
          }
     }else {
         for(var i=jourDebut;i<=jourFin;i++){
             selector="."+i+"-"+indexMois+"-"+currentYear;
            $(selector).css("background-color","#"+RGB+"");
            $(selector).attr("title",$("#oCni-personne").val());
        }
     }
     return RGB ;
     
}


function sFillBusySpaces(oDateDebut,oDateFin,oRGB,oCniPersonne){
        var selector; 
        var jourDebut=parseInt(oDateDebut.split("-")[0]);
        var jourFin=parseInt(oDateFin.split("-")[0]);
        var moisDebut=oDateDebut.split("-")[1];
        var moisFin=oDateFin.split("-")[1];
        var currentYear=oDateDebut.split("-")[2];
        var nbreMois=parseInt(moisFin)-parseInt(moisDebut);
        var RGB= oRGB ;
        var indexDebutJour=0;
        var indexFinJour=0;
        var indexMois=moisDebut;
        if(nbreMois!=0){
            for( indexMois=moisDebut;indexMois<=moisFin;indexMois++){
                
                if(indexMois==moisDebut) {
                     indexDebutJour=jourDebut;
                     indexFinJour=oNbreJour(indexMois,currentYear);
                 }
                else if(indexMois==moisFin){
                    indexDebutJour=1;
                    indexFinJour=jourFin;
                    if(indexMois<10)  indexMois="0"+indexMois;
                 } 
                else{
                    indexDebutJour=1;
                    indexFinJour=oNbreJour(indexMois,currentYear);
                    if(indexMois<10)  indexMois="0"+indexMois;
                  } 
                 for(var i=indexDebutJour;i<=indexFinJour;i++){
                        $("#"+i+"-"+indexMois+"-"+currentYear).css("background-color","#"+RGB+"");
                        $("#"+i+"-"+indexMois+"-"+currentYear).prop("title",oCniPersonne);
                 }
                 
              }
         }else {
             for(var i=jourDebut;i<=jourFin;i++){
                 selector="#"+i+"-"+indexMois+"-"+currentYear;
                 $(selector).css("background-color","#"+RGB+"");
                $(selector).attr("title",oCniPersonne);
            }
         }
         
}



function sFillBusySpacesSalles(oDateDebut,oDateFin,oRGB,oCniPersonne){
    var selector; 
    var jourDebut=parseInt(oDateDebut.split("-")[0]);
    var jourFin=parseInt(oDateFin.split("-")[0]);
    var moisDebut=oDateDebut.split("-")[1];
    var moisFin=oDateFin.split("-")[1];
    var currentYear=oDateDebut.split("-")[2];
    var nbreMois=parseInt(moisFin)-parseInt(moisDebut);
    var RGB= oRGB ;
    var indexDebutJour=0;
    var indexFinJour=0;
    var indexMois=moisDebut;
    if(nbreMois!=0){
        for( indexMois=moisDebut;indexMois<=moisFin;indexMois++){
            
            if(indexMois==moisDebut) {
                 indexDebutJour=jourDebut;
                 indexFinJour=oNbreJour(indexMois,currentYear);
             }
            else if(indexMois==moisFin){
                indexDebutJour=1;
                indexFinJour=jourFin;
                if(indexMois<10)  indexMois="0"+indexMois;
             } 
            else{
                indexDebutJour=1;
                indexFinJour=oNbreJour(indexMois,currentYear);
                if(indexMois<10)  indexMois="0"+indexMois;
              } 
             for(var i=indexDebutJour;i<=indexFinJour;i++){
                    $("."+i+"-"+indexMois+"-"+currentYear).css("background-color","#"+RGB+"");
                    $("."+i+"-"+indexMois+"-"+currentYear).prop("title",oCniPersonne);
             }
             
          }
     }else {
         for(var i=jourDebut;i<=jourFin;i++){
             selector="."+i+"-"+indexMois+"-"+currentYear;
             $(selector).css("background-color","#"+RGB+"");
            $(selector).attr("title",oCniPersonne);
        }
     }
     
}



function generateRandomBValue(min,max){
    return min + Math.floor(Math.random() * max);

}

 function rgb2hex(red, green, blue) {
        var rgb = blue | (green << 8) | (red << 16);
        return '#' + (0x1000000 + rgb).toString(16).slice(1)
  }


function zLibererChambre(oListener,oScreen){
    $(document).on("dblclick",oListener,function(){
        var oColor=$(this).css('background-color');

        if(oColor!="rgba(0, 0, 0, 0)"){
             var repere = oColor.substring(3).substring(1).split(")")[0];
             var redRate = repere.split(",")[0] ; 
             var greenRate = repere.split(",")[1] ; 
             var blueRate = repere.split(",")[2] ; 
             oColor = rgb2hex(redRate , greenRate , blueRate);
             //alert(oColor);
             $("#liberer-reservation div").html("CNI du client: "+$(this).attr('title'));
             oShowDialog10(oListener,oScreen,oColor);
        }
         
    });
}


function zLibererChambreSalle(oListener,oScreen){
    $(document).on("dblclick",oListener,function(){
        var oColor=$(this).css('background-color');

        if(oColor!="rgba(0, 0, 0, 0)"){
             var repere = oColor.substring(3).substring(1).split(")")[0];
             var redRate = repere.split(",")[0] ; 
             var greenRate = repere.split(",")[1] ; 
             var blueRate = repere.split(",")[2] ; 
             oColor = rgb2hex(redRate , greenRate , blueRate);
             //alert(oColor);
             $("#liberer-reservation div").html("CNI du client: "+$(this).attr('title'));
             oShowDialog10Prim(oListener,oScreen,oColor);
        }
         
    });
}

function zInfoReservation(oListener,oScreen){
    $(document).on("click",oListener,function(){
        var oColor=$(this).css('background-color');
        if(oColor!="rgba(0, 0, 0, 0)"){
            $("#info-reservation div").html("CNI du client: "+$(this).attr('title'));
            oShowDialog11(oListener,oScreen);
        }
    });
}

function zChevaucherDate(oDateDebut,oDateFin){
        var jourDebut=parseInt(oDateDebut.split("-")[0]);
        var jourFin=parseInt(oDateFin.split("-")[0]);
        var moisDebut=oDateDebut.split("-")[1];
        var moisFin=oDateFin.split("-")[1];
        var currentYear=oDateDebut.split("-")[2];
        var nbreMois=parseInt(moisFin)-parseInt(moisDebut);
        var indexDebutJour=0;
        var indexFinJour=0;
        var indexMois=moisDebut;
        var e,selector;
        if(currentYear.trim()==$("#progress-date").text().trim()){
            if(nbreMois!=0){
                for( indexMois=moisDebut;indexMois<=moisFin;indexMois++){
                    
                    if(indexMois==moisDebut) {
                        indexDebutJour=jourDebut;
                        indexFinJour=oNbreJour(indexMois,currentYear);
                    }
                    else if(indexMois==moisFin){
                        indexDebutJour=1;
                        indexFinJour=jourFin;
                        if(indexMois<10)  indexMois="0"+indexMois;
                    } 
                    else{
                        indexDebutJour=1;
                        indexFinJour=oNbreJour(indexMois,currentYear);
                        if(indexMois<10)  indexMois="0"+indexMois;
                    } 
                    
                    for(var i=indexDebutJour;i<=indexFinJour;i++){
                        selector="#"+i+"-"+indexMois+"-"+currentYear;
                        e=$(selector).css("background-color");
                            if(e!="rgba(0, 0, 0, 0)")  return true;
                    }
                }
            }else {
                for(var i=jourDebut;i<=jourFin;i++){
                    var selector="#"+i+"-"+moisDebut+"-"+currentYear;
                    var e=$(selector).css("background-color");
                    if(e!="rgba(0, 0, 0, 0)") return true;
                }
            }
        
        } 
        return false ;
}


function zChevaucherDateSalle(oDateDebut,oDateFin){
    var jourDebut=parseInt(oDateDebut.split("-")[0]);
    var jourFin=parseInt(oDateFin.split("-")[0]);
    var moisDebut=oDateDebut.split("-")[1];
    var moisFin=oDateFin.split("-")[1];
    var currentYear=oDateDebut.split("-")[2];
    var nbreMois=parseInt(moisFin)-parseInt(moisDebut);
    var indexDebutJour=0;
    var indexFinJour=0;
    var indexMois=moisDebut;
    var e,selector;
    if(currentYear.trim()==$("#progress-date-salle").text().trim()){
        if(nbreMois!=0){
            for( indexMois=moisDebut;indexMois<=moisFin;indexMois++){
                
                if(indexMois==moisDebut) {
                    indexDebutJour=jourDebut;
                    indexFinJour=oNbreJour(indexMois,currentYear);
                }
                else if(indexMois==moisFin){
                    indexDebutJour=1;
                    indexFinJour=jourFin;
                    if(indexMois<10)  indexMois="0"+indexMois;
                } 
                else{
                    indexDebutJour=1;
                    indexFinJour=oNbreJour(indexMois,currentYear);
                    if(indexMois<10)  indexMois="0"+indexMois;
                } 
                
                for(var i=indexDebutJour;i<=indexFinJour;i++){
                    selector="."+i+"-"+indexMois+"-"+currentYear;
                    e=$(selector).css("background-color");
                        if(e!="rgba(0, 0, 0, 0)")  return true;
                }
            }
        }else {
            for(var i=jourDebut;i<=jourFin;i++){
                var selector="."+i+"-"+moisDebut+"-"+currentYear;
                var e=$(selector).css("background-color");
                if(e!="rgba(0, 0, 0, 0)") return true;
            }
        }
    
    } 
    return false ;
}

function oIntegrityZone(oListener){
    $(document).on('blur',oListener,function(){
        var cni_personne=$(oListener).val();
        var params="cni_personne="+cni_personne+"&jeton=check_cni_integrity";
        //alert(params);
        ajaxing_native3 (params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
    });
}

function oIntegrityZoneCommandes(oListener){
    $(document).on('blur',oListener,function(){
        var cni_personne=$(oListener).val(); 
        var params="cni_personne="+cni_personne+"&jeton=check_cni_integrity_commandes";
        //alert(params);
        ajaxing_commands_1 (params, "POST", "index.php", "warningsSuccess", "warningFailure");
    });
}

function oIntegrityZoneDate(oListener){
    $(document).on('change',oListener,function(){
        var date_attribution=$(oListener).val();
        var params="date_attribution="+date_attribution+"&jeton=check_cni_integrity_date_attribution";
        ajaxing_native5 (params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
    });
}

function oIntegrityZoneDateSalles(oListener){
    $(document).on('change',oListener,function(){
        var date_attribution_salle=$(oListener).val();
        var params="date_attribution_salle="+date_attribution_salle+"&jeton=check_cni_integrity_date_attribution_salle";
        ajaxing_native6 (params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
    });
}

function setDiscountMode (oListener,oDiscountRate1,oDiscountRate2) {
    $(document).on('dblclick',oListener,function(){
        if ($("#field-services").val()!=""){
            var localValue = parseInt($(this).val().toString()) ;
            var oQty=parseInt($("#field-quantity").val());
            var cDiscountRate1 = parseInt (oDiscountRate1) ;
            var cDiscountRate2 = parseInt (oDiscountRate2) ;
            var oRemise1 = localValue-((localValue*cDiscountRate1)/100) ;
            var oRemise2 = localValue-((localValue*cDiscountRate2)/100);
            $(this).replaceWith("<select style='width: 13em;' class='form-control' id='field-uniq-price'> <option>"+ localValue +"</option> <option>"+oRemise1+"</option> <option>"+oRemise2+"</option> </select>");
        }else {
            alert("Service non renseigné pour application de remise");
        }
    });     
}


oIntegrityZone("#oCni-personne");
oIntegrityZone("#oCni-personne-salle");
// oIntegrityZoneDate("#oDatepicker1");
// oIntegrityZoneDate("#oDatepicker2");
// oIntegrityZoneDateSalles("#datepicker3");
// oIntegrityZoneDateSalles("#datepicker4");
zLibererChambre("#dynamic-calendar tbody td","#liberer-reservation");
zLibererChambreSalle("#dynamic-calendar-salle tbody td","#liberer-reservation");

// sFillBusySpaces('02-08-2017','04-08-2017',"419",'111409891');
//zInfoReservation("#dynamic-calendar tbody td","#info-reservation");



function oFormCategory(oListener1,oListener2) {
    $(document).on('click', oListener1, function() {
                $(oListener1).hide();
                $(oListener2).fadeIn();
                $("#finish-to-add-category").fadeIn();
                 
    });
}

function oFinishAddCategory(oListener1,oListener2,oListener3) {
    $(document).on('click', oListener1, function() {
                $(oListener1).hide();
                $(oListener2).hide();
                $(oListener3).fadeIn();
                 
    });
}


function oAddCategory(oListener1) {
    $(document).on('click', oListener1, function() {
               if($("#libelle").val()!=""){
                    $("#list-category").prepend($("#libelle").val()+'<br/>');  
                    $("#code-categorie").val("");
                    $("#libelle").val("");
               } 
                         
    });
}

function oSubmit(oListener) {
            $(oListener).keyup(function(touche){ 
            var appui = touche.which || touche.keyCode;   
              if(appui == 13 && ($(oListener).val()!="")){
                $("#list-category").prepend($("#libelle").val()+'<br/>');
                $("#code-categorie").val("");
                $("#libelle").val("")
             }
        });   
}

function oAddProduit() {
    $("#table-produits tbody tr").hover(function(){
      // $(this).after('<img class="ajout-produit" src="../img/plus.png" title="Ajouter un produit">');
    },function(){
        $('.ajout-produit').remove();
    })           
    
}


function oShowDialog12(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Modifier": function() {   
                $(this).dialog("close");
            },
            "Supprimer": function() {
                
                $(this).dialog("close");

            }
        }
    });
}

 

function oShowDialogRemoveTaxonomy(oListener, oScreen ,oCodeCat) {
    $(oScreen).dialog({
        modal: true,
        width: 450,
        buttons: {
            "Annuler": function() {   
                $(this).dialog("close");
            },
            "Supprimer": function() {
                var codeTaxonomy = oCodeCat;
                var params="code_taxonomy="+codeTaxonomy+"&jeton=remove_taxonomy";
                ajaxing_native_remove_taxonomy (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");                
                $(this).dialog("close");

            }
        }
    });
}
 

function oSaveTaxonomy(oListener){
    $(document).on('click',oListener,function(){
        var libelle=$("#libelle").val();
        var params="libelle="+libelle+"&jeton=save_taxonomy";
        ajaxing_native_save_taxonomy (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");
    });
}


 
function oRemoveTaxonomy(oListener,oScreen){
    $(document).on('click',oListener,function(){
        var codeCat = $(this).attr("id") ;
        oShowDialogRemoveTaxonomy(oListener,oScreen,codeCat);
    });
}



function oSearchTaxonomy(oListener){
    $(document).on('change',oListener,function(){
        var subTaxonomy = $("#search-taxonomy").val() ;
        var params="sub_taxonomy="+subTaxonomy+"&jeton=search_taxonomy";
        ajaxing_native_search_taxonomy (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");
    });
}


 function oActiveAjaxifingTaxonomy(oListener){
    $(document).on('click',oListener,function(){
        if($(this).text()=="chambre"||$(this).text()=="salle"){
            $("#standing").show();
            $("#thStanding").show();
        }
        else{
            $("#standing").hide();
            $("#thStanding").hide();
        }
        $("#list-category li").attr("class","list-group-item");
        $(this).attr("class","list-group-item active");
        
        var libelleTaxonomy=$(this).attr('title');
        var params="libelle_taxonomy="+libelleTaxonomy+"&jeton=active_ajaxifing_taxonomy";
        ajaxing_native_active_ajaxifing_taxonomy (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");
    });
 }

 function oSaveProduitWithTaxonomy(oListener){
    $(document).on('click',oListener,function(){
        var libelleTaxonomy=$("#list-category li.active").text();
        var codeService=$("#size-input-text-code").val();
        var libelleService=$("#libelle-service").val();
        var prixUnitaireAchat=$("#prix-unitaire-achat").val();
        var prixUnitaireVente=$("#prix-unitaire-vente").val();
        var avarie=$("#avarie").val();
        var quantite=parseInt($("#quantite").val()) + parseInt($("#qte-stock").val())-avarie;
        var statut="";
        var standing="";
        var avarie=$("#avarie").val();
        if(libelleTaxonomy=="chambre"||libelleTaxonomy=="salle"){
            statut="libre";
            standing=$("#standing input").val();    
        }
        var params="libelle_taxonomy="+libelleTaxonomy+
                   "&code_service="+codeService+
                   "&quantite="+quantite+
                   "&libelle_service="+libelleService+
                   "&statut="+statut+
                   "&standing="+standing+
                   "&avarie="+avarie+
                   "&prix_unitaire_achat="+prixUnitaireAchat+
                   "&prix_unitaire_vente="+prixUnitaireVente+
                   "&jeton=save_produit_with_taxonomy";
     ajaxing_native_save_produit_with_taxonomy (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");
    
    });
 }


 function oSearchProductByCode(oListener){
    $(document).on('change',oListener,function(){
        var codeService = $("#product-code").val() ;
        var nomService=$("#list-category li.active").text();
        var params="code_service="+codeService+
                   "&nom_service="+nomService+
                   "&jeton=search_product_by_code";
        ajaxing_native_search_product_by_code (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");
    });
}


 function oSearchProductByName(oListener){
    $(document).on('change',oListener,function(){
        var nomService = $("#product-designation").val() ;
        var categorieService=$("#list-category li.active").text();
        var params="nom_service="+nomService+
                   "&categorie_service="+categorieService+
                   "&jeton=search_product_by_name";
        ajaxing_native_search_product_by_name (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");
    });
}


function oUDproduct(oListener,oScreen) {
    $(document).on('dblclick', oListener, function() {
            var codeProduit=$(this).attr('id');
                var position = codeProduit.indexOf(".");
                  if (position!=-1) {
                    var firstPart=codeProduit.split(".")[0];
                    codeProduit=firstPart+"-"+codeProduit.split(".")[1]; 
                  }
                  $(this).attr('id',codeProduit);
            var categorieProduit =$("#list-category li.active").text()
            oShowDialogRemoveProduct(oListener,oScreen,codeProduit,categorieProduit);             
    });
}


function oShowDialogRemoveProduct(oListener, oScreen ,oCodeProd,oCatProd) {
    $(oScreen).dialog({
        modal: true,
        width: 500,
        buttons: {
            "Annuler": function() {   
                $(this).dialog("close");
            },
            "Modifier": function() {
                
                var standing="";
                var quantiteStockProduct="";
                var categorieProduit =$("#list-category li.active").text();
                var subStr                   ="tr#"+oCodeProd;  
                if(categorieProduit=="chambre"||categorieProduit=="salle"){
                    standing=subStr+" :nth-child(7)";
                    $("#standing input").val($(standing).html());
                    quantiteStockProduct     =subStr+" :nth-child(8)";
                    
                }else{
                    quantiteStockProduct     =subStr+" :nth-child(7)";
                    
                }
                var codeProduct              =subStr+" :nth-child(1)";
                var designationProduct       =subStr+" :nth-child(2)";
                var prixUnitaireAchatProduct =subStr+" :nth-child(3)";
                var prixUnitaireVenteProduct =subStr+" :nth-child(4)";
                var avarieProduct            =subStr+" :nth-child(6)";
                $("#size-input-text-code").val($(codeProduct).html()); 
                $("#libelle-service").val($(designationProduct).html());
                $("#prix-unitaire-achat").val($(prixUnitaireAchatProduct).html());
                $("#prix-unitaire-vente").val($(prixUnitaireVenteProduct).html());
                $("#quantite").val("0");
                $("#avarie").val($(avarieProduct).html());
                $("#qte-stock").val($(quantiteStockProduct).html()); 
                 codeProduct = $("#size-input-text-code").val();
                var categorieService = oCatProd;
                
                var params="code_service="+codeProduct+
                           "&categorie_service="+categorieService+
                           "&jeton=remove_product";
                ajaxing_native_remove_product (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");                
               
                $(this).dialog("close");
            },
            "Supprimer": function() {
                var codeProduct = oCodeProd;
                var categorieService = oCatProd;
                var params="code_service="+codeProduct+
                           "&categorie_service="+categorieService+
                           "&jeton=remove_product";
                ajaxing_native_remove_product (params, "POST", "magasinier.php", "warningsSuccess", "warningFailure");                
                $(this).dialog("close");

            }
        }
    });
}


////////////////Alain Tona 20/10/2018///////////////////


function oRemovePersonne(oListener,oScreen){
    $(document).on('click',oListener,function(){
       var cniPersonne=$(this).attr('id');
       oShowDialogRemovePersonne(oListener, oScreen ,cniPersonne);
    });
}



function oShowDialogRemovePersonne(oListener, oScreen ,oCniPersonne) {
    $(oScreen).dialog({
        modal: true,
        width: 500,
        buttons: {
            "Annuler": function() {   
                $(this).dialog("close");
            },
            "Supprimer": function() {
                var params="cni_personne="+oCniPersonne+
                           "&jeton=remove_personne";
                ajaxing_native_remove_personne(params, "POST", "../zViews/privileges.php", "warningsSuccess", "warningFailure"); 
          
                $(this).dialog("close");

            }
        }
    });
}


function oUpdatePersonne(oListener) {
    $(document).on('click', oListener, function() {
        var params = "";
        var cniPersonne=$(this).attr('title');
        params = "jeton=update_personne&cni_personne=" +cniPersonne;
        ajaxing_native_update_personne(params, "POST", "../zViews/privileges.php", "warningsSuccess", "warningFailure");
    });

}


function oBloquePersonne(oListener,oScreen){
    $(document).on('click',oListener,function(){
       var cniPersonne=$(this).attr('title');
       oShowDialogBloquePersonne(oListener, oScreen ,cniPersonne);
    });
}

function oShowDialogBloquePersonne(oListener, oScreen ,oCniPersonne) {
    $(oScreen).dialog({
        modal: true,
        width: 500,
        buttons: {
            "Annuler": function() {   
                $(this).dialog("close");
            },
            "Bloquer": function() {
                var params="cni_personne="+oCniPersonne+
                           "&jeton=bloque_personne";
                ajaxing_native_bloque_personne(params, "POST", "../zViews/privileges.php", "warningsSuccess", "warningFailure"); 
          
                $(this).dialog("close");

            }
        }
    });
}

function oFiltreNomServiceForStock (oListener) {
    $(document).on('change', oListener, function() {
        var search_zone = $(oListener).val();
        var params = "jeton=filtrer_services_en_stock&search_zone=" + search_zone;
        // alert(params) ;
        ajaxing_native_filtrer_services_en_stock(params, "POST", "stock.php", "warningsSuccess", "warningFailure");
    });

}

function oFiltreCategorieForStock (oListener) {
    $(document).on('change', oListener, function() {
        var search_zone = $(oListener).val();
        var params = "jeton=filtrer_categories_en_stock&search_zone=" + search_zone;
        // alert(params) ;
        ajaxing_native_filtrer_categories_en_stock(params, "POST", "stock.php", "warningsSuccess", "warningFailure");
    });

}

////////////////Alain Tona 20/10/2018///////////////////





function oComputeRecettes() {
    sommeCaisses = parseInt($("#recettes-chambres").text()) + parseInt($("#recettes-salles").text()) + parseInt($("#recettes-annexes").text()) ;
    $("#result-recettes").text(parseInt(sommeCaisses)+ " FCFA");
}

function oFiltrerCaisse(oListener) {
    $(document).on('click', oListener, function() {
        var params = "";
        var dateDeb=$("#cDateDeb").val();
        var dateFin=$("#cDateFin").val();
        dateDeb=inverseDateCaisse(dateDeb);
        dateFin=inverseDateCaisse(dateFin);
        params = "jeton=filtre_caisse&date_debut=" +dateDeb+"&date_fin="+dateFin;
        ajaxing_native_filtre_caisse(params, "POST", "../zViews/benefices.php", "warningsSuccess", "warningFailure");
    });

}




function oGetAmountCaisseGlobal (){
    $(window).on('load',function(){
        var params = "jeton=caisse_global";
        ajaxing_native_caisse_global(params, "POST", "../zViews/benefices.php", "warningsSuccess", "warningFailure");
    });

}



