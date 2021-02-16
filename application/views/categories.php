<?php
defined('BASEPATH') or exit('');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="pwell" style="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-3 col-xs-12 pull-left fa fa-user-plus pointer" style="color:#337ab7"
                         data-target='#addNewCategoryModal' data-toggle='modal'>
                        Nouvelle Catégorie
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="categoriesListPerPage">Afficher</label>
                        <select id="categoriesListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="categoriesListPerPage">par page</label>
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="categoriesListSortBy" class="control-label">Trier par</label>
                        <select id="categoriesListSortBy" class="form-control">
                            <option value="nom-ASC" selected>Nom (A à Z)</option>
                            <option value="nom-DESC">Nom (Z à A)</option>
                            <option value="created_on-ASC">Date de création (le plus ancien en premier)</option>
                            <option value="created_on-DESC">Date de création (dernier en premier)</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-xs-12 pull-right">
                        <input type="search" id="categorySearch" placeholder="Chercher ...." class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <!-- Header (sort categories etc.) ends -->

            <!-- category info -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- category list -->
                    <div class="col-sm-12" id="allcategories"></div>
                </div>
            </div>
            <!-- category list ends -->
        </div>
    </div>
</div>


<!--- Modal to add new category --->
<div class='modal fade' id='addNewCategoryModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Ajout Nouvelle Catégorie</h4>
                <div class="text-center">
                    <i id="fMsgIcon"></i><span id="fMsg"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='addNewCategoryForm' role='form'>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='nom' class="control-label">Nom</label>
                            <input type="text" id='nom' name='nom' class="form-control" placeholder="Nom" min="0">
                            <span class="help-block errMsg" id="nomErr"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='description' class="control-label">Description</label>
                            <textarea class="form-control" id='description' name="description" cols="30" rows="10"
                                      placeholder="Description"></textarea>
                            <span class="help-block errMsg" id="descriptionErr"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type='button' id='addCategory' class="btn btn-primary">Ajouter Catégorie</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to add new category --->


<!--- Modal for editing category details --->
<div class='modal fade' id='editCategoryModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Modifier Catégorie</h4>
                <div class="text-center">
                    <i id="fMsgEditIcon"></i>
                    <span id="fMsgEdit"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='editCategoryForm' role='form'>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='nomEdit' class="control-label">Nom</label>
                            <input type="text" id='nomEdit' name='nomEdit' class="form-control" placeholder="Nom"
                                   min="0">
                            <span class="help-block errMsg" id="nomEditErr"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='descriptionEdit' class="control-label">Description</label>
                            <textarea class="form-control" id='descriptionEdit' name="descriptionEdit" cols="30"
                                      rows="10" placeholder="Description"></textarea>
                            <span class="help-block errMsg" id="descriptionEditErr"></span>
                        </div>
                    </div>

                    <input type="hidden" id="categoryId" value="<?=$categoryId?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type='button' id='editCategorySubmit' class="btn btn-primary">Modifier</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to edit category details --->

<script src="<?= base_url() ?>public/js/categories.js"></script>
