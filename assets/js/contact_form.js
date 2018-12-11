const contactButton = document.querySelector('#contactButton');
const contactForm = document.querySelector('#contactForm');

contactButton.addEventListener('click', (e) => {
    e.preventDefault();
    contactForm.style.display = 'block';
    contactButton.style.display = 'none';
})