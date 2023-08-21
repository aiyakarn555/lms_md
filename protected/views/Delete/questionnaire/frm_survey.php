<?php echo CHtml::form('','',array('id'=>'form'));?>
<div class="parallax bg-white page-section">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media v-middle">
            <div class="media-body">
                <h1 class="text-display-2 margin-none"><?php echo $Model[0]['Gna_cNameTH'];?></h1>

                <p class="text-light lead"><?php echo $Model[0]['Gna_cNameTH'];?></p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="text-center bg-transparent margin-none">

    </div>
    <div class="page-section">
        <div class="panel panel-default head-assessment">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h3><?php echo $Model[0]['Gna_cNameTH'];?></h3>
                </div>
                <div class="col-md-6 text-right">
                    <h4>Date : <?php echo date('d M Y');?></h4>
                </div>
                <div class="col-md-12">
                    ASC Basic Training Cause (Inkjet BH11 Series)
                </div>
                <div class="col-md-6 text-left">
                    วิทยากร Mr.Kitichai Visessiri
                </div>
                <div class="col-md-6 text-right">
                    Brother Commercial (Thailand) Limited
                </div>
                <div class="col-md-12">
                    โปรดแสดงความคิดเห็นโดยการทำเครื่องหมาย ( ) ลงช่องความคิดเห็นของท่าน
                </div>
                <div class="col-md-12">
                    <ul class="asesst" style="padding-left: 0px;">
                        <li><b>ระดับประเมิน</b></li>
                        <li>5 = ดีมาก</li>
                        <li>4 = ดี</li>
                        <li>3 = ปานกลาง</li>
                        <li>2 = พอใช้</li>
                        <li>1 = ปรับปรุง</li>
                    </ul>
                </div>
            </div>
        </div>
<?php 
    include(realpath("themes/bws/views/questionnaire/survey_include.php"));
    $cls = new survey_include;
    $cls->survey($Model);
    echo CHtml::submitButton('',array('name'=>'btnSubmit','id'=>'btnSubmit','style'=>'display:none'));
?>

</div>
</div>
<?php echo CHtml::endForm();?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/jquery/jquery-1.11.3.min.js"); ?>
<script type='text/javascript'>
    function rdoCheck(tagId){
        $('input[name='+tagId.name+']').removeClass('UnChecked').addClass('Checked');
    }
    $('#btnCheck').click(function(){
        if($('#form .UnChecked').length==0){
            $('#btnSubmit').trigger('click');
        }else{
            $('#form .UnChecked').focus();
        }
    });
</script>
<style>
    .asesst {
        list-style-type: none;
        margin-bottom: 40px;
    }

    .asesst li {
        float: left;
        margin-right: 20px;
    }

    .head-assessment {
        padding-left: 20px;
        padding-right: 20px;
    }

    thead {
        background-color: #94CFFF;
    }

    .mb-assessment {
        margin-bottom: 10px;
    }
    .form-control{
        border: 1px solid #D1D1D1;
    }
    .radio label::before {
        border: 1px solid #4193D0;
    }
    .checkbox label::before {
        border: 1px solid #4193D0;
    }
    .radio {
        padding-left: 30px;
    }
</style>