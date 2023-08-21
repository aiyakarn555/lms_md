<?php
$my_org = '';
if (!Yii::app()->user->isGuest) {
    $my_org = json_decode($users->orgchart_lv2);
}
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}

$news_forms = $users->isNewRecord;
if ($news_forms) {
  $news_forms = 'y';
}else{
  $news_forms = 'n';
}
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.css">
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/croppie/croppie.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-daterangepicker/jquery.datetimepicker.css">
<script src='https://www.google.com/recaptcha/api.js'></script>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/uploadifive.css">
<style>
    .container1 input[type=text] {
        padding: 5px 0px;
        margin: 5px 5px 5px 0px;
    }

    .add_form_field {
        background-color: #1c97f3;
        border: none;
        color: #fff;
        padding: 8px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }
    .add_form_language {
        background-color: #1c97f3;
        border: none;
        color: #fff;
        padding: 8px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }

    .add_form_work {
        background-color: #1c97f3;
        border: none;
        color: #fff;
        padding: 8px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }
    .add_form_training {
        background-color: #1c97f3;
        border: none;
        color: #fff;
        padding: 8px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }

    .delete {
        border-radius: 3px;
        border: none;
        color: white;
        padding: 5px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-table;
        font-size: 14px;
        margin: 4px 15px;
        cursor: pointer;
        /* position: absolute;
        right: 0 */
    }
    .delete_work {
        border-radius: 3px;
        border: none;
        color: white;
        padding: 5px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-table;
        font-size: 14px;
        margin: 4px 15px;
        cursor: pointer;
        position: absolute;
        right: 0 
    }
    .delete_training{
    /*    border-radius: 3px;
        border: none;
        color: white;
        padding: 5px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-table;
        font-size: 14px;
        margin: 4px 15px;
        cursor: pointer;*/
        border-radius: 3px;
        border: none;
        color: white;
        padding: 5px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-table;
        font-size: 14px;
        margin: 4px 15px;
        cursor: pointer;
        position: absolute;
        right: 0 
    }
    .uploadifive-button {
        float: left;
        margin-right: 10px;
    }
    #queue {
        border: 1px solid rgba(26, 26, 26, 0.14901960784313725);
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 100%;
        border-radius: 4px;
    }

    #docqueue {
        border: 1px solid rgba(26, 26, 26, 0.14901960784313725);
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 100%;
        border-radius: 4px;
    }

    .birthday-icon{
        position: relative;
    }
    .birthday-icon i{
        position: absolute;
        right: 16px;
        top: 40px;
        z-index: 2;
        display: block;
        pointer-events: none;
    }
    .baht {
        position: absolute;
        left:  16px;
        top: 40px;
        z-index: 2;
        display: block;
        pointer-events: none;
    }

    .since-icon{
        position: relative;
    }
    .since-icon i{
        position: absolute;
        right: 16px;
        top: 13px;
        display: block;
        pointer-events: none;
    }

    @media screen and (max-width: 600px){
        #register .row.justify-content-center{
            justify-content: inherit !important;
        }
    }

    .box-uploadimage {
    position: relative;
}

.course-pagination {
    padding-right: 15px;
}

.proflie-login img {
    border-radius: 50%;
    height: 38px;
    width: 38px;
    margin-right: 10px;
}

label.cabinet {
    display: block;
    cursor: pointer;
}

label.cabinet input.file {
    position: absolute;
    width: auto;
    opacity: 0;
    -moz-opacity: 0;
    filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
    margin-top: -30px;
    bottom: 0;
    right: 0;
}

#upload-profileimg {
    width: 250px;
    height: 250px;
    padding-bottom: 25px;
}

figure figcaption {
    color: #fff;
    width: 100%;
    padding-left: 9px;
    padding-bottom: 5px;
    margin-top: 10px;
}

.btn-uploadimg {
    font-size: 14px;
    padding: 10px 20px;
}

.clearfix {
    overflow: auto;
}

</style>
<script language="javascript">

    function isThaiEngchar(str,obj){
        var isThai=true;
        var orgi_text=" ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
        var chk_text=str.split("");
        chk_text.filter(function(s){        
            if(orgi_text.indexOf(s)==-1){
                isThai=false;
            }           
        }); 

        console.log(isThai);

        var isEng=true;
        var orgi_text="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var chk_text=str.split("");
        chk_text.filter(function(s){        
            if(orgi_text.indexOf(s)==-1){
                isEng=false;
                if(isThai == false){
                    obj.value=str.replace(RegExp(s, "g"),'');
                }
            }           
        }); 
        
        if(isThai == false && isEng == false){
            return false;
        }else{
           return true; 
       }
 }

    function isThaichar(str,obj){
        var isThai=true;
        var orgi_text=" ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
        var chk_text=str.split("");
        chk_text.filter(function(s){        
            if(orgi_text.indexOf(s)==-1){
                isThai=false;
                obj.value=str.replace(RegExp(s, "g"),'');
            }           
        }); 
    return isThai; // ถ้าเป็น true แสดงว่าเป็นภาษาไทยทั้งหมด*/
}
function isEngchar(str,obj){
    var isEng=true;
    var orgi_text="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var chk_text=str.split("");
    chk_text.filter(function(s){        
        if(orgi_text.indexOf(s)==-1){
            isEng=false;
            obj.value=str.replace(RegExp(s, "g"),'');
        }           
    }); 
    return isEng; 
}
function isNumberchar(str,obj){
    var isNumber=true;
    var orgi_text="0123456789";
    var chk_text=str.split("");
    chk_text.filter(function(s){        
        if(orgi_text.indexOf(s)==-1){
            isNumber=false;
            obj.value=str.replace(RegExp(s, "g"),'');
        }           
    }); 
    return isNumber; 
}
function isPassportchar(str,obj,s){
    var isNumber=true;
    var orgi_text="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var chk_text=str.split("");
    chk_text.filter(function(s){     
     
        if(orgi_text.indexOf(s)==-1 || /\s/g.test(s)){
                isNumber=false;
                var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Do not use spaces and only enter uppercase letters and numbers.! ':'ห้ามเว้นวรรคและป้อนตัวอักษรพิมพ์ใหญ่และตัวเลขเท่านั้น!'; ?>"; 
                swal(alert_message);
                obj.value=str.replace(RegExp(s, "g"),'');
        }          
    }); 
    return isNumber; isSpaces
}

function isSpaces(s){
    var isNumber=true;
        if(/\s/g.test(s)){
                isNumber=false;
                var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Do not use spaces.! ':'ห้ามเว้นวรรค!'; ?>"; 
                swal(alert_message);
                //replace(RegExp(s, "g"),'');
                //replaceSpace.replace(/ /g, ";");
                 $(".email").empty();
                 $(".email").val(null);
        }          
    return isNumber;
}

