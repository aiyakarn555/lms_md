<div class="innerLR">
    <div class="widget" data-toggle="collapse-widget" data-collapse-closed="false">
        <div class="widget-head">
            <h4 class="heading  glyphicons search"><i></i>ค้นหา</h4>
        </div>
        <div class="widget-body in collapse" style="height: auto;">
            <div class="search-form">
                <?php echo CHtml::form(); ?>

                <?php echo CHtml::textField('txtSearch', '', array('id' => 'txtSearch'
                , 'autocomplete' => 'off')); ?>
                <?php echo chtml::openTag('ul', array('id' => 'autocomplete')); ?>
                <?php echo chtml::closeTag('ul', array('id' => 'autocomplete')); ?>

                <?php echo CHtml::submitButton('ค้นหา', array('name' => 'btnSearch', 'class' => 'btn btn-primary', 'style' => 'margin-bottom:10px;')); ?>
                <?php /*echo CHtml::ajaxButton('ค้นหาข้อมูล',
		Yii::app()->createAbsoluteUrl('Questionnaire/actionGroupQuestion'),
		array(
	        'type' => 'POST', // รูปแบบการส่งข้อมูล POST | GET
	        'dataType' => 'text', // รูปแบบข้อมูล xml | json | jsonp | html | script | text
	        'data' => array('filter' => $this->txtSearch), // ข้อมูลที่ส่งไป
	        'beforeSend' => 'function(){
	            alert("ข้อความก่อนส่งข้อมูลไปยัง URL");
	        }',
	        'success' => 'function(data){
	            alert(data);
	        }',
	    )
	);*/ ?>
            </div>
        </div>
    </div>
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>เพิ่มแบบสอบถาม</h4>
        </div>
        <div class="widget-body">
            <div class="row-fluid">
                <?php echo CHtml::openTag('table', array('class' => 'table table-hover')); ?>
                <?php echo CHtml::openTag('thead'); ?>
                <?php echo CHtml::openTag('tr'); ?>
                <?php //echo CHtml::tag('th', array(), CHtml::checkBox('gqCheck',false));?>
                <?php echo CHtml::tag('th', array(), 'ลำดับ'); ?>
                <?php echo CHtml::tag('th', array(), 'หมวดคำถาม TH'); ?>
                <?php echo CHtml::tag('th', array(), 'หมวดคำถาม EN'); ?>
                <?php echo CHtml::tag('th', array(), 'ดู'); ?>
                <?php echo CHtml::tag('th', array(), 'แก้ไข'); ?>
                <?php echo CHtml::tag('th', array(), 'ลบ'); ?>

                <?php echo CHtml::closeTag('tr'); ?>
                <?php echo CHtml::closeTag('thead'); ?>

                <?php
                foreach ($model as $rows) {
                    echo CHtml::openTag('tr');

                    //Row
                    echo CHtml::tag('td', array(), ++$startnum);
                    //Name TH
                    echo CHtml::tag('td', array(), $rows->Tit_cNameTH);
                    //Name EN
                    echo CHtml::tag('td', array(), $rows->Tit_cNameEN);
                    //View
                    echo CHtml::tag('td', array(),
                        CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/theme/images/icon/view.png'),
                            array('Questionnaire/ManageTitleQuestion', 'stat' => 'VIEW', 'id' => $rows->Tit_nID))
                    );
                    //Edit
                    echo CHtml::tag('td', array(),
                        CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/theme/images/icon/edit.png'),
                            array('Questionnaire/ManageTitleQuestion', 'stat' => 'EDIT', 'id' => $rows->Tit_nID))
                    );
                    //Delete
                    echo CHtml::tag('td', array(),
                        CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/theme/images/icon/del.png'),
                            array('Questionnaire/ManageTitleQuestion', 'stat' => 'DEL', 'id' => $rows->Tit_nID))
                    );


                    echo CHtml::closeTag('tr');
                    //echo $rows->Gqu_cNameEN;  // แสดงข้อมูล field attribute_name
                }
                echo CHtml::closeTag('table');

                if ($countpage > 1) {
                    for ($i = 1; $i <= $countpage; $i++) {
                        echo CHtml::link(CHtml::button($i, array('class' => 'btn btn-primary')),
                            array('Questionnaire/TitleQuestion', 'page' => $i, 'filter' => $filter)
                        );
                    }
                }

                echo CHtml::link(CHtml::button('เพิ่มข้อมูล', array('class' => 'btn btn-primary')),
                    array('Questionnaire/ManageTitleQuestion', 'stat' => 'ADD')
                );
                echo CHtml::link(CHtml::button('ลบทั้งหมด', array('class' => 'btn btn-primary', 'style' => 'margin-left:10px;')),
                    array('Questionnaire/ManageTitleQuestion', 'stat' => 'DELALL'
                    ), array('confirm' => 'Do you want to delete all?')
                );
                ?>

                <?php echo CHtml::endForm(); ?>

            </div>
        </div>
    </div>
</div>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/jquery/jquery-1.11.3.min.js"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#txtSearch").keyup(function () {
            if ($('#txtSearch').val().length > 0) {
                $.post("index.php?r=Questionnaire/ACTitleQuestion", {
                        filter: $('#txtSearch').val()
                    }
                    , function (result) {
                        if (result.length > 4) {
                            $('#autocomplete').html(result);
                        } else {
                            $('#autocomplete').html(null);
                        }
                    }
                );
            } else {
                $('#autocomplete').html(null);
            }
        });
    });
</script>

<style>
    #autocomplete {
        position: absolute;
        z-index: 999;
    }
</style>


