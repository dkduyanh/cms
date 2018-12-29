<?php

namespace app\library\mailer;

/**
 * Mailer is the abstract class that must be extends by mailer classes, 
 * which has responsibility for sending emails over SMTP.
 * 
 * @author DuyAnh
 *
 */
abstract class Mailer
{	
	/**
	 * Mailer instance
	 * @var mixed object
	 */
	protected $mailer;
	
	/**
	 * Configurations that allow to sends messages over SMTP
	 * @var string $smtpUser SMTP username
	 * @var string $smtpPassword SMTP password
	 * @var string $smtpHost SMTP hosts
	 * @var string|int $smtpPort The default SMTP server port
	 * @var boolean $smtpRequireAuth Whether to use SMTP authentication with the $smtpUser and $smtpPassword properties.
	 * @var string $smtpSecure What kind of encryption to use on the SMTP connection. Options: '', 'ssl' or 'tls'
	 */
	protected $smtpUser, $smtpPassword, $smtpHost, $smtpPort, $smtpRequireAuth, $smtpSecure;

	/**
	 * The sender information
	 * @var array
	 */
	protected $from;
	
	/**
	 * The list of receivers
	 * @var array
	 */
	protected $to = [], $cc = [], $bcc = [], $reply = [];
	
	/**
	 * The message detail
	 * @var string $subject The Subject of the message
	 * @var string $body An HTML or plain text message body
	 * @var string $isHtml Whether to send a message in HTML format
	 */
	protected $subject, $body, $isHtml = true;
	
	/**
	 * The list of attachments.
	 * @var array
	 */
	protected $attachment=[];
	
	/**
	 * The character set of the message.
	 * @var string
	 */
	protected $charset = 'utf-8';
	
	/**
     * Whether to throw exceptions for errors.
     * @var boolean
     * @access protected
     */
    protected $exceptions = false;
	
    /**
     * Constructor
     * @param boolean $exceptions
     */
	public function __construct(array $smtp = [], $exceptions = null){
		foreach($smtp as $key => $val){
			if(property_exists($this, $key)){
				$this->$key = $val;
			}
		}
		if ($exceptions !== null) {
			$this->exceptions = (boolean)$exceptions;
		}
		
		$this->init();
	}

	/**
	 * Set SMTP Server
	 * @param string $host SMTP host
	 * @param int $port SMTP Port, default is 25
	 * @param int $secure SMTP Secure method, it may be empty, ssl, tls. Default is empty
	 * @param bool $auth Whether SMTP requires authentication, default is FALSE
	 * @param string $user SMTP username
	 * @param string $password SMTP password
	 */
	public function setSMTPServer($host, $port = 25, $secure = '', $auth = false, $user = '', $password = '')
	{
		$this->smtpHost = $host;
		$this->smtpPort = $port;
		$this->smtpSecure = (bool)$secure;
		$this->smtpRequireAuth = $auth;
		$this->smtpUser = $user;
		$this->smtpPassword = $password;
	}
	
	/**
	 * Set sender information
	 * @param string $address The email address
	 * @param string $name The name associated with this email address
	 * @throws \Exception If $exceptions is enabled
	 * @return boolean Returns TRUE on success, FALSE otherwise
	 */
	public function setFrom($address, $name = null){	
		return $this->addAddress('from', $address, $name);
	}
	
	/**
	 * Add a "TO" address
	 * @param string $address The email address
	 * @param string $name The name associated with this email address
	 * @throws \Exception If $exceptions is enabled
	 * @return boolean Returns TRUE on success, FALSE if address already used or invalid in some way
	 */
	public function addTo($address, $name = null)
	{
		return $this->addAddress('to', $address, $name);
	}
	
	/**
	 * Add a "CC" address
	 * @param string $address The email address
	 * @param string $name The name associated with this email address
	 * @throws \Exception If $exceptions is enabled
	 * @return boolean Returns TRUE on success, FALSE if address already used or invalid in some way
	 */
	public function addCc($address, $name = null)
	{
		return $this->addAddress('cc', $address, $name);
	}
	
	/**
	 * Add a "BCC" address.
	 * @param string $address The email address
	 * @param string $name The name associated with this email address
	 * @throws \Exception If $exceptions is enabled
	 * @return boolean Returns TRUE on success, FALSE if address already used or invalid in some way
	 */
	public function addBcc($address, $name = null)
	{
		return $this->addAddress('bcc', $address, $name);
	}
	
	/**
	 * Add a "Reply-To" address.
	 * @param string $address The email address
	 * @param string $name The name associated with this email address
	 * @throws \Exception If $exceptions is enabled
	 * @return boolean Returns TRUE on success, FALSE if address already used or invalid in some way
	 */
	public function addReplyTo($address, $name = null)
	{
		return $this->addAddress('reply', $address, $name);
	}
	
	/**
	 * Set the Subject of the message.
	 * @param string $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}
	
	/**
	 * Set the Body of the message.
	 * @param string $subject
	 */
	public function setBody($body, $isHtml = false)
	{
		$this->body = $body;
		$this->isHtml = $isHtml;
	}
	
	/**
	 * Add an attachment from a path on the filesystem.
     * @param string $file Path to the attachment.
     * @param string $name Overrides the attachment name.
	 * @throws \Exception If $exceptions is enabled
	 * @return boolean Returns FALSE if the file could not be found or read.
	 */
	public function addAttachment($file, $name = null)
	{
		/**
		 * TODO: Check file path
		 */
		$this->attachment[] = [$file, $name];	
	}
	
	/**
	 * Add address to queue
	 * @param string $type One of 'to', 'cc', 'bcc', or 'reply'
	 * @param string $address The email address
	 * @param string $name The name associated with this email address
	 * @throws \Exception If $exceptions is enabled
	 * @return boolean Returns TRUE if address is added to queue successfully, FALSE if address already used or invalid in some way
	 */
	protected function addAddress($type, $address, $name = null)
	{
		/*Check if type exists*/
		if(!property_exists($this, $type)){
			if($this->exceptions) throw new \Exception('Unknown property "'.$type.'"');
			return false;
		}
		/*Check address validation*/
		$address = trim($address);
		$name = trim($name);
		if(!filter_var($address, FILTER_VALIDATE_EMAIL)){
			if($this->exceptions) throw new \Exception('Invalid email address ['.$type.']: '.$address);
			return false;
		}
		/*Add address to queue*/
		if(is_array($this->$type))
			array_push($this->$type, [$address, $name]);
		else 
			$this->$type = [$address, $name];
		return true;
	}
	
	/**
	 * Init / create instance of mailer
	 * @throws \Exception If $exceptions is enabled
	 * @return boolean Returns TRUE on success, FALSE otherwise
	 */
	abstract protected function init();
	
	/**
     * Create a message and send it.
     * @throws \Exception If $exceptions is enabled
     * @return boolean Returns TRUE on success, FALSE on error.
	 */
	abstract public function send();
}