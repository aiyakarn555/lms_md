<?php
Class Helpers2
{
    public static function lib()
    {
        return new Helpers();
    }


    public function test()
    {
        return "TEST";
    }


    public function SetUpSetting()
    {
        $SetUpSetting = array();
        $Setting = Setting::model()->find();

        $SetUpSetting['USER_EMAIL'] = $Setting->settings_user_email;
        $SetUpSetting['PASS_EMAIL'] = $Setting->settings_pass_email;
        $SetUpSetting['SITE_TESTING'] = $Setting->settings_testing;
        $SetUpSetting['SITE_INTRO_STATUS'] = $Setting->settings_intro_status;
        $SetUpSetting['SITE_INSTITUTION'] = $Setting->settings_institution;
        $SetUpSetting['SITE_TEL'] = $Setting->settings_tel;
        $SetUpSetting['SITE_LINE'] = $Setting->settings_line;
        $SetUpSetting['SITE_EMAIL'] = $Setting->settings_email;
        $SetUpSetting['ACTIVE_REGIS'] = $Setting->settings_register;
        $SetUpSetting['CONFIRM_MAIL'] = $Setting->settings_confirmmail;

        return $SetUpSetting;
    }

    public function ZoomCheckImage($imgMin, $imgMax)
    {
        $check = CHtml::link(CHtml::image($imgMin, '', array("class" => "thumbnail")), $imgMax, array("rel" => "prettyPhoto"));
        return $check;
    }

    public function banKeyword($str)
    {
        $keyword = BbiiIKeyword::model()->findAll();

        if (count($keyword) > 0) {
            foreach ($keyword as $key => $value) {
                $str = str_replace($value->keyword, 'xxxx', $str);
            }
        }

        return $str;
    }

    public function PlusDate($givendate, $day = 0, $mth = 0, $yr = 0)
    {
        $cd = strtotime($givendate);
        $newdate = date('Y-m-d', mktime(date('h', $cd),
            date('i', $cd), date('s', $cd), date('m', $cd) + $mth,
            date('d', $cd) + $day, date('Y', $cd) + $yr));
        return $newdate;
    }

    public function SendMail($to, $subject, $message, $fromText = 'ระบบ E-learning')
    {
        $SettingAll = Helpers::lib()->SetUpSetting();
        $adminEmail = $SettingAll['USER_EMAIL'];
        $adminEmailPass = $SettingAll['PASS_EMAIL'];

        $mail = Yii::app()->mailer;
        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP();
        // $mail->Host = 'smtp.gmail.com'; // gmail server
        // $mail->Port = '465'; // port number
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587'; // port number
        $mail->SMTPSecure = "tls";
        //$mail->SMTPSecure = "ssl";
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $adminEmail;
        $mail->Password = $adminEmailPass;
        $mail->SetFrom($adminEmail, $fromText);
        $mail->AddAddress($to['email'], 'คุณ' . $to['firstname'] . ' ' . $to['lastname']);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);
        $mail->Send();
    }

    public function compareDate($date1, $date2)
    {
        $arrDate1 = explode("-", $date1);
        $arrDate2 = explode("-", $date2);
        $timStmp1 = @mktime(0, 0, 0, $arrDate1[1], $arrDate1[2], $arrDate1[0]);
        $timStmp2 = @mktime(0, 0, 0, $arrDate2[1], $arrDate2[2], $arrDate2[0]);
        if ($timStmp1 == $timStmp2) {
            $Check = true;
        } else if ($timStmp1 > $timStmp2) {
            $Check = false;
        } else if ($timStmp1 < $timStmp2) {
            $Check = true;
        }
        return $Check;
    }

    //("true" return string) && ("false" return true or false)
    public function CheckBuyItem($id, $return = "")
    {
        $courseArray = array();
        if (!Yii::app()->user->isGuest) {
            $user = Yii::app()->getModule('user')->user();
            foreach ($user->ownerCourseOnline(array(
                'condition' => 'DATEDIFF(NOW(),date_expire)'
            )) as $resultCourse) {
                $courseArray[] = $resultCourse->course_id;
            }
        }
        $countReturn = tblReturn::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
            "lesson_id" => $id, "user_id" => Yii::app()->user->id
        ));

        $OrderDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
            'order' => ' OrderDetailonlines.order_id DESC ',
            'condition' => ' OrderDetailonlines.shop_id="' . $id . '" AND OrderDetailonlines.active="y" ',
        ));
        if (!in_array($id, $courseArray)) {
            $get = 'cart';
            if ($return == "string")
                if ($this->CheckTestingPass($id, true) == 'new') {
                    if ($countReturn > 1) {
                        $new = 'renews';
                        $link = CHtml::link('เรียนใหม่', array($new, 'id' => $id), array(
                            'class' => 'btn btn-success btn-icon glyphicons ok_2',
                            'onclick' => 'if(confirm("ยืนยันการเรียนใหม่หรือไม่ ?")){ return true; }else{ return false;}'
                        ));
                    } else {
                        $link = '<div style="margin-bottom:5px;">' . CHtml::link('สั่งซื้อ', array('cart', 'id' => $id), array(
                                'class' => 'btn btn-primary btn-icon glyphicons ok_2'
                            )) . '</div>';
                    }
                } else {
                    if (isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 0 && $OrderDetailonline->con_admin == 0) {
                        $link = '<span class="label label-important">กรุณาแจ้งชำระเงิน</span>';
                    } else if (isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 1 && $OrderDetailonline->con_admin == 0) {
                        $link = '<span class="label label-info">รอการตรวจสอบ</span>';
                    } else {
                        $link = '<div style="margin-bottom:5px;">' . CHtml::link('สั่งซื้อ', array('cart', 'id' => $id), array(
                                'class' => 'btn btn-primary btn-icon glyphicons ok_2'
                            )) . '</div>';
                    }
                    // $link =  '<div style="margin-bottom:5px;">'.CHtml::link('สั่งซื้อ',array('cart','id'=>$id),array(
                    //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                    // )).'</div>'.CHtml::link('Point',array('point','id'=>$id),array(
                    //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                    // ));
                }
            else
                //$link = false;
                $link = true;
        } else {

            if ($OrderDetailonline->date_expire != null) {
                $d1 = new DateTime(date("Y-m-d H:i:s"));
                $d2 = new DateTime($OrderDetailonline->date_expire);
                if ($d1 > $d2) {
                    $CheckDate = false;
                } else {
                    $CheckDate = true;
                }
            } else {
                $CheckDate = false;
            }

            //$CheckDate = $this->compareDate(date("Y-m-d H:i:s"),$OrderDetailonline->CheckDateTime->date_expire);

            if ($return == "string")
                if ($this->CheckTestingPass($id, true) == 'new') {
                    if ($countReturn < 1) {
                        $new = 'renews';
                        $link = CHtml::link('เรียนใหม่', array($new, 'id' => $id), array(
                            'class' => 'btn btn-success btn-icon glyphicons ok_2',
                            'onclick' => 'if(confirm("ยืนยันการเรียนใหม่หรือไม่ ?")){ return true; }else{ return false;}'
                        ));
                    } else {
                        $link = '<div style="margin-bottom:5px;">' . CHtml::link('สั่งซื้อ', array('cart', 'id' => $id), array(
                                'class' => 'btn btn-primary btn-icon glyphicons ok_2'
                            )) . '</div>';
                        // $link =  '<div style="margin-bottom:5px;">'.CHtml::link('สั่งซื้อ',array('cart','id'=>$id),array(
                        //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                        // )).'</div>'.CHtml::link('Point',array('point','id'=>$id),array(
                        //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                        // ));
                    }
                } else {
                    if ($CheckDate) {
                        $link = '<span class="label label-success">ซื้อเรียบร้อย</span>';
                    } else {
                        if (isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 0 && $OrderDetailonline->con_admin == 0) {
                            $link = '<span class="label label-important">กรุณาแจ้งชำระเงิน</span>';
                        } else if (isset($OrderDetailonline->con_user) && isset($OrderDetailonline->con_admin) && $OrderDetailonline->con_user == 1 && $OrderDetailonline->con_admin == 0) {
                            $link = '<span class="label label-info">รอการตรวจสอบ</span>';
                        } else {
                            $link = '<div style="margin-bottom:5px;">' . CHtml::link('สั่งซื้อ', array('cart', 'id' => $id), array(
                                    'class' => 'btn btn-primary btn-icon glyphicons ok_2'
                                )) . '</div>';
                        }
                        // $link =  '<div style="margin-bottom:5px;">'.CHtml::link('สั่งซื้อ',array('cart','id'=>$id),array(
                        //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                        // )).'</div>'.CHtml::link('Point',array('point','id'=>$id),array(
                        //  'class'=>'btn btn-primary btn-icon glyphicons ok_2'
                        // ));
                    }
                }
            else
                if ($CheckDate) {
                    $link = true;
                } else {
                    $link = false;
                }
        }
        return $link;
    }

    public function CalDate($time1, $time2)
    {
        $time1 = strtotime($time1);
        $time2 = strtotime($time2);
        $distanceInSeconds = round(abs($time2 - $time1));
        $distanceInMinutes = round($distanceInSeconds / 60);
        $days = floor(abs($distanceInMinutes / 1440));
        $hours = floor(fmod($distanceInMinutes, 1440) / 60);
        $minutes = floor(fmod($distanceInMinutes, 60));
        return $days . " วัน " . $hours . " ชั่วโมง " . $minutes . " นาที";
    }

    public function CheckDateTimeUser($id)
    {
        $CheckBuy = $this->CheckBuyItem($id);
        if ($CheckBuy == true) {
            //   $OrderDetailonline = OrderDetailonline::model()->find(array(
            //    "order" => "order_detail_id DESC",
            // 'condition'=>'shop_id=:shop_id AND active=:active',
            // 'params' => array(':shop_id' => $id, ':active' => 'y')
            //   ));
            $OrderDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
                'order' => ' OrderDetailonlines.order_detail_id DESC ',
                'condition' => ' OrderDetailonlines.shop_id="' . $id . '" AND OrderDetailonlines.active="y" ',
            ));
            //$CheckDate = $this->compareDate(date("Y-m-d H:i:s"),$OrderDetailonline->CheckDateTime->date_expire);

            if ($OrderDetailonline->date_expire != null) {
                $text = $this->CalDate(date("Y-m-d H:i:s"), $OrderDetailonline->date_expire);
            } else {
                $text = '-';
            }
        } else {
            $text = '-';
        }
        return $text;
    }

    public function CheckLearning($check, $id)
    {
        if (Helpers::lib()->CheckBuyItem($check) == true)
            $learning = CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icon_entervdo.png', 'เข้าสู่บทเรียน', array('style' => 'margin:0px; display:inline;')), array('//courseOnline/learn', 'id' => $id));
        else
            $learning = '-';

        return $learning;
    }

    public function checkLessonFile($file)
    {
        $user = Yii::app()->getModule('user')->user();
        $learnFiles = $user->learnFiles(
            array(
                'condition' => 'file_id=:file_id',
                'params' => array(':file_id' => $file->id)
            )
        );
        if ($learnFiles) {
            if ($learnFiles[0]->learn_file_status != 's') {
                return "learning";
            } else {
                return "pass";
            }
        } else {
            return "notLearn";
        }
    }

    public static function isPretestState($lesson_id)
    {
        $lesson = Lesson::model()->findByPk($lesson_id);

        if (!$lesson) {
            return false;
        }

        if (self::lib()->checkLessonPass($lesson) != 'notLearn') {
            return false;
        }

        if (!self::checkHavePreTestInManage($lesson_id)) {
            return false;
        }

        $haveScore = Score::model()->findAllByAttributes(array('lesson_id' => $lesson_id, 'user_id' => Yii::app()->user->id));

        if (!$isExamAddToLessonForTest && !$haveScore) {
            return true;
        }

        return false;
    }

    public static function checkHavePreTestInManage($lesson_id)
    {
        //$isExamAddToLessonForTest = Manage::model()->with('grouptesting')->findAllByAttributes(array('id' => $lesson_id, 'type' => 'pre'));
        $isExamAddToLessonForTest = Manage::model()->with('grouptesting')->findAll("id = '" . $lesson_id . "' AND type = 'pre' AND manage.active='y' AND grouptesting.active ='y'");

        if (!$isExamAddToLessonForTest) {
            return false;
        }

        return true;
    }

    public function checkLessonPass($lesson)
    {
        $user = Yii::app()->getModule('user')->user();
        if ($user) {

            $learnLesson = $user->learns(
                array(
                    'condition' => 'lesson_id=:lesson_id',
                    'params' => array(':lesson_id' => $lesson->id)
                )
            );

            if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
                return "pass";
            } else {
                if ($lesson->fileCount == 0 && $learnLesson) {
                    return "pass";
                } else {
                    if ($lesson->fileCount != 0 && $learnLesson) {

                        $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                            array(
                                'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\'',
                                'params' => array(':lesson_id' => $lesson->id)
                            )
                        );

                        if ($countLearnCompareTrueVdos != $lesson->fileCount) {
                            return "learning";
                        } else {
                            return "pass";
                        }

                    } else {
                        return "notLearn";
                    }
                }
            }

        }

    }


    public function checkLessonPass_Percent($lesson)
    {
        $percent_max = 100;
        $color = '#00bfff';
        $user = Yii::app()->getModule('user')->user();
        if ($user) {
            $learnLesson = $user->learns(
                array(
                    'condition' => 'lesson_id=:lesson_id',
                    'params' => array(':lesson_id' => $lesson->id)
                )
            );
            if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
                $percent = $percent_max;
                $color = "#00ff00";
                $status = "pass";
            } else {
                if ($lesson->fileCount == 0 && $learnLesson) {
                    $percent = $percent_max;
                    $color = "#00ff00";
                    $status = "pass";
                } else {
                    if ($lesson->fileCount != 0 && $learnLesson) {
                        $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                            array(
                                'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\'',
                                'params' => array(':lesson_id' => $lesson->id)
                            )
                        );
                        if ($countLearnCompareTrueVdos != $lesson->fileCount) {
                            $percent_fn = ($countLearnCompareTrueVdos*100)/$lesson->fileCount;
                            $percent = number_format($percent_fn,2);
                            $color = "#ff8000";
                            $status = "learning";
                        } else {
                            $percent = $percent_max;
                            $color = "#00ff00";
                            $status = "pass";
                        }
                    } else {
                        $percent = 0;
                        $color = "#ff0000";
                        $status = "notLearn";
                    }
                }
            }
        }
        return (object)['percent'=>$percent,'color'=>$color,'status'=>$status];
    }


    public function checkCoursePass($course_id)
    {
        $lessonAll = Lesson::model()->findAllByAttributes(array('course_id' => $course_id));
        $lessonAllCount = count($lessonAll);
        $lessonPassCount = 0;
        if ($lessonAll) {
            foreach ($lessonAll as $lesson) {

                if ($this->checkLessonPass($lesson) == "pass") {
                    if ($this->CheckTestCount('pass', $lesson->id) == true) {
                        $lessonPassCount++;
                    }
                }
            }

            if ($lessonAllCount == $lessonPassCount) {
                return "pass";
            } else {
                return "notPass";
            }
        } else {
            return "notPass";
        }
    }

    public function checkCategoryPass($cate_id)
    {
        $courseAll = CourseOnline::model()->findAllByAttributes(array('cate_id' => $cate_id));
        $courseAllCount = count($courseAll);
        $coursePassCount = 0;
        if ($courseAll) {
            foreach ($courseAll as $course) {

                if ($this->checkCoursePass($course->course_id) == "pass") {
                    $coursePassCount++;
                }
            }

            if ($courseAllCount == $coursePassCount) {
                return "pass";
            } else {
                return "notPass";
            }
        } else {
            return "notPass";
        }
    }

    //("true" return string) && ("false" return true or false)
    public function CheckTestCount($status, $id, $return = false, $check = true,$type)
    {
        if ($status == "notLearn" || $status == "learning") {
            if ($check == true) {
                if ($return == true)
//                    $CheckTesting = '-';
                      $CheckTesting = '<font color="#E60000">ยังไม่มีสิทธิ์ทำแบบทดสอบหลังเรียน</font>';
                else
                    $CheckTesting = false; //No Past
            } else {
                $CheckTesting = false;
            }
        } else if ($status == "pass") {
            $countManage = Manage::Model()->with('grouptesting')->count("id=:id AND manage.active='y' AND grouptesting.active ='y' AND type = 'post' ", array(
                "id" => $id
            ));

            //Condition Testing
            if (!empty($countManage)) {
                $Lesson = Lesson::model()->find(array(
                    'condition' => 'id=:id', 'params' => array(':id' => $id)
                ));

                $lesson_new = TestAmount::model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type =:type ",
                    array("lesson_id" => $id, "user_id" => Yii::app()->user->id, "type" => $type
                    ));

                $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id  AND type =:type ", array(
                    "lesson_id" => $id, "user_id" => Yii::app()->user->id, "type" => $type
                ));

                $countScorePast = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND score_past=:score_past AND type=:type ", array(
                    "lesson_id" => $id, "user_id" => Yii::app()->user->id, "score_past" => "y", "type" => $type
                ));

                if (!empty($countScorePast)) {
                    if ($check == true) {
                        if ($return == true) {
                            $CheckTesting = '<font color="#008000">สอบผ่าน</font><br><a href="' . Yii::app()->createUrl('question/scoreAll', array('id' => $id)) . '" target="_blank">ผลการทดสอบ</a>';
                        } else {
                            $CheckTesting = true; //Past
                        }
                    } else {
                        $CheckTesting = true;
                    }
                } else {

                    if ($lesson_new == $Lesson->cate_amount) {
                        if ($check == true) {
                            if ($return == true) {
                                $CheckTesting = '<font color="#E60000">ทำแบบทดสอบไม่ผ่าน</font>';
                            } else {
                                $CheckTesting = false; //No Past
                            }

                        } else {
                            $CheckTesting = true;
                        }
                    } else {
                        if ($check == true) {
                            if ($return == true) {
                                $CheckTesting = CHtml::link('ทำแบบทดสอบ', array(
                                    '//question/index',
                                    'id' => $id
                                ), array(//'target'=>'_blank'
                                ));
                            } else {
                                $CheckTesting = false; //No Past
                            }
                        } else {
                            $CheckTesting = false;
                        }
                    }

                }
            } else {
                if ($check == true) {
                    if ($return == true) {
                        $CheckTesting = '<font color="#E60000">ไม่มีแบบทดสอบ</font>';
                    } else {
                        $CheckTesting = true; //Past
                    }
                } else {
                    $CheckTesting = false;
                }
            }
        } else {
            if ($check == true) {
                if ($return == true) {
                    $CheckTesting = '<font color="#E60000">ยังเรียนไม่ผ่าน</font>';
                } else {
                    $CheckTesting = false; //No Past
                }
            } else {
                $CheckTesting = false;
            }
        }
        return $CheckTesting;
    }

    public function CheckLevel($id)
    {
        $return = array();
        $orgcourse = OrgCourse::model()->findByPk($id);
        if ($orgcourse) {
            $return = array('id' => $orgcourse->id, 'parentID' => $orgcourse->parent_id);
        }
        return $return;
    }

    public function CheckCourseNextPass($course_id, $department_id='')
    {
        $fn = array();
        //$return_notPass = array();
//        $orgchart = Orgchart::model()->findByPk($department_id);
        $orgcourse = OrgCourse::model()->findAll();
        if ($orgcourse) {
            foreach ($orgcourse as $orgcourse_fn) {
                //f($orgcourse_fn->parent_id!=0){
                $fn[] = Helpers::lib()->CheckLevel($orgcourse_fn->id);
                //}
            }
        }


        foreach ($fn as $key => $value) {
            $orgcourse_c = OrgCourse::model()->find(array(
                'condition' => 'course_id=' . $course_id,
            ));
            if ($orgcourse_c->parent_id == 0) {

                $chk_pass = Helpers::lib()->checkCoursePass($orgcourse_c->course_id);
                if ($chk_pass == "pass") {
                    $text_return = "pass";
                } else {
                    $text_return = "notLearn";
                }

            } else {
                $orgcourse_f = OrgCourse::model()->find(array(
                    'condition' => 'id=' . $orgcourse_c->parent_id,
                ));
                $chk_pass = Helpers::lib()->checkCoursePass($orgcourse_f->course_id);
                if ($chk_pass == "pass") {
                    $text_return = "canLearn";
                } else {
                    $text_return = "backLearn";
                }
            }
        }
        return $orgcourse;
    }

    public function CountTestIng($status, $id, $amount)
    {
        if ($status == "pass") {
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type='post'", array(
                "user_id" => Yii::app()->user->id,
                "lesson_id" => $id
            ));
            $lesson_new = TestAmount::model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type = 'post'",
                array("lesson_id" => $id, "user_id" => Yii::app()->user->id));
            if (!$lesson_new) {
                $lesson_new = 0;
            }

            $sum = intval($amount - $lesson_new);

            if ($sum != 0 && $countScore <= $amount) {
                $num = 'เหลือ ' . $sum . ' ครั้ง';
            } else {
                $num = '<font color="#E60000">หมดสิทธิ์ทำแบบทดสอบ</font>';
            }
        } else {
            $num = '-';
        }

        return $num;
    }

    public function CountTestIngTF($status, $id, $amount)
    {
        if ($status == "pass") {
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type='post'", array(
                "user_id" => Yii::app()->user->id,
                "lesson_id" => $id
            ));

            $sum = intval($amount - $countScore);

            if ($sum != 0 && $countScore <= $amount) {
                $num = 1;
            } else {
                $num = 2;
            }
        } else {
            $num = 3;
        }

        return $num;
    }

    public function ScorePercent($id,$type)
    {
        $criteria = new CDbCriteria;
        $criteria->select = '*,MAX(score_number) as score_number';
        $criteria->condition = ' type = "'.$type.'" AND lesson_id="' . $id . '" AND user_id="' . Yii::app()->user->id . '"';
        $Score = Score::model()->find($criteria);

        if (!empty($Score->score_number)) {
            $check['value'] = number_format(($Score->score_number/$Score->score_total)*100,0);
            $check['option']['color'] = "#00FF00";
        } else {
            $check['value'] = '0';
            $check['option']['color'] = "#F00";
        }

        return (object)$check;
    }

    public function ScoreToTal($id,$type)
    {
        $criteria = new CDbCriteria;
        $criteria->select = '*,MAX(score_total) as score_total';
        $criteria->condition = ' type = "'.$type.'" AND lesson_id="' . $id . '" AND user_id="' . Yii::app()->user->id . '"';
        $Score = Score::model()->find($criteria);

        if (!empty($Score->score_total)) {
            //$check = number_format(($Score->score_total/$Score->score_total)*100,2);
            $check = number_format(($Score->score_total));
        } else {
            $check = '0';
        }

        return $check;
    }

    public function CheckTestingPass($id, $return = false, $checkEvaluate = false)
    {
        $lessonModel = Lesson::model()->findAll(array(
            'condition' => 'course_id=:course_id',
            'params' => array(':course_id' => $id)
        ));

        $_Score = 0;
        $scoreCheck = 0;
        $totalCheck = 0;
        $PassLearnCout = 0;

        foreach ($lessonModel as $key => $value) {
            $lessonStatus = $this->checkLessonPass($value);
            $scoreSum = $this->ScorePercent($value->id);
            $scoreToTal = $this->ScoreToTal($value->id);

            if (!empty($scoreSum)) {
                $CheckSumOK = $scoreSum;
            } else {
                $CheckSumOK = 0;
            }

            if (!empty($scoreToTal)) {
                $CheckToTalOK = $scoreToTal;
            } else {
                $CheckToTalOK = 0;
            }

            $totalCheck = $totalCheck + $CheckToTalOK;
            $scoreCheck = $scoreCheck + $CheckSumOK;

            if (Helpers::lib()->CheckTestCount($lessonStatus, $value->id, false, false) == true) {
                $PassLearnCout = $PassLearnCout + 1;
            }

            //========== เช็คว่าสอบครบทุกบทหรือยัง ==========//
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id", array(
                "user_id" => Yii::app()->user->id,
                "lesson_id" => $value->id
            ));

            if ($countScore >= "1") {
                $_Score = $_Score + 1;
            }


            $CheckNoTesting = Helpers::lib()->CheckTestCount($lessonStatus, $value->id, false);
        }

        if (count($lessonModel) == true) {
            $sumTotal = $scoreCheck * 100;
            if (!empty($totalCheck)) {
                $sumTotal = $sumTotal / $totalCheck;
            }

            if ($_Score === count($lessonModel) && $sumTotal >= 60) {
                $modelDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
                    'order' => ' OrderDetailonlines.order_id DESC ',
                    'condition' => ' OrderDetailonlines.shop_id="' . $id . '" AND OrderDetailonlines.active="y" ',
                ));

                if (isset($modelDetailonline->con_admin) && $modelDetailonline->con_admin == 1) {
                    if ($checkEvaluate == false) {
                        $imageUrl = Yii::app()->request->baseUrl . '/images/icons/print.png';
                        $sumTestingTxt = CHtml::link(CHtml::image($imageUrl, 'Accept'), array(
                            'printpdf', 'id' => $id
                        ), array(
                            'class' => 'imageIcon',
                            'target' => '_blank'
                        ));
                    } else {
                        $sumTestingTxt = true;
                    }
                } else {
                    if (isset($modelDetailonline->con_user) && $modelDetailonline->con_user == 0) {
                        if ($checkEvaluate == false) {
                            $imageCoins = Yii::app()->request->baseUrl . '/images/icons/coins.png';
                            $sumTestingTxt = CHtml::link(CHtml::image($imageCoins, 'Accept'), array(
                                '//orderonline/update',
                                'id' => $modelDetailonline->order_id
                            ), array(
                                'class' => 'imageIcon',
                            ));
                        } else {
                            $sumTestingTxt = false;
                        }
                    } else {
                        if ($checkEvaluate == false) {
                            $imageCoinsOk = Yii::app()->request->baseUrl . '/images/icon_checkpast.png';
                            $sumTestingTxt = CHtml::image($imageCoinsOk, 'ยืนยันเรียบร้อย', array(
                                'title' => 'ยืนยันเรียบร้อย'
                            ));
                        } else {
                            $sumTestingTxt = false;
                        }
                    }
                }
            } else {
                if ($PassLearnCout == count($lessonModel)) {
                    if ($return == false) {
                        if ($checkEvaluate == false) {
                            $sumTestingTxt = '-';
                        } else {
                            $sumTestingTxt = false;
                        }
                    } else {
                        if ($checkEvaluate == false) {
                            $sumTestingTxt = 'new';
                        } else {
                            $sumTestingTxt = false;
                        }
                    }
                } else {
                    if ($CheckNoTesting == true) {
                        if ($checkEvaluate == false) {
                            if ($_Score === count($lessonModel)) {
                                $imageUrl = Yii::app()->request->baseUrl . '/images/icons/print.png';
                                $sumTestingTxt = CHtml::link(CHtml::image($imageUrl, 'Accept'), array(
                                    'printpdf',
                                    'id' => $id), array(
                                    'class' => 'imageIcon',
                                    'target' => '_blank'
                                ));
                            } else {
                                $sumTestingTxt = false;
                            }
                        } else {
                            $sumTestingTxt = true;
                        }
                    } else {
                        if ($checkEvaluate == false) {
                            $sumTestingTxt = '-';
                        } else {
                            $sumTestingTxt = false;
                        }
                    }
                }
            }

            return $sumTestingTxt;
        }
    }

    //INSERT PASS courseOnline
    public function CheckTestingPassCourseOnline($id, $return = false)
    {
        $lessonModel = Lesson::model()->findAll(array(
            'condition' => 'course_id=:course_id',
            'params' => array(':course_id' => $id)
        ));

        $scoreCheck = 0;
        $PassLearnCout = 0;

        foreach ($lessonModel as $key => $value) {
            $lessonStatus = $this->checkLessonPass($value);
            $scoreSum = $this->ScorePercent($value->id);

            if (!empty($scoreSum)) {
                $CheckSumOK = $scoreSum;
            } else {
                $CheckSumOK = 0;
            }

            $scoreCheck = $scoreCheck + $CheckSumOK;

            if ($this->CheckTestCount($lessonStatus, $value->id, false, false) == true) {
                $PassLearnCout = $PassLearnCout + 1;
            }
        }


        foreach ($lessonModel as $key => $value) {
            $lessonStatus = $this->checkLessonPass($value);
            $scoreSum = $this->ScorePercent($value->id);

            if (!empty($scoreSum)) {
                $CheckSumOK = $scoreSum;
            } else {
                $CheckSumOK = $scoreSum;
            }

            $scoreCheck = $scoreCheck + $CheckSumOK;

            if (Helpers::lib()->CheckTestCount($lessonStatus, $value->id, false, false) == true) {
                $PassLearnCout = $PassLearnCout + 1;
            }

            $CheckNoTesting = Helpers::lib()->CheckTestCount($lessonStatus, $value->id, false);
        }


        if (count($lessonModel) == true) {
            $sumTestingOK = $scoreCheck / count($lessonModel);
            if ($sumTestingOK >= 60) {
                $modelDetailonline = Orderonline::model()->with('OrderDetailonlines')->find(array(
                    'order' => ' OrderDetailonlines.order_id DESC ',
                    'condition' => ' OrderDetailonlines.shop_id="' . $id . '" AND OrderDetailonlines.active="y" ',
                ));
                if (isset($modelDetailonline->con_admin) && $modelDetailonline->con_admin == 1) {
                    $sumTestingTxt = true;
                } else {
                    $sumTestingTxt = false;
                }
            } else {
                $sumTestingTxt = false;
            }

            return $sumTestingTxt;
        }
    }


    public function chkRegister_status()
    {
        $model = Setting::model()->find();
        if ($model->settings_register == 1) {
            return true;
        } else {
            return false;
        }
    }

}
