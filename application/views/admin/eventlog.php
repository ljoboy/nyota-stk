<?php
defined('BASEPATH') or exit('');
//var_dump($allLogs);
//die;
?>

<?php echo isset($range) && !empty($range) ? "Afficher " . $range : "" ?>
<div class="panel panel-primary">
    <div class="panel-heading">JOURNAL D'APPROVISIONNEMENT</div>
    <?php if ($allLogs): ?>
        <div class="table table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>EVENT</th>
                    <th>EVENT DESCRIPTION</th>
                    <th>DATE D'ENREGISTREMENT</th>
                    <th>ENREGISTRE PAR</th>
                    <th>MODIFIER</th>
                    <th>EFFACER</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $sn = 0;
                    foreach ($allLogs as $get):
                ?>
                    <tr>
                        <th><?= ++$sn ?>.</th>
                        <td class="coutMotif"><?= $get->event ?></td>
                        <td class="coutMontant"><?= $get->eventDesc ?></td>
                        <td class="coutDateSortie"><?= date('d-m-Y H:i:s', strtotime($get->eventTime)) ?></td>
                        <td class="coutAuthor"><?= $get->author ?></td>
                        <td><?= $get->author ?></td>
                        <td class="text-center reditcout" id="edit-<?= $get->name ?>">
                            <i class="fa fa-pencil pointer"></i>
                        </td>
                        <td class="text-center text-danger deletecout" id="del-<?= $get->code ?>">
                            <?php if ($get->deleted === "1"): ?>
                                <a class="pointer">RECCUPERER</a>
                            <?php else: ?>
                                <i class="fa fa-trash pointer"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        Pas des Dépenses
    <?php endif; ?>
</div>
<!-- Pagination -->
<div class="row pull-left">
    <?php echo isset($links) ? $links : "" ?>
</div>
<!-- Pagination ends -->
<div class="pull-right">
    <a href="<?= site_url('couts/excel') ?>" class="btn btn-primary">Exporter (Télécharger)</a>
</div>

<script src="<?= base_url() ?>public/js/eventlog.js"></script>