<?php

namespace Nexd\Discord;

class DiscordEmbedImage extends DiscordObjectParser
{
    /**
     * source url of image (only supports http(s) and attachments).
     */
    public ?string $url;

    /**
     * a proxied url of the image.
     */
    public ?string $proxy_url;

    /**
     * height of image.
     */
    public ?int $height;

    /**
     * 	width of image.
     */
    public ?int $width;
}
