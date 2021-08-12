<?php

namespace Nexd\Discord;

use Nexd\Discord\Exceptions\DiscordEmbedLimitException;

class DiscordWebhook
{
    private const MAX_EMBEDS = 10;

    private ?string $username;
    private ?string $avatar_url;
    private ?string $content;
    private ?bool $tts;
    private ?array $embeds = [];

    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function WithContent(string $content) : self
    {
        $this->content = $content;

        return $this;
    }

    public function WithUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function WithAvatar(string $avatar_url): self
    {
        $this->avatar_url = $avatar_url;

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
        $request = new DiscordRequest('webhooks/'.$this->url, DiscordRequest::HTTPRequestMethod_POST);
        $request->SetJsonBody([
            "content" => $this->content,
            "username" => $this->username,
            "avatar_url" => $this->avatar_url,
            "tts" => $this->tts,
            "embeds" => $this->embeds
        ]);

        $request->Send();
    }
}