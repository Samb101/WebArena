<!-- File: src/Template/Articles/view.ctp -->

<h1> Liste des combattants :</h1>
<table>
  <tr>
    <th>Nom</th>
    <th>Niveau</th>
    <th>XP</th>
    <th>Points de vue</th>
    <th>Points de santé</th>
    <th>Points de vie</th>
    <th>Identifiant de guilde</th>
    <th>Modification</th>
  </tr>
  <?php foreach ($fighters as $fighter):
    echo $this->Form->create('UpdateName',array(
      'url' => array(
        'controller' => 'players',
        'action' => 'editFighter'
      )
    ));
  ?>
    <tr>
      <td>
        <?php
        echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :','value' => $fighter->name));
        echo $this->Form->input('fighterId',array('type' => 'hidden','value' => $fighter->id));
        ?>
      </td>
      <td><?= $fighter->level ?></td>
      <td><?= $fighter->xp ?></td>
      <td><?= $fighter->skill_sight ?></td>
      <td><?= $fighter->skill_strength ?></td>
      <td><?= $fighter->skill_health ?></td>
      <td><select name="guildId">
            <?php foreach($guilds as $guild): ?>
              <option value=<?= $guild->id ?> <?php if($guild->id==$fighter->guild_id){ echo 'selected'; }?>><?= $guild->name ?></option>
            <?php endforeach; ?>
          </select>
      </td>
      <td>
        <?= $this->Html->link("Supprimer", ['controller' => 'players','action' => 'removeFighter', $fighter->id], ['class' => 'button']) ?>
        <?php echo $this->Form->button(__("Sauvegarder"));
              echo $this->Form->end();
        ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
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
