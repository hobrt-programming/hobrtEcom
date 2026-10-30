<?php include_once 'header.php'; ?>

<section class="ws-section-spacing">
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="text-center">
          <img src="images/success-order.png" alt="Success Icon" style="width: 150px;">
          <h2 class="mt-3"><?= sprintf(lang("lang_h49"), html_escape($this->input->get("order_id") ?? "n/a")) ?></h2>
        </div>
      </div>
    </div>

    <!--<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="border p-4 mt-4">
          <h3><?= lang("lang_h112") ?></h3>
           
        </div>
      </div>
    </div> -->

    <div class="row justify-content-center mt-4">
      <div class="col-md-8 text-center">
        <p><?= lang("lang_h50") ?></p>
      </div>
    </div>
  </div>

</section>

<?php include_once 'footer.php'; ?>