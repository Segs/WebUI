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
}

window.onload = function() {
    var wv = document.getElementById('dash').innerHTML;
    document.getElementById('pagebody').innerHTML = wv;
    goHome();
    accsUpdate();
}


signupFunction = function(){
    var formdata = document.getElementById('signupform');
    var resultbox = document.getElementById('signupFail');
    var bodycont = "user=" + formdata.username.value + "&pass=" + formdata.pass.value;
    fetch(location.protocol + "//" + window.location.hostname + "/usercreate.php", {method: 'POST',
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
    fetch(location.protocol + "//" + window.location.hostname + "/acc_count.php", {method: 'GET'
                                             }).then(function(myBlob){
                                                 return myBlob.json();
					     }).then(function(data){
						 console.log(data);
						 ua.innerHTML = data.numaccs;
						 cc.innerHTML = data.numchar;
					     });
}
