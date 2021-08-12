<?php

namespace Nexd\Discord;

class DiscordEmoji extends DiscordObjectParser
{
    private const InitializeProperties =
    [/*Property Name */			/* to */
        'user'	            => 'DiscordUser',
    ];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties, self::InitializeProperties);
    }

    /**
     * emoji id.
     */
    public string $id;

    /**
     * 	emoji name.
     */
    public ?string $name;

    /**
     * roles allowed to use this emoji.
     */
    public array $roles;

    /**
     * user that created this emoji.
     */
    public $user;

    /**
     * 	whether this emoji must be wrapped in colons.
     */
    public bool $require_colons;

    /**
     * whether this emoji is managed.
     */
    public bool $managed;

    /**
     * whether this emoji is animated.
     */
    public bool $animated;

    /**
     * whether this emoji can be used, may be false due to loss of Server Boosts.
     */
    public bool $available;
}
