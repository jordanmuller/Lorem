/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
const $ = require('jquery');
require('../css/app.css');

require('select2');

$('select').select2();

// Delete of Picture
document.querySelectorAll('[data-delete]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        fetch(link.getAttribute('href'), {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'_token': link.dataset.token})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // On récupère le parent du parent du lien pour supprimer le parent du lien
                    link.parentNode.parentNode.removeChild(link.parentNode)
                } else {
                    alert(data.error);
                }
            })
            .catch(e => alert(e));
    });
});

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');

console.log('Hello Encore! Edit me in assets/js/app.js');
