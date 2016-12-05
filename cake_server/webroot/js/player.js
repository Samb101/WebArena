var shotSize = 1;
var playerH = 5;
var playerWidth = 1;
var playR;
var fighters = [];
var obstacles = [];
var onMove = false;
var playerTexture = "../webroot/img/assets/smiley_texture.jpeg";
var playerModel = "../webroot/img/assets/daftpunk.babylon";
var shotTexture = "../webroot/img/assets/fire.jpg";
var woodTexture = "../webroot/img/assets/ground_texture_2.jpg";
var movingSpeed = 2;
var movingDelay = 10;
var shots = [];
var currentImprovements = 0;
var obstaclesHeight = 2;

var assets_path = "../img/assets/";
var player_model = "clinton-vs-trump-chess-set.babylon";
var PLAYER_MODEL;

Player = function(game, canvas, engine) {
    // La scène du jeu
    this.scene = game.scene;

    var _this = this;

    // Initialisation de la caméra
    loadModels(this.scene,canvas,engine);
};

// Fonction d'initialisation de la scene avec babylonjs
// Entrées :
// - scene : la scene créée dans game.js qui contient les éléments graphiques du jeu
// - canvas : le canvas dans lequel on dessine nos éléments
// - engine : le moteur chargé du traitement des informations et de l'injection dans le canvas
function loadModels(scene,canvas,engine){
  // On charge le mesh de notre personnage
  BABYLON.SceneLoader.ImportMesh("king",assets_path,player_model,scene,function(meshes){
    // On le stocke dans la variable mesh
    var m = meshes[0];

    // On rend le mesh invisible, nous nous en servirons pour réutiliser le modèle plus tard
    m.isVisible = false;
    // La taille étant trop importante on l'échelonne
    m.scaling = new BABYLON.Vector3(0.05,0.05,0.05);

    // On stocke notre modèle dans une variable globale
    PLAYER_MODEL = m;

    // On crée le joueur
    createPlayer();

    // On récupère les autres joueurs sur le plateau
    fetchFighters();

    // On ajoute les listeners des différentes interactions utilisateur
    addInteractionsListeners(scene);

    // On récupère les obstacles lus dans la base
    getObstacles(scene);

    // On ajoute une caméra à la scène
    scene.camera = createCamera(scene,canvas);

    // On fait tourner le moteur du jeu
    engine.runRenderLoop(function () {
        scene.render();
    });
  })
}

// Fonction de récupération des combattants du plateau
// On en profite aussi pour définir des intervals auxquels les informations des combattants
//  et du joueur seront synchronisées avec le serveur
//  Si la mise à jour des informations du joueur n'est plus possible, c'est qu'il est mort. On redirige alors vers l'accueil.
function fetchFighters(){
  $.get("http://localhost:8888/players/getFightersPosition",function(response){

    for(var i=0; i<response.length; i++)
    {
      createFighter(response[i].coordinate_x,response[i].coordinate_y,response[i].id);
    }

    setInterval(function(){
      $.get("http://localhost:8888/players/getFightersPosition",function(response){
        updateFightersLocally(response);
      });
      $.post("http://localhost:8888/players/getFighterInformations",{"id":document.getElementById('fighterID').innerText},function(response){
        if(response.success == 1){
          updateFighterInformations(response);
        }
        else {
          window.location = "http://localhost:8888/players/view";
        }
      })
    },300);
  });
}

// Fonction de mise à jour des informations du joueur
// Les valeurs obtenues sont injectées dans la vue
function updateFighterInformations(fighterInformations){
  document.querySelector("#pv-text").innerText = "PV : "+fighterInformations.current_health+" / "+fighterInformations.skill_health;
  document.querySelector("#pv-progress").value = fighterInformations.current_health;
  document.querySelector("#pv-progress").max = fighterInformations.skill_health;
  document.querySelector("#sight").innerText = fighterInformations.skill_sight;
  document.querySelector("#strength").innerText = fighterInformations.skill_strength;
  document.querySelector("#xp-text").innerText = "XP : "+fighterInformations.xp;
  document.querySelector("#xp-progress").value = fighterInformations.xp;
  document.querySelector("#level").innerText = "LVL "+fighterInformations.level;
}

