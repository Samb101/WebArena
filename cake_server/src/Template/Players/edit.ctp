<!-- File: src/Template/Articles/edit.ctp -->

<h1>Modifier le compte</h1>
<?php
    echo $this->Form->create($player);
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->button(__('Sauvegarder les informations'));
    echo $this->Form->end();
?>
