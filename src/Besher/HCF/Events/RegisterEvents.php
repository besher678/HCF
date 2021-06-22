<?php

declare(strict_types=1);

namespace Besher\HCF\Events;

use Besher\HCF\Events\Buy\BuySign;
use Besher\HCF\Events\Cheat\FlyCheats;
use Besher\HCF\Events\Cheat\Speed;
use Besher\HCF\Events\Crate\CrateEvents;
use Besher\HCF\Events\Crate\CrateSetup;
use Besher\HCF\Events\Faction\Region;
use Besher\HCF\Events\Faction\RegionMove;
use Besher\HCF\Events\ItemClick;
use Besher\HCF\Events\Cheat\NoFallCheats;
use Besher\HCF\Events\Cheat\ReachCheats;
use Besher\HCF\Events\CoolDown\CombatTag;
use Besher\HCF\Events\CoolDown\Crapple;
use Besher\HCF\Events\CoolDown\EnderPearl;
use Besher\HCF\Events\CoolDown\Gapple;
use Besher\HCF\Events\Elevator;
use Besher\HCF\Events\Claim\ClaimEvent;
use Besher\HCF\Events\Items\SwitcherSnowBall;
use Besher\HCF\Events\PlayerJoin;
use pocketmine\event\Listener;
use Besher\HCF\Main;

class RegisterEvents implements Listener{

	public static function init(): void {
		$instance = Main::getInstance();
		$server = $instance->getServer();
		$reg = $server->getPluginManager();

		$reg->registerEvents(new FlyCheats($instance), $instance);
		$reg->registerEvents(new FoundDiamonds($instance), $instance);
		$reg->registerEvents(new CrateEvents($instance), $instance);
		$reg->registerEvents(new CrateSetup($instance), $instance);
		$reg->registerEvents(new Speed($instance), $instance);
		$reg->registerEvents(new DeathEvent($instance), $instance);
		$reg->registerEvents(new Region($instance), $instance);
		$reg->registerEvents(new ChatFormat($instance), $instance);
		$reg->registerEvents(new SwitcherSnowBall($instance), $instance);
		$reg->registerEvents(new FoundDiamonds($instance), $instance);
		$reg->registerEvents(new ItemClick($instance), $instance);
		$reg->registerEvents(new BuySign($instance), $instance);
		$reg->registerEvents(new NoFallCheats($instance), $instance);
		$reg->registerEvents(new ReachCheats($instance), $instance);
		$reg->registerEvents(new Border($instance), $instance);
		$reg->registerEvents(new ClaimEvent($instance), $instance);
		$reg->registerEvents(new Elevator($instance), $instance);
		$reg->registerEvents(new PlayerJoin($instance), $instance);
		$server->getLogger()->notice("Events Registered Successfully");
	}

}