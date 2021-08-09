<?php
namespace Nexd\Discord;

use Nexd\Discord\DiscordRequest;
use Nexd\Discord\DiscordGuild;
use Nexd\Discord\DiscordGuildMember;
use Nexd\Discord\DiscordGuildPreview;
use Nexd\Discord\DiscordUser;
use Nexd\Discord\DiscordChannel;
use Nexd\Discord\DiscordMessage;

use Nexd\Discord\ModifyDiscordGuild;
use Nexd\Discord\ModifyDiscordGuildMember;
use Nexd\Discord\ModifyDiscordChannel;
use Nexd\Discord\ModifyDiscordMessage;
use Nexd\Discord\ModifyDiscordRole;

use Nexd\Discord\CreateDiscordRole;

use Nexd\Discord\Exceptions\DiscordInvalidResponseException;

class DiscordBot
{
    public function __construct(public ?string $token) { }

    /**
     * Returns the guild object for the given id.
     * If with_counts is set to true, this endpoint will also return approximate_member_count and approximate_presence_count for the guild.
     * @return DiscordGuild object on success.
     */
    public function GetGuild(string $id) : DiscordGuild
    {
        return new DiscordGuild($this->SendRequest("guilds/$id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns the guild preview object for the given id.
     * If the user is not in the guild, then the guild must be lurkable (it must be Discoverable or have a live public stage).
     * @return DiscordGuildPreview object on success.
     */
    public function GetGuildPreview(string $id) : DiscordGuildPreview
    {
        return new DiscordGuildPreview($this->SendRequest("guilds/$id/preview", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Modify a guild's settings.
     * Requires the MANAGE_GUILD permission.
     * Returns the updated guild.
     * Fires a Guild Update Gateway event.
     * @return DiscordGuild on success.
     */
    public function ModifyGuild(string $id, ModifyDiscordGuild $modify) : DiscordGuild
    {
        return new DiscordGuild($this->SendRequest("guilds/$id", DiscordRequest::HTTPRequestMethod_PATCH, $modify));
    }

    /**
     * Delete a guild permanently.
     * User must be owner.
     * Returns 204 No Content on success.
     * Fires a Guild Delete Gateway event.
     */
    public function DeleteGuild(string $id) : void
    {
        $this->SendRequest("guilds/$id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Does not include threads.
     * @return array of guild DiscordChannel objects.
     */
    public function GetGuildChannels(string $id) : array
    {
        $result = $this->SendRequest("guilds/$id/channels", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordChannel($value);
        }

        return $result;
    }

    /**
     * Returns all active threads in the guild, including public and private threads.
     * Threads are ordered by their id, in descending order.
     */
    public function GetActiveThreads(string $id) : array
    {
        $result = $this->SendRequest("guilds/$id/threads/active", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result["threads"] as $index => $value)
        {
            $result["threads"][$index] = new DiscordChannel($value);
        }

        foreach($result["members"] as $index => $value)
        {
            $result["members"][$index] = new ThreadMember($value);
        }

        return $result;
    }

    /**
     * Returns a guild member object for the specified user.
     */
    public function GetGuildMember(string $guild_id, string $user_id) : DiscordGuildMember
    {
        return new DiscordGuildMember($this->SendRequest("guilds/$guild_id/members/$user_id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns a list of guild member objects that are members of the guild.
     */
    public function GetGuildMembers(string $id, int $limit = 1, string $after = null) : array
    {
        $route = "guilds/$id/members?limit=$limit";
        if(isset($after))
            $route .= "&after=$after";

        $result = $this->SendRequest($route, DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordGuildMember($value);
        }

        return $result;
    }

    /**
     * Returns a list of guild member objects whose username or nickname starts with a provided string.
     */
    public function SearchGuildMember(string $id, string $query, int $limit = 1) : array
    {
        $result = $this->SendRequest("guilds/$id/members/search?query=$query&limit=$limit", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordGuildMember($value);
        }

        return $result;
    }

    /**
     * Modify attributes of a guild member.
     * Returns a 200 OK with the guild member as the body.
     * Fires a Guild Member Update Gateway event.
     * If the channel_id is set to null, this will force the target user to be disconnected from voice.
     */
    public function ModifyGuildMember(string $guild_id, string $user_id, ModifyDiscordGuildMember $modify) : DiscordGuildMember
    {
        return new DiscordGuildMember($this->SendRequest("guilds/$guild_id/members/$user_id", DiscordRequest::HTTPRequestMethod_PATCH, $modify));
    }

    /**
     * Modifies the nickname of the current user in a guild.
     * Returns a 200 with the nickname on success.
     * Fires a Guild Member Update Gateway event.
     * @param null|string $nick value to set users nickname to, requires CHANGE_NICKNAME permission
     */
    public function ModifyCurrentUserNick(string $id, ?string $nick) : string
    {
        return $this->SendRequest("guilds/$id/members/@me/nick", DiscordRequest::HTTPRequestMethod_PATCH, [ "nick" => $nick ]);
    }

    /**
     * Adds a role to a guild member.
     * Requires the MANAGE_ROLES permission.
     * Returns a 204 empty response on success.
     * Fires a Guild Member Update Gateway event.
     */
    public function AddMemberRole(string $guild_id, string $user_id, string $role_id) : void
    {
        $this->SendRequest("guilds/$guild_id/members/$user_id/roles/$role_id", DiscordRequest::HTTPRequestMethod_PUT);
    }

    /**
     * Removes a role from a guild member. Requires the MANAGE_ROLES permission.
     * Returns a 204 empty response on success.
     * Fires a Guild Member Update Gateway event.
     */
    public function RemoveMemberRole(string $guild_id, string $user_id, string $role_id) : void
    {
        $this->SendRequest("guilds/$guild_id/members/$user_id/roles/$role_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Remove a member from a guild. Requires KICK_MEMBERS permission.
     * Returns a 204 empty response on success.
     * Fires a Guild Member Remove Gateway event.
     */
    public function KickMember(string $guild_id, string $user_id) : void
    {
        $this->SendRequest("guilds/$guild_id/members/$user_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Create a guild ban, and optionally delete previous messages sent by the banned user.
     * Requires the BAN_MEMBERS permission.
     * Returns a 204 empty response on success.
     * Fires a Guild Ban Add Gateway event.
     */
    public function BanMember(string $guild_id, string $user_id, string $reason, int $deleteMessages) : void
    {
        $json = [];
        if(isset($deleteMessages))
        {
            if($deleteMessages < 0) $deleteMessages = 0;
            else if($deleteMessages > 7) $deleteMessages = 7;

            $json["delete_message_days"] = $deleteMessages;
        }
        
        if(isset($reason))
            $json["reason"] = $reason;
        
        $this->SendRequest("guilds/$guild_id/bans/$user_id", DiscordRequest::HTTPRequestMethod_PUT, $json);
    }

    /**
     * Remove the ban for a user.
     * Requires the BAN_MEMBERS permissions.
     * Returns a 204 empty response on success.
     * Fires a Guild Ban Remove Gateway event.
     */
    public function UnbanMember(string $guild_id, string $user_id) : void
    {
        $this->SendRequest("guilds/$guild_id/bans/$user_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Returns a ban object for the given user or a 404 not found if the ban cannot be found.
     * Requires the BAN_MEMBERS permission.
     */
    public function GetGuildBan(string $guild_id, string $user_id) : BanObject
    {
        return new BanObject($this->SendRequest("guilds/$guild_id/bans/$user_id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns a list of ban objects for the users banned from this guild.
     * Requires the BAN_MEMBERS permission.
     */
    public function GetGuildBans(string $guild_id) : array
    {
        $result = $this->SendRequest("guilds/$guild_id/bans", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new BanObject($value);
        }

        return $result;
    }

    /**
     * Returns a list of role objects for the guild.
     */
    public function GetGuildRoles(string $id) : array
    {
        $result = $this->SendRequest("guilds/$id/roles", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordRole($value);
        }

        return $result;
    }

    /**
     * Returns the user object of the requester's account.
     * For OAuth2, this requires the identify scope, which will return the object without an email, and optionally the email scope, which returns the object with an email.
     */
    public function GetCurrentUser() : DiscordUser
    {
        return new DiscordUser($this->SendRequest("users/@me", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns a user object for a given user ID.
     */
    public function GetUser(string $id) : DiscordUser
    {
        return new DiscordUser($this->SendRequest("users/$id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Modify the requester's user account settings.
     * Returns a user object on success.
     */
    public function ModifyCurrentUser(string $username, mixed $avatar = null) : DiscordUser
    {
        $json = [ "username" => $username ];
        if(isset($avatar))
            $json["avatar"] = $avatar;

        return new DiscordUser($this->SendRequest("users/@me", DiscordRequest::HTTPRequestMethod_PATCH, $json));
    }

    /**
     * Returns a list of partial guild objects the current user is a member of.
     * Requires the guilds OAuth2 scope.
     */
    public function GetCurrentUserGuilds() : array
    {
        $result = $this->SendRequest("users/@me/guilds", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordChannel($value);
        }

        return $result;
    }

    /**
     * Leave a guild.
     * Returns a 204 empty response on success.
     */
    public function LeaveGuild(string $id) : void
    {
        $this->SendRequest("users/@meguilds/$id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Create a new DM channel with a user.
     * @return DiscordChannel DM channel object.
     * @param string $id the recipient to open a DM channel with
     */
    public function CreateDM(string $id) : DiscordChannel
    {
        return new DiscordChannel($this->SendRequest("users/@me/channels", DiscordRequest::HTTPRequestMethod_POST, [ "recipient_id" => $id ]));
    }

    /**
     * Create a new group DM channel with multiple users. Returns a DM channel object.
     * This endpoint was intended to be used with the now-deprecated GameBridge SDK.
     * DMs created with this endpoint will not be shown in the Discord client
     * @param array $access_tokens access tokens of users that have granted your app the gdm.join scope
     * @param array $nicks 	a dictionary of user ids to their respective nicknames
     */
    public function CreateGroupDM(array $access_tokens, array $nicks) : DiscordChannel
    {
        return new DiscordChannel($this->SendRequest("users/@me/channels", DiscordRequest::HTTPRequestMethod_POST, [ "access_tokens" => $access_tokens, "nicks" => $nicks ]));
    }

    /**
     * Returns a list of connection objects. Requires the connections OAuth2 scope.
     */
    public function GetCurrentUserConnections() : array
    {
        $result = $this->SendRequest("users/@me/connections", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordConnection($value);
        }

        return $result;
    }

    /**
     * Get a channel by ID.
     * @return DiscordChannel object.
     * If the channel is a thread, a thread member object is included in the returned result.
     */
    public function GetChannel(string $id) : DiscordChannel
    {
        return new DiscordChannel($this->SendRequest("channels/$id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Update a channel's settings.
     * Returns a channel on success, and a 400 BAD REQUEST on invalid parameters.
     * All JSON parameters are optional.
     * @param string $id DM channel id that you want to modify.
     * @param string $name New name for the channel.
     * @param string $icon New base64 encoded icon.
     */
    public function ModifyDMChannel(string $id, string $name, string $icon = null) : DiscordChannel
    {
        $json = [ "name" => $name ];
        if(isset($icon))
            $json["icon"] = $icon;

        return new DiscordChannel($this->SendRequest("channels/$id", DiscordRequest::HTTPRequestMethod_PATCH, $json));
    }

    /**
     * Update a channel's settings.
     * All JSON parameters are optional.
     * @return DiscordChannel object on success, and a 400 BAD REQUEST on invalid parameters.
     */
    public function ModifyChannel(string $id, ModifyDiscordChannel $modify) : DiscordChannel
    {
        return new DiscordChannel($this->SendRequest("channels/$id", DiscordRequest::HTTPRequestMethod_PATCH, $modify));
    }

    /**
     * Delete a channel, or close a private message.
     * Requires the MANAGE_CHANNELS permission for the guild, or MANAGE_THREADS if the channel is a thread.
     * Deleting a category does not delete its child channels; they will have their parent_id removed and a Channel Update Gateway event will fire for each of them.
     * @return DiscordChannel object on success. Fires a Channel Delete Gateway event (or Thread Delete if the channel was a thread).
     */
    public function DeleteChannel(string $id) : DiscordChannel
    {
        return new DiscordChannel($this->SendRequest("channels/$id", DiscordRequest::HTTPRequestMethod_DELETE));
    }

    /**
     * Returns the messages for a channel.
     * If operating on a guild channel, this endpoint requires the VIEW_CHANNEL permission to be present on the current user.
     * If the current user is missing the 'READ_MESSAGE_HISTORY' permission in the channel then this will return no messages (since they cannot read the message history).
     * @return array of DiscordMessage objects on success.
     */
    public function GetChannelMessages(string $id, int $limit = 50) : array
    {
        $result = $this->SendRequest("channels/$id/messages?limit=$limit", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordMessage($value);
        }

        return $result;
    }

    /**
     * Returns a specific message in the channel.
     * If operating on a guild channel, this endpoint requires the 'READ_MESSAGE_HISTORY' permission to be present on the current user.
     * @return DiscordMessage object on success.
     */
    public function GetChannelMessage(string $channel_id, string $message_id) : DiscordMessage
    {
        return new DiscordMessage($this->SendRequest("channels/$channel_id/messages/$message_id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Post a message to a guild text or DM channel.
     * Returns a message object.
     * Fires a Message Create Gateway event.
     * See message formatting for more information on how to properly format messages.
     * 
     * For limitations, check: https://discord.com/developers/docs/resources/channel#create-message-limitations
     * 
     * For parameters, check: https://discord.com/developers/docs/resources/channel#create-message-jsonform-params
     * @return DiscordMessage object.
     */
    public function SendMessage(string $channel_id, DiscordMessage $message) : DiscordMessage
    {
        return new DiscordMessage($this->SendRequest("channels/$channel_id/messages", DiscordRequest::HTTPRequestMethod_POST, $message));
    }

    /**
     * Edit a previously sent message.
     * The fields content, embeds, and flags can be edited by the original message author.
     * Other users can only edit flags and only if they have the MANAGE_MESSAGES permission in the corresponding channel.
     * When specifying flags, ensure to include all previously set flags/bits in addition to ones that you are modifying.
     * Only flags documented in the table below may be modified by users (unsupported flag changes are currently ignored without error).
     * When the content field is edited, the mentions array in the message object will be reconstructed from scratch based on the new content.
     * The allowed_mentions field of the edit request controls how this happens.
     * If there is no explicit allowed_mentions in the edit request, the content will be parsed with default allowances,
     * that is, without regard to whether or not an allowed_mentions was present in the request that originally created the message.
     * @return DiscordMessage object. Fires a Message Update Gateway event.
     */
    public function EditMessage(string $channel_id, string $message_id, ModifyDiscordMessage $modify) : DiscordMessage
    {
        return new DiscordMessage($this->SendRequest("channels/$channel_id/messages/$message_id", DiscordRequest::HTTPRequestMethod_PATCH, $modify));
    }

    /**
     * Delete a message.
     * If operating on a guild channel and trying to delete a message that was not sent by the current user, this endpoint requires the MANAGE_MESSAGES permission.
     * Returns a 204 empty response on success.
     * Fires a Message Delete Gateway event.
     */
    public function DeleteMessage(string $channel_id, string $message_id) : void
    {
        $this->SendRequest("channels/$channel_id/messages/$message_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Delete multiple messages in a single request.
     * This endpoint can only be used on guild channels and requires the MANAGE_MESSAGES permission.
     * Returns a 204 empty response on success.
     * Fires a Message Delete Bulk Gateway event.
     * 
     * @param array $messages_id Any message IDs given that do not exist or are invalid will count towards the minimum and maximum message count (currently 2 and 100 respectively).
     */
    public function BulkDeleteMessages(string $channel_id, array $messages_id) : void
    {
        $this->SendRequest("channels/$channel_id/messages/bulk-delete", DiscordRequest::HTTPRequestMethod_POST, [ "messages" => $messages_id ]);
    }

    /**
     * Returns a list of emoji objects for the given guild.
     * @return array of DiscordEmoji objects.
     */
    public function GetGuildEmojis(string $guild_id) : array
    {
        $result = $this->SendRequest("guilds/$guild_id/emojis", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordEmoji($value);
        }

        return $result;
    }

    /**
     * Returns an emoji object for the given guild and emoji IDs.
     * @return DiscordEmoji object for the given guild and emoji IDs.
     */
    public function GetGuildEmoji(string $guild_id, string $emoji_id) : DiscordEmoji
    {
        return new DiscordEmoji($this->SendRequest("guilds/$guild_id/emojis/$emoji_id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Create a new emoji for the guild.
     * Requires the MANAGE_EMOJIS_AND_STICKERS permission.
     * Returns the new emoji object on success.
     * Fires a Guild Emojis Update Gateway event.
     * Emojis and animated emojis have a maximum file size of 256kb.
     * Attempting to upload an emoji larger than this limit will fail and return 400 Bad Request and an error message, but not a JSON status code.
     * @param string $name name of the emoji.
     * @param mixed $imagedata 128x128 emoji image. See: https://discord.com/developers/docs/reference#image-data.
     * @param array $roles roles allowed to use this emoji (array of snowflakes).
     * @return DiscordEmoji object on success.
     */
    public function CreateGuildEmoji(string $guild_id, string $name, mixed $imagedata, array $roles) : DiscordEmoji
    {
        return new DiscordEmoji($this->SendRequest("guilds/$guild_id/emojis", DiscordRequest::HTTPRequestMethod_POST, [ "name" => $name, "image" => $imagedata, "roles" => $roles ]));
    }

    /**
     * Modify the given emoji.
     * Requires the MANAGE_EMOJIS_AND_STICKERS permission.
     * Returns the updated emoji object on success.
     * Fires a Guild Emojis Update Gateway event.
     * @return DiscordEmoji object on success.
     */
    public function ModifyGuildEmoji(string $guild_id, string $emoji_id, string $name, ?array $roles = null) : DiscordEmoji
    {
        return new DiscordEmoji($this->SendRequest("guilds/$guild_id/emojis/$emoji_id", DiscordRequest::HTTPRequestMethod_PATCH, [ "name" => $name, "roles" => $roles ]));
    }

    /**
     * Delete the given emoji.
     * Requires the MANAGE_EMOJIS_AND_STICKERS permission.
     * Returns 204 No Content on success.
     * Fires a Guild Emojis Update Gateway event.
     */
    public function DeleteGuildEmoji(string $guild_id, string $emoji_id) : void
    {
        $this->SendRequest("guilds/$guild_id/emojis/$emoji_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Updates another user's voice state.
     * For caveats, see: https://discord.com/developers/docs/resources/guild#modify-user-voice-state-caveats.
     * @param string $channel_id the id of the channel the user is currently in.
     * @param bool $suppress toggles the user's suppress state.
     */
    public function ModifyUserVoiceState(string $guild_id, string $user_id, string $channel_id, bool $suppress) : void
    {
        $this->SendRequest("guilds/$guild_id/voice-states/$user_id", DiscordRequest::HTTPRequestMethod_PATCH, [ "channel_id" => $channel_id, "suppress" => $suppress ]);
    }

    /**
     * Updates the current user's voice state.
     * For caveats, see: https://discord.com/developers/docs/resources/guild#modify-current-user-voice-state-caveats.
     */
    public function ModifyCurrentUserVoiceState(string $guild_id, string $channel_id, bool $suppress, ?string $request_to_speak_timestamp = null) : void
    {
        $this->SendRequest("guilds/$guild_id/voice-states/@me", DiscordRequest::HTTPRequestMethod_PATCH, [ "channel_id" => $channel_id, "suppress" => $suppress, "request_to_speak_timestamp" => $request_to_speak_timestamp ]);
    }

    /**
     * Returns a guild widget object.
     * Requires the MANAGE_GUILD permission.
     * @return DiscordGuildWidget object.
     */
    public function GetGuildWidgetSettings(string $guild_id) : DiscordGuildWidget
    {
        return new DiscordGuildWidget($this->SendRequest("guilds/$guild_id/widget", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns the widget for the guild.
     * @return Example https://discord.com/developers/docs/resources/guild#get-guild-widget-example-get-guild-widget
     */
    public function GetGuildWidget(string $guild_id) : mixed
    {
        return $this->SendRequest("guilds/$guild_id/widget.json", DiscordRequest::HTTPRequestMethod_GET);
    }

    /**
     * Modify a guild widget object for the guild.
     * All attributes may be passed in with JSON and modified.
     * Requires the MANAGE_GUILD permission.
     * @return DiscordGuildWidget the updated guild widget object.
     */
    public function ModifyGuildWidget(string $guild_id, DiscordGuildWidget $modify) : DiscordGuildWidget
    {
        return new DiscordGuildWidget($this->SendRequest("guilds/$guild_id/widget", DiscordRequest::HTTPRequestMethod_PATCH, $modify));
    }

    /**
     * Returns a PNG image widget for the guild.
     * Requires no permissions or authentication.
     * @param string $style widget style options.
     * 
     * Available styles:
     * * 'shield' example: https://discord.com/api/guilds/81384788765712384/widget.png?style=shield
     * * 'banner1' example: https://discord.com/api/guilds/81384788765712384/widget.png?style=banner1
     * * 'banner2' example: https://discord.com/api/guilds/81384788765712384/widget.png?style=banner2
     * * 'banner3' example: https://discord.com/api/guilds/81384788765712384/widget.png?style=banner3
     * * 'banner4' example: https://discord.com/api/guilds/81384788765712384/widget.png?style=banner4
     * @return string widget url.
     */
    public function GetGuildWidgetImage(string $guild_id, string $style = "shield") : string
    {
        return $this->SendRequest("guilds/$guild_id/widget.png?style=$style", DiscordRequest::HTTPRequestMethod_GET);
    }

    /**
     * Returns a partial invite object for guilds with that feature enabled.
     * Requires the MANAGE_GUILD permission.
     * code will be null if a vanity url for the guild is not set.
     * @return DiscordInvite object.
     */
    public function GetGuildVanityURL(string $guild_id) : DiscordInvite
    {
        return new DiscordInvite($this->SendRequest("guilds/$guild_id/vanity-url", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns the Welcome Screen object for the guild.
     * @return DiscordGuildWelcomeScreen for the guild.
     */
    public function GetGuildWelcomeScreen(string $guild_id) : DiscordGuildWelcomeScreen
    {
        return new DiscordGuildWelcomeScreen($this->SendRequest("guilds/$guild_id/welcome-screen", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Modify the guild's Welcome Screen.
     * Requires the MANAGE_GUILD permission.
     * Returns the updated Welcome Screen object.
     * All parameters to this endpoint are optional and nullable.
     * @param bool $enabled whether the welcome screen is enabled.
     * @param array $welcome_channels array of welcome screen channel objects, channels linked in the welcome screen and their display options.
     * @param string $description the server description to show in the welcome screen.
     */
    public function ModifyGuildWelcomeScreen(string $guild_id, bool $enabled, array $welcome_channels, string $description) : DiscordGuildWelcomeScreen
    {
        return new DiscordGuildWelcomeScreen($this->SendRequest("guilds/$guild_id/welcome-screen", DiscordRequest::HTTPRequestMethod_PATCH, [ "enabled" => $enabled, "welcome_channels" => $welcome_channels, "description" => $description ]));
    }

    /**
     * Returns a list of invite objects (with invite metadata) for the guild.
     * Requires the MANAGE_GUILD permission.
     */
    public function GetGuildInvites(string $guild_id) : array
    {
        $result = $this->SendRequest("guilds/$guild_id/invites", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordInvite($value);
        }

        return $result;
    }

    /**
     * Returns a list of integration objects for the guild.
     * Requires the MANAGE_GUILD permission.
     */
    public function GetGuildIntegrations(string $guild_id) : array
    {
        $result = $this->SendRequest("guilds/$guild_id/integrations", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordIntegration($value);
        }

        return $result;
    }

    /**
     * Delete the attached integration object for the guild.
     * Deletes any associated webhooks and kicks the associated bot if there is one. Requires the MANAGE_GUILD permission.
     * Returns a 204 empty response on success.
     * Fires a Guild Integrations Update Gateway event.
     */
    public function DeleteGuildIntegration(string $guild_id, string $integration_id) : void
    {
        $this->SendRequest("guilds/$guild_id/integrations/$integration_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Returns a list of voice region objects for the guild.
     * Unlike the similar /voice route, this returns VIP servers when the guild is VIP-enabled.
     */
    public function GetGuildVoiceRegions(string $guild_id) : array
    {
        $result = $this->SendRequest("guilds/$guild_id/regions", DiscordRequest::HTTPRequestMethod_GET);
        foreach($result as $index => $value)
        {
            $result[$index] = new VoiceRegion($value);
        }

        return $result;
    }

    /**
     * Begin a prune operation.
     * Requires the KICK_MEMBERS permission.
     * Returns an object with one 'pruned' key indicating the number of members that were removed in the prune operation.
     * For large guilds it's recommended to set the compute_prune_count option to false, forcing 'pruned' to null.
     * Fires multiple Guild Member Remove Gateway events.
     * By default, prune will not remove users with roles.
     * You can optionally include specific roles in your prune by providing the include_roles parameter.
     * Any inactive user that has a subset of the provided role(s) will be included in the prune and users with additional roles will not.
     * @param int $days number of days to prune (1-30).
     * @param bool $compute_prune_count whether 'pruned' is returned, discouraged for large guilds
     * @param array $include_roles role id(s) to include
     * @param null|string $reason reason for the prune (deprecated)
     */
    public function BeginGuildPrune(string $guild_id, int $days = 7, bool $compute_prune_count = true, array $include_roles = [], ?string $reason = null) : void
    {
        $this->SendRequest("guilds/$guild_id/prune", DiscordRequest::HTTPRequestMethod_POST, [ "days" => $days, "compute_prune_count" => $compute_prune_count, "include_roles" => $include_roles, "reason" => $reason ]);
    }

    /**
     * Returns an object with one 'pruned' key indicating the number of members that would be removed in a prune operation.
     * Requires the KICK_MEMBERS permission.
     * By default, prune will not remove users with roles.
     * You can optionally include specific roles in your prune by providing the include_roles parameter.
     * Any inactive user that has a subset of the provided role(s) will be counted in the prune and users with additional roles will not.
     */
    public function GetGuildPruneCount(string $guild_id) : int
    {
        return $this->SendRequest("guilds/$guild_id/prune", DiscordRequest::HTTPRequestMethod_GET)["pruned"];
    }

    /**
     * Delete a guild role.
     * Requires the MANAGE_ROLES permission.
     * Returns a 204 empty response on success.
     * Fires a Guild Role Delete Gateway event.
     */
    public function DeleteGuildRole(string $guild_id, string $role_id) : void
    {
        $this->SendRequest("guilds/$guild_id/roles/$role_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Modify a guild role.
     * Requires the MANAGE_ROLES permission.
     * Returns the updated role on success.
     * Fires a Guild Role Update Gateway event.
     * @return DiscordRole updated role object on success.
     */
    public function ModifyGuildRole(string $guild_id, string $role_id, ModifyDiscordRole $modify) : DiscordRole
    {
        return new DiscordRole($this->SendRequest("guilds/$guild_id/roles/$role_id", DiscordRequest::HTTPRequestMethod_PATCH, $modify));
    }

    /**
     * Modify the positions of a set of role objects for the guild.
     * Requires the MANAGE_ROLES permission.
     * Returns a list of all of the guild's role objects on success.
     * Fires multiple Guild Role Update Gateway events.
     */
    public function ModifyGuildRolePositions(string $guild_id, string $role_id, ?int $position) : array
    {
        $result = $this->SendRequest("guilds/$guild_id/roles", DiscordRequest::HTTPRequestMethod_PATCH, [ "role_id" => $role_id, "position" => $position ]);
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordRole($value);
        }

        return $result;
    }

    /**
     * Create a new role for the guild.
     * Requires the MANAGE_ROLES permission.
     * Returns the new role object on success.
     * Fires a Guild Role Create Gateway event.
     * All JSON params are optional.
     */
    public function CreateGuildRole(string $guild_id, CreateDiscordRole $create) : DiscordRole
    {
        return new DiscordRole($this->SendRequest("guilds/$guild_id/roles", DiscordRequest::HTTPRequestMethod_POST, $create));
    }

    /**
     * Create a new channel object for the guild.
     * Requires the MANAGE_CHANNELS permission.
     * If setting permission overwrites, only permissions your bot has in the guild can be allowed/denied.
     * Setting MANAGE_ROLES permission in channels is only possible for guild administrators.
     * Returns the new channel object on success.
     * Fires a Channel Create Gateway event.
     */
    public function CreateGuildChannel(string $guild_id, CreateDiscordChannel $create) : DiscordChannel
    {
        return new DiscordChannel($this->SendRequest("guilds/$guild_id/channels", DiscordRequest::HTTPRequestMethod_POST, $create));
    }

    /**
     * Modify the positions of a set of channel objects for the guild.
     * Requires MANAGE_CHANNELS permission.
     * Returns a 204 empty response on success.
     * Fires multiple Channel Update Gateway events.
     * @param null|string $channel_id channel id
     * @param null|int $position sorting position of the channel
     * @param null|bool $lock_permissions syncs the permission overwrites with the new parent, if moving to a new category
     * @param null|string $parent_id the new parent ID for the channel that is moved
     */
    public function ModifyGuildChannelPositions(string $guild_id, string $channel_id, ?int $position = null, ?bool $lock_permissions = null, ?string $parent_id) : void
    {
        $this->SendRequest("guilds/$guild_id/channels", DiscordRequest::HTTPRequestMethod_PATCH, [ "channel_id" => $channel_id, "position"=> $position, "lock_permissions"=> $lock_permissions, "parent_id"=> $parent_id ]);
    }

    /**
     * Adds a user to the guild, provided you have a valid oauth2 access token for the user with the guilds.join scope.
     * Returns a 201 Created with the guild member as the body, or 204 No Content if the user is already a member of the guild.
     * Fires a Guild Member Add Gateway event.
     * For guilds with Membership Screening enabled, this endpoint will default to adding new members as pending in the guild member object.
     * Members that are pending will have to complete membership screening before they become full members that can talk.
     * @return null|DiscordGuildMember null if already member, otherwise DiscordGuildMember object.
     */
    public function AddGuildMember(string $guild_id, string $user_id, string $access_token, ModifyDiscordGuildMember $modify) : mixed
    {
        $result = $this->SendRequest("guilds/$guild_id/members/$user_id", DiscordRequest::HTTPRequestMethod_PUT, [ "access_token" => $access_token, $modify ]);

        //No content if already member
        if(strlen(json_encode($result)) < 40)
            return null;
        
        return new DiscordGuildMember($result);
    }

    /**
     * Send request to the Discord API.
     * @param string $route API route.
     * @param string $method HTTP Request method.
     * @param mixed $json Any value that will be passed as json body.
     */
    private function SendRequest(string $route, string $method, mixed $json = null) : mixed
    {
        $request = new DiscordRequest($route, $method);
        $request->SetBot($this);
        if(isset($json))
            $request->SetJsonBody($json);

        try {
            return $request->Send();
        } catch (DiscordInvalidResponseException $exception) {
            echo $exception->getMessage();
            return array();
        }
    }
}