<!DOCTYPE html>
<html>
<head>
	<title></title>
<style>
canvas {
    cursor: crosshair;
    border: 1px solid #000000;
}
</style>
</head>
<body>

	<canvas id="canvas" width="800" height="400"></canvas>
    <br>
	<input type="button" value="draw" onclick="use_tool('draw');" />
	<input type="button" value="erase" onclick="use_tool('erase');" />

    <button id="clear">Clear</button>
    <button id="save">Save</button>
	<div id="output"></div>

    <br><br>
    <hr>

    <img src="" id="imgsrc">

<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>

	<script>
		//Canvas
var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
//Variables
var canvasx = $(canvas).offset().left;
var canvasy = $(canvas).offset().top;
var last_mousex = last_mousey = 0;
var mousex = mousey = 0;
var mousedown = false;
var tooltype = 'draw';

//Mousedown
$(canvas).on('mousedown', function(e) {
    last_mousex = mousex = parseInt(e.clientX-canvasx);
	last_mousey = mousey = parseInt(e.clientY-canvasy);
    mousedown = true;
});

//Mouseup
$(canvas).on('mouseup', function(e) {
    mousedown = false;
});

//Mousemove
$(canvas).on('mousemove', function(e) {
    mousex = parseInt(e.clientX-canvasx);
    mousey = parseInt(e.clientY-canvasy);
    if(mousedown) {
        ctx.beginPath();
        if(tooltype=='draw') {
            ctx.globalCompositeOperation = 'source-over';
            ctx.strokeStyle = 'blue';
            ctx.lineWidth = 2;
        } else {
            ctx.globalCompositeOperation = 'destination-out';
            ctx.lineWidth = 100;
        }
        ctx.moveTo(last_mousex,last_mousey);
        ctx.lineTo(mousex,mousey);
        ctx.lineJoin = ctx.lineCap = 'round';
        ctx.stroke();
    }
    last_mousex = mousex;
    last_mousey = mousey;
    //Output
    $('#output').html('current: '+mousex+', '+mousey+'<br/>last: '+last_mousex+', '+last_mousey+'<br/>mousedown: '+mousedown);
});

//Use draw|erase
use_tool = function(tool) {
    tooltype = tool; //update
}

$('#clear').click(function () {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
});

$('#save').click(function() {
    var canvas = document.getElementById('canvas');
    var dataURL = canvas.toDataURL();
    console.log(dataURL);
    $('#imgsrc').attr('src', dataURL);
});


	</script>

</body>
</html>