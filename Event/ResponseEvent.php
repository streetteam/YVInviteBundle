<?php
namespace YV\InviteBundle\Event;

use Symfony\Component\HttpFoundation\Response;

class ResponseEvent extends RequestEvent
{
    protected $response;
    
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }    
    
    public function getResponse()
    {
        return $this->response;
    }
}
