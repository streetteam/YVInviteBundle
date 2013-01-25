Provides invites management in your Symfony2 Project.

Features
========

InviteBundle features
-----------------------------


Installation
============

Bring in the vendor libraries
-----------------------------

This can be done in two different ways:

**Method #1**) Use composer

::

    "require": {
        "php": ">=5.3.2",
        "symfony/symfony": "2.1.*",
        "_comment": "your other packages",

        "yv/invite-bundle": "dev-master",
    }


**Method #2**) Use git submodules

::

    git submodule add git://github.com/yourvine/YVInviteBundle.git vendor/bundles/YV/InviteBundle

Register the InviteBundle and YV namespaces
---------------------------------------------------

Only required, when using submodules.

::

    // app/autoload.php
    $loader->registerNamespaces(array(
        'YV'  => __DIR__.'/../vendor/bundles',
        // your other namespaces
    ));

Add InviteBundle to your application kernel
-------------------------------------------------------

::

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new YV\InviteBundle(),
            // ...
        );
    }


Configure the bundle
====================

All available configuration options are listed below with their default values.

::

    # app/config/config.yml
    yv_invite:
        invite_class:       ~ # Required
        recipient_class:    null
        expiration_time:    null
        service:
            invite_strategy_context:    invite_strategy_context.default
            invite_manager:             invite_manager.default
            recipient_manager:          recipient_manager.default
        email:
            sending_enabled:    true
            address:            admin@example.com
            sender_name:        Admin
        sending:
            form_name:  yv_invite_recipient  
            form_type:  yv_invite_recipient
        following:
            role_name:              null
            role_not_granted_route: yv_invite_index
            route:                  yv_invite_index
            session_parameter_name: yv_invite.invite_code
