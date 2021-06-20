<?php

namespace Besher\HCF\Events\Claim;

use Besher\HCF\Main;
use Besher\HCF\Manager\FactionsManager;
use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class ClaimEvent implements \pocketmine\event\Listener
{

	public $delay = [];

	public $firstPosX = [];
	public $firstPosZ = [];

	public $secondPosX = [];
	public $secondPosZ = [];

	public $cost = [];

	public function __construct(Main $pg)
	{
	}

	public function claim(PlayerInteractEvent $e): void
	{
		$f = Main::getFactionsManager();
		if($e->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK OR $e->getAction() === PlayerInteractEvent::LEFT_CLICK_BLOCK) {
			if (!$e->getPlayer()->getInventory()->getItemInHand()->getId() == Item::WOODEN_HOE and !$e->getPlayer()->getInventory()->getItemInHand()->getCustomName() == TF::RESET . TF::GOLD . "Claiming Wand") return;
			$name = $e->getPlayer()->getName();
			if (array_key_exists($name, $f->stepOne)) {
				if (!isset($this->delay[$e->getPlayer()->getName()])) {
				$this->delay[$e->getPlayer()->getName()] = time() + 1;
				$x = (int)$e->getBlock()->getX();
				$z = (int)$e->getBlock()->getZ();
				$this->firstPosX[$e->getPlayer()->getName()] = $x;
				$this->firstPosZ[$e->getPlayer()->getName()] = $z;
				$e->getPlayer()->sendMessage(TF::GREEN . "First pos set please select second");
				$this->claimTower($e->getPlayer(), $e->getBlock()->getX(), $e->getBlock()->getY(), $e->getBlock()->getZ());
				unset($f->stepTwo[$name]);
				$faction = $f->stepOne[$name];
				$f->stepTwo[$name] = $faction;
				unset($f->stepOne[$name]);
				$e->setCancelled();
				return;
			} else {
					if (time() >= $this->delay[$e->getPlayer()->getName()]) {
						unset($this->delay[$e->getPlayer()->getName()]);
					}
					return;
				}
			}
			if (array_key_exists($name, $f->stepTwo)) {
				if (!isset($this->delay[$e->getPlayer()->getName()])) {
					$this->delay[$e->getPlayer()->getName()] = time() + 1;
					$x = (int)$e->getBlock()->getX();
					$z = (int)$e->getBlock()->getZ();
					$this->secondPosX[$e->getPlayer()->getName()] = $x;
					$this->secondPosZ[$e->getPlayer()->getName()] = $z;
					$count = 0;
					$e->setCancelled();
					$e->getPlayer()->sendMessage(TF::GREEN . "Second position\n Claim cost = 100");
					$faction = $f->stepTwo[$name];
					$f->stepThree[$name] = $faction;
					$this->cost[$name] = $count * 10;
					unset($f->stepTwo[$name]);
					$this->claimTower($e->getPlayer(), $e->getBlock()->getX(), $e->getBlock()->getY(), $e->getBlock()->getZ());
					return;
				} else {
					if (time() >= $this->delay[$e->getPlayer()->getName()]) {
						unset($this->delay[$e->getPlayer()->getName()]);
					}
					return;
				}
			}
		}
	}

	public function chatEvent(PlayerChatEvent $e)
	{
		$f = Main::getFactionsManager();
		$eco = Main::getEcoManager();
		$name = $e->getPlayer()->getName();
		if (array_key_exists($e->getPlayer()->getName(), $f->stepThree)) {
			if($e->getMessage() == "cancel"){
				unset($f->stepThree[$e->getPlayer()->getName()]);
				$x1 = $this->firstPosX[$name];
				$x2 = $this->secondPosX[$name];
				$z1 = $this->firstPosZ[$name];
				$z2 = $this->secondPosZ[$name];
				$e->getPlayer()->sendMessage("Claim disbanded");
				$this->removeTower($e->getPlayer(), $x1, $z1);
				$this->removeTower($e->getPlayer(), $x2, $z2);
				$e->setCancelled();
				return;
			}
			if($e->getMessage() == "confirm"){
				$cost = $this->cost[$e->getPlayer()->getName()];
				if($eco->getMoney($e->getPlayer()) >= $cost){
					$eco->reduceMoney($e->getPlayer(), $cost);
					$x1 = $this->firstPosX[$name];
					$x2 = $this->secondPosX[$name];
					$z1 = $this->firstPosZ[$name];
					$z2 = $this->secondPosZ[$name];
					$faction = $f->stepThree[$name];
					$f->setClaim($faction, $x1, $z1, $x2, $z2);
					$e->getPlayer()->sendMessage("You have claimed for $cost");
					$this->removeTower($e->getPlayer(), $x1, $z1);
					$this->removeTower($e->getPlayer(), $x2, $z2);
					unset($this->cost[$name]);
					unset($f->stepThree[$name]);
					unset($this->firstPosX[$name]);
					unset($this->secondPosX[$name]);
					unset($this->firstPosZ[$name]);
					unset($this->secondPosZ[$name]);
					$e->setCancelled();
					return;
				}
			}
		}
	}

	public function sendBlock(Player $player, $x, $y, $z, $id){
		$block = Block::get($id);
		$block->x = (int) $x;
		$block->y = (int) $y;
		$block->z = (int) $z;
		$block->level = $player->getLevel();
		$player->level->sendBlocks([$player],[$block]);
	}

	public function claimTower(Player $player, int $x, int $y, int $z)
	{
		$i = $y;
		for($i = $y; $i < $y +50; $i++){
			$this->sendBlock($player, $x, $i, $z, $this->glassAndEmerald());
		}
	}

	public function removeTower(Player $player, int $x, int $z)
	{
		$y = 40;
		for($i = $y; $i < $y + 100; $i++){
			$this->sendBlock($player, $x, $i, $z, $this->air());
		}
	}

	public function glassAndEmerald(): int
	{
		switch (mt_rand(1, 3)) {
			case 1:
			case 2:
				return BlockIds::GLASS;
				break;
			case 3:
				return BlockIds::EMERALD_BLOCK;
				break;
		}
		return BlockIds::GLASS;
	}

	public function air(): int
	{
		return BlockIds::AIR;
	}
}