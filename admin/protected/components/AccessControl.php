<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22/5/2560
 * Time: 2:45
 */

class AccessControl extends CApplicationComponent
{
    public static function check_access()
    {
        $modelsGroup = PGroup::model()->findAll();
        $group = array();
        foreach ($modelsGroup as $key => $groupval) {
            $group[] = $groupval->id;
        }
        if(Yii::app()->user->id)
        {
            // $return = false;
            $model = User::model()->findByPk(Yii::app()->user->id);

            if(!empty($model)){
                if(is_integer($group)){
                    if($model->group == $group){
                        $return = true;
                    }
                }
                if(is_array($group)){
                    $usergroup = json_decode($model->group);
                    foreach ($group as $value) {
                        if(in_array($value,$usergroup)){
                            $return = true;
                        }
                        // if($model->group == $value){
                        //     $return = true;
                        // }
                    }
                }
            }
            return $return;
        }else{
            return false;
        }
    }

    public static function check_action(){
        $action = array('');
        if(Yii::app()->user->id)
        {
            $model = User::model()->findByPk(Yii::app()->user->id);
   
            if(!empty($model)){
                $usergroup = json_decode($model->group);
                if($usergroup){
                    foreach ($usergroup as $key => $val) {

                       $permission = PGroupPermission::model()->find(array('condition'=> 'group_id ='. $val));
                        if ($permission) {
                            if (in_array("1", $usergroup)) {
                                return array();
                            } else {
                               foreach (json_decode($permission->permission) as $key => $value) {
                                    if (strtolower(Yii::app()->controller->id) == strtolower($key)){
                                        if(!empty($value->action) && ($value->active == 1)){
                                            $action = strtolower($value->action);
                                        }
                                    }
                                }
                                return $action;
                            }
                        }else{
                            return $action;
                        }
                    }
                }
                
            }
        }else{
            return $action;
        }
    }
    
    public static function check_access_action($controller_name,$action_name){
        $action = array('');
        if(Yii::app()->user->id)
        {
            $model = User::model()->findByPk(Yii::app()->user->id);
   
            if(!empty($model)){
                $usergroup = json_decode($model->group);
                if($usergroup){
                    foreach ($usergroup as $key => $val) {

                       $permission = PGroupPermission::model()->find(array('condition'=> 'group_id ='. $val));
                        if ($permission) {
                            if (in_array("1", $usergroup)) {
                                return true;
                            } else {
                               foreach (json_decode($permission->permission) as $key => $value) {
                                    if (strtolower($controller_name) == strtolower($key)){
                                        // return strtolower($key);
                                        if(!empty($value->action) && ($value->active == 1)){
                                            
                                            $action = array_map('strtolower', $value->action);
                                            if($action_name != '*'){
                                                if(!in_array(strtolower($action_name), $action)){
                                                    return false;
                                                }
                                            }
                                            return true;
                                        }
                                    }
                                }
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }
                }
                
            }
        }else{
            return $action;
        }
    }

    // public static function check_access_admin($controller_name,$action_name){
    //     $action = array('');
    //     if(Yii::app()->user->id)
    //     {
    //         $model = User::model()->findByPk(Yii::app()->user->id);
   
    //         if(!empty($model)){
    //             $usergroup = json_decode($model->group);
    //             if($usergroup){
    //                 foreach ($usergroup as $key => $val) {

    //                    $permission = PGroupPermission::model()->find(array('condition'=> 'group_id ='. $val));
    //                     if ($permission) {
    //                         if (in_array("1")) {
    //                             return true;
    //                         } else {
    //                            foreach (json_decode($permission->permission) as $key => $value) {
    //                                 if (strtolower($controller_name) == strtolower($key)){
    //                                     if(!empty($value->action) && ($value->active == 1)){
    //                                         $action = $value->action;
    //                                         if($action_name != '*'){
    //                                             if(!in_array(strtolower($action_name), $action)){
    //                                                 return false;
    //                                             }
    //                                         }
    //                                         return true;
    //                                     }
    //                                 }
    //                             }
    //                             return false;
    //                         }
    //                     }else{
    //                         return false;
    //                     }
    //                 }
    //             }
                
    //         }
    //     }else{
    //         return $action;
    //     }
    // }

    // public static function check_access_filemanager($status){
    //     if($status == 1){
    //         Yii::app()->session['admin'] = true;
    //     }else{
    //         Yii::app()->session['admin'] = false;
    //     }
    // }
}