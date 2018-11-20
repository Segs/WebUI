/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */

function makeRequest(m_elementId, m_page, m_function) {
	var httpRequest;
	var m_docElement = document.getElementById(m_elementId);
    httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function(){
		if (this.readyState === 4 && this.status === 200){
			m_function(m_docElement, httpRequest);
		}
	};
    httpRequest.open('GET', m_page);
    httpRequest.send();
}
	
function showContents(m_docElement, m_httpRequest) {
	m_docElement.innerHTML = m_httpRequest.responseText;
}

function updateMain(m_pageName) {
    var m_view_file;
    m_view_file = 'assets/views/' + m_pageName + '.php'
    makeRequest('main-content', m_view_file, showContents);
    setCookie("CurrentPage", m_pageName, 1);
}

function updateModal(m_pageName) {
    var m_include_file;
    m_include_file = 'assets/includes/' + m_pageName + '.php'
    makeRequest('modal-content', m_include_file, showContents);
}

function doLogin(){
    var formdata = document.getElementById("modal_form_login");
    var bodyvar = { 'username' : formdata.modal_login_username.value,
                    'password' : formdata.modal_login_password.value};
    console.log(formdata);
    console.log(bodyvar);
    fetch("assets/includes/doLogin.php",
          {method: 'POST',
           headers:{
               'charset': 'utf-8',
               'content-type':'application/json'
           },
           body: JSON.stringify(bodyvar)
          }).then(function(myBlob){
              return myBlob.json();
          }).then(function(result){
              try{
                  window.location.replace(window.location.pathname);
              }
              catch(e){
                  window.location.reload();
              }
          });
    return false;
}

function doLogout(){
    fetch("assets/includes/doLogout.php",
          {method: 'GET'
          }).then(function(result){
              return result;
          }).then(function(data){
              try{
                  window.location.replace(window.location.pathname);
              }
              catch(e){
                  window.location.reload();
              }
          });
    return true;
}

function doSignup(){
    var formdata = document.getElementById('signupform');
    var resultbox = document.getElementById('signupFail');
    var bodycont = "user=" + formdata.username.value + "&pass=" + formdata.password.value;
    fetch("/WebUI2/src/usercreate.php",
          {method: 'POST',
           headers: {
               'charset': 'utf-8',
               'content-type':'application/x-www-form-urlencoded'
           },
           body: bodycont
          }).then(function(myBlob){
              return myBlob.json();
          }).then(function(data){
              console.log(data);
              resultbox.innerHTML=data.retmsg;});
}


//function //ountsInfo(){
//    var elementAccts = document.getElementById("num_accts");
//    var elementChars = document.getElementById("num_chars");
//    fetch("/WebUI2/src/acc_count.php",
//          {method: 'GET'
//          }).then(function(myBlob){
//              return myBlob.json();
//          }).then(function(data){
//              console.log(data);
//              elementAccts.innerHTML = data.num_accts;
//              elementChars.innerHTML = data.num_chars;
//          });
//}

/*menu handler*/
//$(function(){
function stripTrailingSlash(str) {
    if(str.substr(-1) == '/') {
        return str.substr(0, str.length - 1);
    }
    return str;
}


var url = window.location.pathname;
var activePage = stripTrailingSlash(url);

/*
  $('.nav li a').each(function(){  
    var currentPage = stripTrailingSlash($(this).attr('href'));

    if (activePage == currentPage) {
      $(this).parent().addClass('active'); 
    } 
  });
*/
//});

function setActiveItem(){
    var path = window.location.pathname;
    console.log(path);
    path = path.replace(/\/$/,"");
    console.log(path);
    path = decodeURIComponent(path)
}

function getCookie(cookieName) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x === cookieName) {
            return unescape(y);
        }
    }
}

function setCookie(cookieName, cookieValue, expirationInDays) {
    var expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + expirationInDays);
    var newCookieValue = escape(cookieValue) + ((expirationInDays == null) ? "" : "; expires=" + expirationDate.toUTCString());
    document.cookie = cookieName + "=" + newCookieValue;
}

