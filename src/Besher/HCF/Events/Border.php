<?php

declare(strict_types=1);

namespace Besher\HCF\Events;

use Besher\HCF\Main;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\Position;
use pocketmine\math\Math;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat as TF;

class Border implements \pocketmine\event\Listener
{

	public $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function BorderMove(PlayerMoveEvent $e){
		$s = Main::getServerManager();
		$player = $e->getPlayer();
		$level = $this->plugin->getServer()->getDefaultLevel();
		$safe = $level->getSafeSpawn();
		$x = $s->getBorder();
		$z = $s->getBorder();
		$xf = $e->getPlayer()->getFloorX();
		$zf = $e->getPlayer()->getFloorZ();
		$xs = $safe->getFloorX() + $x;
		$zs = $safe->getFloorZ() + $z;
		$x1 = abs($xf);
		$z1 = abs($zf);
		$x2 = abs($xs);
		$z2 = abs($zs);
		if($x1 >= $x2){
			$player->sendPopup(TF::RESET . TF::RED . " You have reached the world border!");
			$e->setCancelled();
		}
		if($z1 >= $z2){
			$player->sendPopup(TF::RESET . TF::RED . " You have reached the world border!");
			$e->setCancelled();
		}
	}

	public function onPlace(BlockPlaceEvent $event){
		$s = Main::getServerManager();
		$server = $this->plugin->getServer();
		$player = $event->getPlayer();
		$x = $s->getBorder();
		$z = $s->getBorder();
		$xp = $event->getBlock()->getFloorX();
		$zp = $event->getBlock()->getFloorZ();
		$xs = $player->getFloorX() + $x;
		$zs = $player->getFloorZ() + $z;
		$x1 = abs($xp);
		$z1 = abs($zp);
		$x2 = abs($xs);
		$z2 = abs($zs);
		if($x1 >= $x2){
			$player->sendPopup(TF::RED. " You cannot place blocks out of world border!");
			$event->setCancelled();
		}
		if($z1 >= $z2){
			$player->sendPopup(TF::RED. " You cannot place blocks out of world border!");
			$event->setCancelled();
		}
	}

	public function onBreak(BlockBreakEvent $event){
		$s = Main::getServerManager();
		$server = $this->plugin->getServer();
		$level = $server->getDefaultLevel();
		$safe = $level->getSafeSpawn();
		$player = $event->getPlayer();
		$x = $s->getBorder();
		$z = $s->getBorder();
		$xp = $event->getBlock()->getFloorX();
		$zp = $event->getBlock()->getFloorZ();
		$xs = $safe->getFloorX() + $x;
		$zs = $safe->getFloorZ() + $z;
		$x1 = abs($xp);
		$z1 = abs($zp);
		$x2 = abs($xs);
		$z2 = abs($zs);
		if($x1 >= $x2){
			$player->sendPopup(TF::RED." You cannot break blocks out of world border!");
			$event->setCancelled();
		}
		if($z1 >= $z2){
			$player->sendPopup(TF::RED. " You cannot break blocks out of world border!");
			$event->setCancelled();
		}
	}

	public function outSideBorder(PlayerMoveEvent $e){
		$s = Main::getServerManager();
		$player = $e->getPlayer();
		$x = $player->getX();
		$z = $player->getZ();
		$y = $player->getY();
		$border = $s->getBorder() + 2;
		$level = $player->getLevel();
		if($z > $border){
			$pos = new Position($x, $y, $border - 3, $level);
			$player->teleport($pos);
		}
		if($x > $border){
			$pos = new Position( $border - 3, $y, $z, $level);
			$player->teleport($pos);
		}
	}
}