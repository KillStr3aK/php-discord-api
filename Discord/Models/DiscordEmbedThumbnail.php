<?php

namespace Nexd\Discord;

class DiscordEmbedThumbnail extends DiscordObjectParser
{
    /**
     * source url of thumbnail (only supports http(s) and attachments).
     */
    public ?string $url = null;

    /**
     * a proxied url of the thumbnail.
     */
    public ?string $proxy_url = null;

    /**
     * height of thumbnail.
     */
    public ?int $height = null;

    /**
     * width of thumbnail.
     */
    public ?int $width = null;
}
