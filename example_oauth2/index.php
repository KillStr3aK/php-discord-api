<?php

require_once __DIR__.'/../Discord/Discord.php';

session_start();
$loggedIn = isset($_SESSION['discord']) && isset($_SESSION['discord']['user']->id);

if (!$loggedIn) {
    echo "<a href = 'oauth2/discord.php'>Link discord</a>";
} else {
    echo "<a href = 'oauth2/discord.php?unlink'>Unlink discord</a><br>";
    echo '<pre>';
    var_dump($_SESSION['discord']);
    echo '</pre>';
}
