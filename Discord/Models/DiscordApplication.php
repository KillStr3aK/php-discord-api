<?php
namespace Nexd\Discord;

class ApplicationFlags
{
	public const GATEWAY_PRESENCE = (1 << 12);

	public const GATEWAY_PRESENCE_LIMITED = (1 << 13);

	public const GATEWAY_GUILD_MEMBERS = (1 << 14);

	public const GATEWAY_GUILD_MEMBERS_LIMITED = (1 << 15);

	public const VERIFICATION_PENDING_GUILD_LIMIT = (1 << 16);

	public const EMBEDDED = (1 << 17);
}

class DiscordApplication extends DiscordObjectParser
{
    private const InitializeProperties =
	[	/*Property Name */			/* to */
		"owner"	            => "DiscordUser",
		"team"	            => "DiscordTeam",
	];

	public function __construct(array $properties = array())
	{
		parent::__construct($properties, self::InitializeProperties);
	}

	/**
	 * the id of the app
	 */
    public string $id;

	/**
	 * the name of the app
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
	 * an array of rpc origin urls, if rpc is enabled
	 */
	public array $rpc_origins;

	/**
	 * when false only app owner can join the app's bot to guilds
	 */
	public bool $bot_public;

	/**
	 * 	when true the app's bot will only join upon completion of the full oauth2 code grant flow
	 */
	public bool $bot_require_code_grant;

	/**
	 * the url of the app's terms of service
	 */
	public string $terms_of_service_url;

	/**
	 * the url of the app's privacy policy
	 */
	public string $privacy_policy_url;

	/**
	 * partial user object containing info on the owner of the application
	 */
	public $owner;

	/**
	 * 	if this application is a game sold on Discord, this field will be the summary field for the store page of its primary sku
	 */
	public string $summary;

	/**
	 * the hex encoded key for verification in interactions and the GameSDK's GetTicket
	 */
	public string $verify_key;

	/**
	 * 	if the application belongs to a team, this will be a list of the members of that team
	 */
	public $team = null;

	/**
	 * 	if this application is a game sold on Discord, this field will be the guild to which it has been linked
	 */
	public string $guild_id;

	/**
	 * 	if this application is a game sold on Discord, this field will be the id of the "Game SKU" that is created, if exists
	 */
	public string $primary_sku_id;

	/**
	 * if this application is a game sold on Discord, this field will be the URL slug that links to the store page
	 */
	public string $slug;

	/**
	 * the application's default rich presence invite cover image hash
	 */
	public string $cover_image;

	/**
	 * 	the application's public flags
	 */
	public int $flags;
}
?>