<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

class GGridView extends CGridView
{
    // Set class of table.
    public $itemsCssClass = 'table-striped table-bordered table';

    // pager css class.
    public $pagerCssClass = 'pagination';

    // css class of rows 1, 2, 3,..  will be assigned by odd, even, odd, ... respectively.
    public $rowCssClass = array('odd', 'even');

    // set pager css class
    public $pager = array(
            'maxButtonCount'=>'11',
            'class'=>'CLinkPager',
            'htmlOptions'=>array(
                'class'=>'',
            ),
            'firstPageLabel'=>'<< หน้าแรก',
            'prevPageLabel'=>'< ย้อนกลับ',
            'nextPageLabel'=>'ถัดไป >',
            'lastPageLabel'=>'หน้าสุดท้าย >>',
            'header'=>false,
            'selectedPageCssClass'=>'active',
    );

    // clear summary text in header
    public $summaryText = 'ข้อมูลทั้งหมดมี {count} รายการ';

    // set text that will be shown when no data to response.
    public $emptyText = 'ยังไม่มีข้อมูล';

    // disable default sorting by header link
    //public $enableSorting = false;

    public function init()
    {
        $updateSelector = "#table_".$this->id;
        parent::init();
    }


    /** Overiding initColumns function for change default DataColumn Class
     *  from CDataColumn to ADataColumn (our DataColumn).
     */
    protected function initColumns()
    {
        foreach($this->columns as $i=>$column)
        {
            if(!is_string($column) && !isset($column['class']))
                $this->columns[$i]['class']='ADataColumn';
        }
        parent::initColumns();
    }

