<?php

// src/Controller/PlayersController.php

namespace App\Controller;

class PlayersController extends AppController
{
  public function initialize()
  {
    parent::initialize();
    $this->loadComponent('Flash'); // Charge le FlashComponent
  }
  public function index()
  {
    $players = $this->Players->find('all');
    $this->set(compact('players'));
  }
  public function view($id = null)
  {
    $this->set('player',$this->Players->get($id));
  }
  public function add()
  {
    $player = $this->Players->newEntity();
    if ($this->request->is('post')) {
      $player = $this->Players->patchEntity($player, $this->request->data);
      if ($this->Players->save($player)) {
        $this->Flash->success(__('Votre article a été sauvegardé.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('La création du compte a échoué.'));
    }
    $this->set('player', $player);
  }
  public function edit($id = null)
  {
    $player = $this->Players->get($id);
    if($this->request->is(['post','put'])){
      $this->Players->patchEntity($player, $this->request->data);
      if($this->Players->save($player)){
        $this->Flash->success(__('Votre article a été mis à jour.'));
        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('Impossible de mettre à jour votre article.'));
    }
    $this->set('player', $player);
  }
}

?>
