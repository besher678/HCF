<?php

namespace Besher\HCF\Commands\Player;

use Besher\HCF\Main;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Rename extends \pocketmine\command\Command
{
	public $plugin;

   public function __construct(Main $pg)
   {
	   parent::__construct("rename", "Rename the item in your hand", "/usage: /rename <name>");
	   $this->setPermission("rename.hcf");
   }

	public function execute(\pocketmine\command\CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)){
        	$sender->sendMessage(TF::RED."You don't have permission for this command!, Contact staff if you believe this is false");
        	return true;
		}
        if($sender instanceof Player){
			$name = implode(" ", $args);
			$item = $sender->getInventory()->getItemInHand()->setCustomName("{$name}");
			$sender->sendMessage("You have renamed the item to $name");
			return true;
		}
    }
}