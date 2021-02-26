<?php
defined('BASEPATH') OR exit('');
?>

<div class="row latestStuffs">
    <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-body latestStuffsBody" style="background-color: #5cb85c">
                <div class="pull-left"><i class="fa fa-exchange"></i></div>
                <div class="pull-right">
                    <div><?=$totalSalesToday?></div>
                    <div class="latestStuffsText">Total des ventes aujourd'hui</div>
                </div>
            </div>
            <div class="panel-footer text-center" style="color:#5cb85c">Nombre d'articles vendus aujourd'hui</div>
        </div>
    </div>
    <?php if ($this->session->admin_role === "Super"): ?>
        <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-body latestStuffsBody" style="background-color: #f0ad4e">
                <div class="pull-left"><i class="fa fa-tasks"></i></div>
                <div class="pull-right">
                    <div><?=$totalTransactions?></div>
                    <div class="latestStuffsText pull-right">Transactions totales</div>
                </div>
            </div>
            <div class="panel-footer text-center" style="color:#f0ad4e">Total des transactions de tous les temps</div>
        </div>
    </div>
    <?php endif;?>
    <div class="col-sm-4">
        <div class="panel panel-info">
            <div class="panel-body latestStuffsBody" style="background-color: #337ab7">
                <div class="pull-left"><i class="fa fa-shopping-cart"></i></div>
                <div class="pull-right">
                    <div><?=$totalItems?></div>
                    <div class="latestStuffsText pull-right">Articles en stock</div>
                </div>
            </div>
            <div class="panel-footer text-center" style="color:#337ab7">Nombre total d'articles en stock</div>
        </div>
    </div>
</div>

<?php if ($this->session->admin_role === "Super"): ?>
<!-- ROW OF GRAPH/CHART OF EARNINGS PER MONTH/YEAR-->
<div class="row margin-top-5">
    <div class="col-sm-9">
        <div class="box">
            <div class="box-header" style="background-color:#33c9dd /*#333*/;">
              <h3 class="box-title" id="earningsTitle"></h3>
            </div>

            <div class="box-body" style="background-color:/*#33c9dd*/#5fa4b4;">
              <canvas style="padding-right:25px" id="earningsGraph" width="200" height="80"/></canvas>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <section class="panel form-group-sm">
            <label class="control-label" for="earningAndExpenseYear">Sélectionnez l'année du compte :</label>
            <select class="form-control" id="earningAndExpenseYear">
                <?php $years = range("2016", date('Y')); ?>
                <?php foreach($years as $y):?>
                <option value="<?=$y?>" <?=$y == date('Y') ? 'selected' : ''?>><?=$y?></option>
                <?php endforeach; ?>
            </select>
            <span id="yearAccountLoading"></span>
        </section>

        <section class="panel">
          <center>
              <canvas id="paymentMethodChart" width="200" height="200"/></canvas><br>Méthodes de payement(%)<span id="paymentMethodYear"></span>
          </center>
        </section>
    </div>
</div>
<!-- END OF ROW OF GRAPH/CHART OF EARNINGS PER MONTH/YEAR-->