// Fonction de mise à jour des joueurs présents sur le plateau
// Ils peuvent selon le cas être supprimés (si morts), déplacés, ou ajoutés si nouveaux arrivants
function updateFightersLocally(arr){
  for(var i=0; i<fighters.length; i++)
    if(shouldBeRemoved(arr,fighters[i].id)){
      fighters[i].isVisible = false;
      fighters.splice(i,1);
    }
  for(var i=0; i<arr.length; i++)
    for(var j=0; j<fighters.length; j++)
      if(arr[i].id == fighters[j].id){
        fighters[j].position = new BABYLON.Vector3(arr[i].coordinate_x,playerH/2,arr[i].coordinate_y);
        arr.splice(i,1);
      }
  for(var i=0; i<arr.length; i++){
    createFighter(arr[i].coordinate_x,arr[i].coordinate_y,arr[i].id);
  }
}

// Cette fonction vérifie si un attaquant devrait être retiré de la carte car mort
// Renvoit false si il est toujours vivant, true sinon
function shouldBeRemoved(arr,id){
  for(var i=0; i<arr.length; i++)
    if(arr[i].id == id)
      return false;
  return true;
}

// Fonction de création d'un nouveau combattant sur le plateau
// L'ensemble des combattants est stocké dans le tableau fighters, variable globale
function createFighter(x,y,id){
  var fighter = PLAYER_MODEL.clone(PLAYER_MODEL.name);
  fighter.position = new BABYLON.Vector3(x,playerH/2,y);
  fighter.rotationQuaternion = null;
  fighter.rotation = new BABYLON.Vector3(0,-Math.PI,0);
  fighter.isVisible = true;
  fighter.id = id;
  fighters.push(fighter);
}

// Fonction de création du joueur en place
function createPlayer(){
  var posX = document.getElementById('posX').innerText;
  var posY = document.getElementById('posY').innerText;
  playR = PLAYER_MODEL.clone(PLAYER_MODEL.name);
  playR.position = setRandomPosition();
  sendFighterInformations();
  playR.rotationQuaternion = null;
  playR.rotation = new BABYLON.Vector3(0,-Math.PI,0);
  playR.isVisible = true;
}

// Fonction de création de la caméra de la scène
// On place le focus sur le joueur également pour qu'elle soit en mesure de suivre le personnage
function createCamera(scene,canvas){
  var camera = new BABYLON.FollowCamera("FollowCam", new BABYLON.Vector3(0, 15, -45), scene);
  camera.target = playR;
  camera.radius = 10; // how far from the object to follow
  camera.heightOffset = 2; // how high above the object to place the camera
  camera.rotationOffset = 360; // the viewing angle
  camera.cameraAcceleration = 0.3; // how fast to move
  camera.maxCameraSpeed = 20; // speed limit
  return camera;
}

// Fonction d'ajout des listeners sur les interactions utilisateur expliquées sur la page d'accueil du site
function addInteractionsListeners(scene){
  document.addEventListener("keydown", function(e){
    var char = String.fromCharCode(e.keyCode).toLowerCase();
    if (char == "z")
      smartMove();
    else if (char == "e")
			playR.rotation.y += (playR.rotation.y*180/Math.PI==-315)?playR.rotation.y:Math.PI/4;
    else if (char=="a")
      playR.rotation.y -= (playR.rotation.y*180/Math.PI==315)?-1*playR.rotation.y:Math.PI/4;
    else if (char == "s")
      shoot(scene);
    else if (char == "o")
      scene.camera.radius-=2;
    else if (char == "i")
      scene.camera.radius+=2;
    else if (char == "l")
      scene.camera.rotationOffset-=10;
    else if (char == "k")
      scene.camera.rotationOffset+=10;
    else if (char == "p")
      scene.camera.heightOffset++;
    else if (char == "m" && scene.camera.heightOffset>1)
      scene.camera.heightOffset--;
  });
}

