<div class="innerLR">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>ประเภทคำตอบ</h4>
        </div>
        <div class="widget-body">
            <div class="row-fluid">
                <div class="form">
                    <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
                    <div class="span12">
                        <label for="inputTitle">TH ชื่อประเภทคำตอบ</label>
                        <input type="text" id="inputTitle" class="span6" value=""/>
                        <?php echo $this->NotEmpty();?>
                    </div>

                    <div class="span12">
                        <label for="inputTitle">EN ชื่อประเภทคำตอบ</label>
                        <input type="text" id="inputTitle" class="span6" value=""/>
                        <?php echo $this->NotEmpty();?>
                    </div>

                    <div class="span12">
                        <label for="inputTitle">TH คำอธิบาย</label>
                        <textarea class="span6" rows="3"></textarea>
                        <?php echo $this->NotEmpty();?>
                    </div>

                    <div class="span12">
                        <label for="inputTitle">EN คำอธิบาย</label>
                        <textarea class="span6" rows="3"></textarea>
                        <?php echo $this->NotEmpty();?>
                    </div>

                    <div class="span12">
                        <label for="inputTitle">TH ข้อบังคับ</label>
                        <textarea class="span6" rows="3"></textarea>
                        <?php echo $this->NotEmpty();?>
                    </div>

                    <div class="span12">
                        <label for="inputTitle">EN ข้อบังคับ</label>
                        <textarea class="span6" rows="3"></textarea>
                        <?php echo $this->NotEmpty();?>
                        <div class="separator"></div>
                    </div>
                    <div class="buttons" style="margin-left: 10px;">
                        <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>