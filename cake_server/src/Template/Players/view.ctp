<!-- File: src/Template/Articles/view.ctp -->

<h1> Liste des combattants :</h1>
<div class="row"><div class="col-sm-4">
  <?php foreach ($fighters as $fighter):
    echo $this->Form->create('UpdateName',array(
      'url' => array(
        'controller' => 'players',
        'action' => 'editFighter'
      ),
      'class' => ['card']
    ));
  ?>
    <div class="card-block">
      <div class="card-title">
        <?php
        echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :','value' => $fighter->name));
        echo $this->Form->input('fighterId',array('type' => 'hidden','value' => $fighter->id));
        ?>
      </div>
      <div class="card-subtitle text-muted"><?= $fighter->level ?></div>
      <div class="card-subtitle text-muted"><?= $fighter->xp ?></div>
      <div class="card-subtitle text-muted"><?= $fighter->skill_sight ?></div>
      <div class="card-subtitle text-muted"><?= $fighter->skill_strength ?></div>
      <div class="card-subtitle text-muted"><?= $fighter->skill_health ?></div>
      <div class="card-subtitle text-muted"><select name="guildId">
            <?php foreach($guilds as $guild): ?>
              <option value=<?= $guild->id ?> <?php if($guild->id==$fighter->guild_id){ echo 'selected'; }?>><?= $guild->name ?></option>
            <?php endforeach; ?>
          </select>
      </div>
      <div class="card-link">
        <?= $this->Html->link("Supprimer", ['controller' => 'players','action' => 'removeFighter', $fighter->id], ['class' => 'button']) ?>
        <?php echo $this->Form->button(__("Sauvegarder"));
              echo $this->Form->end();
        ?>
      </div>
    </div>
  <?php endforeach; ?>
</div></div>
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
