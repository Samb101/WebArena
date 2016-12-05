<h1>Guildes</h1>
<div class=container>
<?php
  foreach($guilds as $guild) {?>

    <!-- pour chaque guilde on généré un Card Columns -->
    <div class="row">
      <ol class="breadcrumb no-margin-left" >
        <li class=breadcrumb-item><?= $guild->name ?></h2></li>
      </ol>
    </div>
    <div class=card-columns>

      <!-- Première card avec le logo et les options pour la guilde -->
      <div class="card jumbotron">
        <h3 class="display-5 text-center"><?= $guild->name ?></h3>
        <img src="../webroot/img/tabard_guilde/guild_<?= $guild->id ?>.png" alt="<?= $guild->name ?>" class="image-center">
        <hr class="my-2">
        <p class="lead">
          <div class="btn-group dropup">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Changer de tabard</button>
          <div class="dropdown-menu">
            <?php for($i=1;$i<11;$i++){ ?>
              <a class="col-lg-5" href="#"><img alt="Tabard de Guilde" src="../webroot/img/tabard_guilde/guild_<?php echo $i;?>.png"  href="/guilds/change-tabard/<?php echo $i;?>)" onclick="setTabard(<?php echo $i ?>, <?= $guild->name ?>)" ></a>
              <?php }?>
          </div>
        </div>
        </p>
        <p class="lead">
        <?php
          echo $this->Html->link(__("Supprimer la guilde"), ['controller' => 'guilds', 'action' => 'removeGuild', $guild->id], array('class' => 'btn btn-danger col-lg-6'));
          ?>
      </p>
    </div>

      <!-- Card des personnages de la guilde -->
      <?php foreach($guild->fighters as $fighter){ ?>
        <div class=card>

          <!-- Le nom du personnage et son niveau -->
          <div class=card-block>
            <div class=card-title>
              <h3 class=""><img class="" src="../webroot/img/portrait_fighters/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
                <?= $fighter->name ?>
              </h3>
            </div>
            <p class="text-center font-weight-bold"> LVL  <?= $fighter->level?></p>
          </div>

          <!-- Liste des caractéristiques du personnage -->
              <ul class="list-group list-group-flush no-margin-left">
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
              <!-- Fermeture Card -->
            </div>
      <?php }?>
    </div><!-- Fermeture Card Columns -->
<?php  }?>
</div><!-- Fermeture Container -->
