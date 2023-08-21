<section class="content-page" id="faq">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $label->label_faq ?></li>
            </ol>
        </nav>
        <div class="content-main">

            <div class="panel-group faq-collapse" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">


                    <?php foreach ($faq_type as $keytype => $value) { ?>
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="text1">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?=$keytype?>" aria-expanded="true" aria-controls="collapseOne">
                                <span class="accordion-lable"><?=$keytype+1?>.) <?= $value->faq_type_title_TH; ?> </span> &nbsp;
                                <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                            </a>
                        </h4>
                    </div>
                    <?php
                    $criteria = new CDbCriteria();
                    $criteria->condition = 'active="y"';
                    $criteria->compare('lang_id', Yii::app()->session['lang']);
                    $criteria->compare('faq_type_id', $value->faq_type_id);
                    $criteria->order = 'sortOrder ASC ,create_date DESC';
                    $faqfrist = Faq::model()->findAll($criteria);
                    if (count($faqfrist) > 0) { ?>
                        <!-- show detail -->
                        <div id="collapse-<?=$keytype?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <?php
                            if (count($faqfrist) > 0) {
                                foreach ($faqfrist as $key => $value) {
                                    ?>
                                    <div class="panel-body">
                                        <div class="well" style="background-color: #fff7be;">
                                            <h4><b><?= $label->label_ques ?> : </b></h4>
                                            <p><?php echo htmlspecialchars_decode($value->faq_THtopic) ?></p>
                                        </div>
                                        <div class="well">
                                            <h4><b><?= $label->label_ans ?> : </b></h4>
                                            <p><?php echo htmlspecialchars_decode($value->faq_THanswer) ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    <?php } else { ?>
                        <div id="collapse-<?=$keytype?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="well">
                                    <?= $label->label_noTopic ?>
                                    <p><?= $label->label_noDetail ?></p>
                                </div>
                            </div>
                        </div>
                    <?php  } ?>
                    <!-- end show detail -->
                <?php } ?>







                </div>
                
            </div>
        </div>
        <!-- end loop -->
    </div>
</section>