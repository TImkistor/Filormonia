<?php
session_start();
session_unset();
session_destroy();

$href = isset($_GET['href']) ? $_GET['href'] : '/';
header('Location: '.$href);