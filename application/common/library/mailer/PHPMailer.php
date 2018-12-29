<?php

namespace app\library\mailer;

/**
 * This mailer class is responsible for sending emails via PHPMailer 
 * 
 * @author DuyAnh
 *
 */
class PHPMailer extends Mailer
{
	/**
	 * {@inheritDoc}
	 * @see \app\library\mailer\Mailer::init()
	 */
	protected function init()
	{
		//create mailer instance
		$this->mailer = new \PHPMailer();
		//set server
		$this->mailer->IsSMTP();
		$this->mailer->Host = $this->smtpHost;
		$this->mailer->Port = $this->smtpPort;
		$this->mailer->SMTPAuth = $this->smtpRequireAuth;
		$this->mailer->Username = $this->smtpUser;
		$this->mailer->Password = $this->smtpPassword;
		$this->mailer->SMTPSecure = $this->smtpSecure;
		return true;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\library\mailer\Mailer::send()
	 */
	public function send()
	{
		$this->mailer->CharSet = $this->charset;
		
		//set sender
		if(isset($this->from)){
			$this->mailer->setFrom($this->from[0], $this->from[1]);
		}
		
		//set receivers
		foreach($this->to as $i){
			$this->mailer->addAddress($i[0], $i[1]);
		}
		
		//set cc
		foreach($this->cc as $i){
			$this->mailer->addCC($i[0], $i[1]);
		}
		
		//set bcc
		foreach($this->bcc as $i){
			$this->mailer->addBCC($i[0], $i[1]);
		}
		
		//set reply to
		foreach($this->reply as $i){
			$this->mailer->addReplyTo($i[0], $i[1]);
		}
		
		//set subject
		if(isset($this->subject)){
			$this->mailer->Subject = $this->subject;
		}
		
		//set body
		if(isset($this->body)){
			$this->mailer->isHTML($this->isHtml);
			$this->mailer->msgHTML($this->body);
			//$this->mailer->AltBody = strip_tags($this->body);
		}
		
		//set attachments
		foreach($this->attachment as $i){
			$this->mailer->addAttachment($i[0], $i[1]);
		}
		
		//send email
		if (!$this->mailer->send()) {
			if($this->exceptions) throw new \Exception("PHPMailer Error: " . $this->mailer->ErrorInfo);
			return false;
		} else {
			return true;
		}
	}
}