<?php
$baseUrl = Yii::app()->baseUrl;
?>
<link href="<?php echo $baseUrl; ?>/js/video-js/video-js.css" rel="stylesheet" type="text/css">
<link href="<?php echo $baseUrl; ?>/js/video-js/splitter/src/touchsplitter.css" rel="stylesheet"/>
<script src="<?php echo $baseUrl; ?>/js/video-js/splitter/src/jquery.touchsplitter.js"></script>
<script src="<?php echo $baseUrl; ?>/js/video-js/video.js"></script>
<style type="text/css">

	.video-js {max-width: 100%} /* the usual RWD shebang */

	.video-js {
	    width: auto !important; /* override the plugin's inline dims to let vids scale fluidly */
	    height: auto !important;
	}

	.video-js video {position: relative !important;}
	/* The video should expand to force the height of the containing div.
	One in-flow element is good. As long as everything else in the container
	div stays `position: absolute` we're okay */
	.split-me>div{
	  background: #444;
	}
	.split-me>div:first-child{
	  background: #555;
	}
	.split-me>div:last-child{
	  background: #666;
	}

	.vjs-progress-control {
	  display: none;
	}

	.split-me-container {
	  position: absolute;
	  top: 3em;
	  left: 1em;
	  right: 1em;
	  bottom: 1em;
	  border-radius: 6px;
	  overflow: hidden;
	}

	.splitter-bar {
	  background: #333;
	}

</style>
<script>
  videojs.options.flash.swf = "video-js.swf";
</script>
<?php
$this->breadcrumbs = array(
  'หมวดหลักสูตรอบรมออนไลน์'=>array('//cateOnline/index'),
  'บทเรียนออนไลน์ที่สั่งซื้อ'=>array('//courseOnline/userbuy'),
   $model->title,
);
?>
<style>
.thumbnail { height: 430px; }
.span216 { height: 450px; float: left; margin: 0 7px; }
.btn { margin-right: 5px; }
.jwplayer{width: 100% !important; height: 430px !important;}
</style>
 <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jwplayer/jwplayer.js?var=<?php echo rand(1,999); ?>" ></script>
<script type="text/javascript">jwplayer.key="J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<script type="text/javascript">
function isCanvasSupported(){
  var elem = document.createElement('canvas');
  return !!(elem.getContext && elem.getContext('2d'));
}
$(function(){
  if(!isCanvasSupported()){
    alert('Browser คุณไม่ Support กรุณาใช้ Browser ที่ Support เช่น Chrome, Firefox, IE 9 ขึ้นไป เป็นต้น');
    $(".lessonContent").remove();
  }
  $( "label" ).click(function() {
    $(".jwplayer").each(function(index,element){
      jwplayer(this.id).stop();
    });
  });
});
</script>

