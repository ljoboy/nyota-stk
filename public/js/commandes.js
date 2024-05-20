'use strict';

$(document).ready(function () {
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status


    //load all commande once the page is ready
    //function header: laad_(url)
    laad_();

    //reload the list of commande when fields are changed
    $("#commandesListSortBy, #commandesListPerPage").change(function () {
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        laad_();
    });

    //load and show page when pagination link is clicked
    $("#allcommandes").on('click', '.lnp', function (e) {
        e.preventDefault();

        displayFlashMsg("Patientez svp ...", spinnerClass, "", "");

        laad_($(this).attr('href'));

        return false;
    });

    //handles the addition of new commande details .i.e. when "add commande" button is clicked
    $("#addCommande").click(function (e) {
        e.preventDefault();

        //reset all error msgs in case they are set
        changeInnerHTML(['itemErr', 'supplierErr', 'qtyErr'], "");

        let item_id = $("#item").val();
        let supplier_id = $("#supplier").val();
        let qty = $("#qty").val();
        qty = (qty > 0) ? qty : 0;

        //ensure all required fields are filled
        if (!item_id || !supplier_id || !qty ) {
            !item_id ? changeInnerHTML('itemErr', "Champ obligatoire") : "";
            !supplier_id ? changeInnerHTML('supplierErr', "Champ obligatoire") : "";
            !qty ? changeInnerHTML('qtyErr', "Champ obligatoire") : "";
            return;
        }

        //display message telling user action is being processed
        $("#fMsgIcon").attr('class', spinnerClass);
        $("#fMsg").text(" En cours...");

        //make ajax request if all is well
        $.ajax({
            method: "POST",
            url: appRoot + "commande/add",
            data: {
                item_id: item_id,
                supplier_id: supplier_id,
                qty: qty
            }
        }).done(function (returnedData) {
            $("#fMsgIcon").removeClass();//remove spinner

            if (returnedData.status === 1) {
                $("#fMsg").css('color', 'green').text(returnedData.msg);

                //reset the form
                document.getElementById("addNewCommandeForm").reset();

                //close the modal
                setTimeout(function () {
                    $("#fMsg").text("");
                    $("#addNewCommandeModal").modal('hide');
                }, 1000);

                //reset all error msgs in case they are set
                changeInnerHTML(['itemErr', 'supplierErr', 'qtyErr'], "");

                //refresh commande list table
                laad_();

            } else {
                //display error message returned
                $("#fMsg").css('color', 'red').html(returnedData.msg);

                //display individual error messages if applied
                $("#itemErr").text(returnedData.item_id);
                $("#supplierErr").text(returnedData.supplier_id);
                $("#qtyErr").text(returnedData.qty);
            }
        }).fail(function () {
            if (!navigator.onLine) {
                $("#fMsg").css('color', 'red').text("Erreur du réseau ! Vérifiez votre connexion svp");
            }
        });
    });

    //handles the updating of commande details
    $("#editCommandeSubmit").click(function (e) {
        e.preventDefault();

        if (formChanges("editCommandeForm")) {
            //reset all error msgs in case they are set
            changeInnerHTML(['nameEditErr', 'addressEditErr', 'phone_numberEditErr', 'itemsEditErr', 'emailEditErr'], "");

            let nameEdit = $("#nameEdit").val();
            let emailEdit = $("#emailEdit").val();
            let addressEdit = $("#addressEdit").val();
            let phone_numberEdit = $("#phone_numberEdit").val();
            let itemsEdit = $("#itemCommandeEdit");
            let commandeIdEdit = $("#commandeId").val();

            //ensure all required fields are filled
            if (!nameEdit || !commandeIdEdit || !emailEdit) {
                !nameEdit ? changeInnerHTML('nameEditErr', "Champ obligatoire") : "";
                !emailEdit ? changeInnerHTML('emailEditErr', "Champ obligatoire") : "";
                !commandeIdEdit ? changeInnerHTML("fMsgEdit","Une erreur inattendue s'est produite lors de la modification des détails du fournisseur") : "";
                return;
            }

            //display message telling user action is being processed
            $("#fMsgEditIcon").attr('class', spinnerClass);
            $("#fMsgEdit").text(" Mise à jour des détails...");

            //make ajax request if all is well
            $.ajax({
                method: "POST",
                url: appRoot + "commande/update",
                data: {
                    nameEdit: nameEdit,
                    addressEdit: addressEdit,
                    phone_numberEdit: phone_numberEdit,
                    itemsEdit: itemsEdit,
                    emailEdit: emailEdit,
                    commandeIdEdit: commandeIdEdit
                }
            }).done(function (returnedData) {
                $("#fMsgEditIcon").removeClass();//remove spinner

                if (returnedData.status === 1) {
                    $("#fMsgEdit").css('color', 'green').text(returnedData.msg);

                    //reset the form and close the modal
                    setTimeout(function () {
                        $("#fMsgEdit").text("");
                        $("#editCommandeModal").modal('hide');
                    }, 1000);

                    //reset all error msgs in case they are set
                    changeInnerHTML(['nameEditErr', 'addressEditErr', 'phone_numberEditErr', 'itemsEditErr', 'emailEditErr'], "");

                    //refresh commande list table
                    laad_();

                } else {
                    //display error message returned
                    $("#fMsgEdit").css('color', 'red').html(returnedData.msg);

                    //display individual error messages if applied
                    $("#nameEditErr").html(returnedData.name);
                    $("#emailEditErr").html(returnedData.email);
                    $("#addressEditErr").html(returnedData.address);
                    $("#phone_numberEditErr").html(returnedData.phone_number);
                    $("#itemCommandesErr").html(returnedData.items);
                }
            }).fail(function () {
                if (!navigator.onLine) {
                    $("#fMsgEdit").css('color', 'red').html("Network error! Pls check your network connection");
                }
            });
        } else {
            $("#fMsgEdit").html("Aucun changement a été opéré");
        }
    });

    //handles commande search
    $("#commandeSearch").on('keyup change', function () {
        let value = $(this).val();

        if (value) {//search only if there is at least one char in input
            $.ajax({
                type: "get",
                url: appRoot + "search/commandesearch",
                data: {v: value},
                success: function (returnedData) {
                    $("#allcommandes").html(returnedData.commandesTable);
                }
            });
        } else {
            laad_();
        }
    });

    //When the trash icon in front of an admin account is clicked on the admin list table (i.e. to delete the account)
    $("#allcommandes").on('click', '.deletecommande', function () {
        let catRow = $(this).closest('tr');
        let confirm = window.confirm("Êtes-vous sûre de vouloir effacer cette Catégorie? C'est une action irreversible!");

        if (confirm) {
            let ElemId = $(this).attr('id');

            let commandeId = ElemId.split("-")[1];//get the commandeId

            //show spinner
            $("#" + ElemId).html("<i class='" + spinnerClass + "'</i>");

            if (commandeId) {
                $.ajax({
                    url: appRoot + "commande/delete",
                    method: "POST",
                    data: {_aId: commandeId}
                }).done(function (returnedData) {
                    if (returnedData.status === 1) {
                        catRow.remove()
                        changeFlashMsgContent('Fournisseur effacé', '', 'green', 1000);
                    } else {
                        alert(returnedData.status);
                    }
                }).fail(function(){
                    console.log('Requête échouée');
                });
            }
        }
    });

    //to launch the modal to allow for the editing of admin info
    $("#allcommandes").on('click', '.editcommande', function () {

        let commandeId = $(this).attr('id').split("-")[1];

        $("#commandeId").val(commandeId);

        //get info of admin with commandeId and prefill the form with it
        //alert($(this).siblings(".adminEmail").children('a').html());
        let name = $(this).siblings(".commandeName").html();
        let address = $(this).siblings(".commandeAddress").html();
        let phone_number = $(this).siblings(".commandePhone_number").html();
        let itemCommande = $(this).siblings(".itemCommandes").html();
        let email = $(this).siblings(".commandeEmail").html();

        //prefill the form fields
        $("#nameEdit").val(name);
        $("#emailEdit").val(email);
        $("#addressEdit").val(address);
        $("#phone_numberEdit").val(phone_number);
        $("#itemCommandesEdit").val(itemCommande);

        $("#editCommandeModal").modal('show');
    });

});

/**
 * laad_ = "Load all administrators"
 * @returns {undefined}
 */
function laad_(url) {
    let orderBy = $("#commandesListSortBy").val().split("-")[0];
    let orderFormat = $("#commandesListSortBy").val().split("-")[1];
    let limit = $("#commandesListPerPage").val();

    $.ajax({
        type: 'get',
        url: url ? url : appRoot + "commande/laad_/",
        data: {orderBy: orderBy, orderFormat: orderFormat, limit: limit},
    }).done(function (returnedData) {
        hideFlashMsg();

        $("#allcommandes").html(returnedData.commandesTable);
        $("#allsents").html(returnedData.sendTable);
    });
}