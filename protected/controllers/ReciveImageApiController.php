
<?php
class ReciveImageApiController extends Controller
{
 
    public function actionReciveImage(){
        $path = 'msteam_picture';

        $uploadDir = Yii::app()->getUploadPath(null);
        $uploadDir = $uploadDir.'../';

        if (!is_dir($uploadDir.$path."/")) {
            mkdir($uploadDir.$path."/", 0777, true);
        }

        if (!is_dir($uploadDir.$path."/".$_POST['course_id']."/")) {
            mkdir($uploadDir.$path."/".$_POST['course_id']."/", 0777, true);
        }
        $date = date('Y-m-d H:i:s');
        $timestamp1 = strtotime($date);
        $file_name = $_POST['user_id'].'-'.$timestamp1;
        $file_extension = '.jpg';
        $full_path = $uploadDir.$path."/".$_POST['course_id']."/".$file_name.$file_extension;
 
        $success = file_put_contents($full_path, file_get_contents($_FILES["target"]["tmp_name"]));

        $model = New CaptureMsTeams;
        $model->user_id = $_POST['user_id'];
        $model->ms_teams_id = $_POST['course_id'];
        $model->file_name = $file_name;
        $model->active = 'y';
        $model->type_noti = 'mobile';
        $model->create_date = date("Y-m-d h:i:s");
        $model->update_date = date("Y-m-d h:i:s");
        $model->save();

        $logVerify = LogNoti::model()->find("user_id=".$_POST['user_id'].""); 
        if(isset($logVerify)){
            $logVerify->verify = 1;
            $logVerify->save();
        }else{
            $saveLog = New LogNoti();
            $saveLog->user_id = $_POST['user_id'];
            $saveLog->verify = 1;
            $saveLog->save(false);
        }
    }

    public function actionGetResponse(){
        $noti = LogNoti::model()->find("user_id=".$_POST['user_id'].""); 
        if(isset($noti)){
            if($noti->verify == 1){
                // change default
                $noti->verify = 0;
                $noti->save();
                echo "true";
            }
        }else{
            echo "false";
        }
       
    }


    public function actionTestFaceApi($user_id,$type){
      

        $uploadDir = Yii::app()->getUploadPath(null);
        $uploadDir = $uploadDir.'../';

        $use_id = 431;
        $originalFace = YiiBase::getPathOfAlias('webroot') . '/uploads/FaceIdCard/'.$use_id.'.jpg';

        //face straigh
        $pathFaceStraight = 'FaceVerifyStraight';
        $full_path_facestraight = $uploadDir.$pathFaceStraight."/file.jpg";
        file_put_contents($full_path_facestraight, file_get_contents($_FILES["original_face"]["tmp_name"]));
        $fileStraight = curl_file_create($full_path_facestraight, 'image/jpeg', 'filename.jpg');

        //face left
        $pathFaceLeft = 'FaceVerifyLeft';
        $full_path_faceleft = $uploadDir.$pathFaceLeft."/file.jpg";
        file_put_contents($full_path_faceleft, file_get_contents($_FILES["original_face"]["tmp_name"]));
        $fileLeft = curl_file_create($full_path_faceleft, 'image/jpeg', 'filename.jpg');

        //face right
        $pathFaceRight = 'FaceVerifyRight';
        $full_path_faceright = $uploadDir.$pathFaceRight."/file.jpg";
        file_put_contents($full_path_faceright, file_get_contents($_FILES["original_face"]["tmp_name"]));
        $fileRight = curl_file_create($full_path_faceright, 'image/jpeg', 'filename.jpg');



        $data = [
            'original_face' => new CURLFILE($originalFace),
            'face_image_1' => $fileStraight,
            'face_image_2' => $fileLeft,
            'face_image_3' => $fileRight,
        ];


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://223.27.223.70/api/validate/');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        $responseJson = json_decode($response);
        
        $status = "unsuccess";
        if($type == "login"){
            if($responseJson->liveness->liveness_class == "Real"){ // Real Capture
                if($responseJson->valid_scores->validated_class == "Accept"){ // Real User
                        $status = "success";
                }else {
                        $status = "unsuccess";
                }
            }else{
                $status = "fake";
            }
        }else{
            if($responseJson->liveness->liveness_class == "Real"){ // Real Capture
                if($responseJson->valid_scores->validated_score >= 60){ // Real User
                        $status = "success";
                }else {
                        $status = "unsuccess";
                }
            }else{
                $status = "fake";
            }
        }


        

        if (file_exists($full_path_facestraight) && file_exists($full_path_faceleft) && file_exists($full_path_faceright)) {
            unlink($full_path_facestraight); 
            unlink($full_path_faceleft);
            unlink($full_path_faceright);
        } 
        
        return $status;
    }

    public function base64_to_jpeg($base64_string) {
        $data = explode(',', $base64_string);

        return base64_decode($data[1]);
    }
}