// Fonction de déplacement du personnage
// Nous nous servons de l'orientation du personnage et des sinus/cosinus de son angle de rotation pour déterminer la manière
// dont celui-ci doit avancer sur le plateau
// Nous exploitons aussi l'appel à cette fonction pour vérifier les collisions avec les obstacles et envoyer les nouvelles
// informations du combattant au serveur
function smartMove(){
  var rotationY = playR.rotation.y;
  var cosR, sinR;

  cosR = getCos(rotationY);
  sinR = getSin(rotationY);

  if(playR.position.z-cosR*2*playerWidth<=zmax && playR.position.z-cosR*2*playerWidth>=zmin && isAvailable(playR.position.x,playR.position.z-cosR*2*playerWidth))
    playR.position.z -= cosR*2*playerWidth;
  if(playR.position.x-sinR*2*playerWidth<=xmax && playR.position.x-sinR*2*playerWidth>=xmin && isAvailable(playR.position.x-sinR*2*playerWidth,playR.position.z))
    playR.position.x -= sinR*2*playerWidth;

  checkHiddenObstacles();

  sendFighterInformations();
}

// Arrondi des sinus et cosinus pour le déplacement intelligent
// Pas très intéressant
function getSin(rotationY){
  var sinR;

  if(Math.Sin(rotationY)==0)
    sinR = 0;
  else if(Math.Sin(rotationY)<0)
    sinR = -1;
  else if(Math.Sin(rotationY)>0)
    sinR = 1;

  return sinR
}

function getCos(rotationY){
  var cosR;

  if(Math.Cos(rotationY)==0)
    cosR = 0;
  else if(Math.Cos(rotationY)<0)
    cosR = -1;
  else if(Math.Cos(rotationY)>0)
    cosR = 1;

  return cosR;
}

// Thanks to Sedat Kilinc @ http://stackoverflow.com/questions/8050722/math-cosmath-pi-2-returns-6-123031769111886e-17-in-javascript-as3
// Définition de fonction sin et cos permettant l'arrondi du résultat nécessaire à cause de l'irrationnalité de PI et de
// la valeur inexacte fournie par défaut
Math.Sin = function(w){
    return parseFloat(Math.sin(w).toFixed(10));
};

Math.Cos = function(w){
    return parseFloat(Math.cos(w).toFixed(10));
};

// Fonction de vérification des collisions avec les obstacles invisibles
// En cas de collision, le joueur meurt
// En cas d'obstacle à proximité, on déclenche un avertissement visuel
function checkHiddenObstacles(x,y){
  for(var i=0; i<obstacles.length; i++)
  {
    if(obstacles[i].model.position.x==playR.position.x && obstacles[i].model.position.z==playR.position.z){
      if(obstacles[i].type == 2)
      {
        killplayer(parseInt(document.getElementById('fighterID').innerText));
        window.location = 'http://localhost:8888/players/view';
      }
      if(obstacles[i].type == 3)
      {
        killplayer(parseInt(document.getElementById('fighterID').innerText));
        window.location = 'http://localhost:8888/players/view';
      }
    }
    if(obstacles[i].model.position.x<=playR.position.x+playerWidth*2 && obstacles[i].model.position.x>=playR.position.x-playerWidth*2 && obstacles[i].model.position.z<=playR.position.z+playerWidth*2 && obstacles[i].model.position.z>=playR.position.z-playerWidth*2){
      if(obstacles[i].type == 2)
        createTextualInformation("../webroot/img/texts/brise.png");
      if(obstacles[i].type == 3)
        createTextualInformation("../webroot/img/texts/puanteur.png");
    }
  }
}

// Fonction d'exécution immédiate du joueur, en cas de collision avec un obstacle invisible
function killplayer(id){
  $.post("http://localhost:8888/players/kill",{'id':id},function(response){
    if(response.success==1)
      createTextualInformation("../webroot/img/texts/dead.png");
  })
}

// Fonction de récupération des obstables depuis la table Surroundings stockés dans la variable globale obstacles
// On crée également leurs modèles 3D avec comme propriété isVisible qui vaut true ou false en fonction du type
function getObstacles(scene){
  $.get('http://localhost:8888/players/getObstacles',function(response){
    obstacles = response;
    for(var i=0; i<obstacles.length; i++){
      if(obstacles[i].type == "1")
      {
        obstacles[i].type = 1;
        obstacles[i].model = createObstacle(obstacles[i].coordinate_x,obstacles[i].coordinate_y,scene,true);
      }
      if(obstacles[i].type == "2")
      {
        obstacles[i].type = 2;
        obstacles[i].model = createObstacle(obstacles[i].coordinate_x,obstacles[i].coordinate_y,scene,false);
      }
      if(obstacles[i].type == "3")
      {
        obstacles[i].type = 3;
        obstacles[i].model = createObstacle(obstacles[i].coordinate_x,obstacles[i].coordinate_y,scene,false);
      }
    }
  });
}

