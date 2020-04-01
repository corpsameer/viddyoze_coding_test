<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->data = [];
  }

  public function index() {
    $this->load->view('common/header');
    $this->load->view('login');
    $this->load->view('common/footer');
  }

  public function login() {
    $postVars = $this->input->post();
    $postVars['password'] = md5($postVars['password']);
    $this->load->model('customer_model');
    $customer = $this->customer_model->loginCustomer($postVars);

    if (isset($customer['id'])) {
      $this->load->model('customeraddress_model');
      $address = $this->customeraddress_model->getCustomerAddress($customer['id']);

      if (isset($address['id'])) {
        setCustomerSession($customer, $address);

        redirect('shop');
      } else {
        $this->session->set_flashdata(
          'response',
          [
            'class' => 'danger',
            'message' => 'Invalid login credentials provided.',
            'status' => 'error'
          ]
        );

        redirect('login');
      }
    } else {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'danger',
          'message' => 'Invalid login credentials provided.',
          'status' => 'error'
        ]
      );

      redirect('login');
    }
  }

  public function logout() {
    if (sessionExists()) {
      $this->session->sess_destroy();
    }

    redirect('login');
  }
}
