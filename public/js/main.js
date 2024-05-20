'use strict';

var appRoot = setAppRoot("", "");
var spinnerClass = 'fa fa-spinner faa-spin animated';

// To style only selects with the my-select class
$('.itemCategories').selectpicker();

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    //get total amount earned on current day(on page load)
    totalEarnedToday();


    //to view transaction receipt
    $("#transListTable").on('click', '.vtr', function () {
        vtr_(this);
    });


    //To validate form fields
    $('form').on('change', '.checkField', function () {

        //set the id of the span any error will be displayed
        //It's usually the id of the form field plus the string "Err"
        let errSpan = "#" + $(this).attr('id') + "Err";

        if ($(this).val()) {
            $(errSpan).html('');
        } else {
            $(errSpan).html('Champs obligatoires');
        }
    });


    //to print receipt
    $("#transReceiptModal").on('click', '.ptr', function () {
        ptr_();
    });


    //when the close button on the login modal is clicked
    $(".closeLogInModal").click(function () {
        //redirect to landing page
        window.location.href = appRoot;
    });


    //WHEN THE SUBMIT BUTTON ON THE LOG IN MODAL IS CLICKED
    $("#loginModalSubmit").click(function (e) {
        e.preventDefault();

        var email = $("#logInModalEmail").val();
        var password = $("#logInModalPassword").val();

        if (!email || !password) {
            //display error message
            $("#logInModalFMsg").css('color', 'red').html("Entrez votre email et votre mot de passe s'il vous plaît");
            return;
        }


        //display progress message
        $("#logInModalFMsg").css('color', 'black').html("Authentification S'il vous plaît, attendez...");


        //call function to handle log in and get the returned data through a callback
        handleLogin(email, password, function (returnedData) {
            if (returnedData.status === 1) {
                $("#logInModalFMsg").css('color', 'green').html(returnedData.msg);

                //reload current page
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                //display error message
                $("#logInModalFMsg").css('color', 'red').html(returnedData.msg);
            }
        });

    });


    //TRIGGER FILE DIALOG WHEN BUTTON IS CLICKED
    $("#importdb").click(function (e) {
        e.preventDefault();

        $("#selecteddbfile").click();
    });

    //Save the db locally and remotely
    $("#savedb").click(function (e) {
        e.preventDefault();
        $("#saveDbMsg").css('color', 'black').html("<i class='" + spinnerClass + "'></i> Traitement de votre requête...");
        $.ajax({
            /*if (status === 'success') {
                msg = "Sauvegarde de la Base de Donnée réussie"
                $("#saveDbMsg").css('color', 'green').text(msg);
            } else {
                msg = "Sauvegarde de la Base de Donnée echouée"
                $("#saveDbMsg").css('color', 'red').text(msg);
            }*/
            url: `${appRoot}/misc/dldb`,
            method: "POST",
            cache: false,
            processData: false,
            contentType: false
        }).done(function (rd) {
            if (rd.status === 1) {
                $("#saveDbMsg").css('color', 'green').html(rd.msg);
                setTimeout(function () {
                    $("#saveDbMsg").html("");
                }, 5000);
            } else {
                $("#saveDbMsg").css('color', 'red').html(rd.msg);
                setTimeout(function () {
                    $("#saveDbMsg").html("");
                }, 5000);
            }
        }).fail(function () {
            $("#saveDbMsg").css('color', 'red').html("Vous semblez ëtre hors ligne. Reconnectez-vous à internet puis réessayer svp !");
            setTimeout(function () {
                $("#saveDbMsg").html("");
            }, 5000);
        });

    });


    $("#selecteddbfile").change(function (e) {
        e.preventDefault();

        var file = $("#selecteddbfile").get(0).files[0];

        if (file) {
            var formData = new FormData();

            formData.append('dbfile', file);

            $("#dbFileMsg").css('color', 'black').html("<i class='" + spinnerClass + "'></i> Importation de base de données");

            $.ajax({
                url: appRoot + "misc/importdb",
                method: "POST",
                data: formData,
                cache: false,
                processData: false,
                contentType: false
            }).done(function (rd) {
                //remove the file from the input
                $("#selecteddbfile").val("");

                if (rd.status === 1) {
                    //display success message
                    $("#dbFileMsg").css('color', 'green').html("Base de données importée avec succès");

                    //clear the success msg after a while
                    setTimeout(function () {
                        $("#dbFileMsg").html("");
                    }, 5000);
                } else {
                    //display error message
                    $("#dbFileMsg").css('color', 'red').html(rd.msg);
                    setTimeout(function () {
                        $("#dbFileMsg").html("");
                    }, 5000);
                }
            }).fail(function () {
                $("#dbFileMsg").css('color', 'red').html("Vous semblez ëtre hors ligne. Reconnectez-vous à internet puis réessayer svp !");
                setTimeout(function () {
                    $("#dbFileMsg").html("");
                }, 5000);
            });
        }
    });
});


