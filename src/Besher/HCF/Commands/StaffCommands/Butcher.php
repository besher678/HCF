<?php


namespace Besher\HCF\Commands\StaffCommands;

use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Butcher extends \pocketmine\command\Command
{

	public $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("butcher", "Kill all animals", "/Butcher");
		$this->plugin = $pg;
		$this->setPermission("butcher.hcf");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if(!$this->testPermission($sender)){
			$sender->sendMessage(TF::RED."You dont have permission to use that command");
			return true;
		}
		if($sender instanceof Player){
			$sender->sendMessage(TF::GRAY."[".TF::RED."Core".TF::GRAY."] ".TF::GREEN."Killed all animals");
			$this->clearEntities();
			return true;
		}
		return true;
	}

	public function clearEntities(){
		foreach($this->plugin->getServer()->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if(!$entity instanceof Player) $entity->close(); // Don't use kill since we i don't need drops or exp that will just lag
			}
		}
	}
}