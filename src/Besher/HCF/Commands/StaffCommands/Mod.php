<?php


namespace Besher\HCF\Commands\StaffCommands;


use Besher\HCF\Main;
use Besher\HCF\Tasks\ScoreBoardTask;
use Besher\HCF\Tasks\StaffScoreboard;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Mod extends \pocketmine\command\Command
{

	public $mod = [];

	public $vanish = [];

	public $plugin;
	public $inventory = [];

	public function __construct(Main $pg)
	{
		parent::__construct("mod", "Enter mod mode", "/mod", ["staff", "staffmode", ""]);
		$this->setPermission("mod.hcf");
		$this->setPermissionMessage(TF::RED."You don't have permission for that command!");
		$this->plugin = $pg;
	}

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
       if(!$this->testPermission($sender)){
       		$sender->sendMessage(TF::RED."You don't have permission for that command!, Contact staff if you believe this is false");
       		return true;
	   }
       if(!$sender instanceof Player){
       		$sender->sendMessage(TF::RED."You can't run that command in console!");
       		return true;
	   }
       if(!isset($this->mod[$sender->getName()])){
       	$this->mod[$sender->getName()] = $sender->getName();
       	$this->joinStaffMode($sender);
       	return true;
	} else {
       	unset($this->mod[$sender->getName()]);
       	$this->quitStaffMode($sender);
       	return true;
	   }
    }

    public function joinStaffMode(Player $player){
		$p = Main::getPlayerManager();
		$this->Backup($player);
		$player->setGamemode(1);
		$player->getInventory()->clearAll();
		$compass = Item::get(Item::COMPASS);
		$book = Item::get(Item::BOOK);
		$carpet = Item::get(Item::CARPET);
		$feather = Item::get(Item::DYE, 8);
		$ice = Item::get(Item::ICE);
		$ball = Item::get(Item::FEATHER);

		$compass->setCustomName(TF::RESET.TF::LIGHT_PURPLE."Teleporter");
		$compass->setLore([TF::RESET.TF::AQUA."Easier Teleporting"]);

		$book->setCustomName(TF::RESET.TF::GOLD."Inventory Inspect");
		$book->setLore([TF::RESET.TF::AQUA."Inspect player's inventory"]);

		$carpet->setCustomName(TF::RESET.TF::BLUE."Better View");
		$carpet->setLore([TF::RESET.TF::AQUA."See Better"]);

		$feather->setCustomName(TF::RESET.TF::GREEN."Vanish");
		$feather->setLore([TF::RESET.TF::AQUA."Go invisible"]);

		$ice->setCustomName(TF::RESET.TF::AQUA."Freeze");
		$ice->setLore([TF::RESET.TF::AQUA."Freeze a Player"]);

		$ball->setCustomName(TF::RESET.TF::RED."Random Teleport");
		$ball->setLore([TF::RESET.TF::AQUA."Teleport to a random player"]);

		$player->getInventory()->setItem(0, $compass);
		$player->getInventory()->setItem(1, $book);
		$player->getInventory()->setItem(4, $carpet);
		$player->getInventory()->setItem(6, $feather);
		$player->getInventory()->setItem(7, $ice);
		$player->getInventory()->setItem(8, $ball);

		$player->sendMessage(TF::GRAY."You have ".TF::GREEN."enabled ".TF::GRAY."staffmode");
	}

	public function quitStaffMode(Player $player){
		$this->Restore($player);
		$player->setGamemode(0);
		$player->sendMessage(TF::GRAY."You have ".TF::RED."disabled ".TF::GRAY."staffmode");
	}

	public function Backup(Player $player)
	{
		$contents = $player->getInventory()->getContents();
		$items = [];
		foreach ($contents as $slot => $item) {
			$items[$slot] = [$item->getId(), $item->getDamage(), $item->getCount()];
		}
		$this->inventory[$player->getName()] = $items;
		$player->getInventory()->clearAll();
	}

	public function Restore(Player $player)
	{
		$player->removeAllEffects();
		$player->setMaxHealth(20);
		$player->setHealth(20);
		$player->setFood(20);
		$cloud = $this->inventory[$player->getName()];
		$player->getInventory()->clearAll();
		foreach ($cloud as $slot => $item) {
			$player->getInventory()->setItem($slot, Item::get($item[0], $item[1], $item[2]));
		}
		unset($this->inventory[$player->getName()]);
		return true;
	}
}