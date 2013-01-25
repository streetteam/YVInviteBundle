<?php

namespace YV\InviteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('yv_invite');

        $rootNode
            ->children()
            ->scalarNode('invite_class')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('recipient_class')->defaultNull()->end()
            ->scalarNode('expiration_time')->defaultNull()->end()    
            ->end();

        $this->addServiceSection($rootNode);
        $this->addEmailSection($rootNode);
        $this->addSendingSection($rootNode);
        $this->addFollowingSection($rootNode);
        
        return $treeBuilder;
    }
    
    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('invite_strategy_context')->defaultValue('invite_strategy_context.default')->end()
                            ->scalarNode('invite_manager')->defaultValue('invite_manager.default')->end() 
                            ->scalarNode('recipient_manager')->defaultValue('recipient_manager.default')->end()   
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
    private function addEmailSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('email')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('sending_enabled')->defaultValue(true)->end()
                            ->scalarNode('address')->defaultValue('admin@example.com')->end() 
                            ->scalarNode('sender_name')->defaultValue('Admin')->end()   
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addSendingSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('sending')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('form_name')->defaultValue('yv_invite_recipient')->end() 
                            ->scalarNode('form_type')->defaultValue('yv_invite_recipient')->end()   
                        ->end()
                    ->end()
                ->end()
            ->end();
    }    

    private function addFollowingSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('following')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('role_name')->defaultValue(null)->end() 
                            ->scalarNode('role_not_granted_route')->defaultValue('yv_invite_index')->end() 
                            ->scalarNode('route')->defaultValue('yv_invite_index')->end()
                            ->scalarNode('session_parameter_name')->defaultValue('yv_invite.invite_code')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }      
}