/**
 * Print transaction receipt (from the customer's transaction history page)
 * @returns {undefined}
 */
function ptr_() {
    //change the font-size
    $("#transReceiptToPrint").css({fontSize: '8px'});

    window.print();//trigger the print dialog

    $("#transReceiptModal").modal('hide');//dismiss modal
}

/**
 * Change the class name of elements
 * @param {type} elementId
 * @param {type} newClassName
 * @returns {String}
 */
function changeClassName(elementId, newClassName) {

    //just change value if it's a single element
    if (typeof (elementId) === "string") {
        $("#" + elementId).attr('class', newClassName);
    }

    //loop through if it's an array
    else {
        var i;

        for (i in elementId) {
            $("#" + elementId[i]).attr('class', newClassName);
        }
    }
    return "";
}


/**
 * Change the innerHTML of elements
 * @param {any} elementId
 * @param {string} newValue
 * @returns {String}
 */
function changeInnerHTML(elementId, newValue) {
    //just change value if it's a single element
    if (typeof (elementId) === "string") {
        $("#" + elementId).html(newValue);
    }

    //loop through if it's an array
    else {
        var i;

        for (i in elementId) {
            $("#" + elementId[i]).html(newValue);
        }
    }


    return "";
}


/**
 * Change the value of elements
 * @param {type} elementId
 * @param {type} newValue
 * @returns {String}
 */
function changeElementValue(elementId, newValue) {

    //just change value if it's a single element i.e. if elementId passed to function is not an array
    if (typeof (elementId) === "string") {
        $("#" + elementId).val(newValue);
    }

    //loop through if it's an array
    else {
        var i;

        for (i in elementId) {
            $("#" + elementId[i]).val(newValue);
        }
    }
    return "";
}


/**
 *
 * @param urlToLoad
 * @returns {undefined}
 */
function loadPage(urlToLoad) {
    $.ajax({
        type: "GET",
        url: appRoot + urlToLoad,
        success: function (returnedData) {
            document.getElementById('pageContent').innerHTML = returnedData.pageContent;
            document.getElementById('pageTitle').innerHTML = returnedData.pageTitle;
            //window.history.pushState("", "", "");
        }
    });
}


/**
 * Checks if changes are made to a form
 * credits to Craig Buckler "http://www.sitepoint.com/javascript-form-change-checker/"
 * @param {type} form
 * @returns {boolean}
 */
function formChanges(form) {
    if (typeof (form) === "string") {
        form = document.getElementById(form);
    }

    if (!form || !form.nodeName || form.nodeName.toLowerCase() !== "form") {
        return null;
    }

    let changed = [], n, c, def, o, ol, opt;

    for (var e = 0, el = form.elements.length; e < el; e++) {
        n = form.elements[e];
        c = false;

        switch (n.nodeName.toLowerCase()) {

            // select boxes
            case "select":
                def = 0;

                for (o = 0, ol = n.options.length; o < ol; o++) {
                    opt = n.options[o];
                    c = c || (opt.selected !== opt.defaultSelected);
                    if (opt.defaultSelected) {
                        def = o;
                    }
                }

                if (c && !n.multiple) {
                    c = (def !== n.selectedIndex);
                }
                break;

            //input/textarea
            case "textarea":
            case "input":

                switch (n.type.toLowerCase()) {
                    case "checkbox":
                    case "radio":

                        // checkbox / radio
                        c = (n.checked !== n.defaultChecked);
                        break;

                    default:
                        // standard values
                        c = (n.value !== n.defaultValue);
                        break;
                }

                break;
        }

        if (c) {
            changed.push(n);
        }
    }


    //return true or false based on the length of variable "changed"
    return changed.length > 0;
}


/**
 * Function to handle the display of messages
 * @param {string} msg
 * @param {type} iconClassName
 * @param {type} color
 * @param {type} time
 * @returns {undefined}
 */
