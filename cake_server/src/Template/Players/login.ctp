<!-- File: src/Template/Articles/connect.ctp -->

<h1>Connexion</h1>
<?php
  echo $this->Form->create('Registration',array(
    'url' => array(
      'controller' => 'players',
      'action' => 'add'
    )
  ));
  echo $this->Form->input('email',array('type' => 'email','label' => 'Adresse email :'));
  echo $this->Form->input('password', array('type' => 'password', 'label' => 'Mot de passe :'));
  echo $this->Form->input('password', array('type' => 'password', 'label' => 'Confirmez le mot de passe :'));
  echo $this->Form->button(__("Créer le compte"));
  echo $this->Form->end();

  echo $this->Form->create('Login',array(
    'url' => array(
      'controller' => 'players',
      'action' => 'login'
    )
  ));
  echo $this->Form->input('email',array('type' => 'email','label' => 'Adresse email :'));
  echo $this->Form->input('password', array('type' => 'password', 'label' => 'Mot de passe :'));
  echo $this->Form->button(__("Connexion"));
  echo $this->Form->end();
?>
