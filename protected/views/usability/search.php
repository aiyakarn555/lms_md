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

    <div class="container">
        <!--start total search-->
        <div class="text-center">
            <?php
            $search = usability::model()->findAll(array(
            'condition' => ' usa_title LIKE "%' . $text . '%" and active="y"'));
            
            
            $searchtotal = count($search);
            
            $total = $searchtotal ;
            ?>
            <strong>ผลลัพธ์ทั้งหมด : <?php echo $total; ?> รายการ</strong>
            <br><br>
        </div>
        <!--end total search-->
        <?php if($total !== 0) { ?>
        <!-- start usability search -->
        <?php
        $search1 = usability::model()->findAll(array(
            'condition' => ' usa_title LIKE "%' . $text . '%" and active="y"'));
        // var_dump($search1);
        if ($search1 == null){
            
        } else {
            echo "วิธีการใช้งาน";
            echo '<br>';
        }
        foreach ($search1 as $mod) {
            $str = $mod->usa_title;
            $str_id = $mod->usa_id;
            $keyword = $text;
            
            ?><div class="modal fade" id="modal-manual-detail-<?= $str_id ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                    <h4 class="modal-title"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo ($mod->usa_title); ?> </h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo htmlspecialchars_decode($mod->usa_detail) ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
            
            }
            ?>
        <!-- end usability search -->
        
        <?php }else{
            echo '<div class="well">';
            echo 'ไม่พบข้อมูลที่ต้องการค้นหา'  ;
            echo '</div>';
        } ?>
        
    </div>
<!-- Content -->

<?php
$usability_data = Usability::model()->findAll(array(
    'order' => 'create_date ASC',
    'condition' => 'active="y"',
        ));
?>

<section class="content" id="manual">
    <div class="container">
            
         <div class="row">
            <?php if($total !== 0) { ?>
        <!-- start usability search -->
        <?php 
        $search1 = usability::model()->findAll(array(
            'condition' => ' usa_title LIKE "%' . $text . '%" and active="y"'));
        // var_dump($search1);
        if ($search1 == null){
            
        } else 
                foreach ($search1 as $mod) {
            $str = $mod->usa_title;
            $str_id = $mod->usa_id;
            $keyword = $text; 
            ?>
                    <div class="col-sm-4 col-md-3">
                        <div class="well">
                            <div class="manual-icon">
                            <a data-toggle="modal" href='#modal-manual-detail-<?= $str_id ?>'>
                               <!--  <div class="manual-icon"><i class="fa fa-sign-in fa-3x" aria-hidden="true"></i></div> -->
                                <?php if(file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/usability/' .  $str_id.'/thumb/'.$mod->usa_address)){?>
                            <img src="<?= Yii::app()->baseUrl; ?>/uploads/usability/<?= $str_id.'/thumb/'.$mod->usa_address; ?>" width="auto" > 
                            <?php }else{ ?>
                            <div class="manual-icon"></i><i class="fas fa-info-circle fa-4x"></i></div>
                            <?php } ?>
                                <h4> <?php echo str_ireplace($keyword, '<span class="bg-primary">' . $keyword . '</span>', $str); ?></h4>
                            </a>
                            </div>
                        </div>
                    </div>   
                <?php } } else{
            echo '<div class="well">';
            echo 'ไม่พบข้อมูลที่ต้องการค้นหา'  ;
            echo '</div>';
        } ?>
    
        </div>
      
        <!-- Modal detail -->
    </div>
</section>