var shotSize = 1;
var playerH = 1;
var playR;
var onMove = false;
var playerTexture = "../webroot/img/assets/smiley_texture.jpeg";
var shotTexture = "../webroot/img/assets/fire.jpg";
var movingSpeed = 2;
var movingDelay = 10;

Player = function(game, canvas) {
    // La scène du jeu
    this.scene = game.scene;

    // Initialisation de la caméra
    this._createPlayer(this.scene);
    this._addInteractionsListeners(this,this.scene);
    this._initCamera(this.scene, canvas);
};

Player.prototype = {
    _initCamera : function(scene, canvas) {
        // On crée la caméra
        //this.camera = new BABYLON.FreeCamera("camera", new BABYLON.Vector3(0, 5, -10), scene);
        this.camera = new BABYLON.FollowCamera("FollowCam", new BABYLON.Vector3(0, 15, -45), scene);
        this.camera.target = playR;
        this.camera.radius = 10; // how far from the object to follow
        this.camera.heightOffset = 2; // how high above the object to place the camera
        this.camera.rotationOffset = 90+180; // the viewing angle
        this.camera.cameraAcceleration = 0.3; // how fast to move
        this.camera.maxCameraSpeed = 20; // speed limit
        scene.activeCamera = this.camera;
    },
    _createPlayer : function(scene) {
      // Créons un joueur
      playR = BABYLON.Mesh.CreateBox("player", playerH, scene);
      // On crée la texture du smiley
      var smileyMaterial = new BABYLON.StandardMaterial("Smiley", scene);
      smileyMaterial.diffuseTexture = new BABYLON.Texture(playerTexture, scene);
      smileyMaterial.diffuseTexture.uScale = 1.0;
      smileyMaterial.diffuseTexture.vScale = 1.0;
      // On l'applique à notre Mesh
      playR.material = smileyMaterial;
      // Remontons le sur l'axe y de la moitié de sa hauteur
      playR.position = new BABYLON.Vector3(xmin+playerH,playerH/2,zmin+playerH);
    },
    _addInteractionsListeners : function(_this,scene) {
      document.addEventListener("keypress", function(e){
        var char = String.fromCharCode(e.keyCode).toLowerCase();

        if (char == "z")
          smartMove();
        else if (char == "e")
          playR.rotation.y += (playR.rotation.y*180/Math.PI==-315)?playR.rotation.y:Math.PI/4;
        else if (char=="a")
          playR.rotation.y -= (playR.rotation.y*180/Math.PI==315)?-1*playR.rotation.y:Math.PI/4;
        else if (char == " ")
          _this.shoot(scene);
        else if (char == "o")
          _this.camera.radius-=2;
        else if (char == "i")
          _this.camera.radius+=2;
        else if (char == "l")
          _this.camera.rotationOffset-=10;
        else if (char == "k")
          _this.camera.rotationOffset+=10;
        else if (char == "p")
          _this.camera.heightOffset++;
        else if (char == "m" && _this.camera.heightOffset>1)
          _this.camera.heightOffset--;

      });
    },
    shoot : function(scene) {
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
};

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
// Thanks to Sedat Kilinc @ http://stackoverflow.com/questions/8050722/math-cosmath-pi-2-returns-6-123031769111886e-17-in-javascript-as3
// Définission de fonction sin et cos permettant l'arrondi du résultat nécessaire à cause de l'irrationnalité de PI et de
// la valeur inexacte fournie par défaut
Math.Sin = function(w){
    return parseFloat(Math.sin(w).toFixed(10));
};

Math.Cos = function(w){
    return parseFloat(Math.cos(w).toFixed(10));
};
