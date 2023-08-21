 <section class="content-page">
     <div class="container-main">
         <nav aria-label="breadcrumb">
             <ol class="breadcrumb breadcrumb-main">
                 <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                 <li class="breadcrumb-item active" aria-current="page"><?= $label->label_usability ?></li>
             </ol>
         </nav>
         <div class="content-main" id="manual">

             <section class="all-usability mt-3">
                 <div class="row">

                    <?php foreach ($usability_data as $usa) { ?>
                     <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-center mb-2">
                         <div class="card-second">
                             <a data-toggle="modal" href='#modal-manual-detail-<?= $usa->usa_id ?>'>
                               <?php 

                                 if(file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/usability/'.$usa->usa_id.'/'.$usa->usa_address) && $usa->usa_address){ ?>
                                    <img style="width: 225px;height: 150px;" src="<?= Yii::app()->baseUrl.'/uploads/usability/'.$usa->usa_id.'/'.$usa->usa_address; ?>" class="" alt=""> 
                                 <?php }else{ ?>
                                <img style="width: 225px;height: 150px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png" class="" alt=""> 
                                 <?php } ?>
                                 <br>
                                 <br>
                                 <p><?= $usa->usa_title?></p>
                             </a>
                         </div>
                     </div>


                    <div class="modal fade" id="modal-manual-detail-<?= $usa->usa_id ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                    <h4 class="modal-title"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo ($usa->usa_title); ?> </h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo htmlspecialchars_decode(htmlspecialchars_decode($usa->usa_detail)) ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>


                 <?php } ?>


                    
                     
                 </div>
             </section>


         </div>
     </div>
 </section>