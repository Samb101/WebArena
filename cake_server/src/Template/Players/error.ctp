<!-- File: src/Template/Players/error.ctp -->

<h1> Un erreur est survenue : </h1>
<h2><?= $error ?></h2>
<?= $this->Html->link("Continuer", ['controller' => 'players','action' => $link], ['class' => 'button']) ?>