function isNumbercharSalary(str,obj){
    var isNumberSalary=true;
    var orgi_text="0123456789,";
    var chk_text=str.split("");
    chk_text.filter(function(s){        
        if(orgi_text.indexOf(s)==-1){
            isNumberSalary=false;
            obj.value=str.replace(RegExp(s, "g"),'');
        }           
    }); 
    return isNumberSalary; 
}
function checkID(id) {
    if (id.length != 13) return false;
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(id.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
        return false;
    return true;

}

function checkForm() {
    if (!checkID(document.form1.idcard.value)) {
        alert('<?= $label->label_alert_identification ?>');
    }
}

function upload()
{

        //tinymce.triggerSave();
        //tinyMCE.triggerSave(); 
//     var type_cards = $("input[name='type_card']:checked").val();
//     if (type_cards === 'l') {

//        if ($('.idcard').val() == "" ) {
//         var idcard = "<?php //echo Yii::app()->session['lang'] == 1?'Please enter your ID number! ':'กรุณากรอกเลขบัตรประชาชน!'; ?>";
//         swal(alert_message,idcard)
//         return false; 
//     }
// }else if (type_cards === 'p'){

//    if ($('.passport').val() == "" ) {
//     var passport = "<?php //echo Yii::app()->session['lang'] == 1?'Please enter your passport number! ':'กรุณากรอกเลขพาสปอร์ต!'; ?>";
//     swal(alert_message,passport)
//     return false; 
// }
// }else if(typeof  type_cards === 'undefined' || typeof  type_cards === null){

//     var card = "<?php //echo Yii::app()->session['lang'] == 1?'Please choose to check your ID card or passport! ':'กรุณาเลือกเช็คบัตรประชาชนหรือพาสปอร์ต!'; ?>";
//     swal(alert_message,card)
//     return false;
// }

var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 

var up_new = '<?php echo $news_forms ?>';
if (up_new == 'y') {  

    if ($('.firstname').val() == "") {
     var firstname = "<?php echo Yii::app()->session['lang'] == 1?'Please enter name! ':'กรุณากรอกชื่อ!'; ?>";
     swal(alert_message,firstname)
     return false;
 }

 if ($('.lastname').val() == "") {
    var lastname = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your surname! ':'กรุณากรอกนามสกุล!'; ?>";
    swal(alert_message,lastname)
    return false;
}
if ($('.prefix').val() == "") {
    var prefix = "<?php echo Yii::app()->session['lang'] == 1?'Please choose a name prefix! ':'กรุณาเลือกคำนำหน้าชื่อ!'; ?>";
    swal(alert_message,prefix)
    return false;
}
if ($('.firstname_en').val() == "") {
    var firstname_en = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your name in English! ':'กรุณากรอกชื่อเป็นภาษาอังกฤษ!'; ?>";
    swal(alert_message,firstname_en)
    return false;
}
if ($('.lastname_en').val() == "") {
    var firstname_en = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your surname in English! ':'กรุณากรอกนามสกุลเป็นภาษาอังกฤษ!'; ?>";
    swal(alert_message,firstname_en)
    return false;
} 
if ($('.prefix_en').val() == "") {
    var prefix_en = "<?php echo Yii::app()->session['lang'] == 1?'Please choose an English name prefix! ':'กรุณาเลือกคำนำหน้าชื่อภาษาอังกฤษ!'; ?>";
    swal(alert_message,prefix_en)
    return false;
}
if ($('.email').val() == "") {
    var email = "<?php echo Yii::app()->session['lang'] == 1?'Please enter email! ':'กรุณากรอกอีเมล!'; ?>";
    swal(alert_message,email)
    return false;
} 

    // if ($('.idcard').val() == "" ) {
    //         var idcard = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your ID number! ':'กรุณากรอกเลขบัตรประชาชน!'; ?>";
    //         swal(alert_message,idcard)
    //         return false; 
    // }



    var type_users = $("input[name='type_user']:checked").val();

    if (type_users === '1') {

        if ($('#url_pro_pic').val() == "" ) {
            var picture = "<?php echo Yii::app()->session['lang'] == 1?'Please add a picture! ':'กรุณาเพิ่มรูปภาพ!'; ?>";
            swal(alert_message,picture)
            return false; 
        }

        if ($('.passport').val() == "" ) {
            var passport = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your passport number! ':'กรุณากรอกเลขพาสปอร์ต!'; ?>";
            swal(alert_message,passport)
            return false; 
        } 

        if ($('#Profile_pass_expire').val() == "" ) {
            var Profile_pass_expire = "<?php echo Yii::app()->session['lang'] == 1?'Please select a passport expiration date! ':'กรุณาเลือกวันหมดอายุหนังสือเดินทาง!'; ?>";
            swal(alert_message,Profile_pass_expire)
            return false; 
        }

        if ($('#Profile_seamanbook').val() == "" ) {
            var Profile_seamanbook = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the shipping number! ':'กรุณากรอกเลขหนังสือเดินเรือ!'; ?>";
            swal(alert_message,Profile_seamanbook)
            return false; 
        }

        if ($('#Profile_seaman_expire').val() == "" ) {
            var Profile_seaman_expire = "<?php echo Yii::app()->session['lang'] == 1?'Please select an expiration date for shipping documents! ':'กรุณาเลือกวันหมดอายุหนังสือเดินเรือ!'; ?>";
            swal(alert_message,Profile_seaman_expire)
            return false; 
        }

        if ($('#Profile_birthday').val() == "" ) {
            var Profile_birthday = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your date of birth! ':'กรุณากรอกวันเดือนปีเกิด!'; ?>";
            swal(alert_message,Profile_birthday)
            return false; 
        }

        if ($('#Profile_blood').val() == "" ) {
            var Profile_blood = "<?php echo Yii::app()->session['lang'] == 1?'Please enter blood type! ':'กรุณากรอกกรุ๊ปเลือด!'; ?>";
            swal(alert_message,Profile_blood)
            return false; 
        }

        if ($('#Profile_hight').val() == "" ) {
            var Profile_hight = "<?php echo Yii::app()->session['lang'] == 1?'Please enter a height! ':'กรุณากรอกความสูง!'; ?>";
            swal(alert_message,Profile_hight)
            return false; 
        }

        if ($('#Profile_weight').val() == "" ) {
            var Profile_weight = "<?php echo Yii::app()->session['lang'] == 1?'Please enter a weight! ':'กรุณากรอกน้ำหนัก!'; ?>";
            swal(alert_message,Profile_weight)
            return false; 
        }

        if ($('#Profile_race').val() == "" ) {
            var Profile_race = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your ethnicity! ':'กรุณากรอกเชื้อชาติ!'; ?>";
            swal(alert_message,Profile_race)
            return false; 
        }

        if ($('#Profile_nationality').val() == "" ) {
            var Profile_nationality = "<?php echo Yii::app()->session['lang'] == 1?'Please enter nationality! ':'กรุณากรอกสัญชาติ!'; ?>";
            swal(alert_message,Profile_nationality)
            return false; 
        }

        if ($('#Profile_sex').val() == "" ) {
            var Profile_sex = "<?php echo Yii::app()->session['lang'] == 1?'Please select gender! ':'กรุณาเลือกเพศ!'; ?>";
            swal(alert_message,Profile_sex)
            return false; 
        }

        var status_sm = $("input[name='status_sm']:checked").val(); 
        if (typeof  status_sm === 'undefined' || typeof  status_sm === null) {
            var status_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a status check! ':'กรุณาเลือกเช็คสถานภาพ!'; ?>";
            swal(alert_message,status_message)
            return false;
        }else if(status_sm === 'm'){
            if ($('#Profile_number_of_children').val() == "" ) {
                var Profile_number_of_children = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the number of children! ':'กรุณากรอกจำนวนบุตร!'; ?>";
                swal(alert_message,Profile_number_of_children)
                return false; 
            }

            if ($('#Profile_spouse_firstname').val() == "" ) {
                var Profile_spouse_firstname = "<?php echo Yii::app()->session['lang'] == 1?'Please enter spouse name! ':'กรุณากรอกชื่อคู่สมรส!'; ?>";
                swal(alert_message,Profile_spouse_firstname)
                return false; 
            }

            if ($('#Profile_spouse_lastname').val() == "" ) {
                var Profile_spouse_lastname = "<?php echo Yii::app()->session['lang'] == 1?'Please enter spouse surname! ':'กรุณากรอกนามสกุลคู่สมรส!'; ?>";
                swal(alert_message,Profile_spouse_lastname)
                return false; 
            }

        }

        var accommodation = $("input[name='accommodation']:checked").val(); 
        if (typeof  accommodation === 'undefined' || typeof  accommodation === null) {
            var accommodation_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a residence check! ':'กรุณาเลือกเช็คที่อยู่อาศัย!'; ?>";
            swal(alert_message,accommodation_message)
            return false;
        } 

        if ($('#Profile_domicile_address').val() == "" ) {
            var Profile_domicile_address = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the address on the ID card! ':'กรุณากรอกที่อยู่ตามบัตรประชาชน!'; ?>";
            swal(alert_message,Profile_domicile_address)
            return false; 
        }

        if ($('#Profile_address').val() == "" ) {
            var Profile_address = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the address! ':'กรุณากรอกที่อยู่!'; ?>";
            swal(alert_message,Profile_address)
            return false; 
        }

        if ($('#Profile_tel').val() == "" ) {
            var Profile_tel = "<?php echo Yii::app()->session['lang'] == 1?'Please enter phone number! ':'กรุณากรอกเบอร์โทร!'; ?>";
            swal(alert_message,Profile_tel)
            return false; 
        }

        if ($('#Profile_phone').val() == "" ) {
            var Profile_phone = "<?php echo Yii::app()->session['lang'] == 1?'Please enter an emergency contact telephone! ':'กรุณากรอกโทรศัพท์ที่ติดต่อฉุกเฉิน!'; ?>";
            swal(alert_message,Profile_phone)
            return false; 
        }

        if ($('#Profile_name_emergency').val() == "" ) {
            var Profile_name_emergency = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the name of the emergency contact! ':'กรุณากรอกชื่อผู้ที่ติดต่อฉุกเฉิน!'; ?>";
            swal(alert_message,Profile_name_emergency)
            return false; 
        }

        if ($('#Profile_relationship_emergency').val() == "" ) {
            var Profile_relationship_emergency = "<?php echo Yii::app()->session['lang'] == 1?'Please fill relationship! ':'กรุณากรอกความสัมพันธ์!'; ?>";
            swal(alert_message,Profile_relationship_emergency)
            return false; 
        }

        var military = $("input[name='military']:checked").val(); 
        if (typeof  military === 'undefined' || typeof  military === null) {
            var military_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a national service status! ':'กรุณาเลือกเช็คสถานะการรับใช้ชาติ!'; ?>";
            swal(alert_message,military_message)
            return false;
        } 

        var history_of_illness = $("input[name='history_of_illness']:checked").val(); 
        if (typeof  history_of_illness === 'undefined' || typeof  history_of_illness === null) {
            var history_of_illness_message = "<?php echo Yii::app()->session['lang'] == 1?'Please choose to check the history of severe illness! ':'กรุณาเลือกเช็คประวัติการเจ็บป่วยรุนแรง!'; ?>";
            swal(alert_message,history_of_illness_message)
            return false;
        }else if (history_of_illness === 'y') {
            if ($('#Profile_sickness').val() == "" ) {
                var Profile_sickness = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the disease that was previously sick! ':'กรุณากรอกโรคที่เคยป่วย!'; ?>";
                swal(alert_message,Profile_sickness)
                return false; 
            }            
        }

        if ($('#ProfilesEdu_0_edu_id').val() == "" && $('#ProfilesEdu_0_institution').val() == "" && $('#ProfilesEdu_0_date_graduation').val() == "" ) {
            var ProfilesEdu = "<?php echo Yii::app()->session['lang'] == 1?'Please fill out your education! ':'กรุณากรอกประวัติศึกษา!'; ?>";
            swal(alert_message,ProfilesEdu)
            return false; 
            
        }else{
            if ($('#ProfilesEdu_0_edu_id').val() == "" ) {
                var ProfilesEdu_0_edu_id = "<?php echo Yii::app()->session['lang'] == 1?'Please select study level! ':'กรุณาเลือกระดับการศึกษา!'; ?>";
                swal(alert_message,ProfilesEdu_0_edu_id)
                return false; 
            }

            if ($('#ProfilesEdu_0_institution').val() == "" ) {
                var ProfilesEdu_0_institution = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the name of the school! ':'กรุณากรอกชื่อสถานศึกษา!'; ?>";
                swal(alert_message,ProfilesEdu_0_institution)
                return false; 
            }

            if ($('#ProfilesEdu_0_date_graduation').val() == "" ) {
                var ProfilesEdu_0_date_graduation = "<?php echo Yii::app()->session['lang'] == 1?'Please year of graduation! ':'กรุณาปีจบการศึกษา!'; ?>";
                swal(alert_message,ProfilesEdu_0_date_graduation)
                return false; 
            }
        }

        var ProfilesLanguage_writes = $("input[name='ProfilesLanguage[1][writes]']:checked").val(); 
        if (typeof  ProfilesLanguage_writes === 'undefined' || typeof  ProfilesLanguage_writes === null) {
            var ProfilesLanguage_writes_message = "<?php echo Yii::app()->session['lang'] == 1?'Please choose to check the Thai writing ability level! ':'กรุณาเลือกเช็คระดับความสามารถการเขียนด้านภาษาไทย!'; ?>";
            swal(alert_message,ProfilesLanguage_writes_message)
            return false;
        }

        var ProfilesLanguage_spoken = $("input[name='ProfilesLanguage[1][spoken]']:checked").val(); 
        if (typeof  ProfilesLanguage_spoken === 'undefined' || typeof  ProfilesLanguage_spoken === null) {
            var ProfilesLanguage_spoken_message = "<?php echo Yii::app()->session['lang'] == 1?'Please choose to check the level of Thai speaking ability! ':'กรุณาเลือกเช็คระดับความสามารถการพูดด้านภาษาไทย!'; ?>";
            swal(alert_message,ProfilesLanguage_spoken_message)
            return false;
        }

        var ProfilesLanguage_writes2 = $("input[name='ProfilesLanguage[2][writes]']:checked").val(); 
        if (typeof  ProfilesLanguage_writes2 === 'undefined' || typeof  ProfilesLanguage_writes2 === null) {
            var ProfilesLanguage_writes2_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a level of English proficiency! ':'กรุณาเลือกเช็คระดับความสามารถการเขียนด้านภาษาอังกฤษ!'; ?>";
            swal(alert_message,ProfilesLanguage_writes2_message)
            return false;
        } 

        var ProfilesLanguage_spoken2 = $("input[name='ProfilesLanguage[2][spoken]']:checked").val(); 
        if (typeof  ProfilesLanguage_spoken2 === 'undefined' || typeof  ProfilesLanguage_spoken2 === null) {
            var ProfilesLanguage_spoken2_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a level of English speaking ability! ':'กรุณาเลือกเช็คระดับความสามารถการพูดด้านภาษาอังกฤษ!'; ?>";
            swal(alert_message,ProfilesLanguage_spoken2_message)
            return false;
        } 

        if ($('#docqueue').text() == "") {
         var docqueue = "<?php echo Yii::app()->session['lang'] == 1?'Please add attachments educational! ':'กรุณาเพิ่มไฟล์แนบวุฒิการศึกษา!'; ?>";
         swal(alert_message,docqueue)
         return false;
     }

     if ($('#Profile_expected_salary').val() == "" ) {
        var Profile_expected_salary = "<?php echo Yii::app()->session['lang'] == 1?'Please fill out the expected salary! ':'กรุณากรอกเงินเดือนที่คาดหวัง!'; ?>";
        swal(alert_message,Profile_expected_salary)
        return false; 
    }

    if ($('#Profile_start_working').val() == "" ) {
        var Profile_start_working = "<?php echo Yii::app()->session['lang'] == 1?'Please select a date that is ready to start working! ':'กรุณาเลือกวันที่พร้อมเริ่มงาน!'; ?>";
        swal(alert_message,Profile_start_working)
        return false; 
    }

    if ($('.position_gen').val() == "" ) {
        var position_gen = "<?php echo Yii::app()->session['lang'] == 1?'Please choose the position you want to apply! ':'กรุณาเลือกตำแหน่งที่ต้องการสมัคร!'; ?>";
        swal(alert_message,position_gen)
        return false; 
    }
}else if(type_users === '3'){

   //  var type_employees = $("input[name='type_employee']:checked").val(); 
   //  if (typeof  type_employees === 'undefined' || typeof  type_employees === null) {
   //      var employees = "<?php echo Yii::app()->session['lang'] == 1?'Please select a check. Select a department and position! ':'กรุณาเลือกเช็คเลือกแผนกและตำแหน่ง!'; ?>";
   //      swal(alert_message,employees)
   //      return false;
   // }else if(type_employees != ""){
   //     if(type_employees === '1'){
   //      if ($('.department').val() == "" ) {
   //          var department = "<?php echo Yii::app()->session['lang'] == 1?'Please select department! ':'กรุณาเลือกแผนก!'; ?>";
   //          swal(alert_message,department)
   //          return false; 
   //      }
   //      // else if($('.department').val() != ""){
   //      //     if ($('.position').val() == "" ) {
   //      //         var position = "<?php echo Yii::app()->session['lang'] == 1?'กรุณาเลือกตำแหน่ง! ':'กรุณาเลือกตำแหน่ง!'; ?>";
   //      //         swal(alert_message,position)
   //      //         return false; 
   //      //     }
   //      // }
   //      var type_card = $("input[name='type_card']:checked").val(); 
   //      if (typeof  type_card === 'undefined' || typeof  type_card === null) {
   //          var type_card_choose = "<?php echo Yii::app()->session['lang'] == 1?'Please choose a check. Choose your ID number or passport! ':'กรุณาเลือกเช็คเลือกเลขบัตรประชาชนหรือหนังสือเดินทาง!'; ?>";
   //          swal(alert_message,type_card_choose)
   //          return false; 
   //      }else if(type_card === 'l'){

   //              if ($('.idcard').val() == "" ) {
   //              var idcard = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your ID number! ':'กรุณากรอกเลขบัตรประชาชน!'; ?>";
   //              swal(alert_message,idcard)
   //              return false; 
   //          }

   //              if ($('#Profile_date_of_expiry').val() == "" ) {
   //              var Profile_date_of_expiry = "<?php echo Yii::app()->session['lang'] == 1?'Please select an expiration date, ID number! ':'กรุณาเลือกวันหมดอายุเลขบัตรประจำตัวประชาชน!'; ?>";
   //              swal(alert_message,Profile_date_of_expiry)
   //              return false; 
   //          }      
   //      }else if(type_card === 'p'){
   //              if ($('.passport').val() == "" ) {
   //              var passport = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your passport number! ':'กรุณากรอกเลขพาสปอร์ต!'; ?>";
   //              swal(alert_message,passport)
   //              return false; 
   //          } 
   //              if ($('#Profile_pass_expire').val() == "" ) {
   //              var Profile_pass_expire = "<?php echo Yii::app()->session['lang'] == 1?'Please select a passport expiration date! ':'กรุณาเลือกวันหมดอายุหนังสือเดินทาง!'; ?>";
   //              swal(alert_message,Profile_pass_expire)
   //              return false; 
   //          }
   //  }

   //  if ($('#url_pro_pic').val() == "" ) {
   //      var picture = "<?php echo Yii::app()->session['lang'] == 1?'Please add a picture! ':'กรุณาเพิ่มรูปภาพ!'; ?>";
   //      swal(alert_message,picture)
   //      return false; 
   //  }

   //      if ($('#Profile_birthday').val() == "" ) {
   //          var Profile_birthday = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your date of birth! ':'กรุณากรอกวันเดือนปีเกิด!'; ?>";
   //          swal(alert_message,Profile_birthday)
   //          return false; 
   //      }

   //      if ($('#Profile_blood').val() == "" ) {
   //          var Profile_blood = "<?php echo Yii::app()->session['lang'] == 1?'Please enter blood type! ':'กรุณากรอกกรุ๊ปเลือด!'; ?>";
   //          swal(alert_message,Profile_blood)
   //          return false; 
   //      }

   //      if ($('#Profile_hight').val() == "" ) {
   //          var Profile_hight = "<?php echo Yii::app()->session['lang'] == 1?'Please enter a height! ':'กรุณากรอกความสูง!'; ?>";
   //          swal(alert_message,Profile_hight)
   //          return false; 
   //      }

   //      if ($('#Profile_weight').val() == "" ) {
   //          var Profile_weight = "<?php echo Yii::app()->session['lang'] == 1?'Please enter a weight! ':'กรุณากรอกน้ำหนัก!'; ?>";
   //          swal(alert_message,Profile_weight)
   //          return false; 
   //      }

   //      if ($('#Profile_race').val() == "" ) {
   //          var Profile_race = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your ethnicity! ':'กรุณากรอกเชื้อชาติ!'; ?>";
   //          swal(alert_message,Profile_race)
   //          return false; 
   //      }

   //      if ($('#Profile_nationality').val() == "" ) {
   //          var Profile_nationality = "<?php echo Yii::app()->session['lang'] == 1?'Please enter nationality! ':'กรุณากรอกสัญชาติ!'; ?>";
   //          swal(alert_message,Profile_nationality)
   //          return false; 
   //      }

   //      if ($('#Profile_sex').val() == "" ) {
   //          var Profile_sex = "<?php echo Yii::app()->session['lang'] == 1?'Please select gender! ':'กรุณาเลือกเพศ!'; ?>";
   //          swal(alert_message,Profile_sex)
   //          return false; 
   //      }

   //      var status_sm = $("input[name='status_sm']:checked").val(); 
   //      if (typeof  status_sm === 'undefined' || typeof  status_sm === null) {
   //          var status_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a status check! ':'กรุณาเลือกเช็คสถานภาพ!'; ?>";
   //          swal(alert_message,status_message)
   //          return false;
   //      }else if(status_sm === 'm'){
   //          if ($('#Profile_number_of_children').val() == "" ) {
   //              var Profile_number_of_children = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the number of children! ':'กรุณากรอกจำนวนบุตร!'; ?>";
   //              swal(alert_message,Profile_number_of_children)
   //              return false; 
   //          }

   //          if ($('#Profile_spouse_firstname').val() == "" ) {
   //              var Profile_spouse_firstname = "<?php echo Yii::app()->session['lang'] == 1?'Please enter spouse name! ':'กรุณากรอกชื่อคู่สมรส!'; ?>";
   //              swal(alert_message,Profile_spouse_firstname)
   //              return false; 
   //          }

   //          if ($('#Profile_spouse_lastname').val() == "" ) {
   //              var Profile_spouse_lastname = "<?php echo Yii::app()->session['lang'] == 1?'Please enter spouse surname! ':'กรุณากรอกนามสกุลคู่สมรส!'; ?>";
   //              swal(alert_message,Profile_spouse_lastname)
   //              return false; 
   //          }

   //      }

   //      var accommodation = $("input[name='accommodation']:checked").val(); 
   //      if (typeof  accommodation === 'undefined' || typeof  accommodation === null) {
   //          var accommodation_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a residence check! ':'กรุณาเลือกเช็คที่อยู่อาศัย!'; ?>";
   //          swal(alert_message,accommodation_message)
   //          return false;
   //      } 

   //      if ($('#Profile_domicile_address').val() == "" ) {
   //          var Profile_domicile_address = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the address on the ID card! ':'กรุณากรอกที่อยู่ตามบัตรประชาชน!'; ?>";
   //          swal(alert_message,Profile_domicile_address)
   //          return false; 
   //      }

   //      if ($('#Profile_address').val() == "" ) {
   //          var Profile_address = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the address! ':'กรุณากรอกที่อยู่!'; ?>";
   //          swal(alert_message,Profile_address)
   //          return false; 
   //      }

   //      if ($('#Profile_tel').val() == "" ) {
   //          var Profile_tel = "<?php echo Yii::app()->session['lang'] == 1?'Please enter phone number! ':'กรุณากรอกเบอร์โทร!'; ?>";
   //          swal(alert_message,Profile_tel)
   //          return false; 
   //      }

   //      if ($('#Profile_phone').val() == "" ) {
   //          var Profile_phone = "<?php echo Yii::app()->session['lang'] == 1?'Please enter an emergency contact telephone! ':'กรุณากรอกโทรศัพท์ที่ติดต่อฉุกเฉิน!'; ?>";
   //          swal(alert_message,Profile_phone)
   //          return false; 
   //      }

   //      if ($('#Profile_name_emergency').val() == "" ) {
   //          var Profile_name_emergency = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the name of the emergency contact! ':'กรุณากรอกชื่อผู้ที่ติดต่อฉุกเฉิน!'; ?>";
   //          swal(alert_message,Profile_name_emergency)
   //          return false; 
   //      }

   //      if ($('#Profile_relationship_emergency').val() == "" ) {
   //          var Profile_relationship_emergency = "<?php echo Yii::app()->session['lang'] == 1?'Please fill relationship! ':'กรุณากรอกความสัมพันธ์!'; ?>";
   //          swal(alert_message,Profile_relationship_emergency)
   //          return false; 
   //      }

   //      var military = $("input[name='military']:checked").val(); 
   //      if (typeof  military === 'undefined' || typeof  military === null) {
   //          var military_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a national service status! ':'กรุณาเลือกเช็คสถานะการรับใช้ชาติ!'; ?>";
   //          swal(alert_message,military_message)
   //          return false;
   //      } 

   //      var history_of_illness = $("input[name='history_of_illness']:checked").val(); 
   //      if (typeof  history_of_illness === 'undefined' || typeof  history_of_illness === null) {
   //          var history_of_illness_message = "<?php echo Yii::app()->session['lang'] == 1?'Please choose to check the history of severe illness! ':'กรุณาเลือกเช็คประวัติการเจ็บป่วยรุนแรง!'; ?>";
   //          swal(alert_message,history_of_illness_message)
   //          return false;
   //      }else if (history_of_illness === 'y') {
   //          if ($('#Profile_sickness').val() == "" ) {
   //              var Profile_sickness = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the disease that was previously sick! ':'กรุณากรอกโรคที่เคยป่วย!'; ?>";
   //              swal(alert_message,Profile_sickness)
   //              return false; 
   //          }            
   //      }

   //      if ($('#ProfilesEdu_0_edu_id').val() == "" && $('#ProfilesEdu_0_institution').val() == "" && $('#ProfilesEdu_0_date_graduation').val() == "" ) {
   //          var ProfilesEdu = "<?php echo Yii::app()->session['lang'] == 1?'Please fill out your education! ':'กรุณากรอกประวัติศึกษา!'; ?>";
   //          swal(alert_message,ProfilesEdu)
   //          return false; 
            
   //      }else{
   //          if ($('#ProfilesEdu_0_edu_id').val() == "" ) {
   //              var ProfilesEdu_0_edu_id = "<?php echo Yii::app()->session['lang'] == 1?'Please select study level! ':'กรุณาเลือกระดับการศึกษา!'; ?>";
   //              swal(alert_message,ProfilesEdu_0_edu_id)
   //              return false; 
   //          }

   //          if ($('#ProfilesEdu_0_institution').val() == "" ) {
   //              var ProfilesEdu_0_institution = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the name of the school! ':'กรุณากรอกชื่อสถานศึกษา!'; ?>";
   //              swal(alert_message,ProfilesEdu_0_institution)
   //              return false; 
   //          }

   //          if ($('#ProfilesEdu_0_date_graduation').val() == "" ) {
   //              var ProfilesEdu_0_date_graduation = "<?php echo Yii::app()->session['lang'] == 1?'Please year of graduation! ':'กรุณาปีจบการศึกษา!'; ?>";
   //              swal(alert_message,ProfilesEdu_0_date_graduation)
   //              return false; 
   //          }
   //      } 

   //      if ($('#docqueue').text() == "") {
   //       var docqueue = "<?php echo Yii::app()->session['lang'] == 1?'Please add attachments educational! ':'กรุณาเพิ่มไฟล์แนบวุฒิการศึกษา!'; ?>";
   //       swal(alert_message,docqueue)
   //       return false;
   //   }

 //}else 
 //if(type_employees === '2'){
      if ($('#User_username').val() == "" ) {
            var User_username = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your Employee ID! ':'กรุณากรอกรหัสพนักงาน!'; ?>";
            swal(alert_message,User_username)
            return false; 
        }
    if ($('.department').val() == "" ) {
            var department = "<?php echo Yii::app()->session['lang'] == 1?'Please select department! ':'กรุณาเลือกแผนก!'; ?>";
            swal(alert_message,department)
            return false; 
        }
        // else if($('.department').val() != ""){
        //     if ($('.position').val() == "" ) {
        //         var position = "<?php echo Yii::app()->session['lang'] == 1?'กรุณาเลือกตำแหน่ง! ':'กรุณาเลือกตำแหน่ง!'; ?>";
        //         swal(alert_message,position)
        //         return false; 
        //     }
        // }
    var type_card = $("input[name='type_card']:checked").val(); 
        if (typeof  type_card === 'undefined' || typeof  type_card === null) {
            var type_card_choose = "<?php echo Yii::app()->session['lang'] == 1?'Please choose a check. Choose your ID number or passport! ':'กรุณาเลือกเช็คเลือกเลขบัตรประชาชนหรือหนังสือเดินทาง!'; ?>";
            swal(alert_message,type_card_choose)
            return false; 
        }else if(type_card === 'l'){

                if ($('.idcard').val() == "" ) {
                var idcard = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your ID number! ':'กรุณากรอกเลขบัตรประชาชน!'; ?>";
                swal(alert_message,idcard)
                return false; 
            }

                if ($('#Profile_date_of_expiry').val() == "" ) {
                var Profile_date_of_expiry = "<?php echo Yii::app()->session['lang'] == 1?'Please select an expiration date, ID number! ':'กรุณาเลือกวันหมดอายุเลขบัตรประจำตัวประชาชน!'; ?>";
                swal(alert_message,Profile_date_of_expiry)
                return false; 
            }      
        }else if(type_card === 'p'){
                if ($('.passport').val() == "" ) {
                var passport = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your passport number! ':'กรุณากรอกเลขพาสปอร์ต!'; ?>";
                swal(alert_message,passport)
                return false; 
            } 
                if ($('#Profile_pass_expire').val() == "" ) {
                var Profile_pass_expire = "<?php echo Yii::app()->session['lang'] == 1?'Please select a passport expiration date! ':'กรุณาเลือกวันหมดอายุหนังสือเดินทาง!'; ?>";
                swal(alert_message,Profile_pass_expire)
                return false; 
            }
    }

    if ($('#url_pro_pic').val() == "" ) {
        var picture = "<?php echo Yii::app()->session['lang'] == 1?'Please add a picture! ':'กรุณาเพิ่มรูปภาพ!'; ?>";
        swal(alert_message,picture)
        return false; 
    }
        if ($('#Profile_birthday').val() == "" ) {
            var Profile_birthday = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your date of birth! ':'กรุณากรอกวันเดือนปีเกิด!'; ?>";
            swal(alert_message,Profile_birthday)
            return false; 
        }
        // var status_sm = $("input[name='status_sm']:checked").val(); 
        // if (typeof  status_sm === 'undefined' || typeof  status_sm === null) {
        //     var status_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a status check! ':'กรุณาเลือกเช็คสถานภาพ!'; ?>";
        //     swal(alert_message,status_message)
        //     return false;
        // }else
         if(status_sm === 'm'){
            if ($('#Profile_number_of_children').val() == "" ) {
                var Profile_number_of_children = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the number of children! ':'กรุณากรอกจำนวนบุตร!'; ?>";
                swal(alert_message,Profile_number_of_children)
                return false; 
            }

            if ($('#Profile_spouse_firstname').val() == "" ) {
                var Profile_spouse_firstname = "<?php echo Yii::app()->session['lang'] == 1?'Please enter spouse name! ':'กรุณากรอกชื่อคู่สมรส!'; ?>";
                swal(alert_message,Profile_spouse_firstname)
                return false; 
            }

            if ($('#Profile_spouse_lastname').val() == "" ) {
                var Profile_spouse_lastname = "<?php echo Yii::app()->session['lang'] == 1?'Please enter spouse surname! ':'กรุณากรอกนามสกุลคู่สมรส!'; ?>";
                swal(alert_message,Profile_spouse_lastname)
                return false; 
            }

        }

        // var accommodation = $("input[name='accommodation']:checked").val(); 
        // if (typeof  accommodation === 'undefined' || typeof  accommodation === null) {
        //     var accommodation_message = "<?php echo Yii::app()->session['lang'] == 1?'Please select a residence check! ':'กรุณาเลือกเช็คที่อยู่อาศัย!'; ?>";
        //     swal(alert_message,accommodation_message)
        //     return false;
        // } 

        // if ($('#Profile_domicile_address').val() == "" ) {
        //     var Profile_domicile_address = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the address on the ID card! ':'กรุณากรอกที่อยู่ตามบัตรประชาชน!'; ?>";
        //     swal(alert_message,Profile_domicile_address)
        //     return false; 
        // }

        // if ($('#Profile_address').val() == "" ) {
        //     var Profile_address = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the address! ':'กรุณากรอกที่อยู่!'; ?>";
        //     swal(alert_message,Profile_address)
        //     return false; 
        // }

        if ($('#Profile_tel').val() == "" ) {
            var Profile_tel = "<?php echo Yii::app()->session['lang'] == 1?'Please enter phone number! ':'กรุณากรอกเบอร์โทร!'; ?>";
            swal(alert_message,Profile_tel)
            return false; 
        }

   // }

// } 

    
}else if(type_users === '5'){  

    var type_card = $("input[name='type_card']:checked").val(); 
        if (typeof  type_card === 'undefined' || typeof  type_card === null) {
            var type_card_choose = "<?php echo Yii::app()->session['lang'] == 1?'Please choose a check. Choose your ID number or passport! ':'กรุณาเลือกเช็คเลือกเลขบัตรประชาชนหรือหนังสือเดินทาง!'; ?>";
            swal(alert_message,type_card_choose)
            return false; 
        }else if(type_card === 'l'){

                if ($('.idcard').val() == "" ) {
                var idcard = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your ID number! ':'กรุณากรอกเลขบัตรประชาชน!'; ?>";
                swal(alert_message,idcard)
                return false; 
            }

                if ($('#Profile_date_of_expiry').val() == "" ) {
                var Profile_date_of_expiry = "<?php echo Yii::app()->session['lang'] == 1?'Please select an expiration date, ID number! ':'กรุณาเลือกวันหมดอายุเลขบัตรประจำตัวประชาชน!'; ?>";
                swal(alert_message,Profile_date_of_expiry)
                return false; 
            }      
        }else if(type_card === 'p'){
                if ($('.passport').val() == "" ) {
                var passport = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your passport number! ':'กรุณากรอกเลขพาสปอร์ต!'; ?>";
                swal(alert_message,passport)
                return false; 
            } 
                if ($('#Profile_pass_expire').val() == "" ) {
                var Profile_pass_expire = "<?php echo Yii::app()->session['lang'] == 1?'Please select a passport expiration date! ':'กรุณาเลือกวันหมดอายุหนังสือเดินทาง!'; ?>";
                swal(alert_message,Profile_pass_expire)
                return false; 
            }
    }

    if ($('.sex_5').val() == "" ) {
        var sex_5 = "<?php echo Yii::app()->session['lang'] == 1?'Please select gender! ':'กรุณาเลือกเพศ!'; ?>";
        swal(alert_message,sex_5)
        return false; 
    }

    if ($('#Profile_nationality').val() == "" ) {
        var nationality_5 = "<?php echo Yii::app()->session['lang'] == 1?'Please enter nationality! ':'กรุณากรอกสัญชาติ!'; ?>";
        swal(alert_message,nationality_5)
        return false; 
    }

    if ($('#Profile_phone2').val() == "" ) {
        var tel_5 = "<?php echo Yii::app()->session['lang'] == 1?'Please enter phone number! ':'กรุณากรอกเบอร์โทร!'; ?>";
        swal(alert_message,tel_5)
        return false; 
    }

    if ($('.occupation_5').val() == "" ) {
        var occupation_5 = "<?php echo Yii::app()->session['lang'] == 1?'Please fill out the occupation! ':'กรุณากรอกอาชืพ!'; ?>";
        swal(alert_message,occupation_5)
        return false; 
    }

    if ($('#Profile_domicile_address').val() == "" ) {
        var Profile_domicile_address = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your current address! ':'กรุณากรอกที่อยู่ปัจจุบัน!'; ?>";
        swal(alert_message,Profile_domicile_address)
        return false; 
    }

    // if ($('#Profile_line_id').val() == "" ) {
    //     var Profile_line_id = "<?php echo Yii::app()->session['lang'] == 1?'Please enter ID Line! ':'กรุณากรอก ID Line!'; ?>";
    //     swal(alert_message,Profile_line_id)
    //     return false; 
    // }

    if ($('#Profile_birthday').val() == "" ) {
        var Profile_birthday = "<?php echo Yii::app()->session['lang'] == 1?'Please enter your date of birth! ':'กรุณากรอกวันเดือนปีเกิด!'; ?>";
        swal(alert_message,Profile_birthday)
        return false; 
    }

    if ($('#ProfilesEdu_0_edu_id').val() == "" && $('#ProfilesEdu_0_institution').val() == "" && $('#ProfilesEdu_0_date_graduation').val() == "" ) {
        var ProfilesEdu = "<?php echo Yii::app()->session['lang'] == 1?'Please fill out your education! ':'กรุณากรอกประวัติศึกษา!'; ?>";
        swal(alert_message,ProfilesEdu)
        return false; 

    }else{
        if ($('#ProfilesEdu_0_edu_id').val() == "" ) {
            var ProfilesEdu_0_edu_id = "<?php echo Yii::app()->session['lang'] == 1?'Please select study level! ':'กรุณาเลือกระดับการศึกษา!'; ?>";
            swal(alert_message,ProfilesEdu_0_edu_id)
            return false; 
        }

        if ($('#ProfilesEdu_0_institution').val() == "" ) {
            var ProfilesEdu_0_institution = "<?php echo Yii::app()->session['lang'] == 1?'Please enter the name of the school! ':'กรุณากรอกชื่อสถานศึกษา!'; ?>";
            swal(alert_message,ProfilesEdu_0_institution)
            return false; 
        }

        if ($('#ProfilesEdu_0_date_graduation').val() == "" ) {
            var ProfilesEdu_0_date_graduation = "<?php echo Yii::app()->session['lang'] == 1?'Please year of graduation! ':'กรุณาปีจบการศึกษา!'; ?>";
            swal(alert_message,ProfilesEdu_0_date_graduation)
            return false; 
        }
    }
} 

 }


var file = $('#queue').val();
var file2 = $('#docqueue').val();
var exts = ['jpg','pdf','png','jpeg'];
if ( file || file2) {
    var get_ext = file.split('.');
    get_ext = get_ext.reverse();

    if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){

        if($('#queue .uploadifive-queue-item').length == 0 && $('#docqueue .uploadifive-queue-item').length == 0){
            return true;
        }else{
            if($('#queue .uploadifive-queue-item').length > 0 ) {
                $('#Training').uploadifive('upload');
                return false;
            }else if($('#docqueue .uploadifive-queue-item').length > 0){
                $('#doc').uploadifive('upload');
                return false;
            }
        } 
    }
}else{
   if($('#queue .uploadifive-queue-item').length == 0 && $('#docqueue .uploadifive-queue-item').length == 0 ){
    return true;
}else{
 if($('#docqueue .uploadifive-queue-item').length > 0){
    $('#doc').uploadifive('upload');
    return false;
}else if($('#queue .uploadifive-queue-item').length > 0){
    $('#Training').uploadifive('upload');
    return false;

}


}
}
}

function deleteFileDoc(filedoc_id,file_id){
    console.log(filedoc_id);

    $.get("<?php echo $this->createUrl('Registration/deleteFileDoc'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
           // notyfy({dismissQueue: false,text: "ลบไฟล์เรียบร้อย",type: 'success'});
           var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
           swal(success_file);
           location.reload();
           $('#'+filedoc_id).parent().hide('fast');
       }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        swal(Unable_file);
    }
});
}

function editName(filedoc_id){
    var name = $('#filenamedoc'+filedoc_id).val();

    $.get("<?php echo $this->createUrl('Registration/editName'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filenamedoc'+filedoc_id).hide();
        $('#filenamedoctext'+filedoc_id).text(name);
        $('#filenamedoctext'+filedoc_id).show();
        $('#btnEditName'+filedoc_id).show();
    });

}

function deleteFiletrains(filedoc_id,file_id){

    $.get("<?php echo $this->createUrl('Registration/deleteFileTrain'); ?>",{id:file_id},function(data){
        console.log(data);
    //     if($.trim(data)==1){
    //        var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
    //        swal(success_file);
    //        location.reload();
    //        $('#'+filedoc_id).parent().hide('fast');
    //    }else{
    //     var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
    //     swal(Unable_file);
    // }
});
}

function editNameTrain(filedoc_id){
    console.log(filedoc_id);
    var name = $('#filenameTrains'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNameTrain'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filenameTrains'+filedoc_id).hide();
        $('#filenametraintext'+filedoc_id).text(name);
        $('#filenametraintext'+filedoc_id).show();
        $('#btnEditNametrain'+filedoc_id).show();
    });

}
function deleteFilepassport(file_id){
 console.log(file_id);
 $.get("<?php echo $this->createUrl('Registration/deleteFilePassport'); ?>",{id:file_id},function(data){
    if($.trim(data)==1){
     var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
     swal(success_file);
     location.reload();
     $('#'+filedoc_id).parent().hide('fast');
 }else{
    var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
    swal(Unable_file);
}
});
}

function editNamepassport(filedoc_id){
    var name = $('#filename_attach_passport'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNamePassport'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filename_attach_passport'+filedoc_id).hide();
        $('#file_attach_passporttext'+filedoc_id).text(name);
        $('#file_attach_passporttext'+filedoc_id).show();
        $('#btnEditName_attach_passport'+filedoc_id).show();
    });
    location.reload();
}
function deleteFilecrew_identification(file_id){
    $.get("<?php echo $this->createUrl('Registration/deleteFilePassport'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
         var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
         swal(success_file);
         location.reload();
         $('#'+filedoc_id).parent().hide('fast');
     }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        swal(Unable_file);
    }
});
}

