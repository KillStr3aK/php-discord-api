<?php
namespace Nexd\Discord;

class DiscordGuildWidget extends DiscordObjectParser
{
    /**
     * whether the widget is enabled
     */
    public bool $enabled;

    /**
     * the widget channel id
     */
    public ?string $channel_id;
}
?>