$(function() {
	// retrieve cookie value on page load
	var activePage = getCookie("CurrentPage");
	var $menuItem;
	// if cookie is empty, set to dashboard
	if (activePage === null || activePage === "" || typeof activePage === "undefined") {
		activePage = 'dashboard';
	}
	// create element id variable
	$menuItem = "#menu_" + activePage;
	// load page
//	updateMain(activePage);
	// set page active
	$($menuItem).addClass('active');
});

function cityListPopulate(currentCity){
    //document.getElementById('zoneswitch').style.display = "block";
    var cities = ["Outbreak", "Atlas Park", "King's Row", "Galaxy City",
                  "Steel Canyon", "Skyway City", "Talos Island", "Independence Port",
                  "Founders' Falls", "Brickstown", "Peregrine Island"];
    var hazard = ["Perez Park", "Boomtown", "Dark Astoria", "Crey's Folly",
                  "Enviro Nightmare", "Elysium"];
    var trials = ["Abandoned Sewer Network", "Sewer Network", "Faultline",
                  "Terra Volta", "Eden", "The Hive", "Rikti Crash Site"];
    var cs = document.getElementById('zoneSelector');
    cs.innerHTML = "<option disabled>- Cities</option>";
    var iterator = 0;
    for(var j = 0; j < cities.length; j++){
        var citystr = document.createElement('option');
        citystr.value = iterator;
        citystr.innerText = cities[j];
        cs.appendChild(citystr);
        iterator++;
    }
    cs.innerHTML += "<option disabled>- Hazards</option>";
    for(var j = 0; j < hazard.length; j++){
        var citystr = document.createElement('option');
        citystr.value = iterator;
        citystr.innerText = hazard[j];
        cs.appendChild(citystr);
        iterator++;
    }
    cs.innerHTML += "<option disabled>- Trials</option>";
    for(var j = 0; j < trials.length; j++){
        let citystr = document.createElement('option');
        citystr.value = iterator;
        citystr.innerText = trials[j];
        cs.appendChild(citystr);
        iterator++;
    }
    cs.value = currentCity;
}

var entities;


function goZoneSwitch(){
    var bodycontent = {
        'user': ''
    }
    fetch(window.location.origin + "/assets/includes/getCharacters.php",
          {method: 'POST',
           headers: {
               'charset': 'utf-8',
               'content-type': 'application/json'
           },
           body: JSON.stringify(bodycontent)
          }).then(function(myBlob){
              return myBlob.json();
          }).then(function(results){
              entities = results;
              var myForm = document.createElement('form');
              myForm.name = "zonemove";
              myForm.id = "zonemove";
              myForm.method = "POST";
              
              
              var formgroup = document.createElement('div');
              formgroup.className = "form-row align-items-center";
              myForm.appendChild(formgroup);

              var formgroupcol1 = document.createElement('div');
              formgroupcol1.className = "col-sm-3 my-1";
              formgroup.appendChild(formgroupcol1);

              var charselect = document.createElement('select');
              charselect.id = "characterSelect";
              charselect.name = "character";
              charselect.className = "custom-select mr-sm-2";
              for(let i = 0; i < results.length; i++){
                  let character = JSON.parse(results[i]);
                  let entitydata = JSON.parse(character.entitydata);
                  var charopt = document.createElement('option');
                  charopt.value = i;
                  charopt.innerText = character.name;
                  charselect.appendChild(charopt);
              }
              formgroupcol1.appendChild(charselect);
              
              var formgroupcol2 = document.createElement('div');
              formgroupcol2.className = "col-sm-3 my-1";
              formgroup.appendChild(formgroupcol2);

              var zoneSel = document.createElement('select');
              zoneSel.id = "zoneSelector";
              zoneSel.name = "city";
              zoneSel.className = "custom-select mr-sm-2";
              formgroupcol2.appendChild(zoneSel);
              
              
              var formgroupcol3 = document.createElement('div');
              formgroupcol3.className = "col-sm-3 my-1";
              formgroup.appendChild(formgroupcol3);

              let button = document.createElement('input');
              button.value = "Move";
              button.type = "button";
              button.className = "btn btn-dark";
              button.addEventListener("click", moveCharacter);
              formgroupcol3.appendChild(button);
              
              
              document.getElementById('switchbox').innerHTML = "";
              document.getElementById('switchbox').appendChild(myForm);
              cityListPopulate(1);

          });
}

