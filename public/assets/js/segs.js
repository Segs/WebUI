/*
 * SEGS - Super Entity Game Server
 * http://www.segs.io/
 * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
 * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
 */

function doLogin()
{
    var form_data = document.getElementById("modal_form_login");
    var body_content = {'username' : form_data.modal_login_username.value,
                        'password' : form_data.modal_login_password.value};
	$("#modal-login").modal('hide');
    fetch("/assets/includes/doLogin.php",{
        method: 'POST',
        headers:{
            'charset': 'utf-8',
            'content-type':'application/json'
        },
        body: JSON.stringify(body_content)
    })
        .then(function(myBlob){
            return myBlob.json();
    })
        .then(function(result){
            try {
                $("#modal-result").html(result.return_message);
                $("#modal-message").modal('show');
            } catch(e) {
                window.location.reload();
            }
        });
    return false;
}

function doRefresh()
{
    try {
        var urlParams = new URLSearchParams(window.location.search);
        if(urlParams.get('page') === "register") {
            window.location.replace('/');
        } else {
            window.location.reload();
        }
    } catch {
        window.location.replace('/');
    }
    return false;
}

function doLogout()
{
    fetch("/assets/includes/doLogout.php",{
        method: 'GET'
    })
        .then(myBlob => myBlob.json())
        .then(function(result){
            m_status = false;
            try {
                $("#modal-result").html(result.return_message);
                $("#modal-message").modal('show');
                m_status = true;
            } catch(e) {
                window.location.reload();
                m_status = false;
            }
            return m_status;
        })
        .catch(function(error) {
            console.log(new Date().toUTCString() + " " + error); 
        });
    return true;
}

function doSignup()
{
    var form_data = document.getElementById('form_register');
    var resultbox = document.getElementById('register-result');
    var body_content = {'username': form_data.desired_username.value,
                        'password1': form_data.password1.value,
                        'password2': form_data.password2.value};
    fetch("/assets/includes/createUser.php",
    {
        method: 'POST',
        headers: {'charset': 'utf-8',
                  'content-type': 'application/json'},
        body: JSON.stringify(body_content),
    })
        .then(myBlob => myBlob.json())
        .then(function(result){
            m_status = false;
            try {
                $("#modal-result").html(result.return_message);
                $("#modal-message").modal('show');
                m_status = true;
            } catch(e) {
                window.location.reload();
                m_status = false;
            }
            return m_status;
        })
        .catch(function(error) {
            console.log(new Date().toUTCString() + " " + error); 
        });
    return false;
}

function stripTrailingSlash(str)
{
    if(str.substr(-1) == '/') {
        return str.substr(0, str.length - 1);
    }
    return str;
}

function getCookie(cookieName)
{
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

function setCookie(cookieName, cookieValue, expirationInDays)
{
    var expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + expirationInDays);
    var newCookieValue = escape(cookieValue) + ((expirationInDays == null) ? "" : "; expires=" + expirationDate.toUTCString());
    document.cookie = cookieName + "=" + newCookieValue;
}

$(function()
{
	// retrieve cookie value on page load
	var activePage = getCookie("CurrentPage");
	var $menuItem;
	// if cookie is empty, set to dashboard
	if (activePage === null || activePage === "" || typeof activePage === "undefined") {
		activePage = 'dashboard';
	}
	// create element id variable
	$menuItem = "#menu_" + activePage;
	// set page active
	$($menuItem).addClass('active');
});

function cityListPopulate(currentCity)
{
    var zones = [];
    
    async function fetchZoneList(url)
    {
        let response = await (await fetch(url)).json();
        return response;
    }
    
    request = fetchZoneList('/assets/js/zones.json')
        .then(function(data){
            zones = data;
        })
        .catch(reason => console.log(reason.message));

    $.when(request).done(function(data) {
        var cs = document.getElementById('zoneSelector');
        cs.innerHTML = "<option disabled>- Cities</option>";
        for(var j = 0; j < zones.cities.length; j++){
            var citystr = document.createElement('option');
            citystr.value = zones.cities[j].index;
            citystr.innerText = zones.cities[j].name;
            cs.appendChild(citystr);
        }
        cs.innerHTML += "<option disabled>- Hazards</option>";
        for(var j = 0; j < zones.hazards.length; j++){
            var citystr = document.createElement('option');
            citystr.value = zones.hazards[j].index;
            citystr.innerText = zones.hazards[j].name;
            cs.appendChild(citystr);
        }
        cs.innerHTML += "<option disabled>- Trials</option>";
        for(var j = 0; j < zones.trials.length; j++){
            let citystr = document.createElement('option');
            citystr.value = zones.trials[j].index;
            citystr.innerText = zones.trials[j].name;
            cs.appendChild(citystr);
        }
        cs.value = currentCity;
    });

    
/*    
// // //    var cs = document.getElementById('zoneSelector');
// // //    cs.innerHTML = "<option disabled>- Cities</option>";
// // //    for(var j = 0; j < zones.cities.length; j++){
// // //        var citystr = document.createElement('option');
// // //        citystr.value = zones.cities[j].index;
// // //        citystr.innerText = zones.cities[j].name;
// // //        cs.appendChild(citystr);
// // //    }
// // //    cs.innerHTML += "<option disabled>- Hazards</option>";
// // //    for(var j = 0; j < zones.hazards.length; j++){
// // //        var citystr = document.createElement('option');
// // //        citystr.value = zones.hazards[j].index;
// // //        citystr.innerText = zones.hazards[j];
// // //        cs.appendChild(citystr);
// // //    }
// // //    cs.innerHTML += "<option disabled>- Trials</option>";
// // //    for(var j = 0; j < zones.trials.length; j++){
// // //        let citystr = document.createElement('option');
// // //        citystr.value = zones.trials[j].index;
// // //        citystr.innerText = zones.trials[j].name;
// // //        cs.appendChild(citystr);
// // //    }
// // //    cs.value = currentCity;
*/
}

