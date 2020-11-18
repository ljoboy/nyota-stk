<?php
defined('BASEPATH') OR exit('');
?>
<?php if($allTransInfo):?>
<?php $sn = 1; ?>
<div id="transReceiptToPrint">
    <div class="row">
        <div class="col-xs-12 text-center text-uppercase">
            <div style="margin-bottom:5px;"><img src="<?=base_url()?>public/images/receipt_logo.png" alt="logo" class="img-responsive center-block" width="60px"></div>
            <h1>Ets LMK</h1>
            <b>ID.NAT.: 441/84/EN/H.KAT 2018 <br/> RCCM: 17 A 5350 </b><br/>
            <small>1370, Av. Mama Yemo Q/Makutano</small>
            <div>Tél . : +243 810 555 142</div>
        </div>
    </div>
    <hr style='margin-top:5px; margin-bottom:0'>
    <div class="row margin-top-5">
        <div class="col-xs-12">
            <b>Nom : <?=$cust_name?></b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <b>Téléphone : <?=$cust_phone?></b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <b>Email : <?=$cust_email?></b>
        </div>
    </div>
    <hr style='margin-top:5px; margin-bottom:0'>
    <div class="row text-center">
        <div class="col-sm-12">
            <b><?=isset($transDate) ? date('d-m-Y H:i:s', strtotime($transDate)) : ""?></b>
        </div>
    </div>
    <hr>
    <div class="row" style="margin-top:2px">
        <div class="col-sm-12">
            <label>Facture N<sup>o</sup> :</label>
            <span><?=isset($ref) ? $ref : ""?></span>
		</div>
    </div>
    
	<div class="row" style='font-weight:bold'>
		<div class="col-xs-4">Article</div>
		<div class="col-xs-4">Qté x Prix</div>
		<div class="col-xs-4">Tot(USD )</div>
	</div>
	<hr style='margin-top:2px; margin-bottom:0'>
    <?php $init_total = 0; ?>
    <?php foreach($allTransInfo as $get):?>
        <div class="row">
            <div class="col-xs-4"><?=$get['itemName']?></div>
            <div class="col-xs-4"><?=$get['quantity'] . "x" .number_format($get['unitPrice'], 2)?></div>
            <div class="col-xs-4"><?=number_format($get['totalPrice'], 2)?></div>
        </div>
        <?php $init_total += $get['totalPrice'];?>
    <?php endforeach; ?>
    <hr style='margin-top:2px; margin-bottom:0'>
    <div class="row">
        <div class="col-xs-12 text-right">
            <b>Total : USD <?=isset($init_total) ? number_format($init_total, 2) : 0?></b>
        </div>
    </div>
    <hr style='margin-top:2px; margin-bottom:0px'>      
    <div class="row">
        <div class="col-xs-12 text-right">
            <b>Remise(<?=$discountPercentage?>%) : USD <?=isset($discountAmount) ? number_format($discountAmount, 2) : 0?></b>
        </div>
    </div>       
    <div class="row">
        <div class="col-xs-12 text-right">
            <?php if($vatPercentage > 0): ?>
            <b>TVA(<?=$vatPercentage?>%) : USD <?=isset($vatAmount) ? number_format($vatAmount, 2) : ""?></b>
            <?php else: ?>
            TVA inclus
            <?php endif; ?>
        </div>
    </div>      
    <div class="row">
        <div class="col-xs-12 text-right">
            <b>TOTAL Général : USD <?=isset($cumAmount) ? number_format($cumAmount, 2) : ""?></b>
        </div>
    </div>
    <hr style='margin-top:5px; margin-bottom:0px'>
    <div class="row margin-top-5">
        <div class="col-xs-12">
            <b>Mode de Paiement : <?=isset($_mop) ? str_replace("_", " ", $_mop) : ""?></b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <b>Montant percu : USD <?=isset($amountTendered) ? number_format($amountTendered, 2) : ""?></b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <b>DIfférence : USD <?=isset($changeDue) ? number_format($changeDue, 2) : ""?></b>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-12 text-center">Merci pour votre passage chez nous</div>
    </div>
</div>
<br class="hidden-print">
<div class="row hidden-print">
    <div class="col-sm-12">
        <div class="text-center">
            <button type="button" class="btn btn-primary ptr">
                <i class="fa fa-print"></i> Imprimer le réçu
            </button>
            
            <button type="button" data-dismiss='modal' class="btn btn-danger">
                <i class="fa fa-close"></i> Fermer
            </button>
        </div>
    </div>
</div>
<br class="hidden-print">
<?php endif;?>
