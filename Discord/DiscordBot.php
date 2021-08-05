<?php
namespace Nexd\Discord;

use Nexd\Discord\DiscordRequest;
use Nexd\Discord\DiscordGuild;
use Nexd\Discord\DiscordGuildMember;
use Nexd\Discord\DiscordGuildPreview;
use Nexd\Discord\ModifyDiscordGuild;
use Nexd\Discord\DiscordUser;
use Nexd\Discord\DiscordChannel;

use Nexd\Discord\Exceptions\DiscordInvalidResponseException;

class DiscordBot
{
    public function __construct(public ?string $token) { }

    /**
     * Returns the guild object for the given id. If with_counts is set to true, this endpoint will also return approximate_member_count and approximate_presence_count for the guild.
     */
    public function GetGuild(string $id) : DiscordGuild
    {
        return new DiscordGuild($this->SendRequest("guilds/$id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns the guild preview object for the given id. If the user is not in the guild, then the guild must be lurkable (it must be Discoverable or have a live public stage).
     */
    public function GetGuildPreview(string $id) : DiscordGuildPreview
    {
        return new DiscordGuildPreview($this->SendRequest("guilds/$id/preview", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * !! NOT WORKS => Bad Request !!
     * Modify a guild's settings. Requires the MANAGE_GUILD permission. Returns the updated guild object on success. Fires a Guild Update Gateway event.
     */
    public function ModifyGuild(string $id, ModifyDiscordGuild $modify) : DiscordGuild
    {
        return new DiscordGuild($this->SendRequest("guilds/$id", DiscordRequest::HTTPRequestMethod_PATCH, $modify));
    }

    /**
     * Delete a guild permanently. User must be owner. Returns 204 No Content on success. Fires a Guild Delete Gateway event.
     */
    public function DeleteGuild(string $id)
    {
        $this->SendRequest("guilds/$id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Returns a list of guild channel objects. Does not include threads.
     */
    public function GetGuildChannels(string $id) : array
    {
        return array($this->SendRequest("guilds/$id/channels", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns all active threads in the guild, including public and private threads. Threads are ordered by their id, in descending order.
     */
    public function GetActiveThreads(string $id): array
    {
        return array($this->SendRequest("guilds/$id/threads/active", DiscordRequest::HTTPRequestMethod_GET));
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

        return array($this->SendRequest($route, DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns a list of guild member objects whose username or nickname starts with a provided string.
     */
    public function SearchGuildMember(string $id, string $query, int $limit = 1) : array
    {
        return array($this->SendRequest("guilds/$id/members/search?query=$query&limit=$limit", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * !! NOT WORKS => Bad Request !!
     * Modify attributes of a guild member. Returns a 200 OK with the guild member as the body. Fires a Guild Member Update Gateway event. If the channel_id is set to null, this will force the target user to be disconnected from voice.
     */
    public function ModifyGuildMember(string $guild_id, string $user_id, ModifyDiscordGuildMember $modify) : DiscordGuildMember
    {
        return new DiscordGuildMember($this->SendRequest("guilds/$guild_id/members/$user_id", DiscordRequest::HTTPRequestMethod_PATCH, $modify));
    }

    /**
     * !! NOT WORKS => Bad Request !!
     * Modifies the nickname of the current user in a guild. Returns a 200 with the nickname on success. Fires a Guild Member Update Gateway event.
     * @param ?string $nick 	value to set users nickname to, requires CHANGE_NICKNAME permission
     */
    public function ModifyCurrentUserNick(string $id, ?string $nick) : string
    {
        return $this->SendRequest("guilds/$id/members/@me/nick", DiscordRequest::HTTPRequestMethod_PATCH, [ "nick" => $nick ]);
    }

    /**
     * Adds a role to a guild member. Requires the MANAGE_ROLES permission. Returns a 204 empty response on success. Fires a Guild Member Update Gateway event.
     */
    public function AddMemberRole(string $guild_id, string $user_id, string $role_id) : void
    {
        $this->SendRequest("guilds/$guild_id/members/$user_id/roles/$role_id", DiscordRequest::HTTPRequestMethod_PUT);
    }

    /**
     * Removes a role from a guild member. Requires the MANAGE_ROLES permission. Returns a 204 empty response on success. Fires a Guild Member Update Gateway event.
     */
    public function RemoveMemberRole(string $guild_id, string $user_id, string $role_id) : void
    {
        $this->SendRequest("guilds/$guild_id/members/$user_id/roles/$role_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Remove a member from a guild. Requires KICK_MEMBERS permission. Returns a 204 empty response on success. Fires a Guild Member Remove Gateway event.
     */
    public function KickMember(string $guild_id, string $user_id) : void
    {
        $this->SendRequest("guilds/$guild_id/members/$user_id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * !! NOT WORKS => Bad Request !!
     * Create a guild ban, and optionally delete previous messages sent by the banned user. Requires the BAN_MEMBERS permission. Returns a 204 empty response on success. Fires a Guild Ban Add Gateway event.
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
     * Returns a ban object for the given user or a 404 not found if the ban cannot be found. Requires the BAN_MEMBERS permission.
     */
    public function GetGuildBan(string $guild_id, string $user_id) : BanObject
    {
        return new BanObject($this->SendRequest("guilds/$guild_id/bans/$user_id", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns a list of ban objects for the users banned from this guild. Requires the BAN_MEMBERS permission.
     */
    public function GetGuildBans(string $guild_id) : array
    {
        return array($this->SendRequest("guilds/$guild_id/bans", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns a list of role objects for the guild.
     */
    public function GetGuildRoles(string $id) : array
    {
        return array($this->SendRequest("guilds/$id/roles", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Returns the user object of the requester's account. For OAuth2, this requires the identify scope, which will return the object without an email, and optionally the email scope, which returns the object with an email.
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
     * Modify the requester's user account settings. Returns a user object on success.
     */
    public function ModifyCurrentUser(string $username, mixed $avatar = null) : DiscordUser
    {
        $json = [ "username" => $username ];
        if(isset($avatar))
            $json["avatar"] = $avatar;

        return new DiscordUser($this->SendRequest("users/@me", DiscordRequest::HTTPRequestMethod_PATCH, $json));
    }

    /**
     * Returns a list of partial guild objects the current user is a member of. Requires the guilds OAuth2 scope.
     */
    public function GetCurrentUserGuilds() : array
    {
        return array($this->SendRequest("users/@me/guilds", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Leave a guild. Returns a 204 empty response on success.
     */
    public function LeaveGuild(string $id)
    {
        $this->SendRequest("users/@me/guilds/$id", DiscordRequest::HTTPRequestMethod_DELETE);
    }

    /**
     * Create a new DM channel with a user. Returns a DM channel object.
     * @param string $id the recipient to open a DM channel with
     */
    public function CreateDM(string $id) : DiscordChannel
    {
        return new DiscordChannel($this->SendRequest("users/@me/channels", DiscordRequest::HTTPRequestMethod_POST, [ "recipient_id" => $id ]));
    }

    /**
     * Create a new group DM channel with multiple users. Returns a DM channel object. This endpoint was intended to be used with the now-deprecated GameBridge SDK. DMs created with this endpoint will not be shown in the Discord client
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
        return array($this->SendRequest("users/@me/connections", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * Send request to the Discord API.
     * @param string $route API route
     * @param string $method HTTP Request method
     * @param mixed $json Any value that will be passed as json body
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