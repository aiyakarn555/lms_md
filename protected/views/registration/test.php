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
    <div id="layerslider" style="width:100%;height:500px;">
        <div class="ls-slide" data-ls="slidedelay:8000;transition2d:75,79;">
            <img src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/bg.png" class="ls-bg" alt="Slide background"/><img class="ls-l"
                                                                                      style="top:0px;left:0px;white-space: nowrap;"
                                                                                      data-ls="offsetxin:0;durationin:2000;easingin:linear;offsetxout:0;durationout:6000;showuntil:1;easingout:linear;"
                                                                                      src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/bg.png"
                                                                                      alt="">


            <img class="ls-l" style="top:50px;left:770px;white-space: nowrap;width: 450px;" data-ls="offsetxin:50;durationin:3000;rotateyin:60;transformoriginin:right 50% 0;"
                 src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/1.png"
                 alt="">
            <img class="ls-l" style="top:200px;left:780px;white-space: nowrap;width: 450px;" data-ls="offsetxin:-50;durationin:3000;delayin:500;rotateyin:-60;transformoriginin:left 50% 0;"
                 src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/2.png"
                 alt="">
            <img class="ls-l" style="top:20px;left:70px;white-space: nowrap;" data-ls="durationin:5000;scalexin:0.8;scaleyin:0.8;scalexout:0.8;scaleyout:0.8;"
                                                                                                                                   src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/3.png"
                                                                                                                                   alt="">
            <img class="ls-l" style="top:20px;left:420px;white-space: nowrap;" data-ls="offsetxin:200;durationin:2000;delayin:1500;offsetxout:200;durationout:1000;parallaxlevel:2;"
                 src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/4.png"
                 alt="">

            <img class="ls-l" style="top:350px;left:450px;white-space: nowrap;" data-ls="offsetxin:-200;durationin:2800;delayin:1800;offsetxout:200;durationout:1000;parallaxlevel:1;"
                 src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/5.png"
                 alt="">

            <img class="ls-l" style="top:350px;left:50px;white-space: nowrap;" data-ls="offsetxin:200;durationin:3200;delayin:1800;offsetxout:200;durationout:1000;parallaxlevel:1;"
                 src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/6.png"
                 alt="">

            <img class="ls-l" style="top:20px;left:10px;white-space: nowrap;" data-ls="offsetxin:-200;durationin:2800;delayin:1800;offsetxout:200;durationout:1000;parallaxlevel:1;"
                 src="<?=Yii::app()->theme->baseUrl?>/images/sliderimages/slide/7.png"
                 alt="">


        </div>
    </div>
</div>
<!-- Initializing the slider -->

