<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
?>

<div class="parallax cover overlay cover-image-full home">
    <!-- Initializing the slider -->
    <style>
        #layerslider * {
            font-family: Lato, 'Open Sans', sans-serif;
        }

        .ls-container, .ls-slide, .ls-inner, .ls-lt-container, .ls-bg {
            -webkit-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
            -moz-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
            -ms-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
            mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC);
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

    </style>
    <div id="full-slider-wrapper">
        <div id="layerslider" style="width: 1920px; height: 500px; max-width: 1920px;">
            <div class="ls-slide" data-ls="slidedelay:9000;transition2d:75,79;" style="left: 25px;">
                <img src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/bg.png" class="ls-bg"
                     alt="Slide background" style="width=100%;max-width: 1345px;"/>

                <img class="ls-l" style="top:0;left:0;white-space: nowrap;width: 100%;"
                     data-ls="offsetxin:0;durationin:2000;easingin:linear;offsetxout:0;durationout:6000;showuntil:1;easingout:linear;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/bg.png"
                     alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:1500;scalexin:0.8;scaleyin:0.8;scalexout:0.8;scaleyout:0.8;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/1.png"
                     alt="">


                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="offsetxin:0;delayin:2000;easingin:easeInOutQuart;scalexin:0.8;scaleyin:0.5;offsetxout:-800;durationout:1000;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/2.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;scalexin:0.8;scaleyin:0.8;scalexout:0.8;scaleyout:0.8;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/3.png"
                     alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:4000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 80% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/4.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:5000;rotatein:20;rotatexin:70;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/5.png"
                     alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:6000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/6.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:3500;delayin:6000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide3/7.png"
                     alt="">
            </div>

            <div class="ls-slide" data-ls="slidedelay:20000;transition2d:75,79;">
                <img src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/1.png" class="ls-bg"
                     alt="Slide background"/>
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:1000;rotatein:20;rotatexin:-60;scalexin:1.5;scaleyin:1.5;transformoriginin:left 10% 0;durationout:150;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/2.png"
                     alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:1500;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 80% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/3.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:2000;rotatein:20;rotatexin:70;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/4.png"
                     alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:2500;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/5.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:3000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 80% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/6.png"
                     alt="">


                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:3500;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/7.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:4000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/8.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:4500;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/9.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:5000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/10.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:5500;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/11.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:2500;delayin:6000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide4/12.png"
                     alt="">
            </div>

            <div class="ls-slide" data-ls="slidedelay:8000;transition2d:75,79;">
                <img src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide2/bg.png" class="ls-bg"
                     alt="Slide background"/><img class="ls-l"
                                                  style="top:0px;left:0px;white-space: nowrap;"
                                                  data-ls="offsetxin:0;durationin:2000;easingin:linear;offsetxout:0;durationout:6000;showuntil:1;easingout:linear;"
                                                  src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide2/bg.png"
                                                  alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:1000;scalexin:0.8;scaleyin:0.8;scalexout:0.8;scaleyout:0.8;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide2/1.png"
                     alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="offsetxin:0;delayin:2000;easingin:easeInOutQuart;scalexin:0.8;scaleyin:0.5;offsetxout:-800;durationout:1000;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide2/2.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:3000;delayin:2500;rotatein:20;rotatexin:-60;scalexin:1.5;scaleyin:1.5;transformoriginin:left 10% 0;durationout:150;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide2/3.png"
                     alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:3500;delayin:3000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 80% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide2/4.png"
                     alt="">
                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:3500;delayin:3500;rotatein:20;rotatexin:70;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide2/5.png"
                     alt="">

                <img class="ls-l" style="white-space: nowrap;"
                     data-ls="durationin:3500;delayin:4000;rotatein:20;rotatexin:30;scalexin:1.5;scaleyin:1.5;transformoriginin:left 50% 0;durationout:750;rotateout:20;rotatexout:-30;scalexout:0;scaleyout:0;transformoriginout:left 50% 0;"
                     src="<?= Yii::app()->theme->baseUrl ?>/images/sliderimages/slide2/6.png"
                     alt="">
            </div>
        </div>
    </div>
    <!-- Initializing the slider -->


</div>
<div class="container">
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
</div>
<br/>

</br>
<!--<div class="container">-->
<!--    <div class="page-section-heading">-->
<!--        <h2 class="text-display-1">วิธีใช้งาน</h2>-->
<!--        <p class="lead text-muted">วิธีการใช้งานอุปกรณ์ของบราเดอร์</p>-->
<!--    </div>-->
<!--    <div class="row" data-toggle="gridalicious">-->
<!--        <div class="media">-->
<!--            <div class="media-left padding-none">-->
<!--                <div class="bg-green-300 text-white">-->
<!--                    <div class="panel-body">-->
<!--                        <i class="fa fa-newspaper-o fa-2x fa-fw"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="media-body">-->
<!--                <div class="panel panel-default box-news">-->
<!--                    <div class="panel-body">-->
<!--                        <div class="text-headline">บราเดอร์ เปิดตัว ระบบ “โฮโลแกรม”</div>-->
<!--                        <p>บราเดอร์ ทั่วโลก เปิดตัว “โฮโลแกรมรับประกันสินค้าแท้ 100%” ถือเป็นวิธีการตรวจสอบสินค้าใหม่ล่าสุด เริ่มใช้ตั้งแต่เดือนพฤศจิกายนนี้เป็นต้นไป...</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="media">-->
<!--            <div class="media-left padding-none">-->
<!--                <div class="bg-purple-300 text-white">-->
<!--                    <div class="panel-body">-->
<!--                        <i class="fa fa-newspaper-o fa-2x fa-fw"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="media-body">-->
<!--                <div class="panel panel-default box-news">-->
<!--                    <div class="panel-body">-->
<!--                        <div class="text-headline">ชวนคนไทยถวายเครื่องพิมพ์บราเดอร์</div>-->
<!--                        <p>บราเดอร์   ร่วมกับสำนักงานพระพุทธศาสนาแห่งชาติ และบุ๊คสไมล์ ชวนคนไทยสร้างบุญปัญญา   เครื่องพิมพ์บราเดอร์เลเซอร์มัลติฟังก์ชั่น รุ่น...</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="media">-->
<!--            <div class="media-left padding-none">-->
<!--                <div class="bg-orange-400 text-white">-->
<!--                    <div class="panel-body">-->
<!--                        <i class="fa fa-newspaper-o fa-2x fa-fw"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="media-body">-->
<!--                <div class="panel panel-default box-news">-->
<!--                    <div class="panel-body">-->
<!--                        <div class="text-headline">เครื่องพิมพ์อิงค์เจทมัลติฟังก์ชั่น A3 </div>-->
<!--                        <p>บราเดอร์ ผู้นำนวัตกรรมเครื่องพิมพ์และอุปกรณ์การพิมพ์ ขอแนะนำ เครื่องพิมพ์อิงค์เจทมัลติฟังก์ชั่นสี รุ่นล่าสุด MFC-J3520 InkBenefit...</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
