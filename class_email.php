<?php

class email {
   
    public $to_email;
    public $to_name;
    
    public $from_email;
    public $from_name;
    
    public $bc;
    public $bcc;
    
    public $subject;
    public $body;
    public $host;
    public $port;
    
    public $phpmailer;

    private $db;


    function __construct() {
        
        $this->phpmailer = new phpmailer();
        
        $this->to_email="";
        $this->to_name="";
        
        $this->from_email="admin@youlookinme.com";
        $this->from_name="Admin YouLookingMe.com";
        
        $this->bc="";
        $this->bcc="admin@youlookinme.com";
        $this->subject="";
        $this->body="";
        $this->host="smtp.thedatefree.com";
        $this->port="587";
        
        $this->phpmailer->Host = $this->host;
        $this->phpmailer->Port = $this->port;
        
        $this->phpmailer->SMTPAuth = true;
        $this->phpmailer->Username = "admin@youlookinme.com";
        $this->phpmailer->Password = "happyclown";
        $this->phpmailer->IsHTML(true);
        $this->phpmailer->Priority = 1;


    }

    public function send() {
        $body_h = "<head><title>My HTML Email</title></head><body>";
        $body_e = "</body>";

        $this->phpmailer->From = $this->from_email;
        $this->phpmailer->FromName = $this->from_name;
        $this->phpmailer->AddAddress($this->to_email, $this->to_name);
        $this->phpmailer->Subject = $this->subject;
        $this->phpmailer->Body = $body_h . $this->body . $body_e;
        $this->phpmailer->Send();

    }
    
    
  
    
    
}
?>