    // Overiding createDataColumn function for use our DataColumn Class.
    protected function createDataColumn($text)
    {
        if(!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/',$text,$matches))
            throw new CException(Yii::t('zii','The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
        // Change DataColumn Class
        $column=new ADataColumn($this);
        $column->name=$matches[1];
        if(isset($matches[3]) && $matches[3]!=='')
            $column->type=$matches[3];
        if(isset($matches[5]))
            $column->header=$matches[5];
        return $column;
    }

    public function renderFilter()
    {
        if($this->filter!==null)
        {
            echo "<tr class=\"{$this->filterCssClass}\">\n";
            foreach($this->columns as $column)
                $column->renderFilterCell();
            echo "</tr>\n";
        }
    }

    /**
     * Renders a table body row.
     * @param integer $row the row number (zero-based).
     */
    public function renderTableRow($row)
    {
        $htmlOptions=array();
        if($this->rowHtmlOptionsExpression!==null)
        {
            $data=$this->dataProvider->data[$row];
            $options=$this->evaluateExpression($this->rowHtmlOptionsExpression,array('row'=>$row,'data'=>$data));
            if(is_array($options))
                $htmlOptions = $options;
        }

        if($this->rowCssClassExpression!==null)
        {
            $data=$this->dataProvider->data[$row];
            $class=$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data));
        }
        elseif(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
            $class=$this->rowCssClass[$row%$n];

        if(!empty($class))
        {
            if(isset($htmlOptions['class']))
                $htmlOptions['class'].=' '.$class;
            else
                $htmlOptions['class']=$class;
        }

        echo CHtml::openTag('tr', $htmlOptions)."\n";
        foreach($this->columns as $column)
            $column->renderDataCell($row);
        echo "</tr>\n";

        $course_id = $this->dataProvider->data[$row]->course_id;

        echo '<tr style="background:#FCB847; "><td colspan="'.count($this->columns).'">';

        $userObject = Yii::app()->getModule('user')->user();

        // var_dump($userObject->student_house);
        // var_dump($userObject->operator_name);

        $lessonModel = Lesson::model()->with('creater')->findAll(array(
            'condition'=>'course_id=:course_id AND (view_all="y" OR student_house=:student_house OR operator_name=:operator_name)',
            'params'=>array(':course_id'=>$course_id,':student_house'=>$userObject->student_house,':operator_name'=>$userObject->operator_name)
        ));
        $CheckBuy = Helpers::lib()->CheckBuyItem($course_id);

        // echo '<div class="alert alert-success">
        //         <strong>การเก็บชั่วโมง '. $this->dataProvider->data[$row]->CourseType .'</strong>
        //     </div>';

        /*echo '<table class="table table-bordered" style="width:100%;">
            <thead>
            <tr>
                <th style="text-align: center;">ลำดับ</th>
                <th>ชื่อบทเรียน</th>
                <th width="11%" style="text-align: center;">จำนวนวิดีโอ</th>';
                if($CheckBuy){
                echo '<th style="text-align: center;">เรียน</th>
                <th width="10%" style="text-align: center;">สถานะการเรียน</th>
                <th width="11%" style="text-align: center;">ข้อสอบ</th>
                <th width="12%" style="text-align: center;">สิทธิการสอบ</th>
                <th width="9%" style="text-align: center;">คะแนนที่ดีที่สุด</th>';
                }
        echo '</tr></thead><tbody>';*/


        echo '<table class="table table-bordered" style="width:100%;">
            <thead>
            <tr>
                <!-- <th style="text-align: center;">ลำดับ</th> -->
                <th>บทเรียน</th>';
                if($CheckBuy)
                {
                    echo '<th style="text-align: center;">เข้าสู่บทเรียน</th>
                    <th width="10%" style="text-align: center;">สถานะการเรียน</th>
                    <th width="15%" style="text-align: center;">แบบทดสอบ</th>
                    <th width="12%" style="text-align: center;">สิทธิการทำแบบทดสอบ</th>
                    <th width="9%" style="text-align: center;">คะแนนที่ดีที่สุด</th>
                    <th width="9%" style="text-align: center;">ประเมิน</th>';
                }
        echo '</tr></thead><tbody>';

        $_Score         = 0;
        $scoreCheck     = 0;
        $totalCheck     = 0;
        $PassCoutCheck  = 0;

        foreach ($lessonModel as $key => $value)
        {
            $lessonStatus = Helpers::lib()->checkLessonPass($value);

            if($lessonStatus == "notLearn")
            {
                $statusValue = CHtml::image(Yii::app()->baseUrl.'/images/icon_checkbox.png', 'ยังไม่ได้เรียน', array('style' => 'display:inline;margin:0','title'=>'ยังไม่ได้เรียน'));
            }
            else if($lessonStatus == "learning" && $CheckBuy)
            {
                $statusValue = CHtml::image(Yii::app()->baseUrl.'/images/icon_checklost.png', 'เรียนยังไม่ผ่าน', array('style' => 'display:inline;margin:0','title'=>'เรียนยังไม่ผ่าน'));
            }
            else if($lessonStatus == "pass" && $CheckBuy)
            {
                $statusValue = CHtml::image(Yii::app()->baseUrl.'/images/icon_checkpast.png', 'ผ่าน', array('style' => 'display:inline;margin:0','title'=>'ผ่าน'));
                 $linkformsurvey='<a href="#">ทำแบบสอบถาม</a>';
            }

            if(Helpers::lib()->CheckTestCount($lessonStatus,$value->id,false) == false)
            {
                $checkPass = Helpers::lib()->CountTestIng($lessonStatus,$value->id,$value->cate_amount);
            }
            else
            {
                $checkPass = '-';
            }

            //========== เช็คว่าสอบครบทุกบทหรือยัง ==========//
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
                "user_id"   => Yii::app()->user->id,
                "lesson_id" => $value->id
            ));
            if( $countScore >= "1" )
            {
                $_Score = $_Score+1;
            }

            $CheckTestPast = Helpers::lib()->CheckTestCount($lessonStatus,$value->id,false);

            //========== SUM ==========//
            $scoreSum   = Helpers::lib()->ScorePercent($value->id);
            $scoreToTal = Helpers::lib()->ScoreToTal($value->id);

            if(!empty($scoreSum)) //ถ้ามีการคิดคะแนน
            {
                $CheckSumOK = $scoreSum;
            }
            else //ถ้าไม่มีการคิดคะแนน
            {
                $CheckSumOK = 0;
            }

            if(!empty($scoreToTal))
            {
                $CheckToTalOK = $scoreToTal;
            }
            else
            {
                $CheckToTalOK = 0;
            }

            $totalCheck = $totalCheck+$CheckToTalOK;
            $scoreCheck = $scoreCheck+$CheckSumOK;

            if(Helpers::lib()->CheckTestCount($lessonStatus,$value->id,false,false) == true)
            {
                $PassCoutCheck = $PassCoutCheck+1;
            }

            echo '<tr>';
//            echo '<td width="25" style="text-align: center;">'.($this->dataProvider->pagination->currentPage*
//                    $this->dataProvider->pagination->pageSize + $row+1).".".++$key.'</td>';
            //echo '<td width="25" style="text-align: center;">'.++$key.'</td>';
            /*echo '<td width="93">'.Controller::ImageShowIndex(Yush::SIZE_THUMB,$value,$value->image,array(
                    "style"=>"vertical-align:text-top; width:93px;",
                    //"class"=>"thumbnail"
            )).'</td>';*/
            echo '<td>'.CHtml::link($value->title, array('//Lesson/view','id'=>$value->id) ).'</td>';
            //echo '<td style="text-align: center;">'.$value->fileCount.'</td>';

            if($CheckBuy)
            {
                $isPreTest = Helpers::isPretestState($value->id);
                if ($isPreTest)
                {
                    echo '<td style="text-align: center;">กรุณาทำข้อแบบทดสอบก่อนเรียน</td>';
                }
                else
                {
                    $linkGet = Helpers::lib()->CheckLearning($course_id,$value->id);
                    echo '<td style="text-align: center;">'.$linkGet.'</td>';
                }

                echo '<td style="text-align: center;">'.$statusValue.'</td>';

                if ($isPreTest)
                {
                    echo '<td style="text-align: center;">'.CHtml::link('ทำแบบทดสอบก่อนเรียน', array('//question/index','id'=>$value->id)).'</td>';
                }
                else
                {
                   echo '<td style="text-align: center;">'.Helpers::lib()->CheckTestCount($lessonStatus,$value->id,true).'</td>';
                }

                echo '<td style="text-align: center;">'.$checkPass.'</td>';
                echo '<td style="text-align: center;">'.$scoreSum.' / '.$scoreToTal.'</td>';
                if($CheckTestPast === true){

                    $questAns = QQuestAns::model()->find("user_id='".Yii::app()->user->id."' AND lesson_id='".$value->id."' AND header_id='".$value->header_id."'");
                    if(!$questAns){
					   echo '<td style="text-align: center;">'.(($value->header_id !='')?CHtml::link('ทำแบบสอบถาม', array('//questionnaire/index','id'=>$value->id)):'').'</td>';
                    }else{
                        echo '<td style="text-align: center;">คุณทำแบบสอบถามแล้ว</td>';
                    }
                }
                else
                {
	             echo '<td style="text-align: center;">'.(($value->header_id !='')?'ต้องทำข้อสอบก่อน':'').'</td>';
                }
            }
            echo '</tr>';
        }

        $sumTotal = $scoreCheck*100;
        if (!empty($totalCheck))
        {
            $sumTotal = $sumTotal/$totalCheck;
        }

        if($CheckBuy)
        {
            if( $sumTotal >= 60 || $CheckTestPast === true )
            {
                if( $_Score === count($lessonModel) )
                {
                    $sumTestingTxt = '<font color="green"><b> ผ่าน </b></font>';
                   
                }
                else
                {
                    $sumTestingTxt = '<font color="red"><b> ยังสอบไม่ครบ </b></font>';
                }
            }
            else
            {
                $sumTestingTxt = '<font color="red"><b> ไม่ผ่าน </b></font>';
            }

            echo '<tr>';
                echo '<td colspan="9"><b>คะแนนรวมของหลักสูตร</b> '. number_format($sumTotal,2) .'% '. $sumTestingTxt. '</td>';
            echo '</tr>';
        }


        if(count($lessonModel) == false)
        {
            echo '<tr>';
                echo '<td colspan="9" bgcolor="#FCB847"><font color="red">ยังไม่มีบทเรียน</font></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo "</td></tr>\n";
    }
}