<?php

namespace Besher\HCF\Events\Claim;

use Besher\HCF\Main;
use Besher\HCF\Manager\FactionsManager;
use Besher\HCF\Tasks\CheckClaimTask;
use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class ClaimEvent implements \pocketmine\event\Listener
{
	public CONST FACTION = "§8[§cFaction§8] §7";

	public $plugin;

	public $delay = [];

	public $firstPos = [];
	public $secondPos = [];

	public $cost = [];

	public $erase = [];

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function claim(PlayerInteractEvent $e): void
	{
		$f = Main::getFactionsManager();
		if ($e->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK or $e->getAction() === PlayerInteractEvent::LEFT_CLICK_BLOCK) {
			if (!$e->getPlayer()->getInventory()->getItemInHand()->getId() == Item::WOODEN_HOE and !$e->getPlayer()->getInventory()->getItemInHand()->getCustomName() == TF::RESET . TF::RED . "Claim Wand") return;
			$name = $e->getPlayer()->getName();
			if (array_key_exists($name, $f->claimSetup)) {
				if ($e->getAction() == PlayerInteractEvent::LEFT_CLICK_BLOCK) {
					if ($this->delay[$name] = time() + 2) {
						$this->delay[$name] = time() + 2;
						$pos = $e->getBlock()->asPosition();
							$e->getPlayer()->sendMessage(self::FACTION."Set §efirst §7claim position. (§b{$pos->getX()}, {$pos->getZ()}§7) (§a$0§7)");
							$this->firstPos[$name] = $pos;
							$this->buildWall($e->getPlayer(), $pos->getX(), $pos->getY(), $pos->getZ());
							$e->setCancelled();
						return;
					} else {
						if (time() >= $this->delay[$name]) {
							unset($this->delay[$name]);
						}
					}
				}
				if ($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
					if ($this->delay[$name] = time() + 2) {
						$this->delay[$name] = time() + 2;
						$pos = $e->getBlock()->asPosition();
							if (array_key_exists($name, $this->firstPos)) {
								$pos1 = $this->firstPos[$name];
								$distance = $pos->distance($pos1);
								if ($distance >= 6) {
									$this->secondPos[$name] = $pos;
									$this->buildWall($e->getPlayer(), $pos->getX(), $pos->getY(), $pos->getZ());
									$this->checkClaim($name);
								} else
									$e->getPlayer()->sendMessage(self::FACTION . "§7Claim must be at least §e5x5 blocks §7wide.");
							} else
								$e->setCancelled();
					} else {
						if (time() >= $this->delay[$name]) {
							unset($this->delay[$name]);
							$e->setCancelled();
						}
					}
				}
			}

		}
	}

	public function confirm(PlayerInteractEvent $e)
	{
		$name = $e->getPlayer()->getName();
		$f = Main::getFactionsManager();
		if (array_key_exists($name, $f->confirm)) {
			if ($e->getPlayer()->isSneaking()) {
				if ($e->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) {
					if (array_key_exists($name, $this->firstPos) == false) {
						$e->getPlayer()->sendMessage("Please select the first position");
						return;
					}
					if (array_key_exists($name, $this->secondPos) == false) {
						$e->getPlayer()->sendMessage("Please select the second position");
						return;
					}
					$faction = $f->confirm[$name];
					$cost = $f->cost[$name];
						$pos1 = $this->firstPos[$name];
						$pos2 = $this->secondPos[$name];
						$this->erase[$name] = $faction;
						$e->getPlayer()->sendMessage(self::FACTION."You have force claimed area for $faction");
						$f->setClaim($faction, $pos1->getX(), $pos2->getX(), $pos1->getZ(), $pos2->getZ());
						unset($f->confirm[$name]);
						unset($f->erase[$name]);
						unset($f->cost[$name]);
						unset($f->claimSetup[$name]);
						return;
				}
			}
		}
	}

	public function cancelClaim(PlayerChatEvent $e)
	{
		$f = Main::getFactionsManager();
		$name = $e->getPlayer()->getName();
		if (array_key_exists($name, Main::getFactionsManager()->confirm)) {
			if ($e->getMessage() == "cancel") {
				$faction = $this->erase[$name];
				unset($f->confirm[$name]);
				unset($f->erase[$name]);
				unset($f->cost[$name]);
				unset($f->claimSetup[$name]);
				Main::getFactionsManager()->claimSetup[$name] = $faction;
				$e->getPlayer()->sendMessage(self::FACTION. TF::GRAY . "Claim canceled");
				$e->setCancelled();
			}
		}
	}

	public function buildWall(Player $player, int $x, int $y, int $z)
	{
		for ($i = $y; $i < $y + 40; $i++) {
			$this->setFakeBlock($player, new Vector3($x, $i, $z), $this->getRandWallBlock());
		}
	}

	public function setFakeBlock(Player $player, Vector3 $pos, int $id, int $data = 0)
	{
		$block = Block::get($id, $data)->setComponents($pos->getX(), $pos->getY(), $pos->getZ())->setLevel($player->getLevel());
		$player->getLevel()->sendBlocks([$player], [$block], UpdateBlockPacket::FLAG_ALL);
	}

	public function getRandWallBlock(): int
	{
		switch (mt_rand(1, 3)) {
			case 1:

				return BlockIds::DIAMOND_BLOCK;
				break;
			case 2:
			case 3:
			case 4:
			return BlockIds::GLASS;
				break;
		}
		return BlockIds::GLASS;
	}

	public function checkClaim(string $name)
	{
		$dir = $this->plugin->getDataFolder() . "db/"  . "Factions.db";
		$pos1 = $this->firstPos[$name];
		$pos2 = $this->secondPos[$name];
		$x1 = min($pos1->getX(), $pos2->getX());
		$z1 = min($pos1->getZ(), $pos2->getZ());
		$x2 = max($pos1->getX(), $pos2->getX());
		$z2 = max($pos1->getZ(), $pos2->getZ());
		$this->plugin->getServer()->getAsyncPool()->submitTask(new CheckClaimTask($x1, $z1, $x2, $z2,$dir, $name));
	}

}