<!-- File: src/Template/Articles/index.ctp -->

<h1>Joueurs :</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Adresse e-mail</th>
        <th>Mot de passe</th>
    </tr>

    <!-- Ici se trouve l'itération sur l'objet query de nos $articles, l'affichage des infos des articles -->

    <?php foreach ($players as $player): ?>
    <tr>
        <td><?= $player->id ?></td>
        <td>
            <?= $this->Html->link($player->email, ['action' => 'edit', $player->id]) ?>
        </td>
        <td>
            <?= $player->password ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
