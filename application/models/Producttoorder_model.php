<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producttoorder_model extends CI_Model {
  /**
    * Constructor.
    */
  function __construct() {
    parent::__construct();
  }

  /**
    * Function to insert product details for order.
    *
    * @param int $orderId Order id.
    * @param array $product Product data.
    *
    */
  public function newOrderProduct($orderId, $product) {
    $data = [
      'order_id' => $orderId,
      'product_code' => $product['product_code'],
      'price' => $product['price'],
      'quantity' => $product['quantity'],
      'total_price' => $product['total_price'],
      'offer_applied' => $product['offer_applied'],
      'offer_code' => $product['offer_code']
    ];

    $this->db->insert(TABLE_PRODUCT_TO_ORDER, $data);
  }

  /**
    * Function to get list of all products in order.
    *
    * @param int $orderId Order id.
    *
    * @return array
    */
  public function getOrderProducts($orderId) {
    $this->db->select('o.*, p.name');
    $this->db->from(TABLE_PRODUCT_TO_ORDER . ' o');
    $this->db->join(TABLE_PRODUCT . ' p', 'o.product_code = p.code');
    $this->db->where('o.order_id', $orderId);

    $result = $this->db->get()->result_array();

    return $result;
  }
}
