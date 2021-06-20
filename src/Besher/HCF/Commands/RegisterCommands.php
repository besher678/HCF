<?php

declare(strict_types=1);

namespace Besher\HCF\Commands;

use Besher\HCF\Commands\Factions\Economy;
use Besher\HCF\Commands\Factions\FactionsCommand;
use Besher\HCF\Commands\Factions\Money;
use Besher\HCF\Commands\Player\Kit;
use Besher\HCF\Commands\Player\PvpTimer;
use Besher\HCF\Commands\Player\Rename;
use Besher\HCF\Commands\StaffCommands\Border;
use Besher\HCF\Commands\StaffCommands\Clear;
use Besher\HCF\Commands\StaffCommands\Gmc;
use Besher\HCF\Commands\StaffCommands\Gms;
use Besher\HCF\Commands\StaffCommands\Butcher;
use Besher\HCF\Commands\StaffCommands\Mod;
use Besher\HCF\Commands\StaffCommands\RollBack;
use Besher\HCF\Commands\StaffCommands\Sotw;
use Besher\HCF\Commands\StaffCommands\Vanish;
use Besher\HCF\Main;

use pocketmine\utils\TextFormat as TF;

class RegisterCommands{


    public static function init(): void {
		$instance = Main::getInstance();
		$server = $instance->getServer();
		$map = $server->getCommandMap();
		$map->register("kit", new Kit($instance));
		$map->register("crate", new Crate($instance));
		$map->register("rollback", new RollBack($instance));
		$map->register("setborder", new Border($instance));
		$map->register("pex", new Pex($instance));
		$map->register("rename", new Rename($instance));
		$map->register("mod", new Mod($instance));
		$map->register("money", new Money($instance));
		$map->register("economy", new Economy($instance));
		$map->register("sotw", new Sotw($instance));
		$map->register("pvp", new PvpTimer($instance));
		$map->register("vanish", new Vanish($instance));
		$map->register("butcher", new Butcher($instance));
		$map->register("gms", new Gms($instance));
		$map->register("gmc", new Gmc($instance));
		$map->register("clear", new Clear($instance));
		$map->register("faction", new FactionsCommand($instance));
		$log = $server->getLogger();
		$log->notice(TF::GREEN."All Commands Registered");
	}
}