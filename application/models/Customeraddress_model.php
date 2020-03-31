<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customeraddress_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  public function addAddress($data) {
    $this->db->insert(TABLE_CUSTOMER_ADDRESS, $data);
    $address['id'] = $this->db->insert_id();

    return $address;
  }

  public function getCustomerAddress($customerId) {
    $this->db->select('id, house_no, city, country, postcode');
    $this->db->from(TABLE_CUSTOMER_ADDRESS);
    $this->db->where('customer_id', $customerId);

    $result = $this->db->get()->row_array();

    return $result;
  }
}
