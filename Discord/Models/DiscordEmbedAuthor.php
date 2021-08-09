<?php
namespace Nexd\Discord;

class DiscordEmbedAuthor extends DiscordObjectParser
{
	/**
	 * name of author
	 */
    public ?string $name = null;

	/**
	 * url of author
	 */
    public ?string $url = null;

	/**
	 * url of author icon (only supports http(s) and attachments)
	 */
    public ?string $icon_url = null;

	/**
	 * a proxied url of author icon
	 */
	public ?string $proxy_icon_url = null;
}
?>