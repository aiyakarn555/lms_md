<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
?>
<div class="parallax overlay cover-image-full home">
    <?php include('themes/bws/include/slide.php'); ?>
</div>
<div class="container">

    <div class="row mg-t-m">
        <div class="col-md-3">
            <div class="row mg-bt-s">
                <div class="col-md-12" id="login">
                    <div class="page-header">
                        <h1><small style="background-color: #dfd5e9;">ลงชื่อเข้าสู่ระบบ</small></h1>
                    </div>
                    <form action="" method="POST" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="input">Username</label>
                            <input type="text" name="" id="input" class="form-control" value="" required="required" pattern="" title="">
                        </div>
                        <div class="form-group">
                            <label for="input">Password</label>
                            <input type="password" name="" id="input" class="form-control" required="required" title="">
                        </div>
                        <a href="#"> <span class="glyphicon glyphicon-exclamation-sign"></span> ลืมรหัสผ่าน</a>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1">
                                จดจำผู้เข้าใช้งาน
                            </label>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-warning btn-xs">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mg-bt-s">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><small>เมนูเกี่ยวข้อง</small></h1>
                    </div>
                    <video width="100%" controls>
                        <source src="<?= Yii::app()->theme->baseUrl ?>/videos/serminar_22-07-59.mp4" type="video/mp4">
                        <!-- <source src="mov_bbb.ogg" type="video/ogg"> -->
                        Your browser does not support HTML5 video.
                    </video>
                </div>
            </div>
            <div class="row mg-bt-s" id="btn-menu-index">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><small>เมนูเกี่ยวข้อง</small></h1>
                    </div>
                    <a href="http://vdo.dbdacademy.com/index.php/vdo/index" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/banner-con.jpg') no-repeat;height: 84px;" class="btn-dbd"></a>

                    <a href="http://www.dbd.go.th/main.php?filename=index#click" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/side_banner1.png') no-repeat;" class="btn-dbd"></a>

                    <a href="https://www.trustmarkthai.com/" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/side_banner2.png') no-repeat;" class="btn-dbd"></a>

                    <a href="http://www.dbdacademy.com/index.php?page=comment" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/bannerQA.png') no-repeat;" class="btn-dbd"></a>

                    <a href="http://newsletter.dbd.go.th/" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/banner_e-newsletter.png') no-repeat;" class="btn-dbd"></a>

                    <a href="http://magazine.dbd.go.th/" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/banner_e-magazine.png') no-repeat;" class="btn-dbd"></a>

                    <a href="http://164.115.40.68/" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/banner-young2.png') no-repeat;" class="btn-dbd"></a>

                    <a href="http://www.dbdacademy.com/vaivdo2/" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/banner_vaivdo.png') no-repeat;" class="btn-dbd"></a>
                    
                    <a href="http://www.dbd.go.th/more_news.php?cid=170" style="background: url('<?= Yii::app()->theme->baseUrl ?>/images/img_menu/blue.png') no-repeat;" class="btn-dbd"></a>
                </div>
            </div>
            <div class="row mg-bt-s">
                <div class="col-md-12">
                <div class="page-header">
                        <h1><small>Facebook</small></h1>
                    </div>
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FDBDAcademy&tabs=DBDAcademy&width=340&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="214" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                    <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fwww.facebook.com%2FDBDAcademy&layout=button_count&size=small&mobile_iframe=true&width=78&height=20&appId" width="78" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe> 
                </div>
            </div>
        </div>
        <div class="col-md-9" style="padding-left: 2em;">
            <div class="row mg-bt-s">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><small>หลักสูตรของเรา </small></h1>
                    </div>
                    <div class="row crouse">
                        <div class="col-md-12 group-out">
                            <a href="#" class="img-group animated bounceIn">
                                <img src="<?= Yii::app()->theme->baseUrl ?>/images/icon/Untitled-1.png" alt="" class="img-responsive" data-toggle="tooltip" data-placement="left" title="หลักสูตร DBD Academy">
                            </a>
                            <h4 class="text-center animated fadeInUp">หลักสูตร DBD Academy</h4>
                            <div class="course">
                                <div class="list-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-book"></span>
                                                หลักสูตรพาณิชย์อิเล็กทรอนิกส์เบื้องต้น
                                            </a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-book"></span> หลักสูตรพัฒนากลยุทธ์พาณิชย์อิเล็กทรอนิกส์</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-book"></span> หลักสูตรเริ่มต้นธุรกิจแบบมืออาชีพ</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-book"></span> หลักสูตรการเริ่มต้นธุรกิจแฟรนไชส์
