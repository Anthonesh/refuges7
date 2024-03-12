//Carousel Animation

// Attend que le contenu du document soit complètement chargé avant d'exécuter le code
document.addEventListener('DOMContentLoaded', function() {

    // Sélectionne le carrousel et ses éléments internes pour manipulation
    const carousel = document.getElementById('carousel');
    // Convertit la collection d'éléments HTML en un tableau pour faciliter les manipulations
    const items = Array.from(carousel.getElementsByClassName('carousel-img-container'));
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');

    // Assure qu'un élément est sélectionné par défaut si aucun ne l'est déjà
    if (!carousel.querySelector('.selected')) {
    items[0].classList.add('selected');
    }

    // Fonction pour mettre à jour les positions des éléments du carrousel
    function updateCarouselPositions() {
    // Trouve l'élément actuellement sélectionné
    const selected = carousel.querySelector('.selected');
    // Obtient l'index de l'élément sélectionné dans le tableau
    const selectedIndex = items.indexOf(selected);

    // Applique des classes CSS en fonction de la position relative de chaque élément par rapport à l'élément sélectionné
    items.forEach((item, index) => {
        // Supprime toutes les classes CSS précédemment ajoutées pour la gestion du carrousel
        item.classList.remove('selected', 'prev', 'next', 'hideLeft', 'hideRight', 'prevLeftSecond', 'nextRightSecond');

        // Applique la classe 'selected' à l'élément actuellement sélectionné
        if (index === selectedIndex) {
        item.classList.add('selected');
        } else if (index === selectedIndex - 1 || index === selectedIndex + items.length - 1) {
        // Positionne l'élément précédent immédiat à gauche
        item.classList.add('prev');
        } else if (index === selectedIndex + 1 || index === selectedIndex - items.length + 1) {
        // Positionne l'élément suivant immédiat à droite
        item.classList.add('next');
        } else if (index === selectedIndex - 2 || index === selectedIndex + items.length - 2) {
        // Positionne le deuxième élément précédent encore plus à gauche
        item.classList.add('prevLeftSecond');
        } else if (index === selectedIndex + 2 || index === selectedIndex - items.length + 2) {
        // Positionne le deuxième élément suivant encore plus à droite
        item.classList.add('nextRightSecond');
        } else if (index < selectedIndex) {
        // Cache les éléments situés à gauche de l'élément sélectionné
        item.classList.add('hideLeft');
        } else {
        // Cache les éléments situés à droite de l'élément sélectionné
        item.classList.add('hideRight');
        }
    });
    }

    // Gestion de l'événement de clic sur le bouton précédent
    prevButton.addEventListener('click', () => {
    const selectedIndex = items.indexOf(carousel.querySelector('.selected'));
    // Calcul de l'index de l'élément précédent en tenant compte de la circularité
    const prevIndex = (selectedIndex - 1 + items.length) % items.length;
    items[selectedIndex].classList.remove('selected');
    items[prevIndex].classList.add('selected');
    updateCarouselPositions();
    });

    // Gestion de l'événement de clic sur le bouton suivant
    nextButton.addEventListener('click', () => {
    const selectedIndex = items.indexOf(carousel.querySelector('.selected'));
    // Calcul de l'index de l'élément suivant en tenant compte de la circularité
    const nextIndex = (selectedIndex + 1) % items.length;
    items[selectedIndex].classList.remove('selected');
    items[nextIndex].classList.add('selected');
    updateCarouselPositions();
    });

    // Initialisation des positions du carrousel lors du chargement de la page
    updateCarouselPositions();


    //Menu Burger

    // Ajouter l'écouteur d'événements au bouton du menu burger
    document.addEventListener('click', function(e) {
    let links = document.querySelector('.navLinks');
    let burgerMenuButton = document.querySelector('.burger-menu');

    // Vérifie si le clic n'était ni sur le burger-menu ni sur un descendant de navLinks
    if (!burgerMenuButton.contains(e.target) && !links.contains(e.target)) {
        // Si navLinks est actif, le désactiver et afficher le burger-menu
        if (links.classList.contains('active')) {
            links.classList.remove('active');
            burgerMenuButton.style.display = 'block';
        }
    }
    });

    //Bouton de dons cliquable
    let donsButton = document.querySelector('.donButton');
    donsButton.addEventListener('click', function() {
        window.location.href = '/dons'; 
    });

});


// Menu Burger

function toggleMenu() {
    let links = document.querySelector('.navLinks');
    links.classList.toggle('active');
    // Ajuste la visibilité du bouton burger en fonction de l'état du menu
    document.querySelector('.burger-menu').style.display = links.classList.contains('active') ? 'none' : 'block';
    };

    //Toggle Aside
    document.addEventListener('click', function(e) {
    // Ajouter l'écouteur d'événements au bouton aside
        let asideToggleButton = document.querySelector('.aside-toggle');
        if (asideToggleButton) {
            asideToggleButton.addEventListener('touchstart', toggleAside);
            asideToggleButton.addEventListener('click', toggleAside); // Pour la compatibilité avec le clic
        }
    });

    
// Aside cliquable

function toggleAside() {

    let aside = document.querySelector('.aside');

    if (aside.style.display === "block") {
        aside.style.display = "none";
    } else {
        aside.style.display = "block";
    }
}



