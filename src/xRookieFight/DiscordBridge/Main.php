<?php

namespace xRookieFight\DiscordBridge;

use pocketmine\plugin\PluginBase;
use xRookieFight\DiscordBridge\client\BotClient;
use xRookieFight\DiscordBridge\events\EventListener;

class Main extends PluginBase
{

    public static self $instance;
    public static \AttachableLogger $logger;
    public static BotClient $bot;

    function onEnable() : void
    {
        $this->saveDefaultConfig();
        self::$instance = $this;
        self::$logger = $this->getLogger();
        $this->getLogger()->debug("Starting plugin");
        self::$bot = new BotClient($this->getConfig()->getNested("discord.token"), $this->getConfig()->getNested("discord.guild_id"), $this->getConfig()->getNested("discord.channel_id"));
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }
}