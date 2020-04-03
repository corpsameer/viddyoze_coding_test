<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {
  /**
    * Constructor
    */
  function __construct() {
    parent::__construct();
    $this->data = [];
  }

  /**
    * Function to display active products in application.
    *
    * The function gets the list of all active products in application and show them.
    * For every active product, it checks if there are any active offer for the product.
    *
    */
  public function index() {
    $this->load->model('product_model');

    // Get list of all active products.
    $activeProducts = $this->product_model->getActiveProducts();
    
    if (empty($activeProducts)) {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'info',
          'message' => 'Currently there are no active products. Please visit again to see our latest products.',
          'status' => 'info'
        ]
      );
    } else {
      $this->load->model('offer_model');
      $this->load->model('offertoproduct_model');

      for ($inc = 0; $inc < count($activeProducts); $inc++) {
        $activeProducts[$inc]['activeOffer'] = false;

        // Check active offer for product.
        $activeOfferCode = $this->offertoproduct_model->getActiveOfferForProduct($activeProducts[$inc]['code']);

        if ($activeOfferCode) {
          // If there is an active offer for product, get details of the offer.
          $offerDetails = $this->offer_model->getActiveOfferCodeAndLabel($activeOfferCode);
          $activeProducts[$inc]['activeOffer'] = $offerDetails;
        }
      }
    }

    $this->data['activeProducts'] = $activeProducts;
    $this->load->view('common/header');
    $this->load->view('shop', $this->data);
    $this->load->view('common/footer');
  }
}
