<?php
namespace Nexd\Discord;

use Exception;
use Nexd\Discord\DiscordEmbed;
use Nexd\Discord\Exceptions\DiscordEmbedLimitException;

class MessageType
{
    public const DEFAULT = 0;

    public const RECIPIENT_ADD = 1;

    public const RECIPIENT_REMOVE = 2;

    public const CALL = 3;

    public const CHANNEL_NAME_CHANGE = 4;

    public const CHANNEL_ICON_CHANGE = 5;

    public const CHANNEL_PINNED_MESSAGE = 6;

    public const GUILD_MEMBER_JOIN = 7;
    
    public const USER_PREMIUM_GUILD_SUBSCRIPTION = 8;

    public const USER_PREMIUM_GUILD_SUBSCRIPTION_TIER_1 = 9;

    public const USER_PREMIUM_GUILD_SUBSCRIPTION_TIER_2 = 10;

    public const USER_PREMIUM_GUILD_SUBSCRIPTION_TIER_3 = 11;

    public const CHANNEL_FOLLOW_ADD = 12;

    public const GUILD_DISCOVERY_DISQUALIFIED = 14;

    public const GUILD_DISCOVERY_REQUALIFIED = 15;

    public const GUILD_DISCOVERY_GRACE_PERIOD_INITIAL_WARNING = 16;

    public const GUILD_DISCOVERY_GRACE_PERIOD_FINAL_WARNING = 17;

    public const THREAD_CREATED = 18;
    
    public const REPLY = 9;

    public const APPLICATION_COMMAND = 20;

    public const THREAD_STARTER_MESSAGE = 21;

    public const GUILD_INVITE_REMINDER = 22;
}

class MessageActivityType
{
    public const JOIN = 1;

    public const SPECTATE = 2;

    public const LISTEN = 3;

    public const JOIN_REQUEST = 5;
}

class MessageFlags
{
    public const CROSSPOSTED = (1 << 0);	// this message has been published to subscribed channels (via Channel Following)

    public const IS_CROSSPOST = (1 << 1);	// this message originated from a message in another channel (via Channel Following)

    public const SUPPRESS_EMBEDS = (1 << 2);	// do not include any embeds when serializing this message

    public const SOURCE_MESSAGE_DELETED = (1 << 3);	// the source message for this crosspost has been deleted (via Channel Following)

    public const URGENT = (1 << 4);	// this message came from the urgent message system

    public const HAS_THREAD = (1 << 5);	// this message has an associated thread, with the same id as the message

    public const EPHEMERAL = (1 << 6);	// this message is only visible to the user who invoked the Interaction

    public const LOADING = (1 << 7);	// this message is an Interaction Response and the bot is "thinking"
}

class DiscordMessageReference
{
    /**
     * 	id of the originating message
     */
    public string $message_id;

    /**
     * 	id of the originating message's channel
     */
    public string $channel_id;

    /**
     * 	id of the originating message's guild
     */
    public string $guild_id;

    /**
     * 	when sending, whether to error if the referenced message doesn't exist instead of sending as a normal (non-reply) message, default true
     */
    public bool $fail_if_not_exists;
}

/**
 * TODO:
 * * https://discord.com/developers/docs/resources/channel#allowed-mentions-object
 * * https://discord.com/developers/docs/resources/channel#embed-object
 * * https://discord.com/developers/docs/resources/channel#attachment-object
 * * https://discord.com/developers/docs/interactions/message-components#component-object
 */
class ModifyDiscordMessage
{
    /**
     * the message contents (up to 2000 characters)
     */
    public string $content;

    /**
     * embedded rich content (up to 6000 characters)
     */
    public array $embeds;

    /**
     * (deprecated) embedded rich content, deprecated in favor of embeds
     */
    public $embed;

    /**
     * edit the flags of a message (only SUPPRESS_EMBEDS can currently be set/unset)
     */
    public int $flags;

    /**
     * the contents of the file being sent/edited
     */
    public $file;

    /**
     * 	JSON encoded body of non-file params (multipart/form-data only)
     */
    public string $payload_json;

    /**
     * allowed mentions for the message
     */
    public $allowed_mentions;

    /**
     * 	attached files to keep
     */
    public $attachments;

