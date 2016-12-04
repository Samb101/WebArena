var shotSize = 1;
var playerH = 5;
var playerWidth = 1;
var playR;
var fighters = [];
var onMove = false;
var playerTexture = "../webroot/img/assets/smiley_texture.jpeg";
var playerModel = "../webroot/img/assets/daftpunk.babylon";
var shotTexture = "../webroot/img/assets/fire.jpg";
var movingSpeed = 2;
var movingDelay = 10;
var shots = [];

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


function loadModels(scene,canvas,engine){
  BABYLON.SceneLoader.ImportMesh("king",assets_path,player_model,scene,function(meshes){
    var m = meshes[0];

    m.isVisible = false;
    m.scaling = new BABYLON.Vector3(0.05,0.05,0.05);

    PLAYER_MODEL = m;

    createPlayer();

    fetchFighters();

    addInteractionsListeners(scene);

    scene.camera = createCamera(scene,canvas);
    // Permet au jeu de tourner
    engine.runRenderLoop(function () {
        scene.render();
    });
  })
}

function fetchFighters(){
  $.get("http://localhost:8888/players/getFightersPosition",function(response){
    response = JSON.parse(response);

    for(var i=0; i<response.length; i++)
    {
      createFighter(response[i].coordinate_x,response[i].coordinate_y,response[i].id);
    }

    setInterval(function(){
      $.get("http://localhost:8888/players/getFightersPosition",function(response){
        updateFightersLocally(JSON.parse(response));
      });
      $.post("http://localhost:8888/players/getFighterInformations",{"id":document.getElementById('fighterID').innerText},function(response){
        var res = JSON.parse(response);
        var fighterInformations = {};
        fighterInformations.current_health = res.current_health;
        fighterInformations.level = res.level;
        fighterInformations.xp = res.xp;
        fighterInformations.skill_sight = res.skill_sight;
        fighterInformations.skill_health = res.skill_health;
        fighterInformations.skill_strength = res.skill_strength;
        updateFighterInformations(fighterInformations);
      })
    },300);
  });
}

function updateFighterInformations(fighterInformations){
  document.querySelector(".details:first-of-type > label").innerText = "Santé : "+fighterInformations.current_health+" / "+fighterInformations.skill_health;
  document.querySelector(".details:first-of-type > progress").value = fighterInformations.current_health;
  document.querySelector(".details:first-of-type > progress").max = fighterInformations.skill_health;
  document.querySelector(".details:nth-of-type(2) > label").innerText = "Vue : "+fighterInformations.skill_sight;
  document.querySelector(".details:nth-of-type(2) > progress").value = fighterInformations.skill_sight;
  document.querySelector(".details:nth-of-type(3) > label").innerText = "Force : "+fighterInformations.skill_strength;
  document.querySelector(".details:nth-of-type(3) > progress").value = fighterInformations.skill_strength;
  document.querySelector(".details:nth-of-type(4) > label").innerText = "XP : "+fighterInformations.xp;
  document.querySelector(".details:nth-of-type(4) > progress").value = fighterInformations.xp;
}

function updateFightersLocally(arr){
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

function createFighter(x,y,id){
  var fighter = PLAYER_MODEL.clone(PLAYER_MODEL.name);
  fighter.position = new BABYLON.Vector3(x,playerH/2,y);
  fighter.rotationQuaternion = null;
  fighter.rotation = new BABYLON.Vector3(0,-Math.PI,0);
  fighter.isVisible = true;
  fighter.id = id;
  fighters.push(fighter);
}

function createPlayer(){
  var posX = document.getElementById('posX').innerText;
  var posY = document.getElementById('posY').innerText;
  playR = PLAYER_MODEL.clone(PLAYER_MODEL.name);
  playR.position = new BABYLON.Vector3(parseInt(posX),playerH/2,parseInt(posY));
  playR.rotationQuaternion = null;
  playR.rotation = new BABYLON.Vector3(0,-Math.PI,0);
  playR.isVisible = true;
}

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

function addInteractionsListeners(scene){
  document.addEventListener("keypress", function(e){
    var char = String.fromCharCode(e.keyCode).toLowerCase();
    if (char == "z")
      smartMove();
    else if (char == "e")
			playR.rotation.y += (playR.rotation.y*180/Math.PI==-315)?playR.rotation.y:Math.PI/4;
    else if (char=="a")
      playR.rotation.y -= (playR.rotation.y*180/Math.PI==315)?-1*playR.rotation.y:Math.PI/4;
    else if (char == " ")
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

function smartMove(){
  var rotationY = playR.rotation.y;
  var cosR, sinR;

  cosR = getCos(rotationY);
  sinR = getSin(rotationY);

  if(playR.position.z-cosR*2*playerWidth<=zmax && playR.position.z-cosR*2*playerWidth>=zmin)
    playR.position.z -= cosR*2*playerWidth;
  if(playR.position.x-sinR*2*playerWidth<=xmax && playR.position.x-sinR*2*playerWidth>=xmin)
    playR.position.x -= sinR*2*playerWidth;

  sendFighterInformations();
}

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

  var myInterval = window.setInterval(function(){

    computeCollisions();

    var cosR = getCos(rotationY);
    var sinR = getSin(rotationY);

    if(shot.position.x+shotSize<xmax && shot.position.z+shotSize<zmax && shot.position.x>xmin && shot.position.z>zmin)
    {
      shot.position.z -= 2*shotSize*cosR;
      shot.position.x -= 2*shotSize*sinR;
    }
    else {
      clearInterval(myInterval);
      shot.dispose();
    }
  },100);
}

function computeCollisions(){
  for(var i=0; i<shots.length; i++)
    for(var j=0; j<fighters.length; j++)
      if(shots[i].isVisible == true && shots[i].position.x == fighters[j].position.x && shots[i].position.z == fighters[j].position.z && fighters[j].isVisible == true){
        shots[i].isVisible = false;
        shots.splice(i,1);
        lossOfLifePoints(fighters[j]);
      }
}

function lossOfLifePoints(f){
  var data = {
    'id' : f.id,
    'loss' : 1
  }
  $.post("http://localhost:8888/players/lossOfLifePoints",data,function(response){
    if(JSON.parse(response).over == true)
    {
      f.isVisible = false;
      fighters.splice(fighters.indexOf(f),1);
    }
  })
}

function sendFighterInformations(){
  var id = document.getElementById('fighterID').innerText;
  var current_health = document.getElementById('health').value;
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
// Thanks to Sedat Kilinc @ http://stackoverflow.com/questions/8050722/math-cosmath-pi-2-returns-6-123031769111886e-17-in-javascript-as3
// Définition de fonction sin et cos permettant l'arrondi du résultat nécessaire à cause de l'irrationnalité de PI et de
// la valeur inexacte fournie par défaut
Math.Sin = function(w){
    return parseFloat(Math.sin(w).toFixed(10));
};

Math.Cos = function(w){
    return parseFloat(Math.cos(w).toFixed(10));
};
