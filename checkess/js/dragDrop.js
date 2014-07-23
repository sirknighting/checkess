var canvas; //this wll hold the canvas object
var imageObj;//This will hold an array of the class with the same name.
//var imageSources;//not used in current version.
var ctx;//stores the 2d context for canvas object.
var WIDTH = 720;//stores the width of the canvas
var HEIGHT = 680;//stores the width of the canvas
var mousePrevX;
var mousePrevY;
var lastPos;// holds co-ords from mousedown
var col = 'ABCDEFGH';//holds names for the columns
var serverString = '';// string to send to the server;
var req;
var inString;
function ImageObj(pic, x, y, width, height, dragOk) {//this class represents a
  //game piece
  this.pic = pic;
  this.y = y;
  this.x = x;
  this.lastPos = [x,y];
  this.height = height;
  this.width = width;
  this.dragOk = dragOk;
  this.insideClick = function(e, canvas){
//    info.innerHTML = this.x + ' ' + this.y + ' ' + e.pageX + ' ' +e.pageY;
    if (e.pageX < this.x + this.width + canvas.offsetLeft && e.pageX > this.x  +
     canvas.offsetLeft && e.pageY < this.y + this.height + canvas.offsetTop &&
     e.pageY > this.y+ canvas.offsetTop){
     return true;
    }
  return false;
  }
  this.sendBack = function(){
  this.x = this.lastPos[0];
  this.y = this.lastPos[1];
  }
  this.showType = function(){
  return this.pic.src.slice(-6,-4);
}
  this.getSpace = function(){
  return new Array(
  col[Math.floor((this.x-40)/80)],
  8-Math.floor(this.y/80)
);
  }
  this.getLastSpace = function(){
    return new Array(
    col[Math.floor((this.lastPos[0]-40)/80)],
    8-Math.floor(this.lastPos[1]/80)
);
  }
}

function clear() {//cleans out the play-space
 ctx.clearRect(0, 0, WIDTH, HEIGHT);
}

function init() {// initialises the required elements
  canvas = document.getElementById('myBoard');
  /*info = document.getElementById('info');
  imageInfo = document.getElementById('imageInfo');
  */ 
  ctx = canvas.getContext('2d');
  var path = 'Pieces/images/' ;
  imageObj = [];/*
  imageSources = [
    //list of chess piece icons
    'B.gif',
    'BB.gif',
    'BK.gif',
    'BN.gif',
    'BQ.gif',
    'BR.gif',
    'W.gif',
    'WB.gif',
    'WK.gif',
    'WN.gif',
    'WQ.gif',
    'WR.gif'
    ];*/
  for (i = 0; i < 8; i+=2) {
    pic = new Image();
    if(i<3) {pic.src=path+'BP.gif';}
    else if(i>4){pic.src=path+'WP.gif';}
    else{continue;}
    for (j=1;j<8;j+=2){ 
      imageObj.push(new ImageObj(pic, 40+j*80, 0+i*80, 80, 80, false));
  }
}
for (i = 1; i < 8; i+=2) {
  pic2 = new Image();
  if(i<3) {
  pic2.src=path+'BP.gif';
  }
  else if(i>4){
  pic2.src=path+'WP.gif';
  }
  else{continue;}
  for (j=0;j<8;j+=2){
    imageObj.push(new ImageObj(pic2, 40+j*80, 0+i*80, 80, 80, false));
  }
}
 drawBoard();
 return setInterval(draw, 10);
}
function drawBoard(){//draws the board for the background.
      ctx.fillStyle = 'black';
      ctx.fillRect(40,0,640,640);
      ctx.strokeRect(40,0,640,640);
      ctx.fillStyle = 'white';//through 106 paints white boxes
      for (i = 0; i < 8; i+=2) {
        for (j=0;j<8;j+=2){ 
          ctx.fillRect(40+80*j,0+80*i,80,80);
        }
      }
      for (i = 1; i < 8; i+=2) {
        for (j=1;j<8;j+=2){ 
          ctx.fillRect(40+80*j,0+80*i,80,80);
        }
      }
      ctx.fillStyle = 'black';//label board through
      ctx.font='20px Arial';
      for (i=0;i<8;i++ ){
        ctx.fillText((8-i).toString(),20,40+i*80);
        ctx.fillText((8-i).toString(),690,40+i*80);
        ctx.fillText(col[i],80+80*i,665);
      }       
}
function draw() {//redraws Client canvas
 clear();
 drawBoard();
 for(var i = imageObj.length -1; i >= 0; i--){
   ctx.drawImage(imageObj[i].pic, imageObj[i].x, imageObj[i].y);
 }
}

