document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.querySelector('.mobile-navigation-toggle');
    const closeButton = document.querySelector('.mobile-navigation-close');
    const mobileMenu = document.querySelector('.mobile-navigation-menu');

 if(toggleButton) {   toggleButton.addEventListener('click', function() {
        mobileMenu.classList.add('open');
        closeButton.style.display = 'block';
    });
}
if(closeButton ) {
    closeButton.addEventListener('click', function() {
        mobileMenu.classList.remove('open');
        closeButton.style.display = 'none';
    });
}
});