<?php
namespace Nexd\Discord;

class VerificationLevel
{
	/**
	 * unrestricted
	*/
	public const NONE = 0;

	/**
	 * must have verified email on account
	*/
	public const LOW = 1;

	/**
	 * must be registered on Discord for longer than 5 minutes
	*/
	public const MEDIUM = 2;

	/**
	 * must be a member of the server for longer than 10 minutes
	*/
	public const HIGH = 3;

	/**
	 * must have a verified phone number
	*/
	public const VERY_HIGH = 4;
}

class MessageNotificationLevel
{
	/**
	 * members will receive notifications for all messages by default
	 */
	public const ALL_MESSAGES = 0;

	/**
	 * 	members will receive notifications only for messages that @mention them by default
	 */
	public const ONLY_MENTIONS = 1;
}

class ExplicitContentFilterLevel
{
	/**
	 * media content will not be scanned
	 */
	public const DISABLED = 0;

	/**
	 * media content sent by members without roles will be scanned
	 */
	public const MEMBERS_WITHOUT_ROLES = 1;

	/**
	 * 	media content sent by all members will be scanned
	 */
	public const ALL_MEMBERS = 2;
}

class MFALevel
{
	/**
	 * guild has no MFA/2FA requirement for moderation actions
	 */
	public const NONE = 0;

	/**
	 * guild has a 2FA requirement for moderation actions
	 */
	public const ELEVATED = 1;
}

class NSFWLevel
{
	public const DEFAULT = 0;

	public const EXPLICIT = 1;

	public const SAFE = 2;

	public const AGE_RESTRICTED = 3;
}

class PremiumTier
{
	/**
	 * guild has not unlocked any Server Boost perks
	 */
	public const NONE = 0;

	/**
	 * guild has unlocked Server Boost level 1 perks
	 */
	public const TIER_1 = 1;

	/**
	 * guild has unlocked Server Boost level 2 perks
	 */
	public const TIER_2 = 2;

	/**
	 * guild has unlocked Server Boost level 3 perks
	 */
	public const TIER_3 = 3;
}

class SystemChannelFlags
{
	/**
	 * Suppress member join notifications
	 */
	public const SUPPRESS_JOIN_NOTIFICATIONS = 0b0000;

	/**
	 * 	Suppress server boost notifications
	 */
	public const SUPPRESS_PREMIUM_SUBSCRIPTIONS = 0b0001;

	/**
	 * Suppress server setup tips
	 */
	public const SUPPRESS_GUILD_REMINDER_NOTIFICATIONS = 0b0010;
}

class GuildFeatures
{
	/**
	 * guild has access to set an animated guild icon
	 */
	public const ANIMATED_ICON = "ANIMATED_ICON";

	/**
	 * guild has access to set a guild banner image
	 */
	public const BANNER = "BANNER";

	/**
	 * guild has access to use commerce features (i.e. create store channels)
	 */
	public const COMMERCE = "COMMERCE";

	/**
	 * guild can enable welcome screen, Membership Screening, stage channels and discovery, and receives community updates
	 */
	public const COMMUNITY = "COMMUNITY";

	/**
	 * guild is able to be discovered in the directory
	 */
	public const DISCOVERABLE = "DISCOVERABLE";

	/**
	 * guild is able to be featured in the directory
	 */
	public const FEATURABLE = "FEATURABLE";

	/**
	 * guild has access to set an invite splash background
	 */
	public const INVITE_SPLASH = "INVITE_SPLASH";

	/**
	 * guild has enabled Membership Screening
	 */
	public const MEMBER_VERIFICATION_GATE_ENABLED = "MEMBER_VERIFICATION_GATE_ENABLED";

	/**
	 * 	guild has access to create news channels
	 */
	public const NEWS = "NEWS";

	/**
	 * guild is partnered
	 */
	public const PARTNERED = "PARTNERED";

	/**
	 * 	guild can be previewed before joining via Membership Screening or the directory
	 */
	public const PREVIEW_ENABLED = "PREVIEW_ENABLED";

	/**
	 * guild has access to set a vanity URL
	 */
	public const VANITY_URL = "VANITY_URL";

	/**
	 * guild is verified
	 */
	public const VERIFIED = "VERIFIED";

	/**
	 * guild has access to set 384kbps bitrate in voice (previously VIP voice servers)
	 */
	public const VIP_REGIONS = "VIP_REGIONS";

	/**
	 * guild has enabled the welcome screen
	 */
	public const WELCOME_SCREEN_ENABLED = "WELCOME_SCREEN_ENABLED";

