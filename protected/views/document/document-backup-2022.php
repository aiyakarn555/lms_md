<?php
if(empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}
if (Yii::app()->session['lang'] == 2) {
    // $langId = Yii::app()->session['lang'] = 1;
    $txt_doc = "เอกสารดาวน์โหลด";
} else {
    // $langId = Yii::app()->session['lang'];
    $txt_doc = "Latest Document";
}

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    //$strMonthCut = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_docs  ?></li>
        </ol>
    </nav>
</div>


<section class="content" id="document">
    <div class="container">

        <div class="row justify-content-between align-items-end mb-3">
            <div class="col-7 col-md-8 col-lg-9">
                <h4 class="topic mb-0"> <?= $txt_doc ?></h4>
            </div>
            <!-- <div class="col-5 col-md-4 col-lg-3">
                <input class="form-control text-3" type="text" style="width: 100%;" placeholder="Type a search term">
            </div> -->
        </div>

        <div class="tab-content mt-20">

            <?php $DocumentType = DocumentType::model()->findAll('active = 1 and lang_id =' . $langId) ?>
            <div role="tabpanel" class="tab-pane fade in active" id="doc-1">
                <div class="well">
                    <div class="panel panel-default">
                        <?php foreach ($DocumentType as $key => $doctype) { ?>
                            <div class="panel-heading">
                                <a role="button" data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                                    <h2 class="panel-title">
                                        <li><i class="fa fa-file">&nbsp;&nbsp;</i><?= $doctype->dty_name ?></li>
                                    </h2>
                                </a>
                            </div>
                            <div id="collapse<?= $key ?>">

                            <table class="table table-condensed table-document ">
                                <thead>
                                    <tr>
                                        <td width="10%">No.</td>
                                        <td class="text-left">Document Name</td>
                                        <td width="20%">Announced Date</td>
                                        <td width="15%"></td>
                                    </tr>
                                </thead>
                                <tbody>    
                                <?php 
                                $i = 1;
                                foreach ($Document as $doc) {
                                    if ($doctype->dty_id == $doc->dty_id) { //3
                                ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td class="text-left"><?= $doc->dow_name ?></td>
                                            <td><?php echo DateThai($doc->dow_createday); ?></td>
                                            <td>
                                                <a class="btn btn-download text-white" href="<?= Yii::app()->baseUrl ?>/admin/uploads/<?= $doc->dow_address ?>" download="<?= Yii::app()->baseUrl ?>/admin/uploads/<?= $doc->dow_address ?>" type="button">Download</a>
                                            </td>
                                        </tr>
                                <?php

                                    }
                                }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<iframe id="my_iframe" style="display:none;"></iframe>
<script>
    function Download() {
        var url = '/lms_plm/admin/uploads/58832_300x300.jpg';
        document.getElementById('my_iframe').src = url;
    };
</script>