<?php
namespace Nexd\Discord;

use Nexd\Discord\DiscordRequest;
use Nexd\Discord\DiscordUser;

class DiscordOAuth
{
    private string $access_token;
    private static string $state;

    public function __construct(public string $client, public string $secret, public string $redirect)
    {
        $request = new DiscordRequest("oauth2/token", DiscordRequest::HTTPRequestMethod_POST, "application/x-www-form-urlencoded");
        $request->SetPostFields(array(
            "client_id" => $this->client,
            "client_secret" => $this->secret,
            "redirect_uri" => $this->redirect,
            "grant_type" => "authorization_code",
            "code" => $_GET['code']
        ));

        $this->access_token = $request->Send()["access_token"];
    }

    /**
     * method to generate oAuth2 URL for logging in
     */
    public static function GenerateOAuthUrl(string $client, string $redirect, string $scope)
    {
        self::GenerateState();
        return 'https://discordapp.com/oauth2/authorize?response_type=code&client_id=' . $client . '&redirect_uri=' . $redirect . '&scope=' . $scope . "&state=" . self::$state;
    }
    
    /**
     * method to generate a random string to be used as state
     */
    private static function GenerateState() : string
    {
        self::$state = bin2hex(openssl_random_pseudo_bytes(12));
        return self::$state;
    }

    private function SendRequest(string $route, string $method) : mixed
    {
        $request = new DiscordRequest($route, $method, "application/x-www-form-urlencoded");
        $request->SetHeader('Authorization: Bearer ' . $this->access_token);
        return $request->Send();
    }

    /**
     * method to get user information | (identify scope)
     */
    public function GetUser() : DiscordUser
    {
        return new DiscordUser($this->SendRequest("users/@me", DiscordRequest::HTTPRequestMethod_GET));
    }

    /**
     * method to get user guilds | (guilds scope)
     */
    public function GetGuilds() : array
    {
        $result = array($this->SendRequest("users/@me/guilds", DiscordRequest::HTTPRequestMethod_GET));
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordGuild($value);
        }

        return $result;
    }

    /**
     * method to get user connections | (connections scope)
     */
    public function GetConnections() : array
    {
        $result = array($this->SendRequest("users/@me/connections", DiscordRequest::HTTPRequestMethod_GET));
        foreach($result as $index => $value)
        {
            $result[$index] = new DiscordConnection($value);
        }

        return $result;
    }
}
?>