function myMove(e){//Drag function
 for(var i = 0; i < imageObj.length; i++){
  if (imageObj[i].dragOk){
   imageObj[i].x = imageObj[i].x - (mousePrevX - e.pageX);
   imageObj[i].y = imageObj[i].y - (mousePrevY - e.pageY);
   mousePrevX = e.pageX;
   mousePrevY = e.pageY;
  }
 }
}

function myDown(e){//when mouse is clicked in canvas
  for(var i = 0; i < imageObj.length; i++){
    if (imageObj[i].insideClick(e, canvas)){//look for a piece under mouse,
      mousePrevX = e.pageX;
      mousePrevY = e.pageY;
      imageObj[i].lastPos = [imageObj[i].x,imageObj[i].y]; //record position,
      imageObj[i].dragOk = true;//Enable dragging
      imageObj[i].x=e.pageX-imageObj[i].width/2-canvas.offsetLeft;
      imageObj[i].y=e.pageY-imageObj[i].height/2-canvas.offsetTop;
      canvas.onmousemove = myMove;
    }
   }
}

function myUp(){//when mouse button is released in canvas, snap to nearest box.
    canvas.onmousemove = null;
  for(var i = 0; i < imageObj.length; i++){
    if (imageObj[i].dragOk){
      snapTo(imageObj[i]);
      imageObj[i].dragOk = false;
      sendMoveToServer(
        imageObj[i].getLastSpace().join('').toString()
        +
        imageObj[i].getSpace().join('').toString(), i
      )
    }
  }
}

function myDoubleClick(e){//Print piece description and position to page.
  for(var i = 0; i < imageObj.length; i++){
    if (imageObj[i].insideClick(e, canvas)){
      var space = imageObj[i].getSpace();
    document.getElementById('jsDump').innerHTML +=
    imageObj[i].showType() +' '+ space[0]+space[1]+'<br></br>';
    }
  }
}

function snapTo(image) {//Snaps a piece to the nearest box.
  if(image.x>=0 & image.x<680 & image.y>= 0 & image.y<= 640){ 
  var xCenter = image.x + image.width/2;
  var yCenter = image.y + image.height/2;
  var newX = Math.round((image.x-40)/80)*80+40;
  var newY = Math.round(image.y/80)*80;
  image.x = newX;
  image.y = newY;
  /*document.getElementById('jsDump').innerHTML +=
  '<br></br>'+ newX.toString()+ ' '+newY.toString(); would print new co-ords */
    if(
      (image.pic.src.substr(-6,1)=='W' 
      & 
      image.getSpace()[1]==8)
      | 
      (image.pic.src.substr(-6,1)=='B' & image.getSpace()[1]==0)
){
    promote(image);
    }
}
  else{//or returns to previous box
    image.sendBack();
  }
}
function sendMoveToServer(move, i){
  print(move+' was sent to server');
  /*
  for(var i = 0; i < imageObj.length; i++){
    serverString+=imageObj[i].showType()+imageObj[i].getSpace().join('');
    }
  */
   serverString=move;
   var myReq = getRequest(
       'board.php', // URL for the PHP file
       move,
       drawOutput,  // handle successful request
       drawError,
       i	   // handle error
  ); 
}  
// handles drawing an error message
function drawError () {
    print('No server response');
}
// handles the response, adds the html
function drawOutput(responseText,i) {
  var bob = "TRUE";
  print('Server response: '+ responseText);
  if(responseText.indexOf("TRUE") == -1){
  imageObj[i].sendBack();
 print('line 237 in drawOutput');}
}
// helper function for cross-browser request object
function getRequest(url,move, success, error, i) {
    req = false;
    try{
        // most browsers
        req = new XMLHttpRequest();
    } catch (e){
        // IE
        try{
            req = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
            // try an older version
            try{
                req = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (e){
                return false;
            }
        }
    }
    if (!req) return false;
    if (typeof success != 'function') success = function () {};
    if (typeof error!= 'function') error = function () {};
    req.onreadystatechange = function(){
        if(req .readyState == 4){
            return req.status === 200 ? 
                success(req.responseText,i) : error(req.status)
            ;
        }
    }
    req.open('POST', url, true);
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    req.send('fsend='+move);
    return req;
}
function promote(image){
//code to promote a checkers pawn
//could be adapted to pawns reaching end of board
image.pic.src=image.pic.src.replace('P','C');
}
function print(s){
  document.getElementById('jsDump').innerHTML += s +'<br></br>';
  
}
init();//runs initializing function
//next three lines assign mouse events within canvas to appropriate functions.
canvas.onmousedown = myDown;
canvas.onmouseup = myUp;
canvas.ondblclick = myDoubleClick;
document.getElementById('jsDump').innerHTML += serverString;