function displayFlashMsg(msg, iconClassName, color, time) {
    changeClassName('flashMsgIcon', iconClassName);//set spinner class name
    $("#flashMsg").css('color', color);//change font color
    changeInnerHTML('flashMsg', msg);//set message to display
    $("#flashMsgModal").modal('show');//display modal

    //hide the modal after a specified time if time is specified
    if (time) {
        setTimeout(function () {
            $("#flashMsgModal").modal('hide');
        }, time);
    }
}


/**
 *
 * @returns {undefined}
 */
function hideFlashMsg() {
    changeClassName('flashMsgIcon', "");//set spinner class name
    $("#flashMsg").css('color', '');//change font color
    changeInnerHTML('flashMsg', "");//set message to display
    $("#flashMsgModal").modal('hide');//hide modal
}


/**
 * Change message being displayed and hide the modal if time is set
 * @param {type} msg
 * @param {string} iconClassName
 * @param {type} color
 * @param {type} time
 * @returns {undefined}
 */
function changeFlashMsgContent(msg, iconClassName, color, time) {
    changeClassName('flashMsgIcon', iconClassName);//set spinner class name
    $("#flashMsg").css('color', color);//change font color
    changeInnerHTML('flashMsg', msg);//set message to display

    //hide the modal after a specified time if time is specified
    if (time) {
        setTimeout(function () {
            $("#flashMsgModal").modal('hide');
        }, time);
    }
}


/**
 * To make the class of the current page "menu name" as active
 * @returns {undefined}
 */
function tc_(elemId) {
    $("#" + elemId).attr("class", "active");
}


/**
 * To ensure only numbers are allowed as input
 * @param {type} value
 * @param {type} elementId
 * @returns {undefined}
 */
function numOnly(value, elementId) {
    $("#" + elementId).val(value.replace(/\D+/g, ""));
}


/**
 * to stop interval set
 * @param {type} intervalObj
 * @returns {undefined}
 */
function stopInterval(intervalObj) {
    clearInterval(intervalObj);
}


/**
 *
 * @param {type} length
 * @returns {String}
 */
function randomString(length) {
    return Math.random().toString(36).slice(2).substring(0, length);
}


/**
 * vtr_ = "View transaction's receipt"
 * @param {type} elem
 * @returns {undefined}
 */
function vtr_(elem) {
    let ref = elem.innerHTML;

    if (ref) {
        //show the loading icon
        $("#transReceipt").html("<i class='fa fa-spinner faa-spin animated'></i> Loading receipt");

        //show modal
        $("#transReceiptModal").modal('show');

        //make server request
        $.ajax({
            url: appRoot + "transactions/vtr_",
            type: "post",
            data: {ref: ref},
            success: function (returnedData) {
                if (returnedData.status === 1) {
                    $("#transReceipt").html(returnedData.transReceipt);
                } else {
                    $("#transReceipt").html("Transaction non trouvée");
                }
            }
        });
    }
}


/**
 * drm = "Dismiss receipt modal"
 * @returns {undefined}
 */
function drm_() {
    $("#transReceiptModal").modal("hide");
}


function totalEarnedToday() {
    $.ajax({
        method: "POST",
        url: appRoot + "misc/totalearnedtoday"
    }).done(function (returnedData) {
        //paste the returnedData on the navbar to show total amount earned on current day
        $("#totalEarnedToday").html(returnedData.totalEarnedToday);
    });
}


/**
 *
 * @param {type} value
 * @param {type} errorElementId
 * @returns {undefined}
 */
function checkField(value, errorElementId) {
    if (value) {
        $("#" + errorElementId).html('');
    } else {
        $("#" + errorElementId).html('Champs obligatoires');
    }
}


/**
 * call function "functionToCall" if document has focus
 * Check Andy E's answer: https://stackoverflow.com/questions/1060008/is-there-a-way-to-detect-if-a-browser-window-is-not-currently-active
 * @param {type} functionToCall
 * @returns {undefined}
 */
function checkDocumentVisibility(functionToCall) {
    let hidden = "hidden";

    //detect if page has focus and check login status if it does
    if (hidden in document) {//for browsers that support visibility API
        $(document).on("visibilitychange", functionToCall);
    } else if ((hidden = "mozHidden") in document) {
        document.addEventListener("mozvisibilitychange", functionToCall);
    } else if ((hidden = "webkitHidden") in document) {
        document.addEventListener("webkitvisibilitychange", functionToCall);
    } else if ((hidden = "msHidden") in document) {
        document.addEventListener("msvisibilitychange", functionToCall);
    }

    // IE 9 and lower:
    else if ("onfocusout" in document) {
        document.onfocusin = document.onfocusout = functionToCall;
    }

    // All others:
    else {
        window.onpageshow = window.onpagehide = window.onfocus = window.onblur = functionToCall;
    }
}


