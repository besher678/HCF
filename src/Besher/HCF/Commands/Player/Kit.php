<?php

namespace Besher\HCF\Commands\Player;

use Besher\HCF\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Kit extends Command
{

	public $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("kit", "Opens kit menu", "/kit", ["kits", "gkit"]);
		$this->plugin = $pg;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void
	{
		if(!$sender instanceof Player)
		{
			$sender->sendMessage("You are not a player!");
			return;
		}
		$p = Main::getPlayerManager();
		$device = $p->getDevice($sender->getName());
		if($device == "Win10")
		{
			$inv = Main::getInvMenu();
			$inv->sendMenu($sender);
		} else {
			$sender->sendMessage("YOU ARE PE");
		}
	}
}