const slides = document.querySelectorAll(".slides img");
let indiceSlide = 0;

//aspetta che la pagina si carichi per far partire la creazione dello slider
document.addEventListener("DOMContentLoaded", inizzializzaSlider);
function inizzializzaSlider() {
  slides[indiceSlide].classList.add("slideVisibile");
}

//fa apparire l'immagine quando si preme il tasto per cambiarla
function mostraSlide(indice) {
  if (indice >= slides.length) {
    indiceSlide = 0;
  } else if (indice < 0) {
    indiceSlide = slides.length - 1;
  }

  slides.forEach((slide) => {
    slide.classList.remove("slideVisibile");
  });
  slides[indiceSlide].classList.add("slideVisibile");
  slides[indiceSlide].focus();
}

//manda indietro di uno l'indice dell' immagine per vedere la precedente
function slidePrecedente() {
  indiceSlide--;
  mostraSlide(indiceSlide);
}

//manda avanti di uno l'indice dell' immagine per vedere la succesiva
function slideSuccesiva() {
  indiceSlide++;
  mostraSlide(indiceSlide);
}

function focusOut(){
  if(!document.getElementsByName('testoRecensione')[0].validity.valid)
      document.getElementById("textArea-errore").classList.remove("hidden");
    else
      document.getElementById("textArea-errore").classList.add("hidden");
}

//variabili per non perdere dati in caso di annulamento della modifica
let testo = "";
let voto = "";
let testoModifica = "";
let parametri = new URLSearchParams(window.location.search);
let id = parametri.get('id');

//funzione che si attiva quando il bottone modifica viene premuto
function modificaFunzione()
{
  document.getElementById("textArea-errore").classList.add("hidden");
    testo = document.getElementsByName("testoRecensione")[0].value;
    voto = document.getElementsByName("voto")[0].textContent.substring(6, 7);
    testoModifica = "Recensione modificata con successo";
    document.getElementsByName("testoRecensione")[0].disabled = false;
    document.getElementsByName("modificaRecensione")[0].remove();
    document.getElementsByName("voto")[0].remove();
    document.getElementsByName("cancellaRecensione")[0].remove();
    
    document.getElementById("recensioneUtente").innerHTML+='<label for="voto" id="testoOption">Inserire una valutazione da 1 a 5<abbr title=\"Obbligatorio\">*</abbr></label>';
    document.getElementById("recensioneUtente").innerHTML+='<select id="voto" name="voto" aria-label="Scelta Multipla per il voto della recensione"></select>';
    for (let i = 5; i > 0; i--) {
      
      if(voto==i)
        document.getElementById("voto").innerHTML+='<option value="'+i+'" selected>'+i+'</option>';
      else
        document.getElementById("voto").innerHTML+='<option value="'+i+'">'+i+'</option>';
    }
    document.getElementById("recensioneUtente").innerHTML+="<button id=\"aggiungi\" name=\"aggiungiRecensione\" type=\"submit\" class=\"button\">Invia</button>";
    document.getElementById("recensioneUtente").innerHTML+="<button id=\"annulla\" name=\"annullaRecensione\" type=\"button\" onClick=\"annullaFunzione()\" class=\"button danger\">Annulla</button>";
    document.getElementsByName("testoRecensione")[0].focus();
}

//funzione che si attiva quando il bottone annulla viene premuto
function annullaFunzione()
{
  document.getElementById("textArea-errore").classList.add("hidden");
    document.getElementsByName("testoRecensione")[0].value = testo;
      document.getElementsByName("testoRecensione")[0].disabled = true;
      document.getElementById("testoOption").remove();
      document.getElementById("voto").remove();
      document.getElementById("aggiungi").remove();
      document.getElementById("annulla").remove();

      document.getElementById("recensioneUtente").innerHTML+='<p for="voto" class="valutazione-' + voto+'" name="voto">Voto: ' + voto + ' su 5</p>';
      document.getElementById("recensioneUtente").innerHTML+=
      "<button name=\"modificaRecensione\" type=\"button\" id=\"modifica\" onClick=\"modificaFunzione()\" aria-label=\"Modifica recensione\"><img src=\"./assets/pen-to-square-solid.svg\" alt=\"Modifica\"></button>";
      document.getElementById("recensioneUtente").innerHTML+=
      "<button name=\"cancellaRecensione\" type=\"submit\" id=\"elimina\" aria-label=\"Elimina recensione\"><img src=\"./assets/trash-solid.svg\" alt=\"Elimina\"></button>";
      testo = "";
      voto = "";
      testoModifica = "";

      document.getElementsByName("testoRecensione")[0].focus();
}



