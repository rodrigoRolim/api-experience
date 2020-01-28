var stype=0;
var gUM=false;
var localstream
var vidhtml = '<h5>Posicione o QR Code em frente a Câmera</h5><video id="v" autoplay></video>';

function isCanvasSupported(){
  var elem = document.createElement('canvas');
  return !!(elem.getContext && elem.getContext('2d'));
}
function success(stream) {
    localstream = stream
    let video = document.getElementById('v');
    video.srcObject = stream; //window.URL.createObjectURL(stream);
    on_camera()
}
function on_camera() {
    document.getElementById('v').srcObject = localstream
    document.getElementById('v').play();
    gUM=true;
    setTimeout(captureToCanvas, 500);
}
function off_camera() {
    let play = document.getElementById('v').play()
    let stream = document.getElementById('v').srcObject;
    let tracks = stream.getTracks();
    if (play !== undefined) {
        play.then(_=> {
            tracks.forEach(function (track) {
                track.stop();
            })
            document.getElementById('v').srcObject = null
        })
        .catch((err) => {
            console.log(err)
        })
        
    }
   
}        
function error(error) {
    gUM=false;
    return;
}

function initCanvas(w,h)
{
    gCanvas = document.getElementById("qr-canvas");
    gCanvas.style.width = w + "px";
    gCanvas.style.height = h + "px";
    gCanvas.width = w;
    gCanvas.height = h;
    gCtx = gCanvas.getContext("2d");
    gCtx.clearRect(0, 0, w, h);
}

function read(text)
{
    if(text != ''){
        $('#id').val(text);
        $('#formAutoAtendimento').submit();
    }
}   

function setwebcam()
{

    var n=navigator;
    document.getElementById("outdiv").innerHTML = vidhtml;
    v=document.getElementById("v");

    if(n.getUserMedia)
        n.getUserMedia({video: true, audio: false}, success, error);
    else
    if(n.mediaDevices.getUserMedia)
        n.mediaDevices.getUserMedia({video: { facingMode: "environment"} , audio: false})
            .then(success)
            .catch(error);
    else
    if(n.webkitGetUserMedia)
    {
        webkit=true;
        n.webkitGetUserMedia({video:true, audio: false}, success, error);
    }
    else
    if(n.mozGetUserMedia)
    {
        moz=true;
        n.mozGetUserMedia({video: true, audio: false}, success, error);
    }

    stype=1;
    setTimeout(captureToCanvas, 500);
}

function captureToCanvas() {
    if(stype!=1)
        return;
    if(gUM)
    {
        try{
            gCtx.drawImage(v,0,0);
            try{
                qrcode.decode();
            }
            catch(e){       
                setTimeout(captureToCanvas, 500);
            };
        }
        catch(e){       
                setTimeout(captureToCanvas, 500);
        };
    }
}

function load()
{
    if(isCanvasSupported() && window.File && window.FileReader)
    {
        initCanvas(500, 500);
        qrcode.callback = read;
        setwebcam();
    }
    else
    {
        document.getElementById("mainbody").style.display="inline";
        document.getElementById("mainbody").innerHTML='<p id="mp1">QR code scanner for HTML5 capable browsers</p><br>'+
        '<br><p id="mp2">sorry your browser is not supported</p><br><br>'+
        '<p id="mp1">try <a href="http://www.mozilla.com/firefox"><img src="firefox.png"/></a> or <a href="http://chrome.google.com"><img src="chrome_logo.gif"/></a> or <a href="http://www.opera.com"><img src="Opera-logo.png"/></a></p>';
    }
}
function init (hasVideo) {
    if (hasVideo) {
        on_camera();
    } else {
        load();
    }
}
// 1. load camera