'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
	
	
    //load all admin once the page is ready
    //function header: laad_(url)
    laad_();
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //reload the list of couts when fields are changed
    $("#coutsListSortBy, #coutsListPerPage").change(function(){
        displayFlashMsg("Patientez svp ...", spinnerClass, "", "");
        laad_();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //load and show page when pagination link is clicked
    $("#allcouts").on('click', '.lnp', function(e){
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
    
    
    //handles the addition of new cout details .i.e. when "add cout" button is clicked
    $("#addCout").click(function(e){
        e.preventDefault();
        
        //reset all error msgs in case they are set
        changeInnerHTML(['montantErr', 'motifErr', 'authorErr', 'date_sortieErr'], "");
        
        var montant = $("#montant").val();
        var motif = $("#motif").val();
        var author = $("#author").val();
        var date_sortie = $("#date_sortie").val();
        
        //ensure all required fields are filled
        if(!montant || !motif || !author || !date_sortie){
            !montant ? changeInnerHTML('montantErr', "Champ obligatoire") : "";
            !motif ? changeInnerHTML('motifErr', "Champ obligatoire") : "";
            !author ? changeInnerHTML('authorErr', "Champ obligatoire") : "";
            !date_sortie ? changeInnerHTML('date_sortieErr', "Champ obligatoire") : "";
            
            return;
        }
        
        //display message telling user action is being processed
        $("#fMsgIcon").attr('class', spinnerClass);
        $("#fMsg").text(" En cours...");
        
        //make ajax request if all is well
        $.ajax({
            method: "POST",
            url: appRoot+"couts/add",
            data: {montant:montant, motif:motif, author:author, date_sortie:date_sortie}
        }).done(function(returnedData){
            $("#fMsgIcon").removeClass();//remove spinner
                
            if(returnedData.status === 1){
                $("#fMsg").css('color', 'green').text(returnedData.msg);

                //reset the form
                document.getElementById("addNewCoutForm").reset();

                //close the modal
                setTimeout(function(){
                    $("#fMsg").text("");
                    $("#addNewCoutModal").modal('hide');
                }, 1000);

                //reset all error msgs in case they are set
                changeInnerHTML(['montantErr', 'motifErr', 'authorErr', 'date_sortieErr'],
                "");

                //refresh admin list table
                laad_();

            }

            else{
                //display error message returned
                $("#fMsg").css('color', 'red').html(returnedData.msg);

                //display individual error messages if applied
                $("#montantErr").text(returnedData.montant);
                $("#motifErr").text(returnedData.motif);
                $("#authorErr").text(returnedData.author);
                $("#date_sortieErr").text(returnedData.date_sortie);
            }
        }).fail(function(){
            if(!navigator.onLine){
                $("#fMsg").css('color', 'red').text("Erreur du réseau ! Verifiez votre connexion svp");
            }
        });
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //handles the updating of cout details
    $("#editCout").click(function(e){
        e.preventDefault();
        
        if(formChanges("editCoutForm")){
            //reset all error msgs in case they are set
            changeInnerHTML(['montantErr', 'motifErr', 'authorErr', 'date_sortieErr'], "");

            var montant = $("#montantEdit").val();
            var motif = $("#motifEdit").val();
            var author = $("#authorEdit").val();
            var date_sortie = $("#date_sortieEdit").val();
            var coutId = $("#coutId").val();

            //ensure all required fields are filled
            if(!montant || !motif || !author || !date_sortie){
                !montant ? changeInnerHTML('montantErr', "Champ obligatoire") : "";
                !motif ? changeInnerHTML('motifErr', "Champ obligatoire") : "";
                !author ? changeInnerHTML('authorErr', "Champ obligatoire") : "";
                !date_sortie ? changeInnerHTML('date_sortieErr', "Champ obligatoire") : "";
                
                return;
            }

            if(!coutId){
                $("#fMsgEdit").text("Une erreur inattendue s'est produite lors de la modification des détails de l'administrateur");
                return;
            }

            //display message telling user action is being processed
            $("#fMsgEditIcon").attr('class', spinnerClass);
            $("#fMsgEdit").text(" Mise à jour des détails...");

            //make ajax request if all is well
            $.ajax({
                method: "POST",
                url: appRoot+"couts/update",
                data: {montantEdit:montant, motifEdit:motif, authorEdit:author, date_sortieEdit:date_sortie, coutId:coutId}
            }).done(function(returnedData){
                $("#fMsgEditIcon").removeClass();//remove spinner

                if(returnedData.status === 1){
                    $("#fMsgEdit").css('color', 'green').text(returnedData.msg);

                    //reset the form and close the modal
                    setTimeout(function(){
                        $("#fMsgEdit").text("");
                        $("#editCoutModal").modal('hide');
                    }, 1000);

                    //reset all error msgs in case they are set
                    changeInnerHTML(['montantErr', 'motifErr', 'authorErr', 'date_sortieErr'], "");

                    //refresh admin list table
                    laad_();

                }

                else{
                    //display error message returned
                    $("#fMsgEdit").css('color', 'red').html(returnedData.msg);

                    //display individual error messages if applied
                    $("#montantErr").text(returnedData.montantEdit);
                    $("#motifErr").text(returnedData.motifEdit);
                    $("#authorErr").text(returnedData.authorEdit);
                    $("#date_sortieErr").text(returnedData.date_sortieEdit);
                    
                }
            }).fail(function(){
                    if(!navigator.onLine){
                        $("#fMsgEdit").css('color', 'red').html("Network error! Pls check your network connection");
                    }
                });
        }
        
        else{
            $("#fMsgEdit").html("Aucun changement a été opéré");
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //handles cout search
    $("#coutSearch").on('keyup change', function(){
        var value = $(this).val();
        
        if(value){//search only if there is at least one char in input
            $.ajax({
                type: "get",
                url: appRoot+"search/coutsSearch",
                data: {v:value},
                success: function(returnedData){
                    $("#allcouts").html(returnedData.coutsTable);
                }
            });
        }
        
        else{
            laad_();
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
    $("#allcouts").on('click', '.deletecout', function(){
        var confirm = window.confirm("Procéder ?");
        
        if(confirm){
            var ElemId = $(this).attr('id');

            var coutId = ElemId.split("-")[1];//get the coutId

            //show spinner
            $("#"+ElemId).html("<i class='"+spinnerClass+"'</i>");

            if(coutId){
                $.ajax({
                    url: appRoot+"couts/delete",
                    method: "POST",
                    data: {_aId:coutId}
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
    $("#allcouts").on('click', '.editcout', function(){
        
        var coutId = $(this).attr('id').split("-")[1];
        
        $("#coutId").val(coutId);
        
        //get info of admin with coutId and prefill the form with it
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
 * laad_ = "Load all couts"
 * @returns {undefined}
 */
function laad_(url){
    var orderBy = $("#coutsListSortBy").val().split("-")[0];
    var orderFormat = $("#coutsListSortBy").val().split("-")[1];
    var limit = $("#coutsListPerPage").val();
    
    $.ajax({
        type:'get',
        url: url ? url : appRoot+"couts/laad_/",
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},
     }).done(function(returnedData){
            hideFlashMsg();
			
            $("#allcouts").html(returnedData.coutsTable);
        });
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