function editNamecrew_identification(filedoc_id){
    var name = $('#filename_attach_crew_identification'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNamePassport'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filename_attach_crew_identification'+filedoc_id).hide();
        $('#file_crew_identificationtext'+filedoc_id).text(name);
        $('#file_crew_identificationtext'+filedoc_id).show();
        $('#btnEditName_attach_crew_identification'+filedoc_id).show();
    });
    location.reload();
}
function deleteFileidentification(file_id){
    $.get("<?php echo $this->createUrl('Registration/deleteFilePassport'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
         var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
         swal(success_file);
         location.reload();
         $('#'+filedoc_id).parent().hide('fast');
     }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        swal(Unable_file);
    }
});
}

function editNameidentification(filedoc_id){
    var name = $('#filename_attach_identification'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNamePassport'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filename_attach_identification'+filedoc_id).hide();
        $('#file_identificationtext'+filedoc_id).text(name);
        $('#file_identificationtext'+filedoc_id).show();
        $('#btnEditName_attach_identification'+filedoc_id).show();
    });
    location.reload();
}
function deleteFilehouse_registration(file_id){
    $.get("<?php echo $this->createUrl('Registration/deleteFilePassport'); ?>",{id:file_id},function(data){
        if($.trim(data)==1){
         var success_file = '<?php echo Yii::app()->session['lang'] == 1?'File deletion successful ':'ลบไฟล์สำเร็จ'; ?>';
         swal(success_file);
         location.reload();
         $('#'+filedoc_id).parent().hide('fast');
     }else{
        var Unable_file = '<?php echo Yii::app()->session['lang'] == 1?'Unable to delete file ':'ไม่สามารถลบไฟล์ได้'; ?>';
        swal(Unable_file);
    }
});
}

function editNamehouse_registration(filedoc_id){
    var name = $('#filename_attach_house_registration'+filedoc_id).val();
    $.get("<?php echo $this->createUrl('Registration/editNamePassport'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filename_attach_house_registration'+filedoc_id).hide();
        $('#file_house_registrationtext'+filedoc_id).text(name);
        $('#file_house_registrationtext'+filedoc_id).show();
        $('#btnEditName_attach_house_registration'+filedoc_id).show();
    });
    location.reload();
}
</script>

