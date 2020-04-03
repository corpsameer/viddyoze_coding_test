<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers extends CI_Controller {
  /**
    * Constructor
    */
  function __construct() {
    parent::__construct();
    $this->data = [];
  }

  /**
    * Function to display active offers in the application.
    */
  public function index() {
    $this->load->model('offer_model');
    $activeOffers = $this->offer_model->getActiveOffers();

    if (empty($activeOffers)) {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'info',
          'message' => 'Currently there are no active offers. Please visit again to see our latest offers.',
          'status' => 'info'
        ]
      );
    }

    $this->data['activeOffers'] = $activeOffers;
    $this->load->view('common/header');
    $this->load->view('offers', $this->data);
    $this->load->view('common/footer');
  }
}
