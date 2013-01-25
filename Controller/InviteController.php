<?php

namespace YV\InviteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use YV\InviteBundle\InviteEvents;
use YV\InviteBundle\Event\FormEvent;
use YV\InviteBundle\Event\ResponseEvent;
use YV\InviteBundle\Event\FilterInviteResponseEvent;
use YV\InviteBundle\Model\ModelInterface\InvitableUserInterface;

class InviteController extends Controller
{
    public function indexAction()
    {        
        $inviteManager = $this->get('yv_invite.invite_manager');
        $invites = $inviteManager->getRepository()->findAll();

        return $this->render('YVInviteBundle:Invite:index.html.twig', array(
                'invites' => $invites
        ));        
    }
    
    public function sendAction(Request $request)
    {        
        $form = $this->get('form.factory')->createNamed(
                $this->container->getParameter('yv_invite.sending.form.name'),
                $this->container->getParameter('yv_invite.sending.form.type')
        );
        
        $dispatcher = $this->container->get('event_dispatcher');

        $responseEvent = new ResponseEvent($request);
        $dispatcher->dispatch(InviteEvents::INVITE_SEND_INITIALIZE, $responseEvent);        
        
        if (null !== $responseEvent->getResponse()) {
            return $responseEvent->getResponse();
        }        
        
        if($request->isMethod('POST')) {
            $form->bind($request);
            
            if($form->isValid()) {
                $inviteManager = $this->get('yv_invite.invite_manager');
                $recipientManager = $this->get('yv_invite.recipient_manager');

                $formEvent = new FormEvent($form, $request);
                $dispatcher->dispatch(InviteEvents::INVITE_SEND_SUCCESS, $formEvent);                 
                
                $data = $formEvent->getData();
                
                $recipient = $recipientManager->create($data);
                $invite = $inviteManager->generateInvite($this->addNesting($data), $recipient);
                
                if (null === $response = $formEvent->getResponse()) {
                    $response = $this->redirect($this->generateUrl('yv_invite_index'));
                }

                $filterInviteResponseEvent = new FilterInviteResponseEvent($invite, $request, $response);
                $dispatcher->dispatch(InviteEvents::INVITE_SEND_COMPLETED, $filterInviteResponseEvent);

                return $response;
            }
        }
        
        return $this->render('YVInviteBundle:Invite:send.html.twig', array(
                'form' => $form->createView()
        ));         
    }
    
    public function followAction($code)
    {
        $role = $this->container->getParameter('yv_invite.following.role.name');
        if (is_string($role) && $this->get('security.context')->isGranted($role)) {
            $route = $this->container->getParameter('yv_invite.following.role.not_granted_route');
            return $this->redirect($this->generateUrl($route));
        }

        $parameterName = $this->container->getParameter('yv_invite.following.session_parameter_name');
        $this->getRequest()->getSession()->set($parameterName, $code);
        $route = $this->container->getParameter('yv_invite.following.route');
        
        return $this->redirect($this->generateUrl($route));        
    }
    
    private function addNesting(array $data)
    {
        try {
            $user = $this->getUser();

            if($user instanceof InvitableUserInterface && $parent = $user->getInvite()) {
                $parent = array('parent' => $parent);
                $data = array_merge($data, $parent);
            }
        }
        catch(\LogicException $e) {   
        } 
        
        return $data;
    }
}