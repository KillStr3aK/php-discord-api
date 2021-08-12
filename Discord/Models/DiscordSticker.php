<?php

namespace Nexd\Discord;

class DiscordSticker extends DiscordObjectParser
{
    private const InitializeProperties =
    [/*Property Name */			/* to */
        'user'				=> 'DiscordUser',
    ];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties, self::InitializeProperties);
    }

    /**
     * 	id of the sticker.
     */
    public string $id;

    /**
     * for standard stickers, id of the pack the sticker is from.
     */
    public string $pack_id;

    /**
     * 	name of the sticker.
     */
    public string $name;

    /**
     * description of the sticker.
     */
    public ?string $description;

    /**
     * for guild stickers, the Discord name of a unicode emoji representing the sticker's expression. for standard stickers, a comma-separated list of related expressions.
     */
    public string $tags;

    /**
     * Deprecated previously the sticker asset hash, now an empty string.
     */
    public string $asset;

    /**
     * type of sticker.
     */
    public int $type;

    /**
     * type of sticker format.
     */
    public int $format_type;

    /**
     * 	whether this guild sticker can be used, may be false due to loss of Server Boosts.
     */
    public bool $available;

    /**
     * 	id of the guild that owns this sticker.
     */
    public string $guild_id;

    /**
     * the user that uploaded the guild sticker.
     */
    public $user;

    /**
     * the standard sticker's sort order within its pack.
     */
    public int $sort_value;
}
