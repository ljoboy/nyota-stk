<?php
defined('BASEPATH') or exit('');
?>

<?php echo isset($range) && !empty($range) ? "Afficher " . $range : "" ?>
<div class="panel panel-primary">
    <div class="panel-heading">LISTE DES Fournisseurs</div>
    <?php if ($allSuppliers): ?>
        <div class="table table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Nom</th>
                    <th>E-mail</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Articles</th>
                    <th>Modifier</th>
                    <th>Effacer</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allSuppliers as $get): ?>
                    <tr>
                        <th><?= $sn ?>.</th>
                        <td class="supplierName"><?= $get->name ?></td>
                        <td class="supplierEmail"><?= $get->email ?></td>
                        <td class="supplierAddress"><?= $get->address ?></td>
                        <td class="supplierPhone_number"><?= $get->phone_number ?></td>
                        <td>
                            <?php foreach ($itemSuppliers as $itemSupplier): ?>
                            <?= ($get->id == $itemSupplier->id) ? "<div class='supplierItems'>{$itemSupplier->item_name}</div>" : '' ?>
                            <?php endforeach; ?>
                        </td>
                        <td class="text-center editsupplier" id="edit-<?= $get->id ?>">
                            <i class="fa fa-pencil pointer"></i>
                        </td>
                        <td class="text-center text-danger deletesupplier" id="del-<?= $get->id ?>">
                            <i class="fa fa-trash pointer"></i>
                        </td>
                    </tr>
                    <?php $sn++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        Pas des fournisseurs
    <?php endif; ?>
</div>
<!-- Pagination -->
<div class="row pull-left">
    <?php echo isset($links) ? $links : "" ?>
</div>
 
<div class="pull-right">
    <a href="<?= site_url('suppliers/excel') ?>" class="btn btn-primary">Exporter (Télécharger)</a>
</div>
