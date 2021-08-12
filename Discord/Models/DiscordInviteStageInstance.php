<?php

namespace Nexd\Discord;

class DiscordInviteStageInstance extends DiscordObjectParser
{
    private const InitializeProperties =
    [/*Property Name */			/* to */
        'members'               => 'DiscordGuildMember[]',
    ];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties, self::InitializeProperties);
    }

    /**
     * the members speaking in the Stage.
     */
    public $members;

    /**
     * the number of users in the Stage.
     */
    public int $participant_count;

    /**
     * the number of users speaking in the Stage.
     */
    public int $speaker_count;

    /**
     * the topic of the Stage instance (1-120 characters).
     */
    public string $topic;
}
