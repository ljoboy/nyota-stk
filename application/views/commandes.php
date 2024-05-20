<?php
defined('BASEPATH') or exit('');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="pwell" style="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-3 col-xs-12 pull-left fa fa-shopping-basket pointer" style="color:#337ab7"
                         data-target='#addNewCommandeModal' data-toggle='modal'>
                        Nouvelle commande
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="commandesListPerPage">Afficher</label>
                        <select id="commandesListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="commandesListPerPage">par page</label>
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="commandesListSortBy" class="control-label">Trier par</label>
                        <select id="commandesListSortBy" class="form-control">
                            <option value="Ref-ASC" selected>Ref (A à Z)</option>
                            <option value="Ref-DESC">Ref (Z à A)</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-xs-12 pull-right">
                        <input type="search" id="commandeSearch" placeholder="Chercher ...." class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <!-- Header (sort commandes etc.) ends -->

            <!-- commande info -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- commande list -->
                    <div class="col-sm-12" id="allcommandes"></div>
                </div>
            </div>
            <!-- commande list ends -->

            <!-- commande info -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- commande list -->
                    <div class="col-sm-12" id="allsents"></div>
                </div>
            </div>
            <!-- commande list ends -->
        </div>
    </div>
</div>


<!--- Modal to add new commande --->
<div class='modal fade' id='addNewCommandeModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Ajouter une Commande</h4>
                <div class="text-center">
                    <i id="fMsgIcon"></i><span id="fMsg"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='addNewCommandeForm' role='form'>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='item' class="control-label">Article</label>
                            <select name="item" id="item" class="form-control" onchange="getSupplierFromItem($(this).val())" required>
                                <option value="" disabled selected>Choisir un article</option>
                                <?php foreach ($items as $item): ?>
                                    <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="help-block errMsg" id="itemErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='supplier' class="control-label">Fournisseur</label>
                            <select name="supplier" id="supplier" class="form-control" required>
                                <option value="" disabled selected>Choisir un fournisseur</option>
                            </select>
                            <span class="help-block errMsg" id="supplierErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='qty' class="control-label">Quantité à commander</label>
                            <input class="form-control" type="number" name="qty" id="qty" min="1" required placeholder="25">
                            <span class="help-block errMsg" id="qtyErr"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type='button' id='addCommande' class="btn btn-primary">Ajouter Commande</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to add new commande --->


<!--- Modal for editing commande details --->
<div class='modal fade' id='editCommandeModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Modifier Commande</h4>
                <div class="text-center">
                    <i id="fMsgEditIcon"></i>
                    <span id="fMsgEdit"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='editCommandeForm' role='form'>
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

                    <input type="hidden" id="commandeId" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type='button' id='editCommandeSubmit' class="btn btn-primary">Modifier</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>public/js/commandes.js"></script>
<script>
    var itemSuppliers = <?= json_encode($itemSuppliers); ?>;
    function getSupplierFromItem(item_id) {
        $('#supplier').children().remove().end().append('<option value="" disabled selected>Choisir un article</option>') ;
        $.each(itemSuppliers, function (i, supplier) {
            if (supplier.item_id === item_id)
                $('#supplier').append($('<option>', {
                    value: supplier.id,
                    text : supplier.name
                }));
        });
    }
</script>