<script>
    function check_number() {
        // alert("adadad");
        e_k = event.keyCode
        //if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
            if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
                event.returnValue = false;

                alert("Number only...Please check your information again ...");
            }
        }

        function numberWithCommas() {
            var x = document.getElementById("Profile_expected_salary").value;
            var c = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $(".salary").val(c);
        }
    </script>

    <!-- Header -->
    <style>
        .error2 {
            color: red;
        }
    </style>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $label->label_regis ?></li>
            </ol>
        </nav>
    </div>

    <section class="content" id="register">
        <div class="container">
            <div class="well reset-well">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                //                            'name' => 'form1',
                    'id' => 'registration-form',
                //                        'OnSubmit'=> checkForm(),
                //                        'enableAjaxValidation'=>true,
                //                        // 'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                //                        'clientOptions'=>array(
                //                            'validateOnSubmit'=>true,
                //                        ),
                //                        บรรทัดนี้เอาไว้เก็บไฟลภาพ
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1'/*, 'onsubmit' => 'checkForm(); return false;'*/),
            ));
            ?>
            <?php
            $expire_date = array('class' => ' form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => $label->label_date_of_expiry);
            $working = array('class' => ' form-control default_datetimepicker start_working', 'autocomplete' => 'off', 'placeholder' => $label->label_start_working);
            $attTime = array('class' => ' form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => $label->label_date_of_expiry);
            $date_issueds = array('class' => ' form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => $label->label_date_issued);
            $birthday = array('class' => 'form-control default_datetimepicker birth', 'autocomplete' => 'off', 'placeholder' => $label->label_birthday, 'type' => "text");
            $ships_up_date = array('class' => ' form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => $label->label_ship_up_date);
            $ships_down_date = array('class' => 'form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => $label->label_ship_down_date);
            $Since = array('class' => 'form-control default_datetimepicker', 'autocomplete' => 'off', 'placeholder' => Yii::app()->session['lang'] == 1?'Since ':'ตั้งแต่');
            ?>
            <div class="well">

                <!-- <div class="row box-img-center mb-2 bb-1 uploads_image">
<div class="col-sm-4"> -->
    <div class="row form-mb-1 justify-content-center box-uploadimage">
        <div class="col-md-4 item-uploadimamge">
            <div class="img-profile-setting">
                <div class="text-center upload-img">
                    <label class="cabinet center-block">
                        <figure>
                            <?php
                            if ($users->pic_user == null) {
                                $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                            } else {
                                $registor = new RegistrationForm;
                                $registor->id = $users->id;
                                $img = Yii::app()->baseUrl . '/uploads/user/' . $users->id . '/thumb/' . $users->pic_user;
                            }
                            $url_pro_pic = $img;
                            ?>
                            <img src="<?php echo $url_pro_pic; ?>" class="gambar img-responsive img-thumbnail" name="item-img-output" id="item-img-output" />
                            <figcaption>
                                <div class="btn btn-default btn-uploadimg"><i class="fa fa-camera"></i> <?= Yii::app()->session['lang'] == 1?'Select picture':'เลือกรูป'; ?> </div>
                            </figcaption>
                        </figure>
                        <input type="hidden" name="url_pro_pic" id="url_pro_pic">
                        <input type="file" id="Profile_pro_pic" class="item-img file center-block d-none" name="Profile_pro_pic" />
                    </label>
                    <span class="text-danger"><font color="red">*</font><?= Yii::app()->session['lang'] == 1?'Image should be sized 2X2 inch':'รูปภาพควรมีขนาด 2X2 นิ้ว'; ?> </span>
                </div>
            </div>
        </div>
    </div>
<!-- </div> 

             </div> -->
            <?php if ($users->isNewRecord) { ?>

             <div class="row justify-content-center select-profile mg-0">
                <div class="form-group">
                     <?php
                        
                    $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
                    $chk_status_reg = $SettingAll['ACTIVE_PERSONAL'];
                    if ($chk_status_reg) {
                        ?>
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="type_user" id="general" value="5" <?php if ($profile->type_user == 5) : ?> checked="checked" <?php endif ?>>
                        <label for="general" class="bg-success text-black">
                            <?php echo $label->label_general_public; ?> </label>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="type_user" id="accept" value="1" <?php if ($profile->type_user == 1) : ?> checked="checked" <?php endif ?>>
                            <label for="accept" class="bg-success text-black">
                                <?php echo $label->label_ship_public; ?> </label>
                            </div>
                            <?php
                             // if (Yii::app()->user->id == null) {
                    $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
                    $chk_status_reg = $SettingAll['ACTIVE_OFFICE'];
                    if ($chk_status_reg) {
                            ?>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" name="type_user" id="reject" value="3" <?php if ($profile->type_user == 3) : ?> checked="checked" <?php endif ?>>
                                <label for="reject" class="bg-danger text-black"><?php echo $label->label_personnel; ?> </label>
                            </div>
                            <?php
                        }
                    //}
                            ?>
                        </div>
                    </div>
            <?php
            }
            ?>
                    <div class="row justify-content-center mt-1 id_employee" >
                        <div class="col-sm-4">
                            <div class="form-group" >
                                <!-- <label for=""><?php echo $form->labelEx($users, 'username'); ?></label> -->
                                <label for=""><?php echo $label->label_employee_id ; ?><font color="red">*</font></label>
                                <?php echo $form->textField($users, 'username', array('class' => 'form-control user_ID', 'placeholder' => $label->label_employee_id,'maxlength'=>'5','maxlength'=>'5', 'autocomplete' => 'off')); ?>
                                <?php echo $form->error($users, 'username', array('class' => 'error2')); ?>
                                <!-- <input type="text" class="form-control" id="" placeholder="ID พนักงาน"> -->
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div id="office-section">
                   <!--      <div class="row  mb-1 " id="employee_type_1" >
                            <div class="col-md-3 col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Employee section ':'ส่วนของพนักงาน'; ?><font color="red">*</font></strong></div>
                            <div class="col-sm-12 col-xs-12 col-md-8">
                                <div class="form-group">

                                    <span></span>
                                    <div class="radio radio-danger radio-inline emp">
                                        <input type="radio" name="type_employee" id="card-7" value="2" <?php if ($profile->type_employee == 2) : ?> checked="checked" <?php endif ?>>

                                        <label for="card-7" class="bg-success text-black"> <?php echo $label->label_office ?> </label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input type="radio" name="type_employee" id="card-8" value="1" <?php if ($profile->type_employee == 1) : ?> checked="checked" <?php endif ?>>

                                        <label for="card-8" class="bg-danger text-black"><?php echo $label->label_ship ?> </label>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="row justify-content-center mb-1 pb-20" id="employee_detail">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo $label->label_company; ?><font color="red">*</font></label>
                                    <?php

                                    $criteria= new CDbCriteria;
                                    $criteria->compare('type_employee_id','2'); // office
                                    //$criteria->compare('type_employee_id','5');
                                    $criteria->compare('active','y');
                                    $criteria->order = 'sortOrder ASC';
                                    $departmentModel = Department::model()->findAll($criteria);
                                    $departmentList = CHtml::listData($departmentModel, 'id', 'dep_title');
                                    $departmentOption = array('class' => 'form-control department', 'empty' => $label->label_placeholder_company, 'disabled' => $users->isNewRecord == true? false : true);
                                    ?>
                                    <?php
                                    echo $form->dropDownList($users, 'department_id', $departmentList, $departmentOption );
                                    ?>
                                    <?php //echo $form->error($users, 'department_id', array('class' => 'error2')); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label_position"><?php echo $label->label_position; ?></label>
                                    <?php

                                    $criteria= new CDbCriteria;
                                    $criteria->compare('active','y');
                                    $criteria->order = 'sortOrder ASC';
                                    $positionModel = Position::model()->findAll($criteria);
                                    $positionList = CHtml::listData($positionModel, 'id', 'position_title');
                                    $positiontOption = array('class' => 'form-control position', 'empty' => $label->label_placeholder_position, 'disabled' => $users->isNewRecord == true? false : true);
                                    ?>
                                    <?php
                                    echo $form->dropDownList($users, 'position_id', $positionList, $positiontOption); ?>
                                    <?php //echo $form->error($users, 'position_id', array('class' => 'error2')); ?>

                                </div>
                            </div>

                            <div class="col-md-8 label_branch">
                                <div class="form-group">
                                    <label><?php echo $label->label_branch; ?> </label>
                                    <?php
                // $BranchModel = Branch::model()->findAll(array(
                //     "condition" => " active = 'y'"

                // ));
                                    $criteria= new CDbCriteria;
                                    $criteria->compare('active','y');
                                    $criteria->order = 'sortOrder ASC';
                                    $BranchModel = Branch::model()->findAll($criteria);
                                    $BranchList = CHtml::listData($BranchModel, 'id', 'branch_name');
                                    $BranchOption = array('class' => 'form-control Branch', 'empty' => $label->label_placeholder_branch, 'disabled' => $users->isNewRecord == true? false : true );
                                    ?>
                                    <?php
                                    echo $form->dropDownList($users, 'branch_id', $BranchList, $BranchOption);
                                    ?>
                                    <?php echo $form->error($users, 'branch_id', array('class' => 'error2')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="topic-register form_name"><i class="fas fa-user-edit"></i> <?= Yii::app()->session['lang'] == 1?'Basic information ':'ข้อมูลพื้นฐาน'; ?></h4>

                    <div class="row justify-content-center form_name">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_title; ?>(TH)<font color="red">*</font></label>
                                <?php  $country = array('1' => 'นาย', '2' => 'นางสาว', '3' => 'นาง');?>
                                <?php
                                $htmlOptions = array('class' => 'form-control prefix', 'empty' => 'คำนำหน้า');
                                echo $form->dropDownList($profile, 'title_id', $country, $htmlOptions);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_firstname; ?>(TH)<font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control firstname', 'placeholder' => $label->label_firstname,'onkeyup'=>"isThaiEngchar(this.value,this)", 'autocomplete' => 'off')); ?>
                                <?php echo $form->error($profile, 'firstname', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_lastname; ?>(TH)<font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control lastname', 'placeholder' => $label->label_lastname,'onkeyup'=>"isThaiEngchar(this.value,this)", 'autocomplete' => 'off')); ?>
                                <?php echo $form->error($profile, 'lastname', array('class' => 'error2')); ?>
                                <!--<input type="text" class="form-control" id="">-->
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="row justify-content-center bb-1 pb-20 mt-20 form_name_eng">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_title; ?>(EN)<font color="red">*</font></label>
                                <?php  $country2 = array('1' => 'Mr.', '2' => 'Miss.', '3' => 'Mrs.'); ?>
                                <?php
                                $htmlOptions = array('class' => 'form-control prefix_en', 'empty' => 'Prefix');
                                echo $form->dropDownList($profile, 'title_id', $country2, $htmlOptions);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_firstname; ?>(EN)<font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'firstname_en', array('class' => 'form-control firstname_en', 'placeholder' => $label->label_firstname,'onkeyup'=>"isEngchar(this.value,this)", 'autocomplete' => 'off')); ?>
                                <?php echo $form->error($profile, 'firstname_en', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_lastname; ?>(EN)<font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'lastname_en', array('class' => 'form-control lastname_en', 'placeholder' => $label->label_lastname,'onkeyup'=>"isEngchar(this.value,this)", 'autocomplete' => 'off')); ?>
                                <?php echo $form->error($profile, 'lastname_en', array('class' => 'error2')); ?>
                                <!--<input type="text" class="form-control" id="">-->
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>


            <div class="row justify-content-center mt-1 mb-1 form_number_id">
                <div class="form-group">
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="type_card" id="card-1" value="l" <?php if ($profile->type_card == "l") : ?> checked="checked" <?php endif ?>>
                        <label for="card-1" class="bg-success text-black"><?php echo $label->label_identification; ?> </label>
                    </div>

                    <div class="radio radio-danger radio-inline">
                        <input type="radio" name="type_card" id="card-2" value="p" <?php if ($profile->type_card == "p") : ?> checked="checked" <?php endif ?>>
                        <label for="card-2" class="bg-danger text-black"><?php echo $label->label_passport; ?> </label>
                    </div>
                </div>
            </div> 


            <div class="row justify-content-center form_identification">
                <div class="col-md-4 col-sm-6 col-xs-12" >
                    <div class="form-group" id="identification_card"> 
                        <label> <?php echo $label->label_identification;?><font class="required_identification" color="red">*</font></label>
                        <?php echo $form->textField($profile, 'identification', array('class' => 'form-control idcard', 'name' => 'idcard', 'maxlength' => '13', 'onKeyPress' => 'return check_number();', 'placeholder' => $label->label_identification )); ?>
                        <?php echo $form->error($profile, 'identification', array('class' => 'error2')); ?>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group birthday-icon">
                        <label> <?php echo $label->label_date_of_expiry;?><font class="required_date_of_expiry" color="red">*</font></label>
                        <?php echo $form->textField($profile, 'date_of_expiry', $attTime); ?>
                        <?php echo $form->error($profile, 'date_of_expiry', array('class' => 'error2')); ?>
                        <i class="far fa-calendar-alt"></i>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="row justify-content-center form_identification_5">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label><?php echo $label->label_place_issued;?></label>
                        <?php echo $form->textField($profile, 'place_issued',array('class' => 'form-control', 'placeholder' =>$label->label_place_issued )); ?>
                        <?php echo $form->error($profile, 'place_issued', array('class' => 'error2')); ?>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group birthday-icon">
                        <i class="far fa-calendar-alt"></i>
                        <label><?php echo $label->label_date_issued;?></label>
                        <?php echo $form->textField($profile, 'date_issued',$date_issueds); ?>
                        <?php echo $form->error($profile, 'date_issued', array('class' => 'error2')); ?>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="row  mt-1 mb-1 form_attach_identification">
                <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_FileAttachIdentification;?></strong></div>
                <div class="col-md-4">
                    <div class="form-group">
                       <div class="input-append">
                        <div class="">
                            <?php echo $form->fileField($AttachName, 'attach_identification', array('id'=>"wizard-picture")); ?> 
                        </div>
                    </div>
                    <?php echo $form->error($AttachName, 'attach_identification'); ?>
                    <?php 
                    $identification = Yii::app()->getUploadUrl('attach');
                    $criteria = new CDbCriteria;
                    $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                    $criteria->addCondition("active ='y'");
                    $criteria->addCondition("file_data ='3'");
                    $Attach_identification_File = AttachFile::model()->find($criteria);
                    if (isset($Attach_identification_File)) {
                        echo '<strong id="file_identificationtext'.$Attach_identification_File->id.'">'.$Attach_identification_File->filename.'</strong>';
                        echo '<input id="filename_attach_identification'.$Attach_identification_File->id.'" 
                        class="form-control"
                        type="text" value="'.$Attach_identification_File->filename.'" 
                        style="display:none;" 
                        onblur="editNameidentification('.$Attach_identification_File->id.');">'; 
                        echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                            'id'=>'btnEditName_attach_identification'.$Attach_identification_File->id,
                            'class'=>'btn-action glyphicons pencil btn-danger',
                            'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                            'onclick'=>'$("#file_identificationtext'.$Attach_identification_File->id.'").hide(); 
                            $("#filename_attach_identification'.$Attach_identification_File->id.'").show(); 
                            $("#filename_attach_identification'.$Attach_identification_File->id.'").focus(); 
                            $("#btnEditName_attach_identification'.$Attach_identification_File->id.'").hide(); ')); 

                        echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                            'id'=>'btnSaveName_attach_identification'.$Attach_identification_File->id,
                            'class'=>'btn-action glyphicons btn-danger remove_2',
                            'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                            'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFileidentification("'.$Attach_identification_File->id.'"); }'));

                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row justify-content-center form_passport">
            <div class="col-md-4 col-sm-6 col-xs-12" >
                <div class="form-group">
                    <label><?php echo $label->label_passport;?><font color="red">*</font></label>
                    <?php echo $form->textField($profile, 'passport', array('class' => 'form-control passport', 'name' => 'passport', 'placeholder' => $label->label_passport,'onkeyup'=>"isPassportchar(this.value,this)")); ?>
                    <?php echo $form->error($profile, 'passport', array('class' => 'error2')); ?>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group birthday-icon">
                    <label> <?php echo $label->label_date_of_expiry;?><font color="red">*</font></label>
                    <?php echo $form->textField($profile, 'pass_expire', $attTime); ?>
                    <?php echo $form->error($profile, 'pass_expire', array('class' => 'error2')); ?>
                    <i class="far fa-calendar-alt"></i>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
        <div class="row justify-content-center form_passport_5">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label><?php echo $label->label_place_issued;?></label>
                    <?php echo $form->textField($profile, 'passport_place_issued',array('class' => 'form-control', 'placeholder' =>$label->label_place_issued )); ?>
                    <?php echo $form->error($profile, 'passport_place_issued', array('class' => 'error2')); ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group birthday-icon">
                    <i class="far fa-calendar-alt"></i>
                    <label><?php echo $label->label_date_issued;?></label>
                    <?php echo $form->textField($profile, 'passport_date_issued',$date_issueds); ?>
                    <?php echo $form->error($profile, 'passport_date_issued', array('class' => 'error2')); ?>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
        <div class="row  mt-1 mb-1 form_attach_passport">
            <div class="col-md-3 text-right-md"><strong><?php echo $label->label_FileAttachPassport;?></strong></div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-append">

                        <div class="">
                            <?php echo $form->fileField($AttachName, 'attach_passport', array('id' => 'wizard-picture')); ?>
                        </div>
                    </div>
                </div>
                <?php echo $form->error($AttachName, 'attach_passport'); ?>
                <?php 
                $passport = Yii::app()->getUploadUrl('attach');
                $criteria = new CDbCriteria;
                $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                $criteria->addCondition("active ='y'");
                $criteria->addCondition("file_data ='1'");
                $Attach_passport_File = AttachFile::model()->find($criteria);
                if (isset($Attach_passport_File)) {
                    echo '<strong id="file_attach_passporttext'.$Attach_passport_File->id.'">'.$Attach_passport_File->filename.'</strong>';
                    echo '<input id="filename_attach_passport'.$Attach_passport_File->id.'" 
                    class="form-control"
                    type="text" value="'.$Attach_passport_File->filename.'" 
                    style="display:none;" 
                    onblur="editNamepassport('.$Attach_passport_File->id.');">'; 
                    echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                        'id'=>'btnEditName_attach_passport'.$Attach_passport_File->id,
                        'class'=>'btn-action glyphicons pencil btn-danger',
                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                        'onclick'=>'$("#file_attach_passporttext'.$Attach_passport_File->id.'").hide(); 
                        $("#filename_attach_passport'.$Attach_passport_File->id.'").show(); 
                        $("#filename_attach_passport'.$Attach_passport_File->id.'").focus(); 
                        $("#btnEditName_attach_passport'.$Attach_passport_File->id.'").hide(); ')); 

                    echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                        'id'=>'btnSaveName_attach_passport'.$Attach_passport_File->id,
                        'class'=>'btn-action glyphicons btn-danger remove_2',
                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFilepassport("'.$Attach_passport_File->id.'"); }'));
                }
                ?>
            </div>
        </div>

        <div class="row justify-content-center form_seamanbook">
            <div class="col-md-4 col-sm-6 col-xs-12" >
                <div class="form-group">
                    <label><?php echo $label->label_seamanbook;?><font color="red">*</font></label>
                    <?php echo $form->textField($profile, 'seamanbook', array('class' => 'form-control', 'placeholder' => $label->label_seamanbook)); ?>
                    <?php echo $form->error($profile, 'seamanbook', array('class' => 'error2')); ?>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group birthday-icon">
                    <i class="far fa-calendar-alt"></i>
                    <label><?php echo $label->label_date_of_expiry;?><font color="red">*</font></label>
                    <?php echo $form->textField($profile, 'seaman_expire', $attTime); ?>
                    <?php echo $form->error($profile, 'seaman_expire', array('class' => 'error2')); ?>
                </div>
            </div>                    
            <div class="clearfix"></div>
        </div>
        <div class="row  mt-1 mb-1 form_attach_crew_identification">
            <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_FileAttachCrewIdentification;?></strong></div>
            <div class="col-md-4">
                <div class="form-group">

                 <div class="input-append">
                    <div class="">
                        <?php echo $form->fileField($AttachName, 'attach_crew_identification', array('id' => 'wizard-picture')); ?>
                    </div>
                </div>
                <?php echo $form->error($AttachName, 'attach_crew_identification'); ?>
                <?php 
                $crew_identification = Yii::app()->getUploadUrl('attach');
                $criteria = new CDbCriteria;
                $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
                $criteria->addCondition("active ='y'");
                $criteria->addCondition("file_data ='2'");
                $Attach_crew_identification_File = AttachFile::model()->find($criteria);
                if (isset($Attach_crew_identification_File)) {
                    echo '<strong id="file_crew_identificationtext'.$Attach_crew_identification_File->id.'">'.$Attach_crew_identification_File->filename.'</strong>';
                    echo '<input id="filename_attach_crew_identification'.$Attach_crew_identification_File->id.'" 
                    class="form-control"
                    type="text" value="'.$Attach_crew_identification_File->filename.'" 
                    style="display:none;" 
                    onblur="editNamecrew_identification('.$Attach_crew_identification_File->id.');">'; 
                    echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                        'id'=>'btnEditName_attach_crew_identification'.$Attach_crew_identification_File->id,
                        'class'=>'btn-action glyphicons pencil btn-danger',
                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                        'onclick'=>'$("#file_crew_identificationtext'.$Attach_crew_identification_File->id.'").hide(); 
                        $("#filename_attach_crew_identification'.$Attach_crew_identification_File->id.'").show(); 
                        $("#filename_attach_crew_identification'.$Attach_crew_identification_File->id.'").focus(); 
                        $("#btnEditName_attach_crew_identification'.$Attach_crew_identification_File->id.'").hide(); ')); 

                    echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                        'id'=>'btnSaveName_attach_crew_identification'.$Attach_crew_identification_File->id,
                        'class'=>'btn-action glyphicons btn-danger remove_2',
                        'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                        'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFilecrew_identification("'.$Attach_crew_identification_File->id.'"); }'));
                }
                ?>
            </div>
        </div>
    </div> 
    <div class="row  mt-1 mb-1 bb-1 pb-20 mt-20 form_attach_house_registration">
        <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_AttachCopiesOfHousePaticular;?></strong></div>
        <div class="col-md-4">
            <div class="form-group">

              <div class="input-append">
                <div class="">
                    <?php echo $form->fileField($AttachName, 'attach_house_registration', array('id'=>"wizard-picture")); ?>
                </div>
            </div>
            <?php echo $form->error($AttachName, 'attach_house_registration'); ?>
            <?php 
            $house_registration = Yii::app()->getUploadUrl('attach');
            $criteria = new CDbCriteria;
            $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
            $criteria->addCondition("active ='y'");
            $criteria->addCondition("file_data ='4'");
            $Attach_house_registration_File = AttachFile::model()->find($criteria);
            if (isset($Attach_house_registration_File)) {
                echo '<strong id="file_house_registrationtext'.$Attach_house_registration_File->id.'">'.$Attach_house_registration_File->filename.'</strong>';
                echo '<input id="filename_attach_house_registration'.$Attach_house_registration_File->id.'" 
                class="form-control"
                type="text" value="'.$Attach_house_registration_File->filename.'" 
                style="display:none;" 
                onblur="editNamehouse_registration('.$Attach_house_registration_File->id.');">'; 
                echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                    'id'=>'btnEditName_attach_house_registration'.$Attach_house_registration_File->id,
                    'class'=>'btn-action glyphicons pencil btn-danger',
                    'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                    'onclick'=>'$("#file_house_registrationtext'.$Attach_house_registration_File->id.'").hide(); 
                    $("#filename_attach_house_registration'.$Attach_house_registration_File->id.'").show(); 
                    $("#filename_attach_house_registration'.$Attach_house_registration_File->id.'").focus(); 
                    $("#btnEditName_attach_house_registration'.$Attach_house_registration_File->id.'").hide(); ')); 

                echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                    'id'=>'btnSaveName_attach_house_registration'.$Attach_house_registration_File->id,
                    'class'=>'btn-action glyphicons btn-danger remove_2',
                    'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                    'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFilehouse_registration("'.$Attach_house_registration_File->id.'"); }'));
            }
            ?>
        </div>
    </div>
</div>


<div class="row justify-content-center mt-20 form_birthday">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group birthday-icon">
            <i class="far fa-calendar-alt"></i>
            <label><?php echo $label->label_birthday; ?><font color="red">*</font></label>
            <?php echo $form->textField($profile, 'birthday', $birthday); ?>
            <?php echo $form->error($profile, 'birthday', array('class' => 'error2')); ?>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="form-group">
            <label><?php echo $label->label_age; ?></label>
            <?php echo $form->textField($profile, 'age', array('class' => 'form-control ages', 'placeholder' => $label->label_age,'readonly'=>true )); ?>
            <?php echo $form->error($profile, 'age', array('class' => 'error2')); ?>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="form-group">
            <label><?php echo $label->label_month; ?></label>
            <?php echo $form->textField($profile, 'mouth_birth', array('class' => 'form-control mouth', 'placeholder' => Yii::app()->session['lang'] == 1?'Month':'เดือน','readonly'=>true )); ?>
            <?php echo $form->error($profile, 'mouth_birth', array('class' => 'error2')); ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="row justify-content-center form_place_of_birth">
   <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">

        <label><?php echo $label->label_place_of_birth; ?></label>
        <?php echo $form->textField($profile, 'place_of_birth', array('class' => 'form-control', 'placeholder' =>$label->label_place_of_birth)); ?>
        <?php echo $form->error($profile, 'place_of_birth', array('class' => 'error2')); ?>
    </div>
</div> 

<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">

        <label><?php echo $label->label_blood; ?><font class="required_Blood" color="red">*</font></label>
        <?php echo $form->textField($profile, 'blood', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Blood type ':'กรุ๊ปเลือด')); ?>
        <?php echo $form->error($profile, 'blood', array('class' => 'error2')); ?>
    </div>
</div>

<div class="clearfix"></div>
</div>
<div class="row justify-content-center form_body">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">

            <label><?php echo $label->label_height; ?><font class="required_Height" color="red">*</font></label>
            <?php echo $form->textField($profile, 'hight', array('class' => 'form-control', 'placeholder' =>Yii::app()->session['lang'] == 1?'Height ':'ส่วนสูง','onkeyup'=>"isNumberchar(this.value,this)", 'maxlength' => '3')); ?>
            <?php echo $form->error($profile, 'hight', array('class' => 'error2')); ?>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">

            <label><?php echo $label->label_weight; ?><font class="required_Weight" color="red">*</font></label>
            <?php echo $form->textField($profile, 'weight', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Weight ':'น้ำหนัก','onkeyup'=>"isNumberchar(this.value,this)", 'maxlength' => '3')); ?>
            <?php echo $form->error($profile, 'weight', array('class' => 'error2')); ?>
        </div>
    </div>

    <div class="clearfix"></div>
</div>
                <!--     <div class="row justify-content-center form_name">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                
                                <label><?= Yii::app()->session['lang'] == 1?'Hair color ':'สีผม'; ?></label>
                                <?php echo $form->textField($profile, 'hair_color', array('class' => 'form-control', 'placeholder' =>Yii::app()->session['lang'] == 1?'Hair color ':'สีผม')); ?>
                                <?php echo $form->error($profile, 'hair_color', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
   
                                <label><?= Yii::app()->session['lang'] == 1?'Eye color':'สีตา'; ?></label>
                                <?php echo $form->textField($profile, 'eye_color', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Eye color':'สีตา')); ?>
                                <?php echo $form->error($profile, 'eye_color', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div> -->

                    <div class="row justify-content-center form_race">
                        <div class="col-md-4 col-sm-6 col-xs-12 form_race_13">
                            <div class="form-group form_race_13">

                                <label><?php echo $label->label_race; ?><font class="required_race" color="red">*</font></label>
                                <?php echo $form->textField($profile, 'race', array('class' => 'form-control', 'placeholder' => $label->label_race)); ?>
                                <?php echo $form->error($profile, 'race', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">

                                <label><?php echo $label->label_nationality; ?><font class="required_nationality" color="red">*</font></label>
                                <?php echo $form->textField($profile, 'nationality', array('class' => 'form-control', 'placeholder' => $label->label_nationality)); ?>
                                <?php echo $form->error($profile, 'nationality', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form_phone_5">
                            <div class="form-group ">
                                <label><?php echo $label->label_phone; ?><font color="red">*</font></label>
                                <?php echo $form->textField($profile, 'phone2', array('class' => 'form-control tel_5', 'placeholder' => $label->label_phone,'onkeyup'=>"isNumberchar(this.value,this)")); ?>
                                <?php echo $form->error($profile, 'phone2', array('class' => 'error2')); ?>

                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="row justify-content-center form_religion">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                            <!-- <label for="">ศาสนา</label>
                                <input type="text" class="form-control" id="" placeholder="เชื้อชาติ"> -->
                                <label><?php echo $label->label_religion; ?></label>
                                <?php echo $form->textField($profile, 'religion', array('class' => 'form-control', 'placeholder' => $label->label_religion)); ?>
                                <?php echo $form->error($profile, 'religion', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php echo $label->label_sex; ?><font class="required_sex" color="red">*</font></label>
                                <?php
                                $sex_list = array('Male' => $label->label_male, 'Female' => $label->label_female);
                                $sex_Option = array('class' => 'form-control', 'empty' => $label->label_sex);
                                ?>
                                <?php
                                echo $form->dropDownList($profile, 'sex', $sex_list, $sex_Option);
                                ?>
                                <?php echo $form->error($profile, 'sex', array('class' => 'error2')); ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                  <!--   <div class="row justify-content-center form_name">
                       <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">

                            <label><?php echo $label->label_ss_card; ?></label>
                            <?php echo $form->textField($profile, 'ss_card', array('class' => 'form-control', 'placeholder' =>$label->label_ss_card,'onkeyup'=>"isNumberchar(this.value,this)")); ?>
                            <?php echo $form->error($profile, 'ss_card', array('class' => 'error2')); ?>
                        </div>
                    </div> 

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">

                            <label><?php echo $label->label_tax_payer; ?></label>
                            <?php echo $form->textField($profile, 'tax_payer', array('class' => 'form-control', 'placeholder' => $label->label_tax_payer,'onkeyup'=>"isNumberchar(this.value,this)", 'maxlength' => '13')); ?>
                            <?php echo $form->error($profile, 'tax_payer', array('class' => 'error2')); ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            -->
            <div class="row  mt-1 mb-1 form_marital_status">
                <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_marital_status; ?><font class="required_marital_status" color="red">*</font></strong></div>
                <div class="col-md-3">
                    <div class="form-group">

                        <span></span>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="status_sm" id="card-3" value="s" <?php if ($profile->status_sm == "s") : ?> checked="checked" <?php endif ?>>
                            <label for="card-3" class="bg-success text-black"> <?php echo $label->label_single; ?> </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="status_sm" id="card-4" value="m" <?php if ($profile->status_sm == "m") : ?> checked="checked" <?php endif ?>>
                            <label for="card-4" class="bg-danger text-black"><?php echo $label->label_marry; ?> </label>
                        </div>
                    </div>
                </div>
               
            <div class="text-right-md"><label><?php echo $label->label_number_of_children;  ?></label></div>
            <div class="col-md-3">
                    <div class="form-group">
                        
                        <?php echo $form->textField($profile, 'number_of_children', array('class' => 'form-control children', 'placeholder' => $label->label_number_of_children, 'maxlength' => '2')); ?>
                        <?php echo $form->error($profile, 'number_of_children', array('class' => 'error2')); ?>

                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="row justify-content-center Spouse">
               <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">

                    <label><?php echo $label->label_spouse_firstname; ?><font color="red">*</font></label>
                    <?php echo $form->textField($profile, 'spouse_firstname', array('class' => 'form-control', 'placeholder' =>$label->label_spouse_firstname)); ?>
                    <?php echo $form->error($profile, 'spouse_firstname', array('class' => 'error2')); ?>
                </div>
            </div> 

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">

                    <label><?php echo $label->label_spouse_lastname; ?><font color="red">*</font></label>
                    <?php echo $form->textField($profile, 'spouse_lastname', array('class' => 'form-control', 'placeholder' => $label->label_spouse_lastname)); ?>
                    <?php echo $form->error($profile, 'spouse_lastname', array('class' => 'error2')); ?>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">

                    <label><?php echo $label->label_occupation; ?></label>
                    <?php echo $form->textField($profile, 'occupation_spouse', array('class' => 'form-control', 'placeholder' => $label->label_occupation)); ?>
                    <?php echo $form->error($profile, 'occupation_spouse', array('class' => 'error2')); ?>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
        <div class="row justify-content-center form_father">
           <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">

                <label><?php echo $label->label_father_firstname; ?><font class="required_father_firstname" color="red">*</font></label>
                <?php echo $form->textField($profile, 'father_firstname', array('class' => 'form-control', 'placeholder' =>$label->label_father_firstname)); ?>
                <?php echo $form->error($profile, 'father_firstname', array('class' => 'error2')); ?>
            </div>
        </div> 

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">

                <label><?php echo $label->label_father_lastname; ?><font class="required_father_lastname" color="red">*</font></label>
                <?php echo $form->textField($profile, 'father_lastname', array('class' => 'form-control', 'placeholder' => $label->label_father_lastname)); ?>
                <?php echo $form->error($profile, 'father_lastname', array('class' => 'error2')); ?>
            </div>
        </div>

        <div class="col-md-2 col-sm-6 col-xs-12">
            <div class="form-group">

                <label><?php echo $label->label_occupation; ?></label>
                <?php echo $form->textField($profile, 'occupation_father', array('class' => 'form-control', 'placeholder' => $label->label_occupation)); ?>
                <?php echo $form->error($profile, 'occupation_father', array('class' => 'error2')); ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row justify-content-center form_mother">
       <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="form-group">

            <label><?php echo $label->label_mother_firstname; ?><font class="required_mother_firstname" color="red">*</font></label>
            <?php echo $form->textField($profile, 'mother_firstname', array('class' => 'form-control', 'placeholder' =>$label->label_mother_firstname)); ?>
            <?php echo $form->error($profile, 'mother_firstname', array('class' => 'error2')); ?>
        </div>
    </div> 

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="form-group">

            <label><?php echo $label->label_mother_lastname; ?><font class="required_mother_lastname" color="red">*</font></label>
            <?php echo $form->textField($profile, 'mother_lastname', array('class' => 'form-control', 'placeholder' => $label->label_mother_lastname)); ?>
            <?php echo $form->error($profile, 'mother_lastname', array('class' => 'error2')); ?>
        </div>
    </div>

    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="form-group">

            <label><?php echo $label->label_occupation; ?></label>
            <?php echo $form->textField($profile, 'occupation_mother', array('class' => 'form-control', 'placeholder' => $label->label_occupation)); ?>
            <?php echo $form->error($profile, 'occupation_mother', array('class' => 'error2')); ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="row  mt-1 mb-1 form_accommodation">
    <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_accommodation; ?><font class="required_accommodation" color="red">*</font></strong></div>
    <div class="col-md-6 col-xs-12">
        <div class="form-group">

            <span></span>
            <div class="radio radio-danger radio-inline">
                <input type="radio" name="accommodation" id="accommodation_1" value="own house" <?php if ($profile->accommodation == "own house") : ?> checked="checked" <?php endif ?>>
                <label for="accommodation_1" class="bg-success text-black"><?php echo $label->label_OwnHouse; ?> </label>
            </div>
            <div class="radio radio-danger radio-inline">
                <input type="radio" name="accommodation" id="accommodation_2" value="rent house" <?php if ($profile->accommodation == "rent house") : ?> checked="checked" <?php endif ?>>
                <label for="accommodation_2" class="bg-danger text-black"><?php echo $label->label_RentHouse; ?> </label>
            </div>
            <div class="radio radio-danger radio-inline">
                <input type="radio" name="accommodation" id="accommodation_3" value="with parents" <?php if ($profile->accommodation == "with parents") : ?> checked="checked" <?php endif ?>>
                <label for="accommodation_3" class="bg-danger text-black"><?php echo $label->label_WithParents; ?> </label>
            </div>
            <div class="radio radio-danger radio-inline">
                <input type="radio" name="accommodation" id="accommodation_4" value="apartment" <?php if ($profile->accommodation == "apartment") : ?> checked="checked" <?php endif ?>>
                <label for="accommodation_4" class="bg-danger text-black"><?php echo $label->label_Apartment; ?> </label>
            </div>
            <div class="radio radio-danger radio-inline">
                <input type="radio" name="accommodation" id="accommodation_5" value="with relative" <?php if ($profile->accommodation == "with relative") : ?> checked="checked" <?php endif ?>>
                <label for="accommodation_5" class="bg-danger text-black"><?php echo $label->label_WithRelative; ?> </label>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center form_domicile_address">
    <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="form-group">

            <label><?php echo $label->label_domicile_address; ?><font class="required_domicile_address" color="red">*</font></label>
            <?php echo $form->textArea($profile, 'domicile_address', array('class' => 'form-control', 'cols' => "30", 'rows' => "3", 'placeholder' => $label->label_domicile_address)); ?>
            <?php echo $form->error($profile, 'domicile_address', array('class' => 'error2')); ?>

        </div>
    </div>

    <div class="clearfix"></div>
</div>
<!-- <div class="row justify-content-center form_name">
    <div class="col-md-8 col-sm-12 col-xs-12">
        
    </div>
</div> -->
<div class="row justify-content-center form_address">
    <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="form-group">

            <label><?php echo $label->label_address; ?><font class="required_address" color="red">*</font></label>&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="checkbox checkbox-danger checkbox-inline">
                <input type="checkbox" name="address_parent" id="address_parent" value="y" <?php if ($profile->address_parent == "y") : ?> checked="checked" <?php endif ?>>
                <label for="address_parent" class="bg-danger text-black"><?php echo $label->label_addressParent; ?> </label>
            </div>
            <?php echo $form->textArea($profile, 'address', array('class' => 'form-control', 'cols' => "30", 'rows' => "3", 'placeholder' => $label->label_address)); ?>
            <?php echo $form->error($profile, 'address', array('class' => 'error2')); ?>

        </div>
    </div>

    <div class="clearfix"></div>
</div>

<div class="row justify-content-center form_tel">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label><?php echo $label->label_phone; ?><font color="red">*</font></label>
            <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => $label->label_phone,'onkeyup'=>"isNumberchar(this.value,this)", 'autocomplete'=>'chrome-off')); ?>
            <?php echo $form->error($profile, 'tel', array('class' => 'error2')); ?>

        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12 ">
        <div class="form-group">
            <label><?php echo $label->label_tel; ?><font class="required_Emergency" color="red">*</font></label>
            <?php echo $form->textField($profile, 'phone', array('class' => 'form-control', 'placeholder' => $label->label_tel,'onkeyup'=>"isNumberchar(this.value,this)", 'autocomplete'=>'chrome-off')); ?>
            <?php echo $form->error($profile, 'phone', array('class' => 'error2')); ?>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="row justify-content-center form_occupation_sex">
 <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <label for=""><?php echo $label->label_sex; ?><font color="red">*</font></label>
        <?php
        $sex_list = array('Male' => $label->label_male, 'Female' => $label->label_female);
        $sex_Option = array('class' => 'form-control sex_5', 'empty' => $label->label_sex);
        ?>
        <?php
        echo $form->dropDownList($profile, 'sex', $sex_list, $sex_Option);
        ?>
        <?php echo $form->error($profile, 'sex', array('class' => 'error2')); ?>
    </div>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <label><?php echo $label->label_occupation; ?><font class="required_occupation" color="red">*</font></label>
        <?php echo $form->textField($profile, 'occupation', array('class' => 'form-control occupation_5', 'placeholder' => $label->label_occupation)); ?>
        <?php echo $form->error($profile, 'occupation', array('class' => 'error2')); ?>

    </div>
</div>
<div class="clearfix"></div>
</div>
<div class="row justify-content-center form_emergency">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label><?php echo $label->label_name_emergency; ?><font class="required_name_emergency" color="red">*</font></label>
            <?php echo $form->textField($profile, 'name_emergency', array('class' => 'form-control', 'placeholder' => $label->label_name_emergency)); ?>
            <?php echo $form->error($profile, 'name_emergency', array('class' => 'error2')); ?>

        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <label><?php echo $label->label_relationship_emergency; ?><font class="required_relationship_emergency" color="red">*</font></label>
            <?php echo $form->textField($profile, 'relationship_emergency', array('class' => 'form-control', 'placeholder' => $label->label_relationship_emergency)); ?>
            <?php echo $form->error($profile, 'relationship_emergency', array('class' => 'error2')); ?>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="row justify-content-center form_email">

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
                            <!-- <label for="">Email</label>
                                <input type="text" class="form-control" id="" placeholder="Email"> -->
                                <label><?php echo $label->label_email; ?><font color="red">*</font></label>
                                <?php echo $form->emailField($users, 'email', array('class' => 'form-control email', 'placeholder' => $label->label_email,'onkeyup'=>"isSpaces(this.value,this)")); ?>
                                <?php echo $form->error($users, 'email', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><?php echo $label->label_id_Line;  ?><font class="required_idline" color="red">*</font></label>
                                <?php echo $form->textField($profile, 'line_id', array('class' => 'form-control', 'placeholder' => $label->label_id_Line)); ?>
                                <?php echo $form->error($profile, 'line_id', array('class' => 'error2')); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row  mt-1 mb-1 form_military">
                     <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_military; ?><font class="required_military" color="red">*</font></strong></div>
                     <div class="col-md-6 col-xs-12">
                      <div class="form-group">

                        <span></span>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="military" id="military_1" value="enlisted" <?php if ($profile->military == "enlisted") : ?> checked="checked" <?php endif ?>>
                            <label for="military_1" class="bg-success text-black"><?php echo $label->label_Enlisted; ?> </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="military" id="military_2" value="not enlisted" <?php if ($profile->military == "not enlisted") : ?> checked="checked" <?php endif ?>>
                            <label for="military_2" class="bg-danger text-black"><?php echo $label->label_NotEnlisted; ?> </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="military" id="military_3" value="exempt" <?php if ($profile->military == "exempt") : ?> checked="checked" <?php endif ?>>
                            <label for="military_3" class="bg-danger text-black"><?php echo $label->label_Exempt; ?> </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row  mt-1 mb-1 form_history_of_severe_illness">
                <div class="col-md-3 text-right-md"> <strong><?php echo $label->label_history_of_severe_illness;  ?><font class="required_history_of_severe_illness" color="red">*</font></strong></div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">

                        <span></span>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="history_of_illness" id="card-5" value="n" <?php if ($profile->history_of_illness == "n") : ?> checked="checked" <?php endif ?>>
                            <label for="card-5" class="bg-success text-black"><?php echo $label->label_never;  ?> </label>
                        </div>
                        <div class="radio radio-danger radio-inline">
                            <input type="radio" name="history_of_illness" id="card-6" value="y" <?php if ($profile->history_of_illness == "y") : ?> checked="checked" <?php endif ?>>
                            <label for="card-6" class="bg-danger text-black"><?php echo $label->label_ever;  ?> </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center form_sickness">

                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label><?php echo $label->label_sickness;  ?><font color="red">*</font></label>
                        <?php echo $form->textField($profile, 'sickness', array('class' => 'form-control Sickness', 'placeholder' => $label->label_sickness)); ?>
                        <?php echo $form->error($profile, 'sickness', array('class' => 'error2')); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <?php

            $starting_year  = 2500;
            $ending_year = 543 + date('Y');
            if ($ending_year) {

                    for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                        // $year_edu[] = '<option value="'. $starting_year.'">'. $starting_year.'</option>';
                        $year_edu[] = $starting_year;
                 }                 
            }
                  if (!$ProfilesEdu->isNewRecord || $ProfilesEdu->isNewRecord == NULL) {
                echo "";
            } else { ?>
                <!-- <div class="col-sm-3 text-right"> <strong>ประวัติการศึกษา :</strong></div> -->
                <?php
            }
            $modelList = Education::model()->findAll(array("condition" => " active = 'y'"));

            if (Yii::app()->session['lang'] == 1) {
              $list = CHtml::listData($modelList, 'edu_id', 'edu_name_EN');
          }else{
              $list = CHtml::listData($modelList, 'edu_id', 'edu_name');
          }

          $att_Education = array('class' => 'form-control', 'empty' => $label->label_education_level);

          
        //   if ($ending_year) {

        //     for($starting_year; $starting_year <= $ending_year; $starting_year++) {
        //         $edu_lest  = "<option value=" echo $starting_year ">"echo $starting_year"</option>";
        //     }                 
        // }
        $graduation = array('class' => 'form-control', 'autocomplete' => 'off', 'empty' => $label->label_graduation_year);   
        if (!$ProfilesEdu->isNewRecord) { 
           if (empty($ProfilesEdu)) {
              $ProfilesEdu = new ProfilesEdu;
              ?>
              <div class="row form_Edu">
                <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?php echo $label->label_educational;  ?></strong></div>
                <div class="col-md-2 col-sm-6 col-xs-12 ">
                    <div class="form-group">
                        <?php echo CHtml::activeDropDownList($ProfilesEdu, '[0]edu_id', $list, $att_Education); ?>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 ">
                    <div class="form-group">
                        <?php echo $form->textField($ProfilesEdu, '[0]institution', array('class' => 'form-control', 'placeholder' => $label->label_academy)); ?>
                    </div>
                </div>

                <div class="col-md-2 col-sm-6 col-xs-12 ">
                    <div class="form-group">
                        <select class="form-control" autocomplete="off" id="ProfilesEdu_0_date_graduation" name="ProfilesEdu[0][date_graduation]">
                        <option value=""><?php echo $label->label_graduation_year; ?></option>
                       <?php
                        $starting_year  = 2500;
                        $ending_year = 543 + date('Y');
                      if ($ending_year) {

                       for($starting_year; $starting_year <= $ending_year; $starting_year++) {?>
                             <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                      <?php   }                 
                     }
                       ?>
                    </select>
                        <?php //echo CHtml::activeDropDownList($ProfilesEdu, '[0]date_graduation',$edu_lest ,$graduation); ?>
                    </div>
                </div>
            </div>


            <div class="add-study"></div>
        <?php  }else{
            ?>
            <div class="add-study">

             <?php foreach ($ProfilesEdu as $kedu => $valedu) {
               
                ?>

                <div class="row del_edu">
                    <div class="col-md-3 col-sm-12 text-right-md"> <strong><?php echo $label->label_educational;  ?></strong></div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <?php echo CHtml::activeDropDownList($valedu, '[' . $kedu . ']edu_id', $list, $att_Education); ?>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">

                            <?php echo $form->textField($valedu, '[' . $kedu . ']institution', array('class' => 'form-control', 'placeholder' => $label->label_academy)); ?>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                             <select class="form-control" autocomplete="off" id="ProfilesEdu_<?php echo $kedu ?>_date_graduation" name="ProfilesEdu[<?php echo $kedu ?>][date_graduation]">
                        <option value=""><?php echo $label->label_graduation_year; ?></option>
                       <?php
                        $starting_year  = 2500;
                        $ending_year = 543 + date('Y');
                        $year_gradution = $valedu['date_graduation'];
                       if ($ending_year) {
                       for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                           
                        ?>
                             <option value="<?php echo $starting_year;?>"<?php echo $starting_year == $year_gradution ? ' selected="selected"' : '' ?>><?php echo $starting_year; ?></option>
                       <?php   
                            } 
                        }               
                       ?>
                    </select>
                       
                        </div>
                    </div>
                    <span class="delete btn-danger" name="mytext[]"><i class="fas fa-minus-circle"></i><?= Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?> </span>

                </div>

            <?php } ?>
        </div>    
    <?php }} else {  ?>

        <div class="row form_Edu">
            <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?php echo $label->label_educational;  ?><font class="required_educational" color="red">*</font> <small class="text-danger d-block"><?= Yii::app()->session['lang'] == 1?'Add more than 1 ':'เพิ่มได้มากกว่า 1'; ?></small></strong></div>
            <div class="col-md-2 col-sm-6 col-xs-12 ">
                <div class="form-group">
                    <?php echo CHtml::activeDropDownList($ProfilesEdu, '[0]edu_id', $list, $att_Education); ?>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 ">
                <div class="form-group">
                    <?php echo $form->textField($ProfilesEdu, '[0]institution', array('class' => 'form-control', 'placeholder' => $label->label_academy)); ?>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-xs-12 ">
                <div class="form-group">
                    <select class="form-control" autocomplete="off" id="ProfilesEdu_0_date_graduation" name="ProfilesEdu[0][date_graduation]">
                        <option value=""><?php echo $label->label_graduation_year; ?></option>
                       <?php
                        $starting_year  = 2500;
                        $ending_year = 543 + date('Y');
                      if ($ending_year) {

                       for($starting_year; $starting_year <= $ending_year; $starting_year++) {?>
                             <option value="<?php echo $starting_year; ?>"><?php echo $starting_year; ?></option>
                      <?php   }                 
                     }
                       ?>
                    </select>
                    <?php //echo CHtml::activeDropDownList($ProfilesEdu, '[0]date_graduation',$edu_lest ,$graduation); ?>

                </div>
            </div>
        </div>


        <div class="add-study"></div>

        <?php
    }
    ?>

    <div class="row justify-content-center bb-1 pb-20 mt-20 form_Edu">
        <div class="col-md-3 col-sm-12  col-xs-12 text-center">
            <button class="btn btn-info btn-add add_form_field" type="button" id="moreFields">
                <span class="glyphicon glyphicon-plus"> </span> <?= Yii::app()->session['lang'] == 1?'Add education history ':'เพิ่มประวัติการศึกษา'; ?>
            </button>
        </div>
    </div>
    <?php if ($ProfilesWorkHistory->isNewRecord === null) { 
      if (empty($ProfilesWorkHistory)) {
       $ProfilesWorkHistory = new ProfilesWorkHistory;
       ?>
       <div class="row form_WorkHistory pt-20 ">
        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Work history ':'ประวัติการทำงาน'; ?></strong></div>
        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <?php echo $form->textField($ProfilesWorkHistory, '[0]company_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Company ':'บริษัท')); ?>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <?php echo $form->textField($ProfilesWorkHistory, '[0]position_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Position ':'ตำแหน่ง')); ?>
            </div>
        </div>
        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="form-group since-icon">
                <i class="far fa-calendar-alt"></i>
                <?php echo $form->textField($ProfilesWorkHistory, '[0]since_date', $Since); ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <?php echo $form->textField($ProfilesWorkHistory, '[0]reason_leaving', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Reason for leaving ':'สาเหตุที่ออก')); ?>
            </div>
        </div>
    </div>
    <div class="add-Work"></div>
<?php }else{ ?>
    <div class="add-Work">
        <?php
        foreach ($ProfilesWorkHistory as $keywh => $valwh) {

            ?>
            <div class="row del_work">
                <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Work history ':'ประวัติการทำงาน'; ?></strong></div>
                <div class="col-md-4 col-sm-6 col-xs-12 ">
                    <div class="form-group">
                        <?php echo $form->textField($valwh, '['.$keywh.']company_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Company ':'บริษัท')); ?>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 ">
                    <div class="form-group">
                        <?php echo $form->textField($valwh, '['.$keywh.']position_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Position ':'ตำแหน่ง')); ?>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
                <div class="col-md-4 col-sm-6 col-xs-12 ">
                    <div class="form-group since-icon">
                        <i class="far fa-calendar-alt"></i>
                        <?php echo $form->textField($valwh, '['.$keywh.']since_date', $Since); ?>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 ">
                    <div class="form-group">
                        <?php echo $form->textField($valwh, '['.$keywh.']reason_leaving', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Reason for leaving ':'สาเหตุที่ออก')); ?>
                    </div>
                </div>
                <span class="delete_work btn-danger" name="mytext[]"><i class="fas fa-minus-circle"></i><?= Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?> </span>
            </div>

        <?php } ?>
    </div>
<?php }} else {?>
    <div class="row form_WorkHistory pt-20" style="padding-top: 20px;">
        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Work history ':'ประวัติการทำงาน'; ?><small class="text-danger d-block"><?= Yii::app()->session['lang'] == 1?'Add more than 1 ':'เพิ่มได้มากกว่า 1'; ?></small></strong></div>
        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <?php echo $form->textField($ProfilesWorkHistory, '[0]company_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Company ':'บริษัท')); ?>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <?php echo $form->textField($ProfilesWorkHistory, '[0]position_name', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Position ':'ตำแหน่ง')); ?>
            </div>
        </div>
        <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="form-group since-icon">
                <i class="far fa-calendar-alt"></i>
                <?php echo $form->textField($ProfilesWorkHistory, '[0]since_date', $Since); ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 ">
            <div class="form-group">
                <?php echo $form->textField($ProfilesWorkHistory, '[0]reason_leaving', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Reason for leaving ':'สาเหตุที่ออก')); ?>
            </div>
        </div>
    </div>
    <div class="add-Work"></div>
<?php } ?>
<div class="row justify-content-center bb-1 pb-20 mt-20 form_WorkHistory">
    <div class="col-md-3 col-sm-12  col-xs-12 text-center">
        <button class="btn btn-info btn-add add_form_work" type="button" id="moreFieldsWork">
            <span class="glyphicon glyphicon-plus"> </span> <?= Yii::app()->session['lang'] == 1?'Add Work history ':'เพิ่มประวัติการทำงาน'; ?>
        </button>
    </div>
</div>

<div class="row lang-box bb-1 pb-20 mt-20 form_language">
    <div class="table-responsive w-100 t-regis-language">
      <table class="table">
         <thead>
             <tr>
                <th colspan="2"><?= Yii::app()->session['lang'] == 1?'Language ':'ภาษา'; ?><font color="red">*</font><small class="text-danger d-block"><?= Yii::app()->session['lang'] == 1?'Add more than 1 ':'เพิ่มได้มากกว่า 1'; ?></small></th>
                <th><?= Yii::app()->session['lang'] == 1?'Excellent ':'ดีมาก'; ?></th> 
                <th><?= Yii::app()->session['lang'] == 1?'Good ':'ดี'; ?></th>
                <th><?= Yii::app()->session['lang'] == 1?'Fair ':'พอใช้ได้'; ?></th>
                <th><?= Yii::app()->session['lang'] == 1?'Poor ':'ใช้ไม่ได้'; ?></th>
            </tr>
        </thead>
        <?php 
        if ($ProfilesLanguage->isNewRecord === null) { 
            $i = 1;
            if (!empty($ProfilesLanguage)) {
            foreach ($ProfilesLanguage as $keylg => $vallg) {
               $i++;
               $p = 1;
               $m = 1;
               ?> 
           <tbody class="group-language">
                <tr>
                 <td rowspan="2"><?php echo $form->textField($vallg,'['.$keylg.']language_name' , array('class' => 'form-control' ,'style'=>' width:100px;line-height:28px;padding: 20px 10px;','readonly'=>true)); ?></td>
                 <td><?= Yii::app()->session['lang'] == 1?'Written ':'เขียน'; ?></td>
                 <td>
                    <div class="radio radio-danger ">
                        <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][writes]" id="lang_w-<?php echo $i;echo$p++; ?>" value="4"<?php if ($vallg["writes"] == "4") : ?> checked="checked" <?php endif ?>>
                        <label for="lang_w-<?php echo $i;echo $m++; ?>"></label>
                    </div>
                </td>
                <td>
                    <div class="radio radio-danger ">
                        <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][writes]" id="lang_w-<?php echo $i;echo $p++; ?>" value="3"<?php if ($vallg["writes"] == "3") : ?> checked="checked" <?php endif ?>>
                        <label for="lang_w-<?php echo $i;echo $m++; ?>"></label>
                    </div>
                </td>
                <td>
                    <div class="radio radio-danger ">
                        <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][writes]" id="lang_w-<?php echo $i;echo $p++; ?>" value="2"<?php if ($vallg["writes"] == "2") : ?> checked="checked" <?php endif ?>>
                        <label for="lang_w-<?php echo $i;echo $m++; ?>"></label>
                    </div>
                </td>
                <td>
                    <div class="radio radio-danger ">
                        <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][writes]" id="lang_w-<?php echo $i;echo $p++; ?>" value="1"<?php if ($vallg["writes"] == "1") : ?> checked="checked" <?php endif ?>>
                        <label for="lang_w-<?php echo $i;echo $m++; ?>"></label>
                    </div>
                </td>
            </tr>
            <tr>
             <td><?= Yii::app()->session['lang'] == 1?'Spoken ':'พูด'; ?></td>
             <td>
                <div class="radio radio-danger ">
                    <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][spoken]" id="lang_s-<?php echo $i;echo $p++; ?>" value="4"<?php if ($vallg["spoken"] == "4") : ?> checked="checked" <?php endif ?>>
                    <label for="lang_s-<?php echo $i;echo $m++; ?>"></label>
                </div>
            </td>
            <td>
                <div class="radio radio-danger ">
                    <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][spoken]" id="lang_s-<?php echo $i;echo $p++; ?>" value="3"<?php if ($vallg["spoken"] == "3") : ?> checked="checked" <?php endif ?>>
                    <label for="lang_s-<?php echo $i;echo $m++; ?>"></label>
                </div>
            </td>
            <td>
                <div class="radio radio-danger ">
                    <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][spoken]" id="lang_s-<?php echo $i;echo $p++; ?>" value="2"<?php if ($vallg["spoken"] == "2") : ?> checked="checked" <?php endif ?>>
                    <label for="lang_s-<?php echo $i;echo $m++; ?>"></label>
                </div>
            </td>
            <td>
                <div class="radio radio-danger ">
                    <input type="radio" name="ProfilesLanguage[<?php echo $i; ?>][spoken]" id="lang_s-<?php echo $i;echo $p++; ?>" value="1"<?php if ($vallg["spoken"] == "1") : ?> checked="checked" <?php endif ?>>
                    <label for="lang_s-<?php echo $i;echo $m++; ?>"></label>
                </div>
            </td>
        </tr>
    </tbody>
<?php   }
    }else{ 
        $ProfilesLanguage = new ProfilesLanguage; 
        ?>
        <tbody class="group-language">
        <tr>
         <td rowspan="2" ><?php echo $form->textField($ProfilesLanguage, '[1]language_name', array('class' => 'form-control','value'=>'Thai' ,'style'=>'width:100px;line-height:28px;padding: 20px 10px;','readonly'=>true,'placeholder'=> Yii::app()->session['lang'] == 1?'Thai ':'ไทย')); ?></td>
         <td><?= Yii::app()->session['lang'] == 1?'Written ':'เขียน'; ?></td>
         <td>
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[1][writes]" id="lang_w_th-1" value="4"<?php if ($ProfilesLanguage->writes == "4") : ?> checked="checked" <?php endif ?>>
                <label for="lang_w_th-1"></label>
            </div>
        </td>
        <td>
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[1][writes]" id="lang_w_th-2" value="3"<?php if ($ProfilesLanguage->writes == "3") : ?> checked="checked" <?php endif ?>>
                <label for="lang_w_th-2"></label>
            </div>
        </td>
        <td>
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[1][writes]" id="lang_w_th-3" value="2"<?php if ($ProfilesLanguage->writes == "2") : ?> checked="checked" <?php endif ?>>
                <label for="lang_w_th-3"></label>
            </div>
        </td>
        <td>
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[1][writes]" id="lang_w_th-4" value="1"<?php if ($ProfilesLanguage->writes == "1") : ?> checked="checked" <?php endif ?>>
                <label for="lang_w_th-4"></label>
            </div>
        </td>
    </tr>
    <tr>
     <td><?= Yii::app()->session['lang'] == 1?'Spoken ':'พูด'; ?></td>
     <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[1][spoken]" id="lang_s_th-1" value="4"<?php if ($ProfilesLanguage->spoken == "4") : ?> checked="checked" <?php endif ?>>
            <label for="lang_s_th-1"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[1][spoken]" id="lang_s_th-2" value="3"<?php if ($ProfilesLanguage->spoken == "3") : ?> checked="checked" <?php endif ?>>
            <label for="lang_s_th-2"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[1][spoken]" id="lang_s_th-3" value="2"<?php if ($ProfilesLanguage->spoken == "2") : ?> checked="checked" <?php endif ?>>
            <label for="lang_s_th-3"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[1][spoken]" id="lang_s_th-4" value="1"<?php if ($ProfilesLanguage->spoken == "1") : ?> checked="checked" <?php endif ?>>
            <label for="lang_s_th-4"></label>
        </div>
    </td>
</tr>
</tbody>

<tbody class="group-language">
    <tr>
     <td rowspan="2"><?php echo $form->textField($ProfilesLanguage, '[2]language_name', array('class' => 'form-control','value'=>'English' ,'style'=>' width:100px;line-height:28px;padding: 20px 10px;','readonly'=>true,'placeholder'=> Yii::app()->session['lang'] == 1?'English ':'อังกฤษ')); ?></td>
     <td><?= Yii::app()->session['lang'] == 1?'Written ':'เขียน'; ?></td>
     <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[2][writes]" id="lang_w_en-1" value="4"<?php if ($ProfilesLanguage->writes == "4") : ?> checked="checked" <?php endif ?>>
            <label for="lang_w_en-1"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[2][writes]" id="lang_w_en-2" value="3"<?php if ($ProfilesLanguage->writes == "3") : ?> checked="checked" <?php endif ?>>
            <label for="lang_w_en-2"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[2][writes]" id="lang_w_en-3" value="2"<?php if ($ProfilesLanguage->writes == "2") : ?> checked="checked" <?php endif ?>>
            <label for="lang_w_en-3"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[2][writes]" id="lang_w_en-4" value="1"<?php if ($ProfilesLanguage->writes == "1") : ?> checked="checked" <?php endif ?>>
            <label for="lang_w_en-4"></label>
        </div>
    </td>
</tr>
<tr>
 <td><?= Yii::app()->session['lang'] == 1?'Spoken ':'พูด'; ?></td>
 <td>
    <div class="radio radio-danger ">
        <input type="radio" name="ProfilesLanguage[2][spoken]" id="lang_s_en-5" value="4"<?php if ($ProfilesLanguage->spoken == "4") : ?> checked="checked" <?php endif ?>>
        <label for="lang_s_en-5"></label>
    </div>
</td>
<td>
    <div class="radio radio-danger ">
        <input type="radio" name="ProfilesLanguage[2][spoken]" id="lang_s_en-6" value="3"<?php if ($ProfilesLanguage->spoken == "3") : ?> checked="checked" <?php endif ?>>
        <label for="lang_s_en-6"></label>
    </div>
</td>
<td>
    <div class="radio radio-danger ">
        <input type="radio" name="ProfilesLanguage[2][spoken]" id="lang_s_en-7" value="2"<?php if ($ProfilesLanguage->spoken == "2") : ?> checked="checked" <?php endif ?>>
        <label for="lang_s_en-7"></label>
    </div>
</td>
<td>
    <div class="radio radio-danger ">
        <input type="radio" name="ProfilesLanguage[2][spoken]" id="lang_s_en-8" value="1"<?php if ($ProfilesLanguage->spoken == "1") : ?> checked="checked" <?php endif ?>>
        <label for="lang_s_en-8"></label>
    </div>
</td>
</tr>
</tbody>

  <?php  }
}else{
    ?>
    <tbody class="group-language">
        <tr>
         <td rowspan="2" ><?php echo $form->textField($ProfilesLanguage, '[1]language_name', array('class' => 'form-control','value'=>'Thai' ,'style'=>'width:100px;line-height:28px;padding: 20px 10px;','readonly'=>true,'placeholder'=> Yii::app()->session['lang'] == 1?'Thai ':'ไทย')); ?></td>
         <td><?= Yii::app()->session['lang'] == 1?'Written ':'เขียน'; ?></td>
         <td>
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[1][writes]" id="lang_w_th-1" value="4"<?php if ($ProfilesLanguage->writes == "4") : ?> checked="checked" <?php endif ?>>
                <label for="lang_w_th-1"></label>
            </div>
        </td>
        <td>
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[1][writes]" id="lang_w_th-2" value="3"<?php if ($ProfilesLanguage->writes == "3") : ?> checked="checked" <?php endif ?>>
                <label for="lang_w_th-2"></label>
            </div>
        </td>
        <td>
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[1][writes]" id="lang_w_th-3" value="2"<?php if ($ProfilesLanguage->writes == "2") : ?> checked="checked" <?php endif ?>>
                <label for="lang_w_th-3"></label>
            </div>
        </td>
        <td>
            <div class="radio radio-danger ">
                <input type="radio" name="ProfilesLanguage[1][writes]" id="lang_w_th-4" value="1"<?php if ($ProfilesLanguage->writes == "1") : ?> checked="checked" <?php endif ?>>
                <label for="lang_w_th-4"></label>
            </div>
        </td>
    </tr>
    <tr>
     <td><?= Yii::app()->session['lang'] == 1?'Spoken ':'พูด'; ?></td>
     <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[1][spoken]" id="lang_s_th-1" value="4"<?php if ($ProfilesLanguage->spoken == "4") : ?> checked="checked" <?php endif ?>>
            <label for="lang_s_th-1"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[1][spoken]" id="lang_s_th-2" value="3"<?php if ($ProfilesLanguage->spoken == "3") : ?> checked="checked" <?php endif ?>>
            <label for="lang_s_th-2"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[1][spoken]" id="lang_s_th-3" value="2"<?php if ($ProfilesLanguage->spoken == "2") : ?> checked="checked" <?php endif ?>>
            <label for="lang_s_th-3"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[1][spoken]" id="lang_s_th-4" value="1"<?php if ($ProfilesLanguage->spoken == "1") : ?> checked="checked" <?php endif ?>>
            <label for="lang_s_th-4"></label>
        </div>
    </td>
</tr>
</tbody>

<tbody class="group-language">
    <tr>
     <td rowspan="2"><?php echo $form->textField($ProfilesLanguage, '[2]language_name', array('class' => 'form-control','value'=>'English' ,'style'=>' width:100px;line-height:28px;padding: 20px 10px;','readonly'=>true,'placeholder'=> Yii::app()->session['lang'] == 1?'English ':'อังกฤษ')); ?></td>
     <td><?= Yii::app()->session['lang'] == 1?'Written ':'เขียน'; ?></td>
     <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[2][writes]" id="lang_w_en-1" value="4"<?php if ($ProfilesLanguage->writes == "4") : ?> checked="checked" <?php endif ?>>
            <label for="lang_w_en-1"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[2][writes]" id="lang_w_en-2" value="3"<?php if ($ProfilesLanguage->writes == "3") : ?> checked="checked" <?php endif ?>>
            <label for="lang_w_en-2"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[2][writes]" id="lang_w_en-3" value="2"<?php if ($ProfilesLanguage->writes == "2") : ?> checked="checked" <?php endif ?>>
            <label for="lang_w_en-3"></label>
        </div>
    </td>
    <td>
        <div class="radio radio-danger ">
            <input type="radio" name="ProfilesLanguage[2][writes]" id="lang_w_en-4" value="1"<?php if ($ProfilesLanguage->writes == "1") : ?> checked="checked" <?php endif ?>>
            <label for="lang_w_en-4"></label>
        </div>
    </td>
</tr>
<tr>
 <td><?= Yii::app()->session['lang'] == 1?'Spoken ':'พูด'; ?></td>
 <td>
    <div class="radio radio-danger ">
        <input type="radio" name="ProfilesLanguage[2][spoken]" id="lang_s_en-5" value="4"<?php if ($ProfilesLanguage->spoken == "4") : ?> checked="checked" <?php endif ?>>
        <label for="lang_s_en-5"></label>
    </div>
</td>
<td>
    <div class="radio radio-danger ">
        <input type="radio" name="ProfilesLanguage[2][spoken]" id="lang_s_en-6" value="3"<?php if ($ProfilesLanguage->spoken == "3") : ?> checked="checked" <?php endif ?>>
        <label for="lang_s_en-6"></label>
    </div>
</td>
<td>
    <div class="radio radio-danger ">
        <input type="radio" name="ProfilesLanguage[2][spoken]" id="lang_s_en-7" value="2"<?php if ($ProfilesLanguage->spoken == "2") : ?> checked="checked" <?php endif ?>>
        <label for="lang_s_en-7"></label>
    </div>
</td>
<td>
    <div class="radio radio-danger ">
        <input type="radio" name="ProfilesLanguage[2][spoken]" id="lang_s_en-8" value="1"<?php if ($ProfilesLanguage->spoken == "1") : ?> checked="checked" <?php endif ?>>
        <label for="lang_s_en-8"></label>
    </div>
</td>
</tr>
</tbody>
<?php } ?>
<tbody class="group-language add-language" id="del_languages"></tbody>
<!-- <div class="add-language"></div> -->
</table>

<div class="row justify-content-center form_language">
    <div class="col-md-3 col-sm-12  col-xs-12 text-center">
        <button class="btn btn-info btn-add add_form_language" type="button" id="moreFieldslanguage">
            <span class="glyphicon glyphicon-plus"> </span> <?= Yii::app()->session['lang'] == 1?'Add language ':'เพิ่มภาษา'; ?>
        </button>
    </div>
</div>
</div>
</div>

<div id="office-section1" class="form_Qualification ">
    <div class="row  mt-20 mb-1 mt-20">

        <div class="col-md-3 col-sm-12 text-right-md "> <strong><?= Yii::app()->session['lang'] == 1?'Attachments of Qualification / Professional File ':'เอกสารแนบไฟล์วุฒิการศึกษา/วิชาชีพ'; ?><font class="required_Attachments_educational" color="red">*</font><small class="text-danger d-block">(pdf,png,jpg,jpeg)</small></strong></div>
        <!--     <?php echo $form->labelEx($FileEdu,'file_name'); ?> --> 
        <div class="col-sm-12 col-xs-12 col-md-8">
            <div id="docqueue"></div>
            <?php echo $form->fileField($FileEdu,'file_name',array('id'=>'doc','multiple'=>'true')); ?>
            <script type="text/javascript">
                <?php $timestamp = time();?>
                $(function() {
                    $('#doc').uploadifive({
                        'auto'             : false,

                        'formData'         : {
                            'timestamp' : '<?php echo $timestamp;?>',
                            'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
                        },
                        'queueID'          : 'docqueue',
                        'uploadScript'     : '<?php echo $this->createUrl("Registration/uploadifiveEdu"); ?>',
                        'onAddQueueItem' : function(file){
                            var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'pdf':
                                                        case 'png':
                                                        case 'jpg':
                                                        case 'jpeg':
                                                        break;
                                                        default:
                                                        var filetype = "<?php echo Yii::app()->session['lang'] == 1?'Wrong filetype! ':'ประเภทไฟล์ไม่ถูกต้อง!'; ?>";
                                                        swal(filetype);
                                                        $('#doc').uploadifive('cancel', file);
                                                        break;
                                                    }
                                                },
                                                'onQueueComplete' : function(file, data) {
                                                    console.log(file);
                                                    // if($('#queue .uploadifive-queue-item').length == 0) {
                                                    //     $('#registration-form').submit();
                                                    // }else{
                                                    //     $('#Training').uploadifive('upload');
                                                    // }
                                                    $('#registration-form').submit();

                                                }
                                            });
                });
            </script>
            <?php echo $form->error($FileEdu,'file_name'); ?>
        </div>
    </div>
