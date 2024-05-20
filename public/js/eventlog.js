'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status


    //load all admin once the page is ready
    //function header: lilt(url)
    lilt();

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //reload the list of couts when fields are changed
    $("#eventsLogListSortBy, #eventsListPerPage").change(function(){
        console.log('Okat...');
        displayFlashMsg("Patientez svp ...", spinnerClass, "", "");
        lilt();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //load and show page when pagination link is clicked
    $("#allevents").on('click', '.lnp', function(e){
        e.preventDefault();

        displayFlashMsg("Patientez svp ...", spinnerClass, "", "");

        lilt($(this).attr('href'));

        return false;
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //handles cout search
    $("#eventSearch").on('keyup change', function(){
        var value = $(this).val();

        if(value){//search only if there is at least one char in input
            $.ajax({
                type: "get",
                url: appRoot+"search/eventsSearch",
                data: {v:value},
                success: function(returnedData){
                    $("#allevents").html(returnedData.allevents);
                }
            });
        }

        else{
            lilt();
        }
    });

    /*
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    */


    //When the trash icon in front of an cout account is clicked on the cout list table (i.e. to delete the account)
    $("#allevents").on('click', '.deleteevent', function(){
        var confirm = window.confirm("Procéder ?");

        if(confirm){
            var ElemId = $(this).attr('id');

            var eventId = ElemId.split("-")[1];//get the eventId

            //show spinner
            $("#"+ElemId).html("<i class='"+spinnerClass+"'</i>");

            if(eventId){
                $.ajax({
                    url: appRoot+"eventlog/delete",
                    method: "POST",
                    data: {_aId:eventId}
                }).done(function(returnedData){
                    if(returnedData.status === 1){
                        //change the icon to "undo delete" if it's "active" before the change and vice-versa
                        var newHTML = returnedData._nv === 1 ? "<a class='pointer'>Annuler Suppression</a>" : "<i class='fa fa-trash pointer'></i>";

                        //change the icon
                        $("#del-"+returnedData._aId).html(newHTML);

                    }

                    else{
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


    //to launch the modal to allow for the editing of cout info
    $("#allevents").on('click', '.editevent', function(){

        var eventId = $(this).attr('id').split("-")[1];

        $("#eventId").val(eventId);

        //get info of admin with eventId and prefill the form with it
        //alert($(this).siblings(".adminEmail").children('a').html());
        var montant = $(this).siblings(".coutMontant").html();
        var motif = $(this).siblings(".coutMotif").html();
        var author = $(this).siblings(".coutAuthor").html();
        var date_sortie = $(this).siblings(".coutDateSortie").html();

        //prefill the form fields
        $("#montantEdit").val(montant);
        $("#motifEdit").val(motif);
        $("#authorEdit").val(author);
        $("#date_sortieEdit").val(date_sortie);

        $("#editCoutModal").modal('show');
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
 * lilt = "Load all events"
 * @returns {undefined}
 */
function lilt(url){
    var order = $("#eventsLogListSortBy").val();
    var orderBy = order?.split("-")[0] ?? 'id';
    var orderFormat = order?.split("-")[1] ?? 'DESC';
    var limit = $("#eventsListPerPage").val() ?? 10;

    $.ajax({
        type:'get',
        url: url ? url : appRoot+"eventlog/lilt/",
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},

        success: function (returnedData) {
            hideFlashMsg();
            $("#allevents").html(returnedData.allevents);
        },

        error: function () {

        }
    }).done(function(returnedData){
        hideFlashMsg();

        $("#allevents").html(returnedData.allevents);
    });

    return false;
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





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
