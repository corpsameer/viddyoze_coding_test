<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  /**
    * Constructor
    */
  function __construct() {
    parent::__construct();
    $this->data = [];
  }

  /**
    * Function to show login page.
    */
  public function index() {
    $this->load->view('common/header');
    $this->load->view('login');
    $this->load->view('common/footer');
  }

  /**
    * Function to login to customer's account.
    *
    * The function validates the login credentials entered by the user.
    * If details are correct, the customer's session is set and customer is logged in to his account.
    * If details are incorrect, appropiate error messages are shown.
    *
    */
  public function login() {
    $postVars = $this->input->post();
    $postVars['password'] = md5($postVars['password']);
    $this->load->model('customer_model');

    // Validate customer credentials to login.
    $customer = $this->customer_model->loginCustomer($postVars);

    if (isset($customer['id'])) {
      $this->load->model('customeraddress_model');

      // Get customer address if login is successful.
      $address = $this->customeraddress_model->getCustomerAddress($customer['id']);

      if (isset($address['id'])) {
        // Set session data for customer and address.
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

  /**
    * Function to destroy customer session and logout from application.
    *
    */
  public function logout() {
    if (sessionExists()) {
      $this->session->sess_destroy();
    }

    redirect('login');
  }
}
