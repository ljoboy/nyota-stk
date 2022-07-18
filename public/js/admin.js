'use strict';

$(document).ready(function () {
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status


    //load all admin once the page is ready
    //function header: laad_(url)
    laad_();

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //reload the list of admin when fields are changed
    $("#adminListSortBy, #adminListPerPage").change(function () {
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        laad_();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //load and show page when pagination link is clicked
    $("#allAdmin").on('click', '.lnp', function (e) {
        e.preventDefault();

        displayFlashMsg("Patientez svp ...", spinnerClass, "", "");

        laad_($(this).attr('href'));

        return false;
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Check to ensure the password and retype password fields are the same
    $("#passwordDup").on('keyup change focusout focus focusin', function () {
        var orig = $("#passwordOrig").val();
        var dup = $("#passwordDup").val();

        if (dup !== orig) {
            //show error
            $("#passwordDupErr").addClass('fa');
            $("#passwordDupErr").addClass('fa-times');
            $("#passwordDupErr").removeClass('fa-check');
            $("#passwordDupErr").css('color', 'red');
            $("#passwordDupErr").html("");
        } else {
            //show success
            $("#passwordDupErr").addClass('fa');
            $("#passwordDupErr").addClass('fa-check');
            $("#passwordDupErr").removeClass('fa-times');
            $("#passwordDupErr").css('color', 'green');
            $("#passwordDupErr").html("");
        }
    });

    //Check to ensure the password and retype password fields are the same
    $("#passwordChngDup").on('keyup change focusout focus focusin', function () {
        var orig = $("#passwordChng").val();
        var dup = $("#passwordChngDup").val();

        if (dup !== orig) {
            //show error
            $("#passwordChngDupErr").addClass('fa');
            $("#passwordChngDupErr").addClass('fa-times');
            $("#passwordChngDupErr").removeClass('fa-check');
            $("#passwordChngDupErr").css('color', 'red');
            $("#passwordChngDupErr").html("");
        } else {
            //show success
            $("#passwordChngDupErr").addClass('fa');
            $("#passwordChngDupErr").addClass('fa-check');
            $("#passwordChngDupErr").removeClass('fa-times');
            $("#passwordChngDupErr").css('color', 'green');
            $("#passwordChngDupErr").html("");
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //handles the addition of new admin details .i.e. when "add admin" button is clicked
    $("#addAdminSubmit").click(function (e) {
        e.preventDefault();

        //reset all error msgs in case they are set
        changeInnerHTML(['firstNameErr', 'lastNameErr', 'emailErr', 'roleErr', 'mobile1Err', 'mobile2Err', 'passwordOrigErr', 'passwordDupErr'],
            "");

        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();
        var email = $("#email").val();
        var role = $("#role").val();
        var mobile1 = $("#mobile1").val();
        var mobile2 = $("#mobile2").val();
        var passwordOrig = $("#passwordOrig").val();
        var passwordDup = $("#passwordDup").val();

        //ensure all required fields are filled
        if (!firstName || !lastName || !email || !role || !mobile1 || !passwordOrig || !passwordDup) {
            !firstName ? changeInnerHTML('firstNameErr', "Champ obligatoire") : "";
            !lastName ? changeInnerHTML('lastNameErr', "Champ obligatoire") : "";
            !email ? changeInnerHTML('emailErr', "Champ obligatoire") : "";
            !role ? changeInnerHTML('roleErr', "Champ obligatoire") : "";
            !mobile1 ? changeInnerHTML('mobile1Err', "Champ obligatoire") : "";
            !passwordOrig ? changeInnerHTML('passwordOrigErr', "Champ obligatoire") : "";
            !passwordDup ? changeInnerHTML('passwordDupErr', 'Champ obligatoire') : "";

            return;
        }

        //display message telling user action is being processed
        $("#fMsgIcon").attr('class', spinnerClass);
        $("#fMsg").text(" En cours...");

        //make ajax request if all is well
        $.ajax({
            method: "POST",
            url: appRoot + "administrators/add",
            data: {
                firstName: firstName, lastName: lastName, email: email, role: role, mobile1: mobile1, mobile2: mobile2,
                passwordOrig: passwordOrig, passwordDup: passwordDup
            }
        }).done(function (returnedData) {
            $("#fMsgIcon").removeClass();//remove spinner

            if (returnedData.status === 1) {
                $("#fMsg").css('color', 'green').text(returnedData.msg);

                //reset the form
                document.getElementById("addNewAdminForm").reset();

                //close the modal
                setTimeout(function () {
                    $("#fMsg").text("");
                    $("#addNewAdminModal").modal('hide');
                }, 1000);

                //reset all error msgs in case they are set
                changeInnerHTML(['firstNameErr', 'lastNameErr', 'emailErr', 'roleErr', 'mobile1Err', 'mobile2Err', 'passwordOrigErr', 'passwordDupErr'],
                    "");

                //refresh admin list table
                laad_();

            } else {
                //display error message returned
                $("#fMsg").css('color', 'red').html(returnedData.msg);

                //display individual error messages if applied
                $("#firstNameErr").text(returnedData.firstName);
                $("#lastNameErr").text(returnedData.lastName);
                $("#emailErr").text(returnedData.email);
                $("#roleErr").text(returnedData.role);
                $("#mobile1Err").text(returnedData.mobile1);
                $("#mobile2Err").text(returnedData.mobile2);
                $("#passwordOrigErr").text(returnedData.passwordOrig);
                $("#passwordDupErr").text(returnedData.passwordDup);
            }
        }).fail(function () {
            if (!navigator.onLine) {
                $("#fMsg").css('color', 'red').text("Erreur du réseau ! Verifiez votre connexion svp");
            }
        });
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //handles the updating of admin details
    $("#editAdminSubmit").click(function (e) {
        e.preventDefault();

        if (formChanges("editAdminForm")) {
            //reset all error msgs in case they are set
            changeInnerHTML(['firstNameEditErr', 'lastNameEditErr', 'emailEditErr', 'roleEditErr', 'mobile1Err', 'mobile2Err'], "");

            var firstName = $("#firstNameEdit").val();
            var lastName = $("#lastNameEdit").val();
            var email = $("#emailEdit").val();
            var mobile1 = $("#mobile1Edit").val();
            var mobile2 = $("#mobile2Edit").val();
            var role = $("#roleEdit").val();
            var adminId = $("#adminId").val();

            //ensure all required fields are filled
            if (!firstName || !lastName || !email || !role || !mobile1) {
                !firstName ? changeInnerHTML('firstNameEditErr', "Champ obligatoire") : "";
                !lastName ? changeInnerHTML('lastNameEditErr', "Champ obligatoire") : "";
                !email ? changeInnerHTML('emailEditErr', "Champ obligatoire") : "";
                !mobile1 ? changeInnerHTML('mobile1EditErr', "Champ obligatoire") : "";
                !role ? changeInnerHTML('roleEditErr', "Champ obligatoire") : "";

                return;
            }

            if (!adminId) {
                $("#fMsgEdit").text("Une erreur inattendue s'est produite lors de la modification des détails de l'administrateur");
                return;
            }

            //display message telling user action is being processed
            $("#fMsgEditIcon").attr('class', spinnerClass);
            $("#fMsgEdit").text(" Mise à jour des détails...");

            //make ajax request if all is well
            $.ajax({
                method: "POST",
                url: appRoot + "administrators/update",
                data: {
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    role: role,
                    mobile1: mobile1,
                    mobile2: mobile2,
                    adminId: adminId
                }
            }).done(function (returnedData) {
                $("#fMsgEditIcon").removeClass();//remove spinner

                if (returnedData.status === 1) {
                    $("#fMsgEdit").css('color', 'green').text(returnedData.msg);

                    //reset the form and close the modal
                    setTimeout(function () {
                        $("#fMsgEdit").text("");
                        $("#editAdminModal").modal('hide');
                    }, 1000);

                    //reset all error msgs in case they are set
                    changeInnerHTML(['firstNameEditErr', 'lastNameEditErr', 'emailEditErr', 'roleEditErr', 'mobile1Err', 'mobile2Err'], "");

                    //refresh admin list table
                    laad_();

                } else {
                    //display error message returned
                    $("#fMsgEdit").css('color', 'red').html(returnedData.msg);

                    //display individual error messages if applied
                    $("#firstNameEditErr").html(returnedData.firstName);
                    $("#lastNameEditErr").html(returnedData.lastName);
                    $("#emailEditErr").html(returnedData.email);
                    $("#mobile1EditErr").html(returnedData.mobile1);
                    $("#mobile2EditErr").html(returnedData.mobile2);
                    $("#roleEditErr").html(returnedData.role);
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

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //handles admin search
    $("#adminSearch").on('keyup change', function () {
        var value = $(this).val();

        if (value) {//search only if there is at least one char in input
            $.ajax({
                type: "get",
                url: appRoot + "search/adminsearch",
                data: {v: value},
                success: function (returnedData) {
                    $("#allAdmin").html(returnedData.adminTable);
                }
            });
        } else {
            laad_();
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //When the toggle on/off button is clicked to change the account status of an admin (i.e. suspend or lift suspension)
    $("#allAdmin").on('click', '.suspendAdmin', function () {
        var ElemId = $(this).attr('id');

        var adminId = ElemId.split("-")[1];//get the adminId

        //show spinner
        $("#" + ElemId).html("<i class='" + spinnerClass + "'</i>");

        if (adminId) {
            $.ajax({
                url: appRoot + "administrators/suspend",
                method: "POST",
                data: {_aId: adminId}
            }).done(function (returnedData) {
                if (returnedData.status === 1) {
                    //change the icon to "on" if it's "off" before the change and vice-versa
                    var newIconClass = returnedData._ns === 1 ? "fa fa-toggle-on pointer" : "fa fa-toggle-off pointer";

                    //change the icon
                    $("#sus-" + returnedData._aId).html("<i class='" + newIconClass + "'></i>");

                } else {
                    console.log('err');
                }
            });
        }
    });


    /*
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    */


    //When the trash icon in front of an admin account is clicked on the admin list table (i.e. to delete the account)
    $("#allAdmin").on('click', '.deleteAdmin', function () {
        var confirm = window.confirm("Procéder ?");

        if (confirm) {
            var ElemId = $(this).attr('id');

            var adminId = ElemId.split("-")[1];//get the adminId

            //show spinner
            $("#" + ElemId).html("<i class='" + spinnerClass + "'</i>");

            if (adminId) {
                $.ajax({
                    url: appRoot + "administrators/delete",
                    method: "POST",
                    data: {_aId: adminId}
                }).done(function (returnedData) {
                    if (returnedData.status === 1) {

                        //change the icon to "undo delete" if it's "active" before the change and vice-versa
                        var newHTML = returnedData._nv === 1 ? "<a class='pointer'>Annuler Suppression</a>" : "<i class='fa fa-trash pointer'></i>";

                        //change the icon
                        $("#del-" + returnedData._aId).html(newHTML);

                    } else {
                        alert(returnedData.status);
                    }
                });
            }
        }
    });


    /*
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    */


    //to launch the modal to allow for the editing of admin info
    $("#allAdmin").on('click', '.editAdmin', function () {

        var adminId = $(this).attr('id').split("-")[1];

        $("#adminId").val(adminId);

        //get info of admin with adminId and prefill the form with it
        //alert($(this).siblings(".adminEmail").children('a').html());
        var firstName = $(this).siblings(".firstName").html();
        var lastName = $(this).siblings(".lastName").html();
        var role = $(this).siblings(".adminRole").html();
        var email = $(this).siblings(".adminEmail").children('a').html();
        var mobile1 = $(this).siblings(".adminMobile1").html();
        var mobile2 = $(this).siblings(".adminMobile2").html();

        //prefill the form fields
        $("#firstNameEdit").val(firstName);
        $("#lastNameEdit").val(lastName);
        $("#emailEdit").val(email);
        $("#mobile1Edit").val(mobile1);
        $("#mobile2Edit").val(mobile2);
        $("#roleEdit").val(role);

        $("#editAdminModal").modal('show');
    });

    $("#allAdmin").on('click', '.editPassword', function () {
        let adminId = $(this).attr('id').split("-")[1];

        $("#adminPassId").val(adminId);

        $("#passwordChng").val('');
        $("#passwordChngDup").val('');
        $("#fMsgEditIcon").removeClass();

        $("#editPassModal").modal('show');
    });
});


$("#editPassSubmit").click(function (e) {
    e.preventDefault();

    changeInnerHTML(['passwordChngDupErr', 'passwordChngErr', 'fPassEdit'], '');

    let adminId = $("#adminPassId").val();
    let password = $("#passwordChng").val();
    let passwordDup = $("#passwordChngDup").val();

    if (!adminId || !password || !passwordDup) {
        !adminId ? changeInnerHTML('fPassEdit', "Une erreur inattendue s'est produite lors de la modification des détails de l'administrateur") : "";
        !password ? changeInnerHTML('passwordChngErr', 'Champ obligatoire') : "";
        !passwordDup ? changeInnerHTML('passwordChngDupErr', 'Champ obligatoire') : "";
        return;
    }

    //display message telling user action is being processed
    $("#fMsgPassIcon").attr('class', spinnerClass);
    $("#fPassEdit").text(" Mise à jour des détails...");

    $.ajax({
        method: "POST",
        url: appRoot + "administrators/password_update",
        data: {
            adminId: adminId,
            password: password,
            passwordDup: passwordDup
        }
    }).done(function (returnedData) {

        if (returnedData.status === 1) {
            $("#fPassEdit").css('color', 'green').text(returnedData.msg);
            $("#fMsgEditIcon").removeClass();

            setTimeout(function () {
                $("#fPassEdit").text("");
                $("#fMsgEditIcon").removeClass();
                $("#editPassModal").modal('hide');
            }, 2000);

            changeInnerHTML(['passwordChngDupErr', 'passwordChngErr', 'fPassEdit'], '');

        } else {
            $("#fPassEdit").css('color', 'red').text(returnedData.msg);

            // $("#passwordChngDupErr").html();
            // $("#passwordChngErr").html();

            setTimeout(function () {
                $("#fPassEdit").text("");
                $("#fMsgEditIcon").removeClass();
                $("#editPassModal").modal('hide');
            }, 3000);
        }
    });

});


/*
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
*/

/**
 * laad_ = "Load all administrators"
 * @returns {undefined}
 */
function laad_(url) {
    var orderBy = $("#adminListSortBy").val().split("-")[0];
    var orderFormat = $("#adminListSortBy").val().split("-")[1];
    var limit = $("#adminListPerPage").val();

    $.ajax({
        type: 'get',
        url: url ? url : appRoot + "administrators/laad_/",
        data: {orderBy: orderBy, orderFormat: orderFormat, limit: limit},
    }).done(function (returnedData) {
        hideFlashMsg();

        $("#allAdmin").html(returnedData.adminTable);
    });
}
