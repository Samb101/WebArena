<?php

// src/Controller/GuildsController.php

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
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
      if($res->count()>0){
      $middleArray = (object) [
        "id" => $ownFighter->guild_id,
        "name" => $res->first()->name,
        "fighters" => (object)[]
      ];

      if($this->isInArray($guildsArray,$middleArray) == false)
        array_push($guildsArray, $middleArray);
    }}

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

  public function createGuild(){


    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));
    if($id == null)
      return $this->redirect(['action' => 'error',"Vous n\'êtes pas connecté(e)."]);

    if($this->request->is('post')){
      $guild_id = $this->request->data('name');
  //    $guild_id = $this->request->data('tabard');

      $guild = $this->Guilds->newEntity();
      $guild->name = $this->request->data('name');
      // On enregistre les modifications
      $this->Guilds->save($guild);

      $tabard_id = $this->request->data('add_portrait');
      $file = new File('../webroot/img/tabard_modele/guild_'.$tabard_id.'.png', true, 0777);

      if ($file->exists()) {
        $file->name = "guild_" . $guild->id . ".png";
          $dir = new Folder('../webroot/img/tabard_guilde/', true);
          $file->copy($dir->path . DS . $file->name, array('mode' => 0777, 'scheme' => Folder::OVERWRITE));
      }

      return $this->redirect(['action' => 'view']);
    }
    else {
      return $this->redirect(['action' => 'error',"La requête n\'est pas de type POST."]);
    }
  }



  public function removeGuild($guild_id = null){
    $id = $this->authenticateUserWithCookies($this->Cookie->read('email'),$this->Cookie->read('password'));

    if($id == null) return $this->redirect(['action' => 'error',"Vous n\'êtes pas connecté(e)."]);

    $this->loadModel('Fighters');

    $guild = $this->Guilds->get($guild_id);

    $players_orphelin = $this->Fighters->find("all", [
    'conditions' => [
      'guild_id' => $guild->id
    ]
    ]);

    $orph = $players_orphelin->toArray();

    if($this->Guilds->delete($guild)){
      foreach($orph as $orphelin){
          $orphelin->guild_id = null;
          $this->Fighters->save($orphelin);
      }
        $this->redirect(['action' => 'view']);
    }
    else {
      $this->redirect(['action' => 'error',"Impossible de supprimer le combattant."]);
    }
  }

}


?>