    /**
     * 	the components to include with the message
     */
    public $components;
}

class DiscordMessage extends DiscordObjectParser
{
    private const MAX_EMBEDS = 10;

    private const InitializeProperties =
	[	/*Property Name */			/* to */
		"author"	        => "DiscordUser",
		"member"            => "DiscordGuildMember",
        "stickers"          => "DiscordSticker[]",
        "sticker_items"     => "DiscordStickerItem[]",
        "thread"            => "DiscordChannel",
        "application"       => "DiscordApplication",
        "embeds"            => "DiscordEmbed[]"
	];

	public function __construct()
	{
        if(func_num_args() == 0)
            throw new Exception("Cannot create an empty DiscordMessage");

        switch(gettype(func_get_arg(0)))
        {
            case "string": $function = "__constructNew"; break;
            default: $function = "__constructFromData";
        }

        call_user_func_array(array($this, $function), func_get_args());
	}

    public function __constructFromData(DiscordMessage|array $msg)
	{
        parent::__construct((array)$msg, self::InitializeProperties);
	}

    public function __constructNew(string $content, ?array $embeds = null)
	{
        $this->content = $content;

        if(isset($embeds))
            $this->embeds = $embeds;
	}

    public function AddEmbed(DiscordEmbed $embed) : self
    {
        if($this->embeds == null)
            $this->embeds = [];
            
        if(count($this->embeds) < self::MAX_EMBEDS)
        {
            array_push($this->embeds, $embed);
            return $this;
        }

        throw new DiscordEmbedLimitException("DiscordMessage cannot have more than " . self::MAX_EMBEDS . " embeds.");
    }

    /**
     * 	id of the message
     */
    public string $id;

    /**
     * 	id of the channel the message was sent in
     */
    public string $channel_id;

    /**
     * 	id of the guild the message was sent in
     */
    public string $guild_id;

    /**
     * 	the author of this message (not guaranteed to be a valid user, see below)
     */
    public $author;

    /**
     * member properties for this message's author
     */
    public $member;

    /**
     * 	contents of the message
     */
    public ?string $content;

    /**
     * 	when this message was sent
     */
    public ?string $timestamp;

    /**
     * 	when this message was edited (or null if never)
     */
    public ?string $edited_timestamp;

    /**
     * 	whether this was a TTS message
     */
    public bool $tts;

    /**
     * 	whether this message mentions everyone
     */
    public bool $mention_everyone;

    /**
     * users specifically mentioned in the message
     */
    public ?array $mentions = null;

    /**
     * 	roles specifically mentioned in this message
     */
    public ?array $mention_roles = null;

    /**
     * channels specifically mentioned in this message
     */
    public ?array $mention_channels = null;

    /**
     * 	any attached files
     */
    public ?array $attachments = null;

    /**
     * 	any embedded content
     */
    public ?array $embeds = null;

    /**
     * 	reactions to the message
     */
    public ?array $reactions = null;

    /**
     * used for validating a message was sent
     */
    public $nonce;

    /**
     * whether this message is pinned
     */
    public bool $pinned;

    /**
     * if the message is generated by a webhook, this is the webhook's id
     */
    public string $webhook_id;

    /**
     * 	type of message
     */
    public int $type;

    /**
     * sent with Rich Presence-related chat embeds
     */
    public $activity;

    /**
     * 	sent with Rich Presence-related chat embeds
     */
    public $application;

    /**
     * 	if the message is a response to an Interaction, this is the id of the interaction's application
     */
    public string $application_id;

    /**
     * data showing the source of a crosspost, channel follow add, pin, or reply message
     */
    public $message_reference;

    /**
     * message flags combined as a bitfield
     */
    public int $flags;

    /**
     * the message associated with the message_reference
     */
    public $referenced_message;

    /**
     * sent if the message is a response to an Interaction
     */
    public $interaction;

    /**
     * 	the thread that was started from this message, includes thread member object
     */
    public $thread;

    /**
     * sent if the message contains components like buttons, action rows, or other interactive components
     */
    public ?array $components = null;

    /**
     * sent if the message contains stickers
     */
    public ?array $sticker_items = null;

    /**
     * (deprecated) the stickers sent with the message
     */
    public ?array $stickers = null;
}
?>