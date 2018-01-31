function ajaxing_native(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            //alert(data);
            $("#corps").html(data);
            var i = 0;
            var tcode_service = $("#oBufferChecks").val().replace(/\./g, "-").trim();
            var code_service = "";
            var _BORNE = 20;
            while (i < _BORNE) {
                code_service = tcode_service.split(";")[i + 1];
                code_service = "#" + code_service;
                $(code_service).prop("checked", true);
                i++;
            }


        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_native_salle(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            // alert(data);
            $("#corps").html(data);
            var i = 0;
            var tcode_service = $("#oBufferChecks-salle").val().replace(/\./g, "-").trim();
            var code_service = "";
            var _BORNE = 20;
            while (i < _BORNE) {
                code_service = tcode_service.split(";")[i + 1];
                code_service = "." + code_service;
                $(code_service).prop("checked", true);
                i++;
            }


        },
        error: function() {
            alert(warningFailure);
        }
    });
}




function ajaxing_native2(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(datas, result, jqXHR) {
            //alert(datas);
            $.getJSON('../data.json', function(data) {

                $.each(data, function(index, d) {
                    var selecteur1 = inverseDateCalendar2(data[index].date_attribution_service);
                    var selecteur2 = inverseDateCalendar2(data[index].date_liberation_service);
                    selecteur1 = oDeleteZeroFromDayDate(selecteur1);
                    selecteur2 = oDeleteZeroFromDayDate(selecteur2);
                    //alert(selecteur1+"======="+selecteur2+"====="+data[1].bgcolor+"====="+data[1].cni_personne);
                    sFillBusySpaces(selecteur1, selecteur2, data[index].bgcolor, data[index].cni_personne);

                });

            });
            $("#corps").html(datas);
            var i = 0;
            var tcode_service = $("#oBufferChecks").val().replace(/\./g, "-").trim();
            var code_service = "";
            var _BORNE = 20;
            while (i < _BORNE) {
                code_service = tcode_service.split(";")[i + 1];
                code_service = "#" + code_service;
                $(code_service).prop("checked", true);
                i++;
            }

        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_native2_salles(params, method, servlet, warningsSuccess, warningFailure) {

    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(datas, result, jqXHR) {
            // alert(datas);
            $.getJSON('../data.json', function(data) {
                $.each(data, function(index, d) {
                    var selecteur1 = inverseDateCalendar2(data[index].date_attribution_service);
                    var selecteur2 = inverseDateCalendar2(data[index].date_liberation_service);
                    selecteur1 = oDeleteZeroFromDayDate(selecteur1);
                    selecteur2 = oDeleteZeroFromDayDate(selecteur2);
                    sFillBusySpacesSalles(selecteur1, selecteur2, data[index].bgcolor, data[index].cni_personne);
                });
            });
            $("#corpsSalles").html(datas);
            var i = 0;
            var tcode_service = $("#oBufferChecks-salle").val().replace(/\./g, "-").trim();
            var code_service = "";
            var _BORNE = 20;

            while (i < _BORNE) {
                code_service = tcode_service.split(";")[i + 1];
                code_service = "#" + code_service;
                $(code_service).prop("checked", true);
                i++;
            }

        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_native_prim(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {

            $("#corpsSalles").html(data);
            var i = 0;
            var tcode_service = $("#oBufferChecks-salle").val().replace(/\./g, "-").trim();
            var code_service = "";
            var _BORNE = 20;
            //alert("INFO : "+ tcode_service);
            while (i < _BORNE) {
                code_service = tcode_service.split(";")[i + 1];
                code_service = "#" + code_service;
                $(code_service).prop("checked", true);
                i++;
            }

        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_filter_commande(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#commande-filtrer").html(data);
        },
        error: function() {
            //alert(warningFailure);
        }
    });
}

function ajaxing_commands(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#trichZone").val(data.split("#@#")[0]);
            $("#trichZoneForCode").val(data.split("#@#")[1]);
            $("#trichZoneForAchatPrice").val(data.split("#@#")[2]);
            $("#field-quantity").val("1");
            $("#field-uniq-price").val(data.split("#@#")[0]);

        },
        error: function() {
            //alert(warningFailure);
        }
    });
}


