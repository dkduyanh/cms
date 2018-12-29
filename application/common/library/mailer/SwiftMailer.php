<?php

namespace app\library\mailer;

/**
 * This mailer class is responsible for sending emails via SwiftMailer 
 * 
 * @author DuyAnh
 *
 */
class SwiftMailer extends Mailer 
{	
	/**
	 * {@inheritDoc}
	 * @see \app\library\mailer\Mailer::init()
	 */
	protected function init()
	{
		// Create the Transport
		$transport = \Swift_SmtpTransport::newInstance($this->smtpHost, $this->smtpPort, $this->smtpSecure);
		if($this->smtpRequireAuth){
			$transport->setUsername($this->smtpUser)->setPassword($this->smtpPassword);
		}
		
		 // Create the Mailer using your created Transport
		 $this->mailer = \Swift_Mailer::newInstance($transport);
		 return true;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\library\mailer\Mailer::send()
	 */
	public function send()
	{		
		// Create the message
		$message = \Swift_Message::newInstance();
		
		$message->setCharset($this->charset);
		
		//set sender
		if(isset($this->from)){
			$message->addFrom($this->from[0], $this->from[1]);
		}
		
		//set receivers
		foreach($this->to as $i){
			$message->addTo($i[0], $i[1]);
		}
		
		//set cc
		foreach($this->cc as $i){
			$message->addCc($i[0], $i[1]);
		}
		
		//set bcc
		foreach($this->bcc as $i){
			$message->addBCC($i[0], $i[1]);
		}
		
		//set reply to
		foreach($this->reply as $i){
			$message->addReplyTo($i[0], $i[1]);
		}
		
		//set subject
		if(isset($this->subject)){			
			$message->setSubject($this->subject);			
		}
		
		//set body
		if(isset($this->body)){
			$message->setBody($this->body, $this->isHtml ? 'text/html' : 'text/plain');
			//$message->addPart(strip_tags($this->body), 'text/plain');
		}
		
		//set attachments
		foreach($this->attachment as $i){
			$attachment = \Swift_Attachment::fromPath($i[0]);			
			if(isset($i[1])){
				$attachment->setFilename($i[1]);
			}
			$message->attach($attachment);
		}
		
		// Send the email
		if (!$this->mailer->send($message, $error)) {
			if($this->exceptions) throw new \Exception("SwiftMailer Error: " . $error);
			return false;
		} else {
			return true;
		}
	}
}