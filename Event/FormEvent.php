<?php
namespace YV\InviteBundle\Event;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormEvent extends RequestEvent
{
    protected $form;
    
    protected $data;
    
    protected $response;
    
    public function __construct(FormInterface $form, Request $request)
    {
        parent::__construct($request);
        $this->form = $form;
        $this->data = $form->getData();      
    }

    public function setForm(FormInterface $form)
    {
        $this->form = $form;
    }
    
    public function getForm()
    {
        return $this->form;
    }
    
    public function setData(array $data)
    {
        $this->data = $data;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }    
    
    public function getResponse()
    {
        return $this->response;
    }    
}
