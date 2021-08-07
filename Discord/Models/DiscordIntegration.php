<?php
namespace Nexd\Discord;

class IntegrationExpireBehavior
{
    public const RemoveRole = 0;

    public const Kick = 1;
}

class DiscordIntegration extends DiscordObjectParser
{
    private const InitializeProperties =
	[	/*Property Name */			/* to */
		"user"	            => "DiscordUser",
        "account"           => "IntegrationAccount",
        "application"       => "IntegrationApplication"
	];

	public function __construct(array $properties = array())
	{
		parent::__construct($properties, self::InitializeProperties);
	}

    /**
     * integration id
     */
    public string $id;

    /**
     * 	integration name
     */
    public string $name;

    /**
     * integration type (twitch, youtube, or discord)
     */
    public string $type;

    /**
     * is this integration enabled
     */
    public bool $enabled;

    /**
     * is this integration syncing
     */
    public bool $syncing;

    /**
     * 	id that this integration uses for "subscribers"
     */
    public string $role_id;

    /**
     * whether emoticons should be synced for this integration (twitch only currently)
     */
    public bool $enable_emoticons;

    /**
     * the behavior of expiring subscribers
     */
    public int $expire_behavior;

    /**
     * 		the grace period (in days) before expiring subscribers
     */
    public int $expire_grace_period;

    /**
     * user for this integration
     */
    public $user;

    /**
     * integration account information
     */
    public $account;

    /**
     * 	when this integration was last synced
     */
    public string $synced_at;

    /**
     * how many subscribers this integration has
     */
    public int $subscriber_count;

    /**
     * has this integration been revoked
     */
    public bool $revoked;

    /**
     * The bot/OAuth2 application for discord integrations
     */
    public $application;
}
?>