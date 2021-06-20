<?php

namespace Besher\HCF\Events;

use Besher\HCF\Main;
use pocketmine\block\Air;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class ItemClick implements \pocketmine\event\Listener
{
	public $plugin;
	public $nametagg = [];

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function clickVanish(PlayerInteractEvent $e){
		$player = $e->getPlayer();
		$name = $e->getItem();
		$lore = $name->getLore();
		if($name->getCustomName() == TF::RESET.TF::GREEN."Vanish" AND $lore == TF::RESET.TF::AQUA."Go invisible"){
			$green = Item::get(Item::DYE, 10)->setCustomName(TF::RESET.TF::GRAY."Vanish");
			$green->setLore([TF::RESET.TF::AQUA."Go invisible"]);
			$player->sendMessage(TF::RED."Vanish disbaled!");
			$player->getInventory()->setItem(6, $green);
			foreach ($this->plugin->getServer()->getOnlinePlayers() as $players){
				$players->showPlayer($player);
				return true;
			}
		}
			if($name->getCustomName() == TF::RESET.TF::GRAY."Vanish" AND $lore == TF::RESET.TF::AQUA."Go invisible"){
				$gray = Item::get(Item::DYE, 8)->setCustomName(TF::RESET.TF::GREEN."Vanish");
				$gray->setLore([TF::RESET.TF::AQUA."Go invisible"]);
				$player->sendMessage(TF::GREEN."Vanish enabled!");
				$player->getInventory()->setItem(6, $gray);
				foreach ($this->plugin->getServer()->getOnlinePlayers() as $players){
					$players->hidePlayer($player);
					return true;
				}
			}
			return true;
		}

		public function hitPlayer(EntityDamageByEntityEvent $e)
		{
			$damager = $e->getDamager();
			$player = $e->getEntity();
			if ($damager instanceof Player and $player instanceof Player) {
				$freeze = $damager->getInventory()->getItemInHand();
				if ($freeze->getCustomName() == TF::RESET.TF::GOLD."Inventory Inspect") {
					$e->setCancelled();
					$this->plugin->getServer()->dispatchCommand($damager, "invsee {$player->getName()}");
		}
			}
		}

	public function freezePlayer(EntityDamageByEntityEvent $e)
	{
		$damager = $e->getDamager();
		$player = $e->getEntity();
		if ($damager instanceof Player and $player instanceof Player) {
			$freeze = $damager->getInventory()->getItemInHand();
			if ($freeze->getCustomName() == TF::RESET.TF::AQUA."Freeze") {
				if($player->isImmobile() == true){
					$e->setCancelled();
					$player->sendMessage("You have been unfrozen");
					$player->addTitle(TF::GREEN."You have been", TF::AQUA."unfrozen!", 1, 20, 1);
					$player->setImmobile(false);
					$this->unsetTag($player);
					return true;
				}
				$e->setCancelled();
				$player->sendMessage("You have been frozen");
				$player->addTitle("§cYOU HAVE BEEN FROZEN", "By Staff", 1, 20, 1);
				$player->setImmobile(true);
				$this->setTag($player);
				return true;
			}
		}
	}

	public function thruBlock(BlockBreakEvent $e)
	{
		$player = $e->getPlayer();
		$blockX = $e->getBlock()->getX();
		$blockZ = $e->getBlock()->getZ();
	}

	public function setTag(Player $player)
	{
		$name = $player->getName();
		$nameTag = $player->getNameTag();
		$this->nametagg[$name] = $nameTag;
		$player->setNameTag("§8§l[§r§6§3Frozen§r§8§l]§r $nameTag");
	}

	public function unsetTag(Player $player)
	{
		$name = $player->getName();
		$nameTag = $this->nametagg[$name];
		$player->setNameTag("$nameTag");
	}
}