function ajaxing_commands_1(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            var results = data.split("&&")[0].trim().toString();
            //$('#codel2').html(results);
            if (results == "nok") {
                $("#kCNI").val("");
                $("#smsl2").html("<span style='color:red; font-size:0.8em'>CNI de client inexistente !!</span>");
                $("#kCNI").removeAttr("readonly");
            } else if (results == "ok") {
                $("#kCNI").prop("readonly", "true");
                $("#kCNI").parent().find("span").remove();
            }
        },
        error: function() {
            //alert(warningFailure);
        }
    });
}


function ajaxing_save_commande(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            // alert(data) ;
            var nomPersonne = data.split("####")[0];
            var datastock = data.split("####")[1].split("&&")[1];
            if (datastock == "false") {
                alert("cette commande ne peut etre satisfaite verifier  le stock de certains produits");
            } else {
                var cni_personne = $("#kCNI").val();
                var message_bienvenue = "Bienvenu au centre MAISON CICM<br/>";
                var message_queue = "Votre satisfaction est notre priorité";
                var contact = "680060306 / 690909935";
                var site_web = "centredacceuilcicm@yahoo.fr";
                var enteteprincipale = "<center>";
                enteteprincipale += "MISSIONNAIRES DU COEUR IMMACULE DE MARIE<br/>";
                enteteprincipale += "<img src='img/logo.png' width='25px' height='25px'>&nbsp;&nbsp;&nbsp;<strong>Congregatio Immaculati Cordis Mariae - CICM &nbsp;&nbsp;&nbsp;<img src='img/logo.png' width='25px' height='25px'><br/></strong>";
                enteteprincipale += "PROVINCE D'AFRIQUE CENTRALE ET DE L'OUEST";
                enteteprincipale += "<hr width='70%'><span style='font-size:1.5em; color:#093; text-align:center; font-weight:bold'>MAISON PROVINCIALE CICM</span></center>";
                $("#flowToPrint").prepend(enteteprincipale);
                $("#flowToPrint").append("<center> Facture de : <strong>" + nomPersonne + "</strong><br/>" + message_bienvenue + "</center>");
                $("#flowToPrint").append("<center><strong>" + message_queue + "</strong><br/><strong>" + contact + "</strong><br/>" + site_web + "</center>");
                $("#flowToPrint").append("<center><p>ToTal : <strong style='color:#990099; font-size:1.75em' >" + oSommeCoutCommande("#cout-commande") + "</strong> FCFA</p></center>");
                $("#flowToPrint").removeAttr("style");
                $("#flowToPrint tr").css("background", "#f0Ad4e");
                $("#flowToPrint tr:eq(0)").css("background", "#5bc0de");
                $("#flowToPrint tr th:nth-child(5)").remove();
                $("#flowToPrint tbody tr td:nth-child(5)").remove();
                $('#flowToPrint').printElement({ leaveOpen: true, printMode: 'popup', pageTitle: 'Facture CICM' });
                $("#flowToPrint").hide();

            }

            window.location.replace(""); //OK

        },
        error: function() {
            //alert(warningFailure);
        }
    });
}


