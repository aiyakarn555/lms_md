<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}
if (Yii::app()->session['lang'] == 2) {
    // $langId = Yii::app()->session['lang'] = 1;
    $txt_doc = "เอกสารดาวน์โหลด";
    $txtShow["LatestDocument"] = "เอกสารล่าสุด";
    $txtShow["Number"] = "ลำดับ";
    $txtShow["DocumentName"] = "ชื่อเอกสาร";
    $txtShow["AnnouncedDate"] = "วันที่ประกาศ";
    $txtShow["Download"] = "ดาวน์โหลด";

    $txtShow["InputToSearch"] = "พิมพ์คำค้นหาเอกสาร";
    $txtShow["Search"] = "ค้นหา";
} else {
    // $langId = Yii::app()->session['lang'];
    $txt_doc = "Latest Document";
    $txtShow["LatestDocument"] = "Latest Document";
    $txtShow["Number"] = "No.";
    $txtShow["DocumentName"] = "Document Name";
    $txtShow["AnnouncedDate"] = "Announced Date";
    $txtShow["Download"] = "Download";

    $txtShow["InputToSearch"] = "Input to search";
    $txtShow["Search"] = "Seach";


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

<section class="content-page" id="document">
    <div class="container-main">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $label->label_docs  ?></li>
            </ol>
        </nav>

        <div class="tab-content mt-20">

            <?php $DocumentType = DocumentType::model()->findAll('active = 1 and lang_id =' . $langId) ?>
            <div role="tabpanel" class="tab-pane fade in active" id="doc-1">
                <div class="well">
                    <div class="panel panel-default">
                        <div class="search-filter">
                            <form class="form row head-doc" enctype="multipart/form-data" id="vdo-form" action="<?php echo $this->createUrl('/document/index'); ?>" method="post"> 
                                <div class="dowload-document col-lg-3 p-0">
                                    <h4 class="topic"><?=$txtShow["LatestDocument"]?></h4>
                                </div>
                                <div class="search-document col-lg-5 p-0">
                                    <div class="wrapsearch">
                                        <div class="form-group mx-sm-3">
                                            <label for="inputPassword2" class="sr-only">Password</label>
                                            <input type="text" value="<?=$textold?>" name="dow_name" class="form-control" id="inputPassword2" placeholder="<?=$txtShow["InputToSearch"]?>">
                                        </div>
                                        <div class="wrap-btn-search">
                                            <button type="submit" class="btn btn-primary btn-search"><i class="fas fa-search "></i><?=$txtShow["Search"]?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php foreach ($DocumentType as $key => $doctype) {
                            $array_id_doc = array();
                            foreach ($doctype->document as $key => $value) {
                                $array_id_doc[] = $value->dow_id;
                            }
                            $criteriavdo = new CDbCriteria;
                            $criteriavdo->compare('active',1);
                            if(isset($_POST["dow_name"])){
                                $criteriavdo->compare('dow_name',$_POST["dow_name"],true);
                            }
                            $criteriavdo->AddInCondition("dow_id",$array_id_doc);
                            $Document = Document::model()->findAll($criteriavdo);
                            if(count($Document) > 0){ ?>

                                <div id="collapse<?= $key ?>">

                                    <table class="table table-condensed table-document ">
                                        <thead>
                                            <tr class="head-tb">
                                                <td width="10%"><?=$txtShow["Number"]?></td>
                                                <td class="text-left"><?=$txtShow["DocumentName"]?></td>
                                                <td width="20%"><?=$txtShow["AnnouncedDate"]?></td>
                                                <td width="15%"><?=$txtShow["Download"]?></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $i = 1;
                                            foreach ($Document as $doc) {
                                                ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td class="text-left"><?= $doc->dow_name ?></td>
                                                    <td><?php echo DateThai($doc->dow_createday); ?></td>
                                                    <td>
                                                        <a class="btn btn-download text-white" href="<?= Yii::app()->baseUrl ?>/admin/uploads/<?= $doc->dow_address ?>" download="<?= Yii::app()->baseUrl ?>/admin/uploads/<?= $doc->dow_address ?>" type="button"><?=$txtShow["Download"]?><i class="fas fa-file-download"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
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