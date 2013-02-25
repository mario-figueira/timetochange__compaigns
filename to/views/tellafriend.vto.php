<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ambassadorTO
 *
 * @author pmcosta
 */
class tellafriendVTO {
    
    public $sender_name;
    public $sender_email;
    public $email_subject;
    public $email_body;
    public $send_to_me;
    public $submit_message;
    public $show_tabs = false;
    public $show_pagination = false;
    public $message = array();
    
    public $tabs = array();
    
    public function __construct(
        $emails_array = array(), $sender_name = '', $sender_email = '', $subject = '', $email_body = '', $send_to_me = FALSE) {
        $this->emails_array = $emails_array;
        $this->sender_name = $sender_name;
        $this->sender_email = $sender_email;
        $this->email_subject = $subject;
        $this->email_body = $email_body;
        $this->send_to_me = $send_to_me;
        $this->submit_message = _('Enviar');
    }
    
}

?>
