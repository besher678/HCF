<?php


namespace Besher\HCF\Commands\StaffCommands;

use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Gmc extends \pocketmine\command\Command
{

    public $plugin;

    public function __construct(Main $pg)
	{
		parent::__construct("gmc", "Set your gamemode to creative", "/gmc", ["gm1"]);
		$this->plugin = $pg;
		$this->setPermission("gmc.hcf");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)){
        	$sender->sendMessage(TF::RED."You dont have permission to use that command");
        	return true;
		}
        if($sender instanceof Player){
        	$sender->setGamemode(1);
        	$sender->setGamemode(TF::GRAY."[".TF::RED."Core".TF::GRAY."] ".TF::GREEN."Gamemode set to creative");
        	return true;
		}
        return true;
    }
}