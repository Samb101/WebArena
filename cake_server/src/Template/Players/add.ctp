<!-- File: src/Template/Articles/add.ctp -->

<h1>Créer un compte</h1>
<?php
    echo $this->Form->input('email',array('type' => 'email','label' => 'Adresse email :'));
    echo $this->Form->input('password', array('type' => 'password', 'label' => 'Mot de passe :'));
    echo $this->Form->input('password', array('type' => 'password', 'label' => 'Confirmez le mot de passe :'));
    echo $this->Form->button(__("Créer le compte"));
    echo $this->Form->end();

?>
