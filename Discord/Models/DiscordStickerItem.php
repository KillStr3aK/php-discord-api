<?php

namespace Nexd\Discord;

class DiscordStickerItem extends DiscordObjectParser
{
    public function __construct(array $properties = [])
    {
        parent::__construct($properties);
    }

    /**
     * id of the sticker.
     */
    public string $id;

    /**
     * name of the sticker.
     */
    public string $name;

    /**
     * type of sticker format (see DiscordStickerFormat).
     */
    public int $format_type;
}
