<?php


namespace Besher\HCF\Commands\StaffCommands;

use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Gms extends \pocketmine\command\Command
{

	public $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("gms", "Set your gamemode to survival", "/gms", ["gm0"]);
		$this->plugin = $pg;
		$this->setPermission("gms.hcf");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if(!$this->testPermission($sender)){
			$sender->sendMessage(TF::RED."You dont have permission to use that command");
			return true;
		}
		if($sender instanceof Player){
			$sender->setGamemode(0);
			$sender->setGamemode(TF::GRAY."[".TF::RED."Core".TF::GRAY."] ".TF::GREEN."Gamemode set to survival");
			return true;
		}
		return true;
	}
}