/**
 * Check user's log in status (when page has focus) and trigger login modal if user is not logged in
 * @returns {undefined}
 */
function checkLogin() {
    if (document.hidden || document.onfocusout || window.onpagehide || window.onblur) {
        console.log("Fenêtre a perdu le focus");
    } else {//if window has focus
        $.ajax({
            url: appRoot + "access/css",
            method: "GET"
        }).done(function (returnedData) {
            //if 0 is returned as status, (meaning user's session has expired), trigger the modal to allow user to log in)
            if (returnedData.status === 0) {
                //launch the login/signup modal
                $("#logInModalFMsg").css('color', 'red').html("Votre session a expiré. Merci de vous connecter pour continuer");

                $("#logInModal").modal("show");
            }
        });
    }
}


/**
 *
 * @param {type} email
 * @param {type} password
 * @param {type} callback function to callback after execution
 * @returns {undefined}
 */
function handleLogin(email, password, callback) {
    let jsonToReturn = "";

    $.ajax(appRoot + 'access/login', {
        method: "POST",
        data: {email: email, password: password}
    }).done(function (returnedData) {
        if (returnedData.status === 1) {
            jsonToReturn = {status: 1, msg: "Authentifié ..."};
        } else {
            //display error messages
            jsonToReturn = {status: 0, msg: "Combinaison email et mot de passe incorrecte"};
        }

        typeof (callback) === "function" ? callback(jsonToReturn) : "";

    }).fail(function () {
        //set error message based on the internet connectivity of the user
        let msg = "Échec de la connexion. Veuillez vérifier votre connexion Internet et réessayer plus tard.";

        //display error messages
        jsonToReturn = {status: 0, msg: msg};

        typeof (callback) === "function" ? callback(jsonToReturn) : "";
    });
}


/**
 * Check if browser is connected to the internet (if not on localhost) when an ajax req failed
 * @param {bool} changeFlashContent whether to display a new flash message or change the content if one is displayed
 * @returns {undefined}
 */
function checkBrowserOnline(changeFlashContent) {
    if ((!navigator.onLine) && (appRoot.search('localhost') === -1)) {
        changeFlashContent ?
            changeFlashMsgContent('Erreur réseau! S\'il vous plaît, vérifiez votre connexion à internet et réessayez', '', 'red', '', false)
            :
            displayFlashMsg('Erreur réseau! S\'il vous plaît, vérifiez votre connexion à internet et réessayez', '', 'red', '', false);
    } else {
        changeFlashContent ?
            changeFlashMsgContent('Oops ! Impossible de traiter votre demande. Veuillez réessayer ou signaler une erreur', '', 'red', '', false)
            :
            displayFlashMsg('Oops ! Impossible de traiter votre demande. Veuillez réessayer ou signaler une erreur', '', 'red', '', false);
    }
}


/**
 *
 * @param {type} devFolderName
 * @param {type} prodFolderName
 * @returns {String}
 */
function setAppRoot(devFolderName, prodFolderName) {
    let hostname = window.location.hostname;

    /*
     * set the appRoot
     * This will work for both http, https with or without www
     * @type String
     */

    //attach trailing slash to both foldernames
    let devFolder = devFolderName ? devFolderName + "/" : "";
    let prodFolder = prodFolderName ? prodFolderName + "/" : "";

    let baseURL;

    if (hostname.search("localhost") !== -1 || (hostname.search("192.168.") !== -1) || (hostname.search("127.0.0.") !== -1)) {
        baseURL = window.location.origin + "/" + devFolder;
    } else {
        baseURL = window.location.origin + "/" + prodFolder;
    }

    return baseURL;
}


function inArray(value, array) {
    for (let i = 0; i < array.length; i++) {
        if (array[i].trim() === value.trim()) {
            return true;
        }
    }

    return false;
}


function arrayUnique(array) {
    let newArray = [];

    for (let i = 0; i < array.length; i++) {
        if (inArray(array[i].trim(), newArray)) {
            continue;
        }

        newArray.push(array[i].trim());
    }

    return newArray;
}
