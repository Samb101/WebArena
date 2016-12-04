<h1>Guildes</h1>
<div class=container>
<?php
  foreach($guilds as $guild) {?>
    <div class="row">
      <ol class="breadcrumb" style="margin-left:0">
        <li class=breadcrumb-item><?= $guild->name ?> <?= $avg_guild->avg ?></h2></li>
      </ol>
    </div>
    <div class=card-columns>
      <?php foreach($guild->fighters as $fighter){ ?>
        <div class=card>
          <div class=card-block>
            <div class=card-title>
              <h3 class=""><img class="" src="../webroot/img/portrait/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
                <?= $fighter->name ?>
              </h3>
            </div>
            <p class="text-center font-weight-bold"> LVL  <?= $fighter->level?></p>

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
            </div>
      <?php }?>
    </div>
<?php  }?>
</div>
