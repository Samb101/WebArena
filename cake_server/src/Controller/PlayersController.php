<?php

// src/Controller/PlayersController.php

namespace App\Controller;

use Cake\Utility\Security;

class PlayersController extends AppController
{
  // On démarre les cookies
  var $components = array('Cookie');
  // Fonction d'initialisation du module
  public function initialize(){
    // On appelle le constructeur du parent AppController
    parent::initialize();
    // Puis on charge le composant Flash nous permettant l'affichage de messages à l'utilisateur
    $this->loadComponent('Flash');
  }

  // On redirige vers la connection si l'utilisateur n'est pas connecté
  public function index(){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($id == null)
      return $this->redirect(['action' => 'login']);
    else
      return $this->redirect(['action' => 'view']);
  }

  // Fonction de visualisation des paramètres du compte identifié par son id
  // Entrées : $id | null par défaut
  public function view(){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($id == null)
      return $this->redirect(['action' => 'login']);



    $others_fighters = $this->Players->Fighters->find("all",[
      'conditions' => [
        'player_id !=' => $id
      ],
      'limit' => 5,
      'order' => array('level DESC')
    ]);

    $fighters = $this->Players->Fighters->find("all",[
      'conditions' => [
        'player_id' => $id
      ]
    ]);


    $avg_guild =  $this->Players->Fighters->Guilds->find("all",[
      "fields"     => array("AVG(level) AS avg")
    ]);



    $guilds = $this->Players->Fighters->Guilds->find("all");
    $this->set('others_fighters',$others_fighters);
    $this->set('guilds',$guilds);
    $this->set('fighters',$fighters);
    $this->set('id',$id);
    $this->set('avg_guild',$avg_guild);

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
          return $this->redirect(['action' => 'login',"Compte créé. Vous pouvez maintenant vous connecter."]);
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
  public function edit(){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));
    if($id == null)
      return $this->redirect(['action' => 'login']);
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
  public function login($message = null){
    // On configure les cookies
    $this->Cookie->config('User', 'path', '/');
    $this->Cookie->configKey('User', [
        'expires' => '+10 days',
        'httpOnly' => true
    ]);

    if($message != null)
      $this->Flash->success(__($message));

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
        // On écrit les cookies
        $this->Cookie->write('email',$player->email);
        $this->Cookie->write('password',Security::encrypt($player->password,'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA'));
        // Puis on redirige vers la page de l'utilisateur
        return $this->redirect(['action' => 'view']);
      }
      // Sinon, on indique l'erreur à l'utilisateur
      else {
        $this->Flash->error(__('Aucun compte avec ces identifiants n\'a été trouvé. Veuillez réessayer.'));
      }
    }
  }

  public function editFighter(){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));
    if($id == null)
      return $this->redirect(['action' => 'login']);

    $fighter_id = $this->request->data('fighterId');
    $guild_id = $this->request->data('guildId');

    if($fighter_id == null || $guild_id == null)
      return $this->redirect(['action' => 'view']);
    else {
      if($this->request->is('post')){
        $f = $this->Players->Fighters->get($fighter_id);
        if($f->player_id != $id)
          return $this->redirect(['action' => 'error',"Ce personnage ne vous appartient pas."]);

        $f -> setName($this->request->data('name'));
        $f -> setGuild($this->request->data('guildId'));
        $this->Players->Fighters->save($f);
      }
      return $this->redirect(['action' => 'view']);
    }
  }

  public function createFighter(){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));
    if($id == null)
      return $this->redirect(['action' => 'error',"Vous n\'êtes pas connecté(e)."]);

    if($this->request->is('post')){
      $fighter = $this->Players->Fighters->newEntity();
      $this->Players->Fighters->patchEntity($fighter, $this->request->data);
      $fighter->initParametersToNull();
      $fighter->player_id = $id;
      // On enregistre les modifications
      $this->Players->Fighters->save($fighter);
      return $this->redirect(['action' => 'view']);
    }
    else {
      return $this->redirect(['action' => 'error',"La requête n\'est pas de type POST."]);
    }
  }

  public function removeFighter($fighter_id = null){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));
    if($id == null)
      return $this->redirect(['action' => 'error',"Vous n\'êtes pas connecté(e)."]);

    $fighter = $this->Players->Fighters->get($fighter_id);

    if($fighter->player_id != $id)
      return $this->redirect(['action' => 'error',"Ce personnage ne vous appartient pas."]);

    if($this->Players->Fighters->delete($fighter)){
        $this->redirect(['action' => 'view']);
    }
    else {
      $this->redirect(['action' => 'error',"Impossible de supprimer le combattant."]);
    }
  }

  public function error($error = null){
    if($error ==  null)
      $error = "Nous ne sommes pas en mesure d'identifier l'erreur.";

    $this->set('error',$error);

    $this->set('link','view');
  }

  public function authenticateUserWithCookies($email = null,$password = null){
    if($email == null || $password == null)
      return null;

    $password = Security::decrypt($password,'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA');

    $players = $this->Players->find('all',[
      'conditions' => [
        'email'=>$email,
        'password'=>$password
      ]
    ]);
    if($players->count() != 0){
      $player = $players->first();
      return $player->id;
    }
    else {
      return null;
    }
  }

  public function play(){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));
    $fighters = $this->Players->Fighters->find("all",[
      'conditions' => [
        'player_id' => $id
      ]
    ]);

    $this->set('fighters',$fighters);

    if($fighters->count() != 0){
      $fighter = $fighters->first();
      $current_health = $fighter->current_health;
      $health = $fighter->skill_health;
      $sight = $fighter->skill_sight;
      $strength = $fighter->skill_strength;
      $id = $fighter->id;
      $posX = $fighter->coordinate_x;
      $posY = $fighter->coordinate_y;
      $xp = $fighter->xp;
      $level = $fighter->level;
      $name=$fighter->name;
    }
    else {
      $health = 0;
      $sight = 0;
      $strenght = 0;
      $posX = 0;
      $posY = 0;
    }
    $this->set('health',$health);
    $this->set('sight',$sight);
    $this->set('strength',$strength);
    $this->set('current_health',$current_health);
    $this->set('id',$id);
    $this->set('posX',$posX);
    $this->set('posY',$posY);
    $this->set('xp',$xp);
    $this->set('level',$level);
    $this->set('name',$name);
  }

  public function addEventWithMessage(){

    date_default_timezone_set('UTC');

    $this->autoRender = false;
    $this->loadModel("Events");

    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($this->request->is('post')){

      $fighterId = $this->request->data("id");

      $fighters = $this->Players->Fighters->find("all",[
        'conditions' => [
          'id' => $fighterId,
          'player_id' => $id
        ]
      ]);

      if($fighters->count() != 0){
        $event = $this->Events->newEntity();
        $event->name = $this->request->data("message").$this->request->data("id");
        $event->date = date('Y-m-d H-i-s');
        $event->coordinate_y = $this->request->data("y");
        $event->coordinate_x = $this->request->data("x");
        $this->Events->save($event);
        $this->response->body(json_encode(array(
        'success' => 1,
        'message' => 'Ok.'
        )));

        $this->response->send();
      }
      else {
        $this->response->body(json_encode(array(
        'success' => 0,
        'message' => 'You are not allowed to perform the operation.'
        )));

        $this->response->send();
      }
    }
  }

  public function getFighterInformations(){
    $this->autoRender = false;

    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($id == null){
      sendErrorMessage($this->response);
      return;
    }

    if($this->request->is('post')){
      $fighterID = $this->request->data("id");

      $fighters = $this->Players->Fighters->find("all",[
        "conditions" => [
          "id" => $fighterID
        ]
      ]);

      if($fighters->count()>0){
        $fighter = $fighters->first();
          //      $name=$fighter->name;
        $current_health = $fighter->current_health;
        $skill_sight = $fighter->skill_sight;
        $skill_health = $fighter->skill_health;
        $skill_strength = $fighter->skill_strength;
        $xp = $fighter->xp;

        $this->response->type('json');

        $this->response->body(json_encode(array(
          'current_health' => $current_health,
          'skill_sight' => $skill_sight,
          'skill_health' => $skill_health,
          'skill_strength' => $skill_strength,
          'xp' => $xp,
          'success' => 1
        )));

        $this->response->send();
        die();
        return;
      }
      else {
        sendErrorMessage($this->response);
        return;
      }
    }
    else {
      sendErrorMessage($this->response);
      return;
    }
  }

  public function lossOfLifePoints(){
    $this->autoRender = false;

    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($id == null){
      sendErrorMessage($this->response);
      return;
    }

    if($this->request->is('post')){
      $fighterID = $this->request->data("id");
      $level = $this->request->data("level");
      $loss = $this->request->data("loss");

      $fighters = $this->Players->Fighters->find("all",[
        "conditions" => [
          "id" => $fighterID
        ]
      ]);

      if($fighters->count()>0){

        $fighter = $fighters->first();

        $threshold = (rand(0,20)>10+$fighter->level-$level) ? true : false;

        if($threshold)
          $current_health = $fighter->current_health-$loss;
        else
          $current_health = $fighter->current_health;

        $fighter->__set('current_health',$current_health);
        $this->Players->Fighters->save($fighter);

        if($current_health<=0){
          $this->Players->Fighters->delete($fighter);
          $this->response->body(json_encode(array(
            'success' => 1,
            'message' => 'OK.',
            'over' => true,
            'got' => $threshold
          )));
        }
        else {
          $this->response->body(json_encode(array(
            'success' => 1,
            'message' => 'OK.',
            'over' => false,
            'got' => $threshold
          )));
        }

        $this->response->send();
        die();
        return;
      }
      else {
        sendErrorMessage($this->response);
        return;
      }
    }
    else {
      sendErrorMessage($this->response);
      return;
    }
  }

  public function updateFighterInformations(){
    $this->autoRender = false;

    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($id == null){
      sendErrorMessage($this->response);
      return;
    }

    if($this->request->is('post')){
      $current_health = $this->request->data("current_health");
      $coordinate_x = $this->request->data("coordinate_x");
      $coordinate_y = $this->request->data("coordinate_y");
      $fighterID = $this->request->data("id");

      $fighters = $this->Players->Fighters->find("all",[
        "conditions" => [
          "id" => $fighterID,
          "player_id" => $id
        ]
      ]);

      if($fighters->count()>0){
        $fighter = $fighters->first();
        $fighter->__set('current_health',$current_health);
        $fighter->__set('coordinate_x',$coordinate_x);
        $fighter->__set('coordinate_y',$coordinate_y);

        $this->Players->Fighters->save($fighter);

        $this->response->body(json_encode(array(
          'success' => 1,
          'message' => 'OK.'
        )));

        $this->response->send();
        die();
        return;
      }
      else {
        sendErrorMessage($this->response);
        return;
      }
    }
    else {
      sendErrorMessage($this->response);
      return;
    }

  }

  public function getFightersPosition(){

    date_default_timezone_set('UTC');

    $this->autoRender = false;
    $this->loadModel("Events");

    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($id == null){
      sendErrorMessage($this->response);
      return;
    }

    if($this->request->is('get')){

      $fighters = $this->Players->Fighters->find("all",[
        'conditions' => [
          'coordinate_x !=' => -21,
          'player_id !=' => $id
        ]
      ]);
      $this->response->charset('UTF-8');
      $this->response->type('JSON');
      $this->response->body(json_encode($fighters));
      $this->response->send();
      die();
      return;

    }
    else {
      sendErrorMessage($this->response);
      return;
    }
  }

}

function sendErrorMessage($response){
  $response->type('json');

  $response->body(json_encode(array(
  'success' => 0,
  'message' => 'Wrong request headers.'
  )));

  $response->send();
  die();
}
?>
