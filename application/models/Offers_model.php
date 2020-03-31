<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers_model extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  public function getActiveOffers() {
    $this->db->select('id, title, description');
    $this->db->from(TABLE_OFFERS);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get()->result_array();

    return $result;
  }
}
