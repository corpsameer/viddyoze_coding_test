<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->data = [];
  }

  public function index() {
    $this->load->view('common/header');
    $this->load->view('signup');
    $this->load->view('common/footer');
  }

  public function createAccount() {
    $postVars = $this->input->post();
    $this->load->model('customer_model');
    $alreadyRegistered = $this->customer_model->emailAlreadyRegistered($postVars['email']);

    if ($alreadyRegistered) {
      $this->session->set_flashdata(
        'response',
        [
          'class' => 'danger',
          'message' => 'An account with email <strong>' . $postVars['email'] . '</strong> is already registered with us. Please use a different email address or login to your account.',
          'status' => 'error'
        ]
      );

      redirect('signup');
    } else {
      $customerData = [
        'first_name' => $postVars['first_name'],
        'last_name' => $postVars['last_name'],
        'email' => $postVars['email'],
        'password' => md5($postVars['password'])
      ];
      $customer = $this->customer_model->createAccount($customerData);

      if (isset($customer['id']) && $customer['id']) {
          $this->load->model('customeraddress_model');

          $addressData = [
            'customer_id' => $customer['id'],
            'house_no' => $postVars['house_no'],
            'city' => $postVars['city'],
            'country' => $postVars['country'],
            'postcode' => $postVars['postcode']
          ];
          $address = $this->customeraddress_model->addAddress($addressData);

          if (isset($address['id']) && $address['id']) {
            $this->session->set_flashdata(
              'response',
              [
                'class' => 'success',
                'message' => 'Your account is created successfully. Login to your account below.',
                'status' => 'success'
              ]
            );

            redirect('login');
          } else {
            $this->customer_model->deleteCustomer($customer['id']);
            $this->session->set_flashdata(
              'response',
              [
                'class' => 'danger',
                'message' => 'An unknown error has occured. Please try again after sometime.',
                'status' => 'error'
              ]
            );

            redirect('signup');
          }
      } else {
        $this->session->set_flashdata(
          'response',
          [
            'class' => 'danger',
            'message' => 'An unknown error has occured. Please try again after sometime.',
            'status' => 'error'
          ]
        );

        redirect('signup');
      }
    }
  }
}
