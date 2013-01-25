<?php
namespace YV\InviteBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use YV\InviteBundle\Model\ModelInterface\InviteInterface;

class FilterInviteResponseEvent extends ResponseEvent
{
    protected $invite;
    
    public function __construct(InviteInterface $invite, Request $request, Response $response) 
    {
        parent::__construct($request);
        
        $this->invite = $invite;
        $this->response = $response;
    }
    
    public function setInvite(InviteInterface $invite)
    {
        $this->invite = $invite;
    }
    
    public function getInvite()
    {
        return $this->invite;
    }
}
