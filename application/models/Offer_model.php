<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer_model extends CI_Model {
  /**
    * Constructor.
    */
  function __construct() {
    parent::__construct();
  }

  /**
    * Function to get list of all active offers.
    *
    * @return array
    */
  public function getActiveOffers() {
    $this->db->select('id, title, description');
    $this->db->from(TABLE_OFFER);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get()->result_array();

    return $result;
  }

  /**
    * Function to get code and label of active offer.
    *
    * @param string $offerCode Offer code.
    *
    * @return mixed
    */
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

  /**
    * Function to get label of offer.
    *
    * @param string $offerCode Offer code.
    *
    * @return string
    */
  public function getOfferLabel($offerCode) {
    $this->db->select('label');
    $this->db->from(TABLE_OFFER);
    $this->db->where('code', $offerCode);

    $result = $this->db->get()->row_array();

    return $result['label'];
  }

  /**
    * Function to check if offer is active.
    *
    * @param string $offerCode Offer code.
    *
    * @return bool
    */
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