</div>
<div class="row form_Qualification bb-1 pb-20">
   <div class="col-md-offset-3 col-md-4">
    <?php
    $idx = 1;

    $uploadFolder = Yii::app()->getUploadUrl('edufile');
    $criteria = new CDbCriteria;
    $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
    $criteria->addCondition("active ='y'");
    $FileEdu = FileEdu::model()->findAll($criteria);

    if(isset($FileEdu)){
     $confirm_del  = Yii::app()->session['lang'] == 1?'Do you want to delete the file ?\nWhen you agree, the system will permanently delete the file from the system. ':'คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร';
     foreach($FileEdu as $fileDatas){
        ?>

        <div id="filenamedoc<?php echo $idx; ?>">
            <!-- <a href="<?php echo $this->createUrl('edufile',array('id' => $fileDatas->id)); ?>" target="_blank"> -->
                <?php
                echo '<strong id="filenamedoctext'.$fileDatas->id.'">'.$fileDatas->file_name.'</strong>';
                ?>
                <!-- </a> -->
                <?php echo '<input id="filenamedoc'.$fileDatas->id.'" 
                class="form-control"
                type="text" value="'.$fileDatas->file_name.'" 
                style="display:none;" 
                onblur="editName('.$fileDatas->id.');">'; ?>

                <?php echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                   'id'=>'btnEditName'.$fileDatas->id,
                   'class'=>'btn-action glyphicons pencil btn-danger',
                   'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                   'onclick'=>'$("#filenamedoctext'.$fileDatas->id.'").hide();
                   $("#filenamedoc'.$fileDatas->id.'").show(); 
                   $("#filenamedoc'.$fileDatas->id.'").focus(); 
                   $("#btnEditName'.$fileDatas->id.'").hide(); ')); ?>

                <?php echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                    'id'=>'btnSaveName'.$fileDatas->id,
                    'class'=>'btn-action glyphicons btn-danger remove_2',
                    'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                    'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFileDoc("filedoc'.$idx.'","'.$fileDatas->id.'"); }')); ?>

                </div>
                <?php
                $idx++;
            }?><br><?php
        }
        ?>   
    </div>

