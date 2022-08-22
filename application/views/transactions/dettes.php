<?php
defined('BASEPATH') or exit('');

$current_items = [];

if (isset($items) && !empty($items)) {
    foreach ($items as $get) {
        $current_items[$get->code] = $get->name;
    }
}
?>

<style href="<?= base_url('public/ext/datetimepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet"></style>

<script>
    var currentItems = <?=json_encode($current_items)?>;
</script>

<div class="pwell hidden-print">
    <div class="row">
        <div class="col-sm-12">
            <!-- sort and co row-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="transListPerPage">Par Page</label>
                        <select id="transListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                    <div class="col-sm-5 form-group-sm form-inline">
                        <label for="transListSortBy">Trier par</label>
                        <select id="transListSortBy" class="form-control">
                            <option value="transId-DESC"> date (dernier en premier)</option>
                                                        
                            <option value="transId-ASC"> date (le plus ancien en premier)</option>
                                                        
                            <option value="quantity-DESC"> Quantité (la plus élevée en premier)</option>
                                                        
                            <option value="quantity-ASC"> Quantité (la plus petite en premier)</option>
                                                        
                            <option value="totalPrice-DESC"> Prix total (le plus élevé en premier)</option>
                                                        
                            <option value="totalPrice-ASC"> Prix total (plus bas en premier)</option>
                                                        
                            <option value="totalMoneySpent-DESC"> Montant total dépensé (le plus élevé en premier)
                            </option>
                                                        
                            <option value="totalMoneySpent-ASC"> Montant total dépensé (le plus bas en premier)</option>
                        </select>
                    </div>

                    <div class="col-sm-4 form-inline form-group-sm">
                        <label for='transSearch'><i class="fa fa-search"></i></label>
                        <input type="search" id="transSearch" class="form-control"
                               placeholder="Rechercher une transaction">
                    </div>
                </div>
            </div>
            <!-- end of sort and co div-->
        </div>
    </div>

    <hr>

    <!-- transaction list table-->
    <div class="row">
        <!-- Transaction list div-->
        <div class="col-sm-12" id="transListTable"></div>
        <!-- End of transactions div-->
    </div>
    <!-- End of transactions list table-->
</div>


<div class="row hidden" id="divToClone">
    <div class="col-sm-4 form-group-sm">
        <label>Article</label>
        <select class="form-control selectedItemDefault" onchange="selectedItem(this)"></select>
    </div>

    <div class="col-sm-2 form-group-sm itemAvailQtyDiv">
        <label>Quantité disponible</label>
        <span class="form-control itemAvailQty">0</span>
    </div>

    <div class="col-sm-2 form-group-sm">
        <label>Prix unitaire</label>
        <span class="form-control itemUnitPrice">0.00</span>
    </div>

    <div class="col-sm-1 form-group-sm itemTransQtyDiv">
        <label>Quantité</label>
        <input type="number" min="0" class="form-control itemTransQty" value="0">
        <span class="help-block itemTransQtyErr errMsg"></span>
    </div>

    <div class="col-sm-2 form-group-sm">
        <label>Prix total</label>
        <span class="form-control itemTotalPrice">0.00</span>
    </div>

    <br class="visible-xs">

    <div class="col-sm-1">
        <button class="close retrit">&times;</button>
    </div>

    <br class="visible-xs">
</div>

<!--modal to payment-->
<div id="paymentModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Payer </h4>
                <div id="editItemFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form role="form"><div class="row">
                        <span class="hidden" id="ref"></span>
                        <div class="col-sm-4 form-group-sm">
                            <label for="montantApayer">Montant à payer</label>
                            <span id="montantApayer" class="form-control">0.00</span>
                            <span class="help-block errMsg" id="montantApayerErr"></span>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <div id="amountTenderedDiv">
                                <label for="montantPercu" id="montantPercuLabel">Montant
                                    percu</label>
                                <input type="number" class="form-control" id="montantPercu">
                                <span class="help-block errMsg" id="montantPercuErr"></span>
                            </div>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="monnaieDue">Monnaie due</label>
                            <span class="form-control" id="monnaieDue"></span>
                            <span class="help-block errMsg" id="monnaieDueErr"></span>
                        </div>
                    </div>
                    <input type="hidden" id="paymentId">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="paymentSubmit">Enregistrer</button>
                <button class="btn btn-danger" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>
<!--end of modal-->

<!---End of copy of div to clone when adding more items to sales transaction---->
<script src="<?= base_url() ?>public/js/dettes.js"></script>
<script src="<?= base_url('public/ext/datetimepicker/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= base_url('public/ext/datetimepicker/jquery.timepicker.min.js') ?>"></script>
<script src="<?= base_url() ?>public/ext/datetimepicker/datepair.min.js"></script>
<script src="<?= base_url() ?>public/ext/datetimepicker/jquery.datepair.min.js"></script>
