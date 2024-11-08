import './bootstrap';
$( '.form-select' ).select2( {
    dropdownParent: $( '.form-select' ).closest('.modal'),
    theme: 'bootstrap-5',
    language: "fr"
} );