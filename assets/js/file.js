var text = document.getElementsByClassName('status');
var error_1 = "*Пустой текст.";
var error_2 = "*Выберете возраст.";
var error_3 = "*Введите информацию о себе.";

var timer = 3;

function registration_func() {
  if (validateSurName() && validateName() && validateMiddleName() && validateSelectValue() && validateAbout()) {
    return true;
  }
  else {
        return false;
  }
}

function validateSurName() {
  if (/^[a-zA-Z]+$/.test(document.registration.surname.value)) {
    text[0].innerHTML = "";
    return true;
  } 
  else if (document.registration.surname.value.length <= 0) {
    text[0].innerHTML = error_1;
  }
  else {
    var found = document.registration.surname.value.match(/[^a-zA-Z]/ig); text[0].innerHTML = "*Ошибка: ";          
    for(var j = 0; j < found.length; j++) {
      text[0].innerHTML +=  found[j];
    }
  }
}

function validateName() {
  if (/^[a-zA-Z]+$/.test(document.registration.name.value)) {
    text[1].innerHTML = "";
    return true;
  } 
  else if (document.registration.name.value.length <= 0) {
    text[1].innerHTML = error_1;
  }
  else {
    var found = document.registration.name.value.match(/[^a-zA-Z]/ig); text[1].innerHTML = "*Ошибка: ";          
    for(var j = 0; j < found.length; j++) {
      text[1].innerHTML +=  found[j];
    }
  }
}

function validateMiddleName() {
  if (/^[a-zA-Z]+$/.test(document.registration.middle_name.value)) {
    text[2].innerHTML = "";
    return true;
  } 
  else if (document.registration.middle_name.value.length <= 0) {
    text[2].innerHTML = error_1;
  }
  else {
    var found = document.registration.middle_name.value.match(/[^a-zA-Z]/ig); text[2].innerHTML = "*Ошибка: ";          
    for(var j = 0; j < found.length; j++) {
      text[2].innerHTML +=  found[j];
    }
  }
}

function validateSelectValue() {
  if (document.registration.select_value.options.selectedIndex == 0) {
    text[3].innerHTML = error_2;
    return false;
  }
  else {
    text[3].innerHTML = "";
    return true;
  }
}

function validateAbout() {
  if (document.registration.textbox.value.length <= 0) {
    text[4].innerHTML = error_3;
    return false; 
  }
  else {
    text[4].innerHTML = "";
    return true;
  }
}

var down_load_timer = setInterval(function() {
  if (timer <= 0) {
    location.replace("index.php");
  } 
  else {
    document.getElementById("time").innerHTML = timer; 
} timer -= 1; }, 1000);