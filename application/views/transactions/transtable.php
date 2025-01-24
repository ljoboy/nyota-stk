<?php defined('BASEPATH') or exit('') ?>

<?= isset($range) && !empty($range) ? $range : ""; ?>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">FACTURES</div>
    <?php if ($allTransactions): ?>
        <div class="table table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>N° RECU</th>
                    <th>Articles</th>
                    <th>Montant Total</th>
                    <th>Montant perçu</th>
                    <th>différence</th>
                    <th>Mode de Payement</th>
                    <th>Agent</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allTransactions as $get): ?>
                    <tr>
                        <th><?= $sn ?>.</th>
                        <td id="ref-<?= $sn ?>"><a class="pointer vtr"
                                                   title="Click to view receipt"><?= $get->ref ?></a></td>
                        <td><?= $get->quantity ?></td>
                        <td class="hidden" id="total-<?= $sn ?>"><?= $get->pos ?></td>
                        <td>USD<?= number_format($get->totalMoneySpent, 2) ?></td>
                        <td>
                            USD<?= (($get->cash !== null) && ($get->modeOfPayment !== 'Cash')) ? number_format($get->cash, 2) : number_format($get->amountTendered, 2) ?></td>
                        <td>USD<?= number_format($get->changeDue, 2) ?></td>
                        <td><?= $get->modeOfPayment ?></td>
                        <td><?= $get->staffName ?></td>
                        <td><?= $get->cust_name ?> - <?= $get->cust_phone ?> - <?= $get->cust_email ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($get->transDate)) ?></td>
                        <td>
                            <?php if (($get->modeOfPayment !== 'Cash') && ($get->pos > 0)): ?>
                                <button id="<?= $get->ref . '-' . $sn ?>" class="btn btn-info makePayment"> Payer
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $sn++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- table div end-->
    <?php else: ?>
        <ul>
            <li>Aucune transactions</li>
        </ul>
    <?php endif; ?>

    <!--Pagination div-->
    <div class="col-sm-12 text-center">
        <ul class="pagination">
            <?= isset($links) ? $links : "" ?>
        </ul>
    </div>
</div>
<!-- panel end-->
