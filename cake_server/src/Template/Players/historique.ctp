<div class=container>
  <div class="list-group">
  <h2 class="list-group-item list-group-item-action active">
    Journal de combat
  </h2>

  <!-- Formatage de la couleur du tuple en fonction de l'évènement, répéré par des Reg Ex -->
  <?php foreach($events as $e) {
          if (preg_match('/Entrée/',$e->name)){ ?>
        <p class="list-group-item list-group-item-action list-group-item-info"><?= $e->name ?></p>
    <?php  } ?>
    <?php if (preg_match('/meurt/',$e->name)){ ?>
        <p class="list-group-item list-group-item-action list-group-item-danger"><?= $e->name ?></p>
    <?php  } ?>
    <?php if (preg_match('/d\'expérience/',$e->name)){ ?>
        <p  class="list-group-item list-group-item-action list-group-item-success"><?= $e->name ?></p>
    <?php  } ?>
    <?php if (preg_match('/perd/',$e->name)){ ?>
        <p  class="list-group-item list-group-item-action list-group-item-danger"><?= $e->name ?></p>
    <?php  } ?>
    <?php if (preg_match('/rate/',$e->name)){ ?>
        <p  class="list-group-item list-group-item-action list-group-item-warning"><?= $e->name ?></p>
    <?php  } ?>
    <?php if(preg_match('/réussi son attaque/',$e->name)){ ?>
      <p class="list-group-item list-group-item-action list-group-item-success"><?= $e->name ?></p>
  <?php  } ?>
<?php  }; ?>

</div>
</div>
