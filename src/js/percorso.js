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