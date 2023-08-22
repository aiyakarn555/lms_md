<div class="innerLR">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>เพิ่มแบบสอบถาม</h4>
        </div>
        <div class="widget-body">
            <div class="row-fluid">
                <?php echo CHtml::form('', '', array('id' => 'form')); ?>
                <?php
                $arrDropDownTitle = "";
                $arrDropDownType = "";
                $QuestionTH = "";
                $QuestionEN = "";
                $DetailTH = "";
                $DetailEN = "";
                $empty = "IsEmpty";
                if ($arrQuestion != null) {
                    $arrDropDownTitle = array('options' => array($arrQuestion[0]->Tit_nID => array('selected' => true)));
                    $arrDropDownType = array('options' => array($arrQuestion[0]->Tan_nID => array('selected' => true)));
                    $QuestionTH = $arrQuestion[0]->Que_cNameTH;
                    $QuestionEN = $arrQuestion[0]->Que_cNameEN;
                    $DetailTH = $arrQuestion[0]->Que_cDetailTH;
                    $DetailEN = $arrQuestion[0]->Que_cDetailEN;
                    $empty = "NotEmpty";
                }
                echo CHtml::dropDownList('dropdownTitle', '', $dropdownTitle, $arrDropDownTitle);
                echo CHtml::tag('br');

                echo CHtml::label('TH คำถาม', '');
                echo CHtml::textField('txtQuestionTH', $QuestionTH
                    , array('id' => 'txtQuestionTH', 'onkeyup' => 'txtKeyUp(this)'));
                echo CHtml::label(' * กรุณากรอกข้อมูล', ''
                    , array('id' => 'txtQuestionTH', '', 'class' => $empty . ' red'));
                echo CHtml::tag('br');

                echo CHtml::label('EN คำถาม', '');
                echo CHtml::textField('txtQuestionEN', $QuestionEN
                    , array('id' => 'txtQuestionEN', 'onkeyup' => 'txtKeyUp(this)'));
                echo CHtml::label(' * กรุณากรอกข้อมูล', ''
                    , array('id' => 'txtQuestionEN', '', 'class' => $empty . ' red'));
                echo CHtml::tag('br');

                echo CHtml::label('TH คำอธิบาย', $DetailTH);
                echo CHtml::textArea('txtDetailTH', '');
                echo CHtml::tag('br');

                echo CHtml::label('EN คำอธิบาย', $DetailEN);
                echo CHtml::textArea('txtDetailEN', '');
                echo CHtml::tag('br');

                /*echo CHtml::button('ตกลง',array('id'=>'txtOkay'));
                echo CHtml::button('ยกเลิก',array('id'=>'txtCancel'));*/


                echo CHtml::dropDownList('dropdownType', '', $dropdownType
                    , $arrDropDownType);
                echo CHtml::tag('br');
                echo CHtml::openTag('div', array('id' => 'AnswerDiv'));
                $countAnswer = 0;
                $countSubAnswer = 0;
                if ($arrChoice != null) {
                    foreach ($arrChoice as $key1 => $value1) {
                        echo CHtml::openTag('div', array('id' => 'divAns' . $countAnswer, 'class' => 'marginAns'));
                        echo CHtml::openTag('div');
                        echo CHtml::label('คำตอบ', '');
                        echo CHtml::button('ลบคำตอบ'
                            , array('id' => $countAnswer, 'onclick' => 'removeAnswer(this)', 'class' => 'btn btn-primary'));
                        echo CHtml::closeTag('div');

                        echo CHtml::openTag('div');
                        echo CHtml::label('TH คำตอบ', '');
                        echo CHtml::textField('txtAnswerTH' . $countAnswer, $value1[0]->Cho_cNameTH
                            , array('id' => 'txtAnswerTH' . $countAnswer, 'onkeyup' => 'txtKeyUp(this)'));
                        echo CHtml::label(' * กรุณากรอกข้อมูล', ''
                            , array('id' => 'txtAnswerTH' . $countAnswer, '', 'class' => 'NotEmpty red'));
                        echo CHtml::closeTag('div');

                        echo CHtml::openTag('div');
                        echo CHtml::label('EN คำตอบ', '');
                        echo CHtml::textField('txtAnswerEN' . $countAnswer, $value1[0]->Cho_cNameEN
                            , array('id' => 'txtAnswerEN' . $countAnswer, 'onkeyup' => 'txtKeyUp(this)'));
                        echo CHtml::label(' * กรุณากรอกข้อมูล', ''
                            , array('id' => 'txtAnswerEN' . $countAnswer, '', 'class' => 'NotEmpty red'));
                        echo CHtml::closeTag('div');

                        echo CHtml::openTag('div');
                        echo CHtml::checkBox('chkAnswer' . $countAnswer, $value1[0]->stat_txt);
                        echo CHtml::label('มีช่องให้กรอกเพิ่มเติม', '');
                        echo CHtml::closeTag('div');
                        echo CHtml::openTag('div', array('id' => 'divSub' . $countAnswer));
                        if ($arrSubChoice != null) {
                            foreach ($arrSubChoice[$countAnswer] as $key2 => $value2) {
                                if ($value1[0]->Cho_nID != $value2->Cho_nID) {
                                    continue;
                                }
                                echo CHtml::openTag('div', array('id' => 'divSubAns' . $countSubAnswer, 'class' => 'marginSubAns'));
                                echo CHtml::openTag('div');
                                echo CHtml::label('คำตอบย่อย', '');
                                echo CHtml::button('ลบคำตอบย่อย', array('id' => $countSubAnswer, 'onclick' => 'removeSubAnswer(this)', 'class' => 'btn btn-primary'));
                                echo CHtml::closeTag('div');

                                echo CHtml::openTag('div');
                                echo CHtml::label('TH คำตอบย่อย', '');
                                echo CHtml::textField('txtSubAnswerTH' . $countAnswer . '[]', $value2->Sch_cNameTH
                                    , array('id' => 'txtSubAnswerTH' . $countSubAnswer
                                    , 'onkeyup' => 'txtKeyUp(this)'));
                                echo CHtml::label(' * กรุณากรอกข้อมูล', ''
                                    , array('id' => 'txtSubAnswerTH' . $countSubAnswer, '', 'class' => 'NotEmpty red'));
                                echo CHtml::closeTag('div');

                                echo CHtml::openTag('div');
                                echo CHtml::label('EN คำตอบย่อย', '');
                                echo CHtml::textField('txtSubAnswerEN' . $countAnswer . '[]', $value2->Sch_cNameEN
                                    , array('id' => 'txtSubAnswerEN' . $countSubAnswer
                                    , 'onkeyup' => 'txtKeyUp(this)'));
                                echo CHtml::label(' * กรุณากรอกข้อมูล', ''
                                    , array('id' => 'txtSubAnswerEN' . $countSubAnswer, '', 'class' => 'NotEmpty red'));
                                echo CHtml::closeTag('div');

                                echo CHtml::openTag('div');
                                echo CHtml::checkBox('chkSubAnswer' . $countAnswer . '[]', $value2->stat_txt);
                                echo CHtml::label('มีช่องให้กรอกเพิ่มเติม', '');
                                echo CHtml::closeTag('div');
                                echo CHtml::closeTag('div');
                                ++$countSubAnswer;
                            }
                        }
                        echo CHtml::closeTag('div');
                        echo CHtml::openTag('div');
                        if ($arrQuestion[0]->Tan_nID == 2) {
                            echo CHtml::button('เพิ่มคำตอบย่อย'
                                , array('id' => $countAnswer, 'onclick' => 'addSubAnswer(this)', 'class' => 'btn btn-primary'));
                        }
                        echo CHtml::closeTag('div');
                        echo CHtml::closeTag('div');
                        ++$countAnswer;
                    }
                }
                echo CHtml::closeTag('div');
                if ($arrQuestion != null) {
                    if ($arrQuestion[0]->Tan_nID == 1 || $arrQuestion[0]->Tan_nID == 2) {
                        echo CHtml::button('เพิ่มคำตอบ', array('id' => 'btnAddAnswer', 'class' => 'btn btn-primary'));
                        echo CHtml::tag('br');
                    }
                }

                echo CHtml::button($button_text, array('id' => 'submit', 'class' => 'btn btn-primary'));
                echo CHtml::label('กรุณากรอกข้อมูลที่มีเครื่องหมาย * ให้ครบถ้วน', ''
                    , array('id' => 'lblchkempty', 'class' => 'show red'));
                echo CHtml::submitButton('', array('name' => $type_button, 'id' => 'btnSubmit', 'style' => 'display:none', 'class' => 'btn btn-default'));
                echo CHtml::tag('br');
                ?>

                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/jquery/jquery-1.11.3.min.js"); ?>
