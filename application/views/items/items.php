<?php
defined('BASEPATH') or exit('');
?>

<div class="pwell hidden-print">
    <div class="row">
        <div class="col-sm-12">
            <!-- sort and co row-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2 form-inline form-group-sm">
                        <button class="btn btn-primary btn-sm" id='createItem'>Ajouter un Article</button>
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="itemsListPerPage">Afficher</label>
                        <select id="itemsListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label>par page</label>
                    </div>

                    <div class="col-sm-4 form-group-sm form-inline">
                        <label for="itemsListSortBy">Trier par</label>
                        <select id="itemsListSortBy" class="form-control">
                            <option value="name-ASC">Nom (A-Z)</option>
                            <option value="code-ASC">Code (Croissant)</option>
                            <option value="unitPrice-DESC">Prix unitaire (plus chères)</option>
                            <option value="quantity-DESC">Quantité (plus nombreux)</option>
                            <option value="name-DESC">Nom (Z-A)</option>
                            <option value="code-DESC">Code (Décroissant)</option>
                            <option value="unitPrice-ASC">Prix unitaire (moins chères)</option>
                            <option value="quantity-ASC">Quantité (moins nombreux)</option>
                        </select>
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for='itemSearch'><i class="fa fa-search"></i></label>
                        <input type="search" id="itemSearch" class="form-control" placeholder="Chercher article">
                    </div>
                </div>
            </div>
            <!-- end of sort and co div-->
        </div>
    </div>

    <hr>

    <!-- row of adding new item form and items list table-->
    <div class="row">
        <div class="col-sm-12">
            <!--Form to add/update an item-->
            <div class="col-sm-4 hidden" id='createNewItemDiv'>
                <div class="well">
                    <button class="btn btn-info btn-xs pull-left" id="useBarcodeScanner">Utiliser Scanner</button>
                    <button class="close cancelAddItem">&times;</button>
                    <br>
                    <form name="addNewItemForm" id="addNewItemForm" role="form">
                        <div class="text-center errMsg" id='addCustErrMsg'></div>

                        <br>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemCode">Code</label>
                                <input type="text" id="itemCode" name="itemCode" placeholder="Code" maxlength="80"
                                       class="form-control" onchange="checkField(this.value, 'itemCodeErr')" autofocus>
                                <input type="checkbox" id="gen4me"> <label for="gen4me" class="small"> Générer
                                    automatiquement</label>
                                <span class="help-block errMsg" id="itemCodeErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemName">Nom</label>
                                <input type="text" id="itemName" name="itemName" placeholder="Nom" maxlength="80"
                                       class="form-control" onchange="checkField(this.value, 'itemNameErr')">
                                <span class="help-block errMsg" id="itemNameErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemQuantity">Quantité</label>
                                <input type="number" id="itemQuantity" name="itemQuantity"
                                       placeholder="Quantité disponible"
                                       class="form-control" min="0"
                                       onchange="checkField(this.value, 'itemQuantityErr')">
                                <span class="help-block errMsg" id="itemQuantityErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group-sm col-sm-12">
                                <label for='itemCategories' class="control-label">Catégories</label>
                                <select class="form-control checkField selectpicker itemCategories" id='itemCategories'
                                        name="itemCategories[]" multiple>
                                    <option value='' selected disabled>Catégories</option>
                                    <?php foreach ($categories as $categorie): ?>
                                        <option value='<?= $categorie->id ?>'><?= $categorie->nom ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="help-block errMsg" id="itemCategoriesErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemPrice">(USD) Prix unitaire</label>
                                <input type="text" id="itemPrice" name="itemPrice" placeholder="(USD) Prix unitaire"
                                       class="form-control"
                                       onchange="checkField(this.value, 'itemPriceErr')">
                                <span class="help-block errMsg" id="itemPriceErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemStockMin">Stock minimum</label>
                                <input placeholder="Quantité minimum en stock" type="number" id="itemStockMin"
                                       class="form-control" onchange="checkField(this.value, 'stockMinErr')"/>
                                <span class="help-block errMsg" id="stockMinErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemDescription" class="">Description (Optionel)</label>
                                <textarea class="form-control" id="itemDescription" name="itemDescription" rows='4'
                                          placeholder="Description Article (Optionel)"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row text-center">
                            <div class="col-sm-6 form-group-sm">
                                <button class="btn btn-primary btn-sm" id="addNewItem">Ajouter</button>
                            </div>

                            <div class="col-sm-6 form-group-sm">
                                <button type="reset" id="cancelAddItem" class="btn btn-danger btn-sm cancelAddItem"
                                        form='addNewItemForm'>Annuler
                                </button>
                            </div>
                        </div>
                    </form><!-- end of form-->
                </div>
            </div>

            <!--- Item list div-->
            <div class="col-sm-12" id="itemsListDiv">
                <!-- Item list Table-->
                <div class="row">
                    <div class="col-sm-12" id="itemsListTable"></div>
                </div>
                <!--end of table-->
            </div>
            <!--- End of item list div-->

        </div>
    </div>
    <!-- End of row of adding new item form and items list table-->
