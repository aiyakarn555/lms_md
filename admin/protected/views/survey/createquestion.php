<div class="innerLR">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>คำถาม</h4>
        </div>
        <div class="widget-body">
            <div class="row-fluid">
                <div class="form">
                    <p class="note">ค่าที่มี <?php echo $this->NotEmpty(); ?> จำเป็นต้องใส่ให้ครบ</p>

                    <div class="span12">
                        <label for="inputTitle">หมวดคำถาม</label>
                        <select class="span6">
                            <option>test1</option>
                            <option>test2</option>
                        </select>
                    </div>

                    <div class="buttons" style="margin-left: 10px;">
                        <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons circle_plus'), '<i></i>เพิ่มคำถาม'); ?>
                        <div class="separator"></div>
                    </div>
                    <div class="innerLR" style="width: 50%;">
                        <div class="widget" style="margin-top: -1px;">
                            <div class="widget-head">
                                <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>คำถามที่ 1</h4>
                            </div>
                            <div class="widget-body">
                                <div class="row-fluid">
                                    <div class="tabsbar tabsbar-2">
                                        <ul class="row-fluid row-merge">
                                            <li class="span3 glyphicons circle_question_mark active"><a href="#tab1-4"
                                                                                         data-toggle="tab"><i></i>
                                                    คำถาม</a></li>
                                            <li class="span3 glyphicons circle_ok"><a href="#tab2-4"
                                                                                        data-toggle="tab"><i></i>
                                                    คำตอบ</a></li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1-4">
                                            <h4>คำถาม</h4>
                                            <div class="span12">
                                                <label for="inputTitle">TH คำถาม</label>
                                                <input type="text" id="inputTitle" class="span10" value=""/>
                                                <?php echo $this->NotEmpty();?>
                                            </div>

                                            <div class="span12">
                                                <label for="inputTitle">EN คำถาม</label>
                                                <input type="text" id="inputTitle" class="span10" value=""/>
                                                <?php echo $this->NotEmpty();?>
                                            </div>

                                            <div class="span12">
                                                <label for="inputTitle">TH คำอธิบาย</label>
                                                <textarea class="span10" rows="3"></textarea>
                                                <?php echo $this->NotEmpty();?>
                                            </div>

                                            <div class="span12">
                                                <label for="inputTitle">EN คำอธิบาย</label>
                                                <textarea class="span10" rows="3"></textarea>
                                                <?php echo $this->NotEmpty();?>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab2-4">
                                            <div class="innerLR">
                                                <div class="widget" style="margin-top: -1px;">
                                                    <div class="widget-head">
                                                        <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>คำถามที่ 1</h4>
                                                    </div>
                                                    <div class="widget-body">
                                                        <div class="row-fluid">
                                                            <div class="buttons" style="margin-left: 10px;">
                                                                <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons circle_plus'), '<i></i>เพิ่มคำตอบย่อย'); ?>
                                                            </div>
                                                            <div class="span12">
                                                                <label for="inputTitle">ประเภทคำถาม</label>
                                                                <select class="span12">
                                                                    <option>บรรยาย</option>
                                                                    <option>หลายตัวเลือก</option>
                                                                </select>
                                                            </div>
                                                            <div class="span12">
                                                                <label for="inputTitle">คะแนน</label>
                                                                <input type="text" id="inputTitle" class="span2" value=""/>
                                                            </div>
                                                            <div class="span12">
                                                                <label for="inputTitle">TH คำตอบ</label>
                                                                <input type="text" id="inputTitle" class="span10" value=""/>
<!--                                                                --><?php //echo $this->NotEmpty();?>
                                                            </div>

                                                            <div class="span12">
                                                                <label for="inputTitle">EN คำตอบ</label>
                                                                <input type="text" id="inputTitle" class="span10" value=""/>
<!--                                                                --><?php //echo $this->NotEmpty();?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons" style="margin-left: 10px;">
                        <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2'), '<i></i>บันทึกข้อมูล'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>