<?php

namespace Nexd\Discord;

class DiscordEmbedThumbnail extends DiscordObjectParser
{
    /**
     * source url of thumbnail (only supports http(s) and attachments).
     */
    public ?string $url;

    /**
     * a proxied url of the thumbnail.
     */
    public ?string $proxy_url;

    /**
     * height of thumbnail.
     */
    public ?int $height;

    /**
     * width of thumbnail.
     */
    public ?int $width;
}
