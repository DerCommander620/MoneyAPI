<?php
namespace DerCommander610\MoneyAPI;

use DerCommander610\MoneyAPI\API\MoneyAPI;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{
    use SingletonTrait;
    const Content1 = "§aSet the Value of a Player";

    public Config $money;

    public function onEnable(): void{
        self::setInstance($this);
        $money = new Config($this->getDataFolder() . "money.json", Config::JSON);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch($command->getName()){
            case "payall":
                if(!isset($args[0])){
                    $sender->sendMessage("§cPlease provide the amount you want to pay all!");
                }else{
                    $amount = $args([0]);
                    MoneyAPI::payall($amount);
                    $sender->sendMessage("§aYou Paid §e" . $amount . "§a$ to every player.");
                    Server::getInstance()->broadcastMessage("§a" . $sender->getName() . " Paid every Player §e" . $amount . "$" . "§a!");
                }
                break;
            case "pay":
                if(!isset($args[0])){
                    $sender->sendMessage("§cPlease provide a Playername!");
                }
                if(!isset($args[1])){
                    $sender->sendMessage("§cPlease provide an Amount of money!");
                }else{
                    $player = Server::getInstance()->getPlayerExact($args([0]));
                    $amount = $args([1]);
                    MoneyAPI::pay($player, $amount);
                    $player->sendMessage("§e" . $sender->getName() . " §apaid you §e" . $amount . "$" . "§a!");
                    $sender->sendMessage("§aYou paid " . TextFormat::BLUE . $player->getName() . " §e" . $amount . "$" . "§a!");
                }
                break;
            case "seemoney":
                if(isset($args[0])){
                    $player = Server::getInstance()->getPlayerExact($args([0]));
                    $amount = MoneyAPI::getMoney($player);
                    $sender->sendMessage(TextFormat::YELLOW . "Player " . $player->getName() . " has the amount of " . TextFormat::GREEN . $amount."$");
                }else{
                    $amount = MoneyAPI::getMoney($sender->getName());
                    $sender->sendMessage("§aYour Money: " . $amount);
                }
            case "gettotal":    
                $amount = MoneyAPI::getTotalMoneyOfOnlinePlayers();
                $sender->sendMessage("§aTotal Money of Online Players: §e" . $amount);
                break;                 
            case "resetaccount":
                if(!isset($args[0])){
                    $sender->sendMessage("§cPlease Provide A Username you want to reset the Money Account!");
                }else{
                    $username = Server::getInstance()->getPlayerExact($args([0]));
                    MoneyAPI::reset_account($username);
                    $sender->sendMessage(TextFormat::GREEN . $username . "´s account has been successfully reset!");
                    $username->sendMessage("§cYour account was been reset by " . $sender->getName() . " !");
                }    
                break;
            case "setmoney":
                $form = new CustomForm(function(Player $sander, int $data = null){
                    if($data === null)return false;
                    if($data[0] === null){
                        $sander->sendMessage("§cPlease enter a PlayerName!");
                    }
                    if($data[1] === null){
                        $sander->sendMessage("§cPlease provide the amount you want to set!")
                    }else{
                        if(is_string($data[0])){
                            $player = Server::getInstance()->getPlayerExact($data[0]);
                            $amount = $data[1];
                        }
                    }
                });
                $form->setTitle("§aSet Money");
                $form->addInput("§aPlease provide a Playername !");
                $form->addSlider("§aMoney: ", 1, 1000000000, 5);
                $form->sendToPlayer();
                break;  
            case "removemoney":
                if(!isset($args[0])){
                    $sender->sendMessage("§cPlease provide a PlayerName");
                }
                if(!isset($args[1])){
                    $sender->sendMessage("§cPlease Enter An Amount of Money You Want To Remove From the player!");
                }
                $player = Server::getInstance()->getPlayerExact($args([0]));
                $amount = $args([1]);
                if (!$player) {
                    $sender->sendMessage("§cThe player you entered does not exist or is not online.");
                }else{
                    $player = Server::getInstance()->getPlayerExact($args([0]));
                    $amount = $args([1]);
                    MoneyAPI::removeMoney($player ,$amount);
                    $sender->sendMessage("§eYou have removed §6". $amount. "$ §r§eFrom the player: §6" . $player); 
                }
                break;  
            case "removemoney":
                if(!isset($args[0])){
                    $sender->sendMessage("§cPlease provide a PlayerName");
                }
                if(!isset($args[1])){
                    $sender->sendMessage("§cPlease Enter An Amount of Money You Want To Remove From the player!");
                }
                $player = Server::getInstance()->getPlayerExact($args([0]));
                $amount = $args([1]);
                if (!$player) {
                    $sender->sendMessage("§cThe player you entered does not exist or is not online.");
                }else{
                    $player = Server::getInstance()->getPlayerExact($args([0]));
                    $amount = $args([1]);
                    MoneyAPI::removeMoney($player ,$amount);
                    $sender->sendMessage("§eYou have added §6". $amount. "$ §r§eto the player: §6" . $player); 
                    }
                    break;            
        }
    return true;    
    }
}
