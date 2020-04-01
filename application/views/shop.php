<div class="slider-area ">
    <div class="slider-active">
        <div class="single-slider slider-height" data-background="assets/images/pages/shop/banner_background.jpg">
            <div class="container">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-none d-md-block">
                        <div class="hero__img" data-animation="bounceIn" data-delay=".4s">
                            <img src="assets/images/pages/shop/banner_front.png" alt="">
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-8">
                        <div class="hero__caption">
                            <span data-animation="fadeInRight" data-delay=".4s">Exciting offer</span>
                            <h1 data-animation="fadeInRight" data-delay=".6s">Free Delivery</h1>
                            <p data-animation="fadeInRight" data-delay=".8s">On all orders above $90.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="latest-product-area">
  <div class="container">
    <?php if ($response = $this->session->flashdata('response') ?? false) {
      printf('<div class="container section_padding">');
      printf(
        '<div class="alert alert-%s text-center"><strong>%s %s! </strong>%s</div>',
        $response['class'],
        ($response['status'] == 'error') ? '<i class="fa fa-times-circle"></i>' : '<i class="fa fa-check-circle"></i>',
        ucfirst($response['status']),
        $response['message']
      );
      printf('</div>');
    } ?>

    <?php if ($activeProducts): ?>
      <div class="row product-btn d-flex align-items-center">
        <div class="section-tittle product-catalog-title">
            <h2>Our Products</h2>
        </div>
      </div>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <div class="row">
            <?php foreach ($activeProducts as $product): ?>
              <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="single-product mb-60">
                  <div class="product-img">
                    <img src="<?= $product['image']; ?>" alt="<?= $product['name'] . ' image.' ?>">
                    <?php if($product['activeOffer']): ?>
                      <div class="new-product">
                        <span><?= $product['activeOffer']['label']; ?></span>
                      </div>
                    <?php endif; ?>
                    <input type="hidden" name="product_offer_code_<?= $product['code']; ?>" id="product_offer_code_<?= $product['code']; ?>"
                    value="<?php if ($product['activeOffer']) echo $product['activeOffer']['code']; else echo ''; ?>">
                  </div>
                  <div class="product-caption">
                    <h4><?= $product['name']; ?></h4>
                    <div class="price">
                      <ul>
                        <li><?= $product['price']; ?></li>
                      </ul>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="product_count">
                          <span class="input-number-decrement" data-product_code="<?= $product['code']; ?>" onclick="decrementProductQuantity(this);"> <i class="ti-minus"></i></span>
                          <input class="input-number" type="text" value="1"
                          name="product_quantity_<?= $product['code']; ?>" id="product_quantity_<?= $product['code']; ?>">
                          <span class="input-number-increment" data-product_code="<?= $product['code']; ?>" onclick="incrementProductQuantity(this);"> <i class="ti-plus"></i></span>
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6">
                        <a href="#" class="genric-btn primary circle arrow btn-add-to-cart" data-product_code="<?= $product['code']; ?>">
                          Add to Cart<span class="lnr lnr-arrow-right"></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>
