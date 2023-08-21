<script>
  function AlertCardID(val){
    // $(window).load(function () {
            $('#modal-CPD').modal({backdrop: 'static', keyboard: false});
            // 
            <?php if($profile->type_user == 2) { ?>
            $('#modal-CPD-accounting').modal('show');
            document.getElementById("accounting").value = val;
            <?php } else if($profile->type_user == 3) { ?>
            $('#modal-CPD-exam').modal('show');
            document.getElementById("exam").value = val;
            <?php } else if($profile->type_user == 4) { ?>
            $('#modal-CPD-accounting-exam').modal('show');
            document.getElementById("accounting-exam").value = val;
            <?php } ?>
        // });
  }
</script>
<style>
  a.cancel{
    color: white;
    background-color: black;
  }
</style>
<?php ?>

  <!-- Container -->
  <div id="container">

    <!-- Start Page Banner -->
    <div class="page-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2 class="text-white">หลักสูตรทั่วไป</h2>
            <p class="grey lighten-1">We Are Professional</p>
          </div>
          <div class="col-md-6">
            <ul class="breadcrumbs">
              <li><a href="index.php">หน้าแรก</a></li>
              <li><a href="<?= $this->createUrl('/category/index/'); ?>">หลักสูตร DBD Academy</a></li>
              <li>หลักสูตรทั่วไป</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- End Page Banner -->


    <!-- Start Content -->
    <div id="content">
    <div class="container content-body">

        <!-- Start Big Heading -->
        <div class="big-title text-center" data-animation="fadeInDown" data-animation-delay="01">
          <h1><strong>หลักสูตรทั่วไป</strong></h1>
        </div>
        <!-- End Big Heading -->

        <!-- Some Text -->
        <!-- <p class="text-center">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium <span class="accent-color sh-tooltip" data-placement="right" title="Simple Tooltip">doloremque laudantium</span>, totam rem aperiam, eaque ipsa quae ab illo inventore
          <br/>veritatis et quasi <span class="accent-color sh-tooltip" data-placement="bottom" title="Simple Tooltip">architecto</span> beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p> -->


        <!-- Start Team Members -->
        <div class="row mb-1em">

            <?php
            $i = 0;
            foreach ($cate_coure as $cate_coure_data) {
            $i++;
            ?>

          <!-- Start Memebr 1 -->
          <div class="col-md-3 col-sm-6 col-xs-12" data-animation="fadeIn" data-animation-delay="03">
            <div class="team-member modern">
              <!-- Memebr Photo, Name & Position -->
              
              <div class="member-photo">
                  <?php echo Controller::ImageShowIndex(Yush::SIZE_THUMB, $cate_coure_data, $cate_coure_data->pic, array()); ?>
                <div class="member-name"><?= $cate_coure_data->name ?>
                <!-- <span>50:00 นาที</span> -->
                </div>
              </div>
              <?php 
              if(!Yii::app()->user->isGuest) {
              $userid = Yii::app()->user->id;
              $cpd = CpdLearning::model()->findByAttributes(array('user_id'=>$userid,'course_id'=>$cate_coure_data->id,'active'=>1));
                if($cpd->pic_id_card){
                  $id_card_cpd = 'have';
                }else {
                  $id_card_cpd = 'no';
                }
              }
              ?>
              <!-- Memebr Words -->
              <a href="<?= $this->createUrl('/course/index/', array('id'=>$_GET['id'], 'cate_course_id' => $cate_coure_data->id)); ?>">
              <div class="member-info">
                <p><?= $cate_coure_data->name ?></p>
              </div>
              </a>
            </div>
          </div>
          <!-- End Memebr 1 -->
            <?php } ?>

        </div>

        <!-- End Team Members -->

      </div>
    </div>
    <!-- End content -->

  </div>
  <!-- End Container -->

  <!-- Go To Top Link -->
  <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>