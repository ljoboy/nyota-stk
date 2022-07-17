<?php
defined('BASEPATH') or exit('');
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title><?= $pageTitle ?></title>

    <!-- Favicon -->
    <!--[if IE]><link rel="shortcut icon" href="<?= base_url() ?>public/images/icon.png"><![endif]-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>public/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>public/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>public/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>public/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>public/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>public/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>public/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>public/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>public/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() ?>public/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>public/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>public/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>public/images/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url() ?>public/images/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= base_url() ?>public/images/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="Description" content="STK Management, for your business management !">
    <meta name="appname" content="STK Management">
    <!-- favicon ends --->

    <!-- LOAD CSS FILES -->
    <?php if (server()): ?>
        <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap-theme.min.css" media="screen">
        <link rel="stylesheet" href="<?= base_url() ?>public/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/font-awesome/css/font-awesome-animation.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/ext/select2/select2.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/css/bootstrap-select.min.css">

    <?php else: ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.8/font-awesome-animation.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

    <?php endif; ?>

    <!-- custom CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>public/css/main.css">

    <!--  LOAD JS FILES  -->
    <?php if (server()): ?>

        <script src="<?= base_url() ?>public/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>public/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>public/ext/select2/select2.min.js"></script>
        <script src="<?= base_url() ?>public/js/bootstrap-select.min.js"></script>

    <?php else: ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <!--        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>-->

    <?php endif; ?>
</head>

<body>
<nav class="navbar navbar-default hidden-print">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= base_url() ?>" style="margin-top:-25px;">
                <img src="<?= base_url() ?>public/images/nyota.png" alt="logo" class="img-responsive" width="73px">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="nav navbar-nav navbar-left visible-xs">
                <li class="<?= $pageTitle == 'Tableau de bord' ? 'active' : '' ?>">
                    <a href="<?= site_url('dashboard') ?>">
                        <i class="fa fa-home"></i>
                        Tableau de bord
                    </a>
                </li>

                <li class="<?= $pageTitle == 'Transactions' ? 'active' : '' ?>">
                    <a href="<?= site_url('transactions') ?>">
                        <i class="fa fa-exchange"></i>
                        Transactions
                    </a>
                </li>

                <?php if ($this->session->admin_role === "Super"): ?>
                    <li class="<?= $pageTitle == 'Articles' ? 'active' : '' ?>">
                        <a href="<?= site_url('items') ?>">
                            <i class="fa fa-cart-plus"></i>
                            Articles
                        </a>
                    </li>

                    <li class="<?= $pageTitle == 'Categories' ? 'active' : '' ?>">
                        <a href="<?= site_url('category') ?>">
                            <i class="fa fa-cart-plus"></i>
                            Catégories
                        </a>
                    </li>

                    <!--<li class="<? /*= $pageTitle == 'Customers' ? 'active' : '' */ ?>">
                            <a href="<? /*= site_url('employees') */ ?>">
                                <i class="fa fa-users"></i>
                                Employés
                            </a>
                        </li>

                        <li class="<? /*= $pageTitle == 'Reports' ? 'active' : '' */ ?>">
                            <a href="<? /*= site_url('reports') */ ?>">
                                <i class="fa fa-newspaper-o"></i>
                                Rapports
                            </a>
                        </li>

                        <li class="<? /*= $pageTitle == 'Eventlog' ? 'active' : '' */ ?>">
                            <a href="<? /*= site_url('Eventlog') */ ?>">
                                <i class="fa fa-tasks"></i>
                                Journal des événements
                            </a>
                        </li>-->

                    <li class="<?= $pageTitle == 'Couts' ? 'active' : '' ?>">
                        <a href="<?= site_url('couts') ?>">
                            <i class="fa fa-money"></i>
                            Dépenses
                        </a>
                    </li>

                    <li class="<?= $pageTitle == 'Approvisionnements' ? 'active' : '' ?>">
                        <a href="<?= site_url('eventlog/approvisionnement') ?>">
                            <i class="fa fa-refresh"></i>
                            Approvisionnements
                        </a>
                    </li>

                    <li class="<?= $pageTitle == 'Administrateurs' ? 'active' : '' ?>">
                        <a href="<?= site_url('administrators') ?>">
                            <i class="fa fa-user"></i>
                            Administrateurs
                        </a>
                    </li>

                    <li class="<?= $pageTitle == 'Base des données' ? 'active' : '' ?>">
                        <a href="<?= site_url('dbmanagement') ?>">
                            <i class="fa fa-database"></i>
                            Gérer la base de données
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a>
                        Total gagné aujourd'hui : <b>USD <span id="totalEarnedToday"></span></b>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <i class="fa fa-user navbarIcons"></i>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-menu-header text-center">
                            <strong>
                                <?= $_SESSION['admin_name'] ?>
                            </strong>
                            <small><?= $_SESSION['admin_email'] ?></small>
                        </li>
                        <li class="divider"></li>
                        <!---<li>
                            <a href="#">
                                <i class="fa fa-gear fa-fw"></i>
                                Réglages
                            </a>
                        </li>
                        <li class="divider"></li>--->
                        <li><a href="<?= site_url('logout') ?>"><i class="fa fa-sign-out"></i> Se déconnecter</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid hidden-print">
    <div class="row content">
        <!-- Left sidebar -->
        <div class="col-sm-2 sidenav hidden-xs mySideNav">
            <br>
            <ul class="nav nav-pills nav-stacked pointer">
                <li class="<?= $pageTitle == 'Tableau de bord' ? 'active' : '' ?>">
                    <a href="<?= site_url('dashboard') ?>">
                        <i class="fa fa-home"></i>
                        Tableau de bord
                    </a>
                </li>
                <li class="<?= $pageTitle == 'Transactions' ? 'active' : '' ?>">
                    <a href="<?= site_url('transactions') ?>">
                        <i class="fa fa-exchange"></i>
                        Transactions
                    </a>
                </li>

                <?php if ($this->session->admin_role === "Super"): ?>

                    <li class="<?= $pageTitle == 'Articles' ? 'active' : '' ?>">
                        <a href="<?= site_url('items') ?>">
                            <i class="fa fa-shopping-cart"></i>
                            Articles
                        </a>
                    </li>

                    <li class="<?= $pageTitle == 'Categories' ? 'active' : '' ?>">
                        <a href="<?= site_url('category') ?>">
                            <i class="fa fa-cart-plus"></i>
                            Catégories
                        </a>
                    </li>

                    <!-- <li class="<? /*= $pageTitle == 'Customers' ? 'active' : '' */ ?>">
                            <a href="<? /*= site_url('employees') */ ?>">
                                <i class="fa fa-users"></i>
                                Employés
                            </a>
                        </li>
                        <li class="<? /*= $pageTitle == 'Reports' ? 'active' : '' */ ?>">
                            <a href="<? /*= site_url('reports') */ ?>">
                                <i class="fa fa-newspaper-o"></i>
                                Rapports
                            </a>
                        </li>
                        <li class="<? /*= $pageTitle == 'Eventlog' ? 'active' : '' */ ?>">
                            <a href="<? /*= site_url('Eventlog') */ ?>">
                                <i class="fa fa-tasks"></i>
                                Journal des événements
                            </a>
                        </li>-->

                    <li class="<?= $pageTitle == 'Couts' ? 'active' : '' ?>">
                        <a href="<?= site_url('couts') ?>">
                            <i class="fa fa-money"></i>
                            Dépenses
                        </a>
                    </li>

                    <li class="<?= $pageTitle == 'Approvisionnements' ? 'active' : '' ?>">
                        <a href="<?= site_url('eventlog/approvisionnement') ?>">
                            <i class="fa fa-refresh"></i>
                            Approvisionnements
                        </a>
                    </li>

                    <li class="<?= $pageTitle == 'Administrateurs' ? 'active' : '' ?>">
                        <a href="<?= site_url('administrators') ?>">
                            <i class="fa fa-user"></i>
                            Administrateurs
                        </a>
                    </li>

                    <li class="<?= $pageTitle == 'Base des données' ? 'active' : '' ?>">
                        <a href="<?= site_url('dbmanagement') ?>">
                            <i class="fa fa-database"></i>
                            Base des données
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <br>
        </div>
        <!-- Left sidebar ends -->
        <br>

        <!-- Main content -->
        <div class="col-sm-10">
            <?= isset($pageContent) ? $pageContent : "" ?>
        </div>
        <!-- Main content ends -->
    </div>
