<?php

/**
 * This is the model class for table "{{course}}".
 *
 * The followings are the available columns in table '{{course}}':
 * @property integer $course_id
 * @property integer $cate_id
 * @property string $course_title
 * @property string $course_lecturer
 * @property string $course_short_title
 * @property string $course_detail
 * @property string $course_location
 * @property integer $course_price
 * @property string $course_date
 * @property string $course_time
 * @property string $course_picture
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class CateOnline extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CateCourse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cate_type, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('cate_title, cate_short_detail', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('cate_detail, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cate_id, cate_type, cate_title, cate_short_detail, cate_detail, course_picture, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

    public function afterFind() 
    {
    	$this->cate_title = CHtml::decode($this->cate_title);
    	$this->cate_short_detail = CHtml::decode($this->cate_short_detail);
    	$this->cate_detail = CHtml::decode($this->cate_detail);
        return parent::afterFind();
    }

    public function getCountCourse()
    {
		$count = CourseOnline::Model()->count("cate_id=:cate_id AND active=:active", array(
			"cate_id"=>$this->cate_id,"active"=>"y"
		));
		return $count;
    }

	public function getDetailCourse()
	{
		$get = '//courseOnline/index';
		$link = CHtml::link('<i class="icon-folder-open"></i> หลักสูตร',array($get,'id'=>$this->cate_id),array(
			'click' => 'function(){}',
			'class'=>'btn btn-primary btn-icon glyphicons ok_2'
		));
		return $link;
	}

	public function getImageCheck()
	{
		$imageCateCourse = Controller::ImageShowIndex(Yush::SIZE_THUMB,$this,$this->cate_image,array());
		$imageCateCourseCheck = str_replace("cateonline","category",$imageCateCourse);
		return CHtml::link($imageCateCourseCheck, array('cateOnline/view', 'id'=>$this->cate_id),array(
			'class'=>'thumbnail'
		));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'files' => array(self::HAS_MANY, 'Filecategory', 'category_id'),
			'fileCount'=>array(self::STAT, 'Filecategory', 'category_id'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CountCourse'=>'จำนวนหลักสูตร',
			'Datailhead'=>'หัวข้อ',
			'cate_id' => 'Cate',
			'cate_type' => 'Cate Type',
			'cate_title' => 'ชื่อหมวดหลักสูตรอบรมออนไลน์',
			'cate_short_detail' => 'รายละเอียดย่อ',
			'cate_detail' => 'รายละเอียด',
			'cate_image' => 'รูปภาพประกอบ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

	public function getId()
	{
		return $this->cate_id;
	}
	
	public function getVdoEx()
	{
		$file = CateOnline::model()->with('files')->findByPk($this->cate_id);
		$check = '';
		$uploadFolder = 'http://localhost/set/uploads/category/';
		if(isset($file->files))
		{
			$baseUrl = Yii::app()->baseUrl;
$check.= <<<Url
<link href="{$baseUrl}/js/video-js/video-js.css" rel="stylesheet" type="text/css">
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

	/*.vjs-progress-control {
	  display: none;
	}*/

</style>
<script src="{$baseUrl}/js/video-js/video.js"></script>
Url;
			$idx = 1;
			foreach($file->files as $fileData)
			{
$check.= <<<VDO
				   <div class="thumbnail">
					<div>
				      <video id="vdo{$idx}" class="video-js vjs-default-skin" controls preload="none" 
				          poster="http://video-js.zencoder.com/oceans-clip.png"
				          data-setup="{}">
				        <source src="{$uploadFolder}{$fileData->filename}" type='video/mp4' />
				        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
				      </video>
				    </div>
				   </div>
				   <script type="text/javascript">
  						var myPlayer{$idx} = videojs('vdo{$idx}');
				   </script>
				   <br>
VDO;

				$idx++;
			}
		}
		return $check;
	}

	public function defaultScope()
	{
	    return array(
	    	'alias' => 'cate',
	    	'order' => 'cate.cate_id desc',
	    	'condition' => 'cate.cate_show = "1" AND cate.active = "y"',
	    );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('cate_id',$this->cate_id);
		$criteria->compare('cate_type',$this->cate_type);
		$criteria->compare('cate_title',$this->cate_title,true);
		$criteria->compare('cate_short_detail',$this->cate_short_detail,true);
		$criteria->compare('cate_detail',$this->cate_detail,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		$poviderArray = array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
		);

		return new CActiveDataProvider($this, $poviderArray);
	}
}