async function selectCurrentZone(selectObject)
{
    var character = selectObject.options[selectObject.selectedIndex].text;
    var cs = document.getElementById('zoneSelector');
    cs.value = await getCurrentZone(character);
}

async function getCurrentZone(characterName)
{
    var character;
    var bodycontent = {
            'username': '',
            'character_name' : characterName
    };
    const settings = {
        method: 'POST',
        headers: {
            'charset': 'utf-8',
            'content-type': 'application/json'
        },
        body: JSON.stringify(bodycontent)
    };
    
    async function fetchZone(url)
    {
        let response = await (await fetch(url,settings)
            .then(response => response.json())
            .then(json => {
                return json.return_message;
            })
            .catch(e => {
                return e;
            }));
        return response;
    }

    request = await fetchZone('/assets/includes/getZone.php')
        .then(function(data){
            return data;
        })
        .then(function(zone) {
            if(zone.length == 0){
                document.getElementById('switchbox').innerHTML = "Unable to retrieve zones.";
            } else {
                character = JSON.parse(zone);
            }
            return character['value0']['MapIdx'];
        })
        .catch(reason => console.log(reason.message));

    return request;
}

function doZoneSwitch() 
{
    var bodycontent = {'user': ''};
    fetch(window.location.origin + "/assets/includes/getCharacters.php",{
        method: 'POST',
        headers: {
            'charset': 'utf-8',
            'content-type': 'application/json'
        },
        body: JSON.stringify(bodycontent)
    })
        .then(myBlob => myBlob.json())
        .then(function(results){
            var currZone = null;
            if(results.length == 0){
                document.getElementById('switchbox').innerHTML = "You do not currently have any heroes on this server.<br>Once you have logged in and created one, you will see them here.";
            } else {
                var myForm = document.createElement('form');
                myForm.name = "zonemove";
                myForm.id = "zonemove";
                myForm.setAttribute("onSubmit", "return moveCharacter()");
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
                charselect.setAttribute("onchange", "return selectCurrentZone(this)")

                charselect.className = "custom-select mr-sm-2";
                for(let i = 0; i < results.length; i++) {
                    let character = JSON.parse(results[i]);
                    let entitydata = JSON.parse(character.entityData);
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
                button.className = "btn btn-primary";
                button.addEventListener("click", moveCharacter);
                formgroupcol3.appendChild(button);

                document.getElementById('switchbox').innerHTML = "";
                document.getElementById('switchbox').appendChild(myForm);
                selectedCharacterName = $("#characterSelect option:selected" ).text();
                return selectedCharacterName;
            }
        }, function(){
            document.getElementById('switchbox').innerHTML = "We are unable to display any characters at this time.";
            return null;
        })
        .then(async function(selectedCharacterName){
            var currZone = await getCurrentZone(selectedCharacterName);
            return currZone;
        })
        .then(function(currZone){
            if(currZone !== null){
                cityListPopulate(currZone);
            }
        });
}

function getAccountsInfo()
{
    var elementAccts = document.getElementById("num_accts");
    var elementChars = document.getElementById("num_chars");
    fetch(window.location.origin + "/assets/includes/getAccounts.php",
          {method: 'GET'
          }).then(function(myBlob){
              return myBlob.json();
          }).then(function(data){
              elementAccts.innerHTML = data.num_accts;
              elementChars.innerHTML = data.num_chars;
          });
}

function moveCharacter()
{
    var moveForm = document.getElementById('zonemove');
    var selectedCharacter = moveForm.characterSelect;
    var selectedZone = moveForm.zoneSelector;
    var postBody = {'char' : selectedCharacter.value, 'map' : selectedZone.value};
    fetch(window.location.origin + "/assets/includes/moveCharacter.php",{
        method: 'POST',
        headers:{
            'charset': 'utf-8',
            'content-type':'application/json'
        },
        body : JSON.stringify(postBody)
    }).then(function(myBlob){
        return myBlob.json();
    }).then(function(results){
        var return_message = new Array();
        for (var i = 0, len = results.return_message.length; i < len; i++) {
            return_message.push(results.return_message[i]);
        }
        
        if(results.value == 0){
            return_message.push("<div>You have successfully moved " + 
                selectedCharacter.options[selectedCharacter.selectedIndex].text + " to " + 
                selectedZone.options[selectedZone.selectedIndex].text + ".</div>");
        } else {
            return_message.push("<div>There was an problem moving " + 
                selectedCharacter.options[selectedCharacter.selectedIndex].text + " to " + 
                selectedZone.options[selectedZone.selectedIndex].text + ".</div>");
        }
        
        try{
            $("#modal-result").html(return_message);
            $("#modal-message").modal('show');
        } catch(e) {
            window.location.reload();
        }
        

    });
    return false;
}

function checkUsername(usernameMinLength)
{
    var formdata = document.getElementById('form_register');
    var username = formdata.desired_username.value;
    var isAvailable = false;
    var isLongEnough = false;
    var isValid = false;
    var request = null;
    
    // Check username length
    if(username.length >= usernameMinLength)
    {
        isLongEnough = true;
    }
    
    changeStatusById("username-requirements-length", isLongEnough);

    request = checkUsernameAvailability(username);
    
    $.when(request).done(function(data) {
        if(data === 'true') {
            isAvailable = true;
        }
        changeStatusById("username-requirements-unique", isAvailable);
        
        if(isAvailable && isLongEnough) {
            isValid = true;
        }
        changeStatusById("username-requirements", isValid);
    });
}

function checkUsernameAvailability(username)
{
    var username = "username=" + username;
    var result = "";
    var isAvailable = false;

    var ajaxCall = {
        url: "/assets/includes/checkAvailability.php",
        data: username,
        type: "POST",
        success:function(data){
            if(data !== null)
            {
                result = data;
            } 
            
            if(result === 'true')
            {
                isAvailable = true;
            }
            return isAvailable;
        },
        error:function(data){
            $("#user-availability-status").html('Error:' + data.responseText);
            return isAvailable;
        }
    }
    return $.ajax(ajaxCall);
}

function changeStatusById(entityId, isEnabled)
{   
    divEntityId = "#" + entityId
    iconEntityId = "#icon-" + entityId;
    if(isEnabled)
    {
        $(iconEntityId).removeClass("fa-square");
        $(iconEntityId).addClass("fa-check-square");
        $(divEntityId).removeClass("text-danger");
        $(divEntityId).addClass("text-success");
    }
    else
    {
        $(iconEntityId).removeClass("fa-check-square");
        $(iconEntityId).addClass("fa-square");
        $(divEntityId).removeClass("text-success");
        $(divEntityId).addClass("text-danger");
    }
}

function checkPasswordComplexity(password, passwordMinLength)
{
    var pattern = "^^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[#$^+=!*()@%&]).{" + passwordMinLength.toString() + ",}$";
    var re = new RegExp(pattern);
    return re.test(password);
}

function checkPasswords(passwordMinLength, passwordComplexity)
{
    var username = document.getElementById('desired_username');
    username.value = username.value.replace(/^\s+|\s+$/g, "");
    var password1 = document.getElementById('password1');
    var password2 = document.getElementById('password2');
    var passwordIsLongEnough = true;
    var passwordIsNotEmpty = true;
    var passwordsMatch = true;
    var passwordIsNotUserName = true;
    var passwordIsValid = true;
    var isSuccess = true;
    var message = "";

    if(username === null) {
        username = "";
    }

    if(passwordMinLength > 0 && password1.value === "") {
        passwordIsNotEmpty = false;
        isSuccess =  false;
    }
        
    if(passwordMinLength > 0 && password2.value === "") {
        passwordIsNotEmpty = false;
        isSuccess =  false;
    }

    if(!passwordIsNotEmpty || password1.value.length < passwordMinLength) {
        passwordIsLongEnough = false;
        isSuccess =  false;
    } 
    changeStatusById("password-complex-length", passwordIsLongEnough);
        
    if(!passwordIsNotEmpty || password1.value !== password2.value) {
        passwordsMatch = false;
        isSuccess =  false;
    }
    changeStatusById("passwords-match", passwordsMatch);

    if(password1.value.toLowerCase() === username.value.toLowerCase()) {
        passwordIsNotUserName = false;
        isSuccess =  false;
    }
    changeStatusById("password-complex-not-username", passwordIsNotUserName);

    if(!passwordIsNotEmpty && (passwordComplexity != "false" && passwordMinLength > 4)) {
        if(!checkPasswordComplexity(password1.value, passwordMinLength)) {
            passwordIsValid = false;
            isSuccess = false;
        }
    }
    changeStatusById("password-complex-special", passwordIsValid);
    changeStatusById("password-complex", isSuccess);

    return isSuccess;
}


$(".nav .nav-item").on("click", function(){
    var path = window.location.pathname;
    path = path.replace(/\/$/,"");
    path = decodeURIComponent(path)
    $(".nav").find('.active').removeClass("active");
    $(this).addClass("active");
});