</div>
<?php if ($FileTraining->isNewRecord === null) { 
  if (empty($FileTraining)) {
    $count_tn = 1;
   $FileTraining = new FileTraining;
   ?>
   <div class="row form_Training pt-20" style="padding-top: 20px;">
    <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Training history ':'ประวัติการฝึกอบรม'; ?></strong></div>
    <div class="col-md-8 col-sm-6 col-xs-12 ">
        <div class="form-group">
            <?php echo $form->textField($FileTraining, '[0]name_training', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Training name. ':'ชื่อการอบรม')); ?>
        </div>
    </div>
    <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
    <div class="col-md-4 col-sm-6 col-xs-12 ">
        <div class="form-group">
            <div class="input-append">

                <?php echo $form->fileField($FileTraining, '[0]filename', array('id' => 'wizard-picture')); ?>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12 ">
        <div class="form-group since-icon">
            <i class="far fa-calendar-alt"></i>
            <?php echo $form->textField($FileTraining, '[0]expire_date', $expire_date); ?>
        </div>
    </div>
</div>
<div class="add-train"></div>
<?php } else { ?>

      <div class="add-train">
        <?php 
        $idx = 0;
        $idloop = 1;
        $count_tn = 0;
        foreach ($FileTraining as $keytn => $valtn) {  
          $count_tn =   $idloop++;
            ?>
            <div class="row del_trainings">
               <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Training history ':'ประวัติการฝึกอบรม'; ?></strong></div>
               <div class="col-md-8 col-sm-6 col-xs-12 ">
                <div class="form-group">
                    <?php echo $form->textField($valtn, '['.$keytn.']name_training', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Training name. ':'ชื่อการอบรม')); ?>
                </div>
            </div>
            <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
            <div class="col-md-4 col-sm-6 col-xs-12 ">
                <div class="form-group">
                    <div class="input-append">

                        <?php echo $form->fileField($valtn, '['.$keytn.']filename', array('id' => 'wizard-picture')); ?>
                        <?php
                        $uploadFolder = Yii::app()->getUploadUrl('Trainingfile');
                        $confirm_del  = Yii::app()->session['lang'] == 1?'Do you want to delete the file ?\nWhen you agree, the system will permanently delete the file from the system. ':'คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร';
                        if ($valtn->filename != null) {?>
                            <a href="<?php echo Yii::app()->baseUrl . '/uploads/Trainingfile/'.Yii::app()->user->id.'/' . $valtn->filename; ?>"><span></span>
                        <?php    echo '<strong id="filenametraintext'.$valtn->id.'">'.$valtn->name_training.'</strong>';?>
                            </a>
                        <?php  
                                // echo '<input id="filenameTrains'.$valtn->id.'" 
                                // class="form-control"
                                // type="text" value="'.$valtn->file_name.'" 
                                // style="display:none;" 
                                // onblur="editNameTrain('.$valtn->id.');">'; 
                        ?>

                        <?php   
                               //  echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                               //  'id'=>'btnEditNametrain'.$valtn->id,
                               //  'class'=>'btn-action glyphicons pencil btn-danger',
                               //  'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                               //  'onclick'=>
                               // '$("#filenametraintext'.$valtn->id.'").hide(); 
                               //  $("#filenameTrains'.$valtn->id.'").show(); 
                               //  $("#filenameTrains'.$valtn->id.'").focus(); 
                               //  $("#btnEditNametrain'.$valtn->id.'").hide(); ')); 
                        ?>

                        <?php 
                                // echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                                // 'id'=>'btnSaveNametrain'.$valtn->id,
                                // 'class'=>'btn-action glyphicons btn-danger remove_2',
                                // 'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                                // 'onclick'=>'if(confirm("'.$confirm_del.'")) deleteFiletrains("filedoc'.$idx.'","'.$valtn->id.'") ')); 
                          ?> 
                     <?php  }
                        ?>
                    </div>
                </div>
            </div> 
            <div class="col-md-4 col-sm-6 col-xs-12 ">
                <div class="form-group since-icon">
                    <i class="far fa-calendar-alt"></i>
                    <?php echo $form->textField($valtn, '['.$keytn.']expire_date', $expire_date); ?>
                </div>
            </div>

            <span class="delete_training btn-danger" name="mytexttran[]"><i class="fas fa-minus-circle"></i><?= Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?></span> 
        </div>

    <?php }$idx++; ?>
</div>
<?php }} else {
$count_tn = 1;
 ?>
   <div class="row form_Training pt-20" style="padding-top: 20px;">
    <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Training history ':'ประวัติการฝึกอบรม'; ?><small class="text-danger d-block"><?= Yii::app()->session['lang'] == 1?'Add more than 1 ':'เพิ่มได้มากกว่า 1'; ?></small></strong></div>
    <div class="col-md-8 col-sm-6 col-xs-12 ">
        <div class="form-group">
            <!-- <label><?= Yii::app()->session['lang'] == 1?'Training history ':'ประวัติการฝึกอบรม'; ?></label> -->
            <?php echo $form->textField($FileTraining, '[0]name_training', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Training name. ':'ชื่อการอบรม')); ?>
        </div>
    </div>
    <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>
    <div class="col-md-4 col-sm-6 col-xs-12 ">
        <div class="form-group">
            <div class="input-append">

                <?php echo $form->fileField($FileTraining, '[0]filename', array('id' => 'wizard-picture')); ?>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12 ">
        <div class="form-group since-icon">
            <i class="far fa-calendar-alt"></i>
            <?php echo $form->textField($FileTraining, '[0]expire_date', $expire_date); ?>
        </div>
    </div>
</div>
<div class="add-train"></div>
<?php } ?>


<div class="row justify-content-center mt-20 mb-1 bb-1 form_Training">
    <div class="col-md-3 col-sm-12  col-xs-12 text-center">
        <button class="btn btn-info btn-add add_form_training" type="button" id="moreFieldsTraining">
            <span class="glyphicon glyphicon-plus"> </span> <?= Yii::app()->session['lang'] == 1?'Add training history ':'เพิ่มประวัติการฝึกอบรม'; ?>
        </button>
    </div>
</div>

<!-- <?php if ($ProfilesTraining->isNewRecord === null) { 
  if (empty($ProfilesTraining)) {
 //    $ProfilesTraining = new ProfilesTraining;
     ?>
     <div class="row form_name pt-20 ">
         <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Training history ':'ประวัติการฝึกอบรม'; ?></strong></div>

         <div class="col-md-7 col-sm-6 col-xs-12 ">
             <div class="form-group">
               <?php// echo $form->textField($ProfilesTraining, '[0]message', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Training name. ':'ชื่อการอบรม')); ?>
           </div>
       </div>
   </div>
   <div class="add-train"></div>
<?php } else { ?>
  <div class="add-train">
    <?php foreach ($ProfilesTraining as $keytn => $valtn) {
        ?>
        <div class="row del_training">
         <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Training history ':'ประวัติการฝึกอบรม'; ?></strong></div>

         <div class="col-md-7 col-sm-6 col-xs-12 ">
            <div class="form-group">
               <?php //echo $form->textField($valtn, '['.$keytn.']message', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Training name. ':'ชื่อการอบรม')); ?>
           </div>
       </div>
       <span class="delete_training btn-danger" name="mytext[]"><i class="fas fa-minus-circle"></i><?= Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?></span>
   </div>


<?php } ?>
</div>
<?php }} else { ?>
  <div class="row form_name pt-20 ">
    <div class="col-md-3 col-xs-12  col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Training history ':'ประวัติการฝึกอบรม'; ?></strong></div>
    <div class="col-md-7 col-sm-6 col-xs-12 ">
        <div class="form-group">
           <?php// echo $form->textField($ProfilesTraining, '[0]message', array('class' => 'form-control', 'placeholder' => Yii::app()->session['lang'] == 1?'Training name. ':'ชื่อการอบรม')); ?>
       </div>
   </div>
</div>
<?php } ?>

<div class="add-train"></div>
<div class="row justify-content-center form_name">
    <div class="col-md-3 col-sm-12  col-xs-12 text-center">
        <button class="btn btn-info btn-add add_form_training" type="button" id="moreFieldsTraining">
            <span class="glyphicon glyphicon-plus"> </span> <?= Yii::app()->session['lang'] == 1?'Add training history ':'เพิ่มประวัติการฝึกอบรม'; ?>
        </button>
    </div>
</div> -->
<!-- <div id="office-section2" class="form_name">
    <div class="row  mt-20 mb-1">

        <div class="col-md-3 col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'Training file attachment ':'เอกสารแนบไฟล์ฝึกอบรม'; ?><small class="text-danger d-block">(pdf,png,jpg,jpeg)</small></strong></div>
        <div class="col-sm-12 col-xs-12 col-md-8">
            <div id="queue"></div>
            <?php // echo $form->fileField($FileTraining,'file_name',array('id'=>'Training','multiple'=>'true')); ?>
            <script type="text/javascript">
                <?php// $timestamp = time();?>
                $(function() {
                    $('#Training').uploadifive({
                        'auto'             : false,

                        'formData'         : {
                            'timestamp' : '<?php// echo $timestamp;?>',
                            'token'     : '<?php// echo md5("unique_salt" . $timestamp);?>'
                        },
                        'queueID'          : 'queue',
                        'uploadScript'     : '<?php// echo $this->createUrl("Registration/uploadifiveTraining"); ?>',
                        'onAddQueueItem' : function(file){
                            var fileName = file.name;
                                                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1); // Extract EXT
                                                    switch (ext) {
                                                        case 'pdf':
                                                        case 'png':
                                                        case 'jpg':
                                                        case 'jpeg':
                                                        break;
                                                        default:
                                                        var filetype = "<?php //echo Yii::app()->session['lang'] == 1?'Wrong filetype! ':'ประเภทไฟล์ไม่ถูกต้อง!'; ?>";
                                                        swal(filetype);
                                                        $('#Training').uploadifive('cancel', file);
                                                        break;
                                                    }
                                                },
                                                'onQueueComplete' : function(file, data) {
                                                    console.log(data);
                                                    $('#registration-form').submit();
                                               }
                                           });
                });
            </script>
            <?php // echo $form->error($FileTraining,'file_name'); ?>
        </div>

    </div>
    <div class="row mt-20 mb-3">
        <div class="col-md-offset-3 col-md-4">
            <?php
            // $idx = 1;
            // $uploadFolder = Yii::app()->getUploadUrl('Trainingfile');
            // $criteria = new CDbCriteria;
            // $criteria->addCondition('user_id ="'.Yii::app()->user->id.'"');
            // $criteria->addCondition("active ='y'");
            // $Trainingfile = FileTraining::model()->findAll($criteria);

            if(isset($Trainingfile)){
           //   $confirm_del  = Yii::app()->session['lang'] == 1?'Do you want to delete the file ?\nWhen you agree, the system will permanently delete the file from the system. ':'คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร'; 
              foreach($Trainingfile as $fileData){

                ?>
                <div id="filenameTrain<?php echo $idx; ?>">
          
                    <?php
                    //echo '<strong id="filenametraintext'.$fileData->id.'">'.$fileData->file_name.'</strong>';
                    ?>
                    <?php //echo '<input id="filenameTrains'.$fileData->id.'" 
                    //class="form-control"
                   // type="text" value="'.$fileData->file_name.'" 
                   // style="display:none;" 
                   // onblur="editNameTrain('.$fileData->id.');">'; ?>


                    <?php //echo CHtml::link('<span class="btn-uploadfile btn-warning"><i class="fa fa-edit"></i></span>','', array('title'=>'แก้ไขชื่อ',
                        // 'id'=>'btnEditNametrain'.$fileData->id,
                        // 'class'=>'btn-action glyphicons pencil btn-danger',
                        // 'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                        // 'onclick'=>'$("#filenametraintext'.$fileData->id.'").hide(); 
                        // $("#filenameTrains'.$fileData->id.'").show(); 
                        // $("#filenameTrains'.$fileData->id.'").focus(); 
                        // $("#btnEditNametrain'.$fileData->id.'").hide(); ')); ?>


                    <?php //echo CHtml::link('<span class="btn-uploadfile btn-danger"><i class="fa fa-trash"></i></span>','', array('title'=>'ลบไฟล์',
                       // 'id'=>'btnSaveNametrain'.$fileData->id,
                       // 'class'=>'btn-action glyphicons btn-danger remove_2',
                       // 'style'=>'z-index:1; background-color:transparent; cursor:pointer;',
                       // 'onclick'=>'if(confirm("'.$confirm_del.'")){ deleteFiletrain("filedoc'.$idx.'","'.$fileData->id.'"); }')); ?>

                    </div>

                    <?php
                    $idx++;
                }?><?php
            }
            ?> 
        </div>  
    </div>
</div> -->
<!-- <div class="row  mt-1 mb-1 form_name">
    <div class="col-md-3 text-right-md"> <strong><?php //echo Yii::app()->session['lang'] == 1?'File attachment':'เอกสารแนบไฟล์'; ?><small class="text-danger d-block">(pdf,png,jpg,jpeg)</small></strong></div>
</div> -->

<div id="office-section_gen">
    <div class="row  mb-1 " id="employee_type" >
        <div class="col-md-3 col-sm-12 text-right-md"> <strong><?= Yii::app()->session['lang'] == 1?'The boat position you are interested in applying for ':'ตำแหน่งเรือที่ท่านสนใจสมัคร'; ?></strong><font color="red">*</font></div>
        <div class="col-sm-12 col-xs-12 col-md-8">
            <div class="col-md-6">
                <div class="form-group">
                    <?php

                    $criteria= new CDbCriteria;
                    $criteria->compare('active','y');
                    $criteria->compare('type_employee_id',1); // เรือ
                    //$criteria->compare('type_employee_id',4);
                    $criteria->order = 'sortOrder ASC';
                    $departmentModel = Department::model()->findAll($criteria);
                    $departmentList = CHtml::listData($departmentModel, 'id', 'dep_title');
                    $departmentOption = array('class' => 'form-control department_gen', 'empty' => $label->label_placeholder_position, 'name' => 'department_gen', 'disabled' => $users->isNewRecord == true? false : true);
                    ?>
                    <?php
                    echo $form->dropDownList($users, 'department_id', $departmentList, $departmentOption);
                    ?>
                    <?php echo $form->error($users, 'department_id', array('class' => 'error2')); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <?php
                  $Department_ship = Department::model()->findAll(array(
                    'condition' => 'type_employee_id=:type_employee_id AND active=:active',
                    'params' => array(':type_employee_id'=>4, ':active'=>'y')));

                  $dep_id = [];
                  foreach ($Department_ship as $keydepart => $valuedepart) {
                   $dep_id[] = $valuedepart->id;
               }

               // $criteria= new CDbCriteria;
               // $criteria->compare('active','y');
               // $criteria->addInCondition('department_id', $dep_id);
               // $criteria->order = 'sortOrder ASC';
               $criteria= new CDbCriteria;
               $criteria->compare('active','y');
               $criteria->order = 'sortOrder ASC';
                                    //$positionModel = Position::model()->findAll($criteria);
               $position_ship = Position::model()->findAll($criteria);
               ?> 
               <?php
               $positionLists = CHtml::listData($position_ship, 'id', 'position_title');

               $positiontOption = array('class' => 'form-control position_gen ', 'empty' => Yii::app()->session['lang'] == 1?'Select Position ':'เลือกตำแหน่ง', 'name' => 'position_gen', 'disabled' => $users->isNewRecord == true? false : true);
               ?>
               <?php echo $form->dropDownList($users, 'position_id', $positionLists, $positiontOption); ?>
               <?php echo $form->error($users, 'position_id', array('class' => 'error2')); ?>

           </div>
       </div>
   </div>
</div>
<div class="row justify-content-center form_salary">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="form-group">
            <label><?php echo $label->label_expected_salary; ?><font color="red">*</font></label>
            <?php echo $form->textField($profile, 'expected_salary', array('class' => 'form-control salary','onchange'=>'numberWithCommas();','onkeyup'=>"isNumbercharSalary(this.value,this)", 'placeholder' => $label->label_expected_salary)); ?>
            <?php echo $form->error($profile, 'expected_salary', array('class' => 'error2')); ?>

        </div>

    </div> 
    <div class="col-md-1 col-sm-6 col-xs-12">
        <div class="form-group baht">
           <label><?= Yii::app()->session['lang'] == 1?'Baht':'บาท'; ?></label>
       </div>
   </div>    
   <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group birthday-icon">
        <i class="far fa-calendar-alt"></i>
        <label><?php echo $label->label_start_working; ?><font color="red">*</font></label>
        <?php echo $form->textField($profile, 'start_working',$working); ?>
        <?php echo $form->error($profile, 'start_working', array('class' => 'error2')); ?>

    </div>
</div>
<div class="clearfix"></div>
</div>
</div>

</div>  

 

                        <div class="text-center submit-register" <?php if($page != "update"){ ?>style="display: none;" <?php }  ?>>

                            <?php 
                            $branch_js = $users->branch_id;
                            if ($branch_js === null ) {
                               $branch_js = 0;
                           }else{
                               $branch_js = 1;
                           }

                           $new_form = $users->isNewRecord;
                           if ($new_form) {
                             $new_form = true;
                         }else{
                            $new_form = 0;
                        }

                        if (Yii::app()->user->getId() == null) { ?>
                            <?php echo CHtml::submitButton($label->label_regis, array('class' => 'btn btn-default bg-greenlight btn-lg center-block ok_2','onclick'=>"return upload();")); ?>
                        <?php } else {
                            echo CHtml::submitButton($label->label_save, array('class' => 'btn btn-default bg-greenlight btn-lg center-block ok_2','onclick'=>"return upload();"));
                        } ?>
                    </div>

                    <?php $this->endWidget();
                    ?>

                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
    ////////////////////////////////////////// ประวัติการศึกษา /////////////////////////////////////////////////////////////////////////
    var max_fields = 10;
    var wrapper = $(".add-study");
    var add_button = $(".add_form_field");
    var numItems = 10;
    var x = 1;

    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            numItems++;

            var level = '<option value=""><?php echo $label->label_education_level; ?></option>';
            var academy = '<?php echo $label->label_academy; ?>';
            var graduation_year = '<option value=""><?php echo $label->label_graduation_year; ?></option>';
            var del = '<?php echo Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?>'; 
            $(wrapper).append('<div class="row del_edu"><div class="col-md-3 col-sm-12 text-right-md "><strong><?php echo $label->label_educational; ?></strong></div>'
                +'<div class="col-md-2 col-sm-6"><div class="form-group"><select class ="form-control" name="ProfilesEdu[' + numItems + '][edu_id]">' + level + '<?php foreach ($list as $key => $value) : ?><option value=<?php echo $key ?>><?php echo $value ?></option><?php endforeach ?></select></div></div>'
                +'<div class="col-md-3 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + academy + '" name="ProfilesEdu[' + numItems + '][institution]"></div></div>'
                +'<div class="col-md-2 col-sm-6"><div class="form-group"><select class="form-control" autocomplete="off" id="ProfilesEdu_' + numItems + '_date_graduation" name="ProfilesEdu[' + numItems + '][date_graduation]">' + graduation_year + '<?php foreach ($year_edu as $keys => $values): ?><option value=<?php echo $values ?>><?php echo $values ?></option><?php endforeach ?></select></div></div>'
                +'<span class="delete btn-danger" name="mytext[]"><i class="fas fa-minus-circle" ></i> ' + del + '</span></div>'); //add input box
        } else {
        var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
        var msg ="<?php echo Yii::app()->session['lang'] == 1?'You Reached the limits! ':'คุณเพิ่มถึงจำนวนจำกัด!'; ?>"; 
        swal(alert_message,msg);
        }
    });
    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('.del_edu').remove();
        x--;
    });
////////////////////////////////////////// ประวัติการฝึกอบรม /////////////////////////////////////////////////////////////////////////
var max_fields_training = 30;
var wrapper_train = $(".add-train");
var add_button_training = $(".add_form_training");
//var new_form = <?php echo $users->isNewRecord; ?>;
var new_form = <?php echo $count_tn; ?>;
if (new_form == 1) {
 var numItems_training = 0;
}else{
  var numItems_training = <?php echo $count_tn; ?> - 1; 
}
var t = 1;

$(add_button_training).click(function(e) {
    e.preventDefault();
    if (t < max_fields_training) {
        t++;
        numItems_training++;
        var head_training = '<?php echo Yii::app()->session['lang'] == 1?'Training history ':'ประวัติการฝึกอบรม'; ?>';
        var message = '<?php echo Yii::app()->session['lang'] == 1?'Training name. ':'ชื่อการอบรม' ?>';
        var del_training = '<?php echo Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?>';
        var date_expiry = '<?php echo $label->label_date_of_expiry; ?>';
        $(wrapper_train).append('<div class="row del_trainings">'
            +'<div class="col-md-3 col-xs-12  col-sm-12 text-right-md">' + head_training + '</div>'
            +'<div class="col-md-8 col-sm-3 col-xs-12 ">'
            +'<div class="form-group">'
            +'<input type="text" class="form-control" placeholder="' + message + '" name="FileTraining[' + numItems_training + '][name_training]">'
            +'</div>'
            +'</div>'
            +'<div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>'
            +'<div class="col-md-4 col-sm-6 col-xs-12 ">'
            +'<div class="form-group">'
            +'<div class="input-append">'
            +'<input type="file" name="FileTraining[' + numItems_training + '][filename]" multiple="true">'
            +'</div>'
            +'</div>'
            +'</div>'
            +'<div class="col-md-4 col-sm-6 col-xs-12 ">'
            +'<div class="form-group since-icon">'
            +'<i class="far fa-calendar-alt"></i>'
            +'<input type="text" class="form-control datetimepicker" autocomplete = "off" placeholder="' + date_expiry + '" name="FileTraining[' + numItems_training + '][expire_date]">'
            +'</div>'
            +'</div>'
            +'<span class="delete_training btn-danger" name="mytexttran[]"><i class="fas fa-minus-circle" ></i> ' + del_training + '</span></div>');

            // $(wrapper_train).append('<div class="row del_training"><div class="col-md-3 col-sm-12 text-right-md "><strong> ' + head_training + '</strong></div>'+'<div class="col-md-7 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + message + '" name="ProfilesTraining[' + numItems_training + '][message]"></div></div>'
           // +'<span class="delete_training btn-danger" name="mytext[]"><i class="fas fa-minus-circle" ></i> ' + del_training + '</span></div>');

           $('.datetimepicker').datetimepicker({
            format: 'd-m-Y',
            step: 10,
            timepickerScrollbar: false
        });
           $('.xdsoft_timepicker').hide();
       } else {
        var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
        var msg ="<?php echo Yii::app()->session['lang'] == 1?'You Reached the limits! ':'คุณเพิ่มถึงจำนวนจำกัด!'; ?>"; 
        swal(alert_message,msg);
    }
});
$(wrapper_train).on("click", ".delete_training", function(e) {
    e.preventDefault();
    $(this).parent('.del_trainings').remove();
    t--;
});

