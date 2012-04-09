function http() {
    var http;
    if (window.XMLHttpRequest) { 
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return http;
}