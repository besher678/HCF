<?php

declare(strict_types=1);

namespace Besher\HCF\Events;

use Besher\HardCore\Core;
use Besher\HCF\Main;
use pocketmine\block\BlockIds;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat as TF;

class NoClipCheats implements \pocketmine\event\Listener
{
	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function noClip(PlayerMoveEvent $e)
	{
		$player = $e->getPlayer();
		$name = $player->getName();
		$level = $player->getLevel();
		$movement1 = $level->getBlock(new Vector3($e->getTo()->getX(), $e->getTo()->getY(), $e->getTo()->getZ()));
		$movment2 = $block2 = $level->getBlock(new Vector3($e->getTo()->getX(), $e->getTo()->getY() + 1, $e->getTo()->getZ()));
		if (!$player->isCreative() && !$player->isSpectator() && !$player->getAllowFlight()) {
			if ($movement1->getId() == BlockIds::TRAPDOOR) return;
			if ($movement1->getId() == BlockIds::TRAPDOOR) return;
			if ($movement1->getId() == BlockIds::WOODEN_TRAPDOOR) return;
			if ($movement1->getId() == BlockIds::WOODEN_TRAPDOOR) return;
			if ($movement1->getId() == BlockIds::OAK_FENCE_GATE) return;
			if ($movement1->getId() == BlockIds::OAK_DOOR_BLOCK) return;
			if ($movement1->getId() == BlockIds::ACACIA_FENCE_GATE) return;
			if ($movement1->getId() == BlockIds::JUNGLE_FENCE_GATE) return;
			if ($movement1->getId() == BlockIds::SPRUCE_FENCE_GATE) return;
			if ($movement1->getId() == BlockIds::DARK_OAK_FENCE_GATE) return;
			if ($movement1->getId() == BlockIds::PORTAL || $block2->getId() == BlockIds::PORTAL) return;
			if ($movment2->isSolid() || $movement1->getId() == BlockIds::SAND || $movement1->getId() == BlockIds::GRAVEL || $block2->getId() == BlockIds::SAND || $block2->getId() == BlockIds::GRAVEL) {
				$player->teleport($e->getFrom());
				$this->plugin->getServer()->getLogger()->alert(TF::GRAY . "[" . TF::YELLOW . "!" . TF::GRAY . "]" . TF::BOLD . TF::DARK_RED . " ALERT: " . TF::RESET . TF::GRAY . $player->getName() . " has triggered No-Clip Alert!");
				foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $player) {
					if ($player->hasPermission("alerts.hardcore")) {
						$player->sendMessage(TF::GRAY . "[" . TF::YELLOW . "!" . TF::GRAY . "]" . TF::BOLD . TF::DARK_RED . " ALERT: " . TF::RESET . TF::GRAY . $player->getName() . " has triggered No-Clip ALERT!");
					}
				}

			}

		}
	}
}