function ajaxing_customers(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            //alert(data);
            $(".utilisateurs").html(data);


        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_save_customers(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $(".utilisateurs").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}



function ajaxing_page(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {

            //alert(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}





function ajaxing_native3(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(datas, result, jqXHR) {
            var results = datas.split("&&")[0].trim().toString();
            if (results == "nok") {
                // alert("Aucun client n'est associé à cette CNI !! Vérifiez encore la cni du client SVP") ;
                $("#oCni-personne").val("");
                $("#smsl").html("<span style='color:red; font-size:0.8em'>CNI de client inexistente !!</span>");
                $("#oCni-personne").removeAttr("readonly");

                $("#oCni-personne-salle").val("");
                $("#smsl1").html("<span style='color:red; font-size:0.8em'>CNI de client inexistente !!</span>");
                $("#oCni-personne-salle").removeAttr("readonly");

            } else if (results == "ok") {
                $("#oCni-personne").prop("readonly", "true");
                $("#oCni-personne").parent().find("span").remove();

                $("#oCni-personne-salle").prop("readonly", "true");
                $("#oCni-personne-salle").parent().find("span").remove();
            }

            //oShowDialog3("table#chambres   tbody tr td:nth-child(2)",'#oModal-chambres');
            $.getJSON('../data.json', function(data) {

                $.each(data, function(index, d) {
                    var selecteur1 = inverseDateCalendar2(data[index].date_attribution_service);
                    var selecteur2 = inverseDateCalendar2(data[index].date_liberation_service);
                    selecteur1 = oDeleteZeroFromDayDate(selecteur1);
                    selecteur2 = oDeleteZeroFromDayDate(selecteur2);
                    //alert(selecteur1+"======="+selecteur2+"====="+data[1].bgcolor+"====="+data[1].cni_personne);
                    sFillBusySpaces(selecteur1, selecteur2, data[index].bgcolor, data[index].cni_personne);

                });

            });
            $("#corps").html(datas);
            var i = 0;
            var tcode_service = $("#oBufferChecks").val().replace(/\./g, "-").trim();
            var code_service = "";
            var _BORNE = 20;
            while (i < _BORNE) {
                code_service = tcode_service.split(";")[i + 1];
                code_service = "#" + code_service;
                $(code_service).prop("checked", true);
                i++;
            }

        },
        error: function() {
            alert(warningFailure);
        }
    });
}



function ajaxing_native5(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(datas, result, jqXHR) {
            var results = datas.split("&&")[0].trim().toString();
            //alert(results) ;
            if (results == "nok") {
                // alert("Aucun client n'est associé à cette CNI !! Vérifiez encore la cni du client SVP") ;

                $("#smsCdate1").html("<span style='color:red; font-size:0.8em'>date retrograde ,corrigez la SVP !!</span>");
                $("#oDatepicker1").val("");

                $("#smsCdate2").html("<span style='color:red; font-size:0.8em'>date retrograde ,corrigez la SVP !!</span>");
                $("#oDatepicker2").val("");
            }
            if (results == "ok") {
                $("#oDatepicker1").parent().find("span").remove();

                $("#oDatepicker2").parent().find("span").remove();

            }

            //oShowDialog3("table#chambres   tbody tr td:nth-child(2)",'#oModal-chambres');
            // $.getJSON('../data.json',function(data){

            //          $.each(data,function(index,d){
            //             var selecteur1=inverseDateCalendar2(data[index].date_attribution_service);
            //              var selecteur2=inverseDateCalendar2(data[index].date_liberation_service);
            //              selecteur1=oDeleteZeroFromDayDate(selecteur1);
            //              selecteur2=oDeleteZeroFromDayDate(selecteur2);
            //              //alert(selecteur1+"======="+selecteur2+"====="+data[1].bgcolor+"====="+data[1].cni_personne);
            //              sFillBusySpaces(selecteur1,selecteur2,data[index].bgcolor,data[index].cni_personne);

            //          });

            //   });
            $("#corps").html(datas);
            var i = 0;
            var tcode_service = $("#oBufferChecks").val().replace(/\./g, "-").trim();
            var code_service = "";
            var _BORNE = 20;
            while (i < _BORNE) {
                code_service = tcode_service.split(";")[i + 1];
                code_service = "#" + code_service;
                $(code_service).prop("checked", true);
                i++;
            }

        },
        error: function() {
            alert(warningFailure);
        }
    });
}



