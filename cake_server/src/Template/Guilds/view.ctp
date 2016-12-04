<h1>Guildes</h1>
<div class=jumbotron>
<?php
  foreach($guilds as $guild) {?>

    <div class="row">
    <img src="../webroot/img/tabard_guilde/guild_<?= $guild->id ?>.png" class="col-lg-3"/>
    <h2><?= $guild->name ?></h2>
    </div>
    <div class=card-deck>
      <?php foreach($guild->fighters as $fighter){ ?>

        <div class=card>
          <div class=card-block>
              <h3 class="card-title">
                <img src="../webroot/img/portrait/portrait_<?= $fighter->id ?>.png" class="col-lg-6"/>
                <?= $fighter->name ?>
              </h3>
            <p class=font-weight-bold> LVL  <?= $fighter->level ?></p>
            <p class=font-weight-bold> XP <?= $fighter->xp ?></p>
            </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_sight ?></span>
                  <img src="../webroot/img/caracteristiques/view.png" class=""/>
                  Distance de vue
                </li>
                <li class="list-group-item">
                  <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_strength ?></span>
                  <img src="../webroot/img/caracteristiques/health.png" class=""/>
                  Moyenne LVL
                </li>
                <li class="list-group-item">
                  <span class="tag tag-default tag-pill float-xs-right"> <?= $fighter->skill_health ?></span>
                  <img src="../webroot/img/caracteristiques/attack.png" class=""/>
                  Classement guilde
                </li>
              </ul>
            </div>
            
      <?php }?>
    <br/>
  </div>
<?php  }?>
</div>
