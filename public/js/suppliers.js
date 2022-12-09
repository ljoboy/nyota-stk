'use strict';

$(document).ready(function () {
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status


    //load all supplier once the page is ready
    //function header: laad_(url)
    laad_();

    //reload the list of supplier when fields are changed
    $("#suppliersListSortBy, #suppliersListPerPage").change(function () {
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        laad_();
    });

    //load and show page when pagination link is clicked
    $("#allsuppliers").on('click', '.lnp', function (e) {
        e.preventDefault();

        displayFlashMsg("Patientez svp ...", spinnerClass, "", "");

        laad_($(this).attr('href'));

        return false;
    });

    //handles the addition of new supplier details .i.e. when "add supplier" button is clicked
    $("#addSupplier").click(function (e) {
        e.preventDefault();

        //reset all error msgs in case they are set
        changeInnerHTML(['nameErr', 'addressErr', 'phone_numberErr', 'itemsErr'], "");

        let name = $("#name").val();
        let address = $("#address").val();
        let phone_number = $("#phone_number").val();
        let email = $("#email").val();
        let items = $("#itemSuppliers").val();

        //ensure all required fields are filled
        if (!name || !email) {
            !name ? changeInnerHTML('nameErr', "Champ obligatoire") : "";
            !email ? changeInnerHTML('emailErr', "Champ obligatoire") : "";
            return;
        }

        //display message telling user action is being processed
        $("#fMsgIcon").attr('class', spinnerClass);
        $("#fMsg").text(" En cours...");

        //make ajax request if all is well
        $.ajax({
            method: "POST",
            url: appRoot + "supplier/add",
            data: {
                name: name,
                address: address,
                phone_number: phone_number,
                items: items,
                email: email
            }
        }).done(function (returnedData) {
            $("#fMsgIcon").removeClass();//remove spinner

            if (returnedData.status === 1) {
                $("#fMsg").css('color', 'green').text(returnedData.msg);

                //reset the form
                document.getElementById("addNewSupplierForm").reset();

                //close the modal
                setTimeout(function () {
                    $("#fMsg").text("");
                    $("#addNewSupplierModal").modal('hide');
                }, 1000);

                //reset all error msgs in case they are set
                changeInnerHTML(['nameErr', 'addressErr', 'phone_numberErr', 'itemsErr', 'emailErr'], "");

                //refresh supplier list table
                laad_();

            } else {
                //display error message returned
                $("#fMsg").css('color', 'red').html(returnedData.msg);

                //display individual error messages if applied
                $("#nameErr").text(returnedData.name);
                $("#emailErr").text(returnedData.email);
                $("#addressErr").text(returnedData.address);
                $("#phone_numberErr").text(returnedData.phone_number);
                $("#itemSuppliersErr").text(returnedData.items)
            }
        }).fail(function () {
            if (!navigator.onLine) {
                $("#fMsg").css('color', 'red').text("Erreur du réseau ! Vérifiez votre connexion svp");
            }
        });
    });

    //handles the updating of supplier details
    $("#editSupplierSubmit").click(function (e) {
        e.preventDefault();

        if (formChanges("editSupplierForm")) {
            //reset all error msgs in case they are set
            changeInnerHTML(['nameEditErr', 'addressEditErr', 'phone_numberEditErr', 'itemsEditErr', 'emailEditErr'], "");

            let nameEdit = $("#nameEdit").val();
            let emailEdit = $("#emailEdit").val();
            let addressEdit = $("#addressEdit").val();
            let phone_numberEdit = $("#phone_numberEdit").val();
            let itemsEdit = $("#itemSupplierEdit");
            let supplierIdEdit = $("#supplierId").val();

            //ensure all required fields are filled
            if (!nameEdit || !supplierIdEdit || !emailEdit) {
                !nameEdit ? changeInnerHTML('nameEditErr', "Champ obligatoire") : "";
                !emailEdit ? changeInnerHTML('emailEditErr', "Champ obligatoire") : "";
                !supplierIdEdit ? changeInnerHTML("fMsgEdit","Une erreur inattendue s'est produite lors de la modification des détails du fournisseur") : "";
                return;
            }

            //display message telling user action is being processed
            $("#fMsgEditIcon").attr('class', spinnerClass);
            $("#fMsgEdit").text(" Mise à jour des détails...");

            //make ajax request if all is well
            $.ajax({
                method: "POST",
                url: appRoot + "supplier/update",
                data: {
                    nameEdit: nameEdit,
                    addressEdit: addressEdit,
                    phone_numberEdit: phone_numberEdit,
                    itemsEdit: itemsEdit,
                    emailEdit: emailEdit,
                    supplierIdEdit: supplierIdEdit
                }
            }).done(function (returnedData) {
                $("#fMsgEditIcon").removeClass();//remove spinner

                if (returnedData.status === 1) {
                    $("#fMsgEdit").css('color', 'green').text(returnedData.msg);

                    //reset the form and close the modal
                    setTimeout(function () {
                        $("#fMsgEdit").text("");
                        $("#editSupplierModal").modal('hide');
                    }, 1000);

                    //reset all error msgs in case they are set
                    changeInnerHTML(['nameEditErr', 'addressEditErr', 'phone_numberEditErr', 'itemsEditErr', 'emailEditErr'], "");

                    //refresh supplier list table
                    laad_();

                } else {
                    //display error message returned
                    $("#fMsgEdit").css('color', 'red').html(returnedData.msg);

                    //display individual error messages if applied
                    $("#nameEditErr").html(returnedData.name);
                    $("#emailEditErr").html(returnedData.email);
                    $("#addressEditErr").html(returnedData.address);
                    $("#phone_numberEditErr").html(returnedData.phone_number);
                    $("#itemSuppliersErr").html(returnedData.items);
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

    //handles supplier search
    $("#supplierSearch").on('keyup change', function () {
        let value = $(this).val();

        if (value) {//search only if there is at least one char in input
            $.ajax({
                type: "get",
                url: appRoot + "search/suppliersearch",
                data: {v: value},
                success: function (returnedData) {
                    $("#allsuppliers").html(returnedData.suppliersTable);
                }
            });
        } else {
            laad_();
        }
    });

    //When the trash icon in front of an admin account is clicked on the admin list table (i.e. to delete the account)
    $("#allsuppliers").on('click', '.deletesupplier', function () {
        let catRow = $(this).closest('tr');
        let confirm = window.confirm("Êtes-vous sûre de vouloir effacer cette Catégorie? C'est une action irreversible!");

        if (confirm) {
            let ElemId = $(this).attr('id');

            let supplierId = ElemId.split("-")[1];//get the supplierId

            //show spinner
            $("#" + ElemId).html("<i class='" + spinnerClass + "'</i>");

            if (supplierId) {
                $.ajax({
                    url: appRoot + "supplier/delete",
                    method: "POST",
                    data: {_aId: supplierId}
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
    $("#allsuppliers").on('click', '.editsupplier', function () {

        let supplierId = $(this).attr('id').split("-")[1];

        $("#supplierId").val(supplierId);

        //get info of admin with supplierId and prefill the form with it
        //alert($(this).siblings(".adminEmail").children('a').html());
        let name = $(this).siblings(".supplierName").html();
        let address = $(this).siblings(".supplierAddress").html();
        let phone_number = $(this).siblings(".supplierPhone_number").html();
        let itemSupplier = $(this).siblings(".itemSuppliers").html();
        let email = $(this).siblings(".supplierEmail").html();

        //prefill the form fields
        $("#nameEdit").val(name);
        $("#emailEdit").val(email);
        $("#addressEdit").val(address);
        $("#phone_numberEdit").val(phone_number);
        $("#itemSuppliersEdit").val(itemSupplier);

        $("#editSupplierModal").modal('show');
    });

});

/**
 * laad_ = "Load all administrators"
 * @returns {undefined}
 */
function laad_(url) {
    let orderBy = $("#suppliersListSortBy").val().split("-")[0];
    let orderFormat = $("#suppliersListSortBy").val().split("-")[1];
    let limit = $("#suppliersListPerPage").val();

    $.ajax({
        type: 'get',
        url: url ? url : appRoot + "supplier/laad_/",
        data: {orderBy: orderBy, orderFormat: orderFormat, limit: limit},
    }).done(function (returnedData) {
        hideFlashMsg();

        $("#allsuppliers").html(returnedData.suppliersTable);
    });
}