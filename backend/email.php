<?php

use PSpell\Config;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email as MimeEmail;

 require  str_replace("\\" , "/", dirname(__DIR__) . "/vendor/autoload.php");
 require "fetch_config.php";
class email
{

        private $dns = null;
        
        private $transport = null;

        private $mailer = null;

        private $email = null;

        private $config = null;
    
        public function __construct()
        {
            $this->config = fetch_config::get_instance()->get("mailer"); 
            $this->set_dns();
            $this->transport = Transport::fromDsn($this->dns);
            $this->mailer = new Mailer($this->transport);
            $this->email = new MimeEmail();
        }


        private function set_dns()
        {
          $transport = $this->config["transport"];
          $password = $this->config["password"];
          $username = $this->config["username"];
          $hostname = $this->config["host"];
          $port = !isset($this->config["port"]) ? 25 : $this->config["port"];
          $dns = "$transport://$username:$password@$hostname:$port";
          $this->dns = $dns;
          
        }

        /**
         * the sender
         * 
         */
        public function from(string $from){
                $this->email->from($from);
        }

        /**
         * the recipient
         * 
         */

         public function to(string $recipient)
         {
                $this->email->to($recipient);
         }
        
         /**
          *  add a subject
          *
          */

          public function subject(string $subject)
          {
              $this->email->subject($subject);      
          }

          /**
           * send the message as text
           * 
           */
          public function text(string $message)
          {
              $this->email->text($message);
          }

          /**
           * 
           * send the message as html
           */
          public function html(string $message)
          {
             $this->email->html($message);
          }

          /**
           * add an attachment
           * 
           */
          public function add_attachment(string $path)
          {
                $this->email->attachFromPath($path);
          }

          /**
           * add an image
           * 
           */
          public function add_image($image , $alt)
          {
                $this->email->embed($image , $alt);
          }

          /**
           * send the email
           * 
           */

           public function send()
           {
             $this->mailer->send($this->email);
           }


}