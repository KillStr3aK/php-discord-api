<?php

namespace Nexd\Discord;

class DiscordEmbedFooter extends DiscordObjectParser
{
    /**
     * footer text.
     */
    public ?string $text;

    /**
     * url of footer icon (only supports http(s) and attachments).
     */
    public ?string $icon_url;

    /**
     * a proxied url of footer icon.
     */
    public ?string $proxy_icon_url;
}
