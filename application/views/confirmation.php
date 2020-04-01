<section class="confirmation_part section_padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="alert alert-success text-center">
            <strong>Success! </strong>Thank you. Your order has been received.
            <br>Below are your order details.
          </div>
        </div>
        <div class="col-lg-6 col-lx-4">
          <div class="single_confirmation_details">
            <h4>order info</h4>
            <ul>
              <li>
                <p>order number</p><span>: <?= $orderDetails['id']; ?></span>
              </li>
              <li>
                <p>date</p><span>: <?= $orderDetails['order_date']; ?></span>
              </li>
              <li>
                <p>total</p><span>: $<?= $orderDetails['total_price']; ?></span>
              </li>
              <li>
                <p>payment method</p><span>: <?= DEFAULT_PAYMENT_METHOD; ?></span>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-6 col-lx-4">
          <div class="single_confirmation_details">
            <h4>Billing Address</h4>
            <ul>
              <li>
                <p>Street</p><span>: <?= $billingAddress['house_no']; ?></span>
              </li>
              <li>
                <p>city</p><span>: <?= $billingAddress['city']; ?></span>
              </li>
              <li>
                <p>country</p><span>: <?= $billingAddress['country']; ?></span>
              </li>
              <li>
                <p>postcode</p><span>: <?= $billingAddress['postcode']; ?></span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="order_details_iner">
            <h3>Order Details</h3>
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th scope="col" colspan="2">Product</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Price</th>
                  <th scope="col">Offer</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($orderProducts as $product): ?>
                  <tr>
                    <th colspan="2"><span><?= $product['name']; ?></span></th>
                    <th><?= $product['quantity']; ?></th>
                    <th>$<?= $product['price']; ?></th>
                    <th><?= $product['offer_applied']; ?></th>
                    <th>$<?= $product['total_price']; ?></th>
                  </tr>
                <?php endforeach; ?>
                <tr>
                  <th colspan="5">Subtotal</th>
                  <th> <span>$<?= $orderDetails['sub_total']; ?></span></th>
                </tr>
                <tr>
                  <th colspan="5">delivery charges</th>
                  <th> <span>$<?= $orderDetails['delivery_charge']; ?></span></th>
                </tr>
                <tr>
                  <th colspan="5">total</th>
                  <th> <span>$<?= $orderDetails['total_price']; ?></span></th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="checkout_btn_inner float-right section_padding_20">
        <a class="btn_1" href="/shop">Continue Shopping</a>
      </div>
    </div>
  </section>
