// function updateCartBadge() {
//     fetch('cart_count.php', { cache: 'no-store' })
//         .then(response => response.text())
//         .then(text => {
//             text = text.trim(); 

//             const count = Number(text); 

//             if (isNaN(count)) {
//                 console.error('Cart count is NaN:', text);
//                 return;
//             }

//             const badge = document.getElementById('cartBadge');
//             if (!badge) return;

//             badge.textContent = count;

//             if (count > 0) {
//                 badge.classList.remove('badge-empty');
//                 badge.classList.add('badge-active');
//             } else {
//                 badge.classList.remove('badge-active');
//                 badge.classList.add('badge-empty');
//             }
//         })
//         .catch(err => console.error('Cart badge error:', err));
// }


// /* Run once page loads */
// document.addEventListener('DOMContentLoaded', updateCartBadge);
