<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-main">
      <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= $label->label_about ?></li>
    </ol>
  </nav>
</div>



<section class="content" id="about-us">
  <div class="container">
    <div class="well">
      <div class="detail">
        <?php echo $about_data->about_detail ;?>
      </div>      
    </div>    
  </div>
</section>
<script type="text/javascript">
  $("#gtx-trans").hide();
</script>