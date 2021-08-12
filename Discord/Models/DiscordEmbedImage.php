<?php

namespace Nexd\Discord;

class DiscordEmbedImage extends DiscordObjectParser
{
    /**
     * source url of image (only supports http(s) and attachments).
     */
    public ?string $url = null;

    /**
     * a proxied url of the image.
     */
    public ?string $proxy_url = null;

    /**
     * height of image.
     */
    public ?int $height = null;

    /**
     * 	width of image.
     */
    public ?int $width = null;
}
