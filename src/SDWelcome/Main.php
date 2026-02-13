<?php

namespace SDWelcome;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{

    public function onEnable(): void
    {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        $config = $this->getConfig();
        $prefix = $config->get("prefix", "");
        $message = $config->get("welcome-message", "§aWelcome to the server, {player}!");

        $message = str_replace(["{player}", "{prefix}"], [$player->getName(), $prefix], $message);
        $player->sendMessage($prefix . $message);
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();
        $config = $this->getConfig();
        $prefix = $config->get("prefix", "");
        $message = $config->get("leave-message", "§c{player} has left the server.");

        $message = str_replace(["{player}", "{prefix}"], [$player->getName(), $prefix], $message);
        $this->getServer()->broadcastMessage($prefix . $message);
    }
}