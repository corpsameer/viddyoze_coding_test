/**
 * This function will decrement corresponding product quantity on shop and cart pages.
 * The function gets the current quantity.
 * It will then decrement the current value and check if it is greater than 0.
 * If the condition is true, the decremented value is assigned to product quantity field.
 *
 */
function decrementProductQuantity(element) {
  var productCode = $(element).data('product_code');
  var value = $('#product_quantity_' + productCode).val(); //Current quantity of the corresponding product
  value--;

  if (value > 0) {
    $('#product_quantity_' + productCode).val(value);
  }
}

/**
 * This function will increment corresponding product quantity on shop and cart pages.
 * The function gets the current quantity.
 * It will then increment the current value and assign to product quantity field.
 *
 */
function incrementProductQuantity(element) {
  var productCode = $(element).data('product_code');
  var value = $('#product_quantity_' + productCode).val(); //Current quantity of the corresponding product
  value++;
  $('#product_quantity_' + productCode).val(value);
}

/**
 * This function will update the count in cart icon bubble in header.
 *
 */
function updateCartCount() {
  $.ajax({
    url: '/cart/productCountInCart',
    type: 'GET',
    dataType: 'JSON',
    success: function (response) {
      if (response.status == "success") {
        $('#header_cart_icon').attr('data-products', response.count);
      }
    },
    cache: false
  });
}

/**
 * This function will make an ajax post call to cart controller add to cart method.
 * Based on the response, if user is not logged in, user will be redirected to login page.
 * If product is added to cart, user is alerted with success message and cart count
 * is updated in header.
 * If an unexpected error is occured, user is alerted.
 *
 */
$('a.btn-add-to-cart').on('click', function(e) {
  e.preventDefault();
  var productCode = $(this).data('product_code');
  var quantity = $('#product_quantity_' + productCode).val();
  var offerCode = $('#product_offer_code_' + productCode).val();

  $.ajax({
    url: '/cart/addToCart',
    type: 'POST',
    data: {
      product_code: productCode,
      quantity: quantity,
      offer_code: offerCode
    },
    dataType: 'JSON',
    success: function (response) {
      if (response.status == "success") {
        switch (response.message) {
          case 'Product added to cart.':
            updateCartCount();
            alert('Product added to cart successfully.');

            break;
          case 'User not logged in.':
            window.location.replace('/login');

            break;
          default:
            alert('Product could not be added to cart. Please try again.');
        }
      }
    },
    cache: false
  });
});
