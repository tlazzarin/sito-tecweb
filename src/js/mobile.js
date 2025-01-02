document.addEventListener("DOMContentLoaded", () => {    
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    hamburger.addEventListener("click", () => {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
        hamburger.classList.remove('active');
        navMenu.classList.remove('active');
    }));

    /* Per chiudere il menu cliccando fuori dall'area del menu */
    document.addEventListener("click", (e) => {
        const isClickInside = hamburger.contains(e.target) || navMenu.contains(e.target);
    
        if (!isClickInside) {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        }
    });
});

