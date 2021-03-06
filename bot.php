<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include_once 'madeline.php';
include_once 'functions.php';
include 'EventHandler.php';

function shutdown($lock)
{
    flock($lock, LOCK_UN);
    fclose($lock);
}

$lock = lockFile();

register_shutdown_function('shutdown', $lock);

$MadelineProto = new \danog\MadelineProto\API('session.madeline', ['logger' => ['logger_level' => 5]]);

$started = time();

$bot = $MadelineProto->get_self()['bot'];

$MadelineProto->start();
$MadelineProto->setEventHandler('\EventHandler');
$MadelineProto->loop();