</div>

<!--modal to update stock-->
<div id="updateStockModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Modifier Stock</h4>
                <div id="stockUpdateFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form name="updateStockForm" id="updateStockForm" role="form">
                    <div class="row">
                        <div class="col-sm-4 form-group-sm">
                            <label for="stockUpdateItemName">Nom Article</label>
                            <input type="text" readonly id="stockUpdateItemName" class="form-control">
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="stockUpdateItemCode">Code Article</label>
                            <input type="text" readonly id="stockUpdateItemCode" class="form-control">
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="stockUpdateItemQInStock">Quantité en Stock</label>
                            <input type="text" readonly id="stockUpdateItemQInStock" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 form-group-sm">
                            <label for="stockUpdateType">Modifier Type</label>
                            <select id="stockUpdateType" class="form-control checkField">
                                <option value="">---</option>
                                <option value="newStock">Nouveau Stock</option>
                                <option value="deficit">Déficite</option>
                            </select>
                            <span class="help-block errMsg" id="stockUpdateTypeErr"></span>
                        </div>

                        <div class="col-sm-6 form-group-sm">
                            <label for="stockUpdateQuantity">Quantité</label>
                            <input type="number" id="stockUpdateQuantity" placeholder="Modifier la quantité"
                                   class="form-control checkField" min="0">
                            <span class="help-block errMsg" id="stockUpdateQuantityErr"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group-sm">
                            <label for="stockUpdateMin">Stock minimum</label>
                            <input placeholder="Modifier la quanntité minimum en stock" type="number"
                                   id="stockUpdateMin" class="form-control" min="0" "/>
                            <span class="help-block errMsg" id="stockUpdateMinErr"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 form-group-sm">
                            <label for="stockUpdateDescription" class="">Description</label>
                            <textarea class="form-control checkField" id="stockUpdateDescription"
                                      placeholder="Modifier Description"></textarea>
                            <span class="help-block errMsg" id="stockUpdateDescriptionErr"></span>
                        </div>
                    </div>

                    <input type="hidden" id="stockUpdateItemId">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="stockUpdateSubmit">Modifier</button>
                <button class="btn btn-danger" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>
<!--end of modal-->


<!--modal to edit item-->
<div id="editItemModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Modifier Article</h4>
                <div id="editItemFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-4 form-group-sm">
                            <label for="itemNameEdit">Nom Article</label>
                            <input type="text" id="itemNameEdit" placeholder="Nom Article" autofocus
                                   class="form-control checkField">
                            <span class="help-block errMsg" id="itemNameEditErr"></span>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="itemCodeEdit">Code Article</label>
                            <input type="text" id="itemCodeEdit" class="form-control">
                            <span class="help-block errMsg" id="itemCodeEditErr"></span>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="itemPriceEdit">Prix Unitaire</label>
                            <input type="text" id="itemPriceEdit" name="itemPrice" placeholder="Prix Unitaire"
                                   class="form-control checkField">
                            <span class="help-block errMsg" id="itemPriceEditErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group-sm col-sm-12">
                            <label for='itemCategoriesEdit' class="control-label">Catégories</label>
                            <select class="form-control checkField selectpicker itemCategories" id='itemCategoriesEdit'
                                    name="itemCategories[]" multiple>
                                <option value='' selected disabled>Catégories</option>
                                <?php foreach ($categories as $categorie): ?>
                                    <option value='<?= $categorie->id ?>'><?= $categorie->nom ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="help-block errMsg" id="itemCategoriesEditErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group-sm">
                            <label for="stockMinEdit">Stock minimum</label>
                            <input placeholder="Modifier la quantité minimum en stock" type="number" id="stockMinEdit"
                                   class="form-control" min="0" "/>
                            <span class="help-block errMsg" id="stockUpdateMinErr"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group-sm">
                            <label for="itemDescriptionEdit" class="">Description (Optionel)</label>
                            <textarea class="form-control" id="itemDescriptionEdit"
                                      placeholder="Description Article (Optionel)"></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="itemIdEdit">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="editItemSubmit">Enregistrer</button>
                <button class="btn btn-danger" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>
<!--end of modal-->
<script src="<?= base_url() ?>public/js/items.js"></script>
