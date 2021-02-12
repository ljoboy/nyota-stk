<?php
defined('BASEPATH') OR exit('');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="pwell" style="">
            <!-- Header (add new cout, sort order etc.) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-3 col-xs-12 pull-left fa fa-user-plus pointer" style="color:#337ab7" data-target='#addNewCoutModal' data-toggle='modal'>
                    Nouvelle Dépense
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="coutsListPerPage">Afficher</label>
                        <select id="coutsListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="coutsListPerPage">par page</label>
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="coutsListSortBy" class="control-label">Trier par</label>
                        <select id="coutsListSortBy" class="form-control">
                            <option value="montant-ASC" selected>Nom (A à Z)</option>
                            <option value="montant-DESC">Nom (Z à A)</option>
                            <option value="created_on-ASC">Date de création (le plus ancien en premier)</option>
                            <option value="created_on-DESC">Date de création (dernier en premier)</option>
                            <option value="date_sortie-ASC">Date de Sortie - Croissant</option>
                            <option value="date_sortie-DESC">Date de Sortie - Décroissant</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-xs-12 pull-right">
                        <input type="search" id="coutSearch" placeholder="Chercher ...." class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <!-- Header (sort order etc.) ends -->
            
            <!-- cout info -->
            <div class="row">
                <div class="col-sm-12">
                     <!-- cout list -->
                    <div class="col-sm-12" id="allcouts"></div>
                     <!-- cout list end -->
                    
                    <!-- cout details -->
                    <!-- <div class="col-sm-4">
                        <div class="pwell custDetail scroll">
                            <table class="table table-bordered">
                                <h4 class="text-center text-uppercase">Sanni Amir Olalekan</h4>
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>CUS-ID-0001</td>
                                    </tr>
                                    <tr>
                                        <th>Tel</th>
                                        <td>07030167606</td>
                                    </tr>
                                    <tr>
                                        <th>date_sortie</th>
                                        <td>amirsanni@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>Male</td>
                                    </tr>
                                    <tr>
                                        <th>Debt</th>
                                        <td>N2,000</td>
                                    </tr>
                                    <tr>
                                        <th>Last Transaction</th>
                                        <td>23rd Dec, 2015</td>
                                    </tr>
                                    <tr>
                                        <th>Total Transactions</th>
                                        <td>200</td>
                                    </tr>
                                    <tr>
                                        <th>Total Money Spent</th>
                                        <td>N500,000</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary">View User's Transactions</button>
                            </div>
                        </div>
                    </div> -->
                     <!-- cout details end -->
                </div>
            </div>
            <!-- cout list ends -->
        </div>
    </div>
</div>


<!--- Modal to add new cout --->
<div class='modal fade' id='addNewCoutModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Ajout Nouvelle Dépense</h4>
                <div class="text-center">
                    <i id="fMsgIcon"></i><span id="fMsg"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='addNewCoutForm' role='form'>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='montant' class="control-label">Montant sortie</label>
                            <input type="number" id='montant' name='montant' class="form-control" placeholder="Montant" min="0">
                            <span class="help-block errMsg" id="montantErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='motif' class="control-label">Motif de sortie</label>
                            <textarea class="form-control" id='motif' name="motif" id="" cols="30" rows="10" placeholder="Motif de Sortie"></textarea>
                            <span class="help-block errMsg" id="motifErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for='author' class="control-label">Auteur de la sortie</label>
                            <input type="text" id='author' name='author' class="form-control" placeholder="Auteur de la sortie">
                            <span class="help-block errMsg" id="authorErr"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for='date_sortie' class="control-label">Date de la Sortie</label>
                            <input type="date" id='date_sortie' name='date_sortie' class="form-control" placeholder="date_sortie (optional)">
                            <span class="help-block errMsg" id="date_sortieErr"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type='button' id='addCout' class="btn btn-primary">Ajouter Dépense</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to add new cout --->


<!--- Modal for editing cout details --->
<div class='modal fade' id='editCoutModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Modifier Dépense</h4>
                <div class="text-center">
                    <i id="fMsgEditIcon"></i>
                    <span id="fMsgEdit"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='editCoutForm' role='form'>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='montantEdit' class="control-label">Montant</label>
                            <input type="number" id='montantEdit' name='montantEdit' class="form-control" placeholder="Montant" min="0">
                            <span class="help-block errMsg" id="montantErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for='motifEdit' class="control-label">Motif de sortie</label>
                            <textarea class="form-control" id='motifEdit' name="motifEdit" id="" cols="30" rows="10" placeholder="Motif de Sortie"></textarea>
                            <span class="help-block errMsg" id="motifErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for='authorEdit' class="control-label">Auteur de la sortie</label>
                            <input type="text" id='authorEdit' name='authorEdit' class="form-control" placeholder="Auteur de la sortie">
                            <span class="help-block errMsg" id="authorErr"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for='date_sortieEdit' class="control-label">Date de la Sortie</label>
                            <input type="date" id='date_sortieEdit' name='date_sortieEdit' class="form-control" placeholder="Date de la Sortie">
                            <span class="help-block errMsg" id="date_sortieErr"></span>
                        </div>
                    </div>
                    <input type="hidden" id="coutId">
                </form>
            </div>
            <div class="modal-footer">
                <button type='button' id='editCout' class="btn btn-primary">Modifier</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Fermer</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to edit cout details --->

<script src="<?=base_url()?>public/js/couts.js"></script>