function ajaxing_native6(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(datas, result, jqXHR) {
            var results = datas.split("&&")[0].trim().toString();
            //alert(results) ;
            if (results == "nok") {
                // alert("Aucun client n'est associé à cette CNI !! Vérifiez encore la cni du client SVP") ;

                $("#smsSdate1").html("<span style='color:red; font-size:0.8em'>date retrograde ,corrigez la SVP !!</span>");
                $("#datepicker3").val("");

                $("#smsSdate2").html("<span style='color:red; font-size:0.8em'>date retrograde ,corrigez la SVP !!</span>");
                $("#datepicker4").val("");
            }
            if (results == "ok") {
                $("#datepicker3").parent().find("span").remove();

                $("#datepicker4").parent().find("span").remove();

            }

            //oShowDialog3("table#chambres   tbody tr td:nth-child(2)",'#oModal-chambres');
            // $.getJSON('../data.json',function(data){

            //          $.each(data,function(index,d){
            //             var selecteur1=inverseDateCalendar2(data[index].date_attribution_service);
            //              var selecteur2=inverseDateCalendar2(data[index].date_liberation_service);
            //              selecteur1=oDeleteZeroFromDayDate(selecteur1);
            //              selecteur2=oDeleteZeroFromDayDate(selecteur2);
            //              //alert(selecteur1+"======="+selecteur2+"====="+data[1].bgcolor+"====="+data[1].cni_personne);
            //              sFillBusySpaces(selecteur1,selecteur2,data[index].bgcolor,data[index].cni_personne);

            //          });

            //   });
            $("#corpsSalles").html(datas);
            var i = 0;
            var tcode_service = $("#oBufferChecks-salle").val().replace(/\./g, "-").trim();
            var code_service = "";
            var _BORNE = 20;
            while (i < _BORNE) {
                code_service = tcode_service.split(";")[i + 1];
                code_service = "#" + code_service;
                $(code_service).prop("checked", true);
                i++;
            }

        },
        error: function() {
            alert(warningFailure);
        }
    });
}



function ajaxing_native_save_taxonomy(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#list-category ul").html(data);
            $("#libelle").val("");
        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_native_remove_taxonomy(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#list-category ul").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_native_search_taxonomy(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#list-category ul").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_native_active_ajaxifing_taxonomy(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#tbody-table-produits").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_native_save_produit_with_taxonomy(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#table-product-form input").val("");
            $("#qte-stock").val("0");
            $("#tbody-table-produits").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_native_search_product_by_code(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#tbody-table-produits").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_native_search_product_by_name(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#tbody-table-produits").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_native_remove_product(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#tbody-table-produits").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}

//////////////////////////////////////////////////////////////////////////////

function ajaxing_native_remove_personne(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#list-users-privileges tbody").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_native_update_personne(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#register-form").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}



function ajaxing_native_bloque_personne(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#list-users-privileges tbody").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}





function ajaxing_native_filtrer_services_en_stock(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            // alert(data) ;
            $("#list-produits-en-stock").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}



function ajaxing_native_filtrer_categories_en_stock(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            // alert(data) ;
            $("#list-produits-en-stock").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_native_filtre_caisse(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#recettes-chambres").replaceWith((data).split("#@#")[0]);
            $("#recettes-salles").replaceWith((data).split("#@#")[1]);
            $("#recettes-annexes").replaceWith((data).split("#@#")[2]);
            oComputeRecettes();
        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_native_caisse_global(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            var year = new Date().getFullYear();

            alert(data);
            var datasGlobal = data.split("@@@")[0];
            var datasHeberg = data.split("@@@")[1];
            var datasAnnexe = data.split("@@@")[2];

            nbG = datasGlobal.split("###")[0];
            var _datasGlobal = [];
            var i;
            for (i = 0; i < nbG - 1; i++) {
                _datasGlobal.push({ x: new Date(year, i), y: parseInt(datasGlobal.split("###")[i + 1]) });

            }


            nbH = datasHeberg.split("###")[0];
            var _datasHeberg = [];
            var i;
            for (i = 0; i < nbH - 1; i++) {
                _datasHeberg.push({ x: new Date(year, i), y: parseInt(datasHeberg.split("###")[i + 1]) });

            }



            nbA = datasAnnexe.split("###")[0];
            var _datasAnnexe = [];
            var i;
            for (i = 0; i < nbA - 1; i++) {
                _datasAnnexe.push({ x: new Date(year, i), y: parseInt(datasAnnexe.split("###")[i + 1]) });
            }
            oPlotGraphic(_datasGlobal, _datasHeberg, _datasAnnexe);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}


///////////////////////////////////////////////////////////////////////