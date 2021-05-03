<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion </title>

    <!-- Favicon -->
    <!--[if IE]>
    <link rel="shortcut icon" href="<?=base_url()?>public/images/icon.png"><![endif]-->
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
    <!-- favicon ends --->

    <!--- LOAD CSS FILES -->
    <?php if (server()): ?>
        <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/font-awesome/css/font-awesome.min.css">

    <?php else: ?>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <?php endif; ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>public/css/form-elements.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/css/main.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>

<!-- Top content -->
<div class="top-content">

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <div style="font-size:100px">
                        <h1>
                            <img src="<?= base_url() ?>public/images/logo_white.png" alt="client-logo" height="200px">
                        </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="bg-primary text-center">
                        <span id="errMsg"></span>
                    </div>
                    <div class="form-bottom">
                        <form id="loginForm" autocomplete="off">
                            <div class="form-group">
                                <label class="sr-only" for="email">E-mail ou Phone</label>
                                <input aria-autocomplete="none" type="text" autocomplete="username email" placeholder="Email"
                                       class="form-control checkField" id="email">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="password">Mot de passe</label>
                                <input aria-autocomplete="none" type="password" autocomplete="current-password" placeholder="Mot de passe"
                                       class="form-control checkField" id="password">
                            </div>
                            <button type="submit" class="btn">Se connecter !</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center" style="color:white; margin-top: 30px;">
                    Designed and Developed by <a href="https://zxconnect.org/" target='_blank' class="text-primary">ZX
                        CONNECT sarl</a> (2020)
                </div>
            </div>
        </div>
    </div>

</div>

<!--- LOAD JS FILES -->
<?php if (server()): ?>

    <script src="<?= base_url() ?>public/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>public/bootstrap/js/bootstrap.min.js"></script>

<?php else: ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php endif; ?>

<script src="<?= base_url() ?>public/js/main.js"></script>
<script src="<?= base_url() ?>public/js/access.js"></script>
<script src="<?= base_url() ?>public/js/jquery.backstretch.min.js"></script>

</body>

</html>
