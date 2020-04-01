<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  public function getActiveOffers() {
    $this->db->select('id, title, description');
    $this->db->from(TABLE_OFFER);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get()->result_array();

    return $result;
  }

  public function getActiveOfferCodeAndLabel($offerId) {
    $this->db->select('code, label');
    $this->db->from(TABLE_OFFER);
    $this->db->where('id', $offerId);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      $row = $result->row_array();

      return $row;
    }

    return false;
  }
}
