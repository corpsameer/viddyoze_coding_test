<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

  /**
    * Constructor
    */
  function __construct() {
    parent::__construct();
    $this->load->model('cart_model');
    $this->data = [];
  }

  /**
    * Function to show products in customer's cart.
    *
    * The function checks if user is logged in or not.
    * If user is logged in, existing products in his cart are displayed.
    * If not logged in, user is redirected to login page.
    * If there are no products in a logged in customer's account, empty cart message is shown.
    *
    */
  public function index() {
    if (sessionExists()) {
      // Get products in customer's cart.
      $cartProducts = $this->cart_model->getProductsInCart($this->session->userdata('customer_id'));
      $this->data['cartProducts'] = $cartProducts;
      $this->data['deliveryCharges'] = DEFAULT_DELIVER_CHARGE;
      $this->data['subTotal'] = 0.00;

      // Check if cart has products.
      if ($cartProducts) {
        $this->load->model('deliverychargerule_model');
        $this->load->helper('deliverycharge');

        //Get sum of total price of all products in cart to calculate sub total.
        $this->data['subTotal'] = $this->cart_model->getTotalCartPrice($this->session->userdata('customer_id'));

        // Fetch delivery charge rules from database.
        $deliveryChargeRules = $this->deliverychargerule_model->getDeliveryChargeRules();

        if ($deliveryChargeRules) {
          // Get delivery charge for products in cart.
          $this->data['deliveryCharges'] = calculateDeliveryCharges($this->data['subTotal'], $deliveryChargeRules);
        }
      }

      $this->data['totalOrderPrice'] = $this->data['subTotal'] + $this->data['deliveryCharges'];
      $this->load->view('common/header');
      $this->load->view('cart', $this->data);
      $this->load->view('common/footer');
    } else {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'info',
          'message' => 'Please login to your account to see your cart.',
          'status' => 'info'
        ]
      );

      redirect('login');
    }
  }

  /**
    * Function to get number of products in cutomers cart.
    *
    * The function checks if user is logged in or not.
    * If user is logged in, it gets the number of products in cart and returns it.
    * If user is not logged in, it returns 0.
    *
    */
  public function productCountInCart() {
    $response = [
      'status' => 'success',
      'count' => 0
    ];

    if (sessionExists()) {
      // Get product count in customer's cart.
      $productCountInCart = $this->cart_model->getNumberOfProductsInCart($this->session->userdata('customer_id'));

      $response = [
        'status' => 'success',
        'count' => $productCountInCart
      ];
    }

    echo json_encode($response);
  }

  /**
    * Function to add product in customer's cart.
    *
    * The function checks if user is logged in or not.
    * If user is logged in, it gets details of the products from database and
    * add product to cart.
    * If user is not logged in, user is redirected to login page.
    *
    */
  public function addToCart() {
    $response = [];

    if (sessionExists()) {
      // Post data.
      $postVars = $this->input->post();
      $this->load->model('product_model');
      $this->load->helper('offers');

      // Get details of product from database.
      $product = $this->product_model->getProductDetails($postVars['product_code']);

      // Get total price based on offer code, product price and quantity.
      $totalPrice = applyOfferAndCalculateTotalPrice($postVars['offer_code'], $product['price'], $postVars['quantity']);
      $offerLabel = NULL;
      $offerCode = NULL;

      if ($postVars['offer_code']) {
        $offerCode = $postVars['offer_code'];
        $this->load->model('offer_model');

        // Get label of applicable offer.
        $offerLabel = $this->offer_model->getOfferLabel($postVars['offer_code']);
      }

      $cartData = [
        'customer_id' => $this->session->userdata('customer_id'),
        'product_code' => $postVars['product_code'],
        'quantity' => $postVars['quantity'],
        'price' => $product['price'],
        'offer_applied' => $offerLabel,
        'offer_code' => $offerCode,
        'total_price' => $totalPrice
      ];

      // Add ptoduct to cart.
      $addedToCart = $this->cart_model->addProductToCart($cartData);

      if ($addedToCart) {
        $response = [
          'status' => 'success',
          'message' => 'Product added to cart.'
        ];
      } else {
        $response = [
          'status' => 'success',
          'message' => 'Product not added to cart.'
        ];
      }
    } else {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'info',
          'message' => 'Please login to your account to add prodcuts to your cart.',
          'status' => 'info'
        ]
      );
      $response = [
        'status' => 'success',
        'message' => 'User not logged in.'
      ];
    }

    echo json_encode($response);
  }

  /**
    * Function to delete product from customer's cart.
    *
    */
  public function deleteProductFromCart() {
    $cartId = $this->uri->segment(3);
    $productCode = $this->uri->segment(4);
    $productName = $this->uri->segment(5);

    // Delete product from cart.
    $productDeleted = $this->cart_model->deleteProductFromCart($cartId, $productCode, $this->session->userdata('customer_id'));

    if (!$productDeleted) {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'danger',
          'message' => 'Something went wrong. Please try again.',
          'status' => 'error'
        ]
      );
    } else {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'success',
          'message' => 'Product <strong>' . urldecode($productName) . '</strong> deleted successfully.',
          'status' => 'success'
        ]
      );
    }

    redirect('cart');
  }

  /**
    * Function to checkout and place an order successfully.
    *
    * The function validates if price and applicable offer in customer's cart
    * are in line with data in database and calculations.
    * If there are any deviations from expected data, corresponding error is shown.
    * If everything is in line with expected data, an order is placed successfully.
    * The cart for the customer is emptied after an order is placed successfully.
    *
    */
  public function checkout() {
    $this->load->model('customertoorder_model');
    $this->load->model('producttoorder_model');
    $this->load->model('offer_model');
    $this->load->model('offertoproduct_model');
    $this->load->model('product_model');
    $this->load->helper('offers');

    // Get list of all products in customer's cart.
    $cartProducts = $this->cart_model->getProductsInCart($this->session->userdata('customer_id'));
    $errorProducts = [];
    $orderProducts = [];
    $order = [
      'customer_id' => $this->session->userdata('customer_id'),
      'total_price' => $this->uri->segment(5),
      'sub_total' => $this->uri->segment(3),
      'delivery_charge' => $this->uri->segment(4)
    ];

    foreach ($cartProducts as $product) {
      // Get details of product from database.
      $productDetails = $this->product_model->getProductDetails($product['product_code']);

      if ($productDetails['price'] == $product['price']) {
        if (!is_null($product['offer_code'])) {
          // Check if offer applied to product in cart is still active.
          $isOfferToProductActive = $this->offertoproduct_model->checkActiveOfferForProduct($product['offer_code'], $product['product_code']);

          if ($isOfferToProductActive) {
            // Check if offer applicable on product is still active in system.
            $isOfferActive = $this->offer_model->checkActiveOffer($product['offer_code']);

            if ($isOfferActive) {
              // Calculate total price of product with offer, quantity and price.
              $totalPrice = applyOfferAndCalculateTotalPrice($product['offer_code'], $product['price'], $product['quantity']);

              if ($totalPrice == $product['total_price']) {
                // Add product to confirmed products to be ordered if current total price is equal to total price in database.
                $orderProducts[$product['product_code']] = $product;
              } else {
                // Error if current total price is differnet from total price in database.
                $errorProducts[$productDetails['name']] = 'There are changes in offer ' . $product['offer_applied'] . ' since this product is added in cart.';
              }
            } else {
              // Error if applied offer is no longer active in system.
              $errorProducts[$productDetails['name']] = 'Offer <strong>' . $product['offer_applied'] . '</strong> is no longer available.';
            }
          } else {
            // Error if applied offer is no longer applicable on the product.
            $errorProducts[$productDetails['name']] = 'Offer <strong>' . $product['offer_applied'] . '</strong> is not applicable on this product.';
          }
        } else {
          // Add product to confirmed products to be ordered if no offer is applicable on product.
          $orderProducts[$product['product_code']] = $product;
        }
      } else {
        // Error if current price of product is not equal to product price in cart.
        $errorProducts[$productDetails['name']] = 'Price mismatch in cart and actual product.';
      }
    }

    if (empty($errorProducts)) {
      // If there are no errors, place an order successfully.
      $orderId = $this->customertoorder_model->newOrder($order);

      if ($orderId) {
        // If order is placed, add all products to order details.
        foreach ($orderProducts as $product) {
          $this->producttoorder_model->newOrderProduct($orderId, $product);
        }

        // If order is successful, delete all products from customer's cart.
        $this->cart_model->emptyCart($this->session->userdata('customer_id'));

        redirect('confirmation/' . $orderId);
      }
    } else {
      // If any error for any product is there, then show the corrsponding error.
      $this->session->set_flashdata(
        'checkout_error',
        $errorProducts
      );

      redirect('cart');
    }
  }
}
