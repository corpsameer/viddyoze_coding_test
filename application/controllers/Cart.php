<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model('cart_model');
    $this->data = [];
  }

  public function index() {
    if (sessionExists()) {
      $cartProducts = $this->cart_model->getProductsInCart($this->session->userdata('customer_id'));
      $this->data['cartProducts'] = $cartProducts;
      $this->data['deliveryCharges'] = DEFAULT_DELIVER_CHARGE;
      $this->data['subTotal'] = 0.00;

      if ($cartProducts) {
        $this->load->model('deliverychargerule_model');
        $this->load->helper('deliverycharge');
        $this->data['subTotal'] = $this->cart_model->getTotalCartPrice($this->session->userdata('customer_id'));
        $deliveryChargeRules = $this->deliverychargerule_model->getDeliveryChargeRules();

        if ($deliveryChargeRules) {
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

  public function productCountInCart() {
    $response = [
      'status' => 'success',
      'count' => 0
    ];

    if (sessionExists()) {
      $productCountInCart = $this->cart_model->getNumberOfProductsInCart($this->session->userdata('customer_id'));

      $response = [
        'status' => 'success',
        'count' => $productCountInCart
      ];
    }

    echo json_encode($response);
  }

  public function addToCart() {
    $response = [];

    if (sessionExists()) {
      $postVars = $this->input->post();
      $this->load->model('product_model');
      $this->load->helper('offers');

      $product = $this->product_model->getProductDetails($postVars['product_code']);
      $totalPrice = applyOfferAndCalculateTotalPrice($postVars['offer_code'], $product['price'], $postVars['quantity']);
      $offerLabel = NULL;
      $offerCode = NULL;

      if ($postVars['offer_code']) {
        $offerCode = $postVars['offer_code'];
        $this->load->model('offer_model');
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

  public function deleteProductFromCart() {
    $cartId = $this->uri->segment(3);
    $productCode = $this->uri->segment(4);
    $productName = $this->uri->segment(5);

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

  public function checkout() {
    $this->load->model('customertoorder_model');
    $this->load->model('producttoorder_model');
    $this->load->model('offer_model');
    $this->load->model('offertoproduct_model');
    $this->load->model('product_model');
    $this->load->helper('offers');
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
      $productDetails = $this->product_model->getProductDetails($product['product_code']);

      if ($productDetails['price'] == $product['price']) {
        if (!is_null($product['offer_code'])) {
          $isOfferToProductActive = $this->offertoproduct_model->checkActiveOfferForProduct($product['offer_code'], $product['product_code']);

          if ($isOfferToProductActive) {
            $isOfferActive = $this->offer_model->checkActiveOffer($product['offer_code']);

            if ($isOfferActive) {
              $totalPrice = applyOfferAndCalculateTotalPrice($product['offer_code'], $product['price'], $product['quantity']);

              if ($totalPrice == $product['total_price']) {
                $orderProducts[$product['product_code']] = $product;
              } else {
                $errorProducts[$productDetails['name']] = 'There are changes in offer ' . $product['offer_applied'] . ' since this product is added in cart.';
              }
            } else {
              $errorProducts[$productDetails['name']] = 'Offer <strong>' . $product['offer_applied'] . '</strong> is no longer available.';
            }
          } else {
            $errorProducts[$productDetails['name']] = 'Offer <strong>' . $product['offer_applied'] . '</strong> is not applicable on this product.';
          }
        } else {
          $orderProducts[$product['product_code']] = $product;
        }
      } else {
        $errorProducts[$productDetails['name']] = 'Price mismatch in cart and actual product.';
      }
    }

    if (empty($errorProducts)) {
      $orderId = $this->customertoorder_model->newOrder($order);

      if ($orderId) {
        foreach ($orderProducts as $product) {
          $this->producttoorder_model->newOrderProduct($orderId, $product);
        }

        $this->cart_model->emptyCart($this->session->userdata('customer_id'));

        redirect('confirmation/' . $orderId);
      }
    } else {
      $this->session->set_flashdata(
        'checkout_error',
        $errorProducts
      );

      redirect('cart');
    }
  }
}
