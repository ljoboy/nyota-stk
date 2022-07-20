<?php defined('BASEPATH') or exit('');
?>
            <!-- Event info -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- eventlog list -->
                    <div class="col-sm-12 allevents" id="allevents">
                        <?= $range ?? ""?>
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
                            <?= $links ?? "" ?>
                        </div>
                        <!-- Pagination ends -->
                        <div class="pull-right">
                            <a href="<?= site_url('eventlog/excel') ?>" class="btn btn-primary">Exporter (Télécharger)</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Event list ends -->




