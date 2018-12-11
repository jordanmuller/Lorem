//Import Leaflet
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

export default class Map
{
    static init()
    {
        let map = document.querySelector('#map');
        if (null === map) {
            return;
        }

        // For the icon on map
        let icon = L.icon({
            iconUrl: '/images/marker-icon.png'
        });

        let center = [map.dataset.lat, map.dataset.lng];
        map = L.map('map').setView([map.dataset.lat, map.dataset.lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker(center, {icon: icon}).addTo(map)
            .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
            .openPopup();
    }
}