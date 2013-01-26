<?php

namespace YV\InviteBundle;

final class YVInviteEvents
{
    const INVITE_CREATED = 'yv_invite.created';
    
    const INVITE_ACCEPTED = 'yv_invite.accepted';
    
    const INVITE_SEND_INITIALIZE = 'yv_invite.send.initialize';
    
    const INVITE_SEND_SUCCESS = 'yv_invite.send.success';
    
    const INVITE_SEND_COMPLETED = 'yv_invite.send.completed';
}
