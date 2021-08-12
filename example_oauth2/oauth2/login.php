<?php

require_once __DIR__ . "/../include/config.php";
require_once __DIR__ . "/../include/functions.php";

require_once __DIR__ . "/../../Discord/Discord.php";
session_start();

use Nexd\Discord\DiscordOAuth;

$oauth = new DiscordOAuth($DISCORD_APP["Client"], $DISCORD_APP["Secret"], $DISCORD_APP["Redirect"]);
$_SESSION["discord"]["user"] = $oauth->GetUser();
$_SESSION["discord"]["guilds"] = $oauth->GetGuilds();
$_SESSION["discord"]["connections"] = $oauth->GetConnections();

RedirectToPage("/example_oauth2/index.php");
?>