<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'PRS';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <!-- <?= $this->Html->meta('icon') ?> 
     <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?> -->

    <?= $this->Html->css('materialize.min.css') ?>
    <?= $this->Html->script('jquery-3.5.1.min.js') ?>
    <?= $this->Html->script('fusioncharts/fusioncharts.js') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class="blue-grey lighten-5">
    <!--     <nav>
        <div class="nav-wrapper indigo z-depth-1">
            <a href=" <?= ($Luser['id'] || $admin['id']) ? '/data_analysis' : '' ?> " class="brand-logo center">Products Ranking System</a>
            <?php if ($Luser['id'] || $admin['id']) : ?>
                <a href="#" data-target="slide-out" class="sidenav-trigger left show-on-large">
                    <i class="material-icons">menu</i>
                </a>
            <?php endif ?>
        </div>
    </nav> -->

    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper indigo z-depth-2">
                <a href=" <?= ($Luser['id'] || $admin['id']) ? '/data_analysis' : '' ?> " class="brand-logo center">Products Ranking System</a>
                <?php if ($Luser['id'] || $admin['id']) : ?>
                    <a href="#" data-target="slide-out" class="sidenav-trigger left show-on-large">
                        <i class="material-icons">menu</i>
                    </a>
                <?php endif ?>
            </div>
        </nav>
    </div>

    <!-- side nav -->
    <!-- for UserPanel -->
    <?php if ($Luser['id']) : ?>
        <ul id="slide-out" class="sidenav">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img width="300" height="500" src="/img/profile_img/background.jpg">
                    </div>
                    <a><img class="circle" src="<?= ($Luser['profile_img']) ? '/img/profile_img/' . $Luser['profile_img'] : '/img/profile_img/default.png'  ?>"></a>
                    <a><span class="white-text name"><?= $Luser['name'] ?></span></a>
                    <a><span class="white-text email"><?= $Luser['email'] ?></span></a>
                </div>
            </li>
            <li><a href="/view_user/<?= $Luser['id'] ?>"><i class="material-icons light-blue-text">person</i>My Profile</a></li>
            <li><a href="/edit_user/<?= $Luser['id'] ?>"><i class="material-icons pink-text text-lighten-2">edit</i>Update Profile</a></li>
            <li><a class="waves-effect" href="/user/prizes"><i class="material-icons yellow-text text-darken-1">monetization_on</i>Scores & Rewards</a></li>
            <li><a class="waves-effect" href="/rewardhistory"><i class="material-icons yellow-text text-darken-4">pages</i>Rewards History</a></li>
            <li><a class="waves-effect" href="/notifications"><i class="material-icons green-text">local_play</i>Surveys</a></li>
            <li><a class="waves-effect" href="/answers"><i class="material-icons green-text text-darken-2">pages</i>Surveys History</a></li>
            <li><a class="waves-effect" href="/products"><i class="material-icons brown-text">local_parking</i>Products</a></li>
            <li><a class="waves-effect" href="/logout"><i class="material-icons red-text">exit_to_app</i>Logout</a></li>
        </ul>
    <?php endif ?>

    <!-- for AdminPanel -->
    <?php if ($admin['id']) : ?>
        <ul id="slide-out" class="sidenav">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img width="300" height="500" src="/img/profile_img/background.jpg">
                    </div>
                    <a><img class="circle" src="<?= '/img/profile_img/default.png'  ?>"></a>
                    <a><span class="white-text name">Admin</span></a>
                    <a><span class="white-text email"><?= $admin['email'] ?></span></a>
                </div>
            </li>
            <li><a href="/admin/"><i class="material-icons orange-text text-darken-2">account_box</i>Admins</a></li>
            <li><a href="/users"><i class="material-icons blue-text text-darken-2">group</i>Users</a></li>
            <li><a class="waves-effect" href="/products"><i class="material-icons teal-text text-darken-1">local_parking</i>Products</a></li>
            <li><a class="waves-effect" href="/companies"><i class="material-icons green-text text-accent-3">work</i>Companies</a></li>
            <li><a class="waves-effect" href="/categories"><i class="material-icons cyan-text ">apps</i>Categories</a></li>
            <li><a class="waves-effect" href="/surveys"><i class="material-icons green-text">local_play</i>Surveys</a></li>
            <li><a class="waves-effect" href="/admin/luckydraw"><i class="material-icons purple-text text-lighten-1">card_giftcard</i>Lucky Draw</a></li>
            <li><a class="waves-effect" href="/admin/prize"><i class="material-icons yellow-text text-darken-2">local_atm</i>Prizes</a></li>
            <li><a class="waves-effect" href="/admin/logout"><i class="material-icons red-text">exit_to_app</i>Logout</a></li>
        </ul>
    <?php endif ?>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
    <!--JavaScript at end of body for optimized loading-->
    <?= $this->Html->script('materialize.min.js') ?>
</body>

</html>

<script>
    $(document).ready(function() {
        $('.sidenav').sidenav();
    });
</script>

<style>
    html {
        font-family: 'Raleway', "Open Sans";
    }

    .error-alert {
        padding: 10px;
        background-color: #F78181;
        color: white;
    }

    .success-alert {
        padding: 10px;
        background-color: #3CC099;
        color: white;
    }

    .warning-alert {
        padding: 10px;
        background-color: #FFBB34;
        color: white;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }

    div.message {
        text-align: center !important;
        cursor: pointer;
        display: block;
        font-weight: normal !important;
        padding: 0 1.5rem 0 1.5rem;
        transition: height 300ms ease-out 0s;
        background-color: #a0d3e8;
        color: #626262;
        top: 15px;
        right: 15px;
        z-index: 999;
        overflow: hidden;
        height: 50px;
        line-height: 3.2em;
        margin-bottom: 0px !important;
        margin-top: 0px !important;
    }

    div.message.error {
        background-color: #F78181;
        color: #FFF;
    }

    div.message.success {
        background-color: #3CC099;
        color: #FFF;
    }

    div.message.hidden {
        height: 0;
    }

    .pagination .active {
        background-color: #3F51B5 !important;
    }
</style>