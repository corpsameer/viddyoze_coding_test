<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Acme Widget Co</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/flaticon.css">
        <link rel="stylesheet" href="assets/css/slicknav.css">
        <link rel="stylesheet" href="assets/css/animate.min.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/css/themify-icons.css">
        <link rel="stylesheet" href="assets/css/slick.css">
        <link rel="stylesheet" href="assets/css/nice-select.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div id="preloader-active">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="preloader-circle"></div>
                    <div class="preloader-img pere-text">Loading..</div>
                </div>
            </div>
        </div>

        <header>
          <div class="header-area">
              <div class="main-header ">
                 <div class="header-bottom  header-sticky">
                      <div class="container">
                          <div class="row align-items-center">
                              <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4">
                                  <div class="logo">
                                      <a href="/shop" class="header-logo">Acme Widget Co</a>
                                  </div>
                              </div>
                              <div class="col-xl-5 col-lg-7 col-md-6 col-sm-4">
                                  <div class="main-menu d-none d-lg-block">
                                      <nav>
                                          <ul id="navigation">
                                              <li><a href="/shop">Shop</a></li>
                                              <li class="hot"><a href="/offers">Offers</a></li>
                                              <li><a href="/cart">Shopping Cart</a></li>
                                              <?php if (true): ?>
                                                  <li class="d-block d-lg-none"><a href="/login">Sign in</a></li>
                                              <?php elseif (false): ?>
                                                  <li class="d-block d-lg-none"><a href="/login">Log Out</a></li>
                                              <?php endif; ?>
                                          </ul>
                                      </nav>
                                  </div>
                              </div>
                              <div class="col-xl-5 col-lg-3 col-md-3 col-sm-3 fix-card">
                                  <ul class="header-right f-right d-none d-lg-block d-flex justify-content-between">
                                      <li class="d-none d-lg-block welcome-text">Welcome, Guest</li>
                                      <li>
                                          <div class="shopping-card" data-products="5">
                                              <a href="/cart"><i class="fas fa-shopping-cart"></i></a>
                                          </div>
                                      </li>
                                      <?php if (true): ?>
                                          <li class="d-none d-lg-block"><a href="/login" class="btn header-btn">Sign in</a></li>
                                      <?php elseif (false): ?>
                                          <li class="d-none d-lg-block"><a href="/login" class="btn header-btn">Log Out</a></li>
                                      <?php endif; ?>
                                  </ul>
                              </div>
                              <div class="col-12">
                                  <div class="mobile_menu d-block d-lg-none"></div>
                              </div>
                          </div>
                      </div>
                 </div>
              </div>
            </div>
        </header>
        <main>
