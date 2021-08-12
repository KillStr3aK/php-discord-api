<?php

namespace Nexd\Discord;

use Nexd\Discord\Exceptions\DiscordEmbedLimitException;

class DiscordWebhook
{
    private const MAX_EMBEDS = 10;

    private ?string $username = null;
    private ?string $avatarurl = null;
    private ?bool $tts = null;
    private ?array $embeds = [];

    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function WithUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function WithAvatar(string $avatarurl): self
    {
        $this->avatarurl = $avatarurl;

        return $this;
    }

    public function SetTTS(bool $tts): self
    {
        $this->tts = $tts;

        return $this;
    }

    public function AddEmbed(DiscordEmbed $embed): self
    {
        if (count($this->embeds) < self::MAX_EMBEDS) {
            array_push($this->embeds, $embed);

            return $this;
        }

        throw new DiscordEmbedLimitException('DiscordWebhook cannot have more than '.self::MAX_EMBEDS.' embeds.');
    }

    public function Send(): void
    {
        $request = new DiscordRequest("webhooks/".$this->url, DiscordRequest::HTTPRequestMethod_POST);
        $request->SetJsonBody($this);
        $request->Send();
    }
}
