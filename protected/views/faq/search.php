<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
    <div class="container">
        <h1>ผลการค้นหา
            <small class="pull-right">
                <ul class="list-inline list-unstyled">
                    <li><a  href="<?php echo $this->createUrl('/site/index'); ?>">หน้าแรก</a></li>/
                    <li><a href="#">ผลการค้นหา</a></li>
                </ul>
            </small>
        </h1>
    </div>
    <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
</div>

<!-- Content -->
<style>
    .text1{
        color: #333;
    }
    body a { color: #333; }
    body a:hover, body a:focus {color: #ffffff;text-decoration: none;}
</style>

    <!-- Content -->
    <?php
$criteria=new CDbCriteria();
        $criteria->condition = 'active="y"';

        $faq_data=Faq::model()->findAll($criteria);

?>
<section class="content" id="faq">
    <div class="container">
            <!-- แสดงผลลัพ -->
        <div class="text-center">
            <?php
            $search = FaqType::model()->findAll(array(
            
            'condition' => ' faq_type_title_TH LIKE "%' . $text . '%" and active="y"'));
            
            
            $searchtotal = count($search);
            
            
            $total = $searchtotal;
            ?>
            <strong>ผลลัพธ์ทั้งหมด : <?php echo $total; ?> รายการ</strong>
            <br><br>
        </div>
            <!-- end show detail -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php if($total !== 0) { ?>
                <!-- start usability search -->
                <?php
                $search1 = FaqType::model()->findAll(array(
                'condition' => ' faq_type_title_TH LIKE "%' . $text . '%" and active="y"'));
                // var_dump($search1);
                if ($search1 == null){
                    
                } else {
                    echo "ถาม-ตอบ";
                    echo '<br>';
                } ?>
                <!-- show detail -->
        <?php foreach ($search1 as $key => $value) { ?>
            <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="text1">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?=$value->faq_type_id  ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?php echo str_ireplace($text, '<span class="bg-primary">' . $text . '</span>',$value->faq_type_title_TH); ?>
                                <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                            </a>
                        </h4>
                    </div>
            <?php foreach ($faq_data as $key) { 
              if ($value->faq_type_id == $key->faq_type_id) { ?>
                <div id="collapse-<?=$value->faq_type_id  ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="well">
                                    <?= $key->faq_THtopic; ?>
                                    <p><?php echo htmlspecialchars_decode($key->faq_THanswer) ?></p>
                                </div>
                            </div>
                        </div>
                <?php }else{ ?>
                    <div id="collapse-<?=$value->faq_type_id  ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="well">
                                   ยังไม่มี เนื้อหา
                                    <p>ติดต่อ แอดมิน</p>
                                </div>
                            </div>
                        </div>
              <?php }
            }?>
                <!-- end show detail -->
          </div> 
        <?php }  }else{
                    echo '<div class="well">';
                    echo 'ไม่พบข้อมูลที่ต้องการค้นหา'  ;
                    echo '</div>';
                } ?>
      
        </div>
    </div>
</section>