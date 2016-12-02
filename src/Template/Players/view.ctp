<!-- File: src/Template/Articles/view.ctp -->

<h1> Liste des combattants :</h1>
<div class="row">
  <?php foreach ($fighters as $fighter):
    echo $this->Form->create('UpdateName',array(
      'url' => array(
        'controller' => 'players',
        'action' => 'editFighter'
      ),
      'class' => ['']
    ));
  ?>
  <div class="col-lg-3 ">
    <div class="card-block frame-blue frame-players">
      <div class="card-title">
        <div class="frame-guild row">
          <img src="../webroot/img/portrait/portrait_<?= $fighter->id ?>.png" class="col-lg-4"/>
          <ul class="name-guild">
            <li><h3 class="card-title no-padding"><?= $fighter->name ?></h3></li>
            <li><p>Ma guilde</P></li>
          </ul>
        </div>
        <?php
        echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :','value' => $fighter->name));
        echo $this->Form->input('fighterId',array('type' => 'hidden','value' => $fighter->id));
        ?>
      </div>

      <select name="guildId">
            <?php foreach($guilds as $guild): ?>
              <option value=<?= $guild->id ?> <?php if($guild->id==$fighter->guild_id){ echo 'selected'; }?>><?= $guild->name ?></option>
            <?php endforeach; ?>
      </select>

      <div class="card-text bold">LVL <?= $fighter->level ?></div>
      <div class="card-text">XP <?= $fighter->xp ?></div>
      <div class="card-text"><img src="../webroot/img/caracteristiques/view.png" class="carac-img"/> <?= $fighter->skill_sight ?></div>
      <div class="card-text"><img src="../webroot/img/caracteristiques/health.png" class="carac-img"/> <?= $fighter->skill_strength ?></div>
      <div class="card-text"><img src="../webroot/img/caracteristiques/attack.png" class="carac-img"/> <?= $fighter->skill_health ?></div>

      <div class="card-link">
        <?= $this->Html->link("Supprimer", ['controller' => 'players','action' => 'removeFighter', $fighter->id], ['class' => 'btn btn-primary']);?>
        <?php echo $this->Form->button(__("Sauvegarder"));
              echo $this->Form->end();
        ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<div class="">
<div class="col-lg-4 frame-add-player frame-blue frame-players">
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
</div>
</div>
