<?php

namespace Besher\HCF\Commands\Factions;

use Besher\HCF\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Economy extends Command{

	public $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("economy", "Economy command", "Usage: /economy");
		$this->setPermission("economy.hcf");
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		$eco = Main::getEcoManager();
		if(!$this->testPermission($sender)){
			$sender->sendMessage(TF::RED."You don't have permission for that command!, contact staff if you believe this is false");
			return true;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage("You are not a Player");
			return true;
		}
		if(!isset($args[0])){
			$sender->sendMessage(TF::AQUA."-".TF::GRAY."--------------------------------\n".TF::AQUA. " /".TF::GRAY."economy add ".TF::YELLOW."<".TF::GRAY."player".TF::YELLOW."> "."<".TF::GRAY."amount".TF::YELLOW.">\n". TF::AQUA." /".TF::GRAY."economy remove ".TF::YELLOW."<".TF::GRAY."player".TF::YELLOW."> "."<".TF::GRAY."amount".TF::YELLOW.">\n ".TF::AQUA."/".TF::GRAY."set ".TF::YELLOW."<".TF::GRAY."player".TF::YELLOW."> ".TF::YELLOW."<".TF::GRAY."amount".TF::YELLOW.">\n".TF::AQUA."-".TF::GRAY."--------------------------------");
			return true;
		}
		if($args[0] == "set"){
			if(!isset($args[1])){
				$sender->sendMessage("Usage: /economy set <player> <amount>");
				return true;
			}
			if(!isset($args[2])){
				$sender->sendMessage("Usage: /economy set <player> <amount>");
				return true;
			}
			if(!is_numeric($args[2])){
				$sender->sendMessage("Amount must be a number");
				return true;
			}
			$player = $this->plugin->getServer()->getPlayer($args[1]);
			if($player == null){
				$sender->sendMessage(TF::RED."That player is not online!");
				return true;
			}
			$amount = $args[2];
			$eco->setMoney($player, $amount);
			$sender->sendMessage("{$player->getName()} money has been set to $amount");
			return true;
		}
		if($args[0] == "add"){
			if(!isset($args[1])){
				$sender->sendMessage("Usage: /economy add <player> <amount>");
				return true;
			}
			if(!isset($args[2])){
				$sender->sendMessage("Usage: /economy set <player> <amount>");
				return true;
			}
			if(!is_numeric($args[2])){
				$sender->sendMessage("Amount must be a number");
				return true;
			}
			$player = $this->plugin->getServer()->getPlayer($args[1]);
			if($player == null){
				$sender->sendMessage(TF::RED."That player is not online!");
				return true;
			}
			$amount = $args[2];
			$eco->addMoney($player, $amount);
			$sender->sendMessage("Added $amount to {$player->getName()} balance");
			return true;
		}
		if($args[0] == "remove"){
			if(!isset($args[1])){
				$sender->sendMessage("Usage: /economy remove <player> <amount>");
				return true;
			}
			if(!isset($args[2])){
				$sender->sendMessage("Usage: /economy remove <player> <amount>");
				return true;
			}
			if(!is_numeric($args[2])){
				$sender->sendMessage("Amount must be a number");
				return true;
			}
			$player = $this->plugin->getServer()->getPlayer($args[1]);
			if($player == null){
				$sender->sendMessage(TF::RED."That player is not online!");
				return true;
			}
			$amount = $args[2];
			$eco->reduceMoney($player, $amount);
			$sender->sendMessage("Removed $amount from {$player->getName()} balance");
			return true;
		}
	}
}