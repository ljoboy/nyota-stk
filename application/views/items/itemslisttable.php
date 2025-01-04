<?php defined('BASEPATH') or exit('') ?>

<div class='col-sm-4'>
    <?= isset($range) && !empty($range) ? $range : ""; ?>
</div>
<div class='col-sm-2' style="margin-bottom: 5px;">
    <button type="button" class="btn btn-warning" data-toggle="collapse"
            data-target="#critic_items">Stock en rupture
    </button>
</div>
<!-- TODO::CHANGER (WORTH) -->
<div class='col-sm-6 text-right'><b>Valeur total articles / Prix:</b>
    USD<?= $cum_total ? number_format($cum_total, 2) : '0.00' ?></div>

<div class='col-xs-12 collapse' id="critic_items">
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Articles Critiques</div>
        <?php if ($critic_items): ?>
            <div class="table table-responsive">
                <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>NOM</th>
                        <th>CODE</th>
                        <th>DESCRIPTION</th>
                        <th>CATEGORIES</th>
                        <th>QTE EN STOCK</th>
                        <th>PRIX UNITAIRE</th>
                        <th>STOCK MINIMUM</th>
                        <th>SOLDE TOTAL</th>
                        <th>GAIN TOTAL PAR ARTICLE</th>
                        <th>MODIFIER QUANTITE</th>
                        <th>MODIFIER</th>
                        <th>EFFACER</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($critic_items as $get): ?>
                        <tr>
                            <input type="hidden" value="<?= $get->id ?>" class="curItemId">
                            <th class="itemSN"><?= $sn ?>.</th>
                            <td><span id="itemName-<?= $get->id ?>"><?= $get->name ?></span></td>
                            <td><span id="itemCode-<?= $get->id ?>"><?= $get->code ?></td>
                            <td>
                            <span id="itemDesc-<?= $get->id ?>" data-toggle="tooltip" title="<?= $get->description ?>"
                                  data-placement="auto">
                                <?= word_limiter($get->description, 15) ?>
                            </span>
                            </td>
                            <td>
                                <?php foreach ($itemCategories as $itemCategorie): ?>
                                    <?= ($get->id == $itemCategorie->id_item) ? "<span>{$itemCategorie->nom}</span>" : '' ?>
                                <?php endforeach; ?>
                            </td>
                            <td class="<?= $get->quantity <= $get->min ? 'bg-danger' : ($get->quantity <= ($get->min * 2.5) ? 'bg-warning' : '') ?>">
                                <span id="itemQuantity-<?= $get->id ?>"><?= $get->quantity ?></span>
                            </td>
                            <td>USD<span id="itemPrice-<?= $get->id ?>"><?= number_format($get->unitPrice, 2) ?></span>
                            </td>
                            <th>
                                <span><?= $get->min ?></span>
                            </th>
                            <td><?= $this->genmod->gettablecol('transactions', 'SUM(quantity)', 'itemCode', $get->code) ?></td>
                            <td>
                                USD<?= number_format($this->genmod->gettablecol('transactions', 'SUM(totalPrice)', 'itemCode', $get->code), 2) ?>
                            </td>
                            <td><a class="pointer updateStock" id="stock-<?= $get->id ?>">Modifier la quantité</a></td>
                            <td class="text-center text-primary">
                                <span class="editItem" id="edit-<?= $get->id ?>"><i
                                            class="fa fa-pencil pointer"></i> </span>
                            </td>
                            <td class="text-center"><i class="fa fa-trash text-danger delItem pointer"></i></td>
                        </tr>
                        <?php $sn++; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- table div end-->
        <?php else: ?>
            <ul>
                <li>Pas d'articles</li>
            </ul>
        <?php endif; ?>
    </div>
    <!--- panel end-->
</div>
<div class='col-xs-12'>
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Articles</div>
        <?php if ($allItems): ?>
            <div class="table table-responsive">
                <table class="table table-bordered table-hover" id="item-table" style="background-color: #f5f5f5">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>NOM</th>
                        <th>CODE</th>
                        <th>DESCRIPTION</th>
                        <th>CATEGORIES</th>
                        <th>QTE EN STOCK</th>
                        <th>PRIX UNITAIRE</th>
                        <th>STOCK MINIMUM</th>
                        <th>SOLDE TOTAL</th>
                        <th>GAIN TOTAL PAR ARTICLE</th>
                        <th>MODIFIER QUANTITE</th>
                        <th>MODIFIER</th>
                        <th>EFFACER</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($allItems as $get): ?>
                        <tr  class="<?= $get->quantity <= $get->min ? 'danger' : ($get->quantity <= ($get->min * 2.5) ? 'warning' : '') ?>">
                            <input type="hidden" value="<?= $get->id ?>" class="curItemId">
                            <th class="itemSN"><?= $sn ?>.</th>
                            <td><span id="itemName-<?= $get->id ?>"><?= $get->name ?></span></td>
                            <td><span id="itemCode-<?= $get->id ?>"><?= $get->code ?></td>
                            <td>
                            <span id="itemDesc-<?= $get->id ?>" data-toggle="tooltip" title="<?= $get->description ?>"
                                  data-placement="auto">
                                <?= word_limiter($get->description, 15) ?>
                            </span>
                            </td>
                            <td>
                                <?php foreach ($itemCategories as $itemCategorie): ?>
                                    <span><?= ($get->id == $itemCategorie->id_item) ? $itemCategorie->nom : '' ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td class="">
                                <span id="itemQuantity-<?= $get->id ?>"><?= $get->quantity ?></span>
                            </td>
                            <td>USD<span id="itemPrice-<?= $get->id ?>"><?= number_format($get->unitPrice, 2) ?></span>
                            </td>
                            <th>
                                <span id="itemStockMin-<?= $get->id ?>"><?= $get->min ?></span>
                            </th>
                            <td><?= $this->genmod->gettablecol('transactions', 'SUM(quantity)', 'itemCode', $get->code) ?></td>
                            <td>
                                USD<?= number_format($this->genmod->gettablecol('transactions', 'SUM(totalPrice)', 'itemCode', $get->code), 2) ?>
                            </td>
                            <td><a class="pointer updateStock" id="stock-<?= $get->id ?>">Modifier la quantité</a></td>
                            <td class="text-center text-primary">
                                <span class="editItem" id="edit-<?= $get->id ?>"><i
                                            class="fa fa-pencil pointer"></i> </span>
                            </td>
                            <td class="text-center"><i class="fa fa-trash text-danger delItem pointer"></i></td>
                        </tr>
                        <?php $sn++; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- table div end-->
        <?php else: ?>
            <ul>
                <li>Pas d'articles</li>
            </ul>
        <?php endif; ?>
    </div>
    <!--- panel end-->
</div>

<!---Pagination div-->
<div class="col-sm-12 text-center">
    <ul class="pagination">
        <?= isset($links) ? $links : "" ?>
    </ul>
</div>
<div class="pull-right">
    <a href="<?= site_url('items/excel') ?>" class="btn btn-primary">Exporter (Télécharger)</a>
</div>