////////////////////////////////////////// ภาษา /////////////////////////////////////////////////////////////////////////
var max_fields_language = 10;
var wrapper_language = $(".add-language");
var add_form_language = $(".add_form_language");
var numItems_language = 100;
var l = 1;

$(add_form_language).click(function(e) {
    e.preventDefault();
    if (l < max_fields_language) {
        l++;
        numItems_language++;

        var language_name = '<?php echo Yii::app()->session['lang'] == 1?'language ':'ภาษา' ?>';
        var del_language = '<?php echo Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?>';
        var language_Written = '<?php echo Yii::app()->session['lang'] == 1?'Written ':'เขียน' ?>';
        var language_Spoken = '<?php echo Yii::app()->session['lang'] == 1?'Spoken ':'พูด' ?>'; 
        var del_language = '<?php echo Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?>';
        <?php 
        $h = 10; 
        $v = 10;
        ?>
        $(wrapper_language).append('<tr><td rowspan="2">'
            +'<input type="text" class="form-control" placeholder="' + language_name + '" name="ProfilesLanguage[' + numItems_language + '][language_name]" style="width:100px;line-height:28px;padding: 20px 10px;">'
           // +'<span class="delete_language btn-danger" name="mytextlg[]"><i class="fas fa-minus-circle" ></i> ' + del_language + '</span></div>'
            +'</td>'
            +'<td>'+language_Written+'</td>'
            +'<td><div class="radio radio-danger "><input type="radio" name="ProfilesLanguage[' + numItems_language + '][writes]" id="lang_w-' + numItems_language + '<?php echo $h++ ?>" value="4"><label for="lang_w-' + numItems_language + '<?php echo $v++ ?>"></label></div></td>'
            +'<td><div class="radio radio-danger "><input type="radio" name="ProfilesLanguage[' + numItems_language + '][writes]" id="lang_w-' + numItems_language + '<?php echo $h++ ?>" value="3"><label for="lang_w-' + numItems_language + '<?php echo $v++ ?>"></label></div></td>'
            +'<td><div class="radio radio-danger "><input type="radio" name="ProfilesLanguage[' + numItems_language + '][writes]" id="lang_w-' + numItems_language + '<?php echo $h++ ?>" value="2"><label for="lang_w-' + numItems_language + '<?php echo $v++ ?>"></label></div></td>'
            +'<td><div class="radio radio-danger "><input type="radio" name="ProfilesLanguage[' + numItems_language + '][writes]" id="lang_w-' + numItems_language + '<?php echo $h++ ?>" value="1"><label for="lang_w-' + numItems_language + '<?php echo $v++ ?>"></label></div></td></tr>'
            +'<tr><td>'+language_Spoken+'</td>'
            +'<td><div class="radio radio-danger "><input type="radio" name="ProfilesLanguage[' + numItems_language + '][spoken]" id="lang_s-' + numItems_language + '<?php echo $h++ ?>" value="4"><label for="lang_s-' + numItems_language + '<?php echo $v++ ?>"></label></div></td>'
            +'<td><div class="radio radio-danger "><input type="radio" name="ProfilesLanguage[' + numItems_language + '][spoken]" id="lang_s-' + numItems_language + '<?php echo $h++ ?>" value="3"><label for="lang_s-' + numItems_language + '<?php echo $v++ ?>"></label></div></td>'
            +'<td><div class="radio radio-danger "><input type="radio" name="ProfilesLanguage[' + numItems_language + '][spoken]" id="lang_s-' + numItems_language + '<?php echo $h++ ?>" value="2"><label for="lang_s-' + numItems_language + '<?php echo $v++ ?>"></label></div></td>'
            +'<td><div class="radio radio-danger "><input type="radio" name="ProfilesLanguage[' + numItems_language + '][spoken]" id="lang_s-' + numItems_language + '<?php echo $h++ ?>" value="1"><label for="lang_s-' + numItems_language + '<?php echo $v++ ?>"></label></div></td></tr>' //add input box
            );


    } else {
        var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
        var msg ="<?php echo Yii::app()->session['lang'] == 1?'You Reached the limits! ':'คุณเพิ่มถึงจำนวนจำกัด!'; ?>"; 
        swal(alert_message,msg);
    }
});

///$('.delete_language').find('.add-language').empty();
// $('.delete_language').on('click', ()=>{
//    $('#del_languages').empty();
// });

// $(wrapper_language).on("click", ".delete_language", function(e) {
//     e.preventDefault();
// $(this).parent('#del_languages').remove();
//     l--;
// });
////////////////////////////////////////// ประวัติการทำงาน /////////////////////////////////////////////////////////////////////////
var max_fields_work = 10;
var wrapper_work = $(".add-Work");
var add_button_work = $(".add_form_work");
var numItems_work = 10;
var i = 1;

$(add_button_work).click(function(e) {
    e.preventDefault();
    if (i < max_fields_work) {
        i++;
        numItems_work++;
        var head_work = '<?php echo Yii::app()->session['lang'] == 1?'Work history ':'ประวัติการทำงาน'; ?>';
        var company_work = '<?php echo Yii::app()->session['lang'] == 1?'Company ':'บริษัท'; ?>';
        var position_work = '<?php echo Yii::app()->session['lang'] == 1?'Position ':'ตำแหน่ง'; ?>';
        var since_work = '<?php echo Yii::app()->session['lang'] == 1?'Since ':'ตั้งแต่'; ?>';
        var reason_for_leaving = '<?php echo Yii::app()->session['lang'] == 1?'Reason for leaving ':'สาเหตุที่ออก'; ?>';
        var del_work = '<?php echo Yii::app()->session['lang'] == 1?'Delete ':'ลบ'; ?>';
        $(wrapper_work).append('<div class="row del_work"><div class="col-md-3 col-sm-12 text-right-md "><strong> ' + head_work + '</strong></div>'+'<div class="col-md-4 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + company_work + '" name="ProfilesWorkHistory[' + numItems_work + '][company_name]"></div></div>'+'<div class="col-md-4 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + position_work + '" name="ProfilesWorkHistory[' + numItems_work + '][position_name]"></div></div>'+'<div class="col-md-3 col-xs-12  col-sm-12 text-right-md"></div>'+'<div class="col-md-4 col-sm-6"><div class="form-group since-icon"><i class="far fa-calendar-alt"></i><input type="text" class="form-control datetimepicker" autocomplete = "off" placeholder="' + since_work + '" name="ProfilesWorkHistory[' + numItems_work + '][since_date]"></div></div>'+'<div class="col-md-4 col-sm-6"><div class="form-group"><input type="text" class="form-control" placeholder="' + reason_for_leaving + '" name="ProfilesWorkHistory[' + numItems_work + '][reason_leaving]"></div></div>'
                            +'<span class="delete_work btn-danger" name="mytext[]"><i class="fas fa-minus-circle" ></i> ' + del_work + '</span></div>'); //add input box
        $('.datetimepicker').datetimepicker({
            format: 'd-m-Y',
            step: 10,
            timepickerScrollbar: false
        });
        $('.xdsoft_timepicker').hide();

    } else {
        var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
        var msg ="<?php echo Yii::app()->session['lang'] == 1?'You Reached the limits! ':'คุณเพิ่มถึงจำนวนจำกัด!'; ?>"; 
        swal(alert_message,msg);
       // alert('You Reached the limits')
    }
});
$(wrapper_work).on("click", ".delete_work", function(e) {
    e.preventDefault();
    $(this).parent('.del_work').remove();
    i--;
});
////////////////////////////////////////// ประวัติการ /////////////////////////////////////////////////////////////////////////

$('#accept').change(function(event) {
    $(".submit-register").show();
    $(".id_employee").hide();
    $(".uploads_image").show();
    $('.form_name').show();
    $('.form_name_eng').show();
    $('.form_number_id').hide();
   $("#office-section").hide();
   //$(".form_language").show();
   $("#office-section_gen").show();

   $('.Branch').hide();
   $('.label_branch').hide();
   $('.form_identification').show();
   $('.form_identification_5').show();
   $('.form_passport').show();
   $('.form_passport_5').show();
   $('.form_sickness').hide();
   $(".form_language").show(); 
   $('.children').hide();
   $('.Spouse').hide();
   $(".form_seamanbook").show();
   $(".form_attach_identification").show();
   $(".form_attach_passport").show();
   $(".form_attach_crew_identification").show();
   $(".form_attach_house_registration").show();
   $(".form_birthday").show();
   $(".form_place_of_birth").show();
   $(".form_body").show();
   $(".form_race").show();
   $(".form_religion").show();
   $(".form_marital_status").show();
   //$(".form_tel_nationality").hide();
   $(".form_race_13").show();
   $(".form_phone_5").hide();
   $(".form_occupation_sex").hide();
   $(".form_father").show();
   $(".form_mother").show();
   $(".form_accommodation").show();
   $(".form_domicile_address").show();
   $(".form_address").show();
   $(".form_tel").show();
   $(".form_emergency").show();
   $(".form_email").show();
   $(".form_military").show();
   $(".form_history_of_severe_illness").show();
   $(".form_Edu").show();
   $(".form_WorkHistory").show();
   $(".form_Qualification ").show();
   $(".form_Training").show();
   $(".form_salary").show();

   $(".required_idline").hide();
   $(".required_identification").hide();
   $(".required_date_of_expiry").hide();
});
$("#reject").change(function(event) {
    $('.submit-register').show();
    $(".id_employee").show();
    $(".uploads_image").show();
    $('.form_name').show();
    $('.form_name_eng').show();
    $('.form_number_id').show();
   $("#office-section").show();
   $(".form_language").hide();
   $("#office-section_gen").hide();
   $("#employee_type_1").hide();

   $('.Branch').hide();
   $('.label_branch').hide();
   $('.form_identification').show();
   $('.form_identification_5').show();
   $('.form_passport').hide();
   $('.form_passport_5').hide();
   $('.form_sickness').hide();
   $(".form_language").hide(); 
   $('.children').hide();
   $('.Spouse').hide();
   $(".form_seamanbook").hide();
   $(".form_attach_identification").hide();
   $(".form_attach_passport").hide();
   $(".form_attach_crew_identification").hide();
   $(".form_attach_house_registration").hide();
   $(".form_birthday").show();
   $(".form_place_of_birth").show();
   $(".form_body").show();
   $(".form_race").show();
   $(".form_religion").show();
   $(".form_marital_status").show();
   //$(".form_tel_nationality").hide();
   $(".form_race_13").show();
   $(".form_phone_5").hide();
   $(".form_occupation_sex").hide();
   $(".form_father").show();
   $(".form_mother").show();
   $(".form_accommodation").show();
   $(".form_domicile_address").show();
   $(".form_address").show();
   $(".form_tel").show();
   $(".form_emergency").show();
   $(".form_email").show();
   $(".form_military").show();
   $(".form_history_of_severe_illness").show();
   $(".form_Edu").show();
   $(".form_WorkHistory").show();
   $(".form_Qualification ").hide();
   $(".form_Training").show();
   $(".form_salary").hide();

   $(".required_idline").hide();
   // $(".required_identification").show();
   // $(".required_date_of_expiry").show();
           $(".required_Blood").hide();
           $(".required_Height").hide();
           $(".required_Weight").hide();
           $(".required_race").hide();
           $(".required_nationality").hide();
           $(".required_sex").hide();
           $(".required_father_firstname").hide();
           $(".required_father_lastname").hide();
           $(".required_mother_firstname").hide();
           $(".required_mother_lastname").hide();
           $(".required_nationality").hide();
           $(".required_Emergency").hide();
           $(".required_name_emergency").hide();
           $(".required_relationship_emergency").hide();
           $(".required_military").hide();
           $(".required_history_of_severe_illness").hide();
           $(".required_educational").hide();
           $(".required_Attachments_educational").hide();
           $(".required_marital_status").hide();
           $(".required_accommodation").hide();
           $(".required_domicile_address").hide();
           $(".required_address").hide();

           $(".form_attach_identification").hide();
           $(".form_attach_house_registration").hide();
           $(".form_Qualification ").hide();

});
$("#general").change(function(event) {
    $('.submit-register').show();
    $('.Branch').hide();
    $(".uploads_image").hide();
    $('.label_branch').hide();
    $(".id_employee").hide();
    $("#office-section").hide();
    $('.form_name').show();
    $('.form_name_eng').show();
    $('.form_number_id').show();
    $('.form_identification').show();
    $('.form_identification_5').hide();
    $('.form_passport').show();
    $('.form_passport_5').hide();
    $(".form_language").hide(); 
    $("#office-section_gen").hide();
    $('.form_sickness').hide();
    $('.children').hide();
    $('.Spouse').hide();
    $(".form_seamanbook").hide();
    $(".form_attach_identification").hide();
    $(".form_attach_passport").hide();
    $(".form_attach_crew_identification").hide();
    $(".form_attach_house_registration").hide();
   // $(".form_tel_nationality").show();
   $(".form_race_13").hide();
   $(".form_phone_5").show();
   $(".form_occupation_sex").show();
   $(".form_birthday").show();
   $(".form_place_of_birth").hide();
   $(".form_body").hide();
   $(".form_race").show();
   $(".form_religion").hide();
   $(".form_marital_status").hide();
   $(".form_father").hide();
   $(".form_mother").hide();
   $(".form_accommodation").hide();
   $(".form_domicile_address").show();
   $(".form_address").hide();
   $(".form_tel").hide();
   $(".form_emergency").hide();
   $(".form_email").show();
   $(".form_military").hide();
   $(".form_history_of_severe_illness").hide();
   $(".form_Edu").show();
   $(".form_WorkHistory").hide();
   $(".form_Qualification ").hide();
   $(".form_Training").hide();
   $(".form_salary").hide();

   $(".required_idline").hide();
   $(".required_identification").show();
   $(".required_date_of_expiry").show();
});

$("#card-7").change(function(event) {
           $(".required_Blood").hide();
           $(".required_Height").hide();
           $(".required_Weight").hide();
           $(".required_race").hide();
           $(".required_nationality").hide();
           $(".required_sex").hide();
           $(".required_father_firstname").hide();
           $(".required_father_lastname").hide();
           $(".required_mother_firstname").hide();
           $(".required_mother_lastname").hide();
           $(".required_nationality").hide();
           $(".required_Emergency").hide();
           $(".required_name_emergency").hide();
           $(".required_relationship_emergency").hide();
           $(".required_military").hide();
           $(".required_history_of_severe_illness").hide();
           $(".required_educational").hide();
           $(".required_Attachments_educational").hide();
           $(".required_marital_status").hide();
           $(".required_accommodation").hide();
           $(".required_domicile_address").hide();
           $(".required_address").hide();

           $(".form_attach_identification").hide();
           $(".form_attach_house_registration").hide();
           $(".form_Qualification ").hide();

    var id = $("input[name='type_employee']:checked").val();
    $.ajax({
        type: 'POST',
        url: "<?= Yii::app()->createUrl('Registration/ListDepartment'); ?>",
        data: {
            id: id
        },
        success: function(data) {
           // console.log(data);
           $('.label_branch').hide();
           $('.department').empty();
           $('.department').append(data);
           var Branch ='<option value =""><?php echo Yii::app()->session['lang'] == 1?'Select Level ':'เลือกระดับ'; ?> </option>';
           var Position ='<option value =""><?php echo Yii::app()->session['lang'] == 1?'Select Position ':'เลือกตำแหน่ง'; ?> </option>';
           $('.position').empty();
           $('.Branch').empty();
           $('.position').append(Position);
           $('.Branch').append(Branch);
       }
   });
});

$("#card-8").change(function(event) {
           $(".required_Blood").show();
           $(".required_Height").show();
           $(".required_Weight").show();
           $(".required_race").show();
           $(".required_nationality").show();
           $(".required_sex").show();
           $(".required_father_firstname").show();
           $(".required_father_lastname").show();
           $(".required_mother_firstname").show();
           $(".required_mother_lastname").show();
           $(".required_nationality").show();
           $(".required_Emergency").show();
           $(".required_name_emergency").show();
           $(".required_relationship_emergency").show();
           $(".required_military").show();
           $(".required_history_of_severe_illness").show();
           $(".required_educational").show();
           $(".required_Attachments_educational").show();
           $(".required_marital_status").show();
           $(".required_accommodation").show();
           $(".required_domicile_address").show();
           $(".required_address").show();

           $(".form_attach_identification").show();
           $(".form_attach_house_registration").show();
           $(".form_Qualification ").show();

    var id = $("input[name='type_employee']:checked").val();
    $.ajax({
        type: 'POST',
        url: "<?= Yii::app()->createUrl('Registration/ListDepartment'); ?>",
        data: {
            id: id
        },
        success: function(data) {
            $('.label_branch').hide();
            $('.department').empty();
            $('.department').append(data);
            //var Branch ='<option value ="">Select Branch </option>';
            var Position ='<option value =""><?php echo Yii::app()->session['lang'] == 1?'Select Position ':'เลือกตำแหน่ง'; ?> </option>';
            $('.position').empty();
            //$('.Branch').empty();
            $('.position').append(Position);
            $('.Branch').hide();
        }
    });
});

});
$('.default_datetimepicker').datetimepicker({
               // format: 'Y-m-d',
               format: 'd-m-Y',
               step: 10,
               timepickerScrollbar: false
           });

$('.xdsoft_timepicker').hide();

$(function() {
    ////////////////gen เลข 0 ด้านหน้าให้ครบ 13 หลัก///////////////////////////
    // $('.user_ID').change(function(event,length){
    //                 var max = 13;
    //                 var vals = $(this).val();
    //                 if (max.length < vals.length) { 
    //                     var setval = '' + $(this).val();
    //                     while (setval.length < max.length) {
    //                      setval = '0' + setval;
    //                  }

    //                  $(this).val(setval);

    //              }else{
    //                 var setval = '' + $(this).val();
    //                 while (setval.length < max) {
    //                  setval = '0' + setval;
    //              }

    //              $(this).val(setval);
    //          }
    //      });
    $('.user_ID').change(function(event,length){
        var max = 5;
        var vals = $(this).val();
        // console.log(max);
        // console.log(vals.length);
        if (max != vals.length) {      
               var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
               var msg ="<?php echo Yii::app()->session['lang'] == 1?'Please fill in your 5-digit employee identification number! ':'กรุณากรอกเลขประจำตัวพนักงานให้ครบ 5 หลัก!'; ?>";   
               swal(alert_message,msg);       
        }
        // else{
        //      var alert_message ="<?php //echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
        //        var msg ="<?php //echo Yii::app()->session['lang'] == 1?'Please fill in your 5-digit employee identification number! ':'กรุณากรอกเลขประจำตัวพนักงานให้ครบ 5 หลัก!'; ?>";   
        //        swal(alert_message,msg);     
        // }
    });
    $("#card-5").change(function(event) {    
      var sick = $("input[name='history_of_illness']:checked").val();
      if (sick == 'n') {
          $('.form_sickness').hide();
      }else{
        $('.form_sickness').show();
    }
});
    $("#card-6").change(function(event) {    
      var sick = $("input[name='history_of_illness']:checked").val();
      if (sick == 'y') {
          $('.form_sickness').show();
      }else{
        $('.form_sickness').hide();
    }
});

    $("#card-3").change(function(event) {    
      var sick = $("input[name='status_sm']:checked").val();
      if (sick == 's') {
          $('.children').hide();
          $('.Spouse').hide();
      }else{
        $('.children').show();
        $('.Spouse').show();
    }
});
    $("#card-4").change(function(event) {    
      var child = $("input[name='status_sm']:checked").val();
      if (child == 'm') {
          $('.children').show();
          $('.Spouse').show();
      }else{
        $('.children').hide();
        $('.Spouse').hide();
    }
});

    $("#address_parent").change(function(event) {  
     var address_parent = $("input[name='address_parent']:checked").val();

     if (address_parent == 'y') {
        var Profile_domicile_address = $("#Profile_domicile_address").val();
        if (Profile_domicile_address != '') {
           var Profile_address = $("#Profile_address").val();
           if (Profile_address == '') {
             $('#Profile_address').empty();
             $('#Profile_address').append(Profile_domicile_address);
             $('#Profile_address').val(Profile_domicile_address);
         }else{

             $("#Profile_address").val("");
             if (Profile_address =='') {
                 $('#Profile_address').empty();
                 $('#Profile_address').append(Profile_domicile_address);
                 $('#Profile_address').val(Profile_domicile_address);
             }else{
                $('#Profile_address').empty();
                $('#Profile_address').append(Profile_domicile_address);
                $('#Profile_address').val(Profile_domicile_address);

            }                
        }
    }else{
        var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
        var msg ="<?php echo Yii::app()->session['lang'] == 1?'Please enter the address on the ID card! ':'กรุณากรอกที่อยู่ตามบัตรประชาชน!'; ?>"; 
        swal(alert_message,msg);
        document.getElementById("address_parent").checked = false;
    }
}else{
    $("#Profile_address").val("");
}
});
// $(".start_working").change(function() {
//     var first = new Date($(this).val());
//     var current = new Date();
//     console.log(first.getTime);
//     if(first.getTime()<current.getTime()){
//       var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
//       var msg ="<?php echo Yii::app()->session['lang'] == 1?'Cannot adjust the end time more than the beginning date! ':'ไม่สามารถปรับเวลาสิ้นสุดมากกว่าวันเริ่มต้นได้!'; ?>"; 
//           swal(alert_message,msg);
//      $(this).val("");
//    }
//  });

$(".email").change(function() {
    var text_mail = $(".email").val();
    if (text_mail != "") {
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('Registration/CheckMail'); ?>",
            data: {
                text_mail: text_mail
            },
            success: function(data) {

                if (data != true) {
                 $(".email").empty();
                 var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                 var msg ="<?php echo Yii::app()->session['lang'] == 1?'The email name already exists in the database! ':'อีเมลนี้มีผู้ใช้งานแล้ว!'; ?>"; 
                 swal(alert_message,msg);
                 $(".email").val(null);

             }

         }
     });
    }
});

$(".passport").change(function() {
    var text_passport = $(".passport").val();
    if (text_passport != "") {
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('Registration/CheckPassport'); ?>",
            data: {
                text_passport: text_passport
            },
            success: function(data) {

                if (data != true) {
                 $(".passport").empty();
                 var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                 var msg ="<?php echo Yii::app()->session['lang'] == 1?'This passport number is already in use.! ':'เลขพาสปอร์ตนี้มีผู้ใช้งานแล้ว!'; ?>"; 
                 swal(alert_message,msg);
                 $(".passport").val(null);

             }

         }
     });
    }
});

$(".idcard").change(function() {
    var idcard = $(".idcard").val();
    if (idcard != "") {
        $.ajax({
            type: 'POST',
            url: "<?= Yii::app()->createUrl('Registration/CheckIdcard'); ?>",
            data: {
                idcard: idcard
            },
            success: function(data) {

                if (data == 'yes') {
                 $(".idcard").empty();
                 var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                 var msg ="<?php echo Yii::app()->session['lang'] == 1?'This identification number already has a database! ':'เลขประจำตัวประชาชนนี้มีฐานข้อมูลแล้ว!'; ?>"; 
                 swal(alert_message,msg);
                 $(".idcard").val(null);
             }else if(data == "no"){
                $(".idcard").empty();
                var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                var msg ="<?php echo Yii::app()->session['lang'] == 1?'This ID card number is not correct as per the calculation of the civil registration database! ':'เลขบัตรประชาชนนี้ไม่ถูกต้อง ตามการคำนวณของระบบฐานข้อมูลทะเบียนราษฎร์!'; ?>"; 
                swal(alert_message,msg);
                $(".idcard").val(null);
            }else if(data == 'little'){
                $(".idcard").empty();
                var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                var msg ="<?php echo Yii::app()->session['lang'] == 1?'Incomplete 13 digit ID card number! ':'เลขบัตรประชาชนไม่ครบจำนวน13หลัก!'; ?>"; 
                swal(alert_message,msg);
                $(".idcard").val(null);
            }

        }
    });
    }
});

