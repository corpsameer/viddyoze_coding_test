<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offertoproduct_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  public function getActiveOfferForProduct($productCode) {
    $this->db->select('offer_id');
    $this->db->from(TABLE_OFFER_TO_PRODUCT);
    $this->db->where('product_code', $productCode);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get();

    if ($result->num_rows()) {
      $row = $result->row_array();

      return $row['offer_id'];
    }

    return false;
  }
}
