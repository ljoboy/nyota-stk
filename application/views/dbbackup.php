<?php
defined('BASEPATH') OR exit('');
?>

<div class="pwell hidden-print"> 
    <div class="row">
        <div class="col-sm-6">
            <button id="savedb" class="btn btn-primary">Lancer la sauvegarde</button>
            <span class="help-block" id="saveDbMsg"></span>
        </div>

        <br class="visible-xs">
        
        <div class="col-sm-6">
            <button class="btn btn-info" id="importdb">Importer les données</button>
            <input type="file" id="selecteddbfile" name="selecteddbfile" class="hidden" accept=".sql">
            <span class="help-block" id="dbFileMsg"></span>
        </div>
    </div>
</div>
