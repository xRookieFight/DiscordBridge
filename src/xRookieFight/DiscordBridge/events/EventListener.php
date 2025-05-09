<?php

namespace xRookieFight\DiscordBridge\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use xRookieFight\DiscordBridge\Main;

class EventListener implements Listener
{

    private Config $config;

    public function __construct()
    {
        Main::$logger->debug("Registered listener");
        $this->config = Main::$instance->getConfig();
    }

    function onJoin(PlayerJoinEvent $event) : void
    {
        $message = str_replace("{player}", $event->getPlayer()->getName(), $this->config->getNested("messages.join"));
        Main::$bot->sendMessage($message);
    }

    function onQuit(PlayerQuitEvent $event) : void
    {
        $message = str_replace("{player}", $event->getPlayer()->getName(), $this->config->getNested("messages.quit"));
        Main::$bot->sendMessage($message);
    }

    function onChat(PlayerChatEvent $event) : void
    {
        $message = str_replace(["{player}", "{message}"], [$event->getPlayer()->getName(), $event->getMessage()], $this->config->getNested("messages.chat"));
        Main::$bot->sendMessage($message);
    }
}