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
            <!--- Row to create new transaction-->
            <div class="row">
                <div class="col-sm-3">
                    <span class="pointer text-primary">
                        <button class='btn btn-primary btn-sm' id='showTransForm'><i class="fa fa-plus"></i> Nouvelle Transaction </button>
                    </span>
                </div>
                <div class="col-sm-3">
                    <span class="pointer text-primary">
                        <button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#reportModal'>
                            <i class="fa fa-newspaper-o"></i> Générer un rapport
                        </button>
                    </span>
                </div>
            </div>
            <br>
            <!--- End of row to create new transaction-->
            <!---form to create new transactions--->
            <div class="row collapse" id="newTransDiv">
                <!---div to display transaction form--->
                <div class="col-sm-12" id="salesTransFormDiv">
                    <div class="well">
                        <form name="salesTransForm" id="salesTransForm" role="form">
                            <div class="text-center errMsg" id='newTransErrMsg'></div>
                            <br>

                            <div class="row">
                                <div class="col-sm-12">
                                    <!--Cloned div comes here--->
                                    <div id="appendClonedDivHere"></div>
                                    <!--End of cloned div here--->

                                    <!--- Text to click to add another item to transaction-->
                                    <div class="row">
                                        <div class="col-sm-2 text-primary pointer">
                                            <button class="btn btn-primary btn-sm" id="clickToClone"><i
                                                        class="fa fa-plus"></i> Ajouter un élément
                                            </button>
                                        </div>

                                        <br class="visible-xs">

                                        <div class="col-sm-2 form-group-sm">
                                            <input type="text" id="barcodeText" class="form-control"
                                                   placeholder="code de l'article" autofocus>
                                            <span class="help-block errMsg" id="itemCodeNotFoundMsg"></span>
                                        </div>
                                    </div>
                                    <!-- End of text to click to add another item to transaction-->
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="vat">TVA(%)</label>
                                            <input type="number" min="0" id="vat" class="form-control" value="0"
                                                   disabled>
                                        </div>
                                        <?php if ($this->session->admin_role === "Super"): ?>
                                            <div class="col-sm-3 form-group-sm">
                                                <label for="discount">Remise(%)</label>
                                                <input type="number" min="0" id="discount" class="form-control"
                                                       value="0">
                                            </div>

                                            <div class="col-sm-3 form-group-sm">
                                                <label for="discount">Remise(valeur)</label>
                                                <input type="number" min="0" id="discountValue" class="form-control"
                                                       value="0">
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="modeOfPayment">Moyen de paiement</label>
                                            <select class="form-control checkField" id="modeOfPayment">
                                                <option value="">---</option>
                                                <option value="Cash">Cash</option>
                                                <option value="POS">POS</option>
                                                <option value="Cash and POS">Cash et POS</option>
                                            </select>
                                            <span class="help-block errMsg" id="modeOfPaymentErr"></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="cumAmount">Montant Cumulatif</label>
                                            <span id="cumAmount" class="form-control">0.00</span>
                                        </div>

                                        <div class="col-sm-4 form-group-sm">
                                            <div class="cashAndPos hidden">
                                                <label for="cashAmount">Cash</label>
                                                <input type="text" class="form-control" id="cashAmount">
                                                <span class="help-block errMsg"></span>
                                            </div>

                                            <div class="cashAndPos hidden">
                                                <label for="posAmount">POS</label>
                                                <input type="text" class="form-control" id="posAmount">
                                                <span class="help-block errMsg"></span>
                                            </div>

                                            <div id="amountTenderedDiv">
                                                <label for="amountTendered" id="amountTenderedLabel">Montant
                                                    percu</label>
                                                <input type="text" class="form-control" id="amountTendered">
                                                <span class="help-block errMsg" id="amountTenderedErr"></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 form-group-sm">
                                            <label for="changeDue">Monnaie due</label>
                                            <span class="form-control" id="changeDue"></span>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-info" data-toggle="collapse"
                                            data-target="#opt_client">Options du client
                                    </button>
                                    <div class="row collapse" id="opt_client">
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="custName">Nom du client</label>
                                            <input type="text" id="custName" class="form-control" placeholder="Nom">
                                        </div>

                                        <div class="col-sm-4 form-group-sm">
                                            <label for="custPhone">Téléphone du client</label>
                                            <input type="tel" id="custPhone" class="form-control"
                                                   placeholder="Telephone">
                                        </div>

                                        <div class="col-sm-4 form-group-sm">
                                            <label for="custEmail">Email du client</label>
                                            <input type="email" id="custEmail" class="form-control"
                                                   placeholder="E-mail">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-2 form-group-sm">
                                    <button class="btn btn-primary btn-sm" id='useScanner'>Utiliser un scanner de code à
                                        barres
                                    </button>
                                </div>
                                <br class="visible-xs">
                                <div class="col-sm-6"></div>
                                <br class="visible-xs">
                                <div class="col-sm-4 form-group-sm">
                                    <button type="button" class="btn btn-primary btn-sm" id="confirmSaleOrder">
                                        Confirmer
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" id="cancelSaleOrder">Effacer
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" id="hideTransForm">Fermer
                                    </button>
                                </div>
                            </div>
                        </form><!-- end of form-->
                    </div>
                </div>
                <!-- end of div to display transaction form-->
            </div>
            <!--end of form-->

            <br><br>
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


<div class="modal fade" id='reportModal' data-backdrop='static' role='dialog'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss='modal'>&times;</div>
                <h4 class="text-center">Générer un rapport</h4>
            </div>

            <div class="modal-body">
                <div class="row" id="datePair">
                    <div class="col-sm-6 form-group-sm">
                        <label class="control-label">A partir du</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id='transFrom' class="form-control date start" placeholder="YYYY-MM-DD">
                        </div>
                        <span class="help-block errMsg" id='transFromErr'></span>
                    </div>

                    <div class="col-sm-6 form-group-sm">
                        <label class="control-label">au</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id='transTo' class="form-control date end" placeholder="YYYY-MM-DD">
                        </div>
                        <span class="help-block errMsg" id='transToErr'></span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id='clickToGen'>Générer</button>
                <button class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>

<!---End of copy of div to clone when adding more items to sales transaction---->
<script src="<?= base_url() ?>public/js/transactions.js"></script>
<script src="<?= base_url('public/ext/datetimepicker/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= base_url('public/ext/datetimepicker/jquery.timepicker.min.js') ?>"></script>
<script src="<?= base_url() ?>public/ext/datetimepicker/datepair.min.js"></script>
<script src="<?= base_url() ?>public/ext/datetimepicker/jquery.datepair.min.js"></script>
