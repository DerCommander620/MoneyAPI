<?php
namespace DerCommander610\MoneyAPI\API;

use JsonException;
use DerCommander610\MoneyAPI\Main;
use pocketmine\player\Player;
use pocketmine\Server;

class MoneyAPI{

    public static function minimum_money(string $playername){
        if(Main::getInstance()->money->getNested("money.",Main::getInstance()->money->get($playername,0))){
        }
    }
    /**
     * function getMoney
     * @param string $playerName
     * @return mixed
     */
    public static function getMoney(string $playerName): mixed{
        return Main::getInstance()->money->getNested("money." . $playerName, 0);
    }

    /**
     * function addMoney
     * @param string $playerName
     * @param int $amount
     * @return void
     * @throws JsonException
     */
    public static function addMoney(string $playerName, int $amount): void{
        Main::getInstance()->money->set("money.",Main::getInstance()->money->get($playerName,1), +$amount);
        Main::getInstance()->money->save();
    }

    /**
     * function removeMoney
     * @param string $playerName
     * @param int $amount
     * @return void
     * @throws JsonException
     */
    public static function removeMoney(string $playerName, int $amount): void{
        Main::getInstance()->money->set("money.",Main::getInstance()->money->get($playerName,1), -$amount);
        Main::getInstance()->money->save();
    }
    
    public static function if(){
        function money(int $amount, string $player){
            function player(string $player){
                function islessthan(int $amount, int $maximumset){
                    function(string $playerName){
                        if($amount($playerName) < $maximumset){
                            return false;
                        }   
                    }
                }       
            }
            function minimum(Player $player){
                if(MoneyAPI::minimum_money($player) > MoneyAPI::getMoney($player)){
                    function(string $playerName){
                        self::setMoney($playerName, 0);
                        Main::getInstance()->money->save();
                    }
                ;
            return true;        
            }}
        }
    }

    public static function setMoney(int $amount, string $playerName){
        Main::getInstance()->money->set("money.",Main::getInstance()->money->set($playerName,1), $amount);
        Main::getInstance()->money->save();
    }

    public static function defaultMoney(string $playerName): mixed{
        self::addMoney(1000, $playerName);
    }

    public static function payall(int $amount){
        foreach(Server::getInstance()->getOnlinePlayers() as $players){
            self::addMoney($players, $amount);
        }
    }

    public static function pay(string $playerName, int $amount){
        self::addMoney($playerName, $amount);
    }

    public static function reset_account(string $playerName){
        self::defaultMoney($playerName);
    }

    public static function getTotalMoneyOfOnlinePlayers(){
        foreach(Server::getInstance()->getOnlinePlayers() as $players){
            self::getMoney($players);
        }
    }
}