var new_forms = <?php echo $new_form; ?>;
                    //console.log(new_forms);
                    if (new_forms === 1 || new_forms === true) {   

                        var type_users = $("input[name='type_user']:checked").val();
                       
                        if (type_users === '3') {
                            $(".id_employee").hide();
                            $(".uploads_image").show();
                            $('.form_name').show();
                            $('.form_name_eng').show();
                        $('.form_number_id').hide();
                       $("#office-section").show();
                      // $(".form_language").show();
                       $("#office-section_gen").show();
                        $("#employee_type_1").hide();

                       $('.Branch').hide();
                       $('.label_branch').hide();
                       $('.form_identification').show();
                       $('.form_identification_5').show();
                       $('.form_passport').show();
                       $('.form_passport_5').show();
                       $('.form_sickness').hide();
                       $(".form_language").hide(); 
                       $('.children').hide();
                       $('.Spouse').hide();
                       $(".form_seamanbook").show();
                       $(".form_attach_identification").hide();
                       $(".form_attach_passport").hide();
                       $(".form_attach_crew_identification").hide();
                       $(".form_attach_house_registration").hide();
                       $(".form_birthday").show();
                       $(".form_place_of_birth").show();
                       $(".form_body").show();
                       $(".form_race").show();
                       $(".form_religion").show();
                       $(".form_marital_status").show();
                     //  $(".form_tel_nationality").hide();
                     $(".form_race_13").show();
                     $(".form_phone_5").hide();
                     $(".form_occupation_sex").hide();
                     $(".form_father").show();
                     $(".form_mother").show();
                     $(".form_accommodation").show();
                     $(".form_domicile_address").show();
                     $(".form_address").show();
                     $(".form_tel").show();
                     $(".form_emergency").show();
                     $(".form_email").show();
                     $(".form_military").show();
                     $(".form_history_of_severe_illness").show();
                     $(".form_Edu").show();
                     $(".form_WorkHistory").show();
                     $(".form_Qualification ").hide();
                     $(".form_Training").show();
                     $(".form_salary").hide();

                     $(".required_idline").hide();
                     // $(".required_identification").hide();
                     // $(".required_date_of_expiry").hide();

                                $(".required_Blood").hide();
           $(".required_Height").hide();
           $(".required_Weight").hide();
           $(".required_race").hide();
           $(".required_nationality").hide();
           $(".required_sex").hide();
           $(".required_father_firstname").hide();
           $(".required_father_lastname").hide();
           $(".required_mother_firstname").hide();
           $(".required_mother_lastname").hide();
           $(".required_nationality").hide();
           $(".required_Emergency").hide();
           $(".required_name_emergency").hide();
           $(".required_relationship_emergency").hide();
           $(".required_military").hide();
           $(".required_history_of_severe_illness").hide();
           $(".required_educational").hide();
           $(".required_Attachments_educational").hide();
           $(".required_marital_status").hide();
           $(".required_accommodation").hide();
           $(".required_domicile_address").hide();
           $(".required_address").hide();

           $(".form_attach_identification").hide();
           $(".form_attach_house_registration").hide();
           $(".form_Qualification ").hide();

                 }else if (type_users === '1'){

                   $(".id_employee").hide();
                   $(".uploads_image").show();
                   $('.form_name').show();
                   $('.form_name_eng').show();
                        $('.form_number_id').show();
                       $("#office-section").hide();
                       $("#office-section_gen").show();

                       $('.Branch').hide();
                       $('.label_branch').hide();
                       $('.form_identification').show();
                       $('.form_identification_5').show();
                       $('.form_passport').show();
                       $('.form_passport_5').show();
                       $('.form_sickness').hide();
                       $(".form_language").show(); 
                       $('.children').hide();
                       $('.Spouse').hide();
                       $(".form_seamanbook").hide();
                       $(".form_attach_identification").show();
                       $(".form_attach_passport").show();
                       $(".form_attach_crew_identification").hide();
                       $(".form_attach_house_registration").show();
                       $(".form_birthday").show();
                       $(".form_place_of_birth").show();
                       $(".form_body").show();
                       $(".form_race").show();
                       $(".form_religion").show();
                       $(".form_marital_status").show();
                       //$(".form_tel_nationality").hide();
                       $(".form_race_13").show();
                       $(".form_phone_5").hide();
                       $(".form_occupation_sex").hide();
                       $(".form_father").show();
                       $(".form_mother").show();
                       $(".form_accommodation").show();
                       $(".form_domicile_address").show();
                       $(".form_address").show();
                       $(".form_tel").show();
                       $(".form_emergency").show();
                       $(".form_email").show();
                       $(".form_military").show();
                       $(".form_history_of_severe_illness").show();
                       $(".form_Edu").show();
                       $(".form_WorkHistory").show();
                       $(".form_Qualification ").show();
                       $(".form_Training").show();
                       $(".form_salary").show();

                       $(".required_idline").hide();
                       $(".required_identification").show();
                       $(".required_date_of_expiry").show();

                                             // }
                                         }else if (type_users === '5'){
                                            $('.Branch').hide();
                                            $(".uploads_image").hide();
                                            $('.label_branch').hide();
                                            $(".id_employee").hide();
                                            $("#office-section").hide();
                                            $('.form_name').show();
                                            $('.form_name_eng').show();
                                            $('.form_number_id').show();
                                            
                                            $('.form_identification').show();
                                            $('.form_identification_5').hide();
                                            $('.form_passport').show();
                                            $('.form_passport_5').hide();
                                            $(".form_language").hide(); 
                                            $("#office-section_gen").hide();
                                            $('.form_sickness').hide();
                                            $('.children').hide();
                                            $('.Spouse').hide();
                                            $(".form_seamanbook").hide();
                                            $(".form_attach_identification").hide();
                                            $(".form_attach_passport").hide();
                                            $(".form_attach_crew_identification").hide();
                                            $(".form_attach_house_registration").hide();
                                          //  $(".form_tel_nationality").show();
                                          $(".form_race_13").hide();
                                          $(".form_phone_5").show();
                                          $(".form_occupation_sex").show();
                                          $(".form_birthday").show();
                                          $(".form_place_of_birth").hide();
                                          $(".form_body").hide();
                                          $(".form_race").show();
                                          $(".form_religion").hide();
                                          $(".form_marital_status").hide();
                                          $(".form_father").hide();
                                          $(".form_mother").hide();
                                          $(".form_accommodation").hide();
                                          $(".form_domicile_address").show();
                                          $(".form_address").hide();
                                          $(".form_tel").hide();
                                          $(".form_emergency").hide();
                                          $(".form_email").show();
                                          $(".form_military").hide();
                                          $(".form_history_of_severe_illness").hide();
                                          $(".form_Edu").show();
                                          $(".form_WorkHistory").hide();
                                          $(".form_Qualification ").hide();
                                          $(".form_Training").hide();

                                          $(".required_idline").hide();
                                          $(".required_identification").show();
                                          $(".required_date_of_expiry").show();

                                      }else if (typeof  type_users === 'undefined' ){
                                          $('.Branch').hide();
                                          $('.label_branch').hide();
                                          $(".id_employee").hide();
                                          $("#office-section").hide();
                                          $('.form_name').hide();
                                          $('.form_name_eng').hide();
                                          $('.form_number_id').hide();
                                          $('.form_identification').hide();
                                          $('.form_identification_5').hide();
                                          $('.form_passport').hide();
                                          $('.form_passport_5').hide();
                                          $(".form_language").hide(); 
                                          $("#office-section_gen").hide();
                                          $('.form_sickness').hide();
                                          $('.children').hide();
                                          $('.Spouse').hide();
                                          $(".form_seamanbook").hide();
                                          $(".form_attach_identification").hide();
                                          $(".form_attach_passport").hide();
                                          $(".form_attach_crew_identification").hide();
                                          $(".form_attach_house_registration").hide();
                                          $(".form_birthday").hide();
                                          $(".form_place_of_birth").hide();
                                          $(".form_body").hide();
                                          $(".form_race").hide();
                                          $(".form_religion").hide();
                                          $(".form_marital_status").hide();
                                         // $(".form_tel_nationality").hide();
                                         $(".form_race_13").hide();
                                         $(".form_phone_5").hide();
                                         $(".form_occupation_sex").hide();
                                         $(".form_father").hide();
                                         $(".form_mother").hide();
                                         $(".form_accommodation").hide();
                                         $(".form_domicile_address").hide();
                                         $(".form_address").hide();
                                         $(".form_tel").hide();
                                         $(".form_emergency").hide();
                                         $(".form_email").hide();
                                         $(".form_military").hide();
                                         $(".form_history_of_severe_illness").hide();
                                         $(".form_Edu").hide();
                                         $(".form_WorkHistory").hide();
                                         $(".form_Qualification ").hide();
                                         $(".form_Training").hide();

                                     }              
                                 }else if(new_forms === 0 || typeof  new_forms === 'undefined' || new_forms === false){
                                  
                                     var type_users = <?php  echo $profile->type_user != ""?$profile->type_user:0; ?>;
                        
                                     if (type_users === 3) {
                    // var type_cards = $("input[name='type_card']:checked").val();
                    // if (type_cards === 'l') {
                        var branch = <?php echo $branch_js; ?>;

                        if (branch === 1) {
                            $('.Branch').show();
                            $('.label_branch').show();
                        }else if(branch === 0){
                            $('.Branch').hide();
                            $('.label_branch').hide();
                        }

                        var sick = $("input[name='history_of_illness']:checked").val();
                        if (sick === 'y') {
                            $('.form_sickness').show();
                        }else{
                            $('.form_sickness').hide();
                        }
                        var child = $("input[name='status_sm']:checked").val();
                        if (child == 'm') {
                           $('.children').show();
                           $('.Spouse').show();
                       }else{
                           $('.children').hide();
                           $('.Spouse').hide();
                       }

                       // var type_employee = $("input[name='type_employee']:checked").val();
                       // if (type_employee == '1') {
                          $(".required_Blood").hide();
                           $(".required_Height").hide();
                           $(".required_Weight").hide();
                           $(".required_race").hide();
                           $(".required_nationality").hide();
                           $(".required_sex").hide();
                           $(".required_father_firstname").hide();
                           $(".required_father_lastname").hide();
                           $(".required_mother_firstname").hide();
                           $(".required_mother_lastname").hide();
                           $(".required_nationality").hide();
                           $(".required_Emergency").hide();
                           $(".required_name_emergency").hide();
                           $(".required_relationship_emergency").hide();
                           $(".required_military").hide();
                           $(".required_history_of_severe_illness").hide();
                           $(".required_educational").hide();
                           $(".required_Attachments_educational").hide();
                           $(".required_marital_status").hide();
                           $(".required_accommodation").hide();
                           $(".required_domicile_address").hide();
                           $(".required_address").hide();

                           $(".form_attach_identification").hide();
                           $(".form_attach_house_registration").hide();
                           $(".form_Qualification ").hide();
                       // }else if (type_employee == '2') {
                       //         $(".required_Blood").show();
                       //     $(".required_Height").show();
                       //     $(".required_Weight").show();
                       //     $(".required_race").show();
                       //     $(".required_nationality").show();
                       //     $(".required_sex").show();
                       //     $(".required_father_firstname").show();
                       //     $(".required_father_lastname").show();
                       //     $(".required_mother_firstname").show();
                       //     $(".required_mother_lastname").show();
                       //     $(".required_nationality").show();
                       //     $(".required_Emergency").show();
                       //     $(".required_name_emergency").show();
                       //     $(".required_relationship_emergency").show();
                       //     $(".required_military").show();
                       //     $(".required_history_of_severe_illness").show();
                       //    $(".required_educational").show();
                       //     $(".required_Attachments_educational").show();

                       //     $(".form_attach_identification").show();
                       //     $(".form_attach_house_registration").show();
                       //     $(".form_Qualification ").show();
                       // }
                        var type_card = $("input[name='type_card']:checked").val();
        
                                if (type_card === 'l') {
                                    $('.form_identification').show();
                                    $('.form_passport').hide();
                                    $('.form_identification_5').show();
                                    $('.form_passport_5').hide();
                                    // $(".form_attach_identification").show();
                                    // $(".form_attach_passport").hide();
                                }else if (type_card === 'p') {
                                    $('.form_identification').hide();
                                    $('.form_passport').show();
                                    $('.form_identification_5').hide();
                                    $('.form_passport_5').show();
                                    // $(".form_attach_identification").hide();
                                    // $(".form_attach_passport").show();
                                }
                           $(".id_employee").show();
                           $(".uploads_image").show();
                           $('.form_name').show();
                           $('.form_name_eng').show();
                           $('.form_number_id').show();
                           $("#office-section").show();
                           //$(".form_language").hide();
                           $("#office-section_gen").hide();
                           $("#employee_type_1").hide();
                           $(".form_language").hide(); 
                           $(".form_seamanbook").hide();
                           $(".form_attach_identification").hide();
                           $(".form_attach_passport").hide();
                           $(".form_attach_crew_identification").hide();
                           $(".form_attach_house_registration").hide();
                           $(".form_birthday").show();
                           $(".form_place_of_birth").show();
                           $(".form_body").show();
                           $(".form_race").show();
                           $(".form_religion").show();
                           $(".form_marital_status").show();
                           //$(".form_tel_nationality").hide();
                           $(".form_race_13").show();
                           $(".form_phone_5").hide();
                           $(".form_occupation_sex").hide();
                           $(".form_father").show();
                           $(".form_mother").show();
                           $(".form_accommodation").show();
                           $(".form_domicile_address").show();
                           $(".form_address").show();
                           $(".form_tel").show();
                           $(".form_emergency").show();
                           $(".form_email").show();
                           $(".form_military").show();
                           $(".form_history_of_severe_illness").show();
                           $(".form_Edu").show();
                           $(".form_WorkHistory").show();
                           $(".form_Qualification ").hide();
                           $(".form_Training").show();

                           $(".required_idline").hide();
                           // $(".required_identification").hide();
                           // $(".required_date_of_expiry").hide();
                       }else if (type_users === 1){

                                var sick = $("input[name='history_of_illness']:checked").val();
                                if (sick === 'y') {
                                    $('.form_sickness').show();
                                }else{
                                    $('.form_sickness').hide();
                                }
                                var child = $("input[name='status_sm']:checked").val();
                                if (child == 'm') {
                                   $('.children').show();
                                   $('.Spouse').show();
                               }else{
                                   $('.children').hide();
                                   $('.Spouse').hide();
                               }
                               $(".id_employee").hide();
                               $(".uploads_image").show();
                               $('.form_name').show();
                               $('.form_name_eng').show();
                               $('.form_number_id').hide();
                               $("#office-section").hide();
                               $(".form_language").show();
                               $("#office-section_gen").show();

                               $('.Branch').hide();
                               $('.label_branch').hide();
                               $('.form_identification').show();
                               $('.form_identification_5').show();
                               $('.form_passport').show();
                               $('.form_passport_5').show();
        
                               $(".form_seamanbook").show();
                               $(".form_attach_identification").show();
                               $(".form_attach_passport").show();
                               $(".form_attach_crew_identification").show();
                               $(".form_attach_house_registration").show();
                               $(".form_birthday").show();
                               $(".form_place_of_birth").show();
                               $(".form_body").show();
                               $(".form_race").show();
                               $(".form_religion").show();
                               $(".form_marital_status").show();
                              // $(".form_tel_nationality").hide();
                              $(".form_race_13").show();
                              $(".form_phone_5").hide();
                              $(".form_occupation_sex").hide();
                              $(".form_father").show();
                              $(".form_mother").show();
                              $(".form_accommodation").show();
                              $(".form_domicile_address").show();
                              $(".form_address").show();
                              $(".form_tel").show();
                              $(".form_emergency").show();
                              $(".form_email").show();
                              $(".form_military").show();
                              $(".form_history_of_severe_illness").show();
                              $(".form_Edu").show();
                              $(".form_WorkHistory").show();
                              $(".form_Qualification ").show();
                              $(".form_Training").show();

                              $(".required_idline").hide();
                              $(".required_identification").hide();
                              $(".required_date_of_expiry").hide();
                              $(".required_educational").show();

                          }else if(type_users === 5){
                            var type_card = $("input[name='type_card']:checked").val();
                                if (type_card === 'l') {
                                    $('.form_identification').show();
                                    $('.form_passport').hide();
                                }else if (type_card === 'p') {
                                    $('.form_identification').hide();
                                    $('.form_passport').show();
                                }
                            $('.Branch').hide();
                            $(".uploads_image").hide();
                            $('.label_branch').hide();
                            $(".id_employee").hide();
                            $("#office-section").hide();
                            $('.form_name').show();
                            $('.form_name_eng').show();
                            $('.form_number_id').show();
                            
                            // $('.form_identification').show();
                            $('.form_identification_5').hide();
                            // $('.form_passport').show();
                            $('.form_passport_5').hide();
                            $(".form_language").hide(); 
                            $("#office-section_gen").hide();
                            $('.form_sickness').hide();
                            $('.children').hide();
                            $('.Spouse').hide();
                            $(".form_seamanbook").hide();
                            $(".form_attach_identification").hide();
                            $(".form_attach_passport").hide();
                            $(".form_attach_crew_identification").hide();
                            $(".form_attach_house_registration").hide();
                            //$(".form_tel_nationality").show();
                            $(".form_race_13").hide();
                            $(".form_phone_5").show();
                            $(".form_occupation_sex").show();
                            $(".form_birthday").show();
                            $(".form_place_of_birth").hide();
                            $(".form_body").hide();
                            $(".form_race").show();
                            $(".form_religion").hide();
                            $(".form_marital_status").hide();
                            $(".form_father").hide();
                            $(".form_mother").hide();
                            $(".form_accommodation").hide();
                            $(".form_domicile_address").show();
                            $(".form_address").hide();
                            $(".form_tel").hide();
                            $(".form_emergency").hide();
                            $(".form_email").show();
                            $(".form_military").hide();
                            $(".form_history_of_severe_illness").hide();
                            $(".form_Edu").show();
                            $(".form_WorkHistory").hide();
                            $(".form_Qualification ").hide();
                            $(".form_Training").hide();

                            $(".required_idline").hide();
                            $(".required_identification").show();
                            $(".required_date_of_expiry").show();

                        }  
                    }  
                 // $("input[name='type_employee']").prop("checked", true);


                 $('#card-1').change(function(event) {
                    var type_users = $("input[name='type_user']:checked").val();
                                if (type_users === '3') {
                                     $('.form_passport').hide();
                                     $('.form_identification').show();
                                     $('.form_identification_5').show();
                                     $('.form_passport_5').hide();
                                     $(".form_attach_identification").hide();
                                     $(".form_attach_passport").hide();
                                }else if (type_users === '5') {
                                     $('.form_passport').hide();
                                     $('.form_identification').show();
                                     $('.form_identification_5').hide();
                                     $('.form_passport_5').hide();
                                     $(".form_attach_identification").hide();
                                     $(".form_attach_passport").hide();
                                }
                });

                 $('#card-2').change(function(event) {
                        var type_users = $("input[name='type_user']:checked").val();
                                if (type_users === '3') {
                                     $('.form_passport').show();
                                     $('.form_identification').hide();
                                     $('.form_identification_5').hide();
                                     $('.form_passport_5').show();
                                     $(".form_attach_identification").hide();
                                     $(".form_attach_passport").hide();
                                 }else if (type_users === '5') {
                                     $('.form_passport').show();
                                     $('.form_identification').hide();
                                     $('.form_identification_5').hide();
                                     $('.form_passport_5').hide();
                                     $(".form_attach_identification").hide();
                                     $(".form_attach_passport").hide();
                                 }
                    // $('.form_passport').show();
                    // $('.form_identification').hide();
                    // $('.form_identification_5').hide();
                    // $('.form_passport_5').show();
                });

                $(".department").change(function() {
                    var id = $(".department").val();
                    var type_users = $("input[name='type_user']:checked").val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('Registration/ListPosition'); ?>",
                        data: {
                            id: id,
                            type_users: type_users,
                        },
                        success: function(data) {
                            // console.log(data);
                            // if (data === '<option value ="">Select Pocition </option>' || data === '<option value ="">เลือกตำแหน่ง</option>') {
                            // $('.position').hide();
                            // $('.label_position').hide();
                            // $('.Branch').hide();
                            // $('.label_branch').hide();
                            // }else{
                                $('.position').empty();
                                $('.position').append(data);
                                $('.Branch').hide();
                                $('.label_branch').hide();
                            // }
                        }
                    });
                });
                $(".department_gen").change(function() {
                    var id = $(this).val();
                    var type_users = $("input[name='type_user']:checked").val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('Registration/ListPosition'); ?>",
                        data: {
                            id: id,
                            type_users: type_users,
                        },
                        success: function(data) {
                            console.log(data);

                            $('.position_gen').empty();
                            $('.position_gen').append(data);
                        }
                    });
                });
                $(".position").change(function() {
                    var id = $(".position").val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('Registration/ListBranch'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {
                           // console.log(data);
                            if (data === '<option value ="">Select Level </option>' || data === '<option value ="">เลือกระดับ</option>') {
                                $('.Branch').hide();
                                $('.label_branch').hide();
                            }else{

                                $('.Branch').show();
                                $('.label_branch').show();
                                $('.Branch').empty();
                                $('.Branch').append(data);
                            }
                        }
                    });
                });

                $(".birth").change(function() {
                    var item = $(".birth").val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('Registration/CalculateBirthday'); ?>",
                        data: {
                            item: item
                        },
                        success: function(data) {

                           if (data == 0) {

                            var alert_message ="<?php echo Yii::app()->session['lang'] == 1?'Warning message! ':'ข้อความแจ้งเตือน!'; ?>"; 
                            var msg ="<?php echo Yii::app()->session['lang'] == 1?'The date of birth is greater than or equal to the current time! ':'วันเดือนปีเกิดมากกว่าหรือเท่ากับเวลาปัจจุบัน!'; ?>"; 
                            swal(alert_message,msg);
                            $(".birth").val(null);
                            $('.ages').val(null);
                        }else{
                         var datas = data.split("-");
                         $('.ages').val(datas[0]);
                         $('.ages').append(datas[0]);
                         $('.mouth').val(datas[1]);
                         $('.mouth').append(datas[1]);
                     }
                 }
             });
                });
            });
        </script>





<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content crop-img">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php 
                    if(Yii::app()->session['lang'] == 1){
                        echo "Create image";                        
                    }else{
                        echo "สร้างรูปประจำตัว";
                    }
                    ?>
                 </h4>
            </div>
            <div class="modal-body">
                <div id="upload-profileimg" class="center-block"></div>
                <div class="text-center center-block mt-2">
                    <button class="rotate_btn rotate_left btn" data-deg="90"><i class="fas fa-undo"></i> 
                    <?php 
                    if(Yii::app()->session['lang'] == 1){
                        echo "Rotate Left";                        
                    }else{
                        echo "หมุนซ้าย";
                    }
                    ?></button>
                    <button class="rotate_btn rotate_right btn" data-deg="-90"><i class="fas fa-redo-alt"></i> 
                    <?php 
                    if(Yii::app()->session['lang'] == 1){
                        echo "Rotate Right";                        
                    }else{
                        echo "หมุนขวา";
                    }
                    ?></button>
                </div >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cropcancel" data-dismiss="modal">
                <?php 
                    if(Yii::app()->session['lang'] == 1){
                        echo "cancel";                        
                    }else{
                        echo "ยกเลิก";
                    }
                    ?>                        
                    </button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">
                <?php 
                    if(Yii::app()->session['lang'] == 2){
                        echo "บันทึกรูป";                                               
                    }else{
                        echo "Save";
                    }
                    ?>
                    </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // crop รูปภาพ
var $uploadCrop,
tempFilename,
rawImg,
imageId;


function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.upload-profileimg').addClass('ready');
            $('#cropImagePop').modal('show');
            rawImg = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);

        console.log($("#Profile_pro_pic").val());
    } else {
        if(<?= Yii::app()->session['lang'] ?> == 2){
            swal("ท่านยังไม่ได้เลือกรูป");                      
        }else{
            swal("Please select image");
        }
        
        // swal("ขออภัย - เบราว์เซอร์ของคุณไม่รองรับ FileReader API");
    }
}

$uploadCrop = $('#upload-profileimg').croppie({
    viewport: {
        width: 120,
        height: 120,
    },
    showZoomer: true,
    enableOrientation: true,
    enforceBoundary: true,
    enableExif: true
});

// $('.rotate_left, .rotate_right').on('click', function (ev) {
//     imageCrop.croppie('rotate', parseInt($(this).data('deg')));
//     });

$('.rotate_btn').on('click', function(ev) {
        $uploadCrop.croppie('rotate', $(this).attr("data-deg"));
    });

$('#cropImagePop').on('shown.bs.modal', function() {
    $uploadCrop.croppie('bind', {
        url: rawImg,
        // orientation: 2
    }).then(function() {});
});

$('.item-img').on('change', function() {
    imageId = $(this).data('id');
    tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId);
    readFile(this);
});
$('#cropImageBtn').on('click', function(ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: {
            width: 150,
            height: 150
        }
    }).then(function(resp) {
        $('#item-img-output').attr('src', resp);
        $('#cropImagePop').modal('hide');
        $('#url_pro_pic').val($('#item-img-output').attr('src'));
    });
});

$('#cropcancel').on('click', function(ev) {
$("#Profile_pro_pic").val("");
    });
</script>



    </section>
    <div class="login-bg">
        <img class="login-img-1" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg3.png">
        <img class="login-img-2" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg4.png">
    </div>