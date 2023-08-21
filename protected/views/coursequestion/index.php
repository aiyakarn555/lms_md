<style>
    .quiz {
        list-style-type: none;
        margin-bottom: 40px;
    }

    .quiz li {
        float: left;
        margin-right: 20px;
    }

    .head-quiz {
        padding-left: 20px;
        padding-right: 20px;
    }

    thead {
        background-color: #94CFFF;
    }

    .mb-quiz {
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
    .ml-15{
        margin-left: 15px;
    }
    .mb-10{
        margin-bottom: 15px;;
    }
    .span5 {
        width: 500px;
    }
</style>
<div class="parallax bg-white page-section">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media v-middle">
            <div class="media-body">
                <h1 class="text-display-2 margin-none">แบบทดสอบ</h1>

                <!--                <p class="text-light lead">แบบประเมินผลการอบรม</p>-->
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="text-center bg-transparent margin-none">

    </div>
    <div class="page-section">
        <div class="panel panel-default head-quiz">
            <div class="row">
                <div class="col-md-12 col-sm-12" style="margin-top: 20px;margin-bottom: 30px;text-align: center;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/head-subject/quiz.png" alt="person" style="margin-top: -15px;"/><span style="font-size: 50px;color: rgb(0, 183, 243);">แบบทดสอบ</span></div>
                <div class="col-md-12 col-sm-12">1)
                    เอาอะไรไปคูณกับจำนวนเต็ม ผลลัพธ์จะน้อยลงกว่าเดิม
                </div>
                <div class="col-md-12 col-sm-12 ml-15">
                    <div class="radio radio-info">
                        <input name="radio2" id="radio1" value="option2" type="radio">
                        <label for="radio1">จำนวนเต็ม</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio2" id="radio2" value="option2" type="radio">
                        <label for="radio2">เศษส่วนแท้</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio2" id="radio3" value="option2" type="radio">
                        <label for="radio3">เศษส่วนเกิน</label>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">2)
                    เขาขอยืมเงินกองกลาง..............จ่ายไปก่อน
                </div>
                <div class="col-md-12 col-sm-12 ml-15">
                    <div class="radio radio-info">
                        <input name="radio21" id="radio11" value="option2" type="radio">
                        <label for="radio11">ทดลอง</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio21" id="radio21" value="option2" type="radio">
                        <label for="radio21">ทดหนี้</label>
                    </div>
                    <div class="radio radio-info">
                        <input name="radio21" id="radio31" value="option2" type="radio">
                        <label for="radio31">ทดรอง</label>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">3)
                    ท่านได้รับทราบข้อมูลเดี่ยวกับตัวสินค้าบราเดอร์จากที่ใด
                </div>
                <div class="col-md-12 col-sm-12 ml-15">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox41" name="ccc" type="checkbox">
                        <label for="checkbox41">วิทยุ</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox42" name="ccc" type="checkbox">
                        <label for="checkbox42">หนังสือพิมพ์</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox43" name="ccc" type="checkbox">
                        <label for="checkbox43">นิตยสาร</label>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">4)
                    คุณภาพที่ไดรับจากการใช้สินค้าบราเดอร์
                </div>
                <div class="col-md-12 col-sm-12 ml-15">
                    <div class="checkbox checkbox-info">
                        <input id="checkbox51" name="ccc" type="checkbox">
                        <label for="checkbox51">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox52" name="ccc" type="checkbox">
                        <label for="checkbox52">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                    <div class="checkbox checkbox-info">
                        <input id="checkbox53" name="ccc" type="checkbox">
                        <label for="checkbox53">จากสื่อ สิ่งพิมพ์ดังต่อไปนี้</label>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 ">5)
                    ท่านได้รับทราบข้อมูลเดี่ยวกับตัวสินค้าบราเดอร์จากที่ใด
                </div>
                <div class="col-md-12 col-sm-12 mb-quiz">
                    <div class="form-group" style="margin-top: 15px;">
                        <textarea class="form-control span5" rows="3" placeholder="ที่อยู่"></textarea>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 mb-assessment" style="margin-bottom: 40px;">
                    <a href="#" class="navbar-btn btn btn-primary">ส่งข้อสอบ</a>
                </div>
            </div>
        </div>
    </div>
</div>
