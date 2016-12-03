<!-- File: src/Template/Players/play.ctp -->
<div id="arena_container">
  <canvas id="arena"></canvas>
  <span display="none" id="fighterID"><?=$id?></span>
  <div class="details">
    <label>Santé :</label>
    <progress value="<?=$health?>" max="<?=$health?>" id="health"></progress>
  </div>
  <div class="details">
    <label>Vue :</label>
    <progress value="<?=$sight?>" max="<?=$sight?>" id="sight"></progress>
  </div>
  <div class="details">
    <label>Force :</label>
    <progress value="<?=$strength?>" max="<?=$strength?>" id="strength"></progress>
  </div>
</div>
