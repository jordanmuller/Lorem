// Import Algolia Places => auto-completion of lat and lng
import Places from 'places.js';

import Map from './modules/map';
import 'slick-carousel';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

Map.init();

// /!\ L'id vient du PropertyType généré par Symfony !!!
let inputAddress = document.querySelector('#property_address');

if (null !== inputAddress) {
    let place = Places({
        container: inputAddress
    })
    place.on('change', e => {
        document.querySelector('#property_city').value = e.suggestion.city;
        document.querySelector('#property_postal_code').value = e.suggestion.postcode;
        document.querySelector('#property_lat').value = e.suggestion.latlng.lat;
        document.querySelector('#property_lng').value = e.suggestion.latlng.lng;
    });
}

let searchAddress = document.querySelector('#search_address');

if (null !== searchAddress) {
    let place = Places({
        container: searchAddress
    })
    place.on('change', e => {
        document.querySelector('#lat').value = e.suggestion.latlng.lat;
        document.querySelector('#lng').value = e.suggestion.latlng.lng;
    });
}

const $ = require('jquery');
require('../css/app.css');
require('select2');

// Enable slider
$('[data-slider]').slick({
    dots: true,
    arrows: true
});

$('select').select2();

console.log('Test Success');
