<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
  * Function to apply applicable offer on product and return total price.
  *
  * The function takes applicable offer code, quantity and price of the product
  * to be added in cart. If offer code is blank, it returns total price by
  * multiplying quantity and price.
  * If offer code is not blank, then based on the code and offer it performs the
  * required mathemantical calculations and returns the total price for thr product.
  *
  *
  * @param string $offerCode Offer code to be applied.
  * @param float $productPrice Price of the product.
  * @param int $productQuantity Quantity of the product to be added.
  *
  * @return float
  */
if (!function_exists('applyOfferAndCalculateTotalPrice')) {
  function applyOfferAndCalculateTotalPrice($offerCode, $productPrice, $productQuantity) {
    switch ($offerCode) {
      case 'eYZxPI6SVU3MFWs':
        // Action to apply buy 1 get 50% off on 2nd promotional offer to product
        if ($productQuantity == 1) {
          return $productPrice * $productQuantity;
        }

        $halfPrice = floor(($productPrice/2)*100)/100;
        $halfQuantity = (int)($productQuantity/2);
        $totalPrice = (($halfQuantity * $productPrice) + ($halfQuantity * $halfPrice));
        $totalPrice = floor(($totalPrice)*100)/100;

        if ($productQuantity % 2 == 0) {
          return $totalPrice;
        }

        if ($productQuantity % 2 != 0) {
          return $totalPrice + $productPrice;
        }

        break;

      default:
        // Default action to return total price by multip quantity and price.
        return $productPrice * $productQuantity;

        break;
    }
  }
}