</div>

<footer class="container-fluid text-center hidden-print">
    <p>
        <i class="fa fa-copyright"></i>
        Copyright <a href="https://novictech.com/" target='_blank' class="text-primary">Novic Tech sarl.</a> (2022)
    </p>
</footer>

<!--Modal to show flash message-->
<div id="flashMsgModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="flashMsgHeader">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center><i id="flashMsgIcon"></i> <font id="flashMsg"></font></center>
            </div>
        </div>
    </div>
</div>
<!--Modal end-->

<!--modal to display transaction receipt when a transaction's ref is clicked on the transaction list table -->
<div class="modal fade" role='dialog' data-backdrop='static' id="transReceiptModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header hidden-print">
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Reçu de transaction</h4>
            </div>
            <div class="modal-body" id='transReceipt' style="height: 80vh; overflow-y:auto;"></div>
        </div>
    </div>
</div>
<!-- End of modal-->


<!--Login Modal-->
<div class="modal fade" role='dialog' data-backdrop='static' id='logInModal'>
    <div class="modal-dialog">
        <!-- Log in div below-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="close closeLogInModal">&times;</button>
                <h4 class="text-center">S'identifier</h4>
                <div id="logInModalFMsg" class="text-center errMsg"></div>
            </div>
            <div class="modal-body">
                <form name="logInModalForm">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for='logInModalEmail' class="control-label">E-mail ou Phone</label>
                            <input type="text" id='logInModalEmail' class="form-control checkField"
                                   autocomplete="username email" placeholder="E-mail" autofocus>
                            <span class="help-block errMsg" id="logInModalEmailErr"></span>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label for='logInModalPassword' class="control-label">Mot de passe</label>
                            <input type="password" id='logInModalPassword' autocomplete="current-password"
                                   class="form-control checkField" placeholder="Mot de passe">
                            <span class="help-block errMsg" id="logInModalPasswordErr"></span>
                        </div>
                    </div>

                    <div class="row">
                        <!--<div class="col-sm-6 pull-left">
                            <input type="checkbox" class="control-label" id='remMe'> Remember me
                        </div>-->
                        <div class="col-sm-4"></div>
                        <div class="pull-right">
                            <button id='loginModalSubmit' class="btn btn-primary">Se connecter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End of log in div-->
    </div>
</div>
<!---end of Login Modal-->

<!-- custom JS -->
<script src="<?= base_url() ?>public/js/main.js"></script>
</body>
</html>
