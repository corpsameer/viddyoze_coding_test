<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {
  /**
    * Constructor
    */
  function __construct() {
    parent::__construct();
  }

  /**
    * Function to get count of product in customer's cart.
    *
    * @param int $customerId Customer id.
    *
    * @return int
    */
  public function getNumberOfProductsInCart($customerId) {
    $this->db->select('COUNT(*) as count');
    $this->db->from(TABLE_CART);
    $this->db->where('customer_id', $customerId);

    $result = $this->db->get()->row_array();

    return $result['count'];
  }

  /**
    * Function to add product in customer's cart.
    *
    * @param array $data Product data to be added to cart.
    *
    * @return bool
    */
  public function addProductToCart($data) {
    $this->db->replace(TABLE_CART, $data);

    if ($this->db->affected_rows() > 0) {
      return true;
    }

    return false;
  }

  /**
    * Function to get details of products in customer's cart.
    *
    * @param int $customerId Customer id.
    *
    * @return array
    */
  public function getProductsInCart($customerId) {
    $this->db->select('c.*, p.thumb, p.name');
    $this->db->from(TABLE_CART . ' c');
    $this->db->join(TABLE_PRODUCT . ' p', 'c.product_code = p.code');
    $this->db->where('c.customer_id', $customerId);

    $result = $this->db->get()->result_array();

    return $result;
  }

  /**
    * Function to get sum of total price of all products in customer's cart.
    *
    * @param int $customerId Customer id.
    *
    * @return int
    */
  public function getTotalCartPrice($customerId) {
    $this->db->select('SUM(total_price) as total');
    $this->db->from(TABLE_CART);
    $this->db->where('customer_id', $customerId);

    $result = $this->db->get()->row_array();

    return $result['total'];
  }

  /**
    * Function to delete product from customer's cart.
    *
    * @param int $id Cart record id.
    * @param int $productCode Product code to be deleted.
    * @param int $customerId Customer id.
    *
    * @return int
    */
  public function deleteProductFromCart($id, $productCode, $customerId) {
    $this->db->where('id', $id);
    $this->db->where('product_code', $productCode);
    $this->db->where('customer_id', $customerId);
    $this->db->delete(TABLE_CART);

    if ($this->db->affected_rows() > 0) {
      return true;
    }

    return false;
  }

  /**
    * Function to delete all products from customer's cart.
    *
    * @param int $customerId Customer id.
    *
    */
  public function emptyCart($customerId) {
    $this->db->where('customer_id', $customerId);
    $this->db->delete(TABLE_CART);
  }
}