// Fonction de création d'un obstacle prenant en paramètre sa position initiale, la scène dans laquelle il évolue, et sa visibilité
// dépendant du type d'obstacle
function createObstacle(x,y,scene,isVisible){
  var box = BABYLON.Mesh.CreateBox("box", obstaclesHeight, scene);

  var woodMaterial = new BABYLON.StandardMaterial("wood",scene);
  woodMaterial.diffuseTexture = new BABYLON.Texture(woodTexture, scene);

  box.position = new BABYLON.Vector3(x,2*obstaclesHeight/2,y);
  box.material = woodMaterial;

  box.isVisible = isVisible;

  return box;
}

// Fonction de création d'un tir
// Un setInterval est également défini pour sa progression dans le temps. Celui-ci est borné par la compétence Vue du
// joueur
function shoot(scene){
  var startx = playR.position.x;
  var startz = playR.position.z;
  var rotationY = playR.rotation.y;
  var shot = BABYLON.Mesh.CreateSphere("shot", 16, shotSize/2, scene);
  // On crée la texture du tir
  var fireMaterial = new BABYLON.StandardMaterial("shot", scene);
  var fireTexture = new BABYLON.FireProceduralTexture("fire", 256, scene);
  fireMaterial.diffuseTexture = fireTexture;
  fireMaterial.opacityTexture = fireTexture;
  // On l'applique à notre Mesh
  shot.material = fireMaterial;
  shot.position = new BABYLON.Vector3(startx,shotSize,startz);

  shots.push(shot);

  var sight = parseInt(document.querySelector("#sight").innerText)+3;

  setIntervalX(function(){
    computeCollisions();

    var cosR = getCos(rotationY);
    var sinR = getSin(rotationY);

    if(shot.position.x+shotSize<xmax && shot.position.z+shotSize<zmax && shot.position.x>xmin && shot.position.z>zmin)
    {
      shot.position.z -= 2*shotSize*cosR;
      shot.position.x -= 2*shotSize*sinR;
    }

    return shot;
  },100,sight);
}

// Fonction de vérification des collisions entre les tirs et les combattants ainsi que les obstacles
// Suppression du tir en cas de collision avec les combattants et les obstacles de type 3
// Suppression des obstacles de type 3 en cas de collision également
function computeCollisions(){
  for(var i=0; i<shots.length; i++)
    for(var j=0; j<fighters.length; j++)
      if(shots[i].isVisible == true && shots[i].position.x == fighters[j].position.x && shots[i].position.z == fighters[j].position.z && fighters[j].isVisible == true){
        shots[i].isVisible = false;
        shots.splice(i,1);
        lossOfLifePoints(fighters[j]);
      }
  for(var i=0; i<shots.length; i++)
    for(var j=0; j<obstacles.length; j++)
      if(shots[i].isVisible == true && shots[i].position.x == obstacles[j].model.position.x && shots[i].position.z == obstacles[j].model.position.z && obstacles[j].model.isVisible == true){
        shots[i].isVisible = false;
        shots.splice(i,1);
        if(obstacles[j].type == "3")
          obstacles.splice(j,1);
      }
}

// Fonction de vérification de la disponibilité d'une case
function isAvailable(x,y){
  for(var i=0; i<obstacles.length; i++)
    if(obstacles[i].model.position.x==x && obstacles[i].model.position.z==y && obstacles[i].type==1)
      return false;
  for(var i=0; i<fighters.length; i++)
    if(fighters[i].position.x==x && fighters[i].position.z==y)
      return false;
  return true;
}