<script type="text/javascript">
    var countAnswer = <?php echo $countAnswer;?>;
    var countSubAnswer = <?php echo $countSubAnswer;?>;
    createAnsCookie(countSubAnswer);
    $('#dropdownType').change(function () {
        $.post('index.php?r=Questionnaire/AddAnswer', {
            select: $('#dropdownType').val(),
            countAns: countAnswer,
        }, function (result) {
            $('#AnswerDiv').empty();
            if (result == "") {
                $('#btnAddAnswer').hide();
                $('#btnDelAnswer').hide();
            } else {
                createAnsCookie(++countAnswer);
                $('#btnAddAnswer').show();
                $('#btnDelAnswer').show();
                $('#AnswerDiv').html(result);
                $('#form #lblchkempty').removeClass('hide').addClass('show');
            }
        });
    });
    $('#btnAddAnswer').click(function () {
        $.post('index.php?r=Questionnaire/AddAnswer', {
            select: $('#dropdownType').val(),
            countAns: countAnswer,
        }, function (result) {
            $("#AnswerDiv").append(result);
            createAnsCookie(++countAnswer);
            $('#form #lblchkempty').removeClass('hide').addClass('show');
        });
    });
    function createAnsCookie(counter) {
        document.cookie = "countAnswer=" + counter;
    }
    function removeAnswer(tagId) {
        $('#divAns' + tagId.id).remove();
        if ($('#form label.IsEmpty').length == 0) {
            $('#form #lblchkempty').removeClass('show').addClass('hide');
        }
    }
    function addSubAnswer(tagId) {
        $.post('index.php?r=Questionnaire/AddSubAnswer', {
            countSubAns: ++countSubAnswer,
            countAns: tagId.id,
        }, function (result) {
            $('#divSub' + tagId.id).append(result);
            $('#form #lblchkempty').removeClass('hide').addClass('show');
        });
    }
    function removeSubAnswer(tagId) {
        $('#divSubAns' + tagId.id).remove();
        if ($('#form label.IsEmpty').length == 0) {
            $('#form #lblchkempty').removeClass('show').addClass('hide');
        }
    }

    $('#submit').click(function () {
        if ($('#form label.IsEmpty').length == 0) {
            $('#btnSubmit').trigger('click');
        } else {
            $('input:text#' + $('#form label.IsEmpty').attr('id')).focus();
        }
    });
    function txtKeyUp(tagId) {
        if ($('#' + tagId.id).val().trim().length == 0) {
            $('#form label#' + tagId.id).removeClass('NotEmpty').addClass('IsEmpty');
            $('#form #lblchkempty').removeClass('hide').addClass('show');
        } else {
            $('#form label#' + tagId.id).removeClass('IsEmpty').addClass('NotEmpty');
            if ($('#form label.IsEmpty').length == 0) {
                $('#form #lblchkempty').removeClass('show').addClass('hide');
            }
        }
    }
</script>

<style>
    .red {
        color: #FF0000;
    }

    .hide {
        visibility: hidden;
    }

    .show {
        visibility: inline;
    }

    .IsEmpty {
        visibility: inline;
    }

    .NotEmpty {
        visibility: hidden;
    }

    .marginSubAns {
        margin-top: 20px;
        margin-left: 50px;
    }

    .marginAns {
        margin-top: 10px;
    }
</style>
