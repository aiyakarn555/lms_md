<?php

class SendEmailController extends Controller{


	public function actionSendEmail()	{	
		
		$this->mailsend();
			
			$this->render("SendEMail");
	}


public function mailsend(){
   			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mail = new JPhpMailer;
			$mail->IsSMTP();
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPDebug = 0;
			//$mail->Debugoutput = 'html';
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->Username = 'peerapon.lim@gmail.com';
			$mail->Password = 'dokapon747';

			$mail->SetFrom('peerapon.lim@gmail.com', 'peerapon');
			$mail->Subject = 'PHPMailer Test Subject via smtp, basic with authentication';
			$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			$mail->MsgHTML('<h1>JUST A TEST YEAH</h1>');
			$mail->AddAddress('analysiz01@gmail.com', 'analysiz');
 			if(!$mail->Send()) {
            	echo "Mailer Error: " . $mail->ErrorInfo;
        	}else {
            	echo "<script>alert('Message sent!');</script>";
       		 }
}

}