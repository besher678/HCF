<?php

namespace Besher\HCF\Commands\StaffCommands;

use Besher\HCF\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Clear extends Command{

	public $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("clear", "Clear you're inventory", "/clear");
		$this->setPermission("clear.hcf");
		$this->setPermissionMessage(TF::RED."You don't have permission for that command!");
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if(!$this->testPermission($sender)){
			$sender->sendMessage(TF::RED."You don't have permission for that command!");
			return true;
		}
		if($sender instanceof Player){
			$sender->getInventory()->clearAll();
			$sender->sendMessage(TF::GRAY."[".TF::RED."Core".TF::GRAY."]".TF::GREEN." You're Inventory has been Cleared");
			return true;
		}
	}
}