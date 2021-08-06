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

class DiscordRole extends DiscordObjectParser
{
    /**
     * role id
     */
    public ?string $id = null;

    /**
     * role name
     */
    public ?string $name = null;

    /**
     * integer representation of hexadecimal color code
     */
    public ?int $color = null;

    /**
     * if this role is pinned in the user listing
     */
    public ?bool $hoist = null;

    /**
     * position of this role
     */
    public ?int $position = null;

    /**
     * permission bit set
     */
    public ?string $permissions = null;

    /**
     * whether this role is managed by an integration
     */
    public ?bool $managed = null;

    /**
     * 	whether this role is mentionable
     */
    public ?bool $mentionable = null;

    /**
     * the tags this role has
     */
    public $tags = null;
}
?>