<div class="bs-example">
  <h5><?php echo $model->title; ?></h5>

  <div class="lessonContent">

    <div class="accordion" id="accordion2">
    <?php
    $idx = 1;
    if(count($model->files)):
      $user = Yii::app()->getModule('user')->user();
      $uploadFolder = Yii::app()->getUploadUrl("lesson");

      foreach ($model->files as $file):
        $learnFiles = Helpers::lib()->checkLessonFile($file);

        if($learnFiles == "notLearn")
        {
            $statusValue = CHtml::image(Yii::app()->baseUrl.'/images/icon_checkbox.png', 'ยังไม่ได้เรียน', array(
              'title' => 'ยังไม่ได้เรียน',
              'style' => 'margin-bottom: 8px;',
            ));
        }
        else if($learnFiles == "learning")
        {
            $statusValue = CHtml::image(Yii::app()->baseUrl.'/images/icon_checklost.png', 'เรียนยังไม่ผ่าน', array(
              'title' => 'เรียนยังไม่ผ่าน',
              'style' => 'margin-bottom: 8px;',
            ));
        }
        else if($learnFiles == "pass")
        {
            $statusValue = CHtml::image(Yii::app()->baseUrl.'/images/icon_checkpast.png', 'ผ่าน', array(
              'title' => 'ผ่าน',
              'style' => 'margin-bottom: 8px;',
            ));
        }
      ?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle <?php echo ($idx == 1)?'active':''; ?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $file->id; ?>">
            <?php
            if($file->file_name == '')
            {
              $fileNameCheck = '-';
            }
            else
            {
              $fileNameCheck = $file->file_name;
            }
            ?>
            <?php echo '<div style="float: left;" id="imageCheck'.$file->id.'">'.$statusValue .'</div> '. $fileNameCheck; ?>
          </a>
        </div>
        <div id="collapse<?php echo $file->id; ?>" class="accordion-body collapse in">
          <div class="accordion-inner">
            <div class="thumbnail">
				    <div class="split-me" id="split-me<?php echo $idx;?>" style="height:1000px;">
					    <div>
					      <video id="example_video_<?php echo $idx;?>" class="video-js vjs-default-skin" controls preload="none" 
					          data-setup="{}">
					        <source src="<?php echo $uploadFolder.$file->filename;?>" type='video/mp4' />
					        <!-- <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
					        <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' /> -->
					        <!-- <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track> --><!-- Tracks need an ending tag thanks to IE9 -->
					        <!-- <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track> --><!-- Tracks need an ending tag thanks to IE9 -->
					        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
					      </video>
					    </div>

					    <div>

  					    <div class="col-sm-9" id="showslide<?php echo $idx;?>">

  					    </div>

  					    <div class="col-sm-3" style="height:480px; overflow:auto; padding:0;">
    					    <?php
      						$imageSlide = ImageSlide::model()->findAll('file_id=:file_id', array(':file_id'=>$file->id));
      						if(!empty($imageSlide)){
      							foreach ($imageSlide as $key => $imageSlideItem) {
      						?>
      					      <img src="<?php echo Yii::app()->baseUrl."/uploads/ppt/".$file->id."/slide-".$imageSlideItem->image_slide_name.".JPG"; ?>" id="slide<?php echo $idx;?>_<?php echo $key; ?>" class="slidehide<?php echo $idx;?>" style="display:none; width:100%" data-time="<?php echo $imageSlideItem->image_slide_time; ?>">
      					    <?php
      							}
      						}
      						?>
  					    </div>


					    </div>
					  </div>

					<script type="text/javascript">
						var myPlayer<?php echo $idx;?> = videojs('example_video_<?php echo $idx;?>');
						$('.slidehide<?php echo $idx;?>').click(function(event) {
							/* Act on the event */
							$('#showslide<?php echo $idx;?>').html($(this).clone());
							myPlayer<?php echo $idx;?>.currentTime($(this).attr('data-time'));
						});

						myPlayer<?php echo $idx;?>.on('play',function(){
							$.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>',{
								id        : <?php echo $file->id; ?>,
								learn_id  : <?php echo $learn_id; ?>
							 	},function(data){
							    	$('#imageCheck'+data.no).html(data.image);
							});
						});

						myPlayer<?php echo $idx;?>.on('ended',function(){
							$.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>',{
							    id        : <?php echo $file->id; ?>,
							    learn_id  : <?php echo $learn_id; ?>,
							    status    : "success"
							      },function(data){
							        $('#imageCheck'+data.no).html(data.image);
							});
						});

						myPlayer<?php echo $idx;?>.on('timeupdate',function(){
							//console.log(myPlayer<?php echo $idx;?>.currentTime());
							<?php
							if(!empty($imageSlide)){
								foreach ($imageSlide as $key => $imageSlideItem) {
							?>
								if(myPlayer<?php echo $idx;?>.currentTime() > <?php echo ($imageSlideItem->image_slide_time)?$imageSlideItem->image_slide_time:0; ?>){
								  if($('#slide<?php echo $idx;?>_<?php echo $key; ?>').css('display')=='none'){
								    //$('#slide1').css('display','inline');
								    $('#slide<?php echo $idx;?>_<?php echo $key; ?>').show('slow', function() {
								      $('#showslide<?php echo $idx;?>').html($('#slide<?php echo $idx;?>_<?php echo $key; ?>').clone());
								      // $.post('http://www.google.com', {}, function(data, textStatus, xhr) {
								      //   /*optional stuff to do after success */
								      // });
								    });
								  }
								}
							<?php
								}
							}
							?>
						});
						splitter<?php echo $idx;?> = $('#split-me<?php echo $idx;?>').touchSplit({orientation:"vertical",topMin:440, bottomMin:440,dock:"both"});
					</script>

                <!-- <div id="vdo<?php echo $idx;?>">Loading the player...</div>

                <script>
                var duration;
                var playerInstance<?php echo $idx; ?> = jwplayer("vdo<?php echo $idx; ?>").setup({
                //controls: false,
                // events: {
                //   onBeforePlay: false
                // },
                stretching: "exactfit",
                flashplayer: "<?php echo Yii::app()->baseUrl; ?>/js/jwplayer/jwplayer.flash.swf",
                height: 430,
                width: 300,
                events: {
                  onBuffer: function(event) {
                    //console.log(event);
                  }
                },
                title:'คลิกเพื่อเล่น',
                file: '<?php echo $uploadFolder.$file->filename;?>',
                });
                playerInstance<?php echo $idx; ?>.onReady(function() {
                  if(typeof $("#vdo<?php echo $idx; ?>").find("button").attr('onclick') == "undefined"){
                  $("#vdo<?php echo $idx; ?>").find("button").attr('onclick','return false');
                }
                });

                playerInstance<?php echo $idx; ?>.onPlay(function(callback) {
                    $('.jwsmooth').remove();
                    $.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>',{
                        id        : <?php echo $file->id; ?>,
                        learn_id  : <?php echo $learn_id; ?>
                      },function(data){
                        $('#imageCheck'+data.no).html(data.image);
                    });
                });

                playerInstance<?php echo $idx; ?>.onComplete(function(callback) {
                    $.getJSON('<?php echo $this->createUrl("//CourseOnline/LearnVdo"); ?>',{
                        id        : <?php echo $file->id; ?>,
                        learn_id  : <?php echo $learn_id; ?>,
                        status    : "success"
                      },function(data){
                        $('#imageCheck'+data.no).html(data.image);
                    });
                });
                </script> -->
              </div>
          </div>
        </div>
      </div>

    <?php
      $idx++;
      endforeach;
    endif;
    ?>
    </div>

    <div style="margin-top: 10px;">
      <h5>รายละเอียดของบทเรียน</h5>
      <?php echo $model->content; ?>
    </div>
  </div>
</div>