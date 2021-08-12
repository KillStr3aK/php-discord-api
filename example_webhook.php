<?php

require __DIR__."/Discord/Discord.php";
use Nexd\Discord\DiscordWebhook;
use Nexd\Discord\DiscordEmbedBuilder;

$embed = (new DiscordEmbedBuilder())
    ->WithAuthor("PHP Webhook", "https://github.com/KillStr3aK/php-discord-api")
    ->WithDescription("Description")
    ->WithFooter("Footer `php`")
    ->WithColor("#FF0000")
    ->AddField("Name", "Field", true);

$hook = (new DiscordWebhook("875397623543128114/cvkB_N0EB1oLAjzbGbL--YNqV6ubl88hzYrE6jYkpcbBONR5I46uN37vZ_MV0_8mZ3Wn"))
    ->WithUsername("PHP Webhook")
    ->AddEmbed($embed->Build());

$hook->Send();
?>