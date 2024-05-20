<?php
defined('BASEPATH') or exit('');
?>

<?php echo isset($range) && !empty($range) ? "Afficher " . $range : "" ?>
<div class="panel panel-warning" style="margin-top: 20px">
    <div class="panel-heading">Commande envoyé</div>
    <?php if ($allCommandes): ?>
        <div class="table table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Ref</th>
                    <th>Fournisseur</th>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Envoyé le</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allCommandes as $get): ?>
                    <tr>
                        <th><?= $sn ?>.</th>
                        <td class="supplierName"><?= $get->ref ?></td>
                        <td class="supplierEmail"><?= $get->item_name ?></td>
                        <td class="supplierAddress"><?= $get->supplier_name ?></td>
                        <td class="supplierPhone_number"><?= $get->quantity ?></td>
                        <td class="text-center text-danger">
                            <?= date("d-m-Y H:i:s", strtotime($get->sended_at)); ?>
                        </td>
                    </tr>
                    <?php $sn++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        Pas de commande
    <?php endif; ?>
</div>
<!-- Pagination -->
<div class="row pull-left">
    <?php echo isset($links) ? $links : "" ?>
</div>