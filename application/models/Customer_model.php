<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

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

  public function createAccount($data) {
    $this->db->insert(TABLE_CUSTOMER, $data);
    $customer['id'] = $this->db->insert_id();

    return $customer;
  }

  public function deleteCustomer($customerId) {
    $this->db->where('id', $customerId);
    $result = $this->db->delete(TABLE_CUSTOMER);
  }

  public function loginCustomer($data) {
    $this->db->select('id, first_name, last_name, email');
    $this->db->from(TABLE_CUSTOMER);
    $this->db->where('email', $data['email']);
    $this->db->where('password', $data['password']);

    $result = $this->db->get()->row_array();

    return $result;
  }
}
