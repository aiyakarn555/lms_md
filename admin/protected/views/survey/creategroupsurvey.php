<script>
    $(function() {
        $( "#from" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });
</script>
<div class="innerLR">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>เพิ่มชุดแบบสอบถาม</h4>
        </div>
        <div class="widget-body">
            <div class="row-fluid">
                <div class="form">
                    <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
                    <div class="span12">
                        <label for="inputTitle">TH ชื่อแบบสอบถาม</label>
                        <input type="text" id="inputTitle" class="span6" value=""/>
                        <?php echo $this->NotEmpty();?>
                    </div>

                    <div class="span12">
                        <label for="inputTitle">EN ชื่อแบบสอบถาม</label>
                        <input type="text" id="inputTitle" class="span6" value=""/>
                        <?php echo $this->NotEmpty();?>
                    </div>

                    <div class="form-inline">
                        <label for="from">เริ่ม</label>
                        <input type="text" id="from" name="from">
                        <label for="to">ถึง</label>
                        <input type="text" id="to" name="to">
                        <div class="separator"></div>
                    </div>
                    <div class="buttons" style="margin-left: 10px;">
                        <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons circle_plus'),'<i></i>เพิ่มคำถาม');?>
                        <div class="separator"></div>
                    </div>
                    <div class="innerLR" style="width: 50%;">
                        <div class="widget" style="margin-top: -1px;">
                            <div class="widget-head">
                                <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>คำถามที่ 1</h4>
                            </div>
                            <div class="widget-body">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <label for="inputTitle">หัวข้อ</label>
                                        <select class="span9">
                                            <option>test1</option>
                                            <option>test2</option>
                                        </select>
                                    </div>
                                    <div class="span12">
                                        <div class="widget-body uniformjs">
                                            <label class="checkbox">
                                                <input type="checkbox" class="checkbox" value="1" />
                                                คำตอบที่ 1
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" class="checkbox" value="1" checked="checked" />
                                                คำตอบที่ 2
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons" style="margin-left: 10px;">
                        <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>