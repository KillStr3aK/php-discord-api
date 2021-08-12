<?php

function RedirectToPage(string $url) : void
{
    echo "<script>window.location.replace('" . $url . "')</script>";
}
?>