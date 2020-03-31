<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->data = [];
  }

  public function index() {
    $this->load->model('offers_model');
    $activeOffers = $this->offers_model->getActiveOffers();
    $this->data['activeOffers'] = $activeOffers;

    if (empty($activeOffers)) {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'danger',
          'message' => 'Currently there are no active offers. Please visit again to see our latest offers.',
          'status' => 'error'
        ]
      );
    }

    $this->load->view('common/header');
    $this->load->view('offers', $this->data);
    $this->load->view('common/footer');
  }
}
