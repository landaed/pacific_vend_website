// Create the Babylon.js engine

var canvas = document.getElementById("renderCanvas");
const engine = new BABYLON.Engine(canvas, true, { preserveDrawingBuffer: true, stencil: true, alpha: true });

// scene.js
// ... your existing Babylon.js setup ...



// ... rest of your Babylon.js code ...

// Create the scene
const scene = new BABYLON.Scene(engine);

scene.clearColor = new BABYLON.Color4(0, 0, 0, 0);

var camera = new BABYLON.ArcRotateCamera("camera1", 0, 0, 0, new BABYLON.Vector3(0, -7, 20), scene);
camera.alpha = 3.14159/2;
camera.beta = 3.14159/1.5;
//const light2 = new BABYLON.HemisphericLight("HemiLight", new BABYLON.Vector3(0, 1, 0), scene);

var canvasWidth = engine.getRenderWidth();
/*
BABYLON.SceneLoader.ImportMesh("","./assets/models/", "arcade_machine_final.glb", scene, function (newMeshes) {
  newMeshes[0].position.x = 0;
  newMeshes[0].position.y = 0;
  newMeshes[0].position.z = 0;

});*/
// Add a shaft to the scene
var shaft = BABYLON.MeshBuilder.CreateCylinder("shaft", {height: 3, diameter: 1}, scene);

shaft.rotation.x= 3.14159/2;
shaft.position = new BABYLON.Vector3(0, 1, 0); // Adjust position as needed
var cylinderMaterial = new BABYLON.StandardMaterial("cylinderMat", scene);
cylinderMaterial.emissiveColor = new BABYLON.Color3(.5,.5,.5); // Red emissive color
shaft.material = cylinderMaterial; // Assign the material to the shaft
shaft.setPivotPoint(new BABYLON.Vector3(0, -1, 0));
// Add a handle to the scene
var handle = BABYLON.MeshBuilder.CreateSphere("handle", {diameter: 2}, scene);
handle.parent = shaft; // Make the handle a child of the shaft
handle.position = new BABYLON.Vector3(0, 1, 0); // Adjust position as needed
var sphereMaterial = new BABYLON.StandardMaterial("sphereMat", scene);
sphereMaterial.emissiveColor = new BABYLON.Color3(1, 0, 0); // Blue emissive color
handle.material = sphereMaterial; // Assign the material to the handle


var base = BABYLON.MeshBuilder.CreateBox("base", {width: 6, height: 3, depth: 1}, scene);
base.position = new BABYLON.Vector3(0, -3, 5); // Adjust position as needed
shaft.parent= base;

if(canvasWidth < 500){
  base.scaling.x=.5;
  base.scaling.y=.5;
}

// Create an emissive material for the base
var cubeMaterial = new BABYLON.StandardMaterial("cubeMat", scene);
cubeMaterial.emissiveColor = new BABYLON.Color3(.1,.1,.1); // Green emissive color
base.material = cubeMaterial; // Assign the material to the base

// Create a box to represent the about_us_btn
var about_us_btn = BABYLON.MeshBuilder.CreateBox("about_us_btn", {width: 2, height: 2, depth: .1}, scene);
about_us_btn.position = new BABYLON.Vector3(7, -1, 0); // Adjust position as needed

// Create a material for the about_us_btn
var buttonMaterial = new BABYLON.StandardMaterial("buttonMat", scene);
buttonMaterial.emissiveColor = new BABYLON.Color3(0, 1, 0); // Choose a distinctive color
about_us_btn.material = buttonMaterial; // Assign the material to the about_us_btn

// Function to change about_us_btn color on click
about_us_btn.actionManager = new BABYLON.ActionManager(scene);
about_us_btn.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
    about_us_btn.material.emissiveColor = new BABYLON.Color3(1, 0, 0); // Change to a different color on click
}));


var game_for_sale_btn = BABYLON.MeshBuilder.CreateBox("about_us_btn", {width: 2, height: 2, depth: .1}, scene);
game_for_sale_btn.position = new BABYLON.Vector3(7, -1, 0); // Adjust position as needed

// Create a material for the about_us_btn
var game_for_sale_btn_Material = new BABYLON.StandardMaterial("game_for_sale_btn_Material", scene);
buttonMaterial.emissiveColor = new BABYLON.Color3(0, 1, 0); // Choose a distinctive color
game_for_sale_btn.material = buttonMaterial; // Assign the material to the about_us_btn

