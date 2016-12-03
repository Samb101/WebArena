<div class=container>

  <div style="display:inline-block; margin 5px; padding:10px; border:1px solid black">
    <h2 style="text-align:center">My title</h2>
    <img style="display:block; margin:auto"src="../webroot/img/portrait/portrait_1.png">
    <p style="text-align:center">Descriptif</p>
  </div>
  <div style="display:inline-block; margin:5px; padding:10px; border:1px solid black">
    <h2>My title</h2>
    <img style="display:block; margin:auto" src="../webroot/img/portrait/portrait_1.png">
    <p style="text-align:center">Descriptif</p>
  </div>



    <div class="card-columns">

      <div class="jumbotron card">
        <h3 class="display-5">Bienvenue sur l'interface de votre personnage</h3>
        <p class="lead">C'est un véritable tableau de bord qui s'offre à vous.</p>
        <hr class="my-2">
        <p>Vous pouvez créer un nouveau personnage, le renommer à bon escient, et lui faire intégrer une guilde.</p>
        <p class="lead">
          <a class="btn btn-primary btn-lg" href="#" role="button">Voir les guildes</a>
        </p>
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
            <h3 class=card-title> Mon personnage</h3>
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

            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1">#</span>
              <?php
              echo $this->Form->input('name',array('type' => 'text', 'label' => false , 'class' => 'form-control','value' => $fighter->name, 'aria-describedby'=>'basic-addon1'));
              echo $this->Form->input('fighterId',array('type' => 'hidden','value' => $fighter->id));
              ?>
            </div>
          </div>

          <ul class="list-group list-group-flush" style="margin-left:0">
            <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_sight ?></span>
              <img src="../webroot/img/caracteristiques/view.png" class="carac-img"/>
              Distance de vue
            </li>
            <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_strength ?></span>
              <img src="../webroot/img/caracteristiques/health.png" class="carac-img"/>
              Santé
            </li>
            <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"> <?= $fighter->skill_health ?></span>
              <img src="../webroot/img/caracteristiques/attack.png" class="carac-img"/>
              Force
            </li>
          </ul>

          <div class=card-block>
            <div class="card-link">
              <?= $this->Html->link("Supprimer", ['controller' => 'players','action' => 'removeFighter', $fighter->id], ['class' => 'btn btn-danger']);?>
              <?php echo $this->Form->button(__("Sauvegarder"), array('class' => 'btn btn-success'));
              ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php foreach($guilds as $guild): ?>
        <div class=card>
          <div class="card-block">
            <h3 class=card-title>Votre guilde</h3>
          </div>
          <div class=card-title>
            <h3 class=""> <img src="../webroot/img/tabard_guilde/guild_1.png" class="col-lg-3 "/>
              <?= $guild->name ?>
            </h3>
          </div>

          <ul class="list-group list-group-flush" style="margin-left:0">
            <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_strength ?></span>
              <img src="../webroot/img/caracteristiques/health.png" class="carac-img"/>
              Moyenne LVL
            </li>
            <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"> <?= $fighter->skill_health ?></span>
              <img src="../webroot/img/caracteristiques/attack.png" class="carac-img"/>
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
            echo $this->Form->button(__("Sauvegarder"), array('class' => 'btn btn-success'));
            echo $this->Form->button(__("Quitter"), array('class' => 'btn btn-danger'));
            echo $this->Form->end();
            ?>
           </div>
          </div>
        </div>
        <?php endforeach; ?>



          <div class=card>
            <div class="card-block">
              <h3 class=card-title>Top adversaires</h3>
            </div>
            <div class=card-block>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner" role="listbox">
                <div class="carousel-item active"></div>
                <?php foreach($fighters as $fighter): ?>

                <div class="carousel-item">
                  <div class="col-lg-6 col-lg-offset-6">
                  <img class="" src="../webroot/img/portrait/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
                </div>
                  <div class=carousel-caption>
                    <?= $fighter->name ?>
                    <?= $fighter->level ?>
                  </div>
                </div>
              <?php endforeach; ?>
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
              <li class="list-group-item">
                <img src="../webroot/img/ranks/PVPRank14.png" class="carac-img"/>
                1.
              </li>
              <li class="list-group-item">
                <img src="../webroot/img/ranks/PVPRank13.png" class="carac-img"/>
                2.
              </li>
              <li class="list-group-item">
                <img src="../webroot/img/ranks/PVPRank12.png" class="carac-img"/>
                3.
              </li>
              <li class="list-group-item">
                <img src="../webroot/img/ranks/PVPRank11.png" class="carac-img"/>
                4.
              </li>
              <li class="list-group-item">
                <img src="../webroot/img/ranks/PVPRank10.png" class="carac-img"/>
                5.
              </li>
            </ul>

          </div>

          <div class=card>
            <div class=card-block>
              <div class=card-title>
              <h3> Changer d'avatar </h3>
            </div>
            <div class=card-title>
              <p class=""><img class="" src="../webroot/img/portrait/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
                Actuel
              </p>
            </div>

            <?php    for($i=1; $i<18; $i++){
echo "<img src=\"../webroot/img/portrait/portrait_". $i .".png\"> ";
            }?>
            </div>


      </div>
    </div>

    <div class="col-lg-4">
    <h3>Ajouter un combattant :</h3>
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
  <?php
  echo $this->Form->button(__("Ajouter un combattant"));
  echo $this->Form->end();
  ?>
</div>-->
