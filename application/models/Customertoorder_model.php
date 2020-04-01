<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customertoorder_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  public function newOrder($data) {
    $this->db->insert(TABLE_CUSTOMER_TO_ORDER, $data);
    $orderId = $this->db->insert_id();

    return $orderId;
  }

  public function getOrderDetails($orderId) {
    $this->db->select('*');
    $this->db->from(TABLE_CUSTOMER_TO_ORDER);
    $this->db->where('id', $orderId);

    $result = $this->db->get()->row_array();

    return $result;
  }
}
