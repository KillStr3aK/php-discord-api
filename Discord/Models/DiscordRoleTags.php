<?php
namespace Nexd\Discord;

class DiscordRoleTags extends DiscordObjectParser
{
    /**
     * the id of the bot this role belongs to
     */
    public string $bot_id;

    /**
     * 	the id of the integration this role belongs to
     */
    public string $integration_id;

    /**
     * whether this is the guild's premium subscriber role
     */
    public ?bool $premium_subscriber;
}
?>