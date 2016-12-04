<div class="container">
  <div class="card-deck-wrapper">
  <div class="card-deck">
    <div class="card jumbotron">
      <h3 class="display-5">Bienvenue sur l'interface de votre personnage</h3>
      <p class="lead">C'est un véritable tableau de bord qui s'offre à vous.</p>
      <hr class="my-2">
      <p>Vous pouvez créer un nouveau personnage, le renommer à bon escient, et choisir d'intégrer une guilde.</p>
      <p class="lead">
        <a class="btn btn-primary btn-lg" href="../guilds/view" role="button">Voir les guildes</a>
      </p>
    </div>


    <div class="card">
      <div class=card-block>
        <h3 class=card-title>Ajouter un combattant</h3>
        <?php
        echo $this->Form->create('CreateFighter',array(
          'url' => array(
            'controller' => 'players',
            'action' => 'createFighter'
          )
        ));
        echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :'));
        ?>
        <label for="guild_id">Guilde :</label>
        <select name="guild_id">
          <?php foreach($guilds as $guild): ?>
            <option value=<?= $guild->id ?>><?= $guild->name ?></option>
          <?php endforeach; ?>
        </select>
        <br/>
        <br/>
        <?php
        echo $this->Form->button(__("Ajouter un combattant"), array('class' => 'btn btn-success'));
        echo $this->Form->end();
        ?>
      </div>
    </div>


    <div class=card>
      <div class="card-block">
        <h3 class=card-title>Top Ladder
          <small class="text-muted">
            <br/>Attention à ceux là.
          </small></h3>
        </div>
        <div class=card-block>
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active"></div>
              <?php
              $i=0;
              foreach($others_fighters as $fighter): ?>
              <div class="carousel-item <?php if($i==0){echo "active";}?>">
                <div class="col-lg-6 col-lg-offset-6">
                  <img class="" src="../webroot/img/portrait/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
                </div>
                <p style="padding:auto;margin:auto;">
                  <?= $fighter->name ?>
                  - LVL  <?= $fighter->level ?>
                </p>
              </div>
              <?php
              $i++;
            endforeach; ?>
          </div>
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="icon-prev" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="icon-next" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <ul class="list-group list-group-flush" style="margin-left:0">
        <?php
        $i=1;
        foreach($others_fighters as $fighter): ?>
        <li class="list-group-item">
          <img src="../webroot/img/ranks/PVPRank<?php echo 15-$i; ?>.png" class="carac-img"/>
          <?php echo $i ."."; ?>         <?= $fighter->name ?>
          - LVL    <?= $fighter->level ?>
        </li>
        <?php $i++; endforeach; ?>
    </ul>
  </div>
</div>
</div>



  <?php foreach($fighters as $fighter):
    echo $this->Form->create('UpdateName',array(
      'url' => array(
        'controller' => 'players',
        'action' => 'editFighter'
      ),
      'class' => ['']
    ));?>

    <div class="card">
      <div class="card-block">
        <div class=card-title>
          <h3 class=""><img class="" src="../webroot/img/portrait/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
            <?= $fighter->name ?>
            <small class="text-muted">
              - LVL <?= $fighter->level ?>
            </small>
          </h3>
        </div>

        <div class="text-xs-center" id="example-caption-1">XP <?= $fighter->xp ?></div>
        <progress class="progress" value="<?= $fighter->xp%4/4*100?>" max="100" aria-describedby="example-caption-1"></progress>


        <?php
        echo $this->Form->input('name',array('type' => 'text', 'label' => false , 'class' => 'form-control','value' => $fighter->name, 'aria-describedby'=>'basic-addon1'));
        echo $this->Form->input('fighterId',array('type' => 'hidden','value' => $fighter->id));
        ?>

      </div>

      <ul class="list-group list-group-flush" style="margin-left:0">
        <li class="list-group-item">
          <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_sight ?></span>
          <img src="../webroot/img/caracteristiques/view.png" class=""/>
          Distance de vue
        </li>
        <li class="list-group-item">
          <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_strength ?></span>
          <img src="../webroot/img/caracteristiques/health.png" class=""/>
          Santé
        </li>
        <li class="list-group-item">
          <span class="tag tag-default tag-pill float-xs-right"> <?= $fighter->skill_health ?></span>
          <img src="../webroot/img/caracteristiques/attack.png" class=""/>
          Force
        </li>
      </ul>
      <?php foreach($guilds as $guild): ?>
        <div class=card-block>
          <h4 class="card-title text-justify">
            <img class=col-lg-3 src="../webroot/img/tabard_guilde/guild_<?= $guild->id ?>.png">
            <?= $guild->name ?>
          </h4>
          </div>
          <ul class="list-group list-group-flush" style="margin-left:0">
            <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_strength ?></span>
              <img src="../webroot/img/avg_lvl.png" class="img-responsive"/>
              Moyenne LVL
            </li>
            <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"> <?= $fighter->skill_health ?></span>
              <img src="../webroot/img/clsmt_guild.png" class=""/>
              Classement guilde
            </li>
          </ul>

          <div class=card-block>
            <div class="form-group">
              <select name="guildId" class="form-control">
                <?php foreach($guilds as $guild): ?>
                  <option value=<?= $guild->id ?> <?php if($guild->id==$fighter->guild_id){ echo 'selected'; }?>><?= $guild->name ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="card-link">
              <?php
              echo $this->Form->button(__("Sauvegarder"), array('class' => 'btn btn-success', action));
              echo $this->Form->button(__("Supprimer"), array('class' => 'btn btn-danger'));
              echo $this->Form->button(__("Sauvegarder"), array('class' => 'btn btn-success'));
              echo $this->Html->link(__("Supprimer"), ['controller' => 'players', 'action' => 'removeFighter', $fighter->id], array('class' => 'btn btn-danger'));
              echo $this->Form->end();
              ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endforeach; ?>
</div>
</div>
</div>


<!--<div style="display:inline-block; margin 5px; padding:10px; border:1px solid black">
<h2 style="text-align:center">My title</h2>
<img style="display:block; margin:auto"src="../webroot/img/portrait/portrait_1.png">
<p style="text-align:center">Descriptif</p>
</div>
<div style="display:inline-block; margin:5px; padding:10px; border:1px solid black">
<h2>My title</h2>
<img style="display:block; margin:auto" src="../webroot/img/portrait/portrait_1.png">
<p style="text-align:center; padding:10px">Descriptif</p>
</div>-->
