<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirmation extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->data = [];
  }

  public function index() {
    $orderId = $this->uri->segment(2);

    if (empty($orderId)) {
      redirect('shop');
    }

    $this->load->model('customertoorder_model');
    $this->load->model('producttoorder_model');
    $this->load->model('customeraddress_model');
    $this->data['orderDetails'] = $this->customertoorder_model->getOrderDetails($orderId);
    $this->data['orderProducts'] = $this->producttoorder_model->getOrderProducts($orderId);
    $this->data['billingAddress'] = $this->customeraddress_model->getCustomerAddress($this->session->userdata('customer_id'));

    if (empty($this->data['orderDetails']) || empty($this->data['orderProducts'])) {
      redirect('shop');
    }

    $this->load->view('common/header');
    $this->load->view('confirmation', $this->data);
    $this->load->view('common/footer');
  }
}
