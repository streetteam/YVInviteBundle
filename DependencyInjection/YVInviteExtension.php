<?php

namespace YV\InviteBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class YVInviteExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('yv_invite.invite_class', $config['invite_class']);        
        $container->setParameter('yv_invite.recipient_class', $this->getModelClass($config, 'recipient'));
        $container->setParameter('yv_invite.config', $this->createConfigParameterArray($config));
        
        $container->setParameter('yv_invite.sending.form.type', $config['sending']['form_type']);
        $container->setParameter('yv_invite.sending.form.name', $config['sending']['form_name']);

        $container->setParameter('yv_invite.following.role.name', $config['following']['role_name']);
        $container->setParameter('yv_invite.following.role.not_granted_route', $config['following']['role_not_granted_route']);
        $container->setParameter('yv_invite.following.route', $config['following']['route']);
        $container->setParameter('yv_invite.following.session_parameter_name', $config['following']['session_parameter_name']);
        
        $container->setAlias('yv_invite.invite_manager', $config['service']['invite_manager']);
        $container->setAlias('yv_invite.recipient_manager', $config['service']['recipient_manager']);
        $container->setAlias('yv_invite.invite_strategy_context', $config['service']['invite_strategy_context']);      
    }
    
    private function createConfigParameterArray(array $config)
    {
        $config['email']['from_email'] = array($config['email']['address'] => $config['email']['sender_name']);
        
        return array(
            'email' => $config['email'],
            'expiration_time' => $config['expiration_time']
        );
    }
    
    private function getModelClass(array $config, $className)
    {
        $option = sprintf('%s_class', strtolower($className));
        
        if($config[$option] === null) {
            if(preg_match('~^([A-Za-z0-9\\\]+)\\\[A-Za-z0-9]+$~', $config['invite_class'], $matches)) {
                return sprintf('%s\%s', $matches[1], ucfirst(strtolower($className)));
            }
            
            throw new \InvalidArgumentException(sprintf('The "%s" option must be set.', $option));
        }
        
        return $config[$option];
    }
}
