<?php

// src/Controller/PlayersController.php

namespace App\Controller;

class PlayersController extends AppController
{
  // Fonction d'initialisation du module
  public function initialize(){
    // On appelle le constructeur du parent AppController
    parent::initialize();
    // Puis on charge le composant Flash nous permettant l'affichage de messages à l'utilisateur
    $this->loadComponent('Flash');
  }

  // On redirige vers la connection si l'utilisateur n'est pas connecté
  public function index(){
    return $this->redirect(['action' => 'login']);
  }

  // Fonction de visualisation des paramètres du compte identifié par son id
  // Entrées : $id | null par défaut
  public function view($id = null){
    if($id == null)
      return $this->Flash->error(__('Aucun identifiant n\'a été fourni.'));

    $fighters = $this->Players->Fighters->find("all",[
      'conditions' => [
        'player_id' => $id
      ]
    ]);
    $this->set('fighters',$fighters);
    $this->set('id',$id);
  }

  // Fonction d'ajout d'un utilisateur
  public function add(){
    // On déclare une nouvelle entité player
    $player = $this->Players->newEntity();
    // On cherche dans la base de données s'il n'existe pas déjà un utilisateur avec cette adresse email
    $players = $this->Players->find('all',[
      'conditions' => [
        'email'=>$this->request->data('email')
      ]
    ]);
    // Si le compteur vaut 0, alors aucun compte avec cette adresse n'existe et on crée le compte
    if($players->count() == 0){
      // On vérifie que la requête est bien un POST
      if ($this->request->is('post')) {
        // On récupère les informations contenues dans le corps de la requête
        $player = $this->Players->patchEntity($player, $this->request->data);
        // On sauvegarde l'entrée, en cas d'échec une erreur sera levée
        if ($this->Players->save($player)) {
          // On indique à l'utilisateur la réussite de son inscription
          $this->Flash->success(__('Compte créé. Vous pouvez maintenant vous connecter.'));
        }
        $this->Flash->error(__('La création du compte a échoué.'));
      }
    }
    // Sinon on lève une erreur
    else {
      $this->Flash->error(__('Un compte avec cette adresse existe déjà.'));
    }
  }

  // Fonction d'édition du profil identifié par id
  // Entrées : $id | null par défaut
  public function edit($id = null){
    // On récupère les informations du joueur
    $player = $this->Players->get($id);
    // On vérifie que la requête est bien de type POST ou PUT
    if($this->request->is(['post','put'])){
      // On met à jour les données du compte avec celles contenues dans le corps de la requête
      $this->Players->patchEntity($player, $this->request->data);
      // On enregistre les modifications
      if($this->Players->save($player)){
        // On indique à l'utilisateur que les informations ont été mises à jour
        $this->Flash->success(__('Les informations ont été mises à jour.'));
      }
      else {
        // En cas d'erreur au cours de la sauvegarde, on l'indique à l'utilisateur
        $this->Flash->error(__('Impossible de mettre à jour les informations.'));
      }
    }
    // On met à jour les informations de la vue
    $this->set('player', $player);
  }

  // Fonction de login
  public function login(){
    // On vérifie qu'il s'agit d'une requête POST
    if($this->request->is('post')){
      // On recherche l'utilisateur dans la base
      $players = $this->Players->find('all',[
        'conditions' => [
          'email'=>$this->request->data('email'),
          'password' => $this->request->data('password')
        ]
      ]);
      // Si au moins un résultat est trouvé
      if($players->count() != 0){
        // On récupère la première ligne du fetch
        $player = $players->first();
        // Puis on redirige vers la page de l'utilisateur
        return $this->redirect(['action' => 'view', $player->id]);
      }
      // Sinon, on indique l'erreur à l'utilisateur
      else {
        $this->Flash->error(__('Aucun compte avec ces identifiants n\'a été trouvé. Veuillez réessayer.'));
      }
    }
  }

  public function editPlayer(){
    $id = $this->request->data('playerid');
    $fighterId = $this->request->data('fighterid');

    if($id == null)
      return $this->redirect(['action' => 'index']);

    if($fighterId == null)
      return $this->redirect(['action' => 'view', $id]);
    else {
      if($this->request->is('post')){
        $f = $this->Players->Fighters->get($fighterId);
        $f -> setName($this->request->data('name'));
        $this->Players->Fighters->save($f);
      }
      return $this->redirect(['action' => 'view', $id]);
    }
  }
}

?>
