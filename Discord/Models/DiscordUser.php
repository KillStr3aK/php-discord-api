<?php
namespace Nexd\Discord;

class UserFlags
{
    public const None = 0;

    public const DiscordEmployee = (1 << 0);

    public const PartneredServerOwner = (1 << 1);

    public const HypeSquadEvents = (1 << 2);

    public const BugHunterLevel1 = (1 << 3);

    public const HouseBravery = (1 << 6);

    public const HouseBrilliance = (1 << 7);

    public const HouseBalance = (1 << 8);

    public const EarlySupporter = (1 << 9);

    public const TeamUser = (1 << 10);

    public const BugHunterLevel2 = (1 << 14);

    public const VerifiedBot = (1 << 16);

    public const EarlyVerifiedBotDeveloper = (1 << 17);

    public const DiscordCertifiedModerator = (1 << 18);
}

class PremiumTypes
{
    public const None = 0;

    public const NitroClassic = 1;

    public const Nitro = 2;
}

class ConnectionVisibilityType
{
    /**
     * 	invisible to everyone except the user themselves
     */
    public const None = 0;

    /**
     * visible to everyone
     */
    public const Everyone = 1;
}

class DiscordConnection extends DiscordObjectParser
{
    /**
     * id of the connection account
     */
    public string $id;

    /**
     * the username of the connection account
     */
    public string $name;

    /**
     * the service of the connection (twitch, youtube)
     */
    public string $type;

    /**
     * 	whether the connection is revoked
     */
    public bool $revoked;

    /**
     * an array of partial server integrations
     */
    public array $integrations;

    /**
     * whether the connection is verified
     */
    public bool $verified;

    /**
     * whether friend sync is enabled for this connection
     */
    public bool $friend_sync;

    /**
     * whether activities related to this connection will be shown in presence updates
     */
    public bool $show_activity;

    /**
     * visibility of this connection
     */
    public int $visibility;
}

class BanObject extends DiscordObjectParser
{
    public function __construct(array $properties = array())
	{
		parent::__construct($properties);
		
		if(isset($properties["user"]))
			$this->user = new DiscordUser($properties["user"]);
	}

    public ?string $reason;

    public $user;
}

class DiscordUser extends DiscordObjectParser
{
    /**
     * the user's id
     */
    public string $id;

    /**
     * the user's username, not unique across the platform
     */
    public string $username;

    /**
     * the user's 4-digit discord-tag
     */
    public string $discriminator;

    /**
     * the user's avatar hash
     */
    public ?string $avatar;

    /**
     * whether the user belongs to an OAuth2 application
     */
    public bool $bot;

    /**
     * whether the user is an Official Discord System user (part of the urgent message system)
     */
    public ?bool $system = null;

    /**
     * 	whether the user has two factor enabled on their account
     */
    public ?bool $mfa_enabled = null;

    /**
     * the user's chosen language option
     */
    public ?string $locale = null;

    /**
     * whether the email on this account has been verified
     */
    public ?bool $verified = null;

    /**
     * the user's email
     */
    public ?string $email = null;

    /**
     * the flags on a user's account
     */
    public ?int $flags = null;

    /**
     * the type of Nitro subscription on a user's account
     */
    public ?int $premium_type = null;

    /**
     * the public flags on a user's account
     */
    public int $public_flags;
}
?>