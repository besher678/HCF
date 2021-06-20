<?php

namespace Besher\HCF\Commands\Player;

use Besher\HCF\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class PvpTimer extends Command{

	public $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("pvp", "Server pvp options", "/pvp help", [""]);
		$this->setPermission("pvp.hcf");
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		$p = Main::getPlayerManager();
		if(!$sender instanceof Player){
			$sender->sendMessage("You are console");
			return true;
		}
		if(!isset($args[0])){
			$sender->sendMessage("/pvp help for a list of commands");
			return true;
		}
		if($args[0] == "enable"){
			$p->removePvpTimer($sender);
			$sender->sendMessage("Pvp enabled");
			return true;
		}
		if($args[0] == "set"){
			if(!isset($args[1])){
				$sender->sendMessage("Please enter a name for the player");
				return true;
			}
			$player = $this->plugin->getServer()->getPlayer($args[1]);
			if($player == null){
				$sender->sendMessage("That player is not online!");
				return true;
			}
			if(!$this->testPermission($sender)){
				$sender->sendMessage(TF::RED."You don't have permission to use that command");
				return true;
			}
			$p->setPvpTimer($player);
			$sender->sendMessage("You have reset {$player->getName()}'s pvp timer");
			$player->sendMessage("You're Pvp timer has been reset");
			return true;
		}
		if($args[0] == "remove"){
			if(!isset($args[1])){
				$sender->sendMessage("Please enter a name for the player");
				return true;
			}
			$player = $this->plugin->getServer()->getPlayer($args[1]);
			if($player == null){
				$sender->sendMessage("That player is not online!");
				return true;
			}
			if(!$this->testPermission($sender)){
				$sender->sendMessage(TF::RED."You don't have permission to use that command");
				return true;
			}
			$p->removePvpTimer($player);
			$sender->sendMessage("You have removed {$player->getName()}'s pvp timer");
			$player->sendMessage("You're Pvp timer has been removed");
			return true;
		}
		return true;
	}
}