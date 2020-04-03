<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offertoproduct_model extends CI_Model {
  /**
    * Constructor.
    */
  function __construct() {
    parent::__construct();
  }

  /**
    * Function to get code of offer which is active for product.
    *
    * @param string $productCode Product code.
    *
    * @return mixed
    */
  public function getActiveOfferForProduct($productCode) {
    $this->db->select('offer_code');
    $this->db->from(TABLE_OFFER_TO_PRODUCT);
    $this->db->where('product_code', $productCode);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get();

    if ($result->num_rows()) {
      $row = $result->row_array();

      return $row['offer_code'];
    }

    return false;
  }

  /**
    * Function to check if offer is active for product.
    *
    * @param string $offerCode Offer code.
    * @param string $productCode Product code.
    *
    * @return mixed
    */
  public function checkActiveOfferForProduct($offerCode, $productCode) {
    $this->db->select('is_active');
    $this->db->from(TABLE_OFFER_TO_PRODUCT);
    $this->db->where('offer_code', $offerCode);
    $this->db->where('product_code', $productCode);

    $result = $this->db->get();

    if ($result->num_rows()) {
      $row = $result->row_array();

      if ($row['is_active'] == STATUS_ACTIVE) {
        return true;
      }

      return false;
    }

    return false;
  }
}
