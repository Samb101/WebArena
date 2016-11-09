<?php

// src/Controller/GuildsController.php

namespace App\Controller;

use Cake\Utility\Security;

class GuildsController extends AppController
{
  // Adresse du login
  var $loginurl = "http://localhost:8888/players/";
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
      return $this->redirect($loginurl);
    else
      return $this->redirect(['action' => 'view']);
  }

  // Fonction de visualisation des informations des guildes associées aux combatants de l'utilisateur
  public function view(){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($id == null)
      return $this->redirect($loginurl);

    $guildsArray = $this->buildUserGuildsArray($id);
    $this->set('guilds',$guildsArray);

  }

  public function authenticateUserWithCookies($email = null,$password = null){
    if($email == null || $password == null)
      return null;

    $password = Security::decrypt($password,'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA');

    $players = $this->Guilds->Fighters->Players->find('all',[
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

  public function buildUserGuildsArray($id){
    $ownFightersArray = $this->Guilds->Fighters->find("all",[
      'conditions' => [
        'player_id' => $id
      ]
    ]);

    $guildsArray = array();

    foreach ($ownFightersArray as $ownFighter) {
      $res = $this->Guilds->find("all",[
        'conditions' => [
          'id' => $ownFighter->guild_id
        ],
        'fields' => [
          'name'
        ]
      ]);
      $middleArray = (object) [
        "id" => $ownFighter->guild_id,
        "name" => $res->first()->name,
        "fighters" => (object)[]
      ];

      if($this->isInArray($guildsArray,$middleArray) == false)
        array_push($guildsArray, $middleArray);
    }

    foreach ($guildsArray as $guild) {
      $res = $this->Guilds->Fighters->find("all",[
        'conditions' => [
          'guild_id' => $guild->id
        ]
      ]);
      $guild->fighters = $res;
    }

    return $guildsArray;
  }

  public function isInArray($tab,$el){
    foreach ($tab as $t) {
      if($t->id == $el->id)
        return true;
    }
    return false;
  }
}

?>
