<?php

namespace app\library\mailer;

/**
 * Create mailer object
 * 
 * Usage:
 *   $mailer = MailerFactory::create();
 *   $mailer->setSubject('This is test mail');
 *   $mailer->setBody('<h1>Hello!</h1><br> This is my <em>amazing</em> body');
 *   $mailer->setFrom('john@example.com', 'John');
 *   $mailer->addTo('leo@example.com', 'Leo');
 *   $mailer->addCc('smith@example.com', 'Smith');
 *   $mailer->addAttachment('\path\to\file', 'My File');	
 *   $mailer->send();
 *   
 * @author DuyAnh
 *
 */
class MailerFactory
{
	const PHPMAILER = PHPMailer::class;
	const SWIFTMAILER = SwiftMailer::class;
	
	public static function create($class = self::PHPMAILER){
		$smtp = [
			'smtpHost' => DEFAULT_SMTP_HOST,
			'smtpUser' => DEFAULT_SMTP_USER,
			'smtpPassword' => DEFAULT_SMTP_PASSWORD,
			'smtpPort' => DEFAULT_SMTP_PORT,
			'smtpRequireAuth' => DEFAULT_SMTP_AUTH,
			'smtpSecure' => DEFAULT_SMTP_SECURE,
		];
		
		$mailer = new $class($smtp, true);
		if(!$mailer instanceof Mailer){
			throw new \ErrorException('Unknow mailer');
		}
		$mailer->setFrom(ADMIN_EMAIL);
		return $mailer;
	}
	
	public static function createWithTemplate($template)
	{
		$mailer = self::create();
		if(!empty($template)){			
			$mailer->setSubject($template['subject']);
			$mailer->setBody($template['body']);			
			if(isset($template['attachment']))
				$mailer->addAttachment($template['attachment']);			
		}
		return $mailer;
	}	
}