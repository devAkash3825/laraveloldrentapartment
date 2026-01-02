
document.getElementById('search').addEventListener('blur', function() {
document.getElementById('client-search-form').submit();
});
document.getElementById('search').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        document.getElementById('client-search-form').submit();
    }
});
// document.addEventListener('DOMContentLoaded', function() {
//     const tabButtons = document.querySelectorAll('.tab-button');
//     const tabContents = document.querySelectorAll('.tab-content');

//     function openTab(tabName) {
//         tabContents.forEach(content => {
//             content.classList.remove('active', 'show');
//         });
//         tabButtons.forEach(button => {
//             button.classList.remove('active');
//         });

//         document.getElementById(tabName).classList.add('active', 'show');
//         document.querySelector(`.tab-button[data-tab="${tabName}"]`).classList.add('active');
//     }

//     tabButtons.forEach(button => {
//         button.addEventListener('click', function() {
//             openTab(this.getAttribute('data-tab'));
//         });
//     });

//     // Set default active tab
//     openTab('maindetail');
// });



// document.addEventListener("DOMContentLoaded", function() {
//     const tabButtons = document.querySelectorAll('.tab-button');
//     const tabContents = document.querySelectorAll('.tab-content');

//     function checkIsFav() {
//         const favoriteButton = document.getElementById('favoriteButton');
//         const propertyId = favoriteButton.getAttribute('data-property-id');
//         const renterId = favoriteButton.getAttribute('data-renter-id');
//         fetch('/admin/property/is-favorite', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
//                         'content')
//                 },
//                 body: JSON.stringify({
//                     propertyId: propertyId,
//                     renterId: renterId
//                 })
//             })
//             .then(response => response.json())
//             .then(data => {
//                 const favoriteIcon = document.getElementById('isfav');
//                 if (data.isFavorite == true) {
//                     favoriteIcon.classList.add('favorited');
//                 } else {
//                     favoriteIcon.classList.remove('favorited');
//                 }
//             });
//     }


//     function openTab(tabName) {
//         tabContents.forEach(content => {
//             content.classList.remove('active');
//         });
//         tabButtons.forEach(button => {
//             button.classList.remove('active');
//         });

//         document.getElementById(tabName).classList.add('active');
//         document.querySelector(`.tab-button[data-tab="${tabName}"]`).classList.add('active');
//     }

//     tabButtons.forEach(button => {
//         button.addEventListener('click', function() {
//             openTab(this.getAttribute('data-tab'));
//         });
//     });

//     openTab('favoritetab');
//     checkIsFav();
// });
