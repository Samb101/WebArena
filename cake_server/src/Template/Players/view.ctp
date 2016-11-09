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
    <th>Supprimer le personnage</th>
  </tr>
  <?php foreach ($fighters as $fighter): ?>
    <tr>
      <td>
        <?php
        echo $this->Form->create('UpdateName',array(
          'url' => array(
            'controller' => 'players',
            'action' => 'editPlayer'
          )
        ));
        echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :','value' => $fighter->name));
        echo $this->Form->input('fighterid',array('type' => 'hidden','value' => $fighter->id));
        echo $this->Form->input('playerid',array('type' => 'hidden','value' => $id));
        echo $this->Form->button(__("Renommer le perso"));
        echo $this->Form->end();
        ?>
      </td>
      <td><?= $fighter->level ?></td>
      <td><?= $fighter->xp ?></td>
      <td><?= $fighter->skill_sight ?></td>
      <td><?= $fighter->skill_strength ?></td>
      <td><?= $fighter->skill_health ?></td>
      <td><?= $fighter->guild_id ?></td>
      <td><?= $this->Html->link("Supprimer", ['controller' => 'players','action' => 'removeFighter', $fighter->id, $id], ['class' => 'button']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php
  echo $this->Form->create('CreateFighter',array(
    'url' => array(
      'controller' => 'players',
      'action' => 'createFighter'
    )
  ));
  echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :'));
  echo $this->Form->input('player_id',array('type' => 'hidden','value' => $id));
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
