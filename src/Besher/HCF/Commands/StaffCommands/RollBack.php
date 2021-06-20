<?php


namespace Besher\HCF\Commands\StaffCommands;


use Besher\HCF\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class RollBack extends \pocketmine\command\Command
{

	private $plugin;

	public function __construct(Main $pg)
	{
		parent::__construct("rollback", "Rollback a players inventory after death", "/rollback <player>");
		$this->setPermission("rollback.hcf");
		$this->plugin = $pg;
	}

	/**
     * @inheritDoc
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : void
    {
		$f = Main::getPlayerManager();
		if(!$this->testPermission($sender)){
			$sender->sendMessage(TF::RED."No permission");
    		return;
		}
    	if(!isset($args[0])){
    		$sender->sendMessage($this->usageMessage);
    		return;
		}
    	$player = $this->plugin->getServer()->getPlayer($args[0]);
    	if($player == null){
    		$sender->sendMessage("$args[0] is not online or doesn't exist");
    		return;
		}
    	$this->Restore($player);
    	$sender->sendMessage("Restored {$player->getName()}'s Inventory");
    	return;
    }

	public function Restore(Player $player)
	{
		$p = Main::getPlayerManager();
		$player->removeAllEffects();
		$player->setMaxHealth(20);
		$player->setHealth(20);
		$player->setFood(20);
		$cloud = $p->inventory[$player->getName()];
		$player->getInventory()->clearAll();
		foreach ($cloud as $slot => $item) {
			$player->getInventory()->setItem($slot, Item::get($item[0], $item[1], $item[2]));
		}
		unset($p->inventory[$player->getName()]);
		return true;
	}
}