const slides = document.querySelectorAll(".slides img");
let indiceSlide = 0;

//aspetta che la pagina si carichi per far partire la creazione dello slider
document.addEventListener("DOMContentLoaded", inizzializzaSlider);
function inizzializzaSlider() {
  slides[indiceSlide].classList.add("slideVisibile");
}

//fa apparire l'immagine qunado si preme il tasto per cambiarla
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
}

//manda indietro di uno l'indice delle immagine per vedere la precedente
function slidePrecedente() {
  indiceSlide--;
  mostraSlide(indiceSlide);
}

//manda avanti di uno l'indice delle immagine per vedere la succesiva
function slideSuccesiva() {
  indiceSlide++;
  mostraSlide(indiceSlide);
}

function calcoloMedia()
{
  let valutazione=0;
  let voti=document.querySelectorAll('p[class^="valutazione-"]');
  for (let i = 0; i < voti.length; ++i) {
    valutazione+=parseInt(voti[i].className.slice(-1));
  }
  document.getElementsByClassName("valutazione")[0].innerHTML="Valutazione media: "+(valutazione/voti.length).toFixed(1)+" su 5";
}

//variabili per non perdere dati in caso di annulamento della modifica
let testo = "";
let voto = "";
let testModifica = "";
let parametri = new URLSearchParams(window.location.search);
let id = parametri.get('id');