// Fonction de soustraction des points de vie lors d'une attaque
// Soustrait au joueur à l'identifiant id la valeur des points de combat du joueur à l'identifiant player
// La fonction crée également des informations textuelles relativement à l'attaque en fonction de la réponse du serveur
// Cette réponse indique aussi une montée de niveau, et la possibilité d'upgrade une compétence
// La capacité d'upgrade est aussi vérifiée côté serveur
function lossOfLifePoints(f){
  var data = {
    'id' : f.id,
    'loss' : 1,
    'player' : parseInt(document.getElementById('fighterID').innerText)
  }
  $.post("http://localhost:8888/players/lossOfLifePoints",data,function(response){
    if(response.over == true)
    {
      createTextualInformation("../webroot/img/texts/dead.png");
      f.isVisible = false;
      fighters.splice(fighters.indexOf(f),1);
    }
    else {
      if(response.got == false)
        createTextualInformation("../webroot/img/texts/missed.png");
      else
        createTextualInformation("../webroot/img/texts/gotcha.png");
    }
    if(response.levelup == true){
      currentImprovements++;
      document.getElementById('lvlup').style.display = 'block';
    }
  })
}

// Fonction d'upgrade d'une compétence
// On masque la pop up de montée de niveau à la réponse du serveur
function upgradeSkill(skill){
  var data = {
    'skill' : skill,
    'id' : parseInt(document.getElementById('fighterID').innerText)
  }
  $.post('http://localhost:8888/players/upgradeSkill',data,function(response){
    document.getElementById('lvlup').style.display = 'none';
  });
}

// Fonction de modification du tabard d'une guilde
// On envoit la valeur de la nouvelle image et de la guilde en question
function changeTabard(pictureId, guildId){
  var data = {
    'id' : pictureId,
    'guild_id' : guildId
  }
  $.post('http://localhost:8888/change-tabard',data,function(response){
    window.redirect('http://localhost:8888/guilds/view');
  });
}

// 
function createTextualInformation(path){
  var img = $('<img src="'+path+'" alt="info" class="textualInformation"/>');
  $('#arena_container').append(img);
  window.setTimeout(function(){
    img.remove();
  },1000);
}

function setNewPlayer(id){
  var oldId = document.getElementById('fighterID').innerText;

  $.post('http://localhost:8888/players/getPosition',{'id':id},function(response){
    playR.position = setRandomPosition();
    document.getElementById('fighterID').innerText = id;
  })
  disconnectPlayer(oldId);
}

function setRandomPosition(){
  var x,y;
  var set = false;
  while(!set){
    set=true;
    x = Math.floor((Math.random() * 2*xmax) + 1)-xmax;
    y = Math.floor((Math.random() * 2*zmax) + 1)-zmax;
    for(var i=0; i<fighters.length; i++)
      if(fighters[i].coordinate_x==x && fighters[i].coordinate_y==y)
        set=false;
      if(x%2==0 || y%2==0)
        set=false;
  }
  return new BABYLON.Vector3(x,playerH/2,y);
}

function sendFighterInformations(){
  var id = document.getElementById('fighterID').innerText;
  var current_health = document.getElementById('pv-text').value;
  var coordinate_x = playR.position.x;
  var coordinate_y = playR.position.z;
  var data = {
    "id" : id,
    "current_health" : current_health,
    "coordinate_x" : coordinate_x,
    "coordinate_y" : coordinate_y
  }
  $.post("http://localhost:8888/players/updateFighterInformations",data,function(response){
  });
}

function disconnectPlayer(id){
  var current_health = document.getElementById('pv-text').value;
  var coordinate_x = -21;
  var coordinate_y = -21;
  var data = {
    "id" : id,
    "current_health" : current_health,
    "coordinate_x" : coordinate_x,
    "coordinate_y" : coordinate_y
  }
  $.post("http://localhost:8888/players/updateFighterInformations",data,function(response){
  });
}

// Thanks to Daniel Vassallo http://stackoverflow.com/questions/2956966/javascript-telling-setinterval-to-only-fire-x-amount-of-times
function setIntervalX(callback, delay, repetitions) {
    var x = 0;
    var intervalID = window.setInterval(function () {

       var shot = callback();

       if (++x === repetitions) {
           window.clearInterval(intervalID);
           shot.dispose();
       }
    }, delay);
}
