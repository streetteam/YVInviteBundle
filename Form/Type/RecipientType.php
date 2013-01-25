<?php

namespace YV\InviteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;

class RecipientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array(
            'constraints' => new Email(),
            'label' => 'Recipient email',
        ));
        $builder->add('name', 'text', array(
            'required' => false,
            'label' => 'Recipient name'
        ));
        $builder->add('senderName', 'text', array(
            'required' => true,
            'label' => 'Sender name'
        ));                
    }

    public function getName()
    {
        return 'yv_invite_recipient';
    }
}
