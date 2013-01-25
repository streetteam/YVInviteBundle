<?php
namespace YV\InviteBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class RequestEvent extends Event
{
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
    
    public function getRequest()
    {
        return $this->request;
    }
}
