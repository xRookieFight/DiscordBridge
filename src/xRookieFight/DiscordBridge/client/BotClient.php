<?php

namespace xRookieFight\DiscordBridge\client;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
use pocketmine\scheduler\AsyncTask;
use xRookieFight\DiscordBridge\Main;

class BotClient {

    public function __construct(public string $token, public string $guildId, public string $channelId)
    {
        Main::$logger->debug("Starting client");

        Main::$instance->getServer()->getAsyncPool()->submitTask(new class($token, $channelId) extends AsyncTask {

            public function __construct(public string $token, public string $channelId){}

            public function onRun(): void
            {
                require __DIR__ . '/../../../../vendor/autoload.php';

                $discord = new Discord([
                    'token' => $this->token,
                    'loadAllMembers' => false
                ]);

                $discord->on('ready', function (Discord $discord) {
                    Main::$logger->debug("Client is ready for $discord->username!");

                    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
                        if ($message->content === "!online") {

                            $count = count(Main::$instance->getServer()->getOnlinePlayers());
                            $list = "There is $count players online!\n";
                            foreach (Main::$instance->getServer()->getOnlinePlayers() as $player) $list .= $player->getName() . "\n";

                            $message->reply($list);
                            return;
                        }

                        if ($message->channel->id === $this->channelId) {
                            Main::$instance->getServer()->broadcastMessage($message->author->displayname . " -> ".$message->content);
                        }
                    });
                });

                $discord->run();
            }
        });
    }

    public function sendMessage(string $content): void {
        $url = "https://discord.com/api/v10/channels/{$this->channelId}/messages";
        $token = Main::$instance->getConfig()->getNested("discord.bot_token");

        $headers = [
            "Authorization: Bot $token",
            "Content-Type: application/json"
        ];

        $postData = json_encode(["content" => $content]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}