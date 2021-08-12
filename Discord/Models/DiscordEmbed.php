<?php
namespace Nexd\Discord;

use Nexd\Discord\Exceptions\DiscordEmbedFieldLimitException;

require_once __DIR__ . "/DiscordEmbedAuthor.php";
require_once __DIR__ . "/DiscordEmbedFooter.php";
require_once __DIR__ . "/DiscordEmbedImage.php";
require_once __DIR__ . "/DiscordEmbedVideo.php";
require_once __DIR__ . "/DiscordEmbedThumbnail.php";
require_once __DIR__ . "/DiscordEmbedProvider.php";
require_once __DIR__ . "/DiscordEmbedField.php";

class DiscordEmbedBuilder
{
    private const MAX_EMBED_FIELDS = 25;

    private ?DiscordEmbedAuthor $author = null;
    private ?DiscordEmbedFooter $footer = null;
    private ?DiscordEmbedImage $image = null;
    private ?DiscordEmbedVideo $video = null;
    private ?DiscordEmbedThumbnail $thumbnail = null;
    private ?DiscordEmbedProvider $provider = null;
    private array $fields = [];

    private ?string $title = null;
    private ?\DateTimeInterface $timestamp = null;
    private ?string $type = null;
    private ?string $description = null;
    private ?string $url = null;
    private ?int $color = null;

    public ?DiscordEmbed $embed = null;

    public function __construct(?DiscordEmbed $embed = null)
    {
        $this->embed = $embed;
    }

    public function WithAuthor(?string $name = null, ?string $url = null, ?string $icon_url = null) : self
    {
        $this->author = new DiscordEmbedAuthor([ "name" => $name, "url" => $url, "icon_url" => $icon_url ]);
        return $this;
    }

    public function WithFooter(?string $text = null, ?string $icon_url = null) : self
    {
        $this->footer = new DiscordEmbedFooter([ "text" => $text, "icon_url" => $icon_url ]);
        return $this;
    }

    public function WithImage(?string $url = null, int $height, int $width) : self
    {
        $this->image = new DiscordEmbedImage([ "url" => $url, "height" => $height, "width" => $width ]);
        return $this;
    }

    public function WithThumbnail(?string $url = null, int $height, int $width) : self
    {
        $this->image = new DiscordEmbedThumbnail([ "url" => $url, "height" => $height, "width" => $width ]);
        return $this;
    }

    public function WithVideo(?string $url = null, int $height, int $width) : self
    {
        $this->image = new DiscordEmbedVideo([ "url" => $url, "height" => $height, "width" => $width ]);
        return $this;
    }

    public function WithProvider(?string $name, ?string $url) : self
    {
        $this->provider = new DiscordEmbedProvider([ "name" => $name, "url" => $url ]);
        return $this;
    }

    public function AddField(?string $name, ?string $field, bool $inline = false) : self
    {
        if(count($this->fields) < self::MAX_EMBED_FIELDS)
        {
            array_push($this->fields, new DiscordEmbedField([ "name" => $name, "field" => $field, "inline" => $inline ]));
            return $this;
        }

        throw new DiscordEmbedFieldLimitException("DiscordEmbed cannot have more than " . self::MAX_EMBED_FIELDS . " fields.");
    }

    public function WithColor(string $color) : self
    {
        $this->color = hexdec($color);
        return $this;
    }

    public function WithTitle(string $title) : self
    {
        $this->title = $title;
        return $this;
    }

    public function WithDescription(string $description) : self
    {
        $this->description = $description;
        return $this;
    }

    public function WithUrl(string $url) : self
    {
        $this->url = $url;
        return $this;
    }

    public function SetType(string $type) : self
    {
        $this->type = $type;
        return $this;
    }

    public function WithTimestamp(\DateTimeInterface $timestamp) : self
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function Build() : DiscordEmbed
    {
        return new DiscordEmbed([
            "author" => $this->author,
            "footer" => $this->footer,
            "image" => $this->image,
            "video" => $this->video,
            "thumbnail" => $this->thumbnail,
            "provider" => $this->provider,
            "fields" => $this->fields,
            "title" => $this->title,
            "type" => $this->type,
            "description"=> $this->description,
            "url" => $this->url,
            "color" => $this->color,
            "timestamp" => $this->timestamp
        ]);
    }
}

class DiscordEmbed extends DiscordObjectParser implements \IteratorAggregate
{
    private const InitializeProperties =
	[	/*Property Name */			/* to */
		"author"	        => "DiscordEmbedAuthor",
		"footer"            => "DiscordEmbedFooter",
        "image"             => "DiscordEmbedImage",
        "video"             => "DiscordEmbedVideo",
        "thumbnail"         => "DiscordEmbedThumbnail",
        "provider"          => "DiscordEmbedProvider",
        "fields"            => "DiscordEmbedField[]",
        "timestamp"         => "DateTimeInterface"
	];

    public function FromData(array $properties = array())
    {
        parent::__construct($properties, self::InitializeProperties);
    }

    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this);
    }

    /**
     * title of embed
     */
    public ?string $title = null;

    /**
     * 	type of embed (always "rich" for webhook embeds)
     */
    public ?string $type = null;

    /**
     * description of embed
     */
    public ?string $description = null;

    /**
     * url of embed
     */
    public ?string $url = null;

    /**
     * timestamp of embed content
     */
    public ?\DateTimeInterface $timestamp = null;

    /**
     * 	color code of the embed
     */
    public ?int $color = null;

    /**
     * 	author information
     */
    public $author = null;

    /**
     * 	footer information
     */
    public $footer = null;
    
    /**
     * 	image information
     */
    public $image = null;

    /**
     * video information
     */
    public $video = null;

    /**
     * 	thumbnail information
     */
    public $thumbnail = null;

    /**
     * 	provider information
     */
    public $provider = null;

    /**
     * fields information
     */
    public ?array $fields = null;
}
?>