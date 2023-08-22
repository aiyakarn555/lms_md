<!-- innerLR -->
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i><?php echo $formtext; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="title-uploadzoom">
                <h4>ชื่อห้องเรียนออนไลน์: <?= $model->name_ms_teams ;?></h4>
                <h5>วันที่: <?= Helpers::lib()->DateThaiNewNoTime($model->start_date)  ?></h5>
                <h5>เวลา: <?= substr(explode(" ",$model->start_date)[1],0,5)." น."  ;?></h5><!--  เวลาเริ่มต้น-สิ้นสุด -->
            </div>
            <form action="<?php echo $this->createUrl('MsTeams/UploadImageZoom') ?>" id="frmsavezoom" name="frmsavezoom" method="post" class="needs-validation" enctype="multipart/form-data">
            <!-- form -->
                <div class="form">
                    <p class="note">ค่าที่มี <?php echo $this->NotEmpty(); ?> จำเป็นต้องใส่ให้ครบ</p>
                    <div class="group-upload">
                    <div class="wrapper_form">
                            <input type="hidden" name="ms_teams_id" value="<?= $model->id ?>" />
                            <input type="hidden" name="user_id" value="<?= Yii::app()->user->getId() ?>" />
                            <input type="hidden" name="date" value="<?= explode(" ",$model->start_date)[0] ?>" />                 
                    </div>
                    </div>
                    <div class="">
                            <button type="button" class="btn btn-plus add_form_field" onclick="addFormField();"> เพิ่มรูปภาพ</button>
                    </div>
                    <br>
                    <div class="row buttons">
                        <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2'), '<i></i>บันทึกข้อมูล'); ?>
                    </div>
                </div>
            </form>
            <!-- form -->
        </div>
    </div>
</div>
<!-- END innerLR -->

<script>
    $(function() {
        init_tinymce();
        addFormField();
    });
    // function add form 

    function addFormField() {
        var x = $( ".img-index" ).length+1;
        if(x <= 10){
            $(".wrapper_form").append(
                '<div class="row-item-upload row-item item-upload-'+x+'"><p class="img-index">รูปภาพที่ '+(x)+' <?php echo $this->NotEmpty(); ?></p> <div class="row">'
                + '<div class="span5 d-flex align-center">'
                + '<input type="time" class="form-control m-0" name="time[]"> <button type="button" class="btn btn-danger remove-btn" onclick="removeField('+x+');">ลบ</button>'
                + '</div></div>'
                + '<div class="zoom-upload" >' 
                + '<label class="picture-upload" for="picture__input['+x+']" tabIndex="'+x+'" ><span class="picture__image" id="picture__image['+x+']">เลือกรูปภาพ</span></label>'
                + '<input type="file" accept="image/*" class="picture__input" name="picture__input[]" id="picture__input['+x+']" onchange="changeFile(this,'+x+')" style="display:none;">'
                + '</div></div>' 
            );
        }else{
            alert('จำกัดจำนวน 10 ครั้ง')
        }
    }

    function removeField(index){
        $('.item-upload-'+index).remove();
        resetIndex();
    }
    
    function resetIndex(){
        $('.row-item-upload').each(function(i, obj) {
            ++i;
            $(this).find('.img-index').html('รูปภาพที่ '+i);
            var item_upload = $(this).attr('class').split(' ')[2];
            $(this).removeClass(item_upload).addClass('item-upload-'+i);
            $(this).find('.remove-btn').attr('onclick', 'removeField('+i+')');
            $(this).find('.picture-upload').attr('for', 'picture__input['+i+']');
            $(this).find('.picture-upload').attr('tabindex', ''+i+'');
            $(this).find('.picture__image').attr('id', 'picture__image['+i+']');
            $(this).find('.picture__input').attr('name', 'picture__input['+i+']');
            $(this).find('.picture__input').attr('id', 'picture__input['+i+']');
            $(this).find('.picture__input').attr('onchange', 'changeFile('+'this,'+i+')');
        }); 
    }

    function changeFile(e,i){
        const inputTarget = e;
        const file = inputTarget.files[0];
        const pictureImage = $('[id="picture__image['+i+']"]');
        const pictureImageTxt = "เลือกรูปภาพ";
        if (file) {
            const reader = new FileReader();

            reader.addEventListener("load", function(e) {
                const readerTarget = e.target;
                const img = document.createElement("img");
                img.src = readerTarget.result;
                img.classList.add("picture__img");

                pictureImage.html("");
                pictureImage.append(img);
            });

            reader.readAsDataURL(file);
        } else {
            pictureImage.html(pictureImageTxt);
        }

    }

    var frm = $('#frmsavezoom');
    frm.submit(function (e) {
        e.preventDefault();

        var time = $("input[name='time[]']")
        .map(function() {
            return $(this).val();
        }).get();
        var file = $("input[name='picture__input[]']")
        .map(function() {
            return $(this).val();
        }).get();
        time = time.filter(i => i == '');
        file = file.filter(i => i == '');

        if(file.length > 0){
            swal("ไม่พบไฟล์!", "กรุณาอัพโหลดไฟล์", "warning");
            return false;
        }else if(time.length > 0){
            swal("เวลาไม่ถูกต้อง!", "กรุณาเลือกเวลา", "warning");
            return false;
        }

        if(file.length == 0 && time.length == 0){
            var formData = new FormData(this);
            $.ajax({
                async: true,
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.trim() == 'true'){
                        setTimeout(function() {
                            swal("อัพโหลดสำเร็จ!", "บันทึกเรียบร้อย", "success");   
                            location.href = "<?= $this->createUrl('CaptureScreen/ExportIndex',array('ms_temas'=>$model->id)) ?>";
                        }, 1000);
                    
                    }else{
                        setTimeout(function() {
                            swal("อัพโหลดไม่สำเร็จ!", "กรุณาลองอีกครั้ง", "error");  
                        }, 1000);
        
                    }       
                }
            });
        }
      
    });

     


    // function upload(){
    //     var time = $("input[name='time[]']")
    //         .map(function() {
    //             return $(this).val();
    //         }).get();
    //     var file = $("input[name='picture__input[]']")
    //     .map(function() {
    //         return $(this).val();
    //     }).get();
    //     time = time.filter(i => i == '');
    //     file = file.filter(i => i == '');


    //     // if(file.length > 0){
    //     //     swal("ไม่พบไฟล์!", "กรุณาอัพโหลดไฟล์", "warning");
    //     //     return false;
    //     // }else if(time.length > 0){
    //     //     swal("เวลาไม่ถูกต้อง!", "กรุณาเลือกเวลา", "warning");
    //     //     return false;
    //     // }
    // }
</script>