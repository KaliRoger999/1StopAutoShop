const hamburger = document.getElementById('hamburger');
const navbars = document.getElementById('navbars');

hamburger.addEventListener('click', (event) => {
    navbars.classList.toggle('show');
});

document.addEventListener('click', (event) => {
    if (!navbars.contains(event.target) && !hamburger.contains(event.target)) {
        navbars.classList.remove('show');
    }
});
