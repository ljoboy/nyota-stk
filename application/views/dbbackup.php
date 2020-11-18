<?php
defined('BASEPATH') OR exit('');
?>

<div class="pwell hidden-print"> 
    <div class="row">
        <div class="col-sm-6">
            <a href="<?=base_url()?>misc/dldb" download="stkmanagement.sqlite"><button class="btn btn-primary">Télécharger les données</button></a>
        </div>

        <br class="visible-xs">
        
        <div class="col-sm-6">
            <button class="btn btn-info" id="importdb">Importer les données</button>
            <span class="help-block">Le fichier doit-être de type <b>.sqlite</b></span>
            <input type="file" id="selecteddbfile" class="hidden" accept=".sqlite">
            <span class="help-block" id="dbFileMsg"></span>
        </div>
    </div>
</div>