</a>
                                            
                                        </div>
                                        <div class="col-md-6">
                                        <a href="#" class="list-group-item"><span class="glyphicon glyphicon-book"></span> หลักสูตรการประกอบธุรกิจยุคการค้าเสรี</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-book"></span> หลักสูตรบัญชีและธรรมาภิบาลธุรกิจ</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-book"></span> หลักสูตรวิชาบัญชี (นับชั่วโมง CPD)</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-book"></span>
                                                หลักสูตรภาษาธุรกิจต่างประเทศ
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mg-t-m crouse">
                                <div class="col-md-12 group-out">
                                    <a href="#" class="img-group animated bounceIn">
                                        <img src="<?= Yii::app()->theme->baseUrl ?>/images/icon/Untitled-2.png" alt="" class="img-responsive" data-toggle="tooltip" data-placement="left" title="หลักสูตร Vdo on demand">
                                    </a>
                                    <h4 class="text-center animated fadeInUp">หลักสูตร Vdo on demand</h4>
                                    <div class="course">
                                        <div class="list-group" style="min-height: 260px;">
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-film"></span>
                                                 VDO งานสัมมนา “Smart Business Solution for SMEs”
                                            </a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-film"></span>  หลักสูตรพัฒนาแนวคิดต่อยอดธุรกิจ ด้านนวัตกรรม</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-film"></span>  แนะนำธุรกิจ Startup พร้อมเครื่องมือที่จะมําช่วย SMEs ให้ดำเนินธุรกิจได้ง่ําย สะดวก และรวดเร็ว</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-film"></span>  หลักสูตรด้านการบริหารจัดการ</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-film"></span>  หลักสูตร e-Commerce</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-film"></span>  หลักสูตรด้านการตลาด</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-film"></span>  หลักสูตรด้านการเงินและการบัญชี</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mg-t-m crouse">
                                <div class="col-md-12 group-out">
                                    <a href="#" class="img-group animated bounceIn">
                                        <img src="<?= Yii::app()->theme->baseUrl ?>/images/icon/Untitled-3.png" alt="" class="img-responsive" data-toggle="tooltip" data-placement="left" title="หลักสูตร Audio Leaning">
                                    </a>
                                    <h4 class="text-center animated fadeInUp">หลักสูตร Audio Leaning</h4>
                                    <div class="course">
                                        <div class="list-group" style="min-height: 260px;">
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-play-circle"></span>
                                                ธรรมาภิบาลภาคธุรกิจ
                                            </a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-play-circle"></span> กลยุทธ์ดึงดูดลูกค้าออนไลน์</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-play-circle"></span> เริ่มต้นธุรกิจแบบมืออาชีพ</a>
                                            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-play-circle"></span> หลักสูตร e-Commerce</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="row mg-bt-s mg-t-m" id="news">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><small>ข่าวสาร</small></h1>
                    </div>
                    <div role="tabpanel" class="hidden-xs">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#home" aria-controls="home" role="tab" data-toggle="tab">ข่าวประชาสัมพันธ์</a>
                            </li>
                            <li role="presentation">
                                <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">ข่าวเกี่ยวกับ DBD Academy</a>
                            </li>
                            <li role="presentation">
                                <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">ข่าวเกี่ยวกับ DBD Academy</a>
                            </li>
                        </ul>
                        
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home">
                                <div class="list-group">
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>
                                        Cras justo odio
                                    </a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Dapibus ac facilisis in</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Morbi leo risus</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Porta ac consectetur ac</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Vestibulum at eros</a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab1">
                                <div class="list-group">
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>
                                        Cras justo odio
                                    </a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Dapibus ac facilisis in</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Morbi leo risus</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Porta ac consectetur ac</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Vestibulum at eros</a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab2">
                                <div class="list-group">
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>
                                        Cras justo odio
                                    </a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Dapibus ac facilisis in</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Morbi leo risus</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Porta ac consectetur ac</a>
                                    <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Vestibulum at eros</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-group visible-xs" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-default">
                        <div class="panel-heading bg-dbd-y" role="tab" id="headingOne">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              ข่าวประชาสัมพันธ์
                            </a>
                          </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>
                                    Cras justo odio
                                </a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Dapibus ac facilisis in</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Morbi leo risus</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Porta ac consectetur ac</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Vestibulum at eros</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading bg-dbd-y" role="tab" id="headingTwo">
                          <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              ข่าวเกี่ยวกับ DBD Academy
                            </a>
                          </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>
                                    Cras justo odio
                                </a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Dapibus ac facilisis in</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Morbi leo risus</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Porta ac consectetur ac</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Vestibulum at eros</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading bg-dbd-y" role="tab" id="headingThree">
                          <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              ข่าวเกี่ยวกับ DBD Academy
                            </a>
                          </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                          <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>
                                    Cras justo odio
                                </a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Dapibus ac facilisis in</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Morbi leo risus</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Porta ac consectetur ac</a>
                                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Vestibulum at eros</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="clreafix"></div>
    <div class="row mg-t-s">
        <div class="col-md-12">
            <div class="page-header">
                <h1><small>ลิงค์แนะนำ</small></h1>
            </div>
            <div id="banner-slide" class="owl-carousel">
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/7.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/8.gif" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/9.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/10.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/11.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/12.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/1.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/2.png" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/3.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/4.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/5.jpg" alt="" height="50px" width="100%px"></a>
                <a href="#"><img src="http://www.dbdacademy.com/newtheme/images/link/6.jpg" alt="" height="50px" width="100%px"></a>
            </div>
        </div>
    </div>