//controlla quando un bottone viene premuto e ritorna la funzione apposita oppure non fa nulla in caso di nessun bottone premuto
document.getElementById("recensioneUtente").addEventListener("click", function (e) {
  const target = e.target.closest("button");
  if (!target) return;
  //per chiamate ai file php per creare e cancellare le recensioni
  let xhr = new XMLHttpRequest();
  //switch per decidere funzionalita' pulsante
  switch (target.id) {
    case "modifica":
      testo = document.getElementsByName("testoRecensione")[0].value;
      voto = document.getElementsByName("voto")[0].textContent.substring(6, 7);
      testModifica = "Recensione modificata con successo";
      document.getElementsByName("testoRecensione")[0].disabled = false;
      let bottoneAggiungi = document.createElement("button");
      bottoneAggiungi.setAttribute("id", "aggiungi");
      bottoneAggiungi.setAttribute("name", "aggiungiRecensione");
      bottoneAggiungi.setAttribute("type", "button");
      bottoneAggiungi.setAttribute("class", "button");
      bottoneAggiungi.innerHTML = "Invia";
      document
        .getElementsByName("modificaRecensione")[0]
        .replaceWith(bottoneAggiungi);

      let pOption = document.createElement("p");
      pOption.setAttribute("id", "testoOption");
      pOption.innerHTML = "Inserire una valutazione da 1 a 5:";
      document.getElementsByName("voto")[0].replaceWith(pOption);

      let select = document.createElement("select");
      select.setAttribute("id", "voto");
      select.setAttribute("name", "voto");
      select.setAttribute(
        "aria-label",
        "Scelta Multipla per il voto della recensione"
      );
      for (let i = 1; i <= 5; i++) {
        let opt = document.createElement("option");
        opt.value = i;
        opt.innerHTML = i;
        select.appendChild(opt);
      }
      document
        .getElementById("recensioneUtente")
        .insertBefore(
          select,
          document.getElementById("recensioneUtente").children[4]
        );

      let bottoneAnnulla = document.createElement("button");
      bottoneAnnulla.setAttribute("id", "annulla");
      bottoneAnnulla.setAttribute("name", "annullaRecensione");
      bottoneAnnulla.setAttribute("type", "button");
      bottoneAnnulla.setAttribute("class", "buttonRed");
      bottoneAnnulla.innerHTML = "Annulla";

      document
        .getElementsByName("cancellaRecensione")[0]
        .replaceWith(bottoneAnnulla);
      document.getElementsByName("testoRecensione")[0].focus();
      break;
    case "elimina":
      xhr.open("POST", "../cancellaRecensione.php");
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = function (data) {
        if(xhr.responseText==="Errore") window.location.pathname="error/500.html";
        if (xhr.responseText == "Recensione cancellata con successo") {
          document
            .getElementById("risultatoModifiche")
            .setAttribute("aria-live", "polite");
          document.getElementById("risultatoModifiche").textContent =
            xhr.responseText;
          document.getElementsByName("testoRecensione")[0].disabled = false;
          document.getElementsByName("testoRecensione")[0].value = "";
          let pOption = document.createElement("p");
          pOption.setAttribute("id", "testoOption");
          pOption.innerHTML = "Inserire una valutazione da 1 a 5:";
          document.getElementsByName("voto")[0].replaceWith(pOption);

          let select = document.createElement("select");
          select.setAttribute("id", "voto");
          select.setAttribute("name", "voto");
          select.setAttribute(
            "aria-label",
            "Scelta Multipla per il voto della recensione"
          );
          for (let i = 1; i <= 5; i++) {
            let opt = document.createElement("option");
            opt.value = i;
            opt.innerHTML = i;
            select.appendChild(opt);
          }
          document
            .getElementById("recensioneUtente")
            .insertBefore(
              select,
              document.getElementById("recensioneUtente").children[4]
            );

          let bottoneAggiungi = document.createElement("button");
          bottoneAggiungi.setAttribute("id", "aggiungi");
          bottoneAggiungi.setAttribute("name", "aggiungiRecensione");
          bottoneAggiungi.setAttribute("type", "button");
          bottoneAggiungi.setAttribute("class", "button");
          bottoneAggiungi.innerHTML = "Inserisci";
          document
            .getElementsByName("modificaRecensione")[0]
            .replaceWith(bottoneAggiungi);
          document.getElementsByName("cancellaRecensione")[0].remove();
          calcoloMedia();
        } else {
          document
            .getElementById("risultatoModifiche")
            .setAttribute("aria-live", "polite");
          document.getElementById("risultatoModifiche").textContent =
            xhr.responseText;
        }
        document.getElementsByName("testoRecensione")[0].focus();
      };
      let dataElimina = "id=" + id;

      xhr.send(dataElimina);
      break;
    case "aggiungi":
      
      xhr.open("POST", "../aggiungiRecensione.php");
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = function (data) {
        if(xhr.responseText==="Errore") window.location.pathname="error/500.html";
        if (xhr.responseText == "Recensione aggiunta con successo") {
          document
            .getElementById("risultatoModifiche")
            .setAttribute("aria-live", "polite");
          if (testModifica == "") {
            document.getElementById("risultatoModifiche").textContent =
              xhr.responseText;
          } else {
            document.getElementById("risultatoModifiche").textContent =
              testModifica;
          }
          document.getElementsByName("testoRecensione")[0].disabled = true;
          document.getElementById("testoOption").remove();

          let testoVoto = document.createElement("p");
          testoVoto.setAttribute(
            "class",
            "valutazione-" + document.getElementsByName("voto")[0].value
          );
          testoVoto.setAttribute("name", "voto");
          testoVoto.innerHTML =
            "Voto: " + document.getElementsByName("voto")[0].value + " su 5";
          document.getElementsByName("voto")[0].replaceWith(testoVoto);

          let bottoneModifica = document.createElement("button");
          bottoneModifica.setAttribute("id", "modifica");
          bottoneModifica.setAttribute("name", "modificaRecensione");
          bottoneModifica.setAttribute("type", "button");
          bottoneModifica.setAttribute("aria-label", "Modifica recensione");
          let immagineModifica = document.createElement("img");
          immagineModifica.setAttribute(
            "src",
            "../assets/pen-to-square-solid.svg"
          );
          immagineModifica.setAttribute("alt", "Modifica");
          bottoneModifica.appendChild(immagineModifica);
          document
            .getElementsByName("aggiungiRecensione")[0]
            .replaceWith(bottoneModifica);

          if (!document.querySelector("#elimina")) {
            let bottoneCancella = document.createElement("button");
            bottoneCancella.setAttribute("id", "elimina");
            bottoneCancella.setAttribute("name", "cancellaRecensione");
            bottoneCancella.setAttribute("type", "button");
            bottoneCancella.setAttribute("aria-label", "Elimina recensione");
            let immagineCancella = document.createElement("img");
            immagineCancella.setAttribute("src", "../assets/trash-solid.svg");
            immagineCancella.setAttribute("alt", "Elimina");
            bottoneCancella.appendChild(immagineCancella);
            document.getElementById("recensioneUtente").append(bottoneCancella);
          }
          if (document.querySelector("#annulla")) {
            document.getElementById("annulla").remove();
          }
          calcoloMedia();
        } else {
          document
            .getElementById("risultatoModifiche")
            .setAttribute("aria-live", "polite");
          document.getElementById("risultatoModifiche").textContent =
            xhr.responseText;
        }
        document.getElementsByName("testoRecensione")[0].focus();
      };
      let dataAggiungi =
        "id=" +
        id +
        "&voto=" +
        document.getElementsByName("voto")[0].value +
        "&testo=" +
        document.getElementsByName("testoRecensione")[0].value;

      if(document.getElementsByName('testoRecensione')[0].value.trim()!="")
      {
        xhr.send(dataAggiungi);
      }
      else
      {
        document.getElementsByName('testoRecensione')[0].placeholder="La recensione deve avere contenuto";
      }
      
        
      break;
    case "annulla":
      document.getElementsByName("testoRecensione")[0].value = testo;
      document.getElementsByName("testoRecensione")[0].disabled = true;
      document.getElementById("testoOption").remove();

      let bottoneModifica = document.createElement("button");
      bottoneModifica.setAttribute("id", "modifica");
      bottoneModifica.setAttribute("name", "modificaRecensione");
      bottoneModifica.setAttribute("type", "button");
      bottoneModifica.setAttribute("aria-label", "Modifica recensione");

      let immagineModifica = document.createElement("img");
      immagineModifica.setAttribute("src", "../assets/pen-to-square-solid.svg");
      immagineModifica.setAttribute("alt", "Modifica");
      bottoneModifica.appendChild(immagineModifica);
      document
        .getElementsByName("aggiungiRecensione")[0]
        .replaceWith(bottoneModifica);

      let bottoneCancella = document.createElement("button");
      bottoneCancella.setAttribute("id", "elimina");
      bottoneCancella.setAttribute("name", "cancellaRecensione");
      bottoneCancella.setAttribute("type", "button");
      bottoneCancella.setAttribute("aria-label", "Elimina recensione");
      let immagineCancella = document.createElement("img");
      immagineCancella.setAttribute("src", "../assets/trash-solid.svg");
      immagineCancella.setAttribute("alt", "Elimina");
      bottoneCancella.appendChild(immagineCancella);
      document
        .getElementsByName("annullaRecensione")[0]
        .replaceWith(bottoneCancella);

      let testoVoto = document.createElement("p");
      testoVoto.setAttribute(
        "class",
        "valutazione-" + document.getElementsByName("voto")[0].value
      );
      testoVoto.setAttribute("name", "voto");
      testoVoto.innerHTML = "Voto: " + voto + " su 5";
      document.getElementsByName("voto")[0].replaceWith(testoVoto);
      testo = "";
      voto = "";
      testModifica = "";

      document.getElementsByName("testoRecensione")[0].focus();
      break;
  }
});