function getAccountsInfo(){
    var elementAccts = document.getElementById("num_accts");
    var elementChars = document.getElementById("num_chars");
    //fetch("https://segs.verybadpanda.com/assets/includes/getAccounts.php",
    fetch(window.location.origin + "/assets/includes/getAccounts.php",
          {method: 'GET'
          }).then(function(myBlob){
              return myBlob.json();
          }).then(function(data){
              elementAccts.innerHTML = data.num_accts;
              elementChars.innerHTML = data.num_chars;
          });
}

function moveCharacter(){
    var moveForm = document.getElementById('zonemove');
    var CS = moveForm.zoneSelector;
    var postBody = {'char' : moveForm.characterSelect.value,
                    'map' : CS.value};
    fetch(window.location.origin + "/assets/includes/moveCharacter.php",
          {method: 'POST',
           headers:{
               'charset': 'utf-8',
               'content-type':'application/json'
           },
           body : JSON.stringify(postBody)
          }
         ).then(
             function(myBlob){
                 return myBlob.json();
             }).then(
                 function(results){
                     if(results.value == 0){
                         var sb = document.getElementById('switchbox');
                         var textbox = document.createElement('div');
                         textbox.innerText = "You successfully moved to ";
                         var cityname = document.createElement('SPAN');
                         cityname.style.color = "DarkGreen";
                         cityname.style.fontWeight = "bold";
                         cityname.innerText = CS.options[CS.selectedIndex].text;
                         textbox.append(cityname);
                         sb.append(textbox);
                         setTimeout(function (){
                             sb.removeChild(textbox);
                         }, 2000);
                     }
                 }
             );
    return false;
}


var wsUri = "wss://segs.aruin.com";


var output;
var available_services = ["helloServer", "getVersion"]; // To add a new service, add to this list.

function add_services() {
    var table = document.getElementById("button_table");
    var i;
    for (i = 0; i < available_services.length; i++) {
        var row = table.insertRow(0);
        var cell1 = row.insertCell(0);
        var pre = document.createElement("button");
        pre.setAttribute("id", available_services[i]);
        pre.setAttribute("class", "service_button");
        pre.addEventListener('click', function() {
            makeCall(this.id);
        }, false);
        var buttonText = available_services[i];
        pre.innerHTML = buttonText;
        cell1.appendChild(pre);
    }
}

function initRpc() {
    add_services();//
    output = document.getElementById("output");
    openWebSocket();
}

function openWebSocket() {
    websocket = new WebSocket(wsUri);
    websocket.onopen = function(evt) {
        onOpen(evt)
    };
    websocket.onclose = function(evt) {
        onClose(evt)
    };
    websocket.onmessage = function(evt) {
        onMessage(evt)
    };
    websocket.onerror = function(evt) {
        onError(evt)
    };
}

function onOpen(evt) {
    writeToScreen("CONNECTED TO: " + wsUri);
}

function makeCall(message) {
    doSend(message);
}

function onClose(evt) {
    writeToScreen("DISCONNECTED");
}

function onMessage(evt) {
    writeToScreen('<span style="color: blue;">SERVER RESPONSE: ' + evt.data + '</span>');
    processResponse(evt.data);
}

function onError(evt) {
    writeToScreen('<span style="color: red;">SERVER ERROR:</span> ' + evt.data);
}

function processResponse(response) {
    var obj = JSON.parse(response);
    result = obj.result;
    writeToScreen('<span style="color: green;">PROCESSED RESPONSE:</span> ' + result);
    websocket.close();
}

function doSend(message) {
    var timestamp = new Date().getTime();
    var request_payload = JSON.stringify({
        jsonrpc: "2.0",
        method: message,
        params: {},
        id: timestamp
    });
    websocket.send(request_payload);
    writeToScreen("SENT: " + request_payload);
}

function writeToScreen(message) {
    var pre = document.createElement("p");
    pre.style.wordWrap = "break-word";
    pre.innerHTML = message;
    output.appendChild(pre);
}

//document.addEventListener("load", add_services(), false);
//document.getElementById("rpc-connect").onclick = function() {
//    initRpc();
//};


$(".nav .nav-item").on("click", function(){
    var path = window.location.pathname;
    path = path.replace(/\/$/,"");
    path = decodeURIComponent(path)
    $(".nav").find('.active').removeClass("active");
    $(this).addClass("active");
});

// Login form validation