<section class="cart_area section_padding">
    <div class="container">
      <?php if ($response = $this->session->flashdata('response') ?? false) {
        printf(
          '<div class="alert alert-%s text-center"><strong>%s %s! </strong>%s</div>',
          $response['class'],
          ($response['status'] == 'error') ? '<i class="fa fa-times-circle"></i>' : '<i class="fa fa-check-circle"></i>',
          ucfirst($response['status']),
          $response['message']
        );
      }

      if ($checkoutError = $this->session->flashdata('checkout_error') ?? false): ?>
        <div class="alert alert-danger text-center">
          <strong>Error! </strong>Following errors occured while processing your order.<br><br>
          <?php foreach ($checkoutError as $product => $error): ?>
            Product <strong><?= $product; ?></strong> - <?= $error; ?><br>
          <?php endforeach; ?>
          <br>
          Kindly remove above above products from cart and add them again to remove these errors.
        </div>
      <?php endif; ?>

      <?php if(empty($cartProducts)): ?>
        <div class="alert alert-info text-center">
          <strong>Oops! </strong>Your cart is empty. Visit our shop and start building your cart.
        </div>
        <div class="text-center">
          <a class="btn_1" href="/shop">Continue Shopping</a>
        </div>
      <?php else: ?>
        <div class="cart_inner">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Offer Applied</th>
                  <th scope="col">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cartProducts as $product): ?>
                  <tr>
                    <td>
                      <div class="media">
                        <div class="d-flex">
                          <img src="<?= $product['thumb']; ?>" alt="">
                        </div>
                        <div class="media-body">
                          <p><?= $product['name']; ?></p>
                          <a href="/cart/deleteProductFromCart/<?=$product['id'];?>/<?=$product['product_code'];?>/<?=$product['name'];?>">
                            <p class="remove-product-from-cart">
                                <i class="fas fa-trash-alt"></i>
                                Remove product
                            </p>
                          </a>
                        </div>
                      </div>
                    </td>
                    <td>
                      <h5>$<?= $product['price']; ?></h5>
                    </td>
                    <td>
                      <div class="product_count">
                        <input class="input-number" type="text" disabled value="<?= $product['quantity']; ?>" min="0" max="10">
                      </div>
                    </td>
                    <td>
                      <h5>
                        <?php if($product['offer_applied']): ?>
                          <span class="label label-green"><?= $product['offer_applied']; ?></span>
                        <?php endif; ?>
                      </h5>
                    </td>
                    <td>
                      <h5>$<?= $product['total_price']; ?></h5>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <tr>
                  <td colspan="4">
                    <h5>Subtotal</h5>
                  </td>
                  <td>
                    <h5>$<?= $subTotal; ?></h5>
                  </td>
                </tr>
                <tr>
                  <td colspan="4">
                    <h5>Delivery Charges</h5>
                  </td>
                  <td>
                    <h5>$<?= $deliveryCharges; ?></h5>
                  </td>
                </tr>
                <tr>
                  <td colspan="4">
                    <h5>Total</h5>
                  </td>
                  <td>
                    <h5>$<?= $totalOrderPrice; ?></h5>
                  </td>
                </tr>
                <tr class="bottom_button">
                  <td colspan="4">
                    <a class="btn_1" href="/shop">Continue Shopping</a>
                  </td>
                  <td>
                    <div class="cupon_text float-right">
                      <a class="btn_1 btn-checkout" href="/cart/checkout/<?= $subTotal; ?>/<?= $deliveryCharges; ?>/<?= $totalOrderPrice; ?>">Proceed to Checkout</a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>
    </div>
</section>
