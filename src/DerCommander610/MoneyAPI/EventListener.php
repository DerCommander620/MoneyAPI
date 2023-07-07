<?php
namespace DerCommander610\MoneyAPI;

use DerCommander610\MoneyAPI\API\MoneyAPI;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class EventListener implements Listener{

    public function onJoin(PlayerJoinEvent $event){
        if(!$event->getPlayer()->hasPlayedBefore()){
            MoneyAPI::defaultMoney($event->getPlayer());
            Server::getInstance()->broadcastMessage(TextFormat::GREEN . $event->getPlayer()->getName() . " Joined for the first Time!");
        }
    }
}