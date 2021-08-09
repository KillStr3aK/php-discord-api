<?php
namespace Nexd\Discord;

class DiscordEmbedVideo extends DiscordObjectParser
{
	/**
	 * source url of video
	 */
    public ?string $url = null;

	/**
	 * a proxied url of the video
	 */
    public ?string $proxy_url = null;

	/**
	 * height of video
	 */
	public ?int $height = null;

	/**
	 * 	width of video
	 */
	public ?int $width = null;
}
?>