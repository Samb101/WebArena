var shotSize = 1;
var playerH = 1;
var playR;
var onMove = false;
var playerTexture = "../webroot/img/assets/smiley_texture.jpeg";
var playerModel = "../webroot/img/assets/daftpunk.babylon";
var shotTexture = "../webroot/img/assets/fire.jpg";
var movingSpeed = 2;
var movingDelay = 10;

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
    addInteractionsListeners(scene);
    scene.camera = createCamera(scene,canvas);
    // Permet au jeu de tourner
    engine.runRenderLoop(function () {
        scene.render();
    });
  })
}

function createPlayer(){
  playR = PLAYER_MODEL.clone(PLAYER_MODEL.name);
  playR.position = new BABYLON.Vector3(2,3,2);
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

function addInteractionsListeners(){
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
    else if (char == "m" && _this.camera.heightOffset>1)
      scene.camera.heightOffset--;

  });
}

function smartMove(){
  var rotationY = playR.rotation.y;
  var cosR, sinR;

  if(Math.Cos(rotationY)==0)
    cosR = 0;
  else if(Math.Cos(rotationY)<0)
    cosR = -1;
  else if(Math.Cos(rotationY)>0)
    cosR = 1;

  if(Math.Sin(rotationY)==0)
    sinR = 0;
  else if(Math.Sin(rotationY)<0)
    sinR = -1;
  else if(Math.Sin(rotationY)>0)
    sinR = 1;

  if(playR.position.x+cosR*2*playerH<=xmax && playR.position.x+cosR*2*playerH>=xmin)
    playR.position.x += cosR*2*playerH;
  if(playR.position.z-sinR*2*playerH<=zmax && playR.position.z-sinR*2*playerH>=zmin)
    playR.position.z -= sinR*2*playerH;
}

function shoot(){
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
  var myInterval = window.setInterval(function(){
    if(shot.position.x+shotSize<xmax && shot.position.z+shotSize<zmax && shot.position.x>xmin && shot.position.z>zmin)
    {
      shot.position.z -= 2*shotSize*Math.Sin(rotationY);
      shot.position.x += 2*shotSize*Math.Cos(rotationY);
    }
    else {
      clearInterval(myInterval);
      shot.dispose();
    }
  },100);
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
