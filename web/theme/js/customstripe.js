// web/theme/js/customstripe.js

var handler = StripeCheckout.configure({
  key: 'pk_test_eeAb1jAaE5nmIbHsMg9HGLHz',
  // image: {{ asset('theme/img/Louvre_Museum_icon.png') }},
  locale: 'auto',
  token: function(token) {
    // You can access the token ID with `token.id`.
    // Get the token ID to your server-side code for use.
  }
});

document.getElementById('myStripeButton').addEventListener('click', function(e) {
  // Open Checkout with further options:
  handler.open({
    name: 'Stripe.com',
    description: '2 widgets',
    zipCode: true,
    amount: 2000
  });
  e.preventDefault();
});

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});