// Function to change about_us_btn color on click
game_for_sale_btn.actionManager = new BABYLON.ActionManager(scene);
game_for_sale_btn.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
    game_for_sale_btn.material.emissiveColor = new BABYLON.Color3(1, 0, 0); // Change to a different color on click
}));

// Initial setup for the line (invisible at first)
var linePoints = [shaft.position, about_us_btn.position]; // Starts and ends at the handle
var line = BABYLON.MeshBuilder.CreateLines("line", {points: linePoints}, scene);
line.visibility = 0; // Make line invisible initially

// Update function for line visibility and position
function updateLineVisibility(isVisible, endPoint) {
    if (isVisible) {
        linePoints[1] = endPoint; // Set the end point to the about_us_btn's position
        line = BABYLON.MeshBuilder.CreateLines("line", {points: linePoints, instance: line}, scene);
        line.visibility = 1; // Make line visible
    } else {
        line.visibility = 0; // Hide the line
    }
}

// Modify pointer move event to handle line visibility
canvas.addEventListener("pointermove", function(evt) {
    var pickResult = scene.pick(scene.pointerX, scene.pointerY);
    if (pickResult.hit && pickResult.pickedMesh === about_us_btn) {
        // Mouse is over the about_us_btn
        about_us_btn.material.emissiveColor = new BABYLON.Color3(1, 1, 0); // Change color to indicate hover
        updateLineVisibility(true, about_us_btn.position); // Show the line to the about_us_btn
    } else {
        // Mouse is not over the about_us_btn
        about_us_btn.material.emissiveColor = new BABYLON.Color3(0, 1, 0); // Reset color
        updateLineVisibility(false); // Hide the line
    }
});


// Parent-Child Relationship
//shaft.parent = base; // Make the shaft a child of the base


// Function to update joystick rotation
// Function to update joystick rotation considering the origin
function updateJoystickRotation(event) {
    var rect = canvas.getBoundingClientRect();
    var mouseX = event.clientX - rect.left;
    var mouseY = event.clientY - rect.top;

    // Get the world position of the joystick's origin
    var joystickOrigin = shaft.getAbsolutePosition();

    // Convert the joystick origin to canvas coordinates
    var joystickOriginScreen = BABYLON.Vector3.Project(
        joystickOrigin,
        BABYLON.Matrix.IdentityReadOnly,
        scene.getTransformMatrix(),
        camera.viewport.toGlobal(engine.getRenderWidth(), engine.getRenderHeight())
    );

    // Calculate the relative position of the mouse to the joystick origin
    var relativeMouseX = mouseX - joystickOriginScreen.x;
    var relativeMouseY = mouseY - joystickOriginScreen.y;

    // Normalize these coordinates
    var normalizedMouseX = relativeMouseX / canvasWidth;
    var normalizedMouseY = relativeMouseY / canvas.height;

    // Calculate the angle with normalization
    var angleX = BABYLON.Tools.ToRadians(-135 + Math.min(Math.max(-normalizedMouseY * 90, -45), 45));
    var angleY = BABYLON.Tools.ToRadians(Math.min(Math.max(normalizedMouseX * 90, -45), 45));

    // Update the rotation of the joystick shaft
    shaft.rotation.x = -angleX;
    shaft.rotation.y = -angleY;
}

// Add event listener for mouse movement
canvas.addEventListener("mousemove", updateJoystickRotation);

engine.runRenderLoop(function () {
    scene.render();
});


// Resize the canvas when the window is resized
window.addEventListener("resize", function () {
    updateSceneForCanvasSize();
    engine.resize();
});

function updateSceneForCanvasSize() {
  canvasWidth = engine.getRenderWidth();
  if(canvasWidth < 500){
    base.scaling.x=.5;
    base.scaling.y=.5;
  }
  else{
    base.scaling.x=1;
    base.scaling.y=1;
  }

  // Now, use the worldLeft x-coordinate to position your objects

}
// Resize the canvas when the window is resized
function handleResize() {


    engine.resize();
    updateSceneForCanvasSize();
}

// Handle window resize
window.addEventListener("resize", handleResize);

// Handle fullscreen change
document.addEventListener("fullscreenchange", handleResize);
