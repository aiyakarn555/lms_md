<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<!-- <script src="<?php echo Yii::app()->theme->baseUrl; ?>/base_assets/dist/js/jwplayer_init.js" type="text/javascript"></script> -->
<script type="text/javascript">jwplayer.key="J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<?php
$formtext = 'จัดการ PDF';
$formNameModel = 'File';

?>


<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'id'=>'file-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true
    ),
    'errorMessageCssClass' => 'label label-important',
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); 

?>

<?php

//Display seconds as hours, minutes and seconds
function sec2hms ($sec, $padHours = true)
{

    // start with a blank string
    $hms = "";

    // do the hours first: there are 3600 seconds in an hour, so if we divide
    // the total number of seconds by 3600 and throw away the remainder, we're
    // left with the number of hours in those seconds
    $hours = intval(intval($sec) / 3600);

    // add hours to $hms (with a leading 0 if asked for)
    $hms .= ($padHours)
    ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
    : $hours. ":";

    // dividing the total seconds by 60 will give us the number of minutes
    // in total, but we're interested in *minutes past the hour* and to get
    // this, we have to divide by 60 again and then use the remainder
    $minutes = intval(($sec / 60) % 60);

    // add minutes to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

    // seconds past the minute are found by dividing the total number of seconds
    // by 60 and using the remainder
    $seconds = intval($sec % 60);

    // add seconds to $hms (with a leading 0 if needed)
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

    // done!
    return $hms;

}
// $imageSlide = PdfSlide::model()->findAll('file_id=:file_id', array(':file_id'=>$id));
$imageSlide = PdfSlide::model()->findAll(array("condition" => "file_id = '".$id."'","order" => "image_slide_time")); ?>
<div class="widget-body">
    <div class="form">
        <div class="row">
            <?php echo $form->labelEx($model,'file_name'); ?>
            <?php echo $form->textField($model,'file_name',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
            <?php echo $form->fileField($model,'file_pdf'); ?>
            <?php if (isset($error["video_file"])) { ?>
                <?php if ($error["video_file"] == "Required") { ?>
                    <span class="text-danger">กรุณาเลือกไฟล์วิดีโอ</span>
                <?php }else{ ?>
                    <span class="text-danger">กรุณาเลือกไฟล์วิดีโอด้วยนามสกุล 'mp4','mp3','mkv'</span>
                <?php } ?>
            <?php } ?>
            <?php echo $this->NotEmpty();?>
            <?php echo $form->error($model,'file_name'); ?>
        </div>
    </div>
</div>

<?php if(!empty($imageSlide)){
    ?>
    <div class="widget-body">
        <div class="form">
            <div class="row ">
                <ul class="thumbnails">
                    <?php
                    foreach ($imageSlide as $key => $imageSlideItem) {
                        if(count($imageSlide)==1){
                            $name = '';
                        } else {
                            $name = '-'.$imageSlideItem->image_slide_name;
                        }
                        ?>
                        <li class="col-md-3 <?= $imageSlideItem->image_slide_id ?>">
                            <div class="thumbnail timepicker">
                                <a href="<?php echo Yii::app()->baseUrl."/../uploads/pdf/".$id."/slide".$name.".jpg?time=".time(); ?>" rel="prettyPhoto"><img class="slide" src="<?php echo Yii::app()->baseUrl."/../uploads/pdf/".$id."/slide".$name.".jpg?time=".time(); ?>" alt="<?php echo $imageSlideItem->image_slide_name; ?>"></a>
                                <h3 class="numberHeader"><?php echo $imageSlideItem->image_slide_time+1; ?></h3>
                                <p>เวลา (ชั่วโมง : นาที : วินาที)</p>
                                <div class="input-append">
                        <input data-format="hh:mm:ss" type="text" class="time" name="time[<?php echo $imageSlideItem->image_slide_id; ?>]" value="<?php echo gmdate("H:i:s",$imageSlideItem->image_slide_next_time);?>" style="width: auto !important;"><!-- <span class="add-on">
                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                            </i>
                        </span> -->
                    </div>
                </div>
            </li>
            <?php
        }
        ?>
    </ul>
</div>
</div>
</div>

<?php
}
?>
<div class="widget-body">
    <div class="form">
        <div class="row">
            <?php
            $this->widget(
                'booster.widgets.TbButton',
                array('buttonType' => 'submit', 'size' => 'default', 'icon' =>'fa fa-floppy-o' , 'label' => 'บันทึกข้อมูล','context' => 'primary','htmlOptions'=> array('onclick' => 'upload()'),)
            );
            $this->endWidget(); 
            unset($form);
            ?>
        </div>
    </div>
</div>

<script>
    function upload()
    {
        swal({
            title: "โปรดรอสักครู่",
            text: "ระบบกำลังอัพโหลด",
            type: "info",
            showConfirmButton: false
        });
    }
    
    $(function() {
        InitialSortTable(); 
    });

    function InitialSortTable(){
    // $(".js-table-sortable").sortable({
    //     placeholder: "ui-state-highlight",
    //     forcePlaceholderSize: true,
    //     forceHelperSize: true,
    //     items: 'ul li',
    //     handle: '.thumbnail',
    //     update : function() {
    //         serial = $(".js-table-sortable").sortable("serialize", {key:"item[]", attribute: "class"});
    //         $.ajax({
    //             url : '<?php echo Yii::app()->request->baseUrl. '/index.php/filePdf/sort' ?>',
    //             type : "POST",
    //             data : serial,
    //             success : function(data) {
    //                 console.log("sorted: "+ serial);
    //             },
    //             "error": function(request, status, error) {
    //                 alert("We are unable to set the sort order at this time.  Please try again in a few minutes.");
    //             }
    //         });
    //     },
    //     // helper: fixHelper
    // }).disableSelection();

    $('.js-table-sortable').sortable({
        items: 'ul li',
        forceHelperSize: false,
        forcePlaceholderSize: true,
        tolerance: 'pointer',
        axis: 'x,y',
        update : function () {
            serial = $('.js-table-sortable').sortable('serialize', {key: 'items[]', attribute: 'class'});
            $.ajax({
                'url': '<?php echo Yii::app()->request->baseUrl. '/index.php/filePdf/sort' ?>',
                'type': 'post',
                'data': serial,
                'success': function(data){
                    console.log("sorted: "+ serial);
                    alert('บันทึกข้อมูล');
                },
                'error': function(request, status, error){
                    alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
                }
            });
        },
    });
    $('.js-table-sortable').disableSelection();
}
</script>