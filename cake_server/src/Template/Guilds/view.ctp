<!-- File: src/Template/Guilds/view.ctp -->

<h1>Guildes :</h1>
<?php
  foreach($guilds as $guild) {
    ?>
    <h2><?= $guild->name ?></h2>
      <?php foreach($guild->fighters as $fighter){ ?>
        <div class="card card-block">
        <img src="<?= $fighter->avatar ?>" alt="avatar" class="card-img-top"/>
        <div class="card-block">
          <p class="card-title"><?= $fighter->name ?></p>
          <p class="card-text"><?= $fighter->level ?></p>
          <p class="card-text"><?= $fighter->xp ?></p>
          <p class="card-text"><?= $fighter->skill_sight ?></p>
          <p class="card-text"><?= $fighter->skill_health ?></p>
          <p class="card-text"><?= $fighter->skill_strength ?></p>
        </div>
      </div>
      <?php }
      ?>
    <?php
  }
?>
