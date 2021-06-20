<?php


namespace Besher\HCF\Commands\Factions;

use pocketmine\utils\TextFormat as TF;
use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;

class Money extends \pocketmine\command\Command
{


	public $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("money", "Get the amount of money you have", "/money", ["mymoney", "bal"]);
	}

	/**
     * @inheritDoc
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
    	$eco = Main::getEcoManager();
        if(!$sender instanceof Player){
        	$sender->sendMessage(TF::RED."COnsoile cant");
        	return true;
		}
        $money = $eco->getMoney($sender);
        $sender->sendMessage(TF::GOLD."Balance: ".TF::WHITE.$money);


    }
}