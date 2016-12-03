<!-- File: src/Template/Players/play.ctp -->
<div id="arena_container">
  <canvas id="arena"></canvas>
  <div class="details">
    <label>Santé :</label>
    <progress value="<?=$health?>" max="<?=$health?>"></progress>
  </div>
  <div class="details">
    <label>Vue :</label>
    <progress value="<?=$sight?>" max="<?=$sight?>"></progress>
  </div>
  <div class="details">
    <label>Force :</label>
    <progress value="<?=$strength?>" max="<?=$strength?>"></progress>
  </div>
</div>