<!-- ROW OF SUMMARY -->
<div class="row margin-top-5">
    <div class="col-sm-3">
        <div class="panel panel-hash">
            <div class="panel-heading"><i class="fa fa-cart-plus"></i> LES PLUS DEMANDE</div>
            <?php if($topDemanded): ?>
            <table class="table table-striped table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Qté vendue</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($topDemanded as $get):?>
                    <tr>
                        <td><?=$get->name?></td>
                        <td><?=$get->totSold?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                Aucune transaction
            <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="panel panel-hash">
            <div class="panel-heading"><i class="fa fa-cart-arrow-down"></i> LES MOINS DEMANDE</div>
            <?php if($leastDemanded): ?>
            <table class="table table-striped table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Qté vendue</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($leastDemanded as $get):?>
                    <tr>
                        <td><?=$get->name?></td>
                        <td><?=$get->totSold?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            Aucune Transaction
            <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="panel panel-hash">
            <div class="panel-heading"><i class="fa fa-money"></i> MEILLEUR GAIN</div>
            <?php if($highestEarners): ?>
            <table class="table table-striped table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Total Gagné</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($highestEarners as $get):?>
                    <tr>
                        <td><?=$get->name?></td>
                        <td>USD <?=number_format($get->totEarned, 2)?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            Aucune Transaction
            <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="panel panel-hash">
            <div class="panel-heading"><i class="fa fa-money"></i> GAIN LE PLUS FAIBLE</div>
            <?php if($lowestEarners): ?>
            <table class="table table-striped table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Total Gagné</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($lowestEarners as $get):?>
                    <tr>
                        <td><?=$get->name?></td>
                        <td>USD <?=number_format($get->totEarned, 2)?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
           Aucune transaction
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- END OF ROW OF SUMMARY -->

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-hash">
            <div class="panel-heading">Transactions quotidiennes</div>
            <div class="panel-body scroll panel-height">
                <?php if(isset($dailyTransactions) && $dailyTransactions): ?>
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Qté Vendue</th>
                            <th>Tot. Trans</th>
                            <th>Tot. Gagné</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($dailyTransactions as $get): ?>
                        <tr>
                            <td><?=
                                    date('d-m-Y', strtotime($get->transDate)) === date('d-m-Y', time())
                                    ?
                                    "Aujourd'hui"
                                    :
                                    date('d-m-Y', strtotime($get->transDate));
                                ?>
                            </td>
                            <td><?=$get->qty_sold?></td>
                            <td><?=$get->tot_trans?></td>
                            <td>USD <?=number_format($get->tot_earned, 2)?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <?php else: ?>
                <li>Aucune transaction</li>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div class="col-sm-6">
        <div class="panel panel-hash">
            <div class="panel-heading">Transactions par jours</div>
            <div class="panel-body scroll panel-height">
                <?php if(isset($transByDays) && $transByDays): ?>
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Qté Vendue</th>
                            <th>Tot. Trans</th>
                            <th>Tot. Gagné</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($transByDays as $get): ?>
                            <?php
                                switch ($get->day){
                                    case 'Sunday':
                                        $get->day = "Dimanche";
                                        break;
                                    case 'Monday':
                                        $get->day = "Lundi";
                                        break;
                                    case 'Tuesday':
                                        $get->day = "Mardi";
                                        break;
                                    case 'Wednesday':
                                        $get->day = "Mercredi";
                                        break;
                                    case 'Thursday':
                                        $get->day = "Jeudi";
                                        break;
                                    case 'Friday':
                                        $get->day = "Vendredi";
                                        break;
                                    case 'Saturday':
                                        $get->day = "Samedi";
                                        break;
                                }
                            ?>
                        <tr>
                            <td><?=$get->day?></td>
                            <td><?=$get->qty_sold?></td>
                            <td><?=$get->tot_trans?></td>
                            <td>USD <?=number_format($get->tot_earned, 2)?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <?php else: ?>
                <li>Aucune transaction</li>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-hash">
            <div class="panel-heading">Transactions mensuelles</div>
            <div class="panel-body scroll panel-height">
                <?php if(isset($transByMonths) && $transByMonths): ?>
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Mois</th>
                            <th>Qté Vendue</th>
                            <th>Tot. Trans</th>
                            <th>Tot. Gagné</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($transByMonths as $get): ?>
                            <?php
                            switch ($get->month){
                                case 'January':
                                    $get->month = "Janvier";
                                    break;
                                case 'February':
                                    $get->month = "Février";
                                    break;
                                case 'March':
                                    $get->month = "Mars";
                                    break;
                                case 'April':
                                    $get->month = "Avril";
                                    break;
                                case 'May':
                                    $get->month = "Mai";
                                    break;
                                case 'June':
                                    $get->month = "Juin";
                                    break;
                                case 'July':
                                    $get->month = "Juillet";
                                    break;
                                case 'August':
                                    $get->month = "Août";
                                    break;
                                case 'September':
                                    $get->month = "Septembre";
                                    break;
                                case 'October':
                                    $get->month = "Octobre";
                                    break;
                                case 'November':
                                    $get->month = "Novembre";
                                    break;
                                case 'December':
                                    $get->month = "Décembre";
                                    break;
                            }
                            ?>
                        <tr>
                            <td><?=$get->month?></td>
                            <td><?=$get->qty_sold?></td>
                            <td><?=$get->tot_trans?></td>
                            <td>USD <?=number_format($get->tot_earned, 2)?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <?php else: ?>
                <li>Aucune transaction</li>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div class="col-sm-6">
        <div class="panel panel-hash">
            <div class="panel-heading">Transactions annuelle</div>
            <div class="panel-body scroll panel-height">
                <?php if(isset($transByYears) && $transByYears): ?>
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Année</th>
                            <th>Qté Vendue</th>
                            <th>Tot. Trans</th>
                            <th>Tot. Gagné</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($transByYears as $get): ?>
                        <tr>
                            <td><?=$get->year?></td>
                            <td><?=$get->qty_sold?></td>
                            <td><?=$get->tot_trans?></td>
                            <td>USD <?=number_format($get->tot_earned, 2)?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <?php else: ?>
                <li>Aucune transaction</li>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif;?>

<script src="<?=base_url('public/js/chart.js'); ?>"></script>
<script src="<?=base_url('public/js/dashboard.js')?>"></script>
