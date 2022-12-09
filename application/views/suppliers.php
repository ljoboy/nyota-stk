<?php
defined('BASEPATH') or exit('');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="pwell" style="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-3 col-xs-12 pull-left fa fa-user-plus pointer" style="color:#337ab7"
                         data-target='#addNewSupplierModal' data-toggle='modal'>
                        Nouveau Fournisseur
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="suppliersListPerPage">Afficher</label>
                        <select id="suppliersListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="suppliersListPerPage">par page</label>
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="suppliersListSortBy" class="control-label">Trier par</label>
                        <select id="suppliersListSortBy" class="form-control">
                            <option value="name-ASC" selected>Nom (A à Z)</option>
                            <option value="name-DESC">Nom (Z à A)</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-xs-12 pull-right">
                        <input type="search" id="supplierSearch" placeholder="Chercher ...." class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <!-- Header (sort suppliers etc.) ends -->

            <!-- supplier info -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- supplier list -->
                    <div class="col-sm-12" id="allsuppliers"></div>
                </div>
            </div>
            <!-- supplier list ends -->
        </div>
    </div>
</div>


<!--- Modal to add new supplier --->
<div class='modal fade' id='addNewSupplierModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Ajouter un Fournisseur</h4>
                <div class="text-center">
                    <i id="fMsgIcon"></i><span id="fMsg"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='addNewSupplierForm' role='form'>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='name' class="control-label">Nom</label>
                            <input type="text" id='name' name='name' class="form-control" placeholder="Nom" required>
                            <span class="help-block errMsg" id="nameErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='email' class="control-label">E-Mail</label>
                            <input type="email" id='email' name='email' class="form-control" placeholder="email@domain.tld" required>
                            <span class="help-block errMsg" id="emailErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='address' class="control-label">Adresse</label>
                            <input type="text" id='address' name='address' class="form-control" placeholder="Adresse">
                            <span class="help-block errMsg" id="addressErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='phone_number' class="control-label">Téléphone</label>
                            <input type="text" id='phone_number' name='phone_number' class="form-control" placeholder="0991234578">
                            <span class="help-block errMsg" id="phone_numberErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group-sm col-sm-12">
                            <label for='role' class="control-label">Articles</label>
                            <select class="form-control checkField selectpicker itemSuppliers" id='itemSuppliers' name="itemSuppliers[]" multiple>
                                <option value='' selected disabled>Articles</option>
                            </select>
                            <span class="help-block errMsg" id="itemSuppliersErr"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type='button' id='addSupplier' class="btn btn-primary">Ajouter Fournisseur</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to add new supplier --->


<!--- Modal for editing supplier details --->
<div class='modal fade' id='editSupplierModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Modifier Fournisseur</h4>
                <div class="text-center">
                    <i id="fMsgEditIcon"></i>
                    <span id="fMsgEdit"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='editSupplierForm' role='form'>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='nameEdit' class="control-label">Nom</label>
                            <input type="text" id='nameEdit' name='nameEdit' class="form-control" placeholder="Nom">
                            <span class="help-block errMsg" id="nameEditErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='emailEdit' class="control-label">E-Mail</label>
                            <input type="email" id='emailEdit' name='emailEdit' class="form-control" placeholder="email@domain.tld" required>
                            <span class="help-block errMsg" id="emailEditErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='addressEdit' class="control-label">Adresse</label>
                            <input type="text" id='addressEdit' name='addressEdit' class="form-control" placeholder="Adresse">
                            <span class="help-block errMsg" id="addressEditErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='phone_numberEdit' class="control-label">Téléphone</label>
                            <input type="text" id='phone_numberEdit' name='phone_numberEdit' class="form-control" placeholder="0991234578">
                            <span class="help-block errMsg" id="phone_numberEditErr"></span>
                        </div>
                    </div>

                    <input type="hidden" id="supplierId" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type='button' id='editSupplierSubmit' class="btn btn-primary">Modifier</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to edit supplier details --->

<script src="<?= base_url() ?>public/js/suppliers.js"></script>
<script>
    let items = <?= json_encode($items ?? [], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP|JSON_UNESCAPED_UNICODE|JSON_NUMERIC_CHECK) ?>;
    $.each(items, function (i, item) {
        $('.itemSuppliers').append($('<option>', {
            value: item.id,
            text : item.name
        }));
    });
</script>