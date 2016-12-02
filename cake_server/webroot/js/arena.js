// Position de l'arène par rapport à la caméra
var xmin = -20;
var zmin = -20;
var xmax =  20;
var zmax =  20;
// Détail des textures du sol
var precision = {
    "w" : 2,
    "h" : 2
};
//Dimensions du plateau en nombre de cases
var subdivisions = {
    'h' : 20,
    'w' : 20
};

var blackTexture = "../webroot/img/assets/ground_texture_2.jpg";
var whiteTexture = "../webroot/img/assets/ground_texture.jpg";

Arena = function(game) {
    // Appel des variables nécéssaires
    var _this = this;
    this.game = game;
    var scene = game.scene;

    // Création de notre lumière principale
    var light = new BABYLON.HemisphericLight("light1", new BABYLON.Vector3(0, 1, 0), scene);

    // On crée des tuiles blanche et noire grâce à la fonction StandardMaterial de Babylon
    var whiteMaterial = new BABYLON.StandardMaterial("White", scene);
    whiteMaterial.diffuseTexture = new BABYLON.Texture(whiteTexture, scene);
    whiteMaterial.diffuseTexture.uScale = 4.0;
    whiteMaterial.diffuseTexture.vScale = 4.0;

    var blackMaterial = new BABYLON.StandardMaterial("Black", scene);
    blackMaterial.diffuseTexture = new BABYLON.Texture(blackTexture, scene);
    blackMaterial.diffuseTexture.uScale = 4.0;
    blackMaterial.diffuseTexture.vScale = 4.0;

    // On se sert de nos nouvelles textures pour créer une texture multiple
    var multimat = new BABYLON.MultiMaterial("multi", scene);
    multimat.subMaterials.push(whiteMaterial);
    multimat.subMaterials.push(blackMaterial);

    // Ajoutons un sol pour situer la sphere dans l'espace
    var ground = new BABYLON.Mesh.CreateTiledGround("Tiled Ground", xmin, zmin, xmax, zmax, subdivisions, precision, scene);

    ground.material = multimat;
    var verticesCount = ground.getTotalVertices();
    var tileIndicesLength = ground.getIndices().length / (subdivisions.w * subdivisions.h);

    ground.subMeshes = [];
    var base = 0;
    for (var row = 0; row < subdivisions.h; row++) {
        for (var col = 0; col < subdivisions.w; col++) {
             ground.subMeshes.push(new BABYLON.SubMesh(row%2 ^ col%2, 0, verticesCount, base, tileIndicesLength, ground));
             base += tileIndicesLength;
         }
    }
};
