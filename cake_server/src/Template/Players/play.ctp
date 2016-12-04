<!-- File: src/Template/Players/play.ctp -->
<div id="arena_container">
  <canvas id="arena"></canvas>
  <span display="none" id="fighterID"><?=$id?></span>
  <span display="none" id="posX"><?=$posX?></span>
  <span display="none" id="posY"><?=$posY?></span>
  <h3>Niveau <span id="level"><?=$level?></span></h3>
  <div class="details">
    <label>Santé : <?=$current_health?> / <?=$health?></label>
    <progress value="<?=$current_health?>" max="<?=$health?>" id="health"></progress>
  </div>
  <div class="details">
    <label>Vue : <?=$sight?></label>
    <progress value="<?=$sight?>" max="100" id="sight"></progress>
  </div>
  <div class="details">
    <label>Force : <?=$strength?></label>
    <progress value="<?=$strength?>" max="100" id="strength"></progress>
  </div>
  <div class="details">
    <label>XP : <?=$xp?> / 4</label>
    <progress value="<?=$xp%4?>" max="4" id="health"></progress>
  </div>
</div>
