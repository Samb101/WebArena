<!-- File: src/Template/Players/play.ctp -->
<div class=container>
  <div class=row>
    <ol class="breadcrumb" style="margin-left:0">
      <li class="breadcrumb-item active">L'Arène</li>
    </ol>
    
    <div class=col-lg-9 id="arena_container">
      <!-- IMPORTANT DO NOT DELETE -->
      <span style="display:none" id="fighterID"><?=$id?></span>
      <span style="display:none" id="posX"><?=$posX?></span>
      <span style="display:none" id="posY"><?=$posY?></span>
      <!-- IMPORTANT DO NOT DELETE --->

      <canvas id="arena"></canvas>

      <div class=card id="HUD-player">
        <div class=card-block>
          <div class=card-title>
            <img class="image-center" src="../webroot/img/portrait/portrait_<?=$id?>.png" alt="Icône de personnage" />
            <h3 class="text-center">
                <?= $name ?>
            </h3>
            <h5 class="text-center">
                LVL  <?= $level ?>
            </h5>
            </div>
            <div class="text-xs-center" id="example-caption-1">XP <?= $xp ?></div>
            <progress class="progress" value="<?= $xp%4/4*100?>" max="100" aria-describedby="example-caption-1"></progress>
            <div class="text-xs-center" id="example-caption-1">PV <?= $xp ?></div>
            <progress class="progress" value="<?=$current_health?>" max="<?=$health?>" aria-describedby="example-caption-1"></progress>
        </div>
        <ul class="list-group list-group-flush" style="margin-left:0">
          <li class="list-group-item">
            <span class="tag tag-default tag-pill float-xs-right"><?=$posX?></span>
            Position X
          </li>
          <li class="list-group-item">
              <span class="tag tag-default tag-pill float-xs-right"><?=$posY?></span>
            Position Y
          </li>
          <li class="list-group-item">
            <span class="tag tag-default tag-pill float-xs-right"><?=$sight?></span>
            <img src="../webroot/img/caracteristiques/view.png" class=""/>
             Vue
          </li>
          <li class="list-group-item">
            <span class="tag tag-default tag-pill float-xs-right"><?=$strength?></span>
            <img src="../webroot/img/caracteristiques/attack.png" class=""/>
            Force
          </li>
        </ul>
      </div>
    </div>


  <div class="col-lg-3">
    <div class=card>
    <div class=card-block>
      <h2 class="card-title text-center">Armée</h2>
      <?php foreach($fighters as $fighterz): ?>
        <button type="button" class="btn btn-secondary">
          <span class="tag tag-default tag-pill float-xs-right">LVL <?=$fighterz->level?></span>
          <img src="../webroot/img/portrait/portrait_<?= $fighterz->id ?>.png" class=""/>
           <?= $fighterz->name ?>
        </button>
    </div>
      <?php endforeach;?>
    </div>
  </div>

</div>
</div>
