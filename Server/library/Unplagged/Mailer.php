<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Unplagged_Mailer
{
    /**
     * Sends a registration mail to a specific user to verify the users email address.
     * 
     * @Application_Model_User $user The user the mail sent to.
     * 3
     * @return Whether the mail was sent or not.
     */
    public static function sendRegistrationMail(Application_Model_Personnel $user) {  
        $config = Zend_Registry::get('config');

        $bodyText = 'Thanks for your registration.'."\r"."\n"."\r"."\n";
        $bodyText .= 'Please click the following link, to verify your account: ' ."\r"."\n";
        $bodyText .= $config->link->accountVerification . $user->getVerificationHash() . "\r"."\n";
        $bodyText .= "\r"."\n";
        $bodyText .= 'Your team of ' . $config->default->portalName . "\r"."\n";

        $mail = new Zend_Mail('utf-8');
        $mail->setBodyText($bodyText);
        $mail->setFrom($config->default->senderEmail, $config->default->senderName);
        $mail->addTo($user->getEmail());
        $mail->setSubject($config->default->portalName . ' Registration verification required');
        
        $mail->send();
        
        return true;
    }
    
    /**
     * Sends a registration mail to a specific user to verify the users email address.
     * 
     * @Application_Model_User $user The user the mail sent to.
     * 
     * @return Whether the mail was sent or not.
     */
    public static function sendActivationMail(Application_Model_Personnel $user) {
        $config = Zend_Registry::get('config');
        
        $bodyText = 'Thanks for verifying your account.'."\r"."\n"."\r"."\n";
        $bodyText .= 'You now can use our website. ' ."\r"."\n";
        $bodyText .= "\r"."\n";
        $bodyText .= 'Your team of ' . $config->default->portalName . "\r"."\n";

        $mail = new Zend_Mail('utf-8');
        $mail->setBodyText($bodyText);
        $mail->setFrom($config->default->senderEmail, $config->default->senderName);
        $mail->addTo($user->getEmail());
        $mail->setSubject($config->default->portalName . ' Account successfully verified');
        $mail->send();
        
        return true;
    }
}
?>
