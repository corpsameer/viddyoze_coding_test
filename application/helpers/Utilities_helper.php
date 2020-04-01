<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
  * Function to set customer session data.
  *
  * After a customer is logged in successfully, this function sets
  * required session variables customer and customer address data.
  *
  * @param array $customerData Customer data.
  * @param array $addressData Customer address data.
  *
  * @return void
  */
if (!function_exists('setCustomerSession')) {
  function setCustomerSession($customerData, $addressData) {
    $CI = get_instance();
    $sessionData = [
      'customer_id' => $customerData['id'],
      'customer_first_name' => $customerData['first_name'],
      'customer_last_name' => $customerData['last_name'],
      'customer_email' => $customerData['email'],
      'customer_address_id' => $addressData['id'],
      'customer_house_no' => $addressData['house_no'],
      'customer_city' => $addressData['city'],
      'customer_country' => $addressData['country'],
      'customer_postcoded' => $addressData['postcode']
    ];

    $CI->session->set_userdata($sessionData);
  }
}

/**
  * Function to check if customer session exists.
  *
  * This function checks if a customer session is set or not.
  *
  * @return bool
  */
if (!function_exists('sessionExists')) {
  function sessionExists() {
    $CI = get_instance();

    if ($CI->session->userdata('customer_id')) {
      return true;
    }

    return false;
  }
}
