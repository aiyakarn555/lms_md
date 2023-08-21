<?php
class Helpers
{

    public static function lib()
    {
        return new Helpers();
    }

    public function insertLogError($error_response, $controller = 0, $action = null, $error_code = null, $parameter = null)
    {
        Yii::app()->session['errorMessage'] = null;
        Yii::app()->session['errorController'] = null;
        Yii::app()->session['errorAction'] = null;
        Yii::app()->session['errorCode'] = null;
        Yii::app()->session['errorParameter'] = null;
        if (is_string($error_response)) {
            $error = $error_response;
        } else {
            $error = json_encode([
                "Message" => $error_response->getMessage(),
                "Trace" => $error_response->getTrace()
            ]);
        }

        $model = new ErrorResponse;
        $model->error_response = $error;
        $model->error_code = $error_code;
        $model->controller = $controller;
        $model->action = $action;
        $model->parameter = $parameter;
        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }


    public function uploadimagecroppie($tempFile, $path, $model_id, $base64_pic)
    {
        $uploadDir = Yii::app()->getUploadPath(null);
        $uploadDir = $uploadDir . '../';

        if (!is_dir($uploadDir . $path . "/")) {
            mkdir($uploadDir . $path . "/", 0777, true);
        }

        if (!is_dir($uploadDir . $path . "/" . $model_id . "/")) {
            mkdir($uploadDir . $path . "/" . $model_id . "/", 0777, true);
        } else {
            $files = glob($uploadDir . $path . "/" . $model_id . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        $uploadDir = $uploadDir . $path . "/" . $model_id . "/";
        $fileParts = pathinfo($tempFile['name']);
        $fileType = strtolower($fileParts['extension']);
        $rnd = rand(0, 999999999);
        $fileName = "{$rnd}-{$model_id}." . $fileType;
        $targetFile = $uploadDir . $fileName;
        if (file_put_contents($targetFile, file_get_contents($base64_pic))) {
            return $fileName;
        } else {
            return false;
        }
    }


    public function ApiFaceImage($url, $user_id = null)
    {

        $path = YiiBase::getPathOfAlias('webroot') . '/uploads/FaceRegis/' . $user_id . '.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64_Regis = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $base64_Login = $url;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apis.aigen.online/aiface/face-compare/v1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "image1" : "' . $base64_Regis . '",
            "image2" : "' . $base64_Login . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'x-aigen-key: SBu7ph3zolxi66yin11525vaqx7a6ibt3q',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $return_de = json_decode($response);
        curl_close($curl);

        $status = false;
        if (isset($return_de->confidence)) {
            if ($return_de->confidence > 60) {
                $status = true;
            }

            $logVerify = new LogVerifyFace();
            $logVerify->user_id = $user_id;
            $logVerify->liveness_score = $return_de->confidence;
            $logVerify->create_date = date("Y-m-d H:i:s");
            $logVerify->type = "login";
            $logVerify->status = $status;
            $logVerify->save();
        }

        return $status;
    }
    // public function ApiFaceImage($use_id,$file,$type,$folder){

    //     $uploadDir = Yii::app()->getUploadPath(null);
    //     $uploadDir = $uploadDir.'../';
    //     return "success";

    //     $originalFace = YiiBase::getPathOfAlias('webroot') . '/uploads/'.$folder.'/'.$use_id.'.jpg';

    //     //face straigh
    //     $pathFaceStraight = 'FaceVerifyStraight';
    //     $full_path_facestraight = $uploadDir.$pathFaceStraight."/".$use_id.".jpg";
    //     file_put_contents($full_path_facestraight, file_get_contents($file["face_image_1"]["tmp_name"]));
    //     $fileStraight = curl_file_create($full_path_facestraight, 'image/jpeg', 'filename.jpg');

    //     //face left
    //     $pathFaceLeft = 'FaceVerifyLeft';
    //     $full_path_faceleft = $uploadDir.$pathFaceLeft."/".$use_id.".jpg";
    //     file_put_contents($full_path_faceleft, file_get_contents($file["face_image_2"]["tmp_name"]));
    //     $fileLeft = curl_file_create($full_path_faceleft, 'image/jpeg', 'filename.jpg');

    //     //face right
    //     $pathFaceRight = 'FaceVerifyRight';
    //     $full_path_faceright = $uploadDir.$pathFaceRight."/".$use_id.".jpg";
    //     file_put_contents($full_path_faceright, file_get_contents($file["face_image_3"]["tmp_name"]));
    //     $fileRight = curl_file_create($full_path_faceright, 'image/jpeg', 'filename.jpg');



    //     $data = [
    //         'original_face' => new CURLFILE($originalFace),
    //         'face_image_1' => $fileStraight,
    //         'face_image_2' => $fileLeft,
    //         'face_image_3' => $fileRight,
    //     ];


    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, 'https://223.27.223.70/api/validate/');
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    //     $response = curl_exec($ch);
    //     $responseJson = json_decode($response);

    //     $status = "unsuccess";
    //     if($type != "register"){
    //         if($responseJson->liveness->liveness_class == "Real"){ // Real Capture
    //             if($responseJson->valid_scores->validated_class == "Accept"){ // Real User
    //                     $status = "success";
    //             }else {
    //                     $status = "unsuccess";
    //             }
    //         }else{
    //             $status = "fake";
    //         }
    //     }else{
    //         if($responseJson->liveness->liveness_class == "Real"){ // Real Capture
    //             if($responseJson->valid_scores->validated_score >= 60){ // Real User
    //                     $status = "success";
    //             }else {
    //                     $status = "unsuccess";
    //             }
    //         }else{
    //             $status = "fake";
    //         }
    //     }

    //     if(isset($responseJson->liveness)){
    //         $logVerify = new LogVerifyFace();
    //         $logVerify->user_id = $use_id;
    //         $logVerify->liveness_score = $responseJson->liveness->liveness_score;
    //         $logVerify->liveness_class = $responseJson->liveness->liveness_class;
    //         $logVerify->validated_class = $responseJson->valid_scores->validated_class;
    //         $logVerify->validated_score = $responseJson->valid_scores->validated_score;
    //         $logVerify->create_date = date("Y-m-d H:i:s");
    //         $logVerify->type = $type;
    //         $logVerify->status = $status;
    //         $logVerify->save();
    //     }

    //     if (file_exists($full_path_facestraight) && file_exists($full_path_faceleft) && file_exists($full_path_faceright)) {
    //         unlink($full_path_facestraight); 
    //         unlink($full_path_faceleft);
    //         unlink($full_path_faceright);
    //     } 

    //     return $status;
    // }

    public function ApiFaceExamsImage($use_id, $folder = null, $id = null, $filenams = null, $captureId = 0)
    {
        $originalFace = YiiBase::getPathOfAlias('webroot') . '/uploads/FaceRegis/' . $use_id . '.jpg';
        $learnImage = YiiBase::getPathOfAlias('webroot') . '/uploads/' . $folder . '/' . $id . '/' . $use_id . '/' . $filenams;

        $typeFace = pathinfo($originalFace, PATHINFO_EXTENSION);
        $dataFace = file_get_contents($originalFace);
        $base64_Face = 'data:image/' . $typeFace . ';base64,' . base64_encode($dataFace);

        $typeLearn = pathinfo($learnImage, PATHINFO_EXTENSION);
        $dataLearn = file_get_contents($learnImage);
        $base64_Learn = 'data:image/' . $typeLearn . ';base64,' . base64_encode($dataLearn);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apis.aigen.online/aiface/face-compare/v1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "image1" : "' . $base64_Face . '",
            "image2" : "' . $base64_Learn . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'x-aigen-key: SBu7ph3zolxi66yin11525vaqx7a6ibt3q',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $return_de = json_decode($response);
        curl_close($curl);

        $status = false;
        if (isset($return_de->confidence)) {
            if ($return_de->confidence > 60) {
                $status = true;
            }

            $logVerify = new LogVerifyFace();
            $logVerify->user_id = $use_id;
            $logVerify->liveness_score = $return_de->confidence;
            $logVerify->create_date = date("Y-m-d H:i:s");
            $logVerify->capture_id = $captureId;
            $logVerify->type = $folder;
            $logVerify->status = $status;
            $logVerify->save();
            if ($return_de->confidence > 60) {
                echo "pass";exit();
            }else{
                echo "nopass";exit();
            }
        }else{
            echo "nopass";exit();
        }

        echo "nopass";exit();

        /////////////////////// ปิดวันที่ 29/05/2566 ///////////////

        // $data = [
        //     'original_face' => new CURLFILE($originalFace),
        //     'face_image_1' => new CURLFILE($face_image),
        //     'face_image_2' => new CURLFILE($face_image),
        //     'face_image_3' =>new CURLFILE($face_image),
        // ];


        // $ch = curl_init();

        // curl_setopt($ch, CURLOPT_URL, 'https://223.27.223.70/api/validate/');
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // $response = curl_exec($ch);
        // $responseJson = json_decode($response);
        // if($responseJson->liveness->liveness_class == "Real"){ // Real Capture
        //     if($responseJson->valid_scores->validated_class == "Accept"){ // Real User
        //             echo "pass";
        //     }else {
        //             echo "nopass";
        //     }
        // }else{
        //     echo "nopass";
        // }

        /////////////////////// ปิดวันที่ 29/05/2566 ///////////////



        //   $curl = curl_init();

        //    $target = YiiBase::getPathOfAlias('webroot') . '/uploads/FaceRegis/'.$use_id.'.jpg';
        //    $source = YiiBase::getPathOfAlias('webroot') . '/uploads/'.$folder.'/'.$id.'/'.$use_id.'/'.$filenams;

        //     curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://facesimilarityv2.api.dakok.net/api/compare',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS =>
        //     array('source'=> new CURLFILE($source),
        //      'target'=> new CURLFILE($target)),
        //     CURLOPT_HTTPHEADER => array(
        //       'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJhYmFhZDljZS0wOTRjLTRkYTAtYTZmNy03OTAxM2JjNDIzNjkiLCJwcm9qZWN0IjoiTUQiLCJjdXN0b21lciI6Ik5QQiBEaWdpdGFsIiwicHVycG9zZSI6InBvYyIsImlzcyI6IkRBS09LIExpY2Vuc2UgdjIiLCJleHAiOjE2OTIyNDY1NjgwMDAsImlhdCI6MTY2MDcxMDU2ODAwMH0.ZlGycJyvPWlonhNIyBzvWiTUE_WhBawU147tNRN6bGvsRSFrXqdhyzND10_EXKGhDEagllCnBjP90n6kkr3NrvQzeT-AhpOx_06tWIuK-EbVUH7uQlTuTbKMBUHO21ljsrAphdj-C5uJsJHmjP53GY16NWlgnuXbNwt4jCnERv1_iNiOJlQlLyE0EhNfCflKST32TLUpHiC9qn0kwx2yOOTI1yeg5Ta6k6toWaEqYiErNoHcLWEYAYBoY3L4_iJB6NlrYOTPlw7jnLyRXMoOVySN2MAByh39p5N1fWPOhChJvIJqiOk1PWm5EXjJpy1TKLtFbC_s3olTTQ5-oXOnxw'
        //   ),
        // ));

        //   $response = curl_exec($curl);
        //   $return_de = json_decode($response);
        //   curl_close($curl);

        //   if(count($return_de->data[0]->FaceMatches) > 0){
        //   echo "pass";exit();
        //   }else{
        //   echo "nopass"; exit();
        //   } 


    }


    public function ApiFaceIdCard($use_id)
    {

        $target = YiiBase::getPathOfAlias('webroot') . '/uploads/IdCard/' . $use_id . '.jpg';
        return "success";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://223.27.223.70/api/id_card/');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => new CURLFILE($target)));

        $response = curl_exec($ch);
        $responseJson = json_decode($response);


        if ($responseJson->card_img != null && $responseJson->face_img) {
            // Set the file URL and path
            $path = 'FaceIdCard';
            $uploadDir = Yii::app()->getUploadPath(null);
            $uploadDir = $uploadDir . '../';
            $full_path = $uploadDir . $path . "/" . $use_id . ".jpg";

            $file_url = $responseJson->face_img;
            $save_path = $full_path;

            // Open a file stream to the save path
            $fp = fopen($save_path, 'w');

            // Create a new SSL context
            $ssl_context = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            // Use file_get_contents to download the file using SSL
            $file_contents = file_get_contents($file_url, false, $ssl_context);

            // Write the contents of the file to the stream
            fwrite($fp, $file_contents);

            // Close the file stream
            fclose($fp);

            return "success";
        } else {
            return "unsuccess";
        }
    }



    public function getLearn($course_id)
    {
        $learn = false;

        $course_model = CourseOnline::model()->findByPk($course_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $chk = LogStartcourse::model()->find(array(
            'condition' => 'course_id=:course_id AND user_id=:user_id AND active=:active AND gen_id=:gen_id',
            'params' => array(':course_id' => $course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id)
        ));

        if (!empty($chk)) {
            $learn = true;
        }

        return $learn;
    }

    public function checkUserCourseExpire($model)
    {
        $stats = false;

        $course_model = CourseOnline::model()->findByPk($model->course_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $chk = LogStartcourse::model()->find(array(
            'condition' => 'course_id=:course_id AND user_id=:user_id AND active=:active AND gen_id=:gen_id',
            'params' => array(':course_id' => $model->course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id)
        ));

        if (!empty($chk)) {

            $start_date = strtotime(date($chk->start_date));
            $enddate = strtotime(date($chk->end_date));
            $currentDate = strtotime(date("Y-m-d H:i:s"));

            if ($currentDate >= $start_date && $currentDate <= $enddate) {
                $stats = true;
            } else if ($currentDate >= $start_date && $currentDate >= $enddate) {
                $stats = false;
            } else {
                $stats = false;
            }
        }


        return $stats;
    }

    public function changethainum($num)
    {
        return str_replace(
            array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
            array("o", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙"),
            $num
        );
    }

    public function FunctionName($value = '')
    {
        # code...
    }

    public function DateThaiNew($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    }

    public function DateEngNew($strDate)
    {
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", "Jan.", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    }

    public function DateThaiNewNotime($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    public function DateEngNewNotime($strDate)
    {
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", "Jan.", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }


    public function changeFormatDateNewEn($date, $type = null)
    {
        if ($type == 'full' && $date != '') {
            $date = explode('-', $date);
            $day = $date[2];
            $month = $date[1];
            $year = $date[0];
            if ($year == '543' && $month == '00' && $day == '00') {
                return 'ยังไม่เข้าสู่ระบบ';
            }
            switch ($month) {
                case '01':
                    $month = 'January';
                    break;
                case '02':
                    $month = 'February';
                    break;
                case '03':
                    $month = 'March';
                    break;
                case '04':
                    $month = 'April';
                    break;
                case '05':
                    $month = 'May';
                    break;
                case '06':
                    $month = 'June';
                    break;
                case '07':
                    $month = 'July';
                    break;
                case '08':
                    $month = 'August';
                    break;
                case '09':
                    $month = 'September';
                    break;
                case '10':
                    $month = 'October';
                    break;
                case '11':
                    $month = 'November';
                    break;
                case '12':
                    $month = 'December';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $day . ' ' . $month . ' ' . $year;
        } else if ($date != '') {
            if ($date == '0000-00-00') {
                return '-';
            } else {
                $date = explode('-', $date);
                $day = $date[2];
                $month = $date[1];
                $year = $date[0];
                switch ($month) {
                    case '01':
                        $month = 'Jan';
                        break;
                    case '02':
                        $month = 'Feb';
                        break;
                    case '03':
                        $month = 'Mar';
                        break;
                    case '04':
                        $month = 'Apr';
                        break;
                    case '05':
                        $month = 'May';
                        break;
                    case '06':
                        $month = 'Jun';
                        break;
                    case '07':
                        $month = 'Jul';
                        break;
                    case '08':
                        $month = 'Aug';
                        break;
                    case '09':
                        $month = 'Sep';
                        break;
                    case '10':
                        $month = 'Oct';
                        break;
                    case '11':
                        $month = 'Nov';
                        break;
                    case '12':
                        $month = 'Dec';
                        break;
                    default:
                        $month = 'error';
                        break;
                }
                return $day . ' ' . $month . ' ' . $year;
            }
        }
        return $date;
    }

    public function changeFormatDate($date, $type = null)
    {
        if ($type == 'datetime' && $date != '') {
            $date = explode('-', $date);
            $year = $date[0] + 543;
            $month = $date[1];
            $day = $date[2];
            $day = explode(' ', $day);
            $days = $day[0];
            $time = explode(':', $day[1]);
            $hour = $time[0];
            $minute = $time[1];
            if ($year == '543' && $month == '00' && $days == '00') {
                return 'ยังไม่เข้าสู่ระบบ';
            }
            switch ($month) {
                case '01':
                    $month = 'มกราคม';
                    break;
                case '02':
                    $month = 'กุมภาพันธ์';
                    break;
                case '03':
                    $month = 'มีนาคม';
                    break;
                case '04':
                    $month = 'เมษายน';
                    break;
                case '05':
                    $month = 'พฤษภาคม';
                    break;
                case '06':
                    $month = 'มิถุนายน';
                    break;
                case '07':
                    $month = 'กรกฎาคม';
                    break;
                case '08':
                    $month = 'สิงหาคม';
                    break;
                case '09':
                    $month = 'กันยายน';
                    break;
                case '10':
                    $month = 'ตุลาคม';
                    break;
                case '11':
                    $month = 'พฤศจิกายน';
                    break;
                case '12':
                    $month = 'ธันวาคม';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $days . ' ' . $month . ' ' . $year . ' ' . $hour . ':' . $minute . ' น.';
        } else if ($date != '') {
            $date = explode('-', $date);
            $year = $date[0] + 543;
            $month = $date[1];
            $day = $date[2];
            $day = explode(' ', $day);
            $day = $day[0];
            switch ($month) {
                case '01':
                    $month = 'มกราคม';
                    break;
                case '02':
                    $month = 'กุมภาพันธ์';
                    break;
                case '03':
                    $month = 'มีนาคม';
                    break;
                case '04':
                    $month = 'เมษายน';
                    break;
                case '05':
                    $month = 'พฤษภาคม';
                    break;
                case '06':
                    $month = 'มิถุนายน';
                    break;
                case '07':
                    $month = 'กรกฎาคม';
                    break;
                case '08':
                    $month = 'สิงหาคม';
                    break;
                case '09':
                    $month = 'กันยายน';
                    break;
                case '10':
                    $month = 'ตุลาคม';
                    break;
                case '11':
                    $month = 'พฤศจิกายน';
                    break;
                case '12':
                    $month = 'ธันวาคม';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $day . ' ' . $month . ' ' . $year;
        }
        return $date;
    }


    public function changeFormatDateTHshort($date, $type = null)
    {
        if ($type == 'datetime' && $date != '') {
            $date = explode('-', $date);
            $year = $date[0] + 543;
            $month = $date[1];
            $day = $date[2];
            $day = explode(' ', $day);
            $days = $day[0];
            $time = explode(':', $day[1]);
            $hour = $time[0];
            $minute = $time[1];
            if ($year == '543' && $month == '00' && $days == '00') {
                return 'ยังไม่เข้าสู่ระบบ';
            }
            switch ($month) {
                case '01':
                    $month = 'ม.ค.';
                    break;
                case '02':
                    $month = 'ก.พ.';
                    break;
                case '03':
                    $month = 'มี.ค.';
                    break;
                case '04':
                    $month = 'เม.ย.';
                    break;
                case '05':
                    $month = 'พ.ค.';
                    break;
                case '06':
                    $month = 'มิ.ย.';
                    break;
                case '07':
                    $month = 'ก.ค.';
                    break;
                case '08':
                    $month = 'ส.ค.';
                    break;
                case '09':
                    $month = 'ก.ย.';
                    break;
                case '10':
                    $month = 'ต.ค.';
                    break;
                case '11':
                    $month = 'พ.ย.';
                    break;
                case '12':
                    $month = 'ธ.ค.';
                    break;
                default:
                    $month = 'error';
                    break;
            }

            return $days . ' ' . $month . ' ' . $year . ' ' . $hour . ':' . $minute . ' น.';
        } else if ($date != '') {
            $date = explode('-', $date);
            $year = $date[0] + 543;
            $month = $date[1];
            $day = $date[2];
            $day = explode(' ', $day);
            $day = $day[0];
            switch ($month) {
                case '01':
                    $month = 'ม.ค.';
                    break;
                case '02':
                    $month = 'ก.พ.';
                    break;
                case '03':
                    $month = 'มี.ค.';
                    break;
                case '04':
                    $month = 'เม.ย.';
                    break;
                case '05':
                    $month = 'พ.ค.';
                    break;
                case '06':
                    $month = 'มิ.ย.';
                    break;
                case '07':
                    $month = 'ก.ค.';
                    break;
                case '08':
                    $month = 'ส.ค.';
                    break;
                case '09':
                    $month = 'ก.ย.';
                    break;
                case '10':
                    $month = 'ต.ค.';
                    break;
                case '11':
                    $month = 'พ.ย.';
                    break;
                case '12':
                    $month = 'ธ.ค.';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $day . ' ' . $month . ' ' . $year;
        }
        return $date;
    }


    public function changeFormatsaveBirthday($date)
    {
        if ($date != '') {
            $date = explode('-', $date);
            $year = $date[2];
            $month = $date[1];
            $day = $date[0];
            $day = explode(' ', $day);
            $days = $day[0];
            return $year . '-' . $month . '-' . $days;
        }
    }


    public function checkTypeCourse($cate_id)
    {
        $type = Category::model()->findByPk($cate_id);
        if ($type->special_category == 'y') {
            return true;
        } else {
            return false;
        }
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
        $SetUpSetting['ACTIVE_OFFICE'] = $Setting->settings_register_office;
        $SetUpSetting['ACTIVE_PERSONAL'] = $Setting->settings_register_personal;

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
        $newdate = date('Y-m-d', mktime(
            date('h', $cd),
            date('i', $cd),
            date('s', $cd),
            date('m', $cd) + $mth,
            date('d', $cd) + $day,
            date('Y', $cd) + $yr
        ));
        return $newdate;
    }

    public function SendMail($to, $subject, $message, $fromText = 'E-Learning System Marine Department')
    {
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/Exception.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/PHPMailer.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/SMTP.php";
        $SettingAll = Helpers::lib()->SetUpSetting();
        $model = Cfsendmail::model()->findByPk(2);

        $adminEmail = $model->email;
        $adminEmailPass = $model->password;

        $mail =  new PHPMailer(true);

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );



        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP();
        $mail->Host = 'smtp.office365.com'; // gmail server
        // $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587'; // port number
        // $mail->SMTPSecure = "tls";
        $mail->SMTPSecure = "STARTTLS";
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

        // $mail->SMTPSecure = 'tls';


        // return $mail->Send();
        return true;
    }

    public function SendMailLearnPass($to, $subject, $message, $fromText = 'E-Learning System ascenmoney')
    {
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/Exception.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/PHPMailer.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/SMTP.php";

        $SettingAll = Helpers::lib()->SetUpSetting();
        $model = Cfsendmail::model()->findByPk(1);

        $adminEmail = $model->email;
        $adminEmailPass = $model->password;

        $mail =  new PHPMailer(true);
        $mail =  new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com'; // gmail server
        $mail->Port = '587'; // port number
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        // $mail->SMTPDebug  = 1;
        // $mail->From = 'mailerbws@gmail.com';
        $mail->Username = $adminEmail;
        $mail->Password = $adminEmailPass;
        $fromText = 'E-Learning System ascenmoney';
        $mail->SetFrom($adminEmail, $fromText);
        $mail->AddAddress($to['email'], 'คุณ' . $to['firstname'] . ' ' . $to['lastname']);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);

        $mail->Send();
    }

    public function SendMailToUser($to, $subject, $message, $fromText = 'E-Learning System ascenmoney')
    {
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/Exception.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/PHPMailer.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/SMTP.php";

        $SettingAll = Helpers::lib()->SetUpSetting();
        $$model = Cfsendmail::model()->findByPk(1);

        $adminEmail = $model->email;
        $adminEmailPass = $model->password;

        $mail =  new PHPMailer(true);
        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        // $mail->Host = '172.30.110.16'; // gmail server
        // $mail->Port = 25; // port number
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587'; // port number
        $mail->SMTPSecure = "tls";
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        // $mail->SMTPDebug  = 1;
        $mail->From = 'mailerbws@gmail.com';
        $mail->Username = $adminEmail;
        $mail->Password = $adminEmailPass;
        $fromText = 'E-Learning System ascenmoney';
        $mail->SetFrom($adminEmail, $fromText);
        $mail->AddAddress($to['email'], 'คุณ' . $to['firstname'] . ' ' . $to['lastname']);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->IsHTML(true);
        $mail->Send();
    }

    public function displayLdap()
    {
        $member = $this->ldapTms('mailerbws@gmail.com');
        var_dump('<pre>');
        var_dump($member);
        exit();
    }

    public function SendMailMsg($to, $subject, $message, $attachment = null)
    {

        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/Exception.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/PHPMailer.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/SMTP.php";

        $SettingAll = Helpers::lib()->SetUpSetting();
        $adminEmail = $SettingAll['USER_EMAIL'];
        $adminEmailPass = $SettingAll['PASS_EMAIL'];


        $adminEmail = 'thoresen.elearning@gmail.com';
        $adminEmailPass = 'lms@2020';

        $mail =  new PHPMailer(true);

        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        // 
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587'; // port number
        $mail->SMTPSecure = "tls";
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        // $mail->SMTPDebug  = 1;
        $mail->From = 'mailerbws@gmail.com';
        $mail->Username = $adminEmail;
        $mail->Password = $adminEmailPass;
        $fromText = 'E-Learning System ascenmoney';
        $mail->SetFrom('mailerbws@gmail.com', $fromText);

        $mail->AddAddress($to['email'], 'คุณ' . $to['firstname'] . ' ' . $to['lastname']);
        $mail->Subject = $subject;
        $mail->Body = $message;
        if (!empty($attachment)) {
            $mail->addAttachment($attachment);
        }
        $mail->IsHTML(true);
        $member = $this->ldapTms($to['email']);
        if ($member['count'] <= 0) {
            Yii::app()->user->setFlash('mail', $to['email']);
        }
        return $mail->Send();
    }

    public function displayUser()
    {
        $member = $this->ldapTms('mailerbws@gmail.com');
        if ($member) {
            var_dump($member);
        } else {
            var_dump("nullllll");
        }

        exit();
    }

    public function SendMailNotification($subject, $message, $depart_id)
    {

        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/Exception.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/PHPMailer.php";
        require dirname(__FILE__) . "/../extensions/mailer/phpmailer/src/SMTP.php";

        $address = Users::model()->findAll(array(
            'condition' => 'department_id=' . $depart_id,
        ));

        if ($address) {
            $SettingAll = Helpers::lib()->SetUpSetting();
            $adminEmail = $SettingAll['USER_EMAIL'];
            $adminEmailPass = $SettingAll['PASS_EMAIL'];

            $adminEmail = 'thoresen.elearning@gmail.com';
            $adminEmailPass = 'lms@2020';

            $mail =  new PHPMailer(true);
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->ClearAddresses();
            $mail->CharSet = 'utf-8';
            $mail->IsSMTP();
            // $mail->ClearAddresses();
            // $mail->CharSet = 'utf-8';

            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587'; // port number
            $mail->SMTPSecure = "tls";
            $mail->SMTPKeepAlive = true;
            $mail->Mailer = "smtp";
            // $mail->SMTPDebug  = 1;
            $mail->From = 'mailerbws@gmail.com';
            $mail->Username = $adminEmail;
            $mail->Password = $adminEmailPass;
            $fromText = 'E-Learning System ascenmoney';
            $mail->SetFrom($adminEmail, $fromText);

            foreach ($address as $data_email) {
                $mail->AddAddress($data_email->email, 'คุณ' . $data_email->profile->firstname . ' ' . $data_email->profile->lastname);
            }

            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->IsHTML(true);
            $mail->Send();
        }
    }

    public function SendMailNotificationByUser($subject, $message, $user_id)
    {

        // require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/Exception.php";
        // require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/PHPMailer.php";
        // require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/SMTP.php";

        $address = Users::model()->findByPk($user_id);

        if ($address) {
            $SettingAll = Helpers::lib()->SetUpSetting();
            $adminEmail = $SettingAll['USER_EMAIL'];
            $adminEmailPass = $SettingAll['PASS_EMAIL'];

            $adminEmail = 'thoresen.elearning@gmail.com';
            $adminEmailPass = 'lms@2020';

            // $mail =  new PHPMailer(true);
            $mail = Yii::app()->mailer;
            $mail->ClearAddresses();
            $mail->CharSet = 'utf-8';
            // $mail->Host = '172.30.110.16'; // gmail server
            // $mail->Port = 25; // port number
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587'; // port number
            $mail->SMTPSecure = "tls";
            $mail->SMTPKeepAlive = true;
            $mail->Mailer = "smtp";
            // $mail->SMTPDebug  = 1;
            $mail->From = 'mailerbws@gmail.com';
            $mail->Username = $adminEmail;
            $mail->Password = $adminEmailPass;
            $fromText = 'E-Learning System ascenmoney';
            $mail->SetFrom($adminEmail, $fromText);

            $mail->AddAddress($address->email, 'คุณ' . $address->profile->firstname . ' ' . $address->profile->lastname);

            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->IsHTML(true);
            return $mail->Send();
        }
    }

    public function SendMailGroup($to, $subject, $message, $fromText = 'E-Learning System ascenmoney')
    {
        $path = '../uploads/filemail/';
        $SettingAll = Helpers::lib()->SetUpSetting();
        $adminEmail = $SettingAll['USER_EMAIL'];
        $adminEmailPass = $SettingAll['PASS_EMAIL'];

        $mail = Yii::app()->mailer;
        $mail->ClearAddresses();
        $mail->CharSet = 'utf-8';
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com'; // gmail server
        $mail->Port = '465'; // port number
        $mail->SMTPSecure = "ssl";
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $adminEmail;
        $mail->Password = $adminEmailPass;
        $mail->SetFrom($adminEmail, $fromText);

        $address = Mailuser::model()->findAll(array(
            'condition' => 'group_id=' . $to,
        ));
        if ($address) {
            foreach ($address as $data_email) {
                $mail->AddAddress($data_email->user->email); // to destination
            }
        }
        $file = Mailfile::model()->findAll(array(
            'condition' => 'maildetail_id=' . $to,
        ));
        if ($file) {
            foreach ($file as $data_name) {
                $mail->addAttachment($path . $data_name->file_name);
            }
        }
        //        $mail->addAttachment($path);
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

    // ไม่เอาค่าซํ้า
    function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
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

    public function checkLessonFile($file, $learn_id, $gen_id = null)
    {
        $user = Yii::app()->getModule('user')->user();

        $learn_model = Learn::model()->findByPk($learn_id);
        if ($learn_model != null) {
            if ($gen_id == null) {
                $gen_id = $learn_model->LessonMapper->CourseOnlines->getGenID($learn_model->LessonMapper->course_id);
            }
        }

        /*$learnFiles = $user->learnFiles(
                    array(
                        'condition' => 'file_id=:file_id',
                        'params' => array(':file_id' => $file->id)
                        )
                    );*/
        $learnFiles = $user->learnFiles(
            array(
                'condition' => 'file_id=:file_id AND learns.learn_id=:learn_id AND lesson_active=:status AND learns.gen_id=:gen_id',
                'params' => array(':file_id' => $file->id, ':learn_id' => $learn_id, ':status' => 'y', ':gen_id' => $gen_id)
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

    public static function isPretestStateCourse($course_id, $gen_id = null)
    {
        $course = CourseOnline::model()->findByPk($course_id);
        if (!$course) { // ไม่พบบทเรียน
            return false;
        }

        if ($gen_id == null) {
            $gen_id = $course->getGenID($course_id);
        }

        if (self::checkHaveCoursePreTestInManage($course_id)) {
            $haveScore = Coursescore::model()->findAllByAttributes(array('course_id' => $course_id, 'type' => 'pre', 'user_id' => Yii::app()->user->id, 'active' => 'y', 'gen_id' => $gen_id));
            if (empty($haveScore)) {
                return true;
            }
        }

        if (self::checkHaveCourseTestInManage($course_id)) {
            $haveScore = Coursescore::model()->findAllByAttributes(array('course_id' => $course_id, 'type' => 'course', 'user_id' => Yii::app()->user->id, 'active' => 'y', 'gen_id' => $gen_id));
            if (empty($haveScore)) {
                return false;
            }
        }
    }

    public static function isPretestState($lesson_id, $gen_id = null)
    {
        $lesson = Lesson::model()->findByPk($lesson_id);

        if (!$lesson) { // ไม่พบบทเรียน
            return false;
        }

        // if (self::lib()->checkLessonPass($lesson) != 'notLearn') { // ถ้ากำลังเรียนหรือเรียนจบ จะไม่มี pre
        //     return false;
        // }

        if (!self::checkHavePreTestInManage($lesson_id)) { // ถ้าไม่มีการเพิ่มข้อสอบก่อนเรียนในระบบ
            return false;
        }

        if ($gen_id == null) {
            $course_model = CourseOnline::model()->findByPk($lesson->course_id);
            $gen_id = $course_model->getGenID($course_model->course_id);
        }


        $haveScore = Score::model()->findAllByAttributes(array('lesson_id' => $lesson_id, 'user_id' => Yii::app()->user->id, 'active' => 'y', 'gen_id' => $gen_id));

        if (!$haveScore) { // ถ้าไม่มีการสอบไปแล้ว แสดงว่ายังไม่ทำ pre
            return true;
        }

        return false;
    }


    public static function isPretestStateMsteams($lesson_id, $gen_id = null)
    {
        $lesson = LessonMsTeams::model()->findByPk($lesson_id);

        if (!$lesson) { // ไม่พบบทเรียน
            return false;
        }

        if (!self::checkHavePreTestInManageMsTeams($lesson_id)) { // ถ้าไม่มีการเพิ่มข้อสอบก่อนเรียนในระบบ
            return false;
        }

        $gen_id = 0;


        $haveScore = ScoreMsTeams::model()->findAllByAttributes(array('lesson_teams_id' => $lesson_id, 'user_id' => Yii::app()->user->id, 'active' => 'y', 'gen_id' => $gen_id));

        if (!$haveScore) { // ถ้าไม่มีการสอบไปแล้ว แสดงว่ายังไม่ทำ pre
            return true;
        }

        return false;
    }

    public static function isPretestStateOnline($lesson_id, $gen_id = null)
    {
        $lesson = LessonOnline::model()->findByPk($lesson_id);

        if (!$lesson) { // ไม่พบบทเรียน
            return false;
        }

        if (!self::checkHavePreTestInManageOnline($lesson_id)) { // ถ้าไม่มีการเพิ่มข้อสอบก่อนเรียนในระบบ
            return false;
        }

        $gen_id = 0;


        $haveScore = ScoreOnline::model()->findAllByAttributes(array('lesson_teams_id' => $lesson_id, 'user_id' => Yii::app()->user->id, 'active' => 'y', 'gen_id' => $gen_id));

        if (!$haveScore) { // ถ้าไม่มีการสอบไปแล้ว แสดงว่ายังไม่ทำ pre
            return true;
        }

        return false;
    }

    public static function isPosttestStateMsteams($lesson_id, $gen_id = null)
    {
        $lesson = LessonMsTeams::model()->findByPk($lesson_id);

        if (!$lesson) { // ไม่พบบทเรียน
            return false;
        }

        if (!self::checkHavePostTestInManageMsTeams($lesson_id)) { // ถ้าไม่มีการเพิ่มข้อสอบก่อนเรียนในระบบ
            return false;
        }

        $gen_id = 0;

        $haveScore = ScoreMsTeams::model()->findAllByAttributes(array('lesson_teams_id' => $lesson_id, 'user_id' => Yii::app()->user->id, 'type' => 'post', 'active' => 'y', 'gen_id' => $gen_id));

        if (!$haveScore) { // ถ้าไม่มีการสอบไปแล้ว แสดงว่ายังไม่ทำ post
            return true;
        }

        return false;
    }


    public static function isPosttestStateOnline($lesson_id, $gen_id = null)
    {
        $lesson = LessonOnline::model()->findByPk($lesson_id);

        if (!$lesson) { // ไม่พบบทเรียน
            return false;
        }

        if (!self::checkHavePostTestInManageOnline($lesson_id)) { // ถ้าไม่มีการเพิ่มข้อสอบก่อนเรียนในระบบ
            return false;
        }

        $gen_id = 0;

        $haveScore = ScoreOnline::model()->findAllByAttributes(array('lesson_teams_id' => $lesson_id, 'user_id' => Yii::app()->user->id, 'type' => 'post', 'active' => 'y', 'gen_id' => $gen_id));

        if (!$haveScore) { // ถ้าไม่มีการสอบไปแล้ว แสดงว่ายังไม่ทำ post
            return true;
        }

        return false;
    }



    public static function isPosttestState($lesson_id, $gen_id = null)
    {
        $lesson = Lesson::model()->findByPk($lesson_id);

        if (!$lesson) { // ไม่พบบทเรียน
            return false;
        }

        // if (self::lib()->checkLessonPass($lesson) != 'pass') { // ถ้ากำลังเรียนหรือยังไม่เข้าเรียน จะไม่มี post
        //     return false;
        // }

        if (!self::checkHavePostTestInManage($lesson_id)) { // ถ้าไม่มีการเพิ่มข้อสอบก่อนเรียนในระบบ
            return false;
        }

        if ($gen_id == null) {
            $course_model = CourseOnline::model()->findByPk($lesson->course_id);
            $gen_id = $course_model->getGenID($course_model->course_id);
        }

        $haveScore = Score::model()->findAllByAttributes(array('lesson_id' => $lesson_id, 'user_id' => Yii::app()->user->id, 'type' => 'post', 'active' => 'y', 'gen_id' => $gen_id));

        if (!$haveScore) { // ถ้าไม่มีการสอบไปแล้ว แสดงว่ายังไม่ทำ post
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
        } else {
            return true;
        }
    }

    public static function checkHavePreTestInManageMsTeams($lesson_id)
    {
        //$isExamAddToLessonForTest = Manage::model()->with('grouptesting')->findAllByAttributes(array('id' => $lesson_id, 'type' => 'pre'));
        $isExamAddToLessonForTest = ManageMsTeams::model()->with('grouptesting')->findAll("id = '" . $lesson_id . "' AND type = 'pre' AND manage.active='y' AND grouptesting.active ='y'");
        if (!$isExamAddToLessonForTest) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkHavePreTestInManageOnline($lesson_id)
    {
        //$isExamAddToLessonForTest = Manage::model()->with('grouptesting')->findAllByAttributes(array('id' => $lesson_id, 'type' => 'pre'));
        $isExamAddToLessonForTest = ManageOnline::model()->with('grouptesting')->findAll("id = '" . $lesson_id . "' AND type = 'pre' AND manage.active='y' AND grouptesting.active ='y'");
        if (!$isExamAddToLessonForTest) {
            return false;
        } else {
            return true;
        }
    }



    public static function checkHavePostTestInManage($lesson_id)
    {
        //$isExamAddToLessonForTest = Manage::model()->with('grouptesting')->findAllByAttributes(array('id' => $lesson_id, 'type' => 'pre'));
        $isExamAddToLessonForTest = Manage::model()->with('grouptesting')->findAll("id = '" . $lesson_id . "' AND type = 'post' AND manage.active='y' AND grouptesting.active ='y'");
        if (!$isExamAddToLessonForTest) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkHavePostTestInManageMsTeams($lesson_id)
    {
        //$isExamAddToLessonForTest = Manage::model()->with('grouptesting')->findAllByAttributes(array('id' => $lesson_id, 'type' => 'pre'));
        $isExamAddToLessonForTest = ManageMsTeams::model()->with('grouptesting')->findAll("id = '" . $lesson_id . "' AND type = 'post' AND manage.active='y' AND grouptesting.active ='y'");
        if (!$isExamAddToLessonForTest) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkHavePostTestInManageOnline($lesson_id)
    {
        //$isExamAddToLessonForTest = Manage::model()->with('grouptesting')->findAllByAttributes(array('id' => $lesson_id, 'type' => 'pre'));
        $isExamAddToLessonForTest = ManageOnline::model()->with('grouptesting')->findAll("id = '" . $lesson_id . "' AND type = 'post' AND manage.active='y' AND grouptesting.active ='y'");
        if (!$isExamAddToLessonForTest) {
            return false;
        } else {
            return true;
        }
    }


    public static function checkHaveCourseTestInManage($course_id)
    { // เช็ค ข้อสอบ final หลักสูตร
        $isExamAddToCourseForTest = Coursemanage::model()->with('group')->findAll("id = '" . $course_id . "' AND type = 'course' AND manage.active='y' AND group.active ='y'");
        if (!$isExamAddToCourseForTest) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkHaveCoursePreTestInManage($course_id)
    { // เช็ค ข้อสอบ ก่อนเรียน หลักสูตร
        $isExamAddToCourseForTest = Coursemanage::model()->with('group')->findAll("id = '" . $course_id . "' AND type = 'pre' AND manage.active='y' AND group.active ='y'");
        if (!$isExamAddToCourseForTest) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkHaveScoreCoursePreTest($course_id, $gen_id = null)
    {
        // // เช็คว่าสอบไปยัง      ข้อสอบ ก่อนเรียน หลักสูตร
        if ($gen_id == null) {
            $course_model = CourseOnline::model()->findByPk($course_id);
            $gen_id = $course_model->getGenID($course_model->course_id);
        }

        $Course_Score = Coursescore::model()->find(array(
            'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND type=:type AND active=:active',
            'params' => array(':type' => 'pre', ':course_id' => $course_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id, ':active' => 'y')
        ));
        // print_r($Course_Score);
        if ($Course_Score == "") { // ไม่มีคะแนนสอบ
            return true; //ยังไม่สอบ
        } else {
            return false;
        }
    }

    public static function ScoreCoursePreTest($course_id, $gen_id = null)
    {
        // คะแนน ข้อสอบ ก่อนเรียน
        if ($gen_id == null) {
            $course_model = CourseOnline::model()->findByPk($course_id);
            $gen_id = $course_model->getGenID($course_model->course_id);
        }

        $Course_Score = Coursescore::model()->find(array(
            'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND type=:type AND active=:active',
            'params' => array(':type' => 'pre', ':course_id' => $course_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id, ':active' => 'y')
        ));

        $text = $Course_Score->score_number . "/" . $Course_Score->score_total;
        return $text;
    }



    public function checkLessonPassPostest($lesson)
    {
        $user = Yii::app()->getModule('user')->user();
        if ($user) {

            $lesson_model = Lesson::model()->findByPk($lesson->id);
            $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

            $learnLesson = $user->learns(
                array(
                    'condition' => 'lesson_id=:lesson_id AND lesson_active=:status AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':status' => "y", ':gen_id' => $gen_id)
                )
            );
            $countFile = 0;
            $countLearnCompareTrueVdos = 0;
            if ($lesson->type == 'vdo') {
                // $countFile = $lesson->fileCount;
                $countFile = $lesson->GetfileCount($lesson->id);
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'pdf') {
                $countFile = $lesson->filePdfCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTruePdf(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'scorm') {
                $countFile = $lesson->fileScormCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueScorm(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'ebook') {
                $countFile = $lesson->fileCountEbook;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueEbook(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'audio') {
                $countFile = $lesson->fileAudioCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueAudio(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            }
            if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
                $return = 'pass';
                if (self::isPosttestState($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                    $checkpretest_do = self::CheckTest($lesson, 'post');
                    if (!$checkpretest_do->value->boolean) {
                        $return = "notLearn";
                    }
                }
                return $return;
            } else {
                if ($countFile == 0 /*&& $learnLesson*/) {
                    $return = 'pass';
                    //// check pretest
                    if (self::isPretestState($lesson->id)) { ///ถ้ามีข้อสอบก่อนเรียน
                        $checkpretest_do = self::CheckTest($lesson, 'pre');
                        if (!$checkpretest_do->value->boolean) {
                            $return = "notLearn";
                        }
                    }
                    ////end check pretest

                    //// check posttest
                    if (self::isPosttestState($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                        $checkpretest_do = self::CheckTest($lesson, 'post');
                        if (!$checkpretest_do->value->boolean) {
                            $return = "notLearn";
                        }
                    }
                    //end check posttest
                    if ($countFile == 0) {
                        $return = 'pass';
                    }
                    return $return;
                } else {
                    if ($countFile != 0 && $learnLesson) {
                        if ($countLearnCompareTrueVdos != $countFile) {
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

    public function checkLessonPass($lesson, $gen_id = null)
    {
        $user = Yii::app()->getModule('user')->user();
        if ($user) {
            if ($gen_id == null) {
                $lesson_model = Lesson::model()->findByPk($lesson->id);
                $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);
            }
            $learnLesson = $user->learns(
                array(
                    'condition' => 'lesson_id=:lesson_id AND lesson_active=:status AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':status' => "y", ':gen_id' => $gen_id)
                )
            );

            $countFile = 0;
            $countLearnCompareTrueVdos = 0;
            if ($lesson->type == 'vdo') {
                // $countFile = $lesson->fileCount;
                $countFile = $lesson->GetfileCount($lesson->id);
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'pdf') {
                $countFile = $lesson->filePdfCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTruePdf(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'scorm') {
                $countFile = $lesson->fileScormCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueScorm(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'audio') {
                $countFile = $lesson->fileAudioCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueAudio(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'youtube') {
                // $countFile = $lesson->fileCount;
                $countFile = $lesson->GetfileCount($lesson->id);
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'ebook') {
                $countFile = $lesson->fileCountEbook;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueEbook(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            }
            if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
                return "pass";
            } else {
                if ($countFile == 0 /*&& $learnLesson*/) {
                    $return = 'pass';
                    //// check pretest
                    if (self::isPretestState($lesson->id)) { ///ถ้ามีข้อสอบก่อนเรียน
                        $checkpretest_do = self::CheckTest($lesson, 'pre');
                        if (!$checkpretest_do->value->statusBoolean) {
                            $return = "notLearn";
                        }
                    }
                    ////end check pretest

                    //// check posttest
                    if (self::isPosttestState($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                        $checkpretest_do = self::CheckTest($lesson, 'post');
                        if (!$checkpretest_do->value->statusBoolean) {
                            $return = "notLearn";
                        }
                    }
                    //end check posttest
                    if ($countFile == 0) {
                        $return = 'pass';
                    }
                    return $return;
                } else {
                    if ($countFile != 0 && $learnLesson) {
                        if ($countLearnCompareTrueVdos != $countFile) {
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

    public function checkCourseStatus($lesson)
    {
        // var_dump($lesson);
        $color = '#00bfff';
        $status = '';
        $user = Yii::app()->getModule('user')->user();
        if ($user) {
            $course_model = CourseOnline::model()->findByPk($lesson);
            $gen_id = $course_model->getGenID($course_model->course_id);

            $learnLesson = $user->learns(
                array(
                    'condition' => 'course_id=:course_id AND lesson_active=:status AND gen_id=:gen_id',
                    'params' => array(':course_id' => $lesson, ':status' => "y", ':gen_id' => $gen_id)
                )
            );

            $model = Lesson::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND course_id=' . $lesson, 'order' => 'lesson_no'));

            if (empty($learnLesson)) {
                $color = "#fff";
                $status = "notLearn";
                $class = "defaultcourse";
            } else {

                if (count($learnLesson) == count($model)) {

                    foreach ($learnLesson as $key => $value) {
                        if ($value->lesson_status == "learning") {
                            $color = "#fff";
                            $status = "learning";
                            $class = "warningcourse";
                            break;
                        } elseif ($value->lesson_status == "pass") {
                            $color = "#fff";
                            $status = "pass";
                            $class = "successcourse";
                        }
                    }

                    // if($status == "pass"){
                    //    $criteria = new CDbCriteria;
                    //    $criteria->compare('course_id',$lesson);
                    //    $criteria->compare('user_id',Yii::app()->user->id);
                    //    $criteria->compare('score_past','y');
                    //    $criteria->compare('active','y');
                    //    $criteria->order = 'score_id';
                    //    $courseScorePass = Coursescore::model()->findAll($criteria);
                    //    if(!$courseScorePass){
                    //             $color = "#fff";
                    //             $status = "learning";
                    //             $class = "warningcourse";
                    //     }
                    // }

                } else {
                    $color = "#fff";
                    $status = "learning";
                    $class = "warningcourse";
                }
            }
        }
        return (object)array('color' => $color, 'status' => $status, 'class' => $class);
    }


    public function checkLessonPass_Percent_MsTeams($lesson, $format = null, $gen_id = null)
    {
        $percent_max = 100;
        $percent = 0;
        $color = '#00bfff';
        $status = '';
        $user = Yii::app()->getModule('user')->user();
        if ($user) {
            if ($gen_id == null) {
                $lesson_model = LessonMsTeams::model()->findByPk($lesson->id);
                $gen_id = 0;
            }
            $lesson = LessonMsTeams::model()->findByPk($lesson->id);

            $color = "#fff";
            $status = "notLearn";
            $class = "defaultcourse";

            if (self::checkHavePreTestInManageMsTeams($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                $checkpretest_do = self::CheckTestMsTeams($lesson, 'pre', $gen_id);
                if ($checkpretest_do->value['statusBoolean']) {
                    $color = "#fff";
                    $status = "learning";
                    $class = "warningcourse";
                }
            }

            if (self::checkHavePostTestInManageMsTeams($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                $checkpretest_do = self::CheckTestMsTeams($lesson, 'post', $gen_id);
                if ($checkpretest_do->value['statusBoolean']) {
                    $color = "#fff";
                    $status = "pass";
                    $class = "successcourse";
                }
            } else {
                $color = "#fff";
                $status = "pass";
                $class = "successcourse";
            }



            //end check posttest

        }
        return (object)array('percent' => $percent, 'color' => $color, 'status' => $status, 'class' => $class);
    }


    public function checkLessonPass_Percent_Online($lesson, $format = null, $gen_id = null)
    {
        $percent_max = 100;
        $percent = 0;
        $color = '#00bfff';
        $status = '';
        $user = Yii::app()->getModule('user')->user();
        if ($user) {
            if ($gen_id == null) {
                $lesson_model = LessonOnline::model()->findByPk($lesson->id);
                $gen_id = 0;
            }
            $lesson = LessonOnline::model()->findByPk($lesson->id);

            $color = "#fff";
            $status = "notLearn";
            $class = "defaultcourse";

            if (self::checkHavePreTestInManageOnline($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                $checkpretest_do = self::CheckTestOnline($lesson, 'pre', $gen_id);
                if ($checkpretest_do->value['statusBoolean']) {
                    $color = "#fff";
                    $status = "learning";
                    $class = "warningcourse";
                }
            }

            if (self::checkHavePostTestInManageOnline($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                $checkpretest_do = self::CheckTestOnline($lesson, 'post', $gen_id);
                if ($checkpretest_do->value['statusBoolean']) {
                    $color = "#fff";
                    $status = "pass";
                    $class = "successcourse";
                }
            } else {
                $color = "#fff";
                $status = "pass";
                $class = "successcourse";
            }



            //end check posttest

        }
        return (object)array('percent' => $percent, 'color' => $color, 'status' => $status, 'class' => $class);
    }




    public function checkLessonPass_Percent($lesson, $format = null, $gen_id = null)
    {
        $percent_max = 100;
        $percent = 0;
        $color = '#00bfff';
        $status = '';
        $user = Yii::app()->getModule('user')->user();
        if ($user) {
            if ($gen_id == null) {
                $lesson_model = Lesson::model()->findByPk($lesson->id);
                $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);
            }
            $lesson = Lesson::model()->findByPk($lesson->id);

            $learnLesson = $user->learns(
                array(
                    'condition' => 'lesson_id=:lesson_id AND lesson_active=:status AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':status' => "y", ':gen_id' => $gen_id)
                )
            );

            $countFile = 0;
            $countLearnCompareTrueVdos = 0;
            if ($lesson->type == 'vdo' || $lesson->type == 'youtube') {
                // $countFile = $lesson->fileCount;
                $countFile = $lesson->GetfileCount($lesson->id);
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'pdf') {
                $countFile = $lesson->filePdfCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTruePdf(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'scorm') {
                $countFile = $lesson->fileScormCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueScorm(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'ebook') {
                $countFile = $lesson->fileCountEbook;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueEbook(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            } else if ($lesson->type == 'audio') {
                $countFile = $lesson->fileAudioCount;
                $countLearnCompareTrueVdos = $user->countLearnCompareTrueAudio(
                    array(
                        'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND lesson_active="y" AND t.gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                    )
                );
            }
            if (!empty($learnLesson) && $learnLesson[0]->lesson_status == 'pass') {
                $percent = $percent_max;
                $color = "#fff";
                $status = "pass";
                $class = "successcourse";

                //// check posttest
                if (self::checkHavePostTestInManage($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                    $checkpretest_do = self::CheckTest($lesson, 'post', $gen_id);
                    if (!$checkpretest_do->value['statusBoolean']) {
                        $percent = 0;
                        $color = "#fff";
                        $status = "learning";
                        $class = "warningcourse";
                    }
                }
                //end check posttest
            } else {
                if ($countFile == 0/* && $learnLesson*/) {

                    $percent = $percent_max;
                    $color = "#fff";
                    $status = "pass";
                    $class = "successcourse";
                    //// check pretest
                    if (self::isPretestState($lesson->id, $gen_id)) { ///ถ้ามีข้อสอบก่อนเรียน
                        $checkpretest_do = self::CheckTest($lesson, 'pre', $gen_id);
                        if (!$checkpretest_do->value->boolean) {
                            $percent = 0;
                            $color = "#fff";
                            $status = "notLearn";
                            $class = "defaultcourse";
                        }
                    }
                    ////end check pretest

                    //// check posttest
                    if (self::isPosttestState($lesson->id, $gen_id)) { ///ถ้ามีข้อสอบหลังเรียน
                        $checkpretest_do = self::CheckTest($lesson, 'post', $gen_id);
                        if (!$checkpretest_do->value->boolean) {
                            $percent = 0;
                            $color = "#fff";
                            $status = "notLearn";
                            $class = "defaultcourse";
                        }
                    }
                    //end check posttest
                } else {
                    if ($countFile != 0 && !empty($learnLesson)) {
                        if ($countLearnCompareTrueVdos != $countFile) {
                            $percent_fn = ($countLearnCompareTrueVdos * 100) / $countFile;
                            $percent = number_format($percent_fn, 2);
                            if (is_numeric($format)) {
                                $percent = number_format($percent_fn, $format);
                            }
                            $color = "#fff";
                            $status = "learning";
                            $class = "warningcourse";
                        } else {
                            $percent = $percent_max;
                            $color = "#fff";
                            $status = "pass";
                            $class = "successcourse";
                        }
                    } else {
                        $percent = 0;
                        $color = "#fff";
                        $status = "notLearn";
                        $class = "defaultcourse";
                    }
                }
            }
        }
        return (object)array('percent' => $percent, 'color' => $color, 'status' => $status, 'class' => $class);
    }


    public function checkCoursePass($course_id, $gen = 0)
    {
        $user = Yii::app()->getModule('user')->user();
        $lessonAll = Lesson::model()->findAllByAttributes(array('course_id' => $course_id, 'lang_id' => 1, 'active' => 'y'));
        $lessonAllCount = count($lessonAll);
        $lessonPassCount = 0;

        if ($lessonAll) {
            foreach ($lessonAll as $lesson) {
                $gen_id = $gen != 0 ? $gen : $lesson->CourseOnlines->getGenID($lesson->course_id);
                $checkPreTest = self::checkHavePreTestInManage($lesson->id);
                $checkPostTest = self::checkHavePostTestInManage($lesson->id);
                $step1 = false;
                $step2 = false;
                $step3 = false;
                if ($checkPreTest) {

                    $haveScorePre = Score::model()->find(array(
                        'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND active=:active AND type = "pre" AND gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id)
                    ));

                    if ($haveScorePre != null) {
                        $step1 = true;
                    }
                } else {
                    $step1 = true;
                }

                $learnLesson = $user->learns(
                    array(
                        'condition' => 'lesson_id=:lesson_id AND lesson_active=:status AND gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lesson->id, ':status' => "y", ':gen_id' => $gen_id)
                    )
                );

                $countFile = 0;
                $countLearnCompareTrueVdos = 0;
                if ($lesson->type == 'vdo') {
                    // $countFile = $lesson->fileCount;
                    $countFile = $lesson->GetfileCount($lesson->id);
                    $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                        array(
                            'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                            'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                        )
                    );
                } else if ($lesson->type == 'pdf') {
                    $countFile = $lesson->filePdfCount;
                    $countLearnCompareTrueVdos = $user->countLearnCompareTruePdf(
                        array(
                            'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                            'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                        )
                    );
                } else if ($lesson->type == 'scorm') {
                    $countFile = $lesson->fileScormCount;
                    $countLearnCompareTrueVdos = $user->countLearnCompareTrueScorm(
                        array(
                            'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                            'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                        )
                    );
                } else if ($lesson->type == 'audio') {
                    $countFile = $lesson->fileAudioCount;
                    $countLearnCompareTrueVdos = $user->countLearnCompareTrueAudio(
                        array(
                            'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                            'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                        )
                    );
                }

                if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
                    $step2 = true;
                } else {
                    if ($countFile == 0) {
                        $step2 = true;
                    } else {
                        if ($countFile != 0 && $learnLesson) {
                            if ($countLearnCompareTrueVdos != $countFile) {
                            } else {
                                $step2 = true;
                            }
                        }
                    }
                }


                if ($checkPostTest) {
                    $haveScorePost = Score::model()->find(array(
                        'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND active=:active AND type = "post" AND gen_id=:gen_id AND score_past=:past',
                        'params' => array(':lesson_id' => $lesson->id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id, ':past' => 'y')
                    ));

                    if ($haveScorePost != null) {
                        // if($haveScorePost->score_past == 'y'){
                        $step3 = true;
                        // }
                    }
                } else {
                    $step3 = true;
                }

                if ($step1 && $step2 && $step3) {
                    $lessonPassCount++;
                }

                // if ($this->checkLessonPass($lesson) == "pass") {
                //     if ($this->CheckTestCount('pass', $lesson->id,false,true,'post') == true) {
                //         $lessonPassCount++;
                //     }
                // }
            }
            // print_r($lessonAllCount);
            // print_r($lessonPassCount);
            if ($lessonAllCount == $lessonPassCount) {
                return "pass";
            } else {
                return "notPass";
            }
        } else {
            return "pass";
        }
    }

    public function checkCourseLearnStatus($course_id)
    {
        $lessonAll = Lesson::model()->findAllByAttributes(array('course_id' => $course_id));
        $lessonAllCount = count($lessonAll);
        $lessonPassCount = 0;
        $lessonlearningCount = 0;
        $lessonNotPassCount = 0;

        if ($lessonAll) {
            foreach ($lessonAll as $lesson) {
                $value = $this->checkLessonPass_Percent($lesson);
                if ($value->status == "pass") {
                    $lessonPassCount++;
                } else if ($value->status == 'learning') {
                    $lessonlearningCount++;
                } else {
                    $lessonNotPassCount++;
                }
            }

            if ($lessonAllCount == $lessonPassCount) {
                return "pass";
            } else if ($lessonlearningCount != 0) {
                return "learning";
            } else {
                return "notPass";
            }
        } else {
            return "notFound";
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

    public function checkTestCourse($course)
    {
        if ($course) {
            $data = "";

            $course_model = CourseOnline::model()->findByPk($course->id);
            $gen_id = $course_model->getGenID($course_model->course_id);

            $criteria = new CDbCriteria;
            // $criteria->select = '*';
            $criteria->condition = ' course_id="' . $course->id . '" AND user_id="' . Yii::app()->user->id . '" AND gen_id="' . $gen_id . '" AND type="post"';
            $criteria->order = 'score_number DESC';

            $criteria2 = new CDbCriteria;
            $criteria2->condition = ' course_id="' . $course->id . '" AND score_past="y" AND user_id="' . Yii::app()->user->id . '" AND gen_id="' . $gen_id . '" AND type="post"';
            $criteria2->order = 'score_number ASC';
            $score = Coursescore::model()->find($criteria);
            $score_past = Coursescore::model()->find($criteria2);
            if (!empty($score->score_number)) {
                $percent = number_format(($score->score_number / $score->score_total) * 100, 0);
                if ($score_past) {
                    $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                    $data['option']['color'] = "#0C9C14";
                    $data['value']['status'] = " (ผ่าน)";
                    $data['value']['score'] = $score->score_number;
                    $data['value']['total'] = $score->score_total;
                    $data['value']['pass'] = true;
                } else {
                    $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                    $data['option']['color'] = "#D9534F";
                    $data['value']['status'] = " (ไม่ผ่าน)";
                    $data['value']['score'] = $score->score_number;
                    $data['value']['total'] = $score->score_total;
                    $data['value']['pass'] = false;
                }
                $data['value']['percent'] = $percent;
                $data['value']['boolean'] = true;
            } else {
                $data['value']['percent'] = 0;
                $data['option']['color'] = "#D9534F";
                $data['value']['text'] = "ยังไม่ทำแบบทดสอบหลักสูตร";
                $data['value']['boolean'] = false;
            }
            return (object)$data;
        }
    }

    //("true" return string) && ("false" return true or false)
    public function CheckTestCount($status, $id, $return = false, $check = true, $type)
    {
        if ($status == "learning") {
            if ($check == true) {
                if ($return == true) {
                    $CheckTesting = '<label style="color: #E60000;">ยังไม่มีสิทธิ์ทำแบบทดสอบหลังเรียน</label>';
                } else {
                    $CheckTesting = false; //No Past
                }
            } else {
                $CheckTesting = false;
            }
        } else if ($status == "notLearn") {
            if ($check == true) {
                if ($return == true)
                    //                    $CheckTesting = '-';
                    $CheckTesting = '<label style="color: #E60000">ยังไม่เข้าเรียน</label>';
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

                $lesson_new = TestAmount::model()->count(
                    "lesson_id=:lesson_id AND user_id=:user_id AND type =:type ",
                    array(
                        "lesson_id" => $id, "user_id" => Yii::app()->user->id, "type" => $type
                    )
                );

                //                $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id  AND type =:type ", array(
                //                    "lesson_id" => $id, "user_id" => Yii::app()->user->id, "type" => $type
                //                ));

                $lesson_model = Lesson::model()->findByPk($id);
                $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

                $countScorePast = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type=:type AND gen_id=:gen_id", array(
                    "lesson_id" => $id, "user_id" => Yii::app()->user->id, "type" => $type, 'gen_id' => $gen_id
                ));

                if (!empty($countScorePast)) {
                    if ($check == true) {
                        if ($return == true) {
                            $CheckTesting = '<a href="' . Yii::app()->createUrl('question/scoreAll', array('id' => $id)) . '" target="_blank" class="btn btn-dbd btn-sm">ผลการทดสอบ</a>';
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
                                $CheckTesting = '<label style=" color: #E60000;">ทำแบบทดสอบไม่ผ่าน</label>';
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
                                ), array(
                                    'class' => 'btn btn-dbd btn-sm'
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
                        $CheckTesting = '<label style="color: #E60000">ไม่มีแบบทดสอบ</label>';
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
                    $CheckTesting = '<label style="color: #E60000">ต้องเรียนให้ผ่านทุกหัวข้อ</label>';
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

    public function CheckCourseNextPass($course_id, $department_id = '')
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
        return $text_return;
    }

    public function CountTestIng($id, $amount, $type)
    {

        $lesson_model = Lesson::model()->findByPk($id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type='" . $type . "' AND gen_id=:gen_id", array(
            "user_id" => Yii::app()->user->id,
            "lesson_id" => $id,
            'gen_id' => $gen_id
        ));
        $lesson_new = TestAmount::model()->count(
            "lesson_id=:lesson_id AND user_id=:user_id AND type = '" . $type . "'",
            array("lesson_id" => $id, "user_id" => Yii::app()->user->id)
        );
        if (!$lesson_new) {
            $lesson_new = 0;
        }

        $sum = intval($amount - $lesson_new);

        if ($sum != 0 && $countScore <= $amount) {
            $num = 'เหลือ ' . $sum . ' ครั้ง';
        } else {
            $num = '<label style="color: #E60000;">หมดสิทธิ์ทำแบบทดสอบ</label>';
        }

        return $num;
    }

    public function CountTestIngTF($status, $id, $amount)
    {
        $lesson_model = Lesson::model()->findByPk($id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        if ($status == "pass") {
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type='post' AND gen_id=:gen_id", array(
                "user_id" => Yii::app()->user->id,
                "lesson_id" => $id,
                'gen_id' => $gen_id
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

    public function ScorePercent($id, $type)
    {
        $lesson_model = Lesson::model()->findByPk($id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $criteria = new CDbCriteria;
        $criteria->select = '*,MAX(score_number) as score_number';
        $criteria->condition = ' type = "' . $type . '" AND lesson_id="' . $id . '" AND user_id="' . Yii::app()->user->id . '" AND gen_id="' . $gen_id . '"';
        $Score = Score::model()->find($criteria);

        if (!empty($Score->score_number)) {
            $check['value'] = number_format(($Score->score_number / $Score->score_total) * 100, 0);
            $check['option']['color'] = "#0C9C14";
        } else {
            $check['value'] = '0';
            $check['option']['color'] = "#F00";
        }

        return (object)$check;
    }

    public function ScoreToTal($id, $type)
    {
        $lesson_model = Lesson::model()->findByPk($id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $criteria = new CDbCriteria;
        $criteria->select = '*,MAX(score_total) as score_total';
        $criteria->condition = ' type = "' . $type . '" AND lesson_id="' . $id . '" AND user_id="' . Yii::app()->user->id . '" AND gen_id="' . $gen_id . '"';
        $Score = Score::model()->find($criteria);

        if (!empty($Score->score_total)) {
            //$check = number_format(($Score->score_total/$Score->score_total)*100,2);
            $check = number_format(($Score->score_total));
        } else {
            $check = '0';
        }

        return $check;
    }

    public function CheckTestingPass($id, $type, $return = false, $checkEvaluate = false)
    {
        $lessonModel = Lesson::model()->findAll(array(
            'condition' => 'course_id=:course_id',
            'params' => array(':course_id' => $id)
        ));

        $_Score = 0;
        $scoreCheck = 0;
        $totalCheck = 0;
        $PassLearnCout = 0;

        $course_model = CourseOnline::model()->findByPk($id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        foreach ($lessonModel as $key => $value) {
            $lessonStatus = $this->checkLessonPass($value);
            $scoreSum = $this->ScorePercent($value->id, $type)->value;
            $scoreToTal = $this->ScoreToTal($value->id, $type);

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
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND gen_id=:gen_id", array(
                "user_id" => Yii::app()->user->id,
                "lesson_id" => $value->id,
                'gen_id' => $gen_id
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
                                    'id' => $id
                                ), array(
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

    public function checkLessonParentPass($lesson)
    {

        $user = Yii::app()->getModule('user')->user();
        if ($user) {

            $lesson_model = Lesson::model()->findByPk($lesson->id);
            $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

            $learnLesson = $user->learns(
                array(
                    'condition' => 'lesson_id=:lesson_id and lesson_active ="y" AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                )
            );

            if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
                if (self::checkHavePostTestInManage($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                    $checkposttest_do = self::CheckTest($lesson, 'post');
                    if ($checkposttest_do->value['statusBoolean']) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                // $fileCount = $lesson->type == 'vdo' ? $lesson->fileCount : $lesson->fileCountPdf;
                $fileCount = $lesson->type == 'vdo' ? $lesson->GetfileCount($lesson->id) : $lesson->fileCountPdf;
                if ($fileCount == 0 /*&& $learnLesson*/) {
                    $return = true;
                    //// check pretest
                    if (self::isPretestState($lesson->id)) { ///ถ้ามีข้อสอบก่อนเรียน
                        $checkpretest_do = self::CheckTest($lesson, 'pre');
                        if (!$checkpretest_do->value->boolean) {
                            $return = false;
                        }
                    }
                    ////end check pretest

                    //// check posttest
                    if (self::isPosttestState($lesson->id)) { ///ถ้ามีข้อสอบหลังเรียน
                        $checkpretest_do = self::CheckTest($lesson, 'post');
                        if (!$checkpretest_do->value->boolean) {
                            $return = false;
                        }
                    }
                    //end check posttest
                    return $return;
                } else {
                    if ($fileCount != 0 && $learnLesson) {

                        $countLearnCompareTrue = $lesson->type == 'vdo' ? $user->countLearnCompareTrueVdos(
                            array(
                                'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\'  AND t.gen_id=:gen_id',
                                'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                            )
                        ) : $user->countLearnCompareTruePdf(
                            array(
                                'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\'  AND t.gen_id=:gen_id',
                                'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                            )
                        );

                        $postState = true;
                        //  if(self::isTestState($lesson->id,'post',3)){
                        //     $checkpretest_do = self::checkStatusLecture($lesson, "post",3);
                        //     if(!$checkpretest_do->value['boolean']){
                        //         return false;
                        //     }
                        // }
                        if (self::isTestState($lesson->id, 'post')) {
                            $checkpretest_do = self::CheckTest($lesson, "post", 0);
                            if (!$checkpretest_do->value['boolean']) {
                                return false;
                            }
                        }
                        if ($postState) {
                            if ($countLearnCompareTrue != $fileCount) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    } else {
                        return false;
                    }
                }
            }
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


    public function CheckTestMsTeams($lesson, $type, $gen_id = null)
    {
        if ($lesson) {
            $data = "";

            if ($gen_id == null) {
                $lesson_model = LessonMsTeams::model()->findByPk($lesson->id);
                $gen_id = 0;
            }

            if ($type == "post") {
                $criteria = new CDbCriteria;
                // $criteria->select = '*,MAX(score_number) as score_number';
                $criteria->compare('type', $type);
                $criteria->compare('lesson_teams_id', $lesson->id);
                $criteria->compare('gen_id', $gen_id);
                $criteria->compare('user_id', Yii::app()->user->id);
                $criteria->compare('active', "y");
                // $criteria->condition = ' type = "'.$type.'" AND lesson_id="' . $lesson->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"';
                $criteria->order = 'score_number DESC';
                $score = ScoreMsTeams::model()->find($criteria);
                if ($score->score_past != null) {
                    $percent = number_format(($score->score_number / $score->score_total) * 100, 0);
                    if ($score->score_past == "y") {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = " (ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    } else {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['statusBoolean'] = false;
                        $data['value']['status'] = " (ไม่ผ่าน)";
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    }
                    $data['value']['percent'] = $percent;
                    $data['value']['boolean'] = true;
                } else {
                    $checkPostTest = Helpers::checkHavePostTestInManageMsTeams($lesson->id);
                    if ($checkPostTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            } elseif ($type == "pre") {
                $criteria = new CDbCriteria;
                $criteria->select = '*,MAX(score_number) as score_number';
                $criteria->condition = ' type = "' . $type . '" AND lesson_teams_id="' . $lesson->id . '" AND user_id="' . Yii::app()->user->id . '" and active ="y" AND gen_id="' . $gen_id . '"';
                $score = ScoreMsTeams::model()->find($criteria);

                if ($score->score_past != null) {
                    //                    $data['value']['percent'] = number_format(($score->score_number/$score->score_total)*100,0);
                    $data = array('value' => array('percent' => number_format(($score->score_number / $score->score_total) * 100, 0)));
                    $data['value']['boolean'] = true;
                    $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                    $data['value']['score'] = $score->score_number;
                    $data['value']['total'] = $score->score_total;
                    if ($score->score_past == "n") {
                        $data['option']['color'] = "#D9534F";
                        $data['value']['status'] = "(ไม่ผ่าน)";
                        $data['value']['statusBoolean'] = false;
                    } else {
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = "(ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                    }
                } else {
                    $checkPreTest = Helpers::checkHavePreTestInManageMsTeams($lesson->id);
                    if ($checkPreTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            }
            return (object)$data;
        }
    }



    public function CheckTestOnline($lesson, $type, $gen_id = null)
    {
        if ($lesson) {
            $data = "";

            if ($gen_id == null) {
                $lesson_model = LessonOnline::model()->findByPk($lesson->id);
                $gen_id = 0;
            }

            if ($type == "post") {
                $criteria = new CDbCriteria;
                // $criteria->select = '*,MAX(score_number) as score_number';
                $criteria->compare('type', $type);
                $criteria->compare('lesson_teams_id', $lesson->id);
                $criteria->compare('gen_id', $gen_id);
                $criteria->compare('user_id', Yii::app()->user->id);
                $criteria->compare('active', "y");
                // $criteria->condition = ' type = "'.$type.'" AND lesson_id="' . $lesson->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"';
                $criteria->order = 'score_number DESC';
                $score = ScoreOnline::model()->find($criteria);
                if ($score->score_past != null) {
                    $percent = number_format(($score->score_number / $score->score_total) * 100, 0);
                    if ($score->score_past == "y") {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = " (ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    } else {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['statusBoolean'] = false;
                        $data['value']['status'] = " (ไม่ผ่าน)";
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    }
                    $data['value']['percent'] = $percent;
                    $data['value']['boolean'] = true;
                } else {
                    $checkPostTest = Helpers::checkHavePostTestInManageOnline($lesson->id);
                    if ($checkPostTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            } elseif ($type == "pre") {
                $criteria = new CDbCriteria;
                $criteria->select = '*,MAX(score_number) as score_number';
                $criteria->condition = ' type = "' . $type . '" AND lesson_teams_id="' . $lesson->id . '" AND user_id="' . Yii::app()->user->id . '" and active ="y" AND gen_id="' . $gen_id . '"';
                $score = ScoreOnline::model()->find($criteria);

                if ($score->score_past != null) {
                    //                    $data['value']['percent'] = number_format(($score->score_number/$score->score_total)*100,0);
                    $data = array('value' => array('percent' => number_format(($score->score_number / $score->score_total) * 100, 0)));
                    $data['value']['boolean'] = true;
                    $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                    $data['value']['score'] = $score->score_number;
                    $data['value']['total'] = $score->score_total;
                    if ($score->score_past == "n") {
                        $data['option']['color'] = "#D9534F";
                        $data['value']['status'] = "(ไม่ผ่าน)";
                        $data['value']['statusBoolean'] = false;
                    } else {
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = "(ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                    }
                } else {
                    $checkPreTest = Helpers::checkHavePreTestInManageOnline($lesson->id);
                    if ($checkPreTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            }
            return (object)$data;
        }
    }


    public function CheckTest($lesson, $type, $gen_id = null)
    {
        if ($lesson) {
            $data = "";

            if ($gen_id == null) {
                $lesson_model = Lesson::model()->findByPk($lesson->id);
                $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);
            }

            if ($type == "post") {
                $criteria = new CDbCriteria;
                // $criteria->select = '*,MAX(score_number) as score_number';
                $criteria->compare('type', $type);
                $criteria->compare('lesson_id', $lesson->id);
                $criteria->compare('gen_id', $gen_id);
                $criteria->compare('user_id', Yii::app()->user->id);
                $criteria->compare('active', "y");
                // $criteria->condition = ' type = "'.$type.'" AND lesson_id="' . $lesson->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"';
                $criteria->order = 'score_number DESC';
                $score = Score::model()->find($criteria);
                if ($score->score_past != null) {
                    $percent = number_format(($score->score_number / $score->score_total) * 100, 0);
                    if ($score->score_past == "y") {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = " (ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    } else {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['statusBoolean'] = false;
                        $data['value']['status'] = " (ไม่ผ่าน)";
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    }
                    $data['value']['percent'] = $percent;
                    $data['value']['boolean'] = true;
                } else {
                    $checkPostTest = Helpers::checkHavePostTestInManage($lesson->id);
                    if ($checkPostTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            } elseif ($type == "pre") {
                $criteria = new CDbCriteria;
                $criteria->select = '*,MAX(score_number) as score_number';
                $criteria->condition = ' type = "' . $type . '" AND lesson_id="' . $lesson->id . '" AND user_id="' . Yii::app()->user->id . '" and active ="y" AND gen_id="' . $gen_id . '"';
                $score = Score::model()->find($criteria);

                if ($score->score_past != null) {
                    //                    $data['value']['percent'] = number_format(($score->score_number/$score->score_total)*100,0);
                    $data = array('value' => array('percent' => number_format(($score->score_number / $score->score_total) * 100, 0)));
                    $data['value']['boolean'] = true;
                    $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                    $data['value']['score'] = $score->score_number;
                    $data['value']['total'] = $score->score_total;
                    if ($score->score_past == "n") {
                        $data['option']['color'] = "#D9534F";
                        $data['value']['status'] = "(ไม่ผ่าน)";
                        $data['value']['statusBoolean'] = false;
                    } else {
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = "(ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                    }
                } else {
                    $checkPreTest = Helpers::checkHavePreTestInManage($lesson->id);
                    if ($checkPreTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            }
            return (object)$data;
        }
    }

    public function CheckTestAll($lesson, $type, $score)
    {
        if ($lesson) {
            $data = "";
            if ($type == "post") {
                if ($score->score_past != null) {
                    $percent = number_format(($score->score_number / $score->score_total) * 100, 0);
                    if ($score->score_past == "y") {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = " (ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    } else {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['statusBoolean'] = false;
                        $data['value']['status'] = " (ไม่ผ่าน)";
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    }
                    $data['value']['percent'] = $percent;
                    $data['value']['boolean'] = true;
                } else {
                    $checkPostTest = Helpers::checkHavePostTestInManage($lesson->id);
                    if ($checkPostTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            } elseif ($type == "pre") {
                if ($score->score_past != null) {
                    //                    $data['value']['percent'] = number_format(($score->score_number/$score->score_total)*100,0);
                    $data = array('value' => array('percent' => number_format(($score->score_number / $score->score_total) * 100, 0)));
                    $data['value']['boolean'] = true;
                    $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                    $data['value']['score'] = $score->score_number;
                    $data['value']['total'] = $score->score_total;
                    if ($score->score_past == "n") {
                        $data['option']['color'] = "#D9534F";
                        $data['value']['status'] = "(ไม่ผ่าน)";
                        $data['value']['statusBoolean'] = false;
                    } else {
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = "(ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                    }
                } else {
                    $checkPreTest = Helpers::checkHavePreTestInManage($lesson->id);
                    if ($checkPreTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            }
            return (object)$data;
        }
    }


    public function CheckTestAllMsTeams($lesson, $type, $score)
    {
        if ($lesson) {
            $data = "";
            if ($type == "post") {
                if ($score->score_past != null) {
                    $percent = number_format(($score->score_number / $score->score_total) * 100, 0);
                    if ($score->score_past == "y") {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = " (ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    } else {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['statusBoolean'] = false;
                        $data['value']['status'] = " (ไม่ผ่าน)";
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    }
                    $data['value']['percent'] = $percent;
                    $data['value']['boolean'] = true;
                } else {
                    $checkPostTest = Helpers::checkHavePostTestInManageMsTeams($lesson->id);
                    if ($checkPostTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            } elseif ($type == "pre") {
                if ($score->score_past != null) {
                    //                    $data['value']['percent'] = number_format(($score->score_number/$score->score_total)*100,0);
                    $data = array('value' => array('percent' => number_format(($score->score_number / $score->score_total) * 100, 0)));
                    $data['value']['boolean'] = true;
                    $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                    $data['value']['score'] = $score->score_number;
                    $data['value']['total'] = $score->score_total;
                    if ($score->score_past == "n") {
                        $data['option']['color'] = "#D9534F";
                        $data['value']['status'] = "(ไม่ผ่าน)";
                        $data['value']['statusBoolean'] = false;
                    } else {
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = "(ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                    }
                } else {
                    $checkPreTest = Helpers::checkHavePreTestInManageMsTeams($lesson->id);
                    if ($checkPreTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            }
            return (object)$data;
        }
    }


    public function CheckTestAllOnline($lesson, $type, $score)
    {
        if ($lesson) {
            $data = "";
            if ($type == "post") {
                if ($score->score_past != null) {
                    $percent = number_format(($score->score_number / $score->score_total) * 100, 0);
                    if ($score->score_past == "y") {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = " (ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    } else {
                        //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                        $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['statusBoolean'] = false;
                        $data['value']['status'] = " (ไม่ผ่าน)";
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                    }
                    $data['value']['percent'] = $percent;
                    $data['value']['boolean'] = true;
                } else {
                    $checkPostTest = Helpers::checkHavePostTestInManageOnline($lesson->id);
                    if ($checkPostTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบหลังเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            } elseif ($type == "pre") {
                if ($score->score_past != null) {
                    //                    $data['value']['percent'] = number_format(($score->score_number/$score->score_total)*100,0);
                    $data = array('value' => array('percent' => number_format(($score->score_number / $score->score_total) * 100, 0)));
                    $data['value']['boolean'] = true;
                    $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                    $data['value']['score'] = $score->score_number;
                    $data['value']['total'] = $score->score_total;
                    if ($score->score_past == "n") {
                        $data['option']['color'] = "#D9534F";
                        $data['value']['status'] = "(ไม่ผ่าน)";
                        $data['value']['statusBoolean'] = false;
                    } else {
                        $data['option']['color'] = "#0C9C14";
                        $data['value']['status'] = "(ผ่าน)";
                        $data['value']['statusBoolean'] = true;
                    }
                } else {
                    $checkPreTest = Helpers::checkHavePreTestInManageOnline($lesson->id);
                    if ($checkPreTest) {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ยังไม่ทำแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    } else {
                        //                        $data['value']['percent'] = 0;
                        $data = array('value' => array('percent' => 0));
                        $data['option']['color'] = "#D9534F";
                        $data['value']['text'] = "ไม่มีแบบทดสอบก่อนเรียน";
                        $data['value']['boolean'] = false;
                    }
                }
            }
            return (object)$data;
        }
    }


    public function checkTestPassAll($course_id)
    {
        $flagTestPre = false;
        $flagTestPost = false;
        $data = array();

        $course_model = CourseOnline::model()->findByPk($course_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $criteria = new CDbCriteria;
        $criteria->compare('course_id', $course_id);
        $criteria->compare('active', 'y');
        $criteria->compare('lang_id', '1');
        $lessons = Lesson::model()->findAll($criteria);
        foreach ($lessons as $key => $lesson) {
            foreach ($lesson->Manages as $key => $ckManage) {

                if ($ckManage->type == 'pre') {
                    $data[$lesson->id]['pre_test'] = true;
                    $criteria = new CDbCriteria;
                    $criteria->compare('type', $ckManage->type);
                    $criteria->compare('active', 'y');
                    $criteria->compare('user_id', Yii::app()->user->id);
                    $criteria->compare('lesson_id', $lesson->id);
                    $criteria->compare('gen_id', $gen_id);
                    $ScoreType = Score::model()->findAll($criteria);
                    foreach ($ScoreType as $key => $score) {
                        if ($score->score_past == 'y') {
                            $flagTestPre = true;
                            $data[$lesson->id]['pre_pass'] = $flagTestPre;
                        }
                    }
                }

                if ($ckManage->type == 'post') {
                    $data[$lesson->id]['post_test'] = true;
                    $criteria = new CDbCriteria;
                    $criteria->compare('type', $ckManage->type);
                    $criteria->compare('active', 'y');
                    $criteria->compare('user_id', Yii::app()->user->id);
                    $criteria->compare('lesson_id', $lesson->id);
                    $criteria->compare('gen_id', $gen_id);
                    $ScoreType = Score::model()->findAll($criteria);
                    foreach ($ScoreType as $key => $score) {
                        if ($score->score_past == 'y') {
                            $flagTestPost = true;
                            $data[$lesson->id]['post_pass'] = $flagTestPost;
                        }
                    }
                }
            }
        }

        return $data;
    }


    public function checkLearnAll($lessonList, $status)
    {
        $countLesson = count($lessonList);
        $pass = 0;
        foreach ($lessonList as $key => $value) {
            $lessonStatus = Helpers::lib()->checkLessonPass($value);
            if ($lessonStatus == $status) {
                $pass++;
            }
        }
        if ($pass == $countLesson) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLearnAll_Questionnaire($lessonList, $status)
    {
        $countLesson = count($lessonList);
        $pass = 0;
        foreach ($lessonList as $key => $value) {
            $lessonStatus = Helpers::lib()->checkLessonPassPostest($value);
            if ($lessonStatus == $status) {
                $pass++;
            }
        }
        if ($pass == $countLesson) {
            return true;
        } else {
            return false;
        }
    }

    public function checkProgressStep($course)
    {
        /*
        Notice
            1. need user login
            2. need course model
        */
        $currentId = Yii::app()->user->id;
        $$respon = null;
        if ($course != null or $currentId != null) {
            /* check step 1 */
            $criteria = new CDbCriteria;
            $stepOne = Score::find()->findAll($criteria);
        } else {
            $respon['status'] = 0;
            $respon['message'] = 'ข้อมูลไม่ครบ กรุณาลองใหม่ภายหลัง !';
        }
        return (object)$respon;
    }

    public function checkCourseQues($id, $lessonList)
    {
        $checkLearnAll = Helpers::lib()->checkLearnAll_Questionnaire($lessonList, 'pass');
        if (!$checkLearnAll) {
            return false;
        }
        $course_model = CourseOnline::model()->findByPk($id);
        $gen_id = $course_model->getGenID($course_model->course_id);
        $courseTec = CourseTeacher::model()->findAllByAttributes(array('course_id' => $id));
        $num = 0;
        $countQues = count($courseTec);
        if ($courseTec) {
            foreach ($courseTec as $key => $value) {
                $questAns = QQuestAns_course::model()->find("user_id='" . Yii::app()->user->id . "' AND course_id='" . $value->course_id . "' AND header_id='" . $value->survey_header_id . "' AND teacher_id='" . $value->teacher_id . "' AND gen_id='" . $gen_id . "'");
                if ($questAns) {
                    $num++;
                }
            }
        } else {
            return false;
        }
        if ($num == $countQues) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCourseQuesALl($id)
    {
        $courseTec = CourseTeacher::model()->findAllByAttributes(array('course_id' => $id));
        $course_model = CourseOnline::model()->findByPk($id);
        $gen_id = $course_model->getGenID($course_model->course_id);
        $num = 0;
        $countQues = count($courseTec);
        if ($courseTec) {
            foreach ($courseTec as $key => $value) {
                $questAns = QQuestAns_course::model()->find("user_id='" . Yii::app()->user->id . "' AND course_id='" . $value->course_id . "' AND header_id='" . $value->survey_header_id . "' AND teacher_id='" . $value->teacher_id . "' AND gen_id='" . $gen_id . "'");
                if ($questAns) {
                    $num++;
                }
            }
        } else {
            return false;
        }
        if ($num == $countQues) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCourseQuestion($id)
    {
        $courseTec = CourseTeacher::model()->findAllByAttributes(array('course_id' => $id));
        $course_model = CourseOnline::model()->findByPk($id);
        $gen_id = $course_model->getGenID($course_model->course_id);
        $num = 0;
        $countQues = count($courseTec);
        if ($courseTec) {
            foreach ($courseTec as $key => $value) {
                $questAns = QQuestAns_course::model()->find("user_id='" . Yii::app()->user->id . "' AND course_id='" . $value->course_id . "' AND header_id='" . $value->survey_header_id . "' AND teacher_id='" . $value->teacher_id . "' AND gen_id='" . $gen_id . "'");
                if ($questAns) {
                    $num++;
                }
            }
        } else {
            return true;
        }
        if ($num == $countQues) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLessonQuestion($lesson)
    {
        $lesson_model = Lesson::model()->findByPk($lesson->id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);
        $questAns = QQuestAns::model()->find("user_id='" . Yii::app()->user->id . "' AND lesson_id='" . $lesson->id . "' AND header_id='" . $lesson->header_id . "' AND gen_id='" . $gen_id . "'");
        if ($questAns) {
            return $questAns;
        } else {
            return false;
        }
    }

    public function checkNotificationCourse($model)
    {
        $dateend = $model->end_date;
        $datetime = date("Y-m-d", strtotime($dateend . " -" . $model->notification_time . " days"));
        $date = date("Y-m-d");
        if ($date == $datetime) {
            $time = $model->notification_time;
            return $time;
        } else {
            return false;
        }
    }

    public function emailNotificationCourse($model)
    {
        $dateend = $model->end_date;
        $datetime = date("Y-m-d", strtotime($dateend . " -" . $model->notification_time . " days"));
        $date = date("Y-m-d");
        if ($date == $datetime) {
            $value[0] = $model->course_id;
            $value[1] = $model->notification_time;
            return $value;
        } else {
            return false;
        }
    }

    public function getTimeTest($timeExam, $timeUsage)
    {
        $timeAll = $timeExam * 60;
        $interval = $timeAll - $timeUsage;
        $time = ($interval / 60) == 0 ? 1 : CEIL(($interval / 60));
        return $time;
    }

    public function checkCourseExpire($model)
    {
        $date_start = date("Y-m-d H:i:s", strtotime($model->course_date_start));
        $dateStartStr = strtotime($date_start);
        $date_end = date("Y-m-d H:i:s", strtotime($model->course_date_end));
        $dateEndLearStr = strtotime($date_end);
        $currentDate = strtotime(date("Y-m-d H:i:s"));
        if ($currentDate >= $dateStartStr && $currentDate <= $dateEndLearStr) {
            $stats = true;
        } else {
            $stats = false;
        }
        return $stats;
    }
    public function checkCourseExpireTms($model)
    {
        $date_start = date("Y-m-d", strtotime($model->training_date_start));
        $dateStartStr = strtotime($date_start);
        $date_end = date("Y-m-d", strtotime($model->training_date_end));
        $dateEndLearStr = strtotime($date_end);
        $currentDate = strtotime(date("Y-m-d"));
        if ($currentDate >= $dateStartStr && $currentDate <= $dateEndLearStr) {
            $stats = true;
        } else {
            $stats = false;
        }
        return $stats;
    }

    public function getControllerActionId($parameter = null)
    {
        if (!empty(Yii::app()->controller->action->id)) {
            $model = new LogUsers;
            $model->controller = Yii::app()->controller->id;
            $model->action = Yii::app()->controller->action->id;
            if (!empty($_GET['id'])) {
                $model->parameter = $_GET['id'];
            }
            if ($parameter != null) {
                $model->parameter = $parameter;
            }
            if (Yii::app()->controller->module->id) {
                $model->module = Yii::app()->controller->module->id;
            }
            $model->user_id = Yii::app()->user->id;
            $model->create_date = date('Y-m-d H:i:s');
            $model->save();
        }
    }

    public static function CheckPassLessontest($lesid, $type)
    {
        $lesson_model = Lesson::model()->findByPk($lesid);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $score = Score::model()->findAll(array(
            'condition' => ' lesson_id = "' . $lesid . '"
                AND user_id    = "' . Yii::app()->user->id . '"
                AND type       ="' . $type . '" 
                AND active       = "y"
                AND gen_id = "' . $gen_id . '"
                ',
        ));

        //var_dump($score);


        if ($score) {
            return $score;
        } else {
            return false;
        }
    }

    public function getEndlearncourse($endday)
    {

        $Enddate = date("Y-m-d H:i:s", strtotime("+" . $endday . " day", strtotime(date("Y-m-d H:i:s"))));
        return $Enddate;
    }

    protected function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    public function sendApiLms_old($schedule)
    {
        // $modelSchedule = Schedule::model()->findByAttributes(array('schedule_id' => $schedule_id));
        $member = array();
        foreach ($schedule->auth as $key => $value) {
            $learnStatus = $this->checkCoursePass($value->course_id);
            $member[$key]['username'] = $value->user->username;
            $member[$key]['date'] = "";
            $member[$key]['score'] = 0;
            if ($learnStatus == "pass") {
                $member[$key]['status'] = "P";

                $course_model = CourseOnline::model()->findByPk($value->course_id);
                $gen_id = $course_model->getGenID($course_model->course_id);

                $logStart = LogStartcourse::model()->findByPk(array('user_id' => $value->user->id, 'course_id' => $value->course_id, 'gen_id' => $gen_id));
                $member[$key]['date'] = $logStart->end_date;
                if ($this->checkHaveCourseTestInManage($value->course_id)) {
                    $courseScore = Coursescore::model()->findByAttributes(array('user_id' => $value->user->id, 'course_id' => $value->course_id, 'score_past' => 'y', 'active' => 'y', 'gen_id' => $gen_id, 'type' => "post"));
                    $member[$key]['score'] = $courseScore->score_total;
                }
            } else if ($learnStatus == "notPass") {
                $member[$key]['status'] = "N";
            } else {
                $member[$key]['status'] = "A";
            }
            // P = ผ่าน N = ไม่ผ่าน A = ไม่เข้าเรียน
        }

        if (!empty($member)) {
            $param  = array(
                "schedule_id" => $schedule->schedule_id, //site_list
                "member" => $member, //register_id
                "key" => "09082174-6a9b-45b7-bc8d-090e07bc91b6"
            );
            var_dump(json_encode($param));
            //Destination url
            $url = 'http://red-u.thaiairasia.co.th/tms-test-lms-admin';
            // $url = 'http://localhost:1337/lms_airasia/site/getDataApi'; //LocalHost
            $ch = curl_init(); //เปิดการเชื่่อมต่อ
            curl_setopt($ch, CURLOPT_URL, $url); // เรียกไปที่ url
            curl_setopt($ch, CURLOPT_POST, 1); // ส่งค่าแบบ post 1 ครั้ง
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //     'Content-Type: application/x-www-form-urlencoded'
            // ));
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return = curl_exec($ch); // เก็บค่าที่ส่งกลับมา .. จะประมาณว่า เมสสบอกว่าทำได้หรือไม่ ?
            $model_log = new LogApi;
            $model_log->schedule_id = $schedule->schedule_id;
            $model_log->log_ip = $this->get_client_ip();
            // $model_log->log_event = Yii::app()->controller->action->id;
            $model_log->log_event = "return";
            $model_log->log_data = json_encode($param);
            $model_log->log_date = date("Y-m-d H:i:s");

            if ($return) {
                $data[0] = '1';
                $data[1] = 'ส่ง api สำเร็จ';
                $data[2] = $return;
                // $model_log->send_status = 'success';
            } else {
                $data[0] = '777';
                $data[1] = 'ส่ง api ไม่สำเร็จ';
                $data[2] = $return;
                // $model_log->send_status = 'unsuccess';
            }
            $model_log->save();
            curl_close($ch);
        } else {
            $data[0] = '777';
            $data[1] = 'ไม่พบข้อมูล';
        }
        return json_encode($data);
    }

    public function checlAllLessonLearnPass($course_id, $user_id)
    {

        $course_model = CourseOnline::model()->findByPk($course_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $criteria = new CDbCriteria;
        $criteria->compare('course_id', $course_id);
        $criteria->compare('lesson_active', 'y');
        // $criteria->compare('lesson_status','pass');
        $criteria->compare('user_id', $user_id);
        $criteria->compare('gen_id', $gen_id);
        $learns = Learn::model()->findAll($criteria);
        if ($learns) {
            foreach ($learns as $key => $value) {
                if ($value->lesson_status == 'pass') {
                    $state = 'pass';
                } else {
                    $state = 'notPass';
                }
            }
        } else {
            $state = 'false'; //ยังไม่เข้าเรียน
        }

        return $state;
    }

    public function checlAllLessonPass($course_id, $user_id)
    {

        $state = array();

        $course_model = CourseOnline::model()->findByPk($course_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $criteria = new CDbCriteria;
        $criteria->compare('course_id', $course_id);
        $criteria->compare('active', 'y');
        $criteria->compare('parent_id', 0);
        $lesson = Lesson::model()->findAll($criteria);


        $countFile = 0;
        $id_file = [];
        foreach ($lesson as $key => $val) {
            // var_dump($val->type);
            if ($val->type == 'vdo') {

                // $countFile += $val->fileCount;
                $countFile += $val->GetfileCount($val->id);

                $file = File::model()->findAll(
                    "lesson_id=:id ",
                    array("id" => $val->id)
                );
                foreach ($file as $key => $val_file) {
                    $id_file[] = $val_file->id;
                }
            } else if ($val->type == 'pdf') {
                $countFile += $val->filePdfCount;
                $file_pdf = FilePdf::model()->findAll(
                    "lesson_id=:id ",
                    array("id" => $val->id)
                );
                foreach ($file_pdf as $key => $val_file_pdf) {
                    $id_file[] = $val_file_pdf->id;
                }
            } else if ($val->type == 'scorm') {
                $countFile += $val->fileScormCount;
                $file_scorm = FileScorm::model()->findAll(
                    "lesson_id=:id ",
                    array("id" => $val->id)
                );
                foreach ($file_scorm as $key => $val_file_scorm) {
                    $id_file[] = $val_file_scorm->id;
                }
            } else if ($val->type == 'audio') {
                $countFile += $val->fileAudioCount;
                $file_audio = FileAudio::model()->findAll(
                    "lesson_id=:id ",
                    array("id" => $val->id)
                );
                foreach ($file_audio as $key => $val_file_audio) {
                    $id_file[] = $val_file_audio->id;
                }
            }
        }

        $criteria = new CDbCriteria;
        $criteria->addIncondition('file_id', $id_file);
        $criteria->compare('user_id_file', $user_id);
        $criteria->compare('gen_id', $gen_id);
        // $criteria->compare('learn_file_status','s');
        $learnfiles = LearnFile::model()->findAll($criteria);
        // var_dump(count($learnfiles));
        // var_dump($countFile);

        if ($learnfiles) {
            if (count($learnfiles) == $countFile) {
                foreach ($learnfiles as $key => $value) {
                    if ($value->learn_file_status == 's') {
                        $state[] = 'pass';
                    } else {
                        $state[] = 'notPass';
                    }
                }
            } else {
                $state[] = 'notPass';
            }
        } else {
            $state[] = 'false'; //ยังไม่เข้าเรียน
        }

        if (!empty($state)) {
            if (in_array('notPass', $state)) {
                $result = 'notPass';
            } else if (in_array('false', $state)) {
                $result = 'false';
            } else {
                $result = 'pass';
            }
        } else {
            $result = 'false'; //ยังไม่เข้าเรียน
        }

        $chk_postmanage = array();

        if ($result == 'pass') {
            foreach ($lesson as $key => $val_les) {
                if ($this->checkHavePostTestInManage($val_les->id)) {
                    $courseScore = Score::model()->findByAttributes(array('user_id' => $user_id, 'lesson_id' => $val_les->id, 'score_past' => 'y', 'active' => 'y', 'type' => 'post', 'gen_id' => $gen_id));
                    if ($courseScore) {
                        $chk_postmanage[] = 'pass';
                    } else {
                        $chk_postmanage[] = 'notPass';
                    }
                } else {
                    $chk_postmanage[] = 'pass';
                }
            }

            if (!empty($chk_postmanage)) {
                if (in_array('notPass', $chk_postmanage)) {
                    $result = 'notPass';
                } else if (in_array('pass', $chk_postmanage)) {
                    $result = 'pass';
                }
            }
        }

        return $result;
    }

    public function sendApiLms2($scheduleMain, $scheduleId)
    {
        $member = array();
        foreach ($scheduleMain as $key => $value) {
            $course_model = CourseOnline::model()->findByPk($value->course_id);
            $gen_id = $course_model->getGenID($course_model->course_id);

            $userModel = Users::model()->findByPK($value->user_id);
            if ($userModel) {
                $learnStatus = $this->checlAllLessonPass($value->course_id, $value->user_id);
                $member[$key]['learnStatus'] = $learnStatus;
                $member[$key]['username'] = $userModel->username;
                $member[$key]['date'] = "";
                $member[$key]['score'] = 0;
                if ($learnStatus == "pass") { //learn pass



                    $logStart = LogStartcourse::model()->findByAttributes(array('user_id' => $value->user_id, 'course_id' => $value->course_id, 'active' => 'y', 'gen_id' => $gen_id));
                    $member[$key]['date'] = $logStart->end_date;

                    if ($this->checkHaveCourseTestInManage($value->course_id)) {
                        $courseScore = Coursescore::model()->findByAttributes(array('user_id' => $value->user_id, 'course_id' => $value->course_id, 'score_past' => 'y', 'active' => 'y', 'gen_id' => $gen_id, 'type' => "post"));

                        if ($courseScore) {
                            $member[$key]['status'] = "P";
                            $member[$key]['score'] = $courseScore->score_number . '/' . $courseScore->score_total;
                        } else {
                            $member[$key]['status'] = "N";
                        }
                    }
                } else if ($learnStatus == "notPass") {
                    $criteria = new CDbCriteria;
                    $criteria->compare('course_id', $value->course_id);
                    $criteria->compare('lesson_active', 'y');
                    $criteria->compare('user_id', $value->user_id);
                    $criteria->compare('gen_id', $gen_id);
                    $learns = Learn::model()->findAll($criteria);
                    if ($learns) {
                        $member[$key]['status'] = "N";
                    } else {
                        $member[$key]['status'] = "A";
                    }
                } else {
                    $member[$key]['status'] = "A";
                }
            }
        }
        if (!empty($member)) {
            $param  = array(
                "schedule_id" => $scheduleMain->schedule_id, //site_list
                "member" => $member, //register_id
                "key" => "09082174-6a9b-45b7-bc8d-090e07bc91b6"
            );
            var_dump(json_encode($param));
            // var_dump(($param));
        }
    }


    public function sendApiLms($scheduleMain, $scheduleId)
    {
        // $modelSchedule = Schedule::model()->findByAttributes(array('schedule_id' => $schedule_id));
        $member = array();
        // $criteria = new CDbCriteria;
        // $criteria->compare('schedule_id',$scheduleMain->id,true);
        // $aut = AuthCourse::model()->findAll($criteria);
        // foreach ($aut as $key => $value) {
        foreach ($scheduleMain as $key => $value) {
            $course_model = CourseOnline::model()->findByPk($value->course_id);
            $gen_id = $course_model->getGenID($course_model->course_id);
            // foreach ($scheduleMain->auth as $key => $value) {
            // var_dump($value);
            $userModel = Users::model()->findByPK($value->user_id);
            // var_dump($value->user_id);
            // }exit();

            // foreach ($scheduleMain as $key => $value) {

            if ($userModel) {
                // $learnStatus = $this->checkCoursePass($value->course_id);

                // $learnStatus = $this->checlAllLessonLearnPass($value->course_id,$value->user_id);
                $learnStatus = $this->checlAllLessonPass($value->course_id, $value->user_id);

                $member[$key]['username'] = strtolower($userModel->username);
                // $member[$key]['course_id'] = $value->course_id;
                $member[$key]['date'] = "";
                // $member[$key]['course_id'] = $value->course_id;
                $member[$key]['score'] = 0;

                if ($learnStatus == "pass") { //learn pass



                    $logStart = LogStartcourse::model()->findByAttributes(array('user_id' => $value->user_id, 'course_id' => $value->course_id, 'active' => 'y', 'gen_id' => $gen_id));
                    $member[$key]['date'] = $logStart->end_date;


                    // $passCourse = Passcours::model()->findByPk(array('passcours_user' => $value->user_id,'passcours_cours'=> $value->course_id,'passcours_cates'=> 1));
                    // $member[$key]['date'] = $passCourse->passcours_date;

                    if ($this->checkHaveCourseTestInManage($value->course_id)) {

                        $courseScore = Coursescore::model()->findByAttributes(array('user_id' => $value->user_id, 'course_id' => $value->course_id, 'score_past' => 'y', 'active' => 'y', 'gen_id' => $gen_id, 'type' => "post"));

                        if ($courseScore) {
                            $member[$key]['status'] = "P";
                            $member[$key]['score'] = $courseScore->score_number . '/' . $courseScore->score_total;
                        } else {
                            $member[$key]['status'] = "N";
                        }
                    } else {
                        $member[$key]['status'] = "P";
                    }
                } else if ($learnStatus == "notPass") {
                    $criteria = new CDbCriteria;
                    $criteria->compare('course_id', $value->course_id);
                    $criteria->compare('lesson_active', 'y');
                    $criteria->compare('user_id', $value->user_id);
                    $criteria->compare('gen_id', $gen_id);
                    $learns = Learn::model()->findAll($criteria);
                    if ($learns) {
                        $member[$key]['status'] = "N";
                    } else {
                        $member[$key]['status'] = "A";
                    }
                } else {

                    $member[$key]['status'] = "A";
                }
            }
            // var_dump($learnStatus);
            // echo " // ";
            // var_dump($member[$key]['username']);
            // echo " // ";
            // var_dump($member[$key]['status']);
            // echo "<br>";
        }
        // exit();

        // if(!empty($member)){
        //     $param  = array(
        //             "schedule_id" => $scheduleMain->schedule_id, //site_list
        //             "member"=>$member, //register_id
        //             "key"=>"09082174-6a9b-45b7-bc8d-090e07bc91b6"
        //         );
        //     var_dump(json_encode($param));
        //     // var_dump(($param));
        // }
        // // return $model;
        // return json_encode($param);
        // exit();



        if (!empty($member)) {
            $param  = array(
                // "schedule_id" => $scheduleMain->schedule_id, //site_list
                "schedule_id" => $scheduleId, //site_list
                "member" => $member, //register_id
                "key" => "09082174-6a9b-45b7-bc8d-090e07bc91b6"
            );
            // var_dump(json_encode($param));
            //Destination url

            $url = 'https://red-u.thaiairasia.co.th/training-admin/api/lms/training/result';
            // $url = '';

            // $url = 'http://localhost:1337/lms_airasia/site/getDataApi'; //LocalHost
            $ch = curl_init(); //เปิดการเชื่่อมต่อ
            curl_setopt($ch, CURLOPT_URL, $url); // เรียกไปที่ url
            curl_setopt($ch, CURLOPT_POST, 1); // ส่งค่าแบบ post 1 ครั้ง
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //     'Content-Type: application/x-www-form-urlencoded'
            // ));
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return = curl_exec($ch); // เก็บค่าที่ส่งกลับมา .. จะประมาณว่า เมสสบอกว่าทำได้หรือไม่ ?

            $model_log = new LogApi;
            $model_log->schedule_id = $scheduleId;
            // $model_log->schedule_id = $scheduleMain->schedule_id;
            $model_log->log_ip = $this->get_client_ip();
            // $model_log->log_event = Yii::app()->controller->action->id;
            $model_log->log_event = "return";
            $model_log->log_data = json_encode($param);
            $model_log->log_date = date("Y-m-d H:i:s");

            if ($return) {
                $data[0] = '1';
                $data[1] = 'ส่ง api สำเร็จ';
                $data[2] = $return;

                // $model_log->send_status = 'success';
            } else {

                $data[0] = '777';
                $data[1] = 'ส่ง api ไม่สำเร็จ';
                $data[2] = $return;
                // $model_log->send_status = 'unsuccess';
            }
            $model_log->save();

            curl_close($ch);
        } else {
            $data[0] = '777';
            $data[1] = 'ไม่พบข้อมูล';
        }
        return json_encode($data);
    }

    public function checkDateStartandEnd($user_id = null, $course_id = null)
    {

        $course_model = CourseOnline::model()->findByPk($course_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $logtime = LogStartcourse::model()->find(array(
            'condition' => 'course_id=:course_id AND user_id=:user_id AND active=:active AND gen_id=:gen_id',
            'params' => array(':course_id' => $course_id, ':user_id' => $user_id, ':active' => 'y', ':gen_id' => $gen_id)
        ));

        $passCourse = Passcours::model()->find(array(
            'condition' => 'passcours_cours=:passcours_cours AND passcours_user=:passcours_user AND gen_id=:gen_id',
            'params' => array(':passcours_cours' => $course_id, ':passcours_user' => $user_id, ':gen_id' => $gen_id)
        ));


        $log_startcourse = LogStartcourse::model()->findAll(array(
            'condition' => 'course_id=:course_id AND active=:active AND gen_id=:gen_id',
            'params' => array(':course_id' => $course_id, ':active' => 'y', ':gen_id' => $gen_id)
        ));
        $num_regis = 0;

        if (!empty($log_startcourse)) {
            $num_regis = count($log_startcourse); // จำนวน ที่สมัครไปแล้ว
        }

        if ($gen_id != 0) {
            $gen_person = $course_model->getNumGen($gen_id); // จำนวน สมัครได้ทั้งหมด
        }

        if (empty($logtime) && (($gen_person > $num_regis) || $gen_id == 0)) {
            $logtime = new LogStartcourse;
            $logtime->user_id = Yii::app()->user->id;
            $logtime->course_id = $course_id;
            $logtime->start_date = new CDbExpression('NOW()');
            // $logtime->end_date = new CDbExpression('NOW()');
            $logtime->gen_id = $gen_id;
            $logtime->save();
        } else if (empty($passCourse)) {
            // LogStartcourse::model()->updateByPk($logtime->id, array(
            //     'end_date' => new CDbExpression('NOW()'),

            // ));

        }
    }

    public function PeriodDate($dateStart, $full)
    {
        $date = explode('-', $dateStart);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        $day = explode(' ', $day);
        $days = $day[0];
        switch ($month) {
            case '01':
                $month = 'Jan';
                break;
            case '02':
                $month = 'Feb';
                break;
            case '03':
                $month = 'Mar';
                break;
            case '04':
                $month = 'Apr';
                break;
            case '05':
                $month = 'May';
                break;
            case '06':
                $month = 'Jun';
                break;
            case '07':
                $month = 'Jul';
                break;
            case '08':
                $month = 'Aug';
                break;
            case '09':
                $month = 'Sep';
                break;
            case '10':
                $month = 'Oct';
                break;
            case '11':
                $month = 'Nov';
                break;
            case '12':
                $month = 'Dec';
                break;
            default:
                $month = 'error';
                break;
        }
        if ($full) {
            return $strDate = $days . " " . $month . " " . $year;
        } else {
            return $strDate = $days . " " . $month;
        }
    }

    function DateLang($strDate, $lang_id)
    {
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        if ($lang_id != 1) {
            $strYear = date("Y", strtotime($strDate)) + 543;
            $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        } else {
            $strYear = date("Y", strtotime($strDate));
            $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
        }

        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    }

    function DateLangTms($strDate, $lang_id)
    {

        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));

        if ($lang_id != 1) {
            $strYear = date("Y", strtotime($strDate)) + 543;
            $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        } else {
            $strYear = date("Y", strtotime($strDate));
            $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
        }

        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    function CuttimeLang($strDate, $lang_id)
    {
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        if ($lang_id != 1) {
            $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strYear += 543;
        } else {
            $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
        }

        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay / $strMonthThai / $strYear";
    }

    function CuttimeLang2($strDate, $lang_id)
    {
        $strYear = date("Y", strtotime($strDate));
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        if ($lang_id != 1) {
            $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strYear += 543;
        } else {
            $strMonthCut = array("", "Jan.", "Feb.", "Mar.", "Apr.", "May.", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
        }

        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    function CoursePermission($user_id, $course_id)
    {
        //Check Permission
        if ($user_id != null) {

            $userModel = Users::model()->findByPK($user_id);
            $course = CourseOnline::model()->findByPk($course_id);
            if ($course->cate_id == '1') {
                $criteria = new CDbCriteria;
                $criteria->compare('course_id', $course_id);
                $criteria->compare('user_id', Yii::app()->user->id);
                $modelCourseTms = AuthCourse::model()->findAll($criteria);
                $ckPermission = !empty($modelCourseTms) ? true : false;
            } else {
                $userDepartment = $userModel->department_id;

                $criteria = new CDbCriteria;
                $criteria->with = array('orgchart');
                $criteria->compare('depart_id', $userDepartment);
                $criteria->compare('orgchart.active', 'y');
                $criteria->compare('t.active', 'y');
                $criteria->group = 'orgchart_id';
                $modelOrgDep = OrgDepart::model()->findAll($criteria);

                foreach ($modelOrgDep as $key => $value) {
                    $courseArr[] = $value->orgchart_id;
                }

                $criteria = new CDbCriteria;
                $criteria->with = array('course', 'course.CategoryTitle');
                $criteria->addIncondition('orgchart_id', $courseArr);
                $criteria->group = 'course.course_id';
                $criteria->compare('course.active', 'y');
                $criteria->compare('categorys.cate_show', '1');
                $criteria->compare('categorys.cate_show', '1');
                // $criteria->compare('course.lang_id',$langId);
                $model = OrgCourse::model()->findAll($criteria);

                $ckPermission = false;
                foreach ($model as $key => $course_ck) {
                    $course_ck = $course_ck->course;
                    if ($course_ck->course_id == $course_id) {
                        $ckPermission = true;
                    }
                }
            }
            return $ckPermission;
        }
    }

    public function ldapTms($email)
    {
        $ldap_host = '172.30.110.111';
        $ldap_username = 'taaldap@aagroup.redicons.local';
        $ldap_password = 'Th@i@ir@sia320';
        $dn = "OU=TAA,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
        $dn1 = "OU=TAX,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
        $ldap = ldap_connect($ldap_host);
        $bd = ldap_bind($ldap, $ldap_username, $ldap_password) or die("Could not bind");
        $attrs = array("sn", "displayname", "samaccountname", "mail", "pwdLastSet", "division", "department", "st", "description");
        $filter = "(mail=" . $email . ")";
        $search = ldap_search($ldap, $dn, $filter, $attrs) or die("ldap search failed");
        $search1 = ldap_search($ldap, $dn1, $filter, $attrs) or die("ldap search failed");
        return ldap_get_entries($ldap, $search)['count'] > 0 ? ldap_get_entries($ldap, $search) : ldap_get_entries($ldap, $search1);
    }

    public static function isMultipleChoice($lesson, $type, $quesType = null)
    {
        if (!empty($quesType)) {
            $manage = Manage::Model()->with('question')->findAll(
                "id=:id AND type=:type AND question.ques_type=:quesType AND manage.active='y'",
                array("id" => $lesson->id, "type" => $type, "quesType" => $quesType)
            );
        } else {
            $manage = Manage::Model()->with('question')->findAll(
                "id=:id AND type=:type AND question.ques_type<>3 AND manage.active='y'",
                array("id" => $lesson->id, "type" => $type)
            );
        }

        return !empty($manage);
    }

    public static function isTestState($lesson_id, $type, $quesType)
    {
        $lesson_model = Lesson::model()->findByPk($lesson_id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $lesson = Lesson::model()->findByPk($lesson_id);
        if (!$lesson) {
            return false;
        }

        if (!self::isMultipleChoice($lesson, $type, $quesType)) {
            return false;
        }
        if ($quesType != '3') {
            $haveScore = Score::Model()->findAll(
                "lesson_id=:lesson_id AND type=:type AND ques_type <> 3 AND user_id=:user_id AND active='y' AND gen_id=:gen_id",
                array("lesson_id" => $lesson_id, "type" => $type, "user_id" => Yii::app()->user->id, ':gen_id' => $gen_id)
            );
        } else {
            $haveScore = Score::model()->findAllByAttributes(array('lesson_id' => $lesson_id, 'ques_type' => '3', 'type' =>  $type, 'user_id' => Yii::app()->user->id, 'active' => 'y', 'gen_id' => $gen_id));
        }
        if (count($haveScore) < $lesson->cate_amount) {
            return true;
        }

        return false;
    }

    public static function isCheckTestState($lesson_id, $type, $quesType)
    {
        $lesson_model = Lesson::model()->findByPk($lesson_id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $lesson = Lesson::model()->findByPk($lesson_id);
        if (!$lesson) {
            return false;
        }

        if (!self::isMultipleChoice($lesson, $type, $quesType)) {
            return false;
        }
        if ($quesType != '3') {
            $haveScore = Score::Model()->findAll(
                "lesson_id=:lesson_id AND type=:type AND ques_type <> 3 AND user_id=:user_id AND active='y' AND confirm='0' AND gen_id=:gen_id",
                array("lesson_id" => $lesson_id, "type" => $type, "user_id" => Yii::app()->user->id, ':gen_id' => $gen_id)
            );
        } else {
            $haveScore = Score::model()->findAllByAttributes(array('lesson_id' => $lesson_id, 'ques_type' => '3', 'type' =>  $type, 'user_id' => Yii::app()->user->id, 'active' => 'y', 'confirm' => '0', 'gen_id' => $gen_id));
        }
        if ($haveScore) {
            return true;
        }

        return false;
    }

    public function CheckTest_lerm($lesson, $type, $score, $quesType = null)
    {
        if ($lesson) {
            $data = "";
            if ($type == "post") {
                if ($quesType == '3') {
                    $logQues = Logques::model()->findByAttributes(array('score_id' => $score->score_id));
                    if ($logQues) {
                        if ($logQues->check == 0 || $logQues->confirm == 0) {
                            $data = array('value' => array('percent' => 0));
                            $data['option']['color'] = "#D9534F";
                            $data['value']['text'] = "รอตรวจ";
                            $data['value']['boolean'] = false;
                        } else  if ($logQues->check == 1) {
                            $criteria = new CDbCriteria;
                            $criteria->select = '*,MAX(score_number) as score_number';
                            $criteria->condition = ' type = "' . $type . '" AND lesson_id="' . $lesson->id . '" AND ques_type="3" AND user_id="' . Yii::app()->user->id . '" and active = "y"';
                            $criteria->order = 'score_number ASC';
                            // $score = Score::model()->find($criteria);
                            $data = array('value' => array('percent' => 0));
                            $data['value']['score'] = $score->score_number;
                            $data['value']['total'] = $score->score_total;
                            if ($logQues->scores->score_past == "y") {
                                $data['option']['color'] = "#0C9C14";
                                $data['value']['status'] = "(ผ่าน)";
                                $data['value']['statusBoolean'] = true;
                            } else {
                                $data['option']['color'] = "#D9534F";
                                $data['value']['status'] = "(ไม่ผ่าน)";
                                $data['value']['statusBoolean'] = false;
                            }
                            $data['value']['boolean'] = false;
                        }
                    }
                } else {
                    // $criteria = new CDbCriteria;
                    // $criteria->select = '*,MAX(score_number) as score_number';
                    // $criteria->condition = ' type = "'.$type.'" AND lesson_id="' . $lesson->id . '" AND ques_type <> 3 AND user_id="' . Yii::app()->user->id . '" and active = "y"';
                    // $criteria->order = 'score_number ASC';
                    // $score = Score::model()->find($criteria);
                    if ($score->score_past != null) {
                        $percent = number_format(($score->score_number / $score->score_total) * 100, 0);
                        if ($score->score_past == "y") {
                            //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                            $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                            $data['option']['color'] = "#0C9C14";
                            $data['value']['status'] = " (ผ่าน)";
                            $data['value']['statusBoolean'] = true;
                            $data['value']['score'] = $score->score_number;
                            $data['value']['total'] = $score->score_total;
                        } else {
                            //                        $data['value']['text'] = "ทั้งหมด ".$score->score_total." ข้อ ถูก " . $score->score_number ." ข้อ";
                            $data = array('value' => array('text' => "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ"));
                            $data['option']['color'] = "#D9534F";
                            $data['value']['statusBoolean'] = false;
                            $data['value']['status'] = " (ไม่ผ่าน)";
                            $data['value']['score'] = $score->score_number;
                            $data['value']['total'] = $score->score_total;
                        }
                        $data['value']['percent'] = $percent;
                        $data['value']['boolean'] = true;
                    } else {
                        $checkPostTest = Helpers::checkHavePostTestInManage($lesson->id);
                        if ($checkPostTest) {
                            //                        $data['value']['percent'] = 0;
                            $data = array('value' => array('percent' => 0));
                            $data['option']['color'] = "#D9534F";
                            $data['value']['text'] = "ยังไม่ทำแบบทดสอบหลังเรียน";
                            $data['value']['boolean'] = false;
                        } else {
                            //                        $data['value']['percent'] = 0;
                            $data = array('value' => array('percent' => 0));
                            $data['option']['color'] = "#D9534F";
                            $data['value']['text'] = "ไม่มีแบบทดสอบหลังเรียน";
                            $data['value']['boolean'] = false;
                        }
                    }
                }
            } elseif ($type == "pre") {
                if ($quesType == '3') {
                    $logQues = Logques::model()->findByAttributes(array('score_id' => $score->score_id));
                    if ($logQues) {
                        if ($logQues->check == 0 || $logQues->confirm == 0) {
                            $data = array('value' => array('percent' => 0));
                            $data['option']['color'] = "#D9534F";
                            $data['value']['text'] = "รอตรวจ";
                            $data['value']['boolean'] = false;
                        } else  if ($logQues->check == 1) {
                            $criteria = new CDbCriteria;
                            $criteria->select = '*,MAX(score_number) as score_number';
                            $criteria->condition = ' type = "' . $type . '" AND lesson_id="' . $lesson->id . '" AND ques_type="3" AND user_id="' . Yii::app()->user->id . '" and active = "y"';
                            $criteria->order = 'score_number ASC';
                            // $score = Score::model()->find($criteria);
                            $data = array('value' => array('percent' => 0));
                            $data['value']['score'] = $score->score_number;
                            $data['value']['total'] = $score->score_total;
                            if ($logQues->scores->score_past == "y") {
                                $data['option']['color'] = "#0C9C14";
                                $data['value']['status'] = "(ผ่าน)";
                                $data['value']['statusBoolean'] = true;
                            } else {
                                $data['option']['color'] = "#D9534F";
                                $data['value']['status'] = "(ไม่ผ่าน)";
                                $data['value']['statusBoolean'] = false;
                            }
                            $data['value']['boolean'] = false;
                        }
                    }
                } else {
                    // $criteria = new CDbCriteria;
                    // $criteria->select = '*,MAX(score_number) as score_number';
                    // $criteria->condition = ' type = "'.$type.'" AND lesson_id="' . $lesson->id . '" AND ques_type <> 3 AND user_id="' . Yii::app()->user->id . '" and active ="y"';
                    // $score = Score::model()->find($criteria);
                    if ($score->score_past != null) {
                        //                    $data['value']['percent'] = number_format(($score->score_number/$score->score_total)*100,0);
                        $data = array('value' => array('percent' => number_format(($score->score_number / $score->score_total) * 100, 0)));
                        $data['value']['boolean'] = true;
                        $data['value']['text'] = "ทั้งหมด " . $score->score_total . " ข้อ ถูก " . $score->score_number . " ข้อ";
                        $data['value']['score'] = $score->score_number;
                        $data['value']['total'] = $score->score_total;
                        if ($score->score_past == "n") {
                            $data['option']['color'] = "#D9534F";
                            $data['value']['status'] = "(ไม่ผ่าน)";
                            $data['value']['statusBoolean'] = false;
                        } else {
                            $data['option']['color'] = "#0C9C14";
                            $data['value']['status'] = "(ผ่าน)";
                            $data['value']['statusBoolean'] = true;
                        }
                    } else {
                        $checkPreTest = Helpers::checkHavePreTestInManage($lesson->id);
                        if ($checkPreTest) {
                            //                        $data['value']['percent'] = 0;
                            $data = array('value' => array('percent' => 0));
                            $data['option']['color'] = "#D9534F";
                            $data['value']['text'] = "ยังไม่ทำแบบทดสอบก่อนเรียน";
                            $data['value']['boolean'] = false;
                        } else {
                            //                        $data['value']['percent'] = 0;
                            $data = array('value' => array('percent' => 0));
                            $data['option']['color'] = "#D9534F";
                            $data['value']['text'] = "ไม่มีแบบทดสอบก่อนเรียน";
                            $data['value']['boolean'] = false;
                        }
                    }
                }
            }
            return (object)$data;
        }
    }


    public static function isPosttestStatusPass($lesson_id)
    {
        $lesson_model = Lesson::model()->findByPk($lesson_id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $passPostTest = Score::model()->findAllByAttributes(array('lesson_id' => $lesson_id, 'user_id' => Yii::app()->user->id, 'active' => 'y', 'score_past' => 'y', 'type' => 'post', 'gen_id' => $gen_id));

        if ($passPostTest) {
            return true;
        } else {
            return false;
        }
    }



    public static function ChkAllPostTestLesson($lessonList)
    {
        $pass = false;
        foreach ($lessonList as $key => $value) {
            $havetest = Helpers::lib()->checkHavePostTestInManage($value->id);
            if ($havetest) {
                $passtest = Helpers::lib()->isPosttestStatusPass($value->id);


                if ($passtest) {
                    $pass = true;
                } else {
                    return false;
                }
            } else {
                $pass = true;
            }
        }
        return $pass;
    }

    public function listDataLdap($email)
    {
        $member = $this->ldapTms($email);
        $str = "";
        $str .= 'st: ' . $member[0]['st'][0];
        $str .= 'displayname: ' . $member[0]['displayname'][0];
        $str .= 'department: ' . $member[0]['department'][0];
        $str .= 'pwdlastset: ' . $member[0]['pwdlastset'][0];
        $str .= 'samaccountname: ' . $member[0]['samaccountname'][0];
        $str .= 'division: ' . $member[0]['division'][0];
        $str .= 'mail: ' . $member[0]['mail'][0];
        $str .= "dn: " . $member[0]['dn'];
        $str .= "description: " . $member[0]['description'];
        // var_dump($str);
        if ($member[0]['description']['count'] > 0) {
            $modelUser = User::model()->findByAttributes(array('email' => $email));
            $modelUser->pic_cardid2 = $member[0]['description'][0]; //Employee id
            $modelUser->save(false);
            var_dump($modelUser);
        }
        exit();
    }

    public function seachUser($email)
    {
        $member = $this->ldapTms($email);
        if ($member['count'] > 0) {
            $this->_insertLdap($member);
            $modelUser = Users::model()->findByAttributes(array('email' => $email));
            if (empty($modelUser)) {
                $modelUser = new User;
                $modelProfile = new Profile;
                $modelUser->username = $member[0]['samaccountname'][0];
                $modelDep = Department::model()->findByAttributes(array('dep_title' => $member[0]['department'][0]));
                $modelUser->department_id = $modelDep->id;
                $modelSt = Station::model()->findByAttributes(array('station_title' => $member[0]['st'][0]));
                $modelUser->station_id = $modelSt->station_id;
                //Division 
                $modelDivision = Division::model()->findByAttributes(array('div_title' => $member[0]['division'][0]));
                $modelUser->division_id = $modelDivision->id;

                $modelUser->email = $email;
                $modelUser->status = '1';
                $modelUser->password = md5($email);
                $modelUser->type_register = 3;
                //admin
                //   $division_title = strtolower($member[0]['division'][0]);
                //   if($division_title == "security" || $division_title == "ramp"){
                //     $modelUser->group = '["7","1"]';
                // }
                if ($modelUser->save(false)) {
                    $modelProfile->user_id = $modelUser->id;
                } else {
                    $response['result'] = false;
                }
                $name = explode(" ", $member[0]['displayname'][0]);
                $modelProfile->firstname = $name[0];
                $modelProfile->lastname = $name[1];
                if (!$modelProfile->save(false)) {
                    $response['result'] = false;
                }
            } else {
                $modelUser->username = $member[0]['samaccountname'][0];
                $modelDep = Department::model()->findByAttributes(array('dep_title' => $member[0]['department'][0]));
                $modelUser->department_id = $modelDep->id;
                $modelSt = Station::model()->findByAttributes(array('station_title' => $member[0]['st'][0]));
                $modelUser->station_id = $modelSt->station_id;
                //Division 
                $modelDivision = Division::model()->findByAttributes(array('div_title' => $member[0]['division'][0]));
                $modelUser->division_id = $modelDivision->id;

                //admin
                //    $division_title = strtolower($member[0]['division'][0]);
                //    if($division_title == "security" || $division_title == "ramp"){
                //     $modelUser->group = '["7","1"]';
                // }
                $modelUser->save(false);
            }
        }
        return $modelUser->id;
    }

    public function CheckPostTest($course_id, $user_id)
    {
        $data = array();

        $course_model = CourseOnline::model()->findByPk($course_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $criteria = new CDbCriteria;
        $criteria->compare('active', "y");
        $criteria->compare('course_id', $course_id);
        $criteria->compare('lang_id', 1);
        $lesson = Lesson::model()->findAll($criteria);
        foreach ($lesson as $key => $value) {

            $manage1 = Manage::Model()->with('question')->findAll(
                "id=:id AND type=:type AND question.ques_type<>3 AND manage.active='y'",
                array("id" => $value->id, "type" => 'post')
            );

            $manage2 = Manage::Model()->with('question')->findAll(
                "id=:id AND type=:type AND question.ques_type=:quesType AND manage.active='y'",
                array("id" => $value->id, "type" => 'post', "quesType" => 3)
            );

            if ($manage1) {
                $criteria = new CDbCriteria;
                $criteria->condition = "ques_type <> :ques_type";
                $criteria->params = array(
                    ':ques_type' => 3,
                );
                $criteria->compare('user_id', $user_id);
                $criteria->compare('gen_id', $gen_id);
                $criteria->compare('active', "y");
                $criteria->compare('lesson_id', $value->id);
                $criteria->compare('type', "post");
                $score1 = Score::model()->findAll($criteria);
                $count_score = count($score1);
            }

            if ($manage2) {
                $criteria = new CDbCriteria;
                $criteria->compare('user_id', $user_id);
                $criteria->compare('gen_id', $gen_id);
                $criteria->compare('ques_type', 3);
                $criteria->compare('active', "y");
                $criteria->compare('lesson_id', $value->id);
                $criteria->compare('type', "post");
                $score2 = Score::model()->findAll($criteria);
                $count_score_lecture = count($score2);
            }

            if ($manage1 && $manage2) {
                if (($count_score + $count_score_lecture) / 2 < $lesson->cate_amount) {
                    $data[$value->id]['flagBoth'] = false;
                } else {
                    $data[$value->id]['flagBoth'] = true;
                }
            } else {
                if ($manage1) {
                    if ($count_score < $lesson->cate_amount) {
                        $data[$value->id]['flag'] = false;
                    } else {
                        $data[$value->id]['flag'] = true;
                    }
                }
                if ($manage2) {
                    if ($count_score_lecture < $lesson->cate_amount) {
                        $data[$value->id]['flagLecture'] = false;
                    } else {
                        $data[$value->id]['flagLecture'] = true;
                    }
                }
            }
        }
        return $data;
    }

    // public function CheckPostTestAll($lesson,$user_id){
    //     // $data = array();

    //     $manage = Manage::Model()->with('question')->findAll("id=:id AND type=:type AND question.ques_type<>3 AND manage.active='y'",
    //             array("id" => $lesson->id,"type" => 'post'));

    //     if($manage){
    //         $criteria=new CDbCriteria;
    //         $criteria->condition = "ques_type <> :ques_type";
    //         $criteria->params = array (
    //         ':ques_type' => 3,
    //         );
    //         $criteria->compare('user_id',$user_id);
    //         $criteria->compare('active',"y");
    //         $criteria->compare('lesson_id',$lesson->id);
    //         $criteria->compare('type',"post");
    //         $score1 = Score::model()->findAll($criteria);
    //         $count_score = count($score1);
    //     }
    //     if($manage){
    //         $scorePass = array();
    //         foreach ($score1 as $key => $value) {
    //              if($count_score < $lesson->cate_amount){
    //                     if( $value->score_past == "y"){
    //                         // $data['flag'] = true;
    //                         $data  = true;
    //                     }else{
    //                         $data  = false;
    //                     }
    //                 }else{
    //                     $data = true;
    //                 }
    //         }
    //     }

    //     return $data;
    // }

    public function CheckPostTestAll($lesson, $gen = 0)
    {
        $lesson_model = Lesson::model()->findByPk($lesson->id);
        $gen_id = $gen != 0 ? $gen : $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $manage = Manage::Model()->with('question')->findAll(
            "id=:id AND type=:type AND question.ques_type<>3 AND manage.active='y'",
            array("id" => $lesson->id, "type" => 'post')
        );
        if ($manage) {
            $criteria = new CDbCriteria;
            $criteria->condition = "ques_type <> :ques_type";
            $criteria->params = array(
                ':ques_type' => 3,
            );
            $criteria->compare('user_id', Yii::app()->user->id);
            $criteria->compare('active', "y");
            $criteria->compare('lesson_id', $lesson->id);
            $criteria->compare('gen_id', $gen_id);
            $criteria->compare('type', "post");
            $score1 = Score::model()->findAll($criteria);
            $count_score = count($score1);
        }
        if ($manage) {
            if ($count_score > 0) {
                $scorePass = array();
                foreach ($score1 as $key => $value) {
                    $scorePass[] = $value->score_past;
                }
            } else {
                return false;
            }
        }

        if (in_array("y", $scorePass)) {
            return true;
        } else {
            if ($count_score < $lesson->cate_amount) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function CheckPostTestAllMsTeams($lesson)
    {
        $lesson_model = LessonMsTeams::model()->findByPk($lesson->id);
        $gen_id = 0;

        $manage = ManageMsTeams::Model()->with('question')->findAll(
            "id=:id AND type=:type AND question.ques_type<>3 AND manage.active='y'",
            array("id" => $lesson->id, "type" => 'post')
        );
        if ($manage) {
            $criteria = new CDbCriteria;
            $criteria->condition = "ques_type <> :ques_type";
            $criteria->params = array(
                ':ques_type' => 3,
            );
            $criteria->compare('user_id', Yii::app()->user->id);
            $criteria->compare('active', "y");
            $criteria->compare('lesson_teams_id', $lesson->id);
            $criteria->compare('gen_id', $gen_id);
            $criteria->compare('type', "post");
            $score1 = ScoreMsTeams::model()->findAll($criteria);
            $count_score = count($score1);
        }
        if ($manage) {
            if ($count_score > 0) {
                $scorePass = array();
                foreach ($score1 as $key => $value) {
                    $scorePass[] = $value->score_past;
                }
            } else {
                return false;
            }
        }

        if (in_array("y", $scorePass)) {
            return true;
        } else {
            if ($count_score < $lesson->cate_amount) {
                return true;
            } else {
                return false;
            }
        }
    }


    public function CheckPostTestAllOnline($lesson)
    {
        $lesson_model = LessonOnline::model()->findByPk($lesson->id);
        $gen_id = 0;

        $manage = ManageOnline::Model()->with('question')->findAll(
            "id=:id AND type=:type AND question.ques_type<>3 AND manage.active='y'",
            array("id" => $lesson->id, "type" => 'post')
        );
        if ($manage) {
            $criteria = new CDbCriteria;
            $criteria->condition = "ques_type <> :ques_type";
            $criteria->params = array(
                ':ques_type' => 3,
            );
            $criteria->compare('user_id', Yii::app()->user->id);
            $criteria->compare('active', "y");
            $criteria->compare('lesson_teams_id', $lesson->id);
            $criteria->compare('gen_id', $gen_id);
            $criteria->compare('type', "post");
            $score1 = ScoreOnline::model()->findAll($criteria);
            $count_score = count($score1);
        }
        if ($manage) {
            if ($count_score > 0) {
                $scorePass = array();
                foreach ($score1 as $key => $value) {
                    $scorePass[] = $value->score_past;
                }
            } else {
                return false;
            }
        }

        if (in_array("y", $scorePass)) {
            return true;
        } else {
            if ($count_score < $lesson->cate_amount) {
                return true;
            } else {
                return false;
            }
        }
    }


    public function _updateUser($email)
    {
        $member = $this->ldapTms($email);
        if ($member['count'] > 0) {
            $this->_insertLdap($member);
            $modelUserLogin = new UserLoginLms;
            $modelUser = Users::model()->findByAttributes(array('email' => $email));
            if (empty($modelUser)) {
                $modelUser = new User;
                $modelProfile = new Profile;
                $modelUser->username = $member[0]['samaccountname'][0];
                $modelDep = Department::model()->findByAttributes(array('dep_title' => $member[0]['department'][0]));
                $modelUser->department_id = $modelDep->id;
                $modelSt = Station::model()->findByAttributes(array('station_title' => $member[0]['st'][0]));
                $modelUser->station_id = $modelSt->station_id;
                //Division 
                $modelDivision = Division::model()->findByAttributes(array('div_title' => $member[0]['division'][0]));
                $modelUser->division_id = $modelDivision->id;

                $modelUser->email = $email;
                $modelUser->status = '1';
                $modelUser->password = md5($email);
                $modelUser->type_register = 3;
                //admin
                $division_title = strtolower($member[0]['division'][0]);
                if ($division_title == "security" || $division_title == "ramp") {
                    $modelUser->group = '["7","1"]';
                }
                if ($modelUser->save(false)) {
                    $modelProfile->user_id = $modelUser->id;
                } else {
                    $response['result'] = false;
                }
                $name = explode(" ", $member[0]['displayname'][0]);
                $modelProfile->firstname = $name[0];
                $modelProfile->lastname = $name[1];
                if (!$modelProfile->save(false)) {
                    $response['result'] = false;
                }
            } else {
                $modelUser->username = $member[0]['samaccountname'][0];
                $modelDep = Department::model()->findByAttributes(array('dep_title' => $member[0]['department'][0]));
                $modelUser->department_id = $modelDep->id;
                $modelSt = Station::model()->findByAttributes(array('station_title' => $member[0]['st'][0]));
                $modelUser->station_id = $modelSt->station_id;
                //Division 
                $modelDivision = Division::model()->findByAttributes(array('div_title' => $member[0]['division'][0]));
                $modelUser->division_id = $modelDivision->id;

                //admin
                $division_title = strtolower($member[0]['division'][0]);
                if ($division_title == "security" || $division_title == "ramp") {
                    $modelUser->group = '["7","1"]';
                }
                $modelUser->save(false);
            }
        }
    }

    public function _insertLdap($member)
    {
        if (!empty($member[0]['st'][0])) {
            $modelStation = Station::model()->findByAttributes(array('station_title' => strtolower($member[0]['st'][0])));
            if (!$modelStation) {
                $modelStation = new Station;
                $modelStation->station_title = $member[0]['st'][0];
                $modelStation->lang_id = 1;
                $modelStation->active = 'y';
                $modelStation->parent_id = 0;
                $modelStation->save();
            }
        }

        if (!empty($member[0]['department'][0])) {
            $modelDepartment = Department::model()->findByAttributes(array('dep_title' => strtolower($member[0]['department'][0])));
            if (!$modelDepartment) {
                $modelDepartment = new Department;
                $modelDepartment->dep_title = $member[0]['department'][0];
                $modelDepartment->active = 'y';
                $modelDepartment->lang_id = 1;
                $modelDepartment->parent_id = 0;
                $modelDepartment->save();
            }
        }

        if (!empty($member[0]['division'][0])) {
            $modelDivision = Division::model()->findByAttributes(array('div_title' => strtolower($member[0]['division'][0])));
            if (!$modelDivision) {
                $modelDivision = new Division;
                $modelDivision->div_title = $member[0]['division'][0];
                $modelDivision->active = 'y';
                $modelDivision->lang_id = 1;
                $modelDivision->parent_id = 0;
                $modelDivision->save();
            }
        }
    }

    public static function isPretestStatusPass($lesson_id)
    {
        $passPreTest = Score::model()->findAllByAttributes(array('lesson_id' => $lesson_id, 'user_id' => Yii::app()->user->id, 'active' => 'y', 'type' => 'pre'));
        if ($passPreTest) {
            return true;
        } else {
            return false;
        }
    }

    public function Checkparentlesson($les_id, $gen_id = null)
    {
        $stats = true;
        $status_pre = true;
        $status_post = true;
        if ($les_id != 0) {

            if ($gen_id == null) {
                $lesson_model = Lesson::model()->findByPk($les_id);
                $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);
            }
            $lesson = Lesson::model()->findAllByAttributes(array('id' => $les_id, 'active' => 'y'));

            if ($lesson[0]->sequence_id != 0) {

                $chk_learn_pass = learn::model()->findByAttributes(array(
                    'lesson_id' => $lesson[0]->sequence_id,
                    'lesson_active' => 'y',
                    'user_id' => Yii::app()->user->id, 'gen_id' => $gen_id
                ));

                if ($chk_learn_pass != null) {

                    $learn_file_cou = LearnFile::model()->count(array(
                        'condition' => 'user_id_file=:user_id AND learn_id=:learn_id AND gen_id=:gen_id',
                        'params' => array(':user_id' => Yii::app()->user->id, ':learn_id' => $chk_learn_pass->learn_id, ':gen_id' => $gen_id),
                    ));

                    $learn_file_pass = LearnFile::model()->count(array(
                        'condition' => 'user_id_file=:user_id AND learn_id=:learn_id AND gen_id=:gen_id AND learn_file_status=:status',
                        'params' => array(':user_id' => Yii::app()->user->id, ':learn_id' => $chk_learn_pass->learn_id, ':gen_id' => $gen_id, ':status' => 's'),
                    ));

                    if ($learn_file_cou <= $learn_file_pass) {

                        $chk_learn_pass->lesson_status = 'pass';
                        $chk_learn_pass->save(false);
                    }
                }



                $model = learn::model()->findAllByAttributes(array(
                    'lesson_id' => $lesson[0]->sequence_id,
                    'lesson_active' => 'y',
                    'user_id' => Yii::app()->user->id, 'gen_id' => $gen_id
                ));


                if (empty($model)) {
                    $stats = false;
                } elseif ($model[0]->lesson_status != 'pass' && $model[0]->lesson_status != 'passtest') {
                    $stats = false;
                }

                $checkPreTest = Helpers::checkHavePreTestInManage($lesson[0]->sequence_id);

                if ($checkPreTest) {
                    $status_pre = Helpers::isPretestStatusPass($lesson[0]->sequence_id);
                }

                $checkPostTest = Helpers::checkHavePostTestInManage($lesson[0]->sequence_id);

                if ($checkPostTest) {
                    $status_post = Helpers::isPosttestStatusPass($lesson[0]->sequence_id);
                }
            }
        }
        //var_dump($lesson[0]->parent_id); var_dump($stats); echo "string"; var_dump($status_pre); echo "string"; var_dump($status_post);
        if ($stats && $status_pre && $status_post) {
            return true;
        } else {
            return false;
        }
    }

    public function checkStepLesson($lesson)
    {
        // 1 = สอบก่อนเรียน
        // 2 = กำลังเรียน
        // 3 = สอบหลังเรียน
        // 4 = สอบหลกสูตร
        // 5 = ตอบแบบสอบถาม
        $step;
        //Check Pre test

        $lesson_model = Lesson::model()->findByPk($lesson->id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $checkPreTest = self::checkHavePreTestInManage($lesson->id);
        if ($checkPreTest) { //Have pre test
            $isPreTest = self::isPretestState($lesson->id); //true คือยังไม่ได้สอบ
            if ($isPreTest) {
                $step =  1;
            } else {
                $criteria = new CDbCriteria;
                $criteria->compare('type', 'pre');
                $criteria->compare('active', 'y');
                $criteria->compare('user_id', Yii::app()->user->id);
                $criteria->compare('lesson_id', $lesson->id);
                $criteria->compare('gen_id', $gen_id);
                $scorePre = Score::model()->findAll($criteria);

                foreach ($scorePre as $key => $value) {
                    if ($value->score_past == 'y') {
                        $step = 2;
                    } else { //ไม่ผ่านและยังมีสิทธสอบได้อยู่
                        // $step = 1;
                        $step = 2;
                    }
                }
                if (count($scorePre) == $lesson->cate_amount) {
                    $step = 2;
                }
            }
        } else {
            $step = 2;
        }

        //Check Learn (Step 2)
        if ($step == 2) {
            if ($lesson->type == 'vdo') {
                $file = $lesson->files;
            } else if ($lesson->type == 'pdf') {
                $file = $lesson->filePdf;
            } else if ($lesson->type == 'audio') {
                $file = $lesson->fileAudio;
            } else if ($lesson->type == 'scorm') {
                $file = $lesson->fileScorm;
            }

            foreach ($file as $les) {
                $course_model = CourseOnline::model()->findByPk($lesson->course_id);
                $gen_id = $course_model->getGenID($course_model->course_id);

                $learnModel = Learn::model()->find(array(
                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':user_id' => Yii::app()->user->id, ':status' => 'y', ':gen_id' => $gen_id)
                ));
                $learnFiles = self::lib()->checkLessonFile($les, $learnModel->learn_id); //notLearn,learning,pass
                if ($learnFiles == "notLearn") {
                    $step = 2;
                } else if ($learnFiles == "learning") {
                    $step = 2;
                } else if ($learnFiles == "pass") {
                    $step = 3;
                }
            }
        }
        //Check post test (Step 3)
        if ($step == 3) {
            $checkPostTest = self::checkHavePostTestInManage($lesson->id); //true คือมีข้อสอบหลังเรียน
            if ($checkPostTest) {
                $criteria = new CDbCriteria;
                $criteria->compare('type', 'post');
                $criteria->compare('active', 'y');
                $criteria->compare('user_id', Yii::app()->user->id);
                $criteria->compare('lesson_id', $lesson->id);
                $criteria->compare('gen_id', $gen_id);
                $scorePost = Score::model()->findAll($criteria);

                foreach ($scorePost as $key => $value) {
                    if ($value->score_past == 'y') {
                        $step = 4;
                    } else { //ไม่ผ่านและยังมีสิทธสอบได้อยู่
                        $step = 3;
                    }
                    if (count($scorePost) == $lesson->cate_amount) {
                        $step = 3;
                    }
                }
            } else {
                $step = 4;
            }
        }

        return $step;
    }

    public function xss_clean($text)
    {
        $p = new CHtmlPurifier();
        $p->options = array('URI.AllowedSchemes' => array(
            'http' => true,
            'https' => true,
        ));
        $text = $p->purify($text);
        return $text;
    }

    public function resetScore($lesson_id)
    {
        $lesson_model = Lesson::model()->findByPk($lesson_id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $learn = Learn::model()->findAll(array(
            'condition' => "user_id=:user_id AND lesson_id=:lesson AND lesson_active=:active AND gen_id=:gen_id",
            'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $lesson_id, ':active' => 'y', ':gen_id' => $gen_id)
        ));

        foreach ($learn as $key => $value) {

            LearnFile::model()->deleteAll(array(
                'condition' => "learn_id=:learn_id AND user_id_file=:user_id_file AND gen_id=:gen_id",
                'params' => array(':learn_id' => $value->learn_id, ':user_id_file' => Yii::app()->user->id, ':gen_id' => $gen_id)
            ));


            $value->lesson_active = 'n';
            $value->save(false);
        }

        $score = Score::model()->findAll(array(
            'condition' => "user_id=:user_id AND lesson_id=:lesson AND type=:type AND active=:active AND gen_id=:gen_id",
            'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $lesson_id, ':type' => 'post', ':active' => 'y', ':gen_id' => $gen_id)
        ));

        foreach ($score as $key => $value) {

            Logques::model()->deleteAll(array(
                'condition' => 'user_id=:user_id AND lesson_id=:lesson_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':user_id' => Yii::app()->user->id, ':lesson_id' => $lesson_id, ':score_id' => $value->score_id, ':gen_id' => $gen_id)
            ));

            Logchoice::model()->deleteAll(array(
                'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':lesson_id' => $id, ':user_id' => Yii::app()->user->id, ':score_id' => $value->score_id, ':gen_id' => $gen_id)
            ));
            $value->active = 'n';
            $value->save(false);
        }
    }


    public function resetScoreMsTeams($lesson_id)
    {
        $lesson_model = LessonMsTeams::model()->findByPk($lesson_id);
        $gen_id = 0;

        $score = ScoreMsTeams::model()->findAll(array(
            'condition' => "user_id=:user_id AND lesson_teams_id=:lesson AND type=:type AND active=:active AND gen_id=:gen_id",
            'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $lesson_id, ':type' => 'post', ':active' => 'y', ':gen_id' => $gen_id)
        ));

        foreach ($score as $key => $value) {

            LogquesMsTeams::model()->deleteAll(array(
                'condition' => 'user_id=:user_id AND lesson_teams_id=:lesson_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':user_id' => Yii::app()->user->id, ':lesson_id' => $lesson_id, ':score_id' => $value->score_id, ':gen_id' => $gen_id)
            ));

            LogchoiceMsTeams::model()->deleteAll(array(
                'condition' => 'lesson_teams_id=:lesson_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':lesson_id' => $id, ':user_id' => Yii::app()->user->id, ':score_id' => $value->score_id, ':gen_id' => $gen_id)
            ));
            $value->active = 'n';
            $value->save(false);
        }
    }


    public function checkCourseGenCanStudy($course_id_chk, $gen_id)
    { // เช็คว่า ณ ตอนนี้ หลักสูตรนี้ กดเรียนได้ไหม
        $userModel = Users::model()->findByPK(Yii::app()->user->id);
        $userDepartment = $userModel->department_id;
        $userPosition = $userModel->position_id;
        $userBranch = $userModel->branch_id;

        $criteria = new CDbCriteria;
        $criteria->compare('department_id', $userDepartment);
        $criteria->compare('position_id', $userPosition);
        $criteria->compare('branch_id', $userBranch);
        $criteria->compare('active', 'y');
        $modelOrgDep = OrgChart::model()->findAll($criteria);

        foreach ($modelOrgDep as $key => $value) {
            $courseArr[] = $value->id;
        }

        $criteria = new CDbCriteria;
        $criteria->with = array('course', 'course.CategoryTitle');
        $criteria->addIncondition('orgchart_id', $courseArr);
        $criteria->compare('course.active', 'y');
        $criteria->compare('course.status', '1');
        $criteria->compare('categorys.cate_show', '1');
        $criteria->addCondition('course.course_date_end >= :date_now');
        $criteria->params[':date_now'] = date('Y-m-d H:i');
        $criteria->group = 'course.course_id';
        $modelOrgCourse = OrgCourse::model()->findAll($criteria);

        if ($modelOrgCourse) {
            foreach ($modelOrgCourse as $key => $value) {
                $modelUsers_old = ChkUsercourse::model()->find(
                    array(
                        'condition' => 'course_id=:course_id AND user_id=:user_id AND org_user_status=:org_user_status',
                        'params' => array(':course_id' => $value->course_id, ':user_id' => Yii::app()->user->id, ':org_user_status' => 1)
                    )
                );

                if ($modelUsers_old) {
                    if ($modelUsers_old->course_id !=  $value->course_id) {
                        $course_id[] = $value->course_id;
                    }
                } else {
                    $course_id[] = $value->course_id;
                }
            }

            $modelUsers_To = ChkUsercourseto::model()->findAll(
                array(
                    'condition' => 'user_id=:user_id',
                    'params' => array(':user_id' => Yii::app()->user->id)
                )
            );

            foreach ($modelUsers_To as $key => $val) {
                $course_id[] += $val->course_id;
            }

            $criteria = new CDbCriteria;
            $criteria->addIncondition('course_id', $course_id);
            $course = CourseOnline::model()->findAll($criteria);

            $criteria = new CDbCriteria;
            $criteria->with = array('course', 'course.CategoryTitle');
            $criteria->addIncondition('orgchart_id', $courseArr);
            $criteria->compare('course.active', 'y');
            $criteria->compare('course.status', '1');
            $criteria->compare('categorys.cate_show', '1');
            $criteria->addIncondition('course.course_id', $course_id);
            $criteria->addCondition('course.course_date_end >= :date_now');
            $criteria->params[':date_now'] = date('Y-m-d H:i');
            $criteria->order = 'course.course_id';
            $model_cate = OrgCourse::model()->findAll($criteria);

            $course_id_check = "";
            $check_can_org = 2;
            foreach ($model_cate as $key => $value) { // ลบ course id ที่ซ้ำ
                if ($course_id_check != $value->course_id) {
                    $course_id_check = $value->course_id;
                    if ($course_id_chk == $value->course_id) {
                        $check_can_org = 1;
                    }
                } else {
                    unset($model_cate[$key]);
                }
            }
        }


        $return_val = false;
        if ($check_can_org == 1) { // หลักสูตรนี้ อยู่ใน org
            $course_online_model = CourseOnline::model()->findByPk($course_id_chk);
            $paymentDate = date('Y-m-d H:i:s');
            $paymentDate = date('Y-m-d H:i:s', strtotime($paymentDate));
            $contractDateBegin = date('Y-m-d H:i:s', strtotime($course_online_model->course_date_start));
            $contractDateEnd = date('Y-m-d H:i:s', strtotime($course_online_model->course_date_end));

            if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
                $course_gen_model = CourseGeneration::model()->findAll(array(
                    'condition' => 'active=:active AND course_id=:course_id AND gen_id=:gen_id',
                    'params' => array(':active' => 'y', ':course_id' => $course_id_chk, ':gen_id' => $gen_id),
                ));
                if (!empty($course_gen_model)) {
                    foreach ($course_gen_model as $key_g => $value_g) {
                        if ($value_g->status == "1") {
                            $paymentDate = date('Y-m-d H:i:s');
                            $paymentDate = date('Y-m-d H:i:s', strtotime($paymentDate));
                            $contractDateBegin = date('Y-m-d H:i:s', strtotime($value_g->gen_period_start));
                            $contractDateEnd = date('Y-m-d H:i:s', strtotime($value_g->gen_period_end));
                            if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
                                //เช็ค log start course
                                $LogStartcourse = LogStartcourse::model()->find(array(
                                    'condition' => 'active=:active AND course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id',
                                    'params' => array(':active' => 'y', ':course_id' => $course_id_chk, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id),
                                ));
                                $paymentDate = date('Y-m-d H:i:s');
                                $paymentDate = date('Y-m-d H:i:s', strtotime($paymentDate));
                                $contractDateBegin = date('Y-m-d H:i:s', strtotime($LogStartcourse->start_date));
                                $contractDateEnd = date('Y-m-d H:i:s', strtotime($LogStartcourse->end_date));
                                if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
                                    $return_val = true; // หลักสูตรเปิด รุ่นเปิด logเปิด
                                }
                            }
                            // else{  // หมดเวลารุ่น
                            //     $return_val = false; // รุ่น ไม่เปิด
                            // }
                        }
                    } // foreach ($course_gen_model
                } else { // ไม่มีรุ่น
                    //เช็ค log start course
                    $LogStartcourse = LogStartcourse::model()->find(array(
                        'condition' => 'active=:active AND course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id',
                        'params' => array(':active' => 'y', ':course_id' => $course_id_chk, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id),
                    ));
                    $paymentDate = date('Y-m-d H:i:s');
                    $paymentDate = date('Y-m-d H:i:s', strtotime($paymentDate));
                    $contractDateBegin = date('Y-m-d H:i:s', strtotime($LogStartcourse->start_date));
                    $contractDateEnd = date('Y-m-d H:i:s', strtotime($LogStartcourse->end_date));
                    if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
                        $return_val = true; // หลักสูตรเปิด logเปิด
                    }
                }
            }
            // else{ // หมดเวลา หลักสูตร
            //     $return_val = false; // หลักสูตร ไม่เปิด
            // }
        }
        // else{  //if($check_can_org == 1)
        //     $return_val = false; //ไม่อยู่ใน org
        // } // if($check_can_org == 1)


        return $return_val;
    } // function checkCourseGenCanStudy

    public function checkQuestionnaireDone($course_id, $gen_id)
    { //เช็คว่า ทำแบบสอบถาม ยัง
        $QQuestAns_course = QQuestAns_course::model()->find(array(
            'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id',
            'params' => array(':course_id' => $course_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id),
        ));

        if ($QQuestAns_course != "") {
            return true;
        }
        return false;
    }

    public function checkpasscouse($percent, $course_id, $gen_id)
    {
        $course_model = CourseOnline::model()->findByPk($course_id);

        $passCoursModel = Passcours::model()->findByAttributes(array(
            'passcours_cours' => $course_id,
            'passcours_cates' => $course_model->cate_id,
            'passcours_user' => Yii::app()->user->id, 'gen_id' => $gen_id
        ));

        $chk = LogStartcourse::model()->find(array(
            'condition' => 'course_id=:course_id AND user_id=:user_id AND active=:active AND gen_id=:gen_id',
            'params' => array(':course_id' => $course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id)
        ));

        $CoursePassedLog = PasscoursLog::model()->find(array(
            'condition' => 'pclog_userid=:user_id AND pclog_event=:event AND pclog_target=:cou AND gen_id=:cgd_gen',
            'params' => array(':user_id' => Yii::app()->user->id, ':event' => 'Print', ':cou' => $course_id, ':cgd_gen' => $gen_id)
        ));


        if (!$passCoursModel) {
            if ($percent >= 100) {
                $modelPasscours = new Passcours;
                $modelPasscours->passcours_cates = $course_model->cate_id;
                $modelPasscours->passcours_cours = $course_id;
                $modelPasscours->gen_id = $gen_id;
                if ($CoursePassedLog != null) {
                    $modelPasscours->passcours_number = $CoursePassedLog->cou_number;
                }
                $modelPasscours->passcours_user = Yii::app()->user->id;
                $modelPasscours->passcours_date = new CDbExpression('NOW()');
                $modelPasscours->cours_start_date = $chk->start_date;
                $modelPasscours->save();
            }
        } else {
            if ($CoursePassedLog != null) {
                $passCoursModel->passcours_number = $CoursePassedLog->cou_number;
            }
            $passCoursModel->cours_start_date = $chk->start_date;
            $passCoursModel->save();

            if ($percent < 100) {
                $passCoursModel->delete();
            }
        }
        return true;
    }


    public function percent_CourseGen($course_id, $gen_id)
    { // คำนวน % ของหลักสูตร ที่เรียนไป
        // สอบก่อนเรียนของบทเรียน จำนวนวิดีโอ สอบหลังเรียนของบทเรียน สอบfinalของหลักสูตร

        $course = CourseOnline::model()->find(array(
            'condition' => 'course_id=:course_id AND active=:active',
            'params' => array(':course_id' => $course_id, ':active' => 'y'),
        ));
        $lesson = Lesson::model()->findAll(array(
            'condition' => 'course_id=:course_id AND active=:active AND parent_id=:par',
            'params' => array(':course_id' => $course_id, ':active' => 'y', ':par' => 0),
        ));


        $num_step = 0; // สอบก่อนเรียน วิดีโอ สอบหลังเรียน สอบ final
        $step_pass = 0; // step ที่ผ่าน
        foreach ($lesson as $key => $lessonListValue) {
            $checkPreTest = Helpers::checkHavePreTestInManage($lessonListValue->id);
            if ($checkPreTest) {
                $num_step++;
                $score_pre = Score::model()->find(array(
                    'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND lesson_id=:lesson_id AND active=:active AND type=:type',
                    'params' => array(':course_id' => $course->course_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id, ':lesson_id' => $lessonListValue->id, ':active' => 'y', ':type' => 'pre'),
                ));
                if ($score_pre != "") {
                    $step_pass++;
                }
            }

            $checkPostTest = Helpers::checkHavePostTestInManage($lessonListValue->id);
            if ($checkPostTest) {
                $num_step++;
                $score_post = Score::model()->find(array( // หลังเรียน ต้องผ่าน
                    'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND lesson_id=:lesson_id AND active=:active AND type=:type AND score_past=:score_past',
                    'params' => array(':course_id' => $course->course_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id, ':lesson_id' => $lessonListValue->id, ':active' => 'y', ':type' => 'post', ':score_past' => 'y'),
                ));
                if ($score_post != "") {
                    $step_pass++;
                }
            }
            if ($lessonListValue->type == 'vdo' || $lessonListValue->type == 'youtube') {
                foreach ($lessonListValue->files as $les) { // วนไฟล์ วิดีโอ
                    if ($les->lang_id == 1) {
                        $num_step++;
                        $learnModel = Learn::model()->find(array(
                            'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                            'params' => array(':lesson_id' => $lessonListValue->id, ':user_id' => Yii::app()->user->id, ':status' => 'y', ':gen_id' => $gen_id)
                        ));
                        $learnFiles = self::lib()->checkLessonFile($les, $learnModel->learn_id, $gen_id);
                        if ($learnFiles == 'pass') {
                            $step_pass++;
                        }
                    }
                }
            } elseif ($lessonListValue->type == 'pdf') {
                foreach ($lessonListValue->filePdf as $les) { // วนไฟล์ pdf
                    if ($les->lang_id == 1) {
                        $num_step++;
                        $learnModel = Learn::model()->find(array(
                            'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                            'params' => array(':lesson_id' => $lessonListValue->id, ':user_id' => Yii::app()->user->id, ':status' => 'y', ':gen_id' => $gen_id)
                        ));
                        $learnFiles = self::lib()->checkLessonFile($les, $learnModel->learn_id, $gen_id);
                        if ($learnFiles == 'pass') {
                            $step_pass++;
                        }
                    }
                }
            }
        }


        $checkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
        if ($checkHaveCourseTest) { // สอบ final
            $num_step++;
            $score_final = Coursescore::model()->find(array( // หลังเรียน ต้องผ่าน
                'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND score_past=:score_past AND active=:active AND type=:type',
                'params' => array(':course_id' => $course->course_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id, ':score_past' => 'y', ':active' => 'y', ':type' => "post"),
            ));
            if ($score_final != "") {
                $step_pass++;
            }
        }

        $checkHaveCoursePreTest = Helpers::lib()->checkHaveCoursePreTestInManage($course->course_id);
        if ($checkHaveCoursePreTest) { // สอบ ก่อนเรียน course
            $num_step++;
            $checkHaveScoreCoursePreTest = Helpers::lib()->checkHaveScoreCoursePreTest($course->course_id, $gen_id);
            if (!$checkHaveScoreCoursePreTest) {
                $step_pass++;
            }
        }


        $course_id_have_ans = $course->course_id;
        $checkAnswer = QQuestAns_course::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'course_id' => $course->course_id, 'gen_id' => $gen_id
        ));

        if (!$checkAnswer) {
            $course_check = CourseOnline::model()->findAll("parent_id=" . $course->course_id);
            foreach ($course_check as $key => $value) {
                $checkAnswer_parent = QQuestAns_course::model()->findByAttributes(array(
                    'user_id' => Yii::app()->user->id,
                    'course_id' => $value->course_id, 'gen_id' => $gen_id
                ));
                if ($checkAnswer_parent) {
                    $course_id_have_ans = $value->course_id;
                }
            }
        }

        // $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course_id_have_ans));
        //     if($CourseSurvey){ // มี แบบสอบถาม
        //         foreach ($CourseSurvey as $key => $value) {
        //            $num_step++; 
        //            $passQuest = QQuestAns_course::model()->find(array(
        //             'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $course_id_have_ans . '"'." AND gen_id='".$gen_id."'",
        //         ));
        //              if ($passQuest) { //ตอบแบบสอบถามแล้ว
        //                 $step_pass++;
        //             }
        //         }
        //     }

        if ($num_step != 0) {
            $percent_average = 100 / $num_step; // % แต่ละ step
        }

        $percent_pass = 0;
        if ($step_pass != 0) {
            $percent_pass = $step_pass * $percent_average;
        }
        if ($num_step == 0) {
            $chklog = LogStartcourse::model()->find(array(
                'condition' => 'course_id=:course_id AND user_id=:user_id AND active=:active AND gen_id=:gen_id',
                'params' => array(':course_id' => $course_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id)
            ));

            if ($chklog == null) {
                $percent_pass = 0;
            } else {
                $percent_pass = 100;
            }
        }

        return round($percent_pass, 2);
    }



    public function percent_MsTeams($ms_teams_id, $gen_id = 0)
    { // คำนวน % ของหลักสูตร ที่เรียนไป
        // สอบก่อนเรียนของบทเรียน จำนวนวิดีโอ สอบหลังเรียนของบทเรียน สอบfinalของหลักสูตร

        $course = MsTeams::model()->find(array(
            'condition' => 'id=:id AND active=:active',
            'params' => array(':id' => $ms_teams_id, ':active' => 'y'),
        ));
        $lesson = LessonMsTeams::model()->findAll(array(
            'condition' => 'ms_teams_id=:id AND active=:active',
            'params' => array(':id' => $ms_teams_id, ':active' => 'y'),
        ));

        $num_step = 0; // สอบก่อนเรียน วิดีโอ สอบหลังเรียน สอบ final
        $step_pass = 0; // step ที่ผ่าน
        foreach ($lesson as $key => $lessonListValue) {
            $checkPreTest = Helpers::checkHavePreTestInManageMsTeams($lessonListValue->id);
            if ($checkPreTest) {
                $num_step++;
                $score_pre = ScoreMsTeams::model()->find(array(
                    'condition' => 'ms_teams_id=:ms_teams_id AND gen_id=:gen_id AND user_id=:user_id AND lesson_teams_id=:lesson_id AND active=:active AND type=:type',
                    'params' => array(':ms_teams_id' => $ms_teams_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id, ':lesson_id' => $lessonListValue->id, ':active' => 'y', ':type' => 'pre'),
                ));
                if ($score_pre != "") {
                    $step_pass++;
                }
            }
            $checkPostTest = Helpers::checkHavePostTestInManageMsTeams($lessonListValue->id);
            if ($checkPostTest) {
                $num_step++;
                $score_post = ScoreMsTeams::model()->find(array( // หลังเรียน ต้องผ่าน
                    'condition' => 'ms_teams_id=:ms_teams_id AND gen_id=:gen_id AND user_id=:user_id AND lesson_teams_id=:lesson_id AND active=:active AND type=:type AND score_past=:score_past',

                    'params' => array(':ms_teams_id' => $ms_teams_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id, ':lesson_id' => $lessonListValue->id, ':active' => 'y', ':type' => 'post', ':score_past' => 'y'),
                ));
                if ($score_post != "") {
                    $step_pass++;
                }
            }
        }


        if ($num_step != 0) {
            $percent_average = 100 / $num_step; // % แต่ละ step
        }
        $percent_pass = 0;
        if ($step_pass != 0) {
            $percent_pass = $step_pass * $percent_average;
        }
        if ($num_step == 0) {
            $chklog = LogStartMsTeams::model()->find(array(
                'condition' => 'ms_teams_id=:id AND user_id=:user_id AND active=:active AND gen_id=:gen_id',
                'params' => array(':id' => $ms_teams_id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id)
            ));

            if ($chklog == null) {
                $percent_pass = 0;
            } else {
                $percent_pass = 100;
            }
        }

        return round($percent_pass, 2);
    }




    public function CheckHaveCer($course_id)
    { // เช็คว่า หลักสูตรนี้มีใบ Cer ไหม
        if ($course_id != "") {
            $cert = CertificateNameRelations::model()->findAll(array('condition' => 'course_id=' . $course_id));
            if (!empty($cert)) {
                return true;
            }
        }
        return false;
    }

    public function CheckHaveCerMsTeams($ms_teams_id)
    { // เช็คว่า หลักสูตรนี้มีใบ Cer ไหม
        if ($ms_teams_id != "") {
            $cert = CertificateNameRelationsMsTeams::model()->findAll(array('condition' => 'ms_teams_id=' . $ms_teams_id));
            if (!empty($cert)) {
                return true;
            }
        }
        return false;
    }


    public function CheckPreTestAnsTextAreaLesson($lesson, $type, $score_id = null)
    {


        $lesson_id = $lesson->id;
        $lesson_model = Lesson::model()->findByPk($lesson_id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $user_id = Yii::app()->user->id;
        $test_type = $type;
        $ques_type = "3"; // 3=textarea

        if ($score_id == null) {
            $model = Logques::model()->findAll(array(
                'condition' => 'gen_id=:gen_id AND lesson_id=:lesson_id AND user_id=:user_id AND test_type=:test_type AND ques_type=:ques_type AND active=:active AND logque.check=:confirm',
                'params' => array(':gen_id' => $gen_id, ':lesson_id' => $lesson_id, ':user_id' => $user_id, ':test_type' => $test_type, ':active' => 'y', ':ques_type' => $ques_type, ':confirm' => 0),
            ));
        } else {
            $model = Logques::model()->findAll(array(
                'condition' => 'gen_id=:gen_id AND lesson_id=:lesson_id AND score_id=:score_id AND user_id=:user_id AND test_type=:test_type AND ques_type=:ques_type AND active=:active AND logque.check=:confirm',
                'params' => array(':gen_id' => $gen_id, ':lesson_id' => $lesson_id, ':score_id' => $score_id, ':user_id' => $user_id, ':test_type' => $test_type, ':active' => 'y', ':ques_type' => $ques_type, ':confirm' => 0),
            ));
        }

        // var_dump("<pre>");
        if (!empty($model)) {
            return false;
        } else {
            return true;
        }

        // var_dump($model); exit();

    }


    public function CheckPreTestAnsTextAreaLessonMsTeams($lesson, $type)
    {

        $lesson_id = $lesson->id;
        $lesson_model = LessonMsTeams::model()->findByPk($lesson_id);
        $gen_id = 0;

        $user_id = Yii::app()->user->id;
        $test_type = $type;
        $ques_type = "3"; // 3=textarea

        $model = LogquesMsTeams::model()->findAll(array(
            'condition' => 'gen_id=:gen_id AND lesson_teams_id=:lesson_id AND user_id=:user_id AND test_type=:test_type AND ques_type=:ques_type AND active=:active AND logque.check=:confirm',
            'params' => array(':gen_id' => $gen_id, ':lesson_id' => $lesson_id, ':user_id' => $user_id, ':test_type' => $test_type, ':active' => 'y', ':ques_type' => $ques_type, ':confirm' => 0),
        ));

        // var_dump("<pre>");
        if (!empty($model)) {
            return false;
        } else {
            return true;
        }

        // var_dump($model); exit();

    }

    public function CheckPreTestAnsTextAreaLessonOnline($lesson, $type)
    {

        $lesson_id = $lesson->id;
        $lesson_model = LessonOnline::model()->findByPk($lesson_id);
        $gen_id = 0;

        $user_id = Yii::app()->user->id;
        $test_type = $type;
        $ques_type = "3"; // 3=textarea

        $model = LogquesOnline::model()->findAll(array(
            'condition' => 'gen_id=:gen_id AND lesson_teams_id=:lesson_id AND user_id=:user_id AND test_type=:test_type AND ques_type=:ques_type AND active=:active AND logque.check=:confirm',
            'params' => array(':gen_id' => $gen_id, ':lesson_id' => $lesson_id, ':user_id' => $user_id, ':test_type' => $test_type, ':active' => 'y', ':ques_type' => $ques_type, ':confirm' => 0),
        ));

        // var_dump("<pre>");
        if (!empty($model)) {
            return false;
        } else {
            return true;
        }

        // var_dump($model); exit();

    }




    public function CheckPreTestAnsTextAreaCourse($course, $type)
    {

        $course_id = $course;
        $course_model = CourseOnline::model()->findByPk($course_id);
        $gen_id = $course_model->getGenID($course_model->course_id);

        $user_id = Yii::app()->user->id;
        $test_type = $type;
        $ques_type = "3"; // 3=textarea

        $model = Courselogques::model()->findAll(array(
            'condition' => 'gen_id=:gen_id AND course_id=:course_id AND user_id=:user_id AND test_type=:test_type AND ques_type=:ques_type AND active=:active AND (t.check=:confirm OR confirm=:confirm)',
            'params' => array(':gen_id' => $gen_id, ':course_id' => $course_id, ':user_id' => $user_id, ':test_type' => $test_type, ':active' => 'y', ':ques_type' => $ques_type, ':confirm' => 0),
        ));

        if (!empty($model)) {
            return false;
        } else {
            return true;
        }
    }

    public function StatusCourseGen($course_id, $gen_id)
    { // สถานะของหลักสูตร pass learning notLearn
        // $course_id = $course;
        // $course_model = CourseOnline::model()->findByPk($course_id);
        // $gen_id = $course_model->getGenID($course_model->course_id);

        $user_id = Yii::app()->user->id;

        $passcourse = Passcours::model()->findAll(array(
            'condition' => 'gen_id=:gen_id AND passcours_cours=:course_id AND passcours_user=:user_id',
            'params' => array(':gen_id' => $gen_id, ':course_id' => $course_id, ':user_id' => $user_id),
        ));

        if (!empty($passcourse)) { // สามารถพิมเซอได้
            $status = "pass";
        } else { // if(!empty($passcourse)
            $Learn = Learn::model()->findAll(array(
                'condition' => 'gen_id=:gen_id AND course_id=:course_id AND user_id=:user_id AND lesson_active=:active',
                'params' => array(':gen_id' => $gen_id, ':course_id' => $course_id, ':user_id' => $user_id, ':active' => 'y'),
            ));
            // var_dump($course_id); 
            // var_dump($gen_id); 
            // var_dump($user_id); 
            // var_dump($Learn); 
            // exit();
            if (!empty($Learn)) {
                $status = "learning";
            } else {
                $status = "notLearn";
            }
        } // if(!empty($passcourse)

        return $status;
    }


    public function ColorCode()
    {

        $colorName = array(
            "#CC99FF", "#A9D1F7", "#B4F0A7", "#FFF898", "#FFC588", "#FFB1B0", "#FF93F7",
            "#be7dff", "#8ac6ff", "#96ff7f", "#fff569", "#ffb15e", "#ff8d8c", "#ff5bf3",
            "#a74fff", "#5aafff", "#6eff4e", "#fff23e", "#ff9f39", "#ff6867", "#ff37f0",

            "#CC99FF", "#A9D1F7", "#B4F0A7", "#FFF898", "#FFC588", "#FFB1B0", "#FF93F7",
            "#be7dff", "#8ac6ff", "#96ff7f", "#fff569", "#ffb15e", "#ff8d8c", "#ff5bf3",
            "#a74fff", "#5aafff", "#6eff4e", "#fff23e", "#ff9f39", "#ff6867", "#ff37f0",

            "#CC99FF", "#A9D1F7", "#B4F0A7", "#FFF898", "#FFC588", "#FFB1B0", "#FF93F7",
            "#be7dff", "#8ac6ff", "#96ff7f", "#fff569", "#ffb15e", "#ff8d8c", "#ff5bf3",
            "#a74fff", "#5aafff", "#6eff4e", "#fff23e", "#ff9f39", "#ff6867", "#ff37f0",

            "#CC99FF", "#A9D1F7", "#B4F0A7", "#FFF898", "#FFC588", "#FFB1B0", "#FF93F7",
            "#be7dff", "#8ac6ff", "#96ff7f", "#fff569", "#ffb15e", "#ff8d8c", "#ff5bf3",
            "#a74fff", "#5aafff", "#6eff4e", "#fff23e", "#ff9f39", "#ff6867", "#ff37f0",

            "#4B0082", "#0000FF", "#00FF00", "#FFFF00", "#FF7F00", " #FF0000",
            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D', '#80B300',
            '#809900', '#E6B3B3', '#6680B3', '#66991A', '#FF99E6', '#CCFF1A',
            '#FF1A66', '#E6331A', '#33FFCC', '#66994D', '#B366CC', '#4D8000',
            '#B33300', '#CC80CC', '#66664D', '#991AFF', '#E666FF', '#4DB3FF',
            '#1AB399', '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
            '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933', '#FF3380',
            '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',  '#E64D66', '#4DB380',
            '#FF4D4D', '#99E6E6', '#6666FF', "#63b598", "#ce7d78", "#ea9e70",
            "#a48a9e", "#c6e1e8", "#648177", "#0d5ac1",
            "#f205e6", "#1c0365", "#14a9ad", "#4ca2f9", "#a4e43f", "#d298e2", "#6119d0",
            "#d2737d", "#c0a43c", "#f2510e", "#651be6", "#79806e", "#61da5e", "#cd2f00",
            "#9348af", "#01ac53", "#c5a4fb", "#996635", "#b11573", "#4bb473", "#75d89e",
            "#2f3f94", "#2f7b99", "#da967d", "#34891f", "#b0d87b", "#ca4751", "#7e50a8",
            "#c4d647", "#e0eeb8", "#11dec1", "#289812", "#566ca0", "#ffdbe1", "#2f1179",
            "#935b6d", "#916988", "#513d98", "#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
            "#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
            "#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
            "#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
            "#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
            "#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
            "#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
            "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
            "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
            "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#21538e", "#89d534", "#d36647",
            "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
            "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
            "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#9cb64a", "#996c48", "#9ab9b7",
            "#06e052", "#e3a481", "#0eb621", "#fc458e", "#b2db15", "#aa226d", "#792ed8",
            "#73872a", "#520d3a", "#cefcb8", "#a5b3d9", "#7d1d85", "#c4fd57", "#f1ae16",
            "#8fe22a", "#ef6e3c", "#243eeb", "#1dc18", "#dd93fd", "#3f8473", "#e7dbce",
            "#421f79", "#7a3d93", "#635f6d", "#93f2d7", "#9b5c2a", "#15b9ee", "#0f5997",
            "#409188", "#911e20", "#1350ce", "#10e5b1", "#fff4d7", "#cb2582", "#ce00be",
            "#32d5d6", "#17232", "#608572", "#c79bc2", "#00f87c", "#77772a", "#6995ba",
            "#fc6b57", "#f07815", "#8fd883", "#060e27", "#96e591", "#21d52e", "#d00043",
            "#b47162", "#1ec227", "#4f0f6f", "#1d1d58", "#947002", "#bde052", "#e08c56",
            "#28fcfd", "#bb09b", "#36486a", "#d02e29", "#1ae6db", "#3e464c", "#a84a8f",
            "#911e7e", "#3f16d9", "#0f525f", "#ac7c0a", "#b4c086", "#c9d730", "#30cc49",
            "#3d6751", "#fb4c03", "#640fc1", "#62c03e", "#d3493a", "#88aa0b", "#406df9",
            "#615af0", "#4be47", "#2a3434", "#4a543f", "#79bca0", "#a8b8d4", "#00efd4",
            "#7ad236", "#7260d8", "#1deaa7", "#06f43a", "#823c59", "#e3d94c", "#dc1c06",
            "#f53b2a", "#b46238", "#2dfff6", "#a82b89", "#1a8011", "#436a9f", "#1a806a",
            "#4cf09d", "#c188a2", "#67eb4b", "#b308d3", "#fc7e41", "#af3101", "#ff065",
            "#71b1f4", "#a2f8a5", "#e23dd0", "#d3486d", "#00f7f9", "#474893", "#3cec35",
            "#1c65cb", "#5d1d0c", "#2d7d2a", "#ff3420", "#5cdd87", "#a259a4", "#e4ac44",
            "#1bede6", "#8798a4", "#d7790f", "#b2c24f", "#de73c2", "#d70a9c", "#25b67",
            "#88e9b8", "#c2b0e2", "#86e98f", "#ae90e2", "#1a806b", "#436a9e", "#0ec0ff",
            "#f812b3", "#b17fc9", "#8d6c2f", "#d3277a", "#2ca1ae", "#9685eb", "#8a96c6",
            "#dba2e6", "#76fc1b", "#608fa4", "#20f6ba", "#07d7f6", "#dce77a", "#77ecca"
        );

        return $colorName;
    }

    public function changeFormatDateENnew($date)
    {

        if ($type == 'datetime' && $date != '') {
            $date = explode('-', $date);
            $year = $date[0];
            $month = $date[1];
            $day = $date[2];
            $day = explode(' ', $day);
            $days = $day[0];
            $time = explode(':', $day[1]);
            $hour = $time[0];
            $minute = $time[1];
            if ($year == '543' && $month == '00' && $days == '00') {
                return 'ยังไม่เข้าสู่ระบบ';
            }
            switch ($month) {
                case '01':
                    $month = 'Jan';
                    break;
                case '02':
                    $month = 'Feb';
                    break;
                case '03':
                    $month = 'Mar';
                    break;
                case '04':
                    $month = 'Apr';
                    break;
                case '05':
                    $month = 'May';
                    break;
                case '06':
                    $month = 'Jun';
                    break;
                case '07':
                    $month = 'Jul';
                    break;
                case '08':
                    $month = 'Aug';
                    break;
                case '09':
                    $month = 'Sep';
                    break;
                case '10':
                    $month = 'Oct';
                    break;
                case '11':
                    $month = 'Nov';
                    break;
                case '12':
                    $month = 'Dec';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $days . ' ' . $month . ' ' . $year . ' ' . $hour . ':' . $minute . ' น.';
        } else if ($date != '') {
            $date = explode('-', $date);
            $year = $date[0];
            $month = $date[1];
            $day = $date[2];
            $day = explode(' ', $day);
            $day = $day[0];
            switch ($month) {
                case '01':
                    $month = 'Jan';
                    break;
                case '02':
                    $month = 'Feb';
                    break;
                case '03':
                    $month = 'Mar';
                    break;
                case '04':
                    $month = 'Apr';
                    break;
                case '05':
                    $month = 'May';
                    break;
                case '06':
                    $month = 'Jun';
                    break;
                case '07':
                    $month = 'Jul';
                    break;
                case '08':
                    $month = 'Aug';
                    break;
                case '09':
                    $month = 'Sep';
                    break;
                case '10':
                    $month = 'Oct';
                    break;
                case '11':
                    $month = 'Nov';
                    break;
                case '12':
                    $month = 'Dec';
                    break;
                default:
                    $month = 'error';
                    break;
            }
            return $day . ' ' . $month . ' ' . $year;
        }
        return $date;
    }

    public function sendApiToken()
    {

        $param  = array(
            "grant_type" => "client_credentials",
            "client_id" => "2afea96d-37c1-49da-b3e9-243a59ac599e",
            'client_secret' => 'WOF7Q~q73NfK5Yn3vJlsW8kKdD9oI~Cf0pZCs',
            "resource" => "https://graph.microsoft.com/"
        );

        $url = 'https://login.microsoftonline.com/e7cc8e13-115a-42f5-88fb-368567f9c6ae/oauth2/token';

        $ch = curl_init(); //เปิดการเชื่่อมต่อ
        curl_setopt($ch, CURLOPT_URL, $url); // เรียกไปที่ url
        curl_setopt($ch, CURLOPT_POST, 1); // ส่งค่าแบบ post 1 ครั้ง
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/x-www-form-urlencoded'
        // ));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param2));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch); // เก็บค่าที่ส่งกลับมา .. จะประมาณว่า เมสสบอกว่าทำได้หรือไม่ ?
        $return_de = json_decode($return);
        // var_dump($return_de);
        return $return_de->access_token;
    }

    public function sendApiAzureToken($token)
    {
        $url_graph = 'https://graph.microsoft.com/v1.0/me/events';

        $ch_graph = curl_init(); //เปิดการเชื่่อมต่อ
        curl_setopt($ch_graph, CURLOPT_URL, $url_graph); // เรียกไปที่ url
        curl_setopt($ch_graph, CURLOPT_RETURNTRANSFER, true); // ส่งค่าแบบ post 1 ครั้ง
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token . ''
        ));
        // curl_setopt($ch_graph, CURLOPT_HTTPHEADER, array('Authorization:Bearer '.$token.''));
        // curl_setopt($ch_graph, CURLOPT_POSTFIELDS, http_build_query($param));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param2));
        curl_setopt($ch_graph, CURLOPT_RETURNTRANSFER, true);
        $return_graph = curl_exec($ch_graph); // เก็บค่าที่ส่งกลับมา .. จะประมาณว่า เมสสบอกว่าทำได้หรือไม่ ?
        $return_de_graph = json_decode($return_graph);

        var_dump($return_de_graph);
        exit();
        return $return_de_graph;
    }


    public function checkLessonLearn($lesson_id)
    {
        $user = Yii::app()->getModule('user')->user();

        $lesson = Lesson::model()->findByPk($lesson_id);

        $gen_id = $lesson->CourseOnlines->getGenID($lesson->course_id);
        $checkPreTest = self::checkHavePreTestInManage($lesson->id);
        $checkPostTest = self::checkHavePostTestInManage($lesson->id);
        $step2 = false;

        // if($checkPreTest){
        //     $haveScorePre = Score::model()->find(array(
        //         'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND active=:active AND type = "pre" AND gen_id=:gen_id',
        //         'params' => array(':lesson_id'=>$lesson->id, ':user_id'=>Yii::app()->user->id, ':active'=>'y',':gen_id'=>$gen_id)
        //     ));
        //     if($haveScorePre != null){
        //      $step1 = true;
        //     }
        // }else{
        //     $step1 = true;
        // }


        $learnLesson = $user->learns(
            array(
                'condition' => 'lesson_id=:lesson_id AND lesson_active=:status AND gen_id=:gen_id',
                'params' => array(':lesson_id' => $lesson->id, ':status' => "y", ':gen_id' => $gen_id)
            )
        );

        $countFile = 0;
        $countLearnCompareTrueVdos = 0;
        if ($lesson->type == 'vdo') {
            // $countFile = $lesson->fileCount;
            $countFile = $lesson->GetfileCount($lesson->id);
            $countLearnCompareTrueVdos = $user->countLearnCompareTrueVdos(
                array(
                    'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                )
            );
        } else if ($lesson->type == 'pdf') {
            $countFile = $lesson->filePdfCount;
            $countLearnCompareTrueVdos = $user->countLearnCompareTruePdf(
                array(
                    'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                )
            );
        } else if ($lesson->type == 'scorm') {
            $countFile = $lesson->fileScormCount;
            $countLearnCompareTrueVdos = $user->countLearnCompareTrueScorm(
                array(
                    'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                )
            );
        } else if ($lesson->type == 'audio') {
            $countFile = $lesson->fileAudioCount;
            $countLearnCompareTrueVdos = $user->countLearnCompareTrueAudio(
                array(
                    'condition' => 't.lesson_id=:lesson_id AND learn_file_status = \'s\' AND t.gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':gen_id' => $gen_id)
                )
            );
        }

        if ($learnLesson && $learnLesson[0]->lesson_status == 'pass') {
            $step2 = true;
        } else {
            if ($countFile == 0) {
                $step2 = true;
            } else {
                if ($countFile != 0 && $learnLesson) {
                    if ($countLearnCompareTrueVdos != $countFile) {
                        $step2 = false;
                    }
                }
            }
        }

        return $step2;
    }


    public function checkLessonExams($lesson_id, $type = null)
    {
        $user = Yii::app()->getModule('user')->user();

        $lesson = Lesson::model()->findByPk($lesson_id);
        $gen_id = $lesson->CourseOnlines->getGenID($lesson->course_id);
        $status = false;

        if ($type == 'pre') {

            $checkPreTest = self::checkHavePreTestInManage($lesson->id);

            if ($checkPreTest) {
                $haveScorePre = Score::model()->find(array(
                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND active=:active AND type = "pre" AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson->id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id)
                ));
                if ($haveScorePre != null) {
                    $status = true;
                }
            } else {
                $status = true;
            }
        } else if ($type == 'post') {
            $checkPostTest = self::checkHavePostTestInManage($lesson->id);

            if ($checkPostTest) {
                $haveScorePost = Score::model()->find(array(
                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND active=:active AND type = "post" AND gen_id=:gen_id AND score_past=:past',
                    'params' => array(':lesson_id' => $lesson->id, ':user_id' => Yii::app()->user->id, ':active' => 'y', ':gen_id' => $gen_id, ':past' => 'y')
                ));
                if ($haveScorePost != null) {
                    $status = true;
                }
            } else {
                $status = true;
            }
        }


        return $status;
    }


    public function checkPassCoursequestion($course_id, $gen_id = null)
    {
        if ($gen_id == null) {
            $course_model = CourseOnline::model()->findByPk($course_id);
            $gen_id = $course_model->getGenID($course_model->course_id);
        }

        $Course_Score = Coursescore::model()->find(array(
            'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id AND type=:type AND active=:active',
            'params' => array(':type' => 'pre', ':course_id' => $course_id, ':gen_id' => $gen_id, ':user_id' => Yii::app()->user->id, ':active' => 'y')
        ));

        return $Course_Score;
    }



    public function APIAuthenLmsRegister($user_id, $username, $password, $first_name, $last_name, $identity_number, $secret_key)
    {
        $params = array(
            'user_id' => $user_id,
            'username' => $username,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'identity_number' => $identity_number,
            'push_token' => 'noToken',
            'secret_key' => $secret_key
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.authenticator.npbdigital.net/api/register',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $params,
        ));

        $response = curl_exec($curl);
        $return_de = json_decode($response);
        curl_close($curl);
        return $return_de;
    }

    public function APIAuthenLmsSendNoti($user_id, $course_id, $lesson_id, $secret_key, $zoom_url)
    {

        $params = array(
            'user_id' => $user_id,
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'secret_key' => $secret_key,
            'zoom_url' => $zoom_url,
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.authenticator.npbdigital.net/api/sent-noti',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $params,
        ));

        $response = curl_exec($curl);
        $return_de = json_decode($response);
        curl_close($curl);
    }


    function covert24HourTo12Hour($strDate, $lang_id)
    {
        if ($lang_id == 1) {
            return "Time " . date('h:i A', strtotime($strDate)) . " / ";
        } else {
            $time = explode(" ", $strDate)[1];
            return "เวลา " . substr($time, 0, 5) . " น. " . "/ ";
        }
    }


    public function nextStepTest($id, $gen = 0, $pre)
    {
        $lessonList = Lesson::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND course_id=' . $id, 'order' => 'lesson_no'));
        $link = "";
        foreach ($lessonList as $key => $lessonListValue) {
            if ($pre == "pre") {
                $checkPreTest =  self::checkHavePreTestInManage($lessonListValue->id);
                if ($checkPreTest) {
                    $link = Yii::app()->createUrl('/question/preexams', array('id' => $lessonListValue->id, 'gen' => $gen, 'type' => $pre));
                    return     '"' . $link . '"';
                } else {
                    $learnModel = Learn::model()->find(array(
                        'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                        'params' => array(':lesson_id' => $lessonListValue->id, ':user_id' => Yii::app()->user->id, ':status' => 'y', ':gen_id' => $gen)
                    ));
                    if ($lessonListValue->type == 'vdo') {
                        $i = 1;
                        foreach ($lessonListValue->files as $les) {
                            $learnFiles = self::checkLessonFile($les, $learnModel->learn_id, $gen);
                            if ($learnFiles != "pass") {
                                $link = Yii::app()->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'gen' => $gen, 'file' => $les->id, 'vdo' => $i));
                                return     '"' . $link . '"';
                            }
                            $i++;
                        }
                    }
                }
            } else {

                $checkCourseTest = self::lib()->checkCoursePass($id, $gen); //Chekc Lesson all pass to test course exam
                $checkHaveCourseTest = self::lib()->checkHaveCourseTestInManage($id);

                $PaQuest = false;
                $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id' => $id));
                if ($CourseSurvey) {
                    $passQuest = QQuestAns_course::model()->find(array(
                        'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $id . '"' . " AND gen_id='" . $gen . "'",
                    ));
                    $countSurvey = count($passQuest);
                    if ($passQuest) {
                        $PaQuest = true;
                    }
                } else {
                    $PaQuest = true;
                    if ($checkHaveCourseTest) {
                        $criteria = new CDbCriteria;
                        $criteria->compare('course_id', $id);
                        $criteria->compare('user_id', Yii::app()->user->id);
                        $criteria->compare('active', 'y');
                        $countScore = Coursescore::model()->findAll($criteria);
                        if (count($countScore) < $lessonListValue->cate_amount) {
                            $link = Yii::app()->createUrl('coursequestion/preexams', array('id' => $id, 'gen' => $gen, 'type' => 'course'));
                            return     '"' . $link . '"';
                        }
                    } else {
                        $link = Yii::app()->createUrl('course/detail/', array('id' => $id, 'gen' => $gen));
                        return     '"' . $link . '"';
                    }
                }

                if ($checkCourseTest == 'pass') {
                    if ($checkHaveCourseTest) {
                        $criteria = new CDbCriteria;
                        $criteria->compare('course_id', $id);
                        $criteria->compare('gen_id', $gen);
                        $criteria->compare('type', "post");
                        $criteria->compare('user_id', Yii::app()->user->id);
                        $criteria->compare('score_past', 'y');
                        $criteria->compare('active', 'y');
                        $criteria->order = 'score_id';
                        $courseScorePass = Coursescore::model()->findAll($criteria);
                        if ($courseScorePass) {
                            if ($PaQuest) { //ทำแบบสอบถามแล้ว
                                $link = Yii::app()->createUrl('course/questionnaire', array('id' => $id, 'gen' => $gen));
                                return     '"' . $link . '"';
                            } else {
                                $link = Yii::app()->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id, 'gen' => $gen));
                                return     '"' . $link . '"';
                            }
                        } else { //ยังทำแบบทดสอบหลักสูตรไม่ผ่าน
                            $link = Yii::app()->createUrl('coursequestion/preexams', array('id' => $id, 'gen' => $gen, 'type' => 'course'));
                            return     '"' . $link . '"';
                        }
                    } else {
                        if ($PaQuest) { //ทำแบบสอบถามแล้ว
                            $link = Yii::app()->createUrl('course/questionnaire', array('id' => $id, 'gen' => $gen));
                            return     '"' . $link . '"';
                        } else {
                            $link = Yii::app()->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id, 'gen' => $gen));
                            return     '"' . $link . '"';
                        }
                    }
                }
            }
        }

        return     '"' . $link . '"';
    }

    public function nextStepTestLesson($id, $gen = 0, $pre)
    {
        $lessonList = Lesson::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND course_id=' . $id, 'order' => 'lesson_no'));
        $link = "";
        foreach ($lessonList as $key => $lessonListValue) {
            if ($pre == "pre") {
                $learnModel = Learn::model()->find(array(
                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lessonListValue->id, ':user_id' => Yii::app()->user->id, ':status' => 'y', ':gen_id' => $gen)
                ));
                if ($lessonListValue->type == 'vdo') {
                    $i = 1;
                    foreach ($lessonListValue->files as $les) {
                        $learnFiles = self::checkLessonFile($les, $learnModel->learn_id, $gen);
                        if ($learnFiles != "pass") {
                            $link = Yii::app()->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'gen' => $gen, 'file' => $les->id, 'vdo' => $i));
                            return     '"' . $link . '"';
                        }
                        $i++;
                    }
                }
            } else {
                $learnModel = Learn::model()->find(array(
                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lessonListValue->id, ':user_id' => Yii::app()->user->id, ':status' => 'y', ':gen_id' => $gen)
                ));
                if ($lessonListValue->type == 'vdo') {

                    $checkPreTest = self::checkHavePreTestInManage($lessonListValue->id);
                    if ($checkPreTest) {
                        $isPreTest = self::isPretestState($lessonListValue->id, $gen);
                        if ($isPreTest) {
                            $link = Yii::app()->createUrl('question/preexams', array('id' => $lessonListValue->id, 'gen' => $gen, 'type' => 'pre'));
                            return     '"' . $link . '"';
                        }
                    }

                    $i = 1;
                    foreach ($lessonListValue->files as $les) {
                        $learnFiles = self::checkLessonFile($les, $learnModel->learn_id, $gen);
                        if ($learnFiles != "pass") {
                            $link = Yii::app()->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'gen' => $gen, 'file' => $les->id, 'vdo' => $i));
                            return     '"' . $link . '"';
                        }
                        $i++;
                    }
                }
            }
        }
        if ($pre == "post") {
            $link = Yii::app()->createUrl('coursequestion/preexams', array('id' => $id, 'gen' => $gen, 'type' => 'course'));
            return     '"' . $link . '"';
        }
    }


    public function nextStepLesson($id, $gen = 0)
    {
        $lessonList = Lesson::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND course_id=' . $id, 'order' => 'lesson_no'));
        $link = "";
        foreach ($lessonList as $key => $lessonListValue) {
            $learnModel = Learn::model()->find(array(
                'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                'params' => array(':lesson_id' => $lessonListValue->id, ':user_id' => Yii::app()->user->id, ':status' => 'y', ':gen_id' => $gen)
            ));
            if ($lessonListValue->type == 'vdo') {

                $checkPreTest = self::checkHavePreTestInManage($lessonListValue->id);
                if ($checkPreTest) {
                    $isPreTest = self::isPretestState($lessonListValue->id, $gen);
                    if ($isPreTest) {
                        $link = Yii::app()->createUrl('question/preexams', array('id' => $lessonListValue->id, 'gen' => $gen, 'type' => 'pre'));
                        return $link;
                    }
                }

                $i = 1;
                foreach ($lessonListValue->files as $les) {
                    $learnFiles = self::checkLessonFile($les, $learnModel->learn_id, $gen);
                    if ($learnFiles != "pass") {
                        $link = Yii::app()->createUrl('/course/courselearn', array('id' => $lessonListValue->id, 'gen' => $gen, 'file' => $les->id, 'vdo' => $i));
                        return     $link;
                    }
                    $i++;
                }
            }


            $checkPostTest = self::checkHavePostTestInManage($lessonListValue->id);
            $lessonStatus = self::lib()->checkLessonPass($lessonListValue, $gen);
            if ($checkPostTest) {
                $isPostTest = self::isPosttestState($lessonListValue->id, $gen);
                if ($isPostTest) {
                    if ($lessonStatus == 'pass') {
                        $link = Yii::app()->createUrl('question/preexams', array('id' => $lessonListValue->id, 'gen' => $gen, 'type' => 'post'));
                        return $link;
                    }
                }
                // else{
                //     // $link = Yii::app()->createUrl('coursequestion/preexams', array('id' => $id,'gen'=>$gen, 'type' => 'course'));
                //     // return $link;
                // }
            } else {
                $checkCourseTest = self::lib()->checkCoursePass($id, $gen); //Chekc Lesson all pass to test course exam
                $checkHaveCourseTest = self::lib()->checkHaveCourseTestInManage($id);

                $PaQuest = false;
                $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id' => $id));
                if ($CourseSurvey) {
                    $passQuest = QQuestAns_course::model()->find(array(
                        'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $id . '"' . " AND gen_id='" . $gen . "'",
                    ));
                    $countSurvey = count($passQuest);
                    if ($passQuest) {
                        $PaQuest = true;
                    }
                } else {
                    $PaQuest = true;
                    if ($checkHaveCourseTest) {
                        $criteria = new CDbCriteria;
                        $criteria->compare('course_id', $id);
                        $criteria->compare('user_id', Yii::app()->user->id);
                        $criteria->compare('active', 'y');
                        $countScore = Coursescore::model()->findAll($criteria);
                        if (count($countScore) < $lessonListValue->cate_amount) {
                            $link = Yii::app()->createUrl('coursequestion/preexams', array('id' => $id, 'gen' => $gen, 'type' => 'course'));
                            return $link;
                        }
                    } else {
                        $link = Yii::app()->createUrl('course/detail/', array('id' => $id, 'gen' => $gen));
                        return $link;
                    }
                }

                if ($checkCourseTest == 'pass') {
                    if ($checkHaveCourseTest) {
                        $criteria = new CDbCriteria;
                        $criteria->compare('course_id', $id);
                        $criteria->compare('gen_id', $gen);
                        $criteria->compare('type', "post");
                        $criteria->compare('user_id', Yii::app()->user->id);
                        $criteria->compare('score_past', 'y');
                        $criteria->compare('active', 'y');
                        $criteria->order = 'score_id';
                        $courseScorePass = Coursescore::model()->findAll($criteria);
                        if ($courseScorePass) {
                            if ($PaQuest) { //ทำแบบสอบถามแล้ว
                                $link = Yii::app()->createUrl('course/questionnaire', array('id' => $id, 'gen' => $gen));
                                return $link;
                            } else {
                                $link = Yii::app()->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id, 'gen' => $gen));
                                return $link;
                            }
                        } else { //ยังทำแบบทดสอบหลักสูตรไม่ผ่าน
                            $link = Yii::app()->createUrl('coursequestion/preexams', array('id' => $id, 'gen' => $gen, 'type' => 'course'));
                            return $link;
                        }
                    } else {
                        if ($PaQuest) { //ทำแบบสอบถามแล้ว
                            $link = Yii::app()->createUrl('course/questionnaire', array('id' => $id, 'gen' => $gen));
                            return $link;
                        } else {
                            $link = Yii::app()->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id, 'gen' => $gen));
                            return $link;
                        }
                    }
                }
            }
        }

        $link = Yii::app()->createUrl('coursequestion/preexams', array('id' => $id, 'gen' => $gen, 'type' => 'course'));
        return $link;
    }

    public function datePeriod($dateStart, $dateEnd)
    {
        $now = strtotime($dateStart); // or your date as well
        $your_date = strtotime($dateEnd);
        $datediff = $now - $your_date;

        // echo 
        return abs(round($datediff / (60 * 60 * 24)));
    }
}
