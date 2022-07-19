<?php

namespace Nexd\Discord;

class DiscordGuildPreview extends DiscordObjectParser
{
    private const InitializeProperties =
    [/*Property Name */			/* to */
        'emojis'                => 'DiscordEmoji[]',
    ];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties, self::InitializeProperties);
    }

    /**
     * guild id.
     */
    public string $id;

    /**
     * guild name (2-100 characters).
     */
    public string $name;

    /**
     * 	icon hash.
     */
    public ?string $icon;

    /**
     * splash hash.
     */
    public ?string $splash;

    /**
     * discovery splash hash.
     */
    public ?string $discovery_splash;

    /**
     * custom guild emojis.
     */
    public array $emojis;

    /**
     * 	enabled guild features.
     */
    public array $features;

    /**
     * approximate number of members in this guild.
     */
    public int $approximate_member_count;

    /**
     * approximate number of online members in this guild.
     */
    public int $approximate_presence_count;

    /**
     * 	the description for the guild, if the guild is discoverable.
     */
    public ?string $description;
}
