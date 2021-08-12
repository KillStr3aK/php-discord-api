<?php

namespace Nexd\Discord;

class BanObject extends DiscordObjectParser
{
    private const InitializeProperties =
    [/*Property Name */			/* to */
        'user'	            => 'DiscordUser',
    ];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties, self::InitializeProperties);
    }

    public ?string $reason;

    public $user;
}
