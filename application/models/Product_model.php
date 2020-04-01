<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  public function getActiveProducts() {
    $this->db->select('*');
    $this->db->from(TABLE_PRODUCT);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get()->result_array();

    return $result;
  }

  public function getProductDetails($productCode) {
    $this->db->select('*');
    $this->db->from(TABLE_PRODUCT);
    $this->db->where('code', $productCode);

    $result = $this->db->get()->row_array();

    return $result;
  }
}
