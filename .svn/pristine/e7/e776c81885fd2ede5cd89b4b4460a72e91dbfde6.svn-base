<?php
class sesEmail{
     public static function sendRaw($bcc,$subject,$body,$to){
            
            $raw_email = '
            To: '. $to.'
            From: questions@provoweb.com
            Bcc: '.$bcc.'
                Subject: '.$subject.'
            Mime-Version: 1.0
            Content-type: text/html; charset="iso-8859-1"
            
            <html>'.$body.'</html>';
           $email = new AmazonSES();
 
            $response = $email->send_raw_email(array(
                'Data' => base64_encode($raw_email),
            ), array(
                'Source' => 'questions@provoweb.com',
                'Destinations' => array(
                    $to
                )
            ));
            
            
        }
	public static function sendMail($email,$subject,$message,$replyToAddress=null, $overRideFromAddress=null) {
    	$adminEmail = Yii::app()->params['adminEmail'];
	    $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	    $message = wordwrap($message, 70);
	    $message = str_replace("\n.", "\n..", $message);
            $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
            $opt = isset($replyToAddress) && ($replyToAddress != null) ? array('ReplyToAddresses' => $replyToAddress) : NULL;
            $fromAddress = isset($overRideFromAddress) && ($overRideFromAddress != null) ? $overRideFromAddress : "questions@provoweb.com";

            $amazonSes = new AmazonSES();
 
            $response = $amazonSes->send_email(
                $fromAddress,
                array('ToAddresses' => array($email)),
                array(
                    'Subject.Data' => $subject,
                    'Body.Text.Data' => $message,
                ),
                $opt
            );
            return $response;
            
	    //return mail($email,$subject,$message,$headers);
	}
}
?>