//controlla quando la form viene inviata
document.getElementById("recensioneUtente").addEventListener("submit", function (event) {
  const target = document.querySelector("button[type=submit]");
  event.preventDefault();
  //per chiamate ai file php per creare e cancellare le recensioni
  let xhr = new XMLHttpRequest();
  
  //switch per decidere funzionalita' pulsante
  if(target.id=="elimina") {
      xhr.open("POST", "../cancellaRecensione.php");
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = function () {
        const response=JSON.parse(xhr.responseText);
        if(response[0]==="Errore") window.location.pathname="error/500.html";
        if (response[0] == "Recensione cancellata con successo") {
          document
            .getElementById("risultatoModifiche")
            .setAttribute("aria-live", "polite");
          document.getElementById("risultatoModifiche").textContent =response[0];
          document.getElementsByName("testoRecensione")[0].disabled = false;
          document.getElementsByName("testoRecensione")[0].textContent = "";
          document.getElementById("textArea-errore").classList.add("hidden");

          document.getElementsByName("voto")[0].remove();
          document.getElementById("modifica").remove();
          document.getElementById("elimina").remove();

          document.getElementById("recensioneUtente").innerHTML+='<label for="voto" id="testoOption">Inserire una valutazione da 1 a 5<abbr title=\"Obbligatorio\">*</abbr></label>';
          document.getElementById("recensioneUtente").innerHTML+='<select id="voto" name="voto" aria-label="Scelta Multipla per il voto della recensione"></select>';
          for (let i = 5; i > 0; i--) {
            document.getElementById("voto").innerHTML+='<option value="'+i+'">'+i+'</option>';
          }
          document.getElementById("recensioneUtente").innerHTML+="<button id=\"aggiungi\" name=\"aggiungiRecensione\" type=\"submit\" class=\"button\">Inserisci</button>";
          document.getElementsByClassName("valutazione")[0].innerHTML="Valutazione media: "+response[1]+" su 5";
        } else {
          document
            .getElementById("risultatoModifiche")
            .setAttribute("aria-live", "polite");
          document.getElementById("risultatoModifiche").textContent =
          response[0];
        }
        document.getElementsByName("testoRecensione")[0].focus();
      };
      let dataElimina = "id=" + id;

      xhr.send(dataElimina);
    }
    else
    {
      xhr.open("POST", "../aggiungiRecensione.php");
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = function () {
        const response=JSON.parse(xhr.responseText);
        if(response[0]==="Errore") window.location.pathname="error/500.html";
        if (response[0] == "Recensione aggiunta con successo") {
          document
            .getElementById("risultatoModifiche")
            .setAttribute("aria-live", "polite");
          if (testoModifica == "") {
            document.getElementById("risultatoModifiche").textContent =
            response[0];
          } else {
            document.getElementById("risultatoModifiche").textContent =
              testoModifica;
          }
          document.getElementById("textArea-errore").classList.add("hidden");
          document.getElementsByName("testoRecensione")[0].disabled = true;
          document.getElementById("testoOption").remove();
          let valutazione=document.getElementsByName("voto")[0].value;
          document.getElementById("voto").remove();
          document.getElementById("aggiungi").remove();

          document.getElementById("recensioneUtente").innerHTML+='<p for="voto" class="valutazione-' + valutazione+'" name="voto">Voto: ' + valutazione + ' su 5</p>';
          document.getElementById("recensioneUtente").innerHTML+=
          "<button name=\"modificaRecensione\" type=\"button\" id=\"modifica\" onClick=\"modificaFunzione()\"  aria-label=\"Modifica recensione\"><img src=\"./assets/pen-to-square-solid.svg\" alt=\"Modifica\"></button>";

          if (!document.querySelector("#elimina")) {
            document.getElementById("recensioneUtente").innerHTML+=
            "<button name=\"cancellaRecensione\" type=\"submit\" id=\"elimina\" aria-label=\"Elimina recensione\"><img src=\"./assets/trash-solid.svg\" alt=\"Elimina\"></button>";
          }
          if (document.querySelector("#annulla")) {
            document.getElementById("annulla").remove();
          }
          if(response[1]!=null)
          {
            document.getElementsByClassName("valutazione")[0].innerHTML="Valutazione media: "+response[1]+" su 5";
          }
        } else {
          document
            .getElementById("risultatoModifiche")
            .setAttribute("aria-live", "polite");
          document.getElementById("risultatoModifiche").textContent =
            response[0];
        }
        document.getElementsByName("testoRecensione")[0].focus();
      };
      let dataAggiungi ="id=" +id +"&voto=" +document.getElementsByName("voto")[0].value +"&testo=" +document.getElementsByName("testoRecensione")[0].value;
        
      if(document.getElementsByName('testoRecensione')[0].value.trim()!="")
        {
          xhr.send(dataAggiungi);
          let text=document.getElementsByName("testoRecensione")[0].value;
          document.getElementsByName("testoRecensione")[0].textContent=text;
        }
        else
        {
          document.getElementById("textArea-errore").classList.remove("hidden");
          document.getElementsByName("testoRecensione")[0].focus();
        }
    }

});
