<?php

declare(strict_types=1);

namespace Besher\HCF\Events\Cheat;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use Besher\HCF\Main;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class NoFallCheats implements Listener
{

	private $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function AntiFall(PlayerMoveEvent $e){
		$player = $e->getPlayer();
	}
}