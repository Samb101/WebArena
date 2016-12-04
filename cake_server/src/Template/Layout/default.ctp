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

$cakeDescription = 'WebArena';
$basicURL = 'http://localhost:8888/';
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
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.9/css/tether.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <script src="http://cdn.babylonjs.com/2-4/babylon.js"></script>
    <script src="https://code.jquery.com/pep/0.4.1/pep.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.9/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>

    <?= $this->Html->script('game.js') ?>
    <?= $this->Html->script('player.js') ?>
    <?= $this->Html->script('arena.js') ?>
    <?= $this->Html->script('babylon.fireProceduralTexture.min.js') ?>
</head>
<body>

    <nav class="navbar navbar-light bg-faded" style="box-shadow:1px 1px rgba(0,0,0,0.2);">
      <a class="navbar-brand" href="#"> Arena Junkies</a>
      <a class="btn btn-outline-success" href="<?= $basicURL ?>players/play" role="button">Jouer</a>
      <div class="float-xs-right">
       <ul class="nav navbar-nav">
           <li class="nav-item active"><a class="btn btn-outline-primary" href="<?= $basicURL ?>players/view">Tableau de bord</a></li>
           <li class="nav-item active"><a class="btn btn-outline-info" href="<?= $basicURL ?>guilds">Guildes</a></li>
           <li class="nav-item active"><a class="btn btn-outline-warning" href="<?= $basicURL ?>players/historique">Historique</a></li>
           <li class="nav-item active"><a class="btn btn-outline-secondary" href="<?= $basicURL ?>players/edit">Paramètres du compte</a></li>
       </ul>
     </div>
    </nav>

    <?= $this->Flash->render() ?>
    <div class="container clearfix" style="margin-top:50px">
        <?= $this->fetch('content') ?>
    </div>

  <footer class="footer bd-footer">
   <div class="container">
    <ul class="inline-list">
      <li><a href="https://github.com/twbs/bootstrap">Qui sommes-nous ?</a></li>
      <li><a href="https://twitter.com/getbootstrap"></a></li>
      <li><a href="/examples/">ECE Paris</a></li>
      <li><a href="/about/history/">37 quai de Grenelle 75015</a></li>

    </ul>
    <ul class=inline-list>
    <li> <p class=text-muted>Site Web réalisé par <a href="https://twitter.com/mdo" target="_blank"></a><a href="mailto:e.maincourt@gmail.com" target="_blank">Eliott Maincourt</a> et <a href="mailto:benais@edu.ece.fr">Samuel BENAÏS</a> sur une idée de Mr.Falconnet dans le cadre d'un projet en M1 à l'ECE Paris.</p>
</li>
</ul>
   </div>
  </footer>

</body>
</html>
