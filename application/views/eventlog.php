<?php
defined('BASEPATH') OR exit('');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="pwell" style="">
            <!-- Header (add new cout, sort order etc.) -->
            <div class="row">
                <div class="col-sm-12">
<!--                    <div class="col-sm-3 col-xs-12 pull-left fa fa-user-plus pointer" style="color:#337ab7" data-target='#addNewCoutModal' data-toggle='modal'>-->
<!--                    Nouvelle Dépense-->
<!--                    </div>-->
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="eventsListPerPage">Afficher</label>
                        <select id="eventsListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="eventsListPerPage">par page</label>
                    </div>
                    <div class="col-sm-6 form-inline form-group-sm">
                        <label for="eventsLogListSortBy" class="control-label">Trier par</label>
                        <select id="eventsLogListSortBy" class="form-control">
                            <option value="event-ASC">Event (A à Z)</option>
                            <option value="event-DESC">Event (Z à A)</option>
                            <option value="items-ASC">Article (A à Z)</option>
                            <option value="items-DESC">Article (Z à A)</option>
                            <option value="eventTime-ASC" selected>Date de création (le plus ancien en premier)</option>
                            <option value="eventTime-DESC">Date de création (dernier en premier)</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-xs-12 pull-right">
                        <input type="search" id="eventSearch" placeholder="Chercher ...." class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <!-- Header (sort order etc.) ends -->
            
            <!-- Event info -->
            <div class="row">
                <div class="col-sm-12">
                     <!-- eventlog list -->
                    <div class="col-sm-12 allevents" id="allevents"></div>

                </div>
            </div>
            <!-- Event list ends -->
        </div>
    </div>
</div>

<!--- end of modal to edit cout details --->


<script src="<?= base_url() ?>public/js/eventlog.js"></script>
