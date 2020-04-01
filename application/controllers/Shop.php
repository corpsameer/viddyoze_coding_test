<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->data = [];
  }

  public function index() {
    $this->load->model('product_model');
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
        $activeOfferCode = $this->offertoproduct_model->getActiveOfferForProduct($activeProducts[$inc]['code']);

        if ($activeOfferCode) {
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
