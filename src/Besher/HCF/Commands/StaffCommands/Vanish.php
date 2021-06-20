<?php

namespace Besher\HCF\Commands\StaffCommands;

use Besher\HCF\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Vanish extends Command{

	public $vanish = [];

	public $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("vanish", "Become invisible so other player cant see you", "/vanish", ["v"]);
		$this->setPermission("vanish.hcf");
		$this->setPermissionMessage(TF::RED."You don't have permission for that command!");
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void
	{
		$pex = Main::getPexManager();
		if(!$this->testPermission($sender)){
			$sender->sendMessage(TF::RED."You don't have permission for that command!");
			return;
		}
		if($sender instanceof Player){
			$sender->sendMessage(TF::GRAY."[".TF::RED."Core".TF::GRAY."] ".TF::GREEN."You have vanished");
			foreach ($this->plugin->getServer()->getOnlinePlayers() as $players) {
				if($pex->getServerStaff($players->getName())){
					$players->showPlayer($sender);
					return;
				}
				$players->hidePlayer($sender);
			}
			return;
		}
	}

}