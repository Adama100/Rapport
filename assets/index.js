// Bootstrap
// ==========
import Button from 'bootstrap/js/src/button'
import Collapse from 'bootstrap/js/src/collapse'
import Alert from 'bootstrap/js/src/alert'
import Carousel from 'bootstrap/js/src/carousel'
import Dropdown from 'bootstrap/js/src/dropdown'
import Modal from 'bootstrap/js/src/modal'
import Offcanvas from 'bootstrap/js/src/offcanvas'
import Tab from 'bootstrap/js/src/tab'



// Elements
// ==========
import Tabs from "./elements/Tabs"

// Custom Elements
// ================
customElements.define('nav-tabs', Tabs)


$(document).ready(function () {
    $('#table').DataTable({
        "language": {
            "sProcessing": "Traitement en cours...",
            "sSearch": "Rechercher&nbsp;:",
            "sLengthMenu": "Afficher _MENU_ éléments",
            "sInfo": "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty": "Affichage de 0 à 0 sur 0 éléments",
            "sInfoFiltered": "(filtré à partir de _MAX_ éléments au total)",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords": "Aucun élément à afficher",
            "sEmptyTable": "Aucune donnée disponible dans le tableau",
            "oPaginate": {
                "sFirst": "Premier",
                "sPrevious": "Précédent",
                "sNext": "Suivant",
                "sLast": "Dernier"
            },
            "oAria": {
                "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });
});


// "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"