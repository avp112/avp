var InfoId = null;

var mouseX = 0;
var mouseY = 0;

var offX = 0;
var offY = 0;

IE = document.all&&!window.opera;
DOM = document.getElementById&&!IE;

function connectTS(server){
    nick = prompt("Gib bitte deinen Nickname ein.", "");
    if(nick != null){
        if(nick == ""){
            nick = "TSMonitor-Gast";
        }
        window.location.href = 'teamspeak://'+server+"?nickname="+nick;
    }
}

function init(server, tcp, udp){
    document.getElementById('Content').innerHTML = '<img src="styles/'+STYLESHEET+'/images/icons/loading.gif" alt="loading Content ..." /> &nbsp;&nbsp; loading TSMonitor';

	setInterval("loadContent('"+server+"', '"+tcp+"', '"+udp+"')", 1000);
}

function loadContent(){
    xhr_content = http();
    xhr_content.open("GET", "pages/content.php", true);
    xhr_content.onreadystatechange = putContent;
    xhr_content.send(null);
}

function putContent(){
    if (xhr_content.readyState == 4) {
        response = xhr_content.responseText;
        if(response == ""){
			document.getElementById("Content").innerHTML = "Keine Daten vorhanden.";
		} else {
			document.getElementById("Content").innerHTML = response;
		}
    }
}

function showInfo(id){
    InfoId = "Info";

    //offX = mouseX - document.getElementById(InfoId).offsetLeft;
	offY = document.getElementById("Content").offsetHeight;
	//alert(offY);
	// 60
    document.getElementById(InfoId).innerHTML = document.getElementById("user_info_"+id).innerHTML;
    document.getElementById(InfoId).style.display = "block";
}

function hideInfo(){
    document.getElementById(InfoId).style.display = "none";

    InfoId = null;
}

function moveInfoWindow(event){
    mouseX = (IE) ? window.event.clientX : event.pageX;
	mouseY = (IE) ? window.event.clientY : event.pageY;

    

    if((offY - mouseY) >= 85){
        position = 25;
    } else {
        position = -60;
    }

	if (document.getElementById(InfoId)) {
	    //alert("X:"+mouseX+", Y:"+mouseY+", offY:"+offY);
		document.getElementById(InfoId).style.left = (mouseX +15) + "px";
		document.getElementById(InfoId).style.top = (mouseY +position) + "px";
	}
}