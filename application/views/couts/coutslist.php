<?php
defined('BASEPATH') or exit('');
?>

<?php echo isset($range) && !empty($range) ? "Afficher " . $range : "" ?>
<div class="panel panel-primary">
    <div class="panel-heading">LISTE DES COUTS</div>
    <?php if ($allcouts): ?>
        <div class="table table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>MOTIF</th>
                    <th>MONTANT</th>
                    <th>AUTEUR</th>
                    <th>DATE DE SORTIE</th>
                    <th>DATE DE ENREGISTREMENT</th>
                    <th>ENREGISTRE PAR</th>
                    <th>MODIFIER</th>
                    <th>EFFACER</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allcouts as $get): ?>
                    <tr>
                        <th><?= $sn ?>.</th>
                        <td class="coutMotif"><?= $get->motif ?></td>
                        <td class="coutMontant"><?= $get->montant ?></td>
                        <td class="coutAuthor"><?= $get->author ?></td>
                        <td class="coutDateSortie"><?= date('d-m-Y', strtotime($get->date_sortie)) ?></td>
                        <td><?= date('d-m-Y h:i:s', strtotime($get->created_on)) ?></td>
                        <td><?= $get->staffName ?></td>
                        <td class="text-center editcout" id="edit-<?= $get->coutsId ?>">
                            <i class="fa fa-pencil pointer"></i>
                        </td>
                        <td class="text-center text-danger deletecout" id="del-<?= $get->coutsId ?>">
                            <?php if ($get->deleted === "1"): ?>
                                <a class="pointer">RECCUPERER</a>
                            <?php else: ?>
                                <i class="fa fa-trash pointer"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $sn++; ?>
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
<!--  -->
<div class="pull-right">
    <a href="<?= site_url('couts/excel') ?>" class="btn btn-primary">Exporter (Télécharger)</a>
</div>
