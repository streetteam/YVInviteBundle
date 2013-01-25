<?php

namespace YV\InviteBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use YV\InviteBundle\Event\InviteAcceptedEvent;
use YV\InviteBundle\Event\InviteCreatedEvent;

class InviteListener
{
    protected $config;
    
    protected $mailer;
    
    protected $twig;
    
    protected $objectManager;
    
    /**
     * Constructs a new instance of InviteListener.
     *
     */
    public function __construct(ObjectManager $objectManager, \Swift_Mailer $mailer, \Twig_Environment $twig, array $config)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->objectManager = $objectManager;
        $this->config = $config;
    }

    /**
     * Invoked after an invite has been created.
     *
     * @param InviteCreatedEvent $event The event
     */
    public function onInviteCreated(InviteCreatedEvent $event)
    {    
        $invite = $event->getInvite();
        
        if($invite->hasRecipients() && $this->config['email']['sending_enabled'] === true) {    
            
            foreach($invite->getRecipients() as $recipient) {  
                
                $context = array('recipient' => $recipient);
                $fromEmail = $this->config['email']['from_email'];
                $toEmail = array($recipient->getEmail() => $recipient->getName());
                
                $this->sendMessage('YVInviteBundle:emails:invite_created.html.twig', $context, $fromEmail, $toEmail);
            }
        }
    }     
    
    /**
     * Invoked after an invite has been accepted.
     *
     * @param InviteAcceptedEvent $event The event
     */
    public function onInviteAccepted(InviteAcceptedEvent $event)
    {
        $invite = $event->getInvite();
        $user = $event->getUser();
        
        $user->setInvite($invite);
        
        $this->objectManager->persist($user);
        $this->objectManager->persist($invite);
        $this->objectManager->flush();       
    }
       
    protected function sendMessage($templateName, array $context, $fromEmail, $toEmail)
    {
        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }    
}
