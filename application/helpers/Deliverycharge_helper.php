<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
  * Function to calculate delivery charges for products in cart.
  *
  * The function takes sum of price of all the products in cart and delivery charge rules.
  * Based on the applicble condition, the corresponding delivery charge is returned.
  * If no condition is satisfied, a flat delivry charge of $4.95 is returned.
  *
  *
  * @param float $orderPrice Total price of all products in cart.
  * @param array $deliveryChargeRules Delivery charge rules.
  *
  * @return float
  */
if (!function_exists('calculateDeliveryCharges')) {
  function calculateDeliveryCharges($orderPrice, $deliveryChargeRules) {
    foreach ($deliveryChargeRules as $deliveryChargeRule) {
      if ($orderPrice >= $deliveryChargeRule['minimum_order_value']) {
        if ($deliveryChargeRule['maximum_order_value'] == -1) {
          return 0.00;
        }

        if ($orderPrice < $deliveryChargeRule['maximum_order_value']) {
          return $deliveryChargeRule['delivery_charge'];
        }
      }
    }

    return DEFAULT_DELIVER_CHARGE;
  }
}
