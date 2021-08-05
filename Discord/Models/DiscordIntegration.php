<?php
namespace Nexd\Discord;

class IntegrationExpireBehavior
{
    public const RemoveRole = 0;

    public const Kick = 1;
}

class IntegrationAccount extends DiscordObjectParser
{
    /**
     * id of the account
     */
    public string $id;

    /**
     * name of the account
     */
    public string $name;
}

class IntegrationApplication extends DiscordObjectParser
{
    /**
     * the id of the app
     */
    public string $id;

    /**
     * 	the name of the app
     */
    public string $name;

    /**
     * the icon hash of the app
     */
    public ?string $icon;

    /**
     * the description of the app
     */
    public string $description;

    /**
     * 	the summary of the app
     */
    public string $summary;

    /**
     * the bot associated with this application
     */
    public $bot;
}

class DiscordIntegration extends DiscordObjectParser
{
    public string $id;
    public string $name;
    public string $type;
    public bool $enabled;
    public bool $syncing;
    public string $role_id;
    public bool $enable_emoticons;
    public int $expire_behavior;
    public int $expire_grace_period;
    public $user;
    public string $synced_at;
    public int $subscriber_count;
    public bool $revoked;
    public mixed $application;
}
?>