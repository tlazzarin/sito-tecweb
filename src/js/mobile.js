document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.querySelector('#hamburger');
    const img = document.querySelector('#hamburger>img');
    const navMenu = document.querySelector('.nav-menu');
    const navItem = document.querySelectorAll('.nav-item>a');
    hamburger.classList.remove('active');
    navMenu.classList.remove('active');

    // invocata per aprire - chiudere il menu
    hamburger.addEventListener("click", () => {
        navMenu.classList.toggle('active');
        hamburger.classList.toggle('active');
        if (hamburger.classList.contains('active')) {
            aperto();
        }
        else {
            chiuso();
        }

    });

    /* Per chiudere il menu cliccando fuori dall'area del menu */
    document.addEventListener("click", (e) => {
        const isClickInside = hamburger.contains(e.target) || navMenu.contains(e.target);
        if (!isClickInside) {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
            chiuso();
        }
    });

    /* Per chiudere il menu quando elementi esterni alla navbar prendono il focus */
    document.addEventListener("focusin", voceFocusEsterna);
    function voceFocusEsterna(e) {
        const isFocusInside = hamburger.contains(e.target) || navMenu.contains(e.target);
        if (!isFocusInside) {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
            chiuso();
        }
    }       

    /* Per aprire il menu una volta che una voce ha il focus */
    navItem.forEach(item => item.addEventListener("focusin", voceFocusInterna));
    function voceFocusInterna() {
        navMenu.classList.toggle('active');
        hamburger.classList.toggle('active');
        aperto();
    };


    /* icone con menu aperto */
    function aperto() {
        hamburger.setAttribute('aria-label', 'Chiudi menu');
        img.setAttribute('src', './assets/xmark-solid.svg');
        img.setAttribute('alt', 'Chiudi menu');
        navItem.forEach(item => item.removeEventListener("focusin", voceFocusInterna));;
    }
    /* icone con menu chiuso */
    function chiuso() {
        hamburger.setAttribute('aria-label', 'Apri menu');
        img.setAttribute('src', './assets/bars-solid.svg');
        img.setAttribute('alt', 'Apri menu');
        navItem.forEach(item => item.addEventListener("focusin", voceFocusInterna));
    }
});

