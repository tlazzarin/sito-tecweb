const slides=document.querySelectorAll(".slides img");
let indiceSlide=0;

document.addEventListener("DOMContentLoaded",inizzializzaSlider);
function inizzializzaSlider(){
    slides[indiceSlide].classList.add("slideVisibile");
    
}

function mostraSlide(indice){
    if(indice>=slides.length){
        indiceSlide=0;
    }
    else if(indice<0)
    {
        indiceSlide=slides.length-1;
    }


    slides.forEach(slide=>{
        slide.classList.remove("slideVisibile");
    });
    slides[indiceSlide].classList.add("slideVisibile");
}

function slidePrecedente(){
    indiceSlide--;
    mostraSlide(indiceSlide);
}

function slideSuccesiva(){
    indiceSlide++;
    mostraSlide(indiceSlide);
}


let testo="";
let voto="";
let testModifica="";
$(document).ready(function(){
    $(document).on('click','#modifica',function(){
        testo=$('[name="testoRecensione"]').val();
        voto=$('[name="voto"]').text().substring(6,7);
        testModifica="Recensione modificata con successo";
        $('[name="testoRecensione"]').prop("disabled", false);
        $('[name="voto"]').replaceWith('<p id="testoOption" >Inserire una valutazione da 1 a 5:</p> <select aria-label="Scelta Multipla per il voto della recensione" id="voto" name="voto"> <option value="5">5</option> <option value="4">4</option> <option value="3">3</option> <option value="2">2</option> <option value="1">1</option> </select>');
        $('[name="modificaRecensione"]').replaceWith('<button id=aggiungi name="aggiungiRecensione" type="button" class="button">Invia</button>');
        $('[name="cancellaRecensione"]').replaceWith('<button id=annulla name="annullaRecensione" type="button" class="buttonRed">Annulla</button>');
        $('[name="testoRecensione"]').focus();
    });

    $(document).on('click','#elimina',function(){
        $.post("cancellaRecensione.php",{
            id:window.location.search.substring(4)
        }, function(data,status){
            if(data=="Recensione cancellata con successo"&&status)
            {
                $('#risultatoModifiche').attr('aria-live','polite');
                $('#risultatoModifiche').text(data);
                $('[name="testoRecensione"]').prop("disabled", false);
                $('[name="testoRecensione"]').val("");
                $('[name="voto"]').replaceWith('<p id="testoOption" >Inserire una valutazione da 1 a 5:</p> <select aria-label="Scelta Multipla per il voto della recensione" id="voto" name="voto"> <option value="5">5</option> <option value="4">4</option> <option value="3">3</option> <option value="2">2</option> <option value="1">1</option> </select>');
                $('[name="modificaRecensione"]').replaceWith('<button id=aggiungi name="aggiungiRecensione" type="button" class="button">Inserisci</button>');
                $('[name="cancellaRecensione"]').remove();
            }
            else
            {
                $('#risultatoModifiche').attr('aria-live','polite');
                $('#risultatoModifiche').text(data);
            }
            $('[name="testoRecensione"]').focus();
        });

    });

    $(document).on('click','#aggiungi',function(){
        $.post("aggiungiRecensione.php",{
            id: window.location.search.substring(4),
            voto: $('[name="voto"]').find(":selected").val(),
            testo: $('[name="testoRecensione"]').val()
        }, function(data,status){
            if(data=="Recensione aggiunta con successo"&&status)
            {
                $('#risultatoModifiche').attr('aria-live','polite');
                if(testModifica=="")
                    $('#risultatoModifiche').text(data);
                else
                {
                    $('#risultatoModifiche').text(testModifica);
                    testModifica="";
                }
                $('[name="testoRecensione"]').prop("disabled", true);
                $('[name="voto"]').replaceWith('<p name="voto" class="valutazione-'+$('[name="voto"]').find(":selected").val()+'">Voto: '+$('[name="voto"]').find(":selected").val()+' su 5</p>');
                $('[name="aggiungiRecensione"]').replaceWith('<button name="modificaRecensione" type="button" id="modifica" aria-label="Modifica recensione"><img src="./assets/pen-to-square-solid.svg" alt="Modifica"></button>');
                if($('[name="cancellaRecensione"]').length==0)
                {
                    $('[class="recensione"]').first().append('<button name="cancellaRecensione" type="button" id="elimina" aria-label="Elimina recensione"><img src="./assets/trash-solid.svg" alt="Elimina"></button>')
                }
                if($('[name="annullaRecensione"]').length!=0)
                {
                    $('[name="annullaRecensione"]').remove();
                }
                $('#testoOption').remove();
            }
            else
            {
                $('#risultatoModifiche').attr('aria-live','polite');
                $('#risultatoModifiche').text(data);
            }
            $('[name="testoRecensione"]').focus();
        });
    });

    $(document).on('click','#annulla',function(){
        $('[name="testoRecensione"]').val(testo);
        $('[name="testoRecensione"]').prop("disabled", true);
        $('#testoOption').remove();
        $('[name="aggiungiRecensione"]').replaceWith('<button name="modificaRecensione" type="button" id="modifica" aria-label="Modifica recensione"><img src="./assets/pen-to-square-solid.svg" alt="Modifica"></button>');
        $('[name="annullaRecensione"]').replaceWith('<button name="cancellaRecensione" type="button" id="elimina" aria-label="Elimina recensione"><img src="./assets/trash-solid.svg" alt="Elimina"></button>');
        $('[name="voto"]').replaceWith('<p name="voto" class="valutazione-"'+voto+'">Voto: '+voto+' su 5</p>');
        $('[name="testoRecensione"]').focus();
    });
});