	/**
	 * guild has enabled ticketed events
	 */
	public const TICKETED_EVENTS_ENABLED = "TICKETED_EVENTS_ENABLED";

	/**
	 * 	guild has enabled monetization
	 */
	public const MONETIZATION_ENABLED = "MONETIZATION_ENABLED";

	/**
	 * guild has increased custom sticker slots
	 */
	public const MORE_STICKERS = "MORE_STICKERS";

	/**
	 * guild has access to the three day archive time for threads
	 */
	public const THREE_DAY_THREAD_ARCHIVE = "THREE_DAY_THREAD_ARCHIVE";

	/**
	 * guild has access to the seven day archive time for threads
	 */
	public const SEVEN_DAY_THREAD_ARCHIVE = "SEVEN_DAY_THREAD_ARCHIVE";

	/**
	 * guild has access to create private threads
	 */
	public const PRIVATE_THREADS = "PRIVATE_THREADS";
}

class ModifyDiscordGuild
{
	/**
	 * guild name
	 */
	public string $name;

	/**
	 * guild voice region id (deprecated)
	 */
	public ?string $region;

	/**
	 * 	verification level
	 */
	public ?int $verification_level;

	/**
	 * 	default message notification level
	 */
	public ?int $default_message_notifications;

	/**
	 * explicit content filter level
	 */
	public ?int $explicit_content_filter;

	/**
	 * id for afk channel
	 */
	public ?string $afk_channel_id;

	/**
	 * afk timeout in seconds
	 */
	public int $afk_timeout;

	/**
	 * base64 1024x1024 png/jpeg/gif image for the guild icon (can be animated gif when the server has the ANIMATED_ICON feature)
	 */
	public mixed $icon;

	/**
	 * 	user id to transfer guild ownership to (must be owner)
	 */
	public string $owner_id;

	/**
	 * 	base64 16:9 png/jpeg image for the guild splash (when the server has the INVITE_SPLASH feature)
	 */
	public mixed $splash;

	/**
	 * base64 16:9 png/jpeg image for the guild discovery splash (when the server has the DISCOVERABLE feature)
	 */
	public mixed $discovery_splash;

	/**
	 * 	base64 16:9 png/jpeg image for the guild banner (when the server has the BANNER feature)
	 */
	public mixed $banner;

	/**
	 * 	the id of the channel where guild notices such as welcome messages and boost events are posted
	 */
	public ?string $system_channel_id;

	/**
	 * system channel flags
	 */
	public int $system_channel_flags;

	/**
	 * 	the id of the channel where Community guilds display rules and/or guidelines
	 */
	public ?string $rules_channel_id;

	/**
	 * the id of the channel where admins and moderators of Community guilds receive notices from Discord
	 */
	public ?string $public_updates_channel_id;

	/**
	 * the preferred locale of a Community guild used in server discovery and notices from Discord; defaults to "en-US"
	 */
	public ?string $preferred_locale;

	/**
	 * enabled guild features
	 */
	public array $features;

	/**
	 * the description for the guild, if the guild is discoverable
	 */
	public ?string $description;
}

class DiscordGuildStickerType
{
	/**
	 * an official sticker in a pack, part of Nitro or in a removed purchasable pack
	 */
	public const STANDARD = 1;

	/**
	 * a sticker uploaded to a Boosted guild for the guild's members
	 */
	public const GUILD = 2;
}

class DiscordGuildStickerFormat
{
	public const PNG = 1;

	public const APNG = 2;
	
	public const LOTTIE = 3;
}

/**
 * Guilds in Discord represent an isolated collection of users and channels, and are often referred to as "servers" in the UI.
*/
class DiscordGuild extends DiscordObjectParser
{
	private const InitializeProperties =
	[	/*Property Name */			/* to */
		"stage_instances"	=> "DiscordGuildStageInstance[]",
		"roles"				=> "DiscordRole[]",
		"emojis"			=> "DiscordEmoji[]",
		"members"			=> "DiscordGuildMember[]",
		"channels"			=> "DiscordChannel[]",
		"threads"			=> "DiscordChannel[]"
	];

	public function __construct(array $properties = array())
	{
		parent::__construct($properties, self::InitializeProperties);
	}

	/**
     * guild id
     */
    public string $id;

    /**
     * guild name (2-100 characters, excluding trailing and leading whitespace)
     */
    public string $name;

    /**
     * icon hash
     */
    public ?string $icon = null;

    /**
     * icon hash, returned when in the template object
     */
    public ?string $icon_splash = null;

    /**
     * splash hash
     */
    public ?string $splash = null;

    /**
     * discovery splash hash; only present for guilds with the "DISCOVERABLE" feature
     */
    public ?string $discovery_splash = null;

	/**
	 * true if the user is the owner of the guild
	 */
	public ?bool $owner = false;

	/**
	 * id of owner
	 */
	public string $owner_id;

	/**
	 * total permissions for the user in the guild (excludes overwrites)
	 */
	public ?string $permissions = null;

	/**
	 * voice region id for the guild (deprecated)
	 */
	public string $region;

	/**
	 * id of afk channel
	 */
	public ?string $afk_channel_id = null;

	/**
	 * afk timeout in seconds
	 */
	public int $afk_timeout;

	/**
	 * true if the server widget is enabled
	 */
	public bool $widget_enabled;

	/**
	 * the channel id that the widget will generate an invite to, or null if set to no invite
	 */
	public ?string $widget_channel_id = null;

	/**
	 * verification level required for the guild
	 */
	public int $verification_level;

	/**
	 * default message notifications level
	 */
	public int $default_message_notifications;

	/**
	 * explicit content filter level
	 */
	public int $explicit_content_filter;

	/**
	 * roles in the guild
	 */
	public array $roles;

	/**
	 * custom guild emojis
	 */
	public array $emojis;

	/**
	 * enabled guild features
	 */
	public array $features;

	/**
	 * required MFA level for the guild
	 */
	public int $mfa_level;

	/**
	 * application id of the guild creator if it is bot-created
	 */
	public ?string $application_id = null;

	/**
	 * the id of the channel where guild notices such as welcome messages and boost events are posted
	 */
	public ?string $system_channel_id = null;

	/**
	 * system channel flags
	 */
	public int $system_channel_flags;

	/**
	 * the id of the channel where Community guilds can display rules and/or guidelines
	 */
	public ?string $rules_channel_id = null;

	/**
	 * when this guild was joined at
	 */
	public ?string $joined_at = null;

	/**
	 * true if this is considered a large guild
	 */
	public ?bool $large = null;

	/**
	 * 	true if this guild is unavailable due to an outage
	 */
	public ?bool $unavailable = null;

	/**
	 * 	total number of members in this guild
	 */
	public ?int $member_count = null;

	/**
	 * states of members currently in voice channels; lacks the guild_id key
	 */
	public ?array $voice_states = null;

	/**
	 * users in the guild
	 */
	public ?array $members = null;

	/**
	 * channels in the guild
	 */
	public ?array $channels = null;

	/**
	 * all active threads in the guild that current user has permission to view
	 */
	public ?array $threads = null;

	/**
	 * presences of the members in the guild, will only include non-offline members if the size is greater than large threshold
	 */
	public ?array $presences = null;

	/**
	 * the maximum number of presences for the guild (null is always returned, apart from the largest of guilds)
	 */
	public ?int $max_presences = 0;

	/**
	 * 	the maximum number of members for the guild
	 */
	public int $max_members;

	/**
	 * 	the vanity url code for the guild
	 */
	public ?string $vanity_url_code = null;

	/**
	 * the description of a Community guild
	 */
	public ?string $description = null;

	/**
	 * banner hash
	 */
	public ?string $banner = null;

	/**
	 * premium tier (Server Boost level)
	 */
	public int $premium_tier;

	/**
	 * the number of boosts this guild currently has
	 */
	public int $premium_subscription_count;

	/**
	 * the preferred locale of a Community guild; used in server discovery and notices from Discord; defaults to "en-US"
	 */
	public string $preferred_locale;

	/**
	 * the id of the channel where admins and moderators of Community guilds receive notices from Discord
	 */
	public ?string $public_updates_channel_id = null;

	/**
	 * the maximum amount of users in a video channel
	 */
	public int $max_video_channel_users;
	/**
	 * approximate number of members in this guild, returned from the GET /guilds/<id> endpoint when with_counts is true
	 */
	public ?int $approximate_member_count = null;

	/**
	 * approximate number of non-offline members in this guild, returned from the GET /guilds/<id> endpoint when with_counts is true
	 */
	public ?int $approximate_presence_count = null;

	/**
	 * the welcome screen of a Community guild, shown to new members, returned in an Invite's guild object
	 */
	public array $welcome_screen;

	/**
	 * 	guild NSFW level
	 */
	public ?int $nsfw_level = null;

	/**
	 * 	Stage instances in the guild
	 */
	public ?array $stage_instances = null;
	/**
	 * 	custom guild stickers
	 */
	public array $stickers;
}
?>