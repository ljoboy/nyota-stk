'use strict';

let barCodeTextTimeOut;
let cumTotalWithoutVATAndDiscount = 0;

$(document).ready(function () {
    $("#selItemDefault").select2();


    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status

    //load all transactions on page load
    latr_();


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //when text/btn ("Add item") to clone the div to add an item is clicked
    $("#clickToClone").on('click', function (e) {
        e.preventDefault();

        let cloned = $("#divToClone").clone();

        //remove the id 'divToClone' from the cloned div
        cloned.addClass('transItemList').removeClass('hidden').attr('id', '');

        //reset the form values (in the cloned div) to default
        cloned.find(".selectedItemDefault").addClass("selectedItem").val("");
        cloned.find(".itemAvailQty").html("0");
        cloned.find(".itemTransQty").val("0");
        cloned.find(".itemTotalPrice").html("0.00");

        //loop through the currentItems variable to add the items to the select input
        return new Promise((resolve, reject) => {
            //if an item has been selected (i.e. added to the current transaction), do not add it to the list. This way, an item will appear just once.
            //We start by forming an array of all selected items, then skip that item in the loop appending items to select dropdown
            let selectedItemsArr = [];

            return new Promise((res, rej) => {
                $(".selectedItem").each(function () {
                    //push the selected value (which is the item code [a key in currentItems object]) to the array
                    $(this).val() ? selectedItemsArr.push($(this).val()) : "";
                });

                res();
            }).then(() => {
                for (let key in currentItems) {
                    //if the current key in the loop is in our 'selectedItemsArr' array
                    if (!inArray(key, selectedItemsArr)) {
                        //if the item has not been selected, append it to the select list
                        cloned.find(".selectedItemDefault").append("<option value='" + key + "'>" + currentItems[key] + "</option>");
                    }
                }

                //prepend 'select item' to the select option
                cloned.find(".selectedItemDefault").prepend("<option value='' selected>Sélectionner un article</option>");

                resolve(selectedItemsArr);
            });
        }).then((selectedItemsArray) => {
            //If the input is from the barcode scanner, we need to check if the item has already been added to the list and just increment the qty instead of
            //re-adding it to the list, thus duplicating the item.
            if ($("#barcodeText").val()) {
                //This means our clickToClone btn was triggered after an item was scanned by the barcode scanner
                //Check the gotten selected items array if the item scanned has already been selected
                if (inArray($("#barcodeText").val().trim(), selectedItemsArray)) {
                    //increment it
                    $(".selectedItem").each(function () {
                        if ($(this).val() === $("#barcodeText").val()) {
                            let newVal = parseInt($(this).closest('div').siblings('.itemTransQtyDiv').find('.itemTransQty').val()) + 1;

                            $(this).closest('div').siblings('.itemTransQtyDiv').find('.itemTransQty').val(newVal);

                            //unset value in barcode input
                            $("#barcodeText").val('');

                            return false;
                        }
                    });
                } else {
                    //if it has not been selected previously, append it to the list and set it as the selected item
                    //then append our cloned div to div with id 'appendClonedDivHere'
                    cloned.appendTo("#appendClonedDivHere");

                    //add select2 to the 'select input'
                    cloned.find('.selectedItemDefault').select2();

                    //set it as the selected item
                    changeSelectedItemWithBarcodeText($("#barcodeText"), $("#barcodeText").val());
                }
            } else {//i.e. clickToClone clicked manually by user
                //do not append if no item is selected in the last select list
                if ($(".selectedItem").length > 0 && (!$(".selectedItem").last().val())) {
                    //do nothing
                } else {
                    //then append our cloned div to div with id 'appendClonedDivHere'
                    cloned.appendTo("#appendClonedDivHere");

                    //add select2 to the 'select input'
                    cloned.find('.selectedItemDefault').select2();
                }
            }
        }).catch(() => {
            console.log('promesse extérieure err');
        });

        return false;
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //WHEN USER CLICKS BTN TO REMOVE AN ITEM FROM THE TRANSACTION LIST
    $("#appendClonedDivHere").on('click', '.retrit', function (e) {
        e.preventDefault();

        $(this).closest(".transItemList").remove();

        ceipacp();//recalculate price
        calchadue();//also recalculate change due
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //reload transactions table when events occur
    $("#transListPerPage, #transListSortBy").change(function () {
        displayFlashMsg("S'il vous plaît, attendez...", spinnerClass, "", "");
        latr_();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    $("#transSearch").keyup(function () {
        let value = $(this).val();

        if (value) {
            $.ajax({
                url: appRoot + "search/transsearch",
                type: "get",
                data: {v: value},
                success: function (returnedData) {
                    $("#transListTable").html(returnedData.transTable);
                }
            });
        } else {
            //reload the table if all text in search box has been cleared
            latr_();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //enable/disable amount tendered input field based on the selected mode of payment
    $("#modeOfPayment").change(function () {
        let modeOfPayment = $(this).val();

        //remove any error message we might have
        $("#amountTenderedErr").html("");

        //unset the values of cashAmount and posAmount
        $("#cashAmount, #posAmount").val("");

        if (modeOfPayment === "POS") {
            /**
             * Change the Label
             * set the "cumulative amount" value field as the value of "amount tendered" and make the amountTendered field disabled
             * change "changeDue" to 0.00
             * hide "cash" an "pos" fields
             *
             */
            $("#amountTenderedLabel").html("Montant percu");
            $("#amountTendered").val($("#cumAmount").html()).prop('disabled', true);
            $("#changeDue").html('0.00');
            $(".cashAndPos").addClass('hidden');
        } else if (modeOfPayment === "Cash and POS") {
            /*
             * Change the label
             * make empty "amount tendered" field's value and also make it writable
             * unset any value that might be in "changeDue"
             * display "cash" an "pos" fields
             */
            $("#amountTenderedLabel").html("Total");
            $("#amountTendered").val('').prop('disabled', true);
            $("#changeDue").html('');
            $(".cashAndPos").removeClass('hidden');
        } else {//if cash. If something not recognise, we assume it is cash
            /*
             * change the label
             * empty and make amountTendered field writable
             * unset any value that might be in "changeDue"
             * hide "cash" an "pos" fields
             */
            $("#amountTenderedLabel").html("Montant percu");
            $("#amountTendered").val('').prop('disabled', false);
            $("#changeDue").html('');
            $(".cashAndPos").addClass('hidden');
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //calculate the change due based on the amount tendered. Also ensure amount tendered is not less than the cumulative amount
    $("#amountTendered").on('change focusout keyup keydown keypress', calchadue);

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*
     * unset mode of payment each time ".itemTransQty" changes
     * This will allow the user to be able to reselect the mode of payment,
     * thus enabling us to recalculate change due based on amount tendered
     */
    $("#appendClonedDivHere").on("change", ".itemTransQty", function (e) {
        e.preventDefault();

        return new Promise((resolve, reject) => {
            $("#modeOfPayment").val("");

            resolve();
        }).then(() => {
            ceipacp();
        }).catch();

        //recalculate
        ceipacp();

        $("#modeOfPayment").val("");
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * If mode of payment is "Cash and POS", both #cashAmount and #posAmount fields will be visible to user to add values
     * The addition of both will be set as the amount tendered
     */
    $("#cashAmount, #posAmount").on("change", function (e) {
        e.preventDefault();

        let totalAmountTendered = parseFloat($("#posAmount").val()) + parseFloat($("#cashAmount").val());

        //set amount tendered as the value of "totalAmountTendered" and then trigger the change event on it
        $("#amountTendered").val(isNaN(totalAmountTendered) ? "" : totalAmountTendered).change();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //calcuate cumulative amount if the percentage of VAT is changed
    $("#vat").change(ceipacp);

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //calcuate cumulative amount if the percentage of discount is changed
    $("#discount").change(ceipacp);

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //calculate discount percentage when discount (value) is changed
    $("#discountValue").change(function () {
        let discountValue = $(this).val();

        let discountPercentage = (discountValue / cumTotalWithoutVATAndDiscount) * 100;

        //display the discount (%)
        $("#discount").val(discountPercentage).change();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //handles the submission of a new sales order
    $("#confirmSaleOrder").click(function () {
        //ensure all fields are properly filled
        let amountTendered = parseFloat($("#amountTendered").val());
        let changeDue = $("#changeDue").html();
        let modeOfPayment = $("#modeOfPayment").val();
        let cumAmount = parseFloat($("#cumAmount").html());
        let arrToSend = [];
        let vatPercentage = $("#vat").val();
        let discountPercentage = $("#discount").val();
        let custName = $("#custName").val();
        let custPhone = $("#custPhone").val();
        let custEmail = $("#custEmail").val();
        let cashAmount = $("#cashAmount").val();
        let posAmount = $("#posAmount").val();

        if (modeOfPayment === 'Cash') {
            cashAmount = cumAmount;
            posAmount = 0;
        } else if (modeOfPayment === 'POS') {
            posAmount = cumAmount;
            cashAmount = 0;
        }


        if (isNaN(amountTendered) || (amountTendered === '0.00') || !modeOfPayment || (amountTendered < cumAmount)) {
            isNaN(amountTendered) || (amountTendered === '0.00') ? $("#amountTenderedErr").html("Champs obligatoires") : $("#amountTenderedErr").html("");
            !modeOfPayment ? $("#modeOfPaymentErr").html("Sélectionnez le mode de paiement") : $("#modeOfPaymentErr").html("");
            amountTendered < cumAmount ? $("#amountTenderedErr").html("Le montant ne peut être inférieur à " + cumAmount) : "";

            return;
        } else {
            //remove error messages if any
            changeInnerHTML(["amountTenderedErr", "modeOfPaymentErr"], "");

            //now get details of all items to be sold (itemCode, qty, unitPrice, totPrice)
            let selectedItemNode = document.getElementsByClassName("selectedItem");//get all elem with class "selectedItem"
            let selectedItemNodeLength = selectedItemNode.length;//get the number of elements with the class name

            let verifyCumAmount = 0;

            for (let i = 0; i < selectedItemNodeLength; i++) {
                let itemCode = selectedItemNode[i].value;

                let availQtyNode = selectedItemNode[i].parentNode.parentNode.children[1].children[1];
                let qtyNode = selectedItemNode[i].parentNode.parentNode.children[3].children[1];
                let unitPriceNode = selectedItemNode[i].parentNode.parentNode.children[2].children[1];
                let totalPriceNode = selectedItemNode[i].parentNode.parentNode.children[4].children[1];

                //get values
                let availQty = parseInt(availQtyNode.innerHTML);
                let qty = parseInt(qtyNode.value);
                let unitPrice = parseFloat(unitPriceNode.innerHTML);
                let totalPrice = parseFloat(totalPriceNode.innerHTML);
                let expectedTotPrice = +(unitPrice * qty).toFixed(2);

                //validate data
                if ((qty === 0) || (availQty < qty) || (expectedTotPrice !== totalPrice)) {
                    totalPriceNode.style.backgroundColor = expectedTotPrice !== totalPrice ? "red" : "";
                    qtyNode.style.backgroundColor = (qty === 0) || (availQty < qty) ? "red" : "";

                    return;
                } else {
                    //if all is well, remove all error bg color
                    totalPriceNode.style.backgroundColor = "";
                    qtyNode.style.backgroundColor = "";


                    //then prepare data to add to array of items' info
                    let itemInfo = {_iC: itemCode, qty: qty, unitPrice: unitPrice, totalPrice: totalPrice};

                    arrToSend.push(itemInfo);//add data to array

                    //if all is well, add totalPrice to calculate cumAmount
                    verifyCumAmount = (parseFloat(verifyCumAmount) + parseFloat(totalPrice));
                }
            }


            return new Promise(function (resolve, reject) {
                //calculate discount amount using the discount percentage
                let discountAmount = getDiscountAmount(verifyCumAmount);//get discount amount

                //display discount amount in discount(value) field
                $("#discountValue").val(discountAmount.toFixed(2));

                //now update verifyCumAmount by subtracting the discount amount from it
                verifyCumAmount = +(verifyCumAmount - discountAmount).toFixed(2);

                resolve();
            }).then(function () {
                //update verifyCumAmount by adding VAT
                let vatAmount = getVatAmount(verifyCumAmount);//get vat amount

                //now update verifyCumAmount by adding the amount of VAT to it
                verifyCumAmount = +(verifyCumAmount + vatAmount).toFixed(2);

                //stop execution if cumAmount is wrong
                if (verifyCumAmount !== cumAmount) {
                    $("#cumAmount").css('backgroundColor', 'red');
                    return;
                } else {
                    $("#cumAmount").css('backgroundColor', '');
                }

                let _aoi = JSON.stringify(arrToSend);//aoi = "All orders info"

                displayFlashMsg("Traitement de la transaction ...", spinnerClass, "", "");

                //send details to server
                $.ajax({
                    url: appRoot + "transactions/nso_",
                    method: "post",
                    data: {
                        _aoi: _aoi,
                        _mop: modeOfPayment,
                        _at: amountTendered,
                        _cd: changeDue,
                        _ca: cumAmount,
                        vat: vatPercentage,
                        discount: discountPercentage,
                        cn: custName,
                        ce: custEmail,
                        cp: custPhone,
                        ca: cashAmount,
                        pos: posAmount
                    },

                    success: function (returnedData) {
                        if (returnedData.status === 1) {
                            hideFlashMsg();

                            //reset the form
                            resetSalesTransForm();

                            //display receipt
                            $("#transReceipt").html(returnedData.transReceipt);//paste receipt
                            $("#transReceiptModal").modal('show');//show modal

                            //refresh the transaction list table
                            latr_();

                            setTimeout(function () {
                                $("#transReceiptModal").modal('hide');
                            }, 5000);

                            //update total earned today
                            $("#totalEarnedToday").html(returnedData.totalEarnedToday);

                            //remove all items list in transaction and leave just one
                            resetTransList();
                        } else {
                            changeFlashMsgContent(returnedData.msg, "", "red", "");
                        }
                    },

                    error: function () {
                        checkBrowserOnline(true);
                    }
                });
            }).catch(function () {
                console.log("Erreur");
            });
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //handles the submission of a new sales transaction
    $("#cancelSaleOrder").click(function (e) {
        e.preventDefault();

        resetSalesTransForm();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //WHEN THE "USE SCANNER" BTN IS CLICKED
    $("#useScanner").click(function (e) {
        e.preventDefault();

        //focus on the barcode text input
        $("#barcodeText").focus();
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //WHEN THE BARCODE TEXT INPUT VALUE CHANGED
    $("#barcodeText").keyup(function (e) {
        e.preventDefault();

        clearTimeout(barCodeTextTimeOut);

        let bText = $(this).val();
        let allItems = [];

        barCodeTextTimeOut = setTimeout(function () {
            if (bText) {
                for (let i in currentItems) {
                    if (bText === i) {
                        //remove any message that might have been previously displayed
                        $("#itemCodeNotFoundMsg").html("");

                        //if no select input has been added or the last select input has a value (i.e. an item has been selected)
                        if (!$(".selectedItem").length || $(".selectedItem").last().val()) {
                            //add a new item by triggering the clickToClone btn. This will handle everything from 'appending a list of items' to 'auto-selecting
                            //the corresponding item to the value detected by the scanner'
                            $("#clickToClone").click();
                        }

                        //else if the last select input doesn't have a value
                        else {
                            //just change the selected item to the corresponding code in let bText
                            changeSelectedItemWithBarcodeText($(this), bText);
                        }

                        break;
                    }

                    //if the value doesn't match the code of any item
                    else {
                        //display message telling user item not found
                        $("#itemCodeNotFoundMsg").css('color', 'red').html("Objet non-trouvé. L'article peut ne pas être enregistré.");
                    }
                }
            }
        }, 1500);
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //TO SHOW/HIDE THE TRANSACTION FORM
    $("#showTransForm").click(function () {
        $("#newTransDiv").toggleClass('collapse');

        if ($("#newTransDiv").hasClass('collapse')) {
            $(this).html("<i class='fa fa-plus'></i> Nouvelle Transaction");
        } else {
            $(this).html("<i class='fa fa-minus'></i> Nouvelle Transaction");

            //remove error messages
            $("#itemCodeNotFoundMsg").html("");
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //TO HIDE THE TRANSACTION FORM FROM THE TRANSACTION FORM
    $("#hideTransForm").click(function () {
        $("#newTransDiv").toggleClass('collapse');

        //remove error messages
        $("#itemCodeNotFoundMsg").html("");

        //change main "new transaction" button back to default
        $("#showTransForm").html("<i class='fa fa-plus'></i> Nouvelle Transaction");
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //PREVENT AUTO-SUBMISSION BY THE BARCODE SCANNER (this shouldn't matter but just to be on the safe side)
    $("#barcodeText").keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //INITIALISE datepicker on the "From date" and "To date" fields
    $('#datePair .date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        assumeNearbyYear: true,
        todayBtn: 'linked',
        todayHighlight: true,
        endDate: 'today'
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //INITIALISE datepair on the "From date" and "To date" fields
    $("#datePair").datepair();

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //WHEN "GENERATE REPORT" BUTTON IS CLICKED FROM THE MODAL
    $("#clickToGen").click(function (e) {
        e.preventDefault();

        let fromDate = $("#transFrom").val();
        let toDate = $("#transTo").val();

        if (!fromDate) {
            $("#transFromErr").html("Choisissez une date pour commencer");

            return;
        }

        /*
         * remove any error msg, hide modal, launch window to display the report in
         */

        $("#transFromErr").html("");
        $("#reportModal").modal('hide');

        let strWindowFeatures = "width=1000,height=500,scrollbars=yes,resizable=yes";

        window.open(appRoot + "transactions/report/" + fromDate + "/" + toDate, 'Print', strWindowFeatures);
    });
});


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * gti_ = "Get Transaction Info"
 * @param {type} transId
 * @returns {Boolean}
 */
function gti_(transId) {
    if (transId) {
        $("#transReceipt").html("<i class='fa fa-spinner faa-spin animated'></i> Loading...");

        //make server request to get information about transaction
        $.ajax({
            type: "POST",
            url: appRoot + "transactions/transactionReceipt",
            data: {transId: transId},
            success: function (returnedData) {
                if (returnedData.status === 1) {
                    $("#transReceipt").html(returnedData.transReceipt);
                } else {

                }
            },
            error: function () {
                alert("ERREUR!");
            }
        });
    }

    return false;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//to update transaction
function uptr_(transId) {
    //alert(transId);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * ceipacp = "Calculate each item's price and cumulative price"
 * This calculates the total price of each item selected for sale and also their cumulative amount
 * @returns {undefined}
 */
function ceipacp() {
    let cumulativePrice = 0;

    //loop through the items selected to calculate the total of each item
    $(".transItemList").each(function () {
        //current item's available quantity
        let availQty = parseFloat($(this).find(".itemAvailQty").html());

        //current item's quantity to be sold
        let transQty = parseInt($(this).find(".itemTransQty").val());

        //if the qty needed is greater than the qty available
        if (transQty > availQty) {
            //set the value back to the max available qty
            $(this).find(".itemTransQty").val(availQty);

            //display msg telling user the qty left
            $(this).find(".itemTransQtyErr").html("plus que " + availQty);

            ceipacp();//call itself in order to recalculate price
        } else {//if all is well
            //remove err msg if any
            $(this).find(".itemTransQtyErr").html("");

            //calculate the total price of current item
            let itemTotalPrice = parseFloat(($(this).find(".itemUnitPrice").html()) * transQty);

            //round to two decimal places
            itemTotalPrice = +(itemTotalPrice).toFixed(2);

            //display the total price
            $(this).find(".itemTotalPrice").html(itemTotalPrice);

            //add current item's total price to the cumulative amount
            cumulativePrice += itemTotalPrice;

            //set the total amount before any addition or dedcution
            cumTotalWithoutVATAndDiscount = cumulativePrice;
        }

        //trigger the click event of "use barcode" btn to focus on the barcode input text
        $("#useScanner").click();
    });

    return new Promise(function (resolve, reject) {
        //calculate discount amount using the discount percentage
        let discountAmount = getDiscountAmount(cumulativePrice);//get discount amount

        //display discount amount in discount(value) field
        $("#discountValue").val(discountAmount.toFixed(2));

        //now update verifyCumAmount by subtracting the discount amount from it
        cumulativePrice = +(cumulativePrice - discountAmount).toFixed(2);

        resolve();
    }).then(function () {
        //get vat amount
        let vatAmount = getVatAmount(cumulativePrice);

        //now update cumulativePrice by adding the amount of VAT to it
        cumulativePrice = +(cumulativePrice + vatAmount).toFixed(2);

        //display the cumulative amount
        $("#cumAmount").html(cumulativePrice);

        //update change due just in case amount tendered field is filled
        calchadue();
    }).catch(function () {
        console.log("Err");
    });
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Populates the available quantity and unit price of selected item to be sold
 * Auto set the quantity needed to 1
 * @param {type} selectedNode
 * @returns {undefined}
 */
function selectedItem(selectedNode) {
    if (selectedNode) {
        //get the elements of the selected item's avail qty and unit price
        let itemAvailQtyElem = selectedNode.parentNode.parentNode.children[1].children[1];
        let itemUnitPriceElem = selectedNode.parentNode.parentNode.children[2].children[1];
        let qtyNeededElem = selectedNode.parentNode.parentNode.children[3].children[1];

        let itemCode = selectedNode.value;

        //displayFlashMsg("Getting item info...", spinnerClass, "", "");

        //get item's available quantity and unitPrice
        $.ajax({
            url: appRoot + "items/gcoandqty",
            type: "get",
            data: {_iC: itemCode},
            success: function (returnedData) {
                if (returnedData.status === 1) {
                    itemAvailQtyElem.innerHTML = returnedData.availQty;
                    itemUnitPriceElem.innerHTML = parseFloat(returnedData.unitPrice);

                    qtyNeededElem.value = 1;

                    ceipacp();//recalculate since item has been changed/added
                    calchadue();//update change due as well in case amount tendered is not empty

                    //hideFlashMsg();

                    //return focus to the hidden barcode input
                    $("#useScanner").click();
                } else {
                    itemAvailQtyElem.innerHTML = "0";
                    itemUnitPriceElem.innerHTML = "0.00";

                    ceipacp();//recalculate since item has been changed/added
                    calchadue();//update change due as well in case amount tendered is not empty

                    //changeFlashMsgContent("Item not found", "", "red", "");
                }
            }
        });
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * calchadue = "Calculate change due"
 * @returns {undefined}
 */
function calchadue() {
    let cumAmount = parseFloat($("#cumAmount").html());
    let amountTendered = parseFloat($("#amountTendered").val());

    if (amountTendered && (amountTendered < cumAmount)) {
        $("#amountTenderedErr").html("Le montant ne peut être inférieur à USD" + cumAmount);

        //remove change due if any
        $("#changeDue").html("");
    } else if (amountTendered) {
        $("#changeDue").html(+(amountTendered - cumAmount).toFixed(2));

        //remove error msg if any
        $("#amountTenderedErr").html("");
    }

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function resetSalesTransForm() {
    document.getElementById('salesTransForm').reset();

    $(".itemUnitPrice, .itemTotalPrice, #cumAmount, #changeDue").html("0.00");
    $(".itemAvailQty").html("0");
    $("#amountTendered").prop('disabled', false);

    //remove error messages
    $("#itemCodeNotFoundMsg").html("");

    //remove all appended lists
    $("#appendClonedDivHere").html("");
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * ctr_ = "Close Transaction receipt". This is for the receipt being displayed immediately the sales order is done
 * @deprecated v1.0.0
 * @returns {undefined}
 */
function ctr_() {
    //hide receipt and display form
    $("#salesTransFormDiv").removeClass("hidden");
    $("#showTransReceipt").addClass("hidden").html("");
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function resetTransList() {
    let tot = $(".transItemList").length;

    $(".transItemList").each(function () {
        if ($(".transItemList").length > 1) {
            $(this).remove();
        } else {
            return "";
        }
    });
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * latr_ = "Load all transactions"
 * @param {type} url
 * @returns {Boolean}
 */
function latr_(url) {
    let orderBy = $("#transListSortBy").val().split("-")[0];
    let orderFormat = $("#transListSortBy").val().split("-")[1];
    let limit = $("#transListPerPage").val();

    $.ajax({
        type: 'get',
        url: url ? url : appRoot + "transactions/latr_?dette=true",
        data: {orderBy: orderBy, orderFormat: orderFormat, limit: limit},

        success: function (returnedData) {
            hideFlashMsg();

            $("#transListTable").html(returnedData.transTable);
        },

        error: function () {

        }
    });

    return false;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function changeSelectedItemWithBarcodeText(barcodeTextElem, selectedItem) {
    $(".selectedItem").last().val(selectedItem).change();

    //then remove the value from the input
    $(barcodeTextElem).val("");
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getVatAmount(cumAmount) {
    //update cumAmount by adding the amount VAT to it
    let vatPercentage = $("#vat").val();//get vat percentage

    //calculate the amount vat will be
    let vatAmount = parseFloat((vatPercentage / 100) * cumAmount);

    return vatAmount;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getDiscountAmount(cumAmount) {
    //update cumAmount by subtracting discount amount from it
    let discountPercentage = $("#discount").val();//get discount percentage
    discountPercentage = discountPercentage ?? 0;
    //calculate the discount amount
    let discountAmount = parseFloat((discountPercentage / 100) * cumAmount);

    return discountAmount;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//triggers when an item's "edit" icon is clicked
$("#transListTable").on('click', ".makePayment", function (e) {
    e.preventDefault();
    //fixme: change me
    //get item info
    const itemId = $(this).attr('id').split("-")[1];
    const montantApayer = parseFloat($("#total-" + itemId).html());

    $("#montantApayer").html(montantApayer);
    $("#montantPercuErr").html();

    const transref = $(this).attr('id').split("-")[0];
    $("#ref").html(transref);

    $("#paymentModal").modal('show');
});

$("#montantPercu").on('change focusout keyup keydown keypress', calculmonnaiedue);

function calculmonnaiedue() {
    let montantPercu = parseFloat($("#montantPercu").val());
    let montantApayer = parseFloat($("#montantApayer").html());

    /*if (montantPercu && (montantPercu < montantApayer)) {
        // $("#montantPercuErr").html("Le montant ne peut être inférieur à USD" + montantApayer);
        //remove change due if any
        $("#monnaieDue").html("");
    } else */
    if (montantPercu) {
        if (montantPercu < montantApayer) {
            $("#monnaieDue").html('0');
        } else {
            $("#monnaieDue").html(+(montantPercu - montantApayer).toFixed(2));
        }

        //remove error msg if any
        $("#montantPercuErr").html("");
    }
}

$("#paymentSubmit").click(function () {
    let montantApayer = parseFloat($("#montantApayer").html());
    let montantPercu = parseFloat($("#montantPercu").val());
    let monnaieDue = parseFloat($("#monnaieDue").html());
    let ref = $("#ref").html();

    monnaieDue = (monnaieDue) ? monnaieDue : 0;

    if (!montantApayer || !montantPercu) {
        !montantPercu ? $("#montantPercuErr").html("Vous devez entrer le montant perçu") : "";
        !montantApayer ? $("#montantApayerErr").html("Le montant à payer ne peut être vide") : "";
        // !monnaieDue ? $("#monnaieDueErr").html("La monnaie à retourner ne peut être vide") : "";
        return;
    }

    $("#editItemFMsg").css('color', 'black').html("<i class='" + spinnerClass + "'></i> Traitement de votre requête....");

    $.ajax({
        method: "POST",
        url: appRoot + "transactions/payment",
        data: {
            monnaieDue: monnaieDue,
            // montantApayer: montantApayer,
            montantPercu: montantPercu,
            ref: ref
        }
    }).done(function (returnedData) {
        if (returnedData.status === 1) {
            $("#editItemFMsg").css('color', 'green').html("paiement ajouté avec succès");

            setTimeout(function () {
                $("#paymentModal").modal('hide');
            }, 1000);

            $("#montantApayer").html("");
            $("#montantPercu").val("");
            $("#monnaieDue").html("");
            $("#editItemFMsg").html("");

            latr_();
        } else {
            $("#editItemFMsg").css('color', 'red').html("Un ou plusieurs champs obligatoires sont vide ou mal remplis");

            // Todo:: add error message
            // $("#itemNameEditErr").html(returnedData.itemName);
            // $("#itemCodeEditErr").html(returnedData.itemCode);
            // $("#itemCategoriesEditErr").html(returnedData.itemCategories);
            // $("#itemPriceEditErr").html(returnedData.itemPrice);
        }
    }).fail(function () {
        $("#editItemFMsg").css('color', 'red').html("Vous semblez être hors ligne. Reconnectez-vous à internet puis réessayer svp !");
    });
});
