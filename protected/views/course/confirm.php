<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
if (Yii::app()->session['lang'] == 2) {
    $courseconfirm = "ยืนยันการจองหลักสูตร";
    $confirm = "ยืนยัน";
    $cancel = "ยกเลิก";
   
} else {
    $courseconfirm = "Course Confirmation";
    $confirm = "Confirm";
    $cancel = "Cancel";
}
?>
<?php
$id_course_picture = $course->course_id;
if (!$flag) {
    $modelChildren  = CourseOnline::model()->find(array('condition' => 'lang_id = ' . $langId . ' AND parent_id = ' . $course->course_id, 'order' => 'course_id'));
    if ($modelChildren) {
        $course->course_title = $modelChildren->course_title;
        $course->course_short_title = $modelChildren->course_short_title;
        $course->course_detail = $modelChildren->course_detail;
        $course->course_picture = $modelChildren->course_picture;
        $id_course_picture = $modelChildren->course_id;
    }
}
?>

<style type="text/css">
    .sweet-alert {
        z-index: 999999999999999999;

    }

    .swal2-container {

        z-index: 999999999999999999;

    }
</style>
<section class="content-page" id="">
    <div class="container-main">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"> <?= $langId == 1 ? "Course Detail" : "รายละเอียดหลักสูตร" ?></li>
            </ol>
        </nav>

        <div class="content">
            <div class="row p-2 back-page ">
                <?php 
                $link = Yii::app()->createUrl('course/bookingdetail/', array('id' => $course->id));
                 ?>
                <a class="btn-back-page" href="<?=$link?>">
                    <i class="fas fa-chevron-left"></i> <?= $langId == 1 ? "Back" : "ย้อนกลับ" ?>
                </a>
            </div>

            <div class="">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="p-4 bg-white">
                             <div class="text-center">
                                  <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/wallet.png" class=" " width="200px">
                             </div>


                            <?php if ($cou_pri) { ?>
                                <?php 
                                if($_GET['tempoldid'] != null){
                                $tex = $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน";
                                }else{
                                $tex = $langId == 1 ? "Bookingcourse" : "จองหลักสูตร";
                                }


                                 ?>
                                <div class="row justify-content-center">
                                   <div class="col">
                                        <a data-toggle="modal" data-target="#course-booking" class="btn btn-booking"><?= $tex ?></a>
                                   </div>
                                </div>

                            <?php }else{ ?>
                               <div class="row justify-content-center">
                                    <div class="col">
                                        <a onclick="mybooking()" class="btn btn-booking w-200"><i class="fas fa-check"></i> <?= $langId == 1 ? "Confirmation of booking" : "ยืนยันการจอง" ?></a>
                                    </div>
                                </div>
                            <?php } ?>

                                 <div class="row justify-content-center">
                                    <div class="col">
                                         <!-- <a onclick="" class="btn btn-booking w-200"><i class="fas fa-file-invoice"></i> <?= $langId == 1 ? "Payment" : "ชำระเงิน" ?></a> -->
                                         <a data-toggle="modal" data-target="#course-booking" class="btn btn-booking-outline w-200"><i class="fas fa-file-invoice"></i>&nbsp;<?= $langId == 1 ? "Payment" : "ชำระเงิน" ?></a>
                                    </div>
                                 </div>

                                 <?php if($course->document_status == "y"){ ?>
                                    <div class="row justify-content-center">
                                       <div class="col">
                                        <a data-toggle="modal" data-target="#course-uploadfile" class="btn btn-booking-outline w-200"><i class="fas fa-file-invoice"></i>&nbsp;<?= $langId == 1 ? "Upload Document" : "แนบไฟล์เอกสาร" ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</section>
<!--  -->
<form action="<?php echo $this->createUrl('course/bookingsave') ?>" id="frmsave" name="frmsave" method="post" class="needs-validation" enctype="multipart/form-data">
    <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
    <input type="hidden" name="type_price" value="<?= $type_pri ?>">
</form>

<div class="modal fade " id="course-video" tabindex="-1" role="dialog" aria-labelledby="course-video">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">ตัวอย่างหลักสูตร</h4>
            </div>
            <div class="modal-body">
                <video width="100%" muted controls preload="auto">
                    <source src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $course->intro_video ?>">
                </video>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="course-booking" tabindex="-1" role="dialog" aria-labelledby="course-booking">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">จ่ายเงินเพื่อจองหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">

                <form action="<?php echo $this->createUrl('course/bookingsave') ?>" id="frmsavepay" name="frmsavepay" method="post" class="needs-validation" enctype="multipart/form-data">

                    <div class="pay-course">
                        <h4>ธนาคารที่โอนเข้า</h4>
                        <?php
                        $modelbank = BankNameRelations::model()->findAll(array(
                            'condition' => 'course_id = "' . $course->course_id . '"'
                        ));
                        ?>

                        <?php foreach ($modelbank as $key => $valueb) {
                            ?>
                            <div class="row row-pay align-items-center">

                                <input type="radio" id="test-<?= $valueb->banks->id ?>" name="chkbank" class="custom-control-input custom" value="<?= $valueb->banks->id ?>">
                                <img class="mx-2" src="<?php echo Yii::app()->baseUrl; ?>/uploads/bank/<?= $valueb->banks->id ?>/<?= $valueb->banks->bank_images ?>" width="80" alt="">

                                <div class="account-bank" >
                                <h4 class="">ธนาคาร : <span class="text-main"><?= $valueb->banks->bank_name ?></span></h4>
                                <h4 class="">ชื่อบัญชี : <span class="text-main"><?= $valueb->banks->account_name ?></span></h4>
                                <h4 class="">หมายเลขบัญชี : <span class="text-main"><?= $valueb->banks->account_number ?></span></h4>
                                
                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <input type="hidden" name="course_id" value="<?= $course->course_id ?>" id="course_id_payment">
                    <input type="hidden" name="type_price" value="<?= $type_pri ?>" id="type_price_payment">

                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">จำนวนเงินที่โอน</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="money" placeholder="" id="money">
                                        <div class="input-group-addon">บาท</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-4 col-xs-12">
                                <div class="form-group">
                                    <label for="">วันเวลาที่โอน</label>
                                    <input type="datetime-local" class="form-control" name="date_slip" placeholder="" id="date_slip">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <h4>อัพโหลดหลักฐานการชำระเงิน</h4>
                        <input type="file" name="file_payment" accept="image/png , image/jpg , image/jpeg" id="file_payment" class="form-control" style="height:40px;">
                    </div>

                </form>

                <button type="button" onclick="mybooking('pay')" id="b3" class="btn btn-booking">ยืนยันการจอง</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="course-uploadfile" tabindex="-1" role="dialog" aria-labelledby="course-uploadfile">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">แนบเอกสารเพื่อจองหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">

                <form action="<?php echo $this->createUrl('course/courseuploaddocument') ?>" id="frmsavedocument" name="frmsavedocument" method="post" class="needs-validation" enctype="multipart/form-data">
                    <p class="text-danger">
                        <i class="fa fa-info-circle"></i> หมายเหตุ : <?= isset($note) ? $note->note : '-' ;?>
                    </p>
                    <input type="hidden" name="course_id" value="<?= $course->course_id ?>" id="course_id_upload">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="documentattch">
                             <!-- <div class="pay-course">
                                 <h4>เอกสารแนบ</h4>
                                 <input type="file" multiple name="file_document[]" accept="image/png , image/jpg , image/jpeg , application/pdf" id="file_document" class="form-control" style="height:40px;">
                             </div> -->
                             </div>
                        </div>
    
                         <!-- form fuction เพิ่มลบได้   -->
                         <div class="col-sm-12">
                             <input type="hidden" id="document-group" value="1">
                             <!-- <div id="documentattch"></div> -->
                         </div>
                         <div class="col-sm-12">
                             <a href="#" class="btn btn-add" onClick="addFormField(); return false;"><i class="fas fa-plus"></i> เพิ่มเอกสาร</a>
                         </div>
                         <!-- form fuction เพิ่มลบได้   -->
                    </div>
                </form>
                <script>
                     addFormField();
                    function addFormField() {
                        // // var id = document.getElementById("document-group").value;
                        var id = $( ".txtFile" ).length+1;
                        $("#documentattch").append(
                            "<div class='pay-course' id='row" +
                            id +
                            "'><label for='txt" +
                            id +
                            "'class='txtFile'>เอกสารแนบที่ " +
                            id +'</label>'+
                            "<div class='flex-upload'><input  type='file' name='file_document[]' accept='image/png , image/jpg , image/jpeg , application/pdf' class='upload-h40 form-control' size='20' name='txt[]' id='txt" +
                            id +
                            "'>&nbsp;&nbsp<a href='#' class='btn-remove btn' onClick='removeFormField(\"#row" +
                            id +
                            "\"); return false;'>ลบ</a></div><div>"
                        );
                        // id = id - 1 + 2;
                        // document.getElementById("document-group").value = id;
                    }

                    async function removeFormField(id) {
                        $(id).remove();
                        await resetTxtFile();
                    }

                    function resetTxtFile(){
                        var id = 0;
                        $("#documentattch > .pay-course").each(function (i)
                        {    
                            id = i+1;
                            $(this).attr("id","row"+id);
                            $(this).find( ".txtFile" ).attr("for","txt"+id);
                            $(this).find( ".txtFile" ).text("เอกสารแนบที่ "+id);
                        });
                    }
                </script>

                <button type="button" onclick="myupload('upload')" id="b3" class="btn btn-booking">อัพโหลดเอกสาร</button>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    function mybooking($type = null) {  

       
        if($type == null){
            var cou_ti = "<?= $course->course_title ?>";
                Swal.fire({
                    title: 'ยืนยันการอัพโหลดหลักฐานการชำระเงิน',
                    text: cou_ti,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก',
                }).then((result) => {
                    if (result.value) {
                        document.getElementById("frmsave").submit();
                    }
                })
        }else{
            if (document.getElementById("file_payment").files.length > 0) {
                var cou_ti = "<?= $course->course_title ?>";
                Swal.fire({
                    title: 'ยืนยันการอัพโหลดหลักฐานการชำระเงิน',
                    text: cou_ti,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก',
                }).then((result) => {
                    if (result.value) {
                        var fileslip = new FormData();
                        fileslip.append('chkbank',$("input[name='chkbank']").val());
                        fileslip.append('course_id',$("#course_id_payment").val());
                        fileslip.append('type_price',$("#type_price_payment").val());
                        fileslip.append('money',$("#money").val());
                        fileslip.append('date_slip',$("#date_slip").val());
                        fileslip.append('type','confirm');
                        $.each($("#file_payment"), function(i, obj) {
                            $.each(obj.files,function(j, file){
                                fileslip.append('file_payment', file);
                            })
                        });
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('course/bookingsave'); ?>",
                            type: "POST",
                            data: fileslip,  
                            enctype: 'multipart/form-data',
                            processData:false,
                            contentType:false, 
                            success: function(result) {
                                if(result == 'success'){
                                    $('#course-booking').modal('toggle');
                                    swal("อัพโหลดสำเร็จ", "", "success");
                                }else{
                                    swal("อัพโหลดไม่สำเร็จ", "กรุณาอัพโหลดเอกสารอีกครั้ง", "error");
                                }                       
                            }
					    });
                    }
                })
            }else{
                swal("กรุณาอัปโหลดหลักฐานการชำระเงิน", "", "warning");
            }
        }


        
        // var cou_ti = "<?= $course->course_title ?>";
        // Swal.fire({
        //     title: 'ยืนยันการจองหลักสูตร',
        //     text: cou_ti,
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'ยืนยัน',
        //     cancelButtonText: 'ยกเลิก',
        // }).then((result) => {
        //     // if (result.value) {
        //     //     if ($type != null) {
        //     //         console.log(document.getElementById("file_payment").files.length == 0);
        //     //         if (document.getElementById("file_payment").files.length == 0) {
        //     //             swal("กรุณาอัปโหลดหลักฐานการชำระเงิน", "", "error");
        //     //             return false;
        //     //         } else {
        //     //             document.getElementById("frmsavepay").submit();
        //     //         }

        //     //     } else {
        //     //         document.getElementById("frmsave").submit();
        //     //     }
        //     // }
        // })
    }

    function myupload($type = null) {
        const lengthFileDocField = $( ".txtFile" ).length;
        var values = $("input[name='file_document[]']")
              .map(function(){return $(this).val();}).get();
        values = values.filter(i => i != '');
        const lengthFileDocUpload =  values.length;
        if(lengthFileDocField == lengthFileDocUpload){
                var cou_ti = "<?= $course->course_title ?>";
                Swal.fire({
                title: 'ยืนยันการอัพโหลดเอกสาร',
                text: cou_ti,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.value) {
                    var filedocument = new FormData();
                    filedocument.append('course_id',$('#course_id_upload').val());
                    filedocument.append('type','confirm');
                    $.each($("input[name='file_document[]']"), function(i, obj) {
                            $.each(obj.files,function(j, file){
                                filedocument.append('file_document[]', file);
                            })
                    });
                    $.ajax({
                        type: "POST", 
                        url: '<?php echo $this->createUrl('course/courseuploaddocument'); ?>',
                        data: filedocument,  
                        enctype: 'multipart/form-data',
                        processData:false,
                        contentType:false, 
                        success: function(result) {
                            if(result == 'success'){
                                $('#course-uploadfile').modal('toggle');
                                swal("อัพโหลดสำเร็จ", "", "success");
                            }else{
                                swal("อัพโหลดไม่สำเร็จ", "กรุณาอัพโหลดเอกสารอีกครั้ง", "error");
                            }
                           
                        }
                    });
                    // document.getElementById("frmsavedocument").submit();
                }
            })
        }else{
            swal("อัพโหลดเอกสารไม่ครบ", "กรุณาอัพโหลดเอกสารอีกครั้ง", "warning");
        }
    }
</script>