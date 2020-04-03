<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
  /**
    * Constructor.
    */
  function __construct() {
    parent::__construct();
  }

  /**
    * Function to get list of all active products.
    *
    * @return array
    */
  public function getActiveProducts() {
    $this->db->select('*');
    $this->db->from(TABLE_PRODUCT);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get()->result_array();

    return $result;
  }

  /**
    * Function to get details of the product.
    *
    * @param string $productCode Product code.
    *
    * @return array
    */
  public function getProductDetails($productCode) {
    $this->db->select('*');
    $this->db->from(TABLE_PRODUCT);
    $this->db->where('code', $productCode);

    $result = $this->db->get()->row_array();

    return $result;
  }
}
