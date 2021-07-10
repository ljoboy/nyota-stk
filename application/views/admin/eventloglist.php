<?php defined('BASEPATH') or exit('');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="pwell" style="">
            <!-- Header (add new cout, sort order etc.) -->
            <div class="row">
                <div class="col-sm-12">
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
                    <div class="col-sm-12 allevents" id="allevents">
                        <?php echo isset($range) && !empty($range) ? "Afficher " . $range : "" ?>
                        <div class="panel panel-primary">
                            <div class="panel-heading">JOURNAL D'APPROVISIONNEMENT</div>
                            <?php if ($allevents): ?>
                                <div class="table table-responsive">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>EVENT</th>
                                            <th>EVENT DESCRIPTION</th>
                                            <th>DATE D'ENREGISTREMENT</th>
                                            <th>ENREGISTRE PAR</th>
                                            <!--                    <th>MODIFIER</th>-->
                                            <!--                    <th>EFFACER</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sn = 0;
                                        foreach ($allevents as $get):
                                            ?>
                                            <tr>
                                                <th><?= ++$sn ?>.</th>
                                                <td class="coutMotif"><?= $get->event ?></td>
                                                <td class="coutMontant"><?= $get->eventDesc ?></td>
                                                <td class="coutDateSortie"><?= date('d-m-Y H:i:s', strtotime($get->eventTime)) ?></td>
                                                <td class="coutAuthor"><?= $get->author ?></td>
                                                <td><?= $get->author ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                Pas d'approvisionnement
                            <?php endif; ?>
                        </div>
                        <!-- Pagination -->
                        <div class="row pull-left">
                            <?php echo isset($links) ? $links : "" ?>
                        </div>
                        <!-- Pagination ends -->
                        <!--<div class="pull-right">-->
                        <!--    <a href="--><?//= site_url('events/excel') ?><!--" class="btn btn-primary">Exporter (Télécharger)</a>-->
                        <!--</div>-->
                    </div>

                </div>
            </div>
            <!-- Event list ends -->
        </div>
    </div>
</div>


<script src="<?= base_url() ?>public/js/eventlog.js"></script>
