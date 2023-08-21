<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i class="fa fa-fw fa-book"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">ห้องเรียนเสมือน</h3>
                <p class="text-white text-subhead" style="font-size: 1.6rem;">รวมรายชื่อห้องเรียนเสมือนที่กำลัง ออนไลน์อยู่</p>
            </div>
        </div>
    </div>
</div>
<div class="container" style="min-height: 250px;">
    <div class="page-section">
        <div class="row">
            <div class="col-md-12">
                <div class="row" data-toggle="isotope">
                <?php
                require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
                $bbb = new BigBlueButton();

                /* ___________ GET MEETINGS FROM BBB SERVER ______ */
                /* 
                */

                /* 
                ---DEBUG - useful for manually checking the raw xml results.
                $test = $bbb->getGetMeetingsUrl();
                echo $test;
                 ---END DEBUG 
                */

                $itsAllGood = true;
                try {$result = $bbb->getMeetingsWithXmlResponseArray();}
                    catch (Exception $e) {
                        echo 'Caught exception: ', $e->getMessage(), "\n";
                        $itsAllGood = false;
                    }

                if ($itsAllGood == true) {
                    // If it's all good, then we've interfaced with our BBB php api OK:
                    if ($result == null) {
                        // If we get a null response, then we're not getting any XML back from BBB.
                        echo "ไม่สามารถติดต่อ Streaming Server ได้";
                    }   
                    else { 
                    // We got an XML response, so let's see what it says:
                        if ($result['returncode'] == 'SUCCESS') {
                            // Then do stuff ...
                            // You can parse this array how you like. For now we just do this:
                            $messageKey = (array)$result['messageKey'];
                            if($messageKey[0] == 'noMeetings'){
                                echo "ไม่พบห้องเรียนที่ออนไลน์อยู่ตอนนี้";
                            }else{
                                unset($result['returncode']);
                                unset($result['messageKey']);
                                unset($result['message']);
                    foreach ($result as $room){
                        $meetingId = (array)$room['meetingId'];
                        $meetingName = (array)$room['meetingName'];
                    ?>

                    <div class="item col-xs-12 col-sm-6 col-lg-4">
                        <div class="panel panel-default paper-shadow" data-z="0.5">
                            <div class="cover overlay cover-image-full hover">
                            <span class="img icon-block height-150 bg-default"></span>
                                <a href="<?php echo $this->createUrl('virtualclassroom/join',array('id'=>$meetingId[0])); ?>"
                                   class="padding-none overlay overlay-full icon-block bg-default" target="_blank">
                                        <span class="v-center">
                                        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/logo_course.png', 'No Image'); ?>
                                    </span>
                                </a>
                                <a href="<?php echo $this->createUrl('virtualclassroom/join',array('id'=>$meetingId[0])); ?>" class="overlay overlay-full overlay-hover overlay-bg-white" target="_blank">
                                    <span class="v-center">
                                        <span class="btn btn-circle btn-white btn-lg"><i class="fa fa-graduation-cap"></i></span>
                                    </span>
                                </a>
                        </div>
                        <div class="panel-body height-100">
                            <h4 class="text-headline margin-v-0-10" style="font-size: 23px;">
                                <a target="_blank" href="<?php echo $this->createUrl('virtualclassroom/join',array('id'=>$meetingId[0])); ?>"><?php echo $meetingName[0]; ?></a>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php 
                                } 
                            }
                        }
                        else {
                            echo "ไม่พบห้องเรียนที่ออนไลน์อยู่ตอนนี้";
                            // print_r($result);
                        }
                    }
                }
                ?>
                </div>
            </div>
    </div>
</div>
</div>