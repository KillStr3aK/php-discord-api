<?php

require_once __DIR__.'/../include/config.php';
require_once __DIR__.'/../include/functions.php';
require_once __DIR__.'/../../Discord/DiscordOAuth.php';

use Nexd\Discord\DiscordOAuth;

session_start();

if (!isset($_GET['unlink'])) {
    RedirectToPage(DiscordOAuth::GenerateOAuthUrl($DISCORD_APP['Client'], $DISCORD_APP['Redirect'], $DISCORD_APP['Scopes']));
} else {
    unset($_SESSION['discord']);
    RedirectToPage('/example_oauth2/index.php');
}
