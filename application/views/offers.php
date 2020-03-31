<div class="section-top-border container">
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

      <?php if ($activeOffers): ?>
        <div class="card-deck mt-4">
          <div class="row">
            <?php foreach ($activeOffers as $offer): ?>
              <div class="col-lg-6">
                <div class="card text-center min-height-200">
                  <div class="card-block">
                      <h4 class="card-title"><?= ucwords($offer['title']); ?></h4>
                      <p class="card-text padding-top-30">
                        <?= $offer['description']; ?>
                      </p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
  </div>
</div>
