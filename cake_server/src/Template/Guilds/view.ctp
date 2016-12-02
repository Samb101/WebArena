<!-- File: src/Template/Guilds/view.ctp -->
<style>
.frame-players{
  border:1px solid black;
  border-radius: 3px;
  margin:5px;
  background-color: #337ab7;
}
.frame-players p, h3{
  color:#fff;
}
.frame-players h3{
  text-shadow: 2px 2px rgba(255,255,255,0.1);
}
.frame-guild{
  display:flex;
  align-items: center;
}
.guild-img{
  width:10%;
  height:10%;
}

.vcenter {
    display: inline-block;
    vertical-align: middle;
    float: none;
}
.carac-img{
  width:32px;
  height:32px;

}
.bold{
  font-weight: bold;
}
</style>

<h1>Guildes</h1><br/>
<?php
  foreach($guilds as $guild) {
    ?>

    <div class="frame-guild row">
    <img src="../webroot/img/tabard_guilde/guild_<?= $guild->id ?>.png" class="col-lg-3 guild-img"/>
    <h2><?= $guild->name ?></h2>
  </div>
      <?php foreach($guild->fighters as $fighter){ ?>

        <div class="frame-blue frame-players col-lg-3">
        <div class="card-block">
        <div class="frame-guild row">
          <img src="../webroot/img/portrait/portrait_<?= $fighter->id ?>.png" class="col-lg-4"/>
          <h3 class="card-title"><?= $fighter->name ?></h3>
        </div>
          <br/><p class="card-text bold">LVL <?= $fighter->level ?></p>
          <p class="card-text">XP : <?= $fighter->xp ?></p>
          <p class="card-text">    <img src="../webroot/img/caracteristiques/view.png" class="carac-img"/>
Vue : <?= $fighter->skill_sight ?></p>
          <p class="card-text">    <img src="../webroot/img/caracteristiques/health.png" class=" carac-img"/>
Santé : <?= $fighter->skill_health ?></p>
          <p class="card-text">    <img src="../webroot/img/caracteristiques/attack.png" class=" carac-img"/>
Force : <?= $fighter->skill_strength ?></p>
        </div>
      </div>
      <?php }
      ?><br/>
    <?php
  }
?>
