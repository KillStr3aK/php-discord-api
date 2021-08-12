<?php

namespace Nexd\Discord;

class DiscordEmbedVideo extends DiscordObjectParser
{
    /**
     * source url of video.
     */
    public ?string $url;

    /**
     * a proxied url of the video.
     */
    public ?string $proxy_url;

    /**
     * height of video.
     */
    public ?int $height;

    /**
     * 	width of video.
     */
    public ?int $width;
}
