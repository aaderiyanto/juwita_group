<?php
/**
 * Created by BMT Solutions.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@bilikmelayu.com
 * Website : https://bilikmelayu.com
 */
class mailerfungsi extends MethodFungsi{
	private $mailer = NULL;
	public function __construct() {
		$this->mailer = new PHPMailer;
    }
	
	public function kirim_email($subject,$to,$isi_email,$cc="",$bcc="",$replay="",$atc_file=""){
		$arr_setting = $this->data_array("setup_mail","1");
		$this->mailer->isSMTP();
		//$this->mailer->Host = 'smtp.gmail.com'; = Set GMAIL.COM
		$this->mailer->Host = $arr_setting->smtp_host;
		$this->mailer->SMTPAuth = true;
		$this->mailer->Username = $arr_setting->smtp_user;
		$this->mailer->Password = $arr_setting->smtp_pass;
		//$this->mailer->SMTPSecure = 'ssl'; // for SSL Conection
		//$this->mailer->SMTPDebug = 1;
		$this->mailer->Port = $arr_setting->smtp_port;
		$this->mailer->setFrom($arr_setting->from_sending, $arr_setting->alias_name);
		if(!empty($to)){
			$exp_to = explode(",",$to);
			foreach($exp_to as $to_email){
			$this->mailer->addAddress($to_email);
			}
		}
		//$this->mailer->addAddress($to);
		if(!empty($replay)){
			$exp_reply = explode(",",$replay);
			foreach($exp_reply as $replay_email){
			$this->mailer->addReplyTo($replay_email);
			}
		}
		if(!empty($cc)){
			$exp_cc = explode(",",$cc);
			foreach($exp_cc as $cc_email){
			$this->mailer->addCC($cc_email);
			}
		}
		if(!empty($bcc)){
			$exp_bcc = explode(",",$bcc);
			foreach($exp_bcc as $bcc_email){
			$this->mailer->addBCC($bcc_email);
			}
		}
		if(!empty($atc_file)){
			$this->mailer->addAttachment(ROOT_DIR.$atc_file);
			//unlink(ROOT_DIR.$atc_file); // delete attach
		}
		$this->mailer->Subject = $subject;
		$this->mailer->isHTML(true);
		$this->mailer->Body = $isi_email;
		if(!$this->mailer->send()) {
			$mail_sukses = "0";
			//$mail_sukses = $this->mailer->ErrorInfo;
		} 
		else {
			$mail_sukses = "1";
		}
		return $mail_sukses;
	}
}
$send_mailer = new mailerfungsi;
?>