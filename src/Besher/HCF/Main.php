<?php

declare(strict_types=1);

namespace Besher\HCF;

use Besher\HCF\Commands\Crate;
use Besher\HCF\Commands\RegisterCommands;
use Besher\HCF\Events\RegisterEvents;
use Besher\HCF\Manager\CrateManager;
use Besher\HCF\Manager\EconomyManager;
use Besher\HCF\Manager\FactionsManager;
use Besher\HCF\Manager\PexManager;
use Besher\HCF\Manager\PlayerManager;
use Besher\HCF\Manager\ServerManager;
use Besher\HCF\Tasks\ScoreBoard;
use Besher\HCF\Tasks\ScoreBoardTask;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use Besher\HCF\Provider\KitUi;

class Main extends PluginBase
{

	private static $instance;

	private static $playerManager;
	private static $factionsManager;
	private static $economyManager;
	private static $pexManager;
	private static $serverManager;
	private static $crateManager;
	private static $kitUi;

	public $crateSetup = [];
	public $display = [];
	public $hologram = [];
	public $breakCrate = [];

	private $config;

	public function onEnable()
	{
		self::$instance = $this;
		@mkdir($this->getDataFolder() . "db/");
		@mkdir($this->getDataFolder() . "crate/");
		$this->config = new Config($this->getDataFolder() . "crate/" . "items.yml", Config::YAML);
		$this->getScheduler()->scheduleRepeatingTask(new ScoreboardTask($this), 20);
		Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand("ban"));
		Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand("pardon"));
		Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand("banlist"));
		Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand("help"));
		self::$playerManager = new PlayerManager($this);
		self::$crateManager = new CrateManager($this);
		self::$factionsManager = new FactionsManager($this);
		self::$economyManager = new EconomyManager($this);
		self::$pexManager = new PexManager($this);
		self::$serverManager = new ServerManager($this);
		self::$kitUi = new KitUi($this);
		RegisterEvents::init();
		RegisterCommands::init();
		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}
	}


	public static function getInstance(): Main
	{
		return self::$instance;
	}

	public static function getPlayerManager(): PlayerManager
	{
		return self::$playerManager;
	}

	public static function getCrateManager(): CrateManager
	{
		return self::$crateManager;
	}

	public static function getInvMenu(): KitUi
	{
		return self::$kitUi;
	}


	public static function getFactionsManager(): FactionsManager
	{
		return self::$factionsManager;
	}

	public static function getEcoManager(): EconomyManager
	{
		return self::$economyManager;
	}

	public static function getPexManager(): PexManager
	{
		return self::$pexManager;
	}

	public static function getServerManager(): ServerManager
	{
		return self::$serverManager;
	}

	public function scoreboard()
	{
		$p = Main::getPlayerManager();
			foreach ($this->getServer()->getOnlinePlayers() as $players) {
				Scoreboard::removeScoreboard($players, "hcf");
				Scoreboard::createScoreboard($players, "   HCF| Map 1   ", "hcf");
			}
	}

	public function secondsTik(int $sec): int
	{
		return $sec * 20;
	}
}
