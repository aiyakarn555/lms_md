<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_contactus ?></li>
        </ol>
    </nav>
</div>

<section class="content" id="contact-us">
    <div class="container">
    <div class="row justify-content-center gy-4">
                    <!-- <div class="col-lg-6 pt-3">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/Company.png" class="img-fluid mt-3" alt="Company">
                    </div> -->
                    <div class="col-lg-12">
                        <h4 class="contact-title"><span>Admin</span></h4>
                        <div class="row pt-2 gy-3">
                            <?php 
                                if ($ContactusNew_data) {
                                foreach ($ContactusNew_data as $key => $value) {      
                            ?>
                            <div class="col-sm-6">
                                <div class="card border p-2">
                                    <?php
                                        if ($value['con_image'] == null) {

                                            $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                                        } else {
                                        
                                            $img = Yii::app()->baseUrl . '/uploads/contactusnew/' . $value['id'] . '/' . $value['con_image'];
                                        }
                                    ?>
                                      <img src="<?php echo $img ?>" class="img-fluid">
                                    <div class="contect-detial">
                                        <p>
                                        <?php 
                                            if (Yii::app()->session['lang'] == 2) {
                                                echo $value['con_firstname']." ".$value['con_lastname'];
                                            }else{
                                                echo $value['con_firstname_en']." ".$value['con_lastname_en'];
                                            }
                                        ?>                                        
                                        </p>
                                        <p>Position : 
                                        <?php
                                            if (Yii::app()->session['lang'] == 2) {
                                                echo $value['con_position'];
                                            }else{
                                                echo $value['con_position_en'];
                                            }
                                        ?> 
                                        </p>
                                        <p>Phone Number : 
                                         <?php
                                            echo $value['con_tel'];
                                        ?>
                                        </p>
                                        <p>Email : <?php
                                            echo $value['con_email'];
                                        ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                }// end foreach
                                }// end if
                            ?>

                            <!-- <div class="col-sm-6">
                                <div class="card border p-2">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/avatar-2.png" class="img-fluid">
                                    <div class="contect-detial">
                                        <p>Mr. FirstName LastName</p>
                                        <p>Position : Admin staff</p>
                                        <p>Phone Number : 0-2966-2111</p>
                                        <p>Email : info@isuzu-tis.com</p>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                    </div>

                </div>
    </div>
</section>

