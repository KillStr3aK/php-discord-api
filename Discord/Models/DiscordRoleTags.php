<?php

namespace Nexd\Discord;

class DiscordRoleTags extends DiscordObjectParser
{
    /**
     * the id of the bot this role belongs to.
     */
    public ?string $bot_id = null;

    /**
     * 	the id of the integration this role belongs to.
     */
    public ?string $integration_id = null;

    /**
     * whether this is the guild's premium subscriber role.
     */
    public ?bool $premium_subscriber = null;
}
