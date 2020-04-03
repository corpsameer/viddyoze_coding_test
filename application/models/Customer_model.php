<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
  /**
    * Conctructor.
    */
  function __construct() {
    parent::__construct();
  }

  /**
    * Function to get customer id through email.
    *
    * @param string $email Customer email address.
    *
    * @return bool
    */
  public function emailAlreadyRegistered($email) {
    $this->db->select('id');
    $this->db->from(TABLE_CUSTOMER);
    $this->db->where('email', $email);

    $result = $this->db->get();

    if($result->num_rows() > 0) {
      return true;
    }

    return false;
  }

  /**
    * Function to create new customer account.
    *
    * @param array $data Customer data.
    *
    * @return array
    */
  public function createAccount($data) {
    $this->db->insert(TABLE_CUSTOMER, $data);
    $customer['id'] = $this->db->insert_id();

    return $customer;
  }

  /**
    * Function to delete customer account.
    *
    * @param int $customerId Customer id.
    *
    */
  public function deleteCustomer($customerId) {
    $this->db->where('id', $customerId);
    $result = $this->db->delete(TABLE_CUSTOMER);
  }

  /**
    * Function to get customer details if login is successful.
    *
    * @param array $data Array with customer's email and password..
    *
    * @return array
    */
  public function loginCustomer($data) {
    $this->db->select('id, first_name, last_name, email');
    $this->db->from(TABLE_CUSTOMER);
    $this->db->where('email', $data['email']);
    $this->db->where('password', $data['password']);

    $result = $this->db->get()->row_array();

    return $result;
  }
}
