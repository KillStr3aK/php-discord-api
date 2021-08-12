<?php

namespace Nexd\Discord;

class InviteTargetType
{
    public const STREAM = 1;

    public const EMBEDDED_APPLICATION = 2;
}

class DiscordInvite extends DiscordObjectParser
{
    private const InitializeProperties =
    [/*Property Name */			/* to */
        'guild'                 => 'DiscordGuild',
        'channel'				           => 'DiscordChannel',
        'inviter'			            => 'DiscordUser',
        'target_user'			        => 'DiscordUser',
        'target_application'    => 'DiscordApplication',
        'stage_instance'        => 'DiscordInviteStageInstance',
    ];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties, self::InitializeProperties);
    }

    /**
     * the invite code (unique ID).
     */
    public string $code;

    /**
     * the guild this invite is for.
     */
    public $guild;

    /**
     * the channel this invite is for.
     */
    public $channel;

    /**
     * 	the user who created the invite.
     */
    public $inviter;

    /**
     * 	the type of target for this voice channel invite.
     */
    public int $target_type;

    /**
     * the user whose stream to display for this voice channel stream invite.
     */
    public $target_user;

    /**
     * 	the embedded application to open for this voice channel embedded application invite.
     */
    public $target_application;

    /**
     * approximate count of online members, returned from the GET /invites/<code> endpoint when with_counts is true.
     */
    public int $approximate_presence_count;

    /**
     * approximate count of total members, returned from the GET /invites/<code> endpoint when with_counts is true.
     */
    public int $approximate_member_count;

    /**
     * the expiration date of this invite, returned from the GET /invites/<code> endpoint when with_expiration is true.
     */
    public string $expires_at;

    /**
     * stage instance data if there is a public Stage instance in the Stage channel this invite is for.
     */
    public $stage_instance = null;

    /**
     * not always has a value.
     */
    public $metadata = null;
}
