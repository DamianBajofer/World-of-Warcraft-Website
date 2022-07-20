<?php
session_destroy();
header("Location: ".Config::$SiteData["Domain"]);
?>