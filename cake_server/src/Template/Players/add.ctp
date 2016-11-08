<!-- File: src/Template/Articles/add.ctp -->

<h1>Créer un compte</h1>
<?php
    echo $this->Form->create($player);
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->button(__("Sauvegarder l'article"));
    echo $this->Form->end();
?>
