<?php
require __DIR__ . "/Discord/Discord.php";
use Nexd\Discord\DiscordBot;

$TOKEN = "";
$bot = new DiscordBot($TOKEN);

$guildid = "801193764487561247";
$guild = $bot->GetGuild($guildid);
var_dump($guild);
?>