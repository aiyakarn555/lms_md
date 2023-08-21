<?php
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
} else {
    $langId = Yii::app()->session['lang'];
}
if (Yii::app()->session['lang'] == 2) {
    $txtShow["Contactus"] = "ติดต่อเรา";
    $txtShow["Tel"] = "โทรศัพท์";
    $txtShow["Email"] = "อีเมล";
} else {
    $txtShow["Contactus"] = "Contact Us";
    $txtShow["Tel"] = "Tel";
    $txtShow["Email"] = "Email";
}

?>
<section class="content-page">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $txtShow["Contactus"] ?></li>
            </ol>
        </nav>

        <div class="content-main">

            <section class="contact">
                <div class="row mb-4 mt-3 ">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="google-map mt-0 mb-3" >
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.7691679722725!2d100.51100081483024!3d13.732420490359951!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e298ded5efeb5b%3A0x29db48b55d77f3a5!2z4LiB4Lij4Lih4LmA4LiI4LmJ4Liy4LiX4LmI4Liy!5e0!3m2!1sth!2sth!4v1643098051109!5m2!1sth!2sth" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>

                    </div>
                    <div class="col-lg-6 px-0 card-right-contact">
                        <h3 class="mb-3"><?= $about_data['about_title'] ?></h3>
                        <div class="row card-body mt-2">
                            <div class="col-lg-2 col-xs-12">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <path d="M27.2015 19.7858L21.0764 17.1607C20.8147 17.0492 20.5239 17.0257 20.2477 17.0938C19.9716 17.1618 19.725 17.3178 19.5451 17.5381L16.8326 20.8522C12.5755 18.845 9.14949 15.4191 7.14231 11.162L10.4564 8.44942C10.6772 8.26987 10.8335 8.02327 10.9015 7.74697C10.9696 7.47067 10.9458 7.17971 10.8338 6.91814L8.20874 0.793034C8.08575 0.511065 7.86823 0.280846 7.59368 0.142076C7.31914 0.003306 7.00478 -0.0353181 6.7048 0.0328641L1.01721 1.34539C0.727996 1.41217 0.469963 1.57501 0.285219 1.80733C0.100476 2.03965 -6.6622e-05 2.32773 3.31205e-08 2.62455C3.31205e-08 16.6521 11.3697 28 25.3754 28C25.6724 28.0002 25.9606 27.8997 26.193 27.715C26.4254 27.5302 26.5883 27.2721 26.6551 26.9828L27.9677 21.2952C28.0354 20.9938 27.996 20.6781 27.8561 20.4027C27.7163 20.1272 27.4848 19.909 27.2015 19.7858Z" fill="#418cd1" />
                                </svg>
                            </div>
                            <div class="col-lg-10 col-xs-12">
                                <h4 class="contact-tel mb-1"><?=$txtShow["Tel"]?></h4>
                                <p><?= $about_data['about_tel'];  ?> (เจ้าหน้าที่ฝ่ายบริการ)</p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="underline text-center">
                                </div>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35" fill="none">
                                    <g clip-path="url(#clip0_448_29697)">
                                        <path d="M20.425 21.4437C19.5543 22.0242 18.5428 22.3311 17.5 22.3311C16.4572 22.3311 15.4458 22.0242 14.575 21.4437L0.233037 11.8821C0.153467 11.829 0.0759473 11.7737 0 11.7169V27.3846C0 29.181 1.45776 30.6066 3.22198 30.6066H31.7779C33.5743 30.6066 34.9999 29.1489 34.9999 27.3846V11.7168C34.9238 11.7738 34.8462 11.8292 34.7664 11.8824L20.425 21.4437Z" fill="#418cd1" />
                                        <path d="M1.37061 10.1762L15.7126 19.7379C16.2555 20.0999 16.8777 20.2808 17.4999 20.2808C18.1222 20.2808 18.7445 20.0998 19.2874 19.7379L33.6294 10.1762C34.4876 9.60439 35 8.64735 35 7.61444C35 5.8384 33.5551 4.39355 31.7791 4.39355H3.22089C1.44491 4.39362 0 5.83847 0 7.61615C0 8.64735 0.512422 9.60439 1.37061 10.1762Z" fill="#418cd1" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_448_29697">
                                            <rect width="35" height="35" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div class="col-lg-10 col-xs-12">
                                <h4 class="contact-email mb-1"><?=$txtShow["Email"]?></h4>
                                <p><?= $about_data['about_email'] ?></p>
                            </div>
                            <div class="col-lg-2 col-xs-12">
                            </div>
                            <div class="col-lg-10 col-xs-12">
                                <p><?= $about_data['about_detail'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</section>