<section class="terms&conditions" id="terms&conditions">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-main">
        <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
        <li class="breadcrumb-item active" aria-current="page">
          <?php if ($langId == 2) { ?>
            ข้อตกลง & เงื่อนไข
          <?php } else { ?>
            Terms & Conditions
          <?php } ?></li>
      </ol>
    </nav>
    <div class="well well-term">
      <div class="detail">
        <center>
          <h2><?php echo $model->terms_title; ?></h2>
        </center>
        <?php echo htmlspecialchars_decode($model->terms_detail); ?>

      </div>
    </div>
  </div>

</section>