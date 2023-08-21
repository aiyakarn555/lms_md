<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2 class="text-center" style="margin-bottom: 30px;">เข้าสู่ระบบ</h2>

                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">ชื่อผู้ใช้</label>

                                <div class="col-sm-9">
                                    <input class="form-control" id="inputEmail3" placeholder="ชื่อผู้ใช้..."
                                           type="email"><span class="ma-form-highlight"></span><span
                                        class="ma-form-bar"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">รหัสผ่าน</label>

                                <div class="col-sm-9">
                                    <input class="form-control" id="inputEmail3" placeholder="รหัสผ่าน..."
                                           type="email"><span class="ma-form-highlight"></span><span
                                        class="ma-form-bar"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-3" style="padding: 0;">
                                    <div class="checkbox">
                                        <input id="checkbox1" type="checkbox" checked>
                                        <label for="checkbox1">ให้ฉันอยู่ในระบบต่อไป</label>
                                    </div>
                                </div>
                                <div class="col-sm-3" style="padding-top:9px;">ลืมรหัสผ่าน</div>
                            </div>
                            <div class="form-group margin-none">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <a href="<?php echo $this->createUrl('#'); ?>"
                                       class="btn btn-primary">เข้าสู่ระบบ</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>