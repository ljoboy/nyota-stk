'use strict';

$(document).ready(function () {
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status

    //load all items once the page is ready
    lilt();


    //WHEN USE BARCODE SCANNER IS CLICKED
    $("#useBarcodeScanner").click(function (e) {
        e.preventDefault();

        $("#itemCode").focus();
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Toggle the form to add a new item
     */
    $("#createItem").click(function () {
        $("#itemsListDiv").toggleClass("col-sm-8", "col-sm-12");
        $("#createNewItemDiv").toggleClass('hidden');
        $("#itemName").focus();
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    $(".cancelAddItem").click(function () {
        //reset and hide the form
        document.getElementById("addNewItemForm").reset();//reset the form
        $("#createNewItemDiv").addClass('hidden');//hide the form
        $("#itemsListDiv").attr('class', "col-sm-12");//make the table span the whole div
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //execute when 'auto-generate' checkbox is clicked while trying to add a new item
    $("#gen4me").click(function () {
        //if checked, generate a unique item code for user. Else, clear field
        if ($("#gen4me").prop("checked")) {
            var codeExist = false;

            do {
                //generate random string, reduce the length to 10 and convert to uppercase
                var rand = Math.random().toString(36).slice(2).substring(0, 10).toUpperCase();
                $("#itemCode").val(rand);//paste the code in input
                $("#itemCodeErr").text('');//remove the error message being displayed (if any)

                //check whether code exist for another item
                $.ajax({
                    type: 'get',
                    url: appRoot + "items/gettablecol/id/code/" + rand,
                    success: function (returnedData) {
                        codeExist = returnedData.status;//returnedData.status could be either 1 or 0
                    }
                });
            }

            while (codeExist);

        } else {
            $("#itemCode").val("");
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //handles the submission of adding new item
    $("#addNewItem").click(function (e) {
        e.preventDefault();

        changeInnerHTML(['itemNameErr', 'itemQuantityErr', 'itemCategoriesErr', 'itemPriceErr', 'itemCodeErr', 'addCustErrMsg', 'stockMinErr'], "");

        var itemName = $("#itemName").val();
        var itemQuantity = $("#itemQuantity").val();
        var itemCategories = $("#itemCategories").val();
        var itemPrice = $("#itemPrice").val().replace(",", "");
        var itemCode = $("#itemCode").val();
        var itemDescription = $("#itemDescription").val();
        var stockMin = $("#itemStockMin").val();

        if (!itemName || !itemQuantity || !itemPrice || !itemCode || !itemCategories || !stockMin) {
            !itemName ? $("#itemNameErr").text("Champs obligatoire") : "";
            !itemQuantity ? $("#itemQuantityErr").text("Champs obligatoire") : "";
            !itemCategories ? $("#itemCategoriesErr").text("Champs obligatoire") : "";
            !itemPrice ? $("#itemPriceErr").text("Champs obligatoire") : "";
            !itemCode ? $("#itemCodeErr").text("Champs obligatoire") : "";
            !stockMin ? $("#stockMinErr").text("Champs obligatoire") : "";

            $("#addCustErrMsg").text("Un ou plusieurs champs obligatoires sont vides");

            return;
        }

        displayFlashMsg("Ajouter un article '" + itemName + "'", "fa fa-spinner faa-spin animated", '', '');

        $.ajax({
            type: "post",
            url: appRoot + "items/add",
            data: {
                itemName: itemName,
                itemQuantity: itemQuantity,
                itemCategories: itemCategories,
                itemPrice: itemPrice,
                itemDescription: itemDescription,
                itemCode: itemCode,
                stockMin: stockMin
            },

            success: function (returnedData) {
                if (returnedData.status === 1) {
                    changeFlashMsgContent(returnedData.msg, "text-success", '', 1500);
                    document.getElementById("addNewItemForm").reset();

                    //refresh the items list table
                    lilt();

                    //return focus to item code input to allow adding item with barcode scanner
                    $("#itemCode").focus();
                } else {
                    hideFlashMsg();

                    //display all errors
                    $("#itemNameErr").text(returnedData.itemName);
                    $("#itemPriceErr").text(returnedData.itemPrice);
                    $("#itemCategoriesErr").text(returnedData.itemCategories);
                    $("#itemCodeErr").text(returnedData.itemCode);
                    $("#itemQuantityErr").text(returnedData.itemQuantity);
                    $("#stockMinErr").text(returnedData.min);
                    $("#addCustErrMsg").text(returnedData.msg);
                }
            },

            error: function () {
                if (!navigator.onLine) {
                    changeFlashMsgContent("Vous semblez être hors ligne. Reconnectez-vous à internet puis réessayer svp !", "", "red", "");
                } else {
                    changeFlashMsgContent("Impossible de répondre à votre requête à cet instant. Réessayez plus tard svp !", "", "red", "");
                }
            }
        });
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //reload items list table when events occur
    $("#itemsListPerPage, #itemsListSortBy").change(function () {
        displayFlashMsg("Patientez svp !", spinnerClass, "", "");
        lilt();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $("#itemSearch").keyup(function () {
        var value = $(this).val();

        if (value) {
            $.ajax({
                url: appRoot + "search/itemsearch",
                type: "get",
                data: {v: value},
                success: function (returnedData) {
                    $("#itemsListTable").html(returnedData.itemsListTable);
                }
            });
        } else {
            //reload the table if all text in search box has been cleared
            displayFlashMsg("Chargement de la page...", spinnerClass, "", "");
            lilt();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //triggers when an item's "edit" icon is clicked
    $("#itemsListTable").on('click', ".editItem", function (e) {
        e.preventDefault();

        //get item info
        var itemId = $(this).attr('id').split("-")[1];
        var itemDesc = $("#itemDesc-" + itemId).attr('title');
        var itemName = $("#itemName-" + itemId).html();
        var itemPrice = $("#itemPrice-" + itemId).html().split(".")[0].replace(",", "");
        var itemCode = $("#itemCode-" + itemId).html();
        var stockMin = $("#itemStockMin-" + itemId).html();

        //prefill form with info
        $("#itemIdEdit").val(itemId);
        $("#itemNameEdit").val(itemName);
        $("#itemCodeEdit").val(itemCode);
        $("#itemPriceEdit").val(itemPrice);
        $("#itemDescriptionEdit").val(itemDesc);
        $("#stockMinEdit").val(stockMin);

        //remove all error messages that might exist
        $("#editItemFMsg").html("");
        $("#itemNameEditErr").html("");
        $("#itemCodeEditErr").html("");
        $("#itemPriceEditErr").html("");
        $("#stockMinErr").html("");

        //launch modal
        $("#editItemModal").modal('show');
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $("#editItemSubmit").click(function () {
        var itemName = $("#itemNameEdit").val();
        var itemPrice = $("#itemPriceEdit").val();
        var itemCategories = $("#itemCategoriesEdit").val();
        var itemDesc = $("#itemDescriptionEdit").val();
        var itemId = $("#itemIdEdit").val();
        var itemCode = $("#itemCodeEdit").val();
        var stockMin = $("#stockMinEdit").val();

        if (!itemName || !itemPrice || !itemId || !itemCategories) {
            !itemName ? $("#itemNameEditErr").html("Le nom de l'article ne peut être vide") : "";
            !itemPrice ? $("#itemPriceEditErr").html("L'article doit avoir un prix") : "";
            !itemCategories ? $("#itemCategoriesEditErr").html("L'article doit avoir au moins une categorie") : "";
            !itemId ? $("#editItemFMsg").html("Article inconnu") : "";
            return;
        }

        $("#editItemFMsg").css('color', 'black').html("<i class='" + spinnerClass + "'></i> Traitement de votre requête....");

        $.ajax({
            method: "POST",
            url: appRoot + "items/edit",
            data: {
                itemName: itemName,
                itemPrice: itemPrice,
                itemCategories: itemCategories,
                itemDesc: itemDesc,
                _iId: itemId,
                itemCode: itemCode,
                stockMin: stockMin
            }
        }).done(function (returnedData) {
            if (returnedData.status === 1) {
                $("#editItemFMsg").css('color', 'green').html("Article modifié avec succès");

                setTimeout(function(){
                    $("#editItemModal").modal('hide');
                }, 1000);

                lilt();
            }

            else{
                $("#editItemFMsg").css('color', 'red').html("Un ou plusieurs champs obligatoires sont vide ou mal remplis");

                $("#itemNameEditErr").html(returnedData.itemName);
                $("#itemCodeEditErr").html(returnedData.itemCode);
                $("#itemCategoriesEditErr").html(returnedData.itemCategories);
                $("#itemPriceEditErr").html(returnedData.itemPrice);
                $("#stockUpdateMinErr").html(returnedData.min);
            }
        }).fail(function () {
            $("#editItemFMsg").css('color', 'red').html("Vous semblez ëtre hors ligne. Reconnectez-vous à internet puis réessayer svp !");
        });
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //trigers the modal to update stock
    $("#itemsListTable").on('click', '.updateStock', function () {
        //get item info and fill the form with them
        var itemId = $(this).attr('id').split("-")[1];
        var itemName = $("#itemName-" + itemId).html();
        var itemCurQuantity = $("#itemQuantity-" + itemId).html();
        var itemCode = $("#itemCode-" + itemId).html();
        var itemStockMin = $("stockMin" + itemId).html();

        $("#stockUpdateItemId").val(itemId);
        $("#stockUpdateItemName").val(itemName);
        $("#stockUpdateItemCode").val(itemCode);
        $("#stockUpdateItemQInStock").val(itemCurQuantity);
        $("#stockUpdateMin").val(itemStockMin);

        $("#updateStockModal").modal('show');
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //runs when the update type is changed while trying to update stock
    //sets a default description if update type is "newStock"
    $("#stockUpdateType").on('change', function () {
        var updateType = $("#stockUpdateType").val();

        if (updateType && (updateType === 'newStock')) {
            $("#stockUpdateDescription").val("De nouveaux articles ont été achetés");
        } else {
            $("#stockUpdateDescription").val("");
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //handles the updating of item's quantity in stock
    $("#stockUpdateSubmit").click(function () {
        var updateType = $("#stockUpdateType").val();
        var stockUpdateQuantity = $("#stockUpdateQuantity").val();
        var stockUpdateDescription = $("#stockUpdateDescription").val();
        var itemId = $("#stockUpdateItemId").val();

        if (!updateType || !stockUpdateQuantity || !stockUpdateDescription || !itemId) {
            !updateType ? $("#stockUpdateTypeErr").html("Champs obligatoire") : "";
            !stockUpdateQuantity ? $("#stockUpdateQuantityErr").html("Champs obligatoire") : "";
            !stockUpdateDescription ? $("#stockUpdateDescriptionErr").html("Champs obligatoire") : "";
            !itemId ? $("#stockUpdateItemIdErr").html("Champs obligatoire") : "";

            return;
        }

        $("#stockUpdateFMsg").html("<i class='" + spinnerClass + "'></i> Mise à jour du Stock.....");

        $.ajax({
            method: "POST",
            url: appRoot + "items/updatestock",
            data: {_iId: itemId, _upType: updateType, qty: stockUpdateQuantity, desc: stockUpdateDescription}
        }).done(function (returnedData) {
            if (returnedData.status === 1) {
                $("#stockUpdateFMsg").html(returnedData.msg);

                //refresh items' list
                lilt();

                //reset form
                document.getElementById("updateStockForm").reset();

                //dismiss modal after some secs
                setTimeout(function () {
                    $("#updateStockModal").modal('hide');//hide modal
                    $("#stockUpdateFMsg").html("");//remove msg
                }, 1000);
            } else {
                $("#stockUpdateFMsg").html(returnedData.msg);

                $("#stockUpdateTypeErr").html(returnedData._upType);
                $("#stockUpdateQuantityErr").html(returnedData.qty);
                $("#stockUpdateDescriptionErr").html(returnedData.desc);
            }
        }).fail(function () {
            $("#stockUpdateFMsg").html("Vous semblez ëtre hors ligne. Reconnectez-vous à internet puis réessayer svp !");
        });
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //PREVENT AUTO-SUBMISSION BY THE BARCODE SCANNER
    $("#itemCode").keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();

            //change to next input by triggering the tab keyboard
            $("#itemName").focus();
        }
    });


    //TO DELETE AN ITEM (The item will be marked as "deleted" instead of removing it totally from the db)
    $("#itemsListTable").on('click', '.delItem', function (e) {
        e.preventDefault();

        //get the item id
        var itemId = $(this).parents('tr').find('.curItemId').val();
        var itemRow = $(this).closest('tr');//to be used in removing the currently deleted row

        if (itemId) {
            var confirm = window.confirm("Êtes-vous sûre de vouloir effacer ? C'est une action irreversible");

            if (confirm) {
                displayFlashMsg('Patienter svp ...', spinnerClass, 'black');

                $.ajax({
                    url: appRoot + "items/delete",
                    method: "POST",
                    data: {i: itemId}
                }).done(function (rd) {
                    if (rd.status === 1) {
                        //remove item from list, update items' SN, display success msg
                        $(itemRow).remove();

                        //update the SN
                        resetItemSN();

                        //display success message
                        changeFlashMsgContent('Article effacé', '', 'green', 1000);
                    } else {

                    }
                }).fail(function () {
                    console.log('Requete échoué');
                });
            }
        }
    });
});


/**
 * "lilt" = "load Items List Table"
 * @param {type} url
 * @returns {undefined}
 */
function lilt(url) {
    var orderBy = $("#itemsListSortBy").val().split("-")[0];
    var orderFormat = $("#itemsListSortBy").val().split("-")[1];
    var limit = $("#itemsListPerPage").val();


    $.ajax({
        type: 'get',
        url: url ? url : appRoot + "items/lilt/",
        data: {orderBy: orderBy, orderFormat: orderFormat, limit: limit},

        success: function (returnedData) {
            hideFlashMsg();
            $("#itemsListTable").html(returnedData.itemsListTable);
        },

        error: function () {

        }
    });


    return false;
}


/**
 * "vittrhist" = "View item's transaction history"
 * @param {type} itemId
 * @returns {Boolean}
 */
function vittrhist(itemId) {
    if (itemId) {

    }

    return false;
}


function resetItemSN() {
    $(".itemSN").each(function (i) {
        $(this).html(parseInt(i) + 1);
    });
}
