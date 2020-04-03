<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deliverychargerule_model extends CI_Model {
  /**
    * Constructor.
    */
  function __construct() {
    parent::__construct();
  }

  /**
    * Function to get list of delivery charge rules.
    *
    * @return array
    */
  public function getDeliveryChargeRules() {
    $this->db->select('*');
    $this->db->from(TABLE_DELIVERY_CHARGE_RULE);
    $this->db->where('is_active', STATUS_ACTIVE);

    $result = $this->db->get()->result_array();

    return $result;
  }
}
