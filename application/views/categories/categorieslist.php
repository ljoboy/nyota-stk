<?php
defined('BASEPATH') or exit('');
?>

<?php echo isset($range) && !empty($range) ? "Afficher " . $range : "" ?>
<div class="panel panel-primary">
    <div class="panel-heading">LISTE DES CATEGORIES</div>
    <?php if ($allCategories): ?>
        <div class="table table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>NOM</th>
                    <th>DESCRIPTION</th>
                    <th>DATE DE ENREGISTREMENT</th>
                    <th>MODIFIER</th>
                    <th>EFFACER</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allCategories as $get): ?>
                    <tr>
                        <th><?= $sn ?>.</th>
                        <td class="categoryNom"><?= $get->nom ?></td>
                        <td class="categoryDescription"><?= $get->description ?></td>
                        <td><?= date('d-m-Y h:i:s', strtotime($get->created_on)) ?></td>
                        <td class="text-center editcategory" id="edit-<?= $get->id ?>">
                            <i class="fa fa-pencil pointer"></i>
                        </td>
                        <td class="text-center text-danger deletecategory" id="del-<?= $get->id ?>">
                            <i class="fa fa-trash pointer"></i>
                        </td>
                    </tr>
                    <?php $sn++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        Pas des Catégories
    <?php endif; ?>
</div>
<!-- Pagination -->
<div class="row pull-left">
    <?php echo isset($links) ? $links : "" ?>
</div>
 Pagination ends
<div class="pull-right">
    <a href="<?= site_url('categories/excel') ?>" class="btn btn-primary">Exporter (Télécharger)</a>
</div>
