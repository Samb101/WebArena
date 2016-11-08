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
      <th>Actions</th>
  </tr>
  <?php foreach ($fighters as $fighter): ?>
  <tr>
      <td><?= $fighter->name ?></td>
      <td><?= $fighter->level ?></td>
      <td><?= $fighter->xp ?></td>
      <td><?= $fighter->skill_sight ?></td>
      <td><?= $fighter->skill_strength ?></td>
      <td><?= $fighter->skill_health ?></td>
      <td><?= $fighter->guild_id ?></td>
      <td><?php
            echo $this->Form->create('UpdateName',array(
              'url' => array(
                'controller' => 'players',
                'action' => 'editPlayer'
              )
            ));
            echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :'));
            echo $this->Form->input('fighterid',array('type' => 'hidden','value' => $fighter->id));
            echo $this->Form->input('playerid',array('type' => 'hidden','value' => $id));
            echo $this->Form->button(__("Renommer le perso"));
            echo $this->Form->end();
          ?>
      </td>
  </tr>
  <?php endforeach; ?>
</table>
