let restrizioni = {
  "username": [
    "Username",
    /^[A-Za-z\s]\w{2,30}$/,
    "Inserire un username di lunghezza tra i 2 e 30 caratteri"
  ],
  "email": [
    "Indirizzo mail",
    /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
    "Inserire un indirizzo mail corretto"
  ],
  "password": [
    "Password",
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$.,-;:<>!%*?&_=])[A-Za-z\d@$.,-;:<>!%*?&_=]{8,16}$/,
    "Inserire una password di almeno 8 caratteri, di cui: uno minuscolo, uno maiuscolo, un numero ed un carattere speciale"
  ],
  "confirm": [
    "Password",
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$.,-;:<>!%*?&_=])[A-Za-z\d@$.,-;:<>!%*?&_=]{8,16}$/,
    "Le due password non coincidono"
  ]
};



//controllo che tutti i campi siano pieni e validi per poter premere il tasto registrati
function load()
{
  let form =document.getElementById("form");

  form.addEventListener("submit",function (event){
      if(!validazioneForm())
      {
          event.preventDefault();
      }
  })

  for (var key in restrizioni) {
      var input = document.getElementById(key);
      if(input!=null){
        campoDefault(input);
        input.onfocus = function () {
          campoPerInput(this);
        };
        input.onblur = function () {
          validazioneCampo(this);
        };
      }
        
    }
}

//imposta il placeholder degli input nella pagina registrati
function campoDefault(input) {
  if (input.value == "" && document.title!="Accedi") {
    input.classname = "";
    input.value = restrizioni[input.id][0];
  }
}

//tolgo placholder quando premuto fieldset 
function campoPerInput(input) {
if (input.value == restrizioni[input.id][0]) {
    input.classname = "";
    input.value = "";
}
}

//controllo validazione campo e aggiunta consiglio su come riempire campo
function validazioneCampo(input) {
  var parent = input.parentNode;

  if (parent.children.length == 2) {
      parent.removeChild(parent.children[1]);
  }

  if (input.value.search(restrizioni[input.id][1]) != 0 || input.value == restrizioni[input.id][0]) {
    mostraErrore(input);
    return false;
  }

  if (input.id == "conferma" && !confirmPass()) {
    mostraErrore(input);
    return false;
  }

  return true;
}


//controllo che password e conferma siano ugali
function confirmPass() {
  const password = document.querySelector('input[name=password]');
  const confirm = document.querySelector('input[name=conferma]');

  if (confirm.value === password.value) {
    return true
  }
  return false;
}

//aggiunta dell' error suggestion
function mostraErrore(input) {
  var parent = input.parentNode;
  var errore = document.createElement("strong");
  errore.className = "errorSuggestion";
  errore.appendChild(document.createTextNode(restrizioni[input.id][2]));
  parent.appendChild(errore);
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

window.addEventListener('load', function(){
  load();
})