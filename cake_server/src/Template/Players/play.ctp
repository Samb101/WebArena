<!-- File: src/Template/Players/play.ctp -->
<div class=container>
  <div class=row>
    <ol class="breadcrumb no-margin-left">
      <li class="breadcrumb-item active">L'Arène</li>
    </ol>

    <div class=col-lg-9 id="arena_container">
      <!-- IMPORTANT DO NOT DELETE -->
      <span class=hide id="fighterID"><?=$id?></span>
      <span class=hide id="posX"><?=$posX?></span>
      <span class=hide id="posY"><?=$posY?></span>
      <!-- IMPORTANT DO NOT DELETE --->

      <canvas id="arena"></canvas>
      <div class=row>
      <div class="card col-lg-3 HUD">
        <div class=card-block>
          <div class=card-title>
            <img class="image-center" src="../webroot/img/portrait_fighters/portrait_<?=$id?>.png" alt="Icône de personnage" />
            <h3 class="text-center">
                <?= $name ?>
            </h3>
            <h5 class="text-center" id="level">
                LVL  <?= $level ?>
            </h5>
            </div>
            <div class="text-xs-center" id="xp-text">XP : <?= $xp ?></div>
            <progress class="progress" value="<?= $xp%4/4*100?>" max="100" aria-describedby="xp-test" id="xp-progress"></progress>
            <div class="text-xs-center" id="pv-text">PV : <?= $current_health ?></div>
            <progress class="progress" value="<?=$current_health?>" max="<?=$health?>" aria-describedby="pv-progress" id="pv-progress"></progress>
        </div>
        <ul class="list-group list-group-flush no-margin-left">
          <li class="list-group-item">
            <span class="tag tag-default tag-pill float-xs-right"><?=$posX?></span>
            Position X
          </li>
          <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"><?=$posY?></span>
            Position Y
          </li>
          <li class="list-group-item">
            <span class="tag tag-default tag-pill float-xs-right" id="sight"><?=$sight?></span>
            <img src="../webroot/img/caracteristiques/view.png" class=""/>
             Vue
          </li>
          <li class="list-group-item">
            <span class="tag tag-default tag-pill float-xs-right" id="strength"><?=$strength?></span>
            <img src="../webroot/img/caracteristiques/attack.png" class=""/>
            Force
          </li>
        </ul>
      </div>

      <div class="card col-lg-3 pull-right HUD" id="lvlup">
        <div class=card-block>
          <h5 class="text-center card-title"> LVL UP </h5>
          <div class=row>
          <img src="../webroot/img/caracteristiques/attack.png" class="col-lg-6"/>
          <img src="../webroot/img/add-skill.png" class="col-lg-6" onclick="upgradeSkill(2)"/>
        </div>
        <hr>
        <div class=row>
          <img src="../webroot/img/caracteristiques/view.png" class="col-lg-6"/>
          <img src="../webroot/img/add-skill.png" class="col-lg-6" onclick="upgradeSkill(3)"/>
        </div>
        <hr>
        <div class=row>
          <img src="../webroot/img/caracteristiques/health.png" class="col-lg-6"/>
          <img src="../webroot/img/add-skill.png" class="col-lg-6" onclick="upgradeSkill(1)"/>
        </div>
        </div>
    </div>
</div>
</div>

  <div class="col-lg-3">
    <div class=card>
    <div class=card-block>
      <h2 class="card-title text-center">Armée</h2>
      <?php foreach($fighters as $fighter):?>
        <button type="button" class="btn btn-secondary" onclick="setNewPlayer(<?= $fighter->id ?>)">
          <span class="tag tag-default tag-pill float-xs-right">LVL <?=$fighter->level?></span>
          <img src="../webroot/img/portrait_fighters/portrait_<?= $fighter->id ?>.png" class=""/>
           <?= $fighter->name ?>
        </button>
      <?php endforeach;?>
    </div>
    </div>
  </div>

</div>
</div>
