<div class="innerLR">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>เพิ่มแบบสอบถาม</h4>
        </div>
        <div class="widget-body">
            <div class="row-fluid">
                <?php echo CHtml::form(); ?>
                <div style='padding:5%;'>
                    <?php echo CHtml::label('TH ชื่อหมวดคำถาม : ', '');
                    echo CHtml::textField('titleQuestionTH', $titleTH); ?></br>

                    <?php echo CHtml::label('EN ชื่อหมวดคำถาม : ', '');
                    echo CHtml::textField('titleQuestionEN', $titleEN); ?></br>

                    <?php echo CHtml::label('TH คำอธิบาย : ', '');
                    echo CHtml::textArea('titleDescriptionTH', $DescriptionTH); ?></br>

                    <?php echo CHtml::label('EN คำอธิบาย : ', '');
                    echo CHtml::textArea('titleDescriptionEN', $DescriptionEN); ?></br>

                    <?php
                    if ($type_button == 'VIEW') {
                        echo CHtml::submitButton('ตกลง', array('name' => $type_button, 'class' => 'btn btn-primary'));
                    } else {
                        echo CHtml::submitButton('ตกลง', array('name' => $type_button, 'confirm' => 'Are you sure?', 'class' => 'btn btn-primary'));
                    }
                    echo CHtml::submitButton('ยกเลิก', array('name' => 'Backward', 'class' => 'btn btn-primary', 'style' => 'margin-left:10px;')); ?></br>
                </div>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>
</div>
</div>