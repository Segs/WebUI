/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2018 SEGS Team (see Authors.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */

selectDiv = function(elem){
    elem.classList.add("selected");
    elem.classList.remove("others");
}

unselectDiv = function(elem){
    elem.classList.add("others");
    elem.classList.remove("selected");
}

goHome = function(){
    selectDiv(document.getElementById('dashboard'));
    unselectDiv(document.getElementById('accounts'));
    unselectDiv(document.getElementById('stats'));
    unselectDiv(document.getElementById('chatlogs'));
    unselectDiv(document.getElementById('serverlogs'));
    
    document.getElementById('dashy').style.display = "block";
    document.getElementById('signup').style.display = "none";
    document.getElementById('statistics').style.display = "none";
    document.getElementById('chatlog').style.display = "none";
    document.getElementById('servlog').style.display = "none";
}

goAccs = function(){
    unselectDiv(document.getElementById('dashboard'));
    selectDiv(document.getElementById('accounts'));
    unselectDiv(document.getElementById('stats'));
    unselectDiv(document.getElementById('chatlogs'));
    unselectDiv(document.getElementById('serverlogs'));
    
    document.getElementById('dashy').style.display = "none";
    document.getElementById('signup').style.display = "block";
    document.getElementById('statistics').style.display = "none";
    document.getElementById('chatlog').style.display = "none";
    document.getElementById('servlog').style.display = "none";
}

goStats = function(){
    unselectDiv(document.getElementById('dashboard'));
    unselectDiv(document.getElementById('accounts'));
    selectDiv(document.getElementById('stats'));
    unselectDiv(document.getElementById('chatlogs'));
    unselectDiv(document.getElementById('serverlogs'));
    
    document.getElementById('dashy').style.display = "none";
    document.getElementById('signup').style.display = "none";
    document.getElementById('statistics').style.display = "block";
    document.getElementById('chatlog').style.display = "none";
    document.getElementById('servlog').style.display = "none";
}

goClogs = function(){
    unselectDiv(document.getElementById('dashboard'));
    unselectDiv(document.getElementById('accounts'));
    unselectDiv(document.getElementById('stats'));
    selectDiv(document.getElementById('chatlogs'));
    unselectDiv(document.getElementById('serverlogs'));
    
    document.getElementById('dashy').style.display = "none";
    document.getElementById('signup').style.display = "none";
    document.getElementById('statistics').style.display = "none";
    document.getElementById('chatlog').style.display = "block";
    document.getElementById('servlog').style.display = "none";
}

goSlogs = function(){
    unselectDiv(document.getElementById('dashboard'));
    unselectDiv(document.getElementById('accounts'));
    unselectDiv(document.getElementById('stats'));
    unselectDiv(document.getElementById('chatlogs'));
    selectDiv(document.getElementById('serverlogs'));
    
    document.getElementById('dashy').style.display = "none";
    document.getElementById('signup').style.display = "none";
    document.getElementById('statistics').style.display = "none";
    document.getElementById('chatlog').style.display = "none";
    document.getElementById('servlog').style.display = "block";
    document.getElementById('cityswitch').style.display = "none";
}

cityListPopulate = function(currentCity){
    document.getElementById('cityswitch').style.display = "block";
    var cities = ["Outbreak", "Atlas Park", "King's Row", "Galaxy City",
                  "Steel Canyon", "Skyway City", "Talos Island", "Independence Port",
                  "Founders' Falls", "Brickstown", "Peregrine Island"];
    var hazard = ["Perez Park", "Boomtown", "Dark Astoria", "Crey's Folly",
                  "Enviro Nightmare", "Elysium"];
    var trials = ["Abandoned Sewer Network", "Sewer Network", "Faultline",
                  "Terra Volta", "Eden", "The Hive", "Rikti Crash Site"];
    var cs = document.getElementById('citySelector');
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

goCitySwitch = function(){
    var bodycontent = {
        'user': ''
    }
    fetch("/charfetch.php",
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
              myForm.name = "citymove";
              myForm.id = "citymove";
              myForm.method = "POST";
              var charselect = document.createElement('select');
              charselect.id = "characterSelect";
              charselect.name = "character";
              for(let i = 0; i < results.length; i++){
                  let character = JSON.parse(results[i]);
                  let entitydata = JSON.parse(character.entitydata);
                  var charopt = document.createElement('option');
                  charopt.value = i;
                  charopt.innerText = character.name;
                  charselect.appendChild(charopt);
              }
              myForm.appendChild(charselect);
              var citySel = document.createElement('select');
              citySel.id = "citySelector";
              citySel.name = "city";
              myForm.appendChild(citySel);
              let button = document.createElement('input');
              button.value = "Move";
              button.type = "button";
              button.addEventListener("click", moveCharacter);
              myForm.appendChild(button);
              document.getElementById('switchbox').innerHTML = "";
              document.getElementById('switchbox').appendChild(myForm);
              cityListPopulate(1);

          });
}

window.onload = function() {
    var wv = document.getElementById('dash').innerHTML;
    document.getElementById('pagebody').innerHTML = wv;
    accsUpdate();
    selectDiv(document.getElementById('dashboard'));
    document.getElementById('dashy').style.display = "block";
}


signupFunction = function(){
    var formdata = document.getElementById('signupform');
    var resultbox = document.getElementById('signupFail');
    var bodycont = "user=" + formdata.username.value + "&pass=" + formdata.pass.value;
    fetch("usercreate.php",
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

accsUpdate = function(){
    var ua = document.getElementById("numaccs");
    var cc = document.getElementById("numchars");
    fetch("/acc_count.php",
          {method: 'GET'
          }).then(function(myBlob){
              return myBlob.json();
          }).then(function(data){
              console.log(data);
              ua.innerHTML = data.numaccs;
              cc.innerHTML = data.numchar;
          });
}

doLogin = function(){
    var formdata = document.getElementById("loginform");
    var bodyvar = { 'user' : formdata.username.value,
                    'pass' : formdata.pass.value};
    fetch("/login.php",
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
                  window.location.replace("/");
              }
              catch(e){
                  window.location.reload();
              }
          });
    return false;
}

signOut = function(){
    fetch("/logout.php",
          {method: 'GET'
          }).then(function(result){
              return result;
          }).then(function(data){
              try{
                  window.location.replace("/");
              }
              catch(e){
                  window.location.reload();
              }
          });
    return true;
}

moveCharacter = function(){
    var moveForm = document.getElementById('citymove');
    var CS = moveForm.citySelector;
    var postBody = {'char' : moveForm.characterSelect.value,
                    'map' : CS.value};
    fetch("/charmove.php",
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
