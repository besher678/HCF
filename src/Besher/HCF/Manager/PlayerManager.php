<?php

declare(strict_types=1);

namespace Besher\HCF\Manager;

use Besher\HCF\Main;
use Besher\HCF\Tasks\ScoreBoard;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\GoldenApple;
use pocketmine\item\GoldenAppleEnchanted;
use Besher\HCF\Provider\Time;
use pocketmine\item\Item;
use pocketmine\Player;

class PlayerManager
{

	public $inventory = [];

	public $staffMode = [];

	private $Gcooldown;
	public $Ccooldown = array();
	private $Pcooldown;

	const GCOOLDOWN = 7200;
	const CCOOLDOWN = 120;
	const PCOOLDOWN = 15;

	const PLAYER = "Player"; //Default rank
	const RUBY = "Ruby"; //1$
	const RIOT = "Riot"; //$2
	const FLARE = "Flare"; //4$
	const CINDER = "Cinder"; //6$
	const EMBER = "Ember";// 10$
	const VIPER = "Viper";//15$
	const PYRO = "Pyro";//30$
	const TMOD = "T-Mod";
	const MOD = "Mod";
	const ADMIN = "Admin";
	const YOUTUBER = "YouTube";
	const FAMOUS = "Famous";
	const PARTNER = "Partner";
	const DEVELEPOR = "Developer";
	const MANAGER = "Manager";
	const OWNER = "Owner";


	public $plugin;
	/**
	 * @var \SQLite3
	 */
	private $player;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
		$this->player = new \SQLite3($this->plugin->getDataFolder() . "db/"  . "players.db");
		$this->player->query("CREATE TABLE IF NOT EXISTS player(player TEXT PRIMARY KEY, rank TEXT, permissions TEXT, warnings INT, uuid INT, kills INT, deaths INT, device TEXT);");
		$this->player->query("CREATE TABLE IF NOT EXISTS hcfdata(player TEXT PRIMARY KEY, pvpenabled INT, reclaim INT, deathban INT, Bard int, Miner int, Archer int, Rogue int, Diamond int, Master int, Builder int, Brewer int, Starter int);");
	}

	public function firstJoin(Player $player)
	{
		$name = $player->getName();
		$rank = self::PLAYER;
		$pvp = time() + 3600;
		$this->player->exec("INSERT OR REPLACE INTO player(player, rank)VALUES('$name', '$rank');");
		$this->player->exec("INSERT OR REPLACE INTO hcfdata(player, pvpenabled, Bard, Miner, Archer, Rogue, Diamond, Master, Builder, Brewer, Starter)VALUES('$name', $pvp, 0, 0, 0, 0, 0, 0, 0, 0, 0);");
	}

	public function getKitCooldownLeft(string $kit, Player $player)
	{
		$name = $player->getName();
		$array = $this->player->query("SELECT $kit FROM hcfdata WHERE player = '$name';");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result ?? null;
	}

	public function setDevice($name, $device)
	{
		echo $name;
		$this->player->exec("UPDATE player SET device ='$device' WHERE player = '$name';");
	}

	public function getDevice($name)
	{
		$array = $this->player->query("SELECT device FROM player WHERE player = '$name';");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['device'] ?? null;
	}

	public function deathBan(Player $player)
	{
		$name = $player->getName();
		$deathban = time() + 3600;
		$pvptimer = time() + 1800;
		$this->player->exec("UPDATE hcfdata SET deathban = $deathban WHERE player = '$name';");
		$this->player->exec("UPDATE hcfdata SET pvpenabled = $pvptimer WHERE player = '$name';");
	}

	public function startSotw(int $time)
	{
		$this->player->exec("INSERT OR REPLACE INTO sotw(sotw) VALUES ($time);");
	}

	public function getSotwTimer()
	{
		$sotw = $this->player->query("SELECT sotw FROM sotw;");
		$result = $sotw->fetchArray(SQLITE3_ASSOC);
		return $result['sotw'] ?? null;
	}

	public function setRank(Player $player, $rank)
	{
		$name = $player->getName();
		$this->player->exec("UPDATE player set rank = '$rank' WHERE player = '$name';");
	}

	public function endSotw()
	{
		$this->player->exec("DELETE FROM sotw;");
	}

	public function getPvpTimer(Player $player)
	{
		$name = $player->getName();
		$pvp = $this->player->query("SELECT pvpenabled FROM hcfdata WHERE player = '$name';");
		$result = $pvp->fetchArray(SQLITE3_ASSOC);
		return $result['pvpenabled'] ?? null;
	}

	public function removePvpTimer(Player $player)
	{
		$name = $player->getName();
		$this->player->exec("UPDATE hcfdata SET pvpenabled = null WHERE player = '$name';");
	}

	public function setPvpTimer(Player $player)
	{
		$name = $player->getName();
		$time = time() + 3600;
		$this->player->exec("UPDATE hcfdata SET pvpenabled = $time WHERE player = '$name'");
	}

	public function setStaff(string $name)
	{
		$this->staffMode[$name] = $name;
	}

	public function getAllStaff()
	{
		return $this->staffMode;
	}
}