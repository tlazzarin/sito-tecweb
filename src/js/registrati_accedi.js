let restrizioni = {
  username: [
    "Username",
    /^[A-Za-z0-9\s]\w{1,30}$/,
    "Inserire un username di lunghezza tra i 2 e 30 caratteri che non inizi con un numero\n",
  ],
  password: [
    "Password",
    /^[^\s]{4,}$/,
    "Inserire una password di almeno 4 caratteri\n",
  ],
  conferma: [
    "ConfermaPassword",
    /^[^\s]{4,}$/,
    "Le due password non coincidono\n",
  ],
};

//controllo che tutti i campi siano pieni e validi per poter premere il tasto registrati
function load() {
  let form = document.getElementById("form");

  form.addEventListener("submit", function (event) {
    if (!validazioneForm()) {
      event.preventDefault();
    }
  });

  for (var key in restrizioni) {
    var input = document.getElementById(key);

    if (input != null&&input.id != "conferma") {
      validazioneCampo(input);
    }
  }
}

//controllo validazione campo e aggiunta consiglio su come riempire campo
function validazioneCampo(input) {
  
  var parent = document.getElementById("aiuto" + restrizioni[input.id][0]);
  mostraErrore(input);

  if (parent.children.length == 2) {
    parent.removeChild(parent.children[1]);
  }

  if (
    input.value.search(restrizioni[input.id][1]) != 0 ||
    input.value == restrizioni[input.id][0]
  ) {
    return false;
  }

  if (input.id == "conferma" && !confirmPass()) {
    return false;
  }

  return true;
}

//controllo che password e conferma siano ugali
function confirmPass() {
  const password = document.querySelector("input[name=password]");
  const confirm = document.querySelector("input[name=conferma]");

  if (confirm.value === password.value) {
    return true;
  }
  return false;
}

//aggiunta dell'error/suggestion
function mostraErrore(input) {
  var parent = document.getElementById("aiuto" + restrizioni[input.id][0]);
  var messaggio = document.createElement("strong");
  
  if (input.id == "conferma" && !confirmPass()) {
      messaggio.className = "errorMessage";
  } else {
      messaggio.className = "suggestionMessage";
  }
  
  messaggio.id = "error" + restrizioni[input.id][0];
  messaggio.appendChild(document.createTextNode(restrizioni[input.id][2]));
  parent.appendChild(messaggio);
}

//controllo di tutti gli input nella form
function validazioneForm() {
  for (var key in restrizioni) {
    var input = document.getElementById(key);
    if (!validazioneCampo(input)) {
      return false;
    }
    if (input.id == "conferma" && !confirmPass(input)) {
      mostraErrore(input);
      return false;
    }
  }
  return true;
}

window.addEventListener("load", function () {
  load();
});
