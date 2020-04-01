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

  public function getActiveOfferCodeAndLabel($offerCode) {
    $this->db->select('code, label');
    $this->db->from(TABLE_OFFER);
    $this->db->where('code', $offerCode);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get();

    if ($result->num_rows() > 0) {
      $row = $result->row_array();

      return $row;
    }

    return false;
  }

  public function getOfferLabel($offerCode) {
    $this->db->select('label');
    $this->db->from(TABLE_OFFER);
    $this->db->where('code', $offerCode);

    $result = $this->db->get()->row_array();

    return $result['label'];
  }

  public function checkActiveOffer($offerCode) {
    $this->db->select('is_active');
    $this->db->from(TABLE_OFFER);
    $this->db->where('code', $offerCode);

    $result = $this->db->get()->row_array();

    if ($result['is_active'] == STATUS_ACTIVE) {
      return true;
    }

    return false;
  }
}
