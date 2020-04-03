<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customeraddress_model extends CI_Model {
  /**
    * Constructor.
    */
  function __construct() {
    parent::__construct();
  }

  /**
    * Function to add customer address details.
    *
    * @param array $data Customer address data.
    *
    * @return array
    */
  public function addAddress($data) {
    $this->db->insert(TABLE_CUSTOMER_ADDRESS, $data);
    $address['id'] = $this->db->insert_id();

    return $address;
  }

  /**
    * Function to get customer's address details.
    *
    * @param int $customerId Customer id.
    *
    * @return array
    */
  public function getCustomerAddress($customerId) {
    $this->db->select('id, house_no, city, country, postcode');
    $this->db->from(TABLE_CUSTOMER_ADDRESS);
    $this->db->where('customer_id', $customerId);

    $result = $this->db->get()->row_array();

    return $result;
  }
}