</div>
<div class="clreafix"></div>
 <!-- End Container -->
<!-- <div class="container">
<div class="page-section-heading">
<h2 class="text-display-1" style="font-weight: bold;">ข่าวสาร</h2>
<p class="lead text-muted" style="color: black;">ข่าวสาร กิจกรรม และประกาศต่าง ๆ</p>
</div>
<div class="row" data-toggle="gridalicious">
<?php
$classcolor = array('btn-green-500', 'bg-purple-300', 'bg-orange-400', 'bg-cyan-400', 'bg-pink-400', 'bg-red-400');
$i = 0;
foreach ($news_data as $news) {
?>
<div class="media">
    <div class="media-left padding-none">
        <div class="<?php echo $classcolor[$i];?> text-white">
            <div class="panel-body">
                <i class="fa fa-newspaper-o fa-2x fa-fw"></i>
            </div>
        </div>
    </div>
    <div class="media-body">
        <div class="panel panel-default box-news">
            <div class="panel-body">
                <div class="text-headline" style="font-size: 23px;"><?= $news->cms_title; ?></div>
                <p style="font-size: 18px;"><?= iconv_substr($news->cms_short_title, 0, 150, 'utf-8'); ?> <a
                    href="<?= Yii::app()->createUrl('news/index/', array('id' => $news->cms_id)); ?>"
                title="<?= $news->cms_title; ?>">อ่านต่อ...</a></p>
            </div>
        </div>
    </div>
</div>
<?php $i++;
} ?>
</div>
</div> -->