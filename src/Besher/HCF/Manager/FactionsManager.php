<?php

declare(strict_types=1);

namespace Besher\HCF\Manager;


use Besher\HCF\Main;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelChunkPacket;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class FactionsManager
{

	private $plugin;

	public $stepOne = [];
	public $stepTwo = [];
	public $stepThree = [];

	public $x1 = [];
	public $x2 = [];
	public $z1 = [];
	public $z2 = [];
	public $factions = [];

	public $factionChat = [];

	public $officerChat = [];

	const LEADER = 0;

	const COLEADER = 2;

	const OFFICER = 1;

	const MEMBER = 3;


	/**
	 * @var \SQLite3
	 */
	private $faction;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
		$this->faction = new \SQLite3($this->plugin->getDataFolder() . "db/"  . "Factions.db");
		$this->faction->exec("CREATE TABLE IF NOT EXISTS players(player TEXT PRIMARY KEY, rank INT, faction TEXT);");
		$this->faction->exec("CREATE TABLE IF NOT EXISTS factioninfo(faction TEXT PRIMARY KEY, dtr DOUBLE, balance INT, points DOUBLE);");
		$this->faction->exec("CREATE TABLE IF NOT EXISTS claim(faction TEXT PRIMARY KEY, x1 float, z1 float, x2 float, z2 float);");
		$this->faction->exec("CREATE TABLE IF NOT EXISTS confirm (player TEXT PRIMARY KEY COLLATE NOCASE,  faction TEXT);");
		$this->faction->exec("CREATE TABLE IF NOT EXISTS freeze(faction TEXT PRIMARY KEY, dtrfreeze BIGINT);");
		$this->faction->exec("CREATE TABLE IF NOT EXISTS fhome(faction TEXT PRIMARY KEY, x INT, y INT, z INT);");
	}

	public function createFaction(Player $player, string $faction)
	{
		$rank = self::LEADER;
		$name = $player->getName();
		$this->faction->exec("INSERT OR REPLACE INTO players(player, rank, faction) VALUES ('$name', $rank, '$faction');");
		$this->faction->exec("INSERT OR REPLACE INTO factioninfo(faction, dtr, balance, points) VALUES ('$faction', 1.1, 0, 0);");
		$this->plugin->getServer()->broadcastMessage(TF::RED."$name ".TF::GREEN."has created a team with the name ".TF::RED.$faction);
		$player->sendMessage(TF::GREEN."You have successfully created a team with the name $faction");
	}

	public function joinFaction(Player $player, string $faction)
	{
		$rank = self::MEMBER;
		$name = $player->getName();
		$this->faction->exec("INSERT OR REPLACE INTO players(player, rank, faction) VALUES ('$name', $rank, '$faction');");

	}

	public function inFaction(Player $player) : bool{
		$name = $player->getName();
		$array = $this->faction->query("SELECT faction FROM players WHERE player = '$name'");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		if($result == null){
			return false;
		}
		return true;
	}

	public function factionExists(string $faction) : bool{
		$array = $this->faction->query("SELECT * FROM factioninfo WHERE faction = '$faction'");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		if($result == null){
			return false;
		}
		return true;
	}

	public function isInvited(Player $player, string $faction) : bool{
		$array = $this->faction->query("SELECT player FROM confirm WHERE faction = '$faction'");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		if($result == null){
			return false;
		}
		return true;
	}

	public function getPlayerFaction(Player $player) :string{
		$name = $player->getName();
		$array = $this->faction->query("SELECT faction FROM players WHERE player = '$name'");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['faction'];
	}

	public function getFactionMemebers(string $faction){
		$players = [];
		$array = $this->faction->query("SELECT * FROM players WHERE faction = '$faction';");
		while($result = $array->fetchArray(SQLITE3_ASSOC)){
			$players[$result['player']] = $result['player'];
		}
		return $players;
	}

	public function getDtr(string $faction){
		$array = $this->faction->query("SELECT dtr FROM factioninfo WHERE faction = '$faction';");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['dtr'];
	}

	public function claimFor(string $faction, string $name)
	{
		if (!$this->factionExists($faction)) {
			unset($this->stepOne[$name]);
			$this->stepOne[$name] = $faction;
		}
	}

	public function setClaim(string $faction, int $x1, int $x2, int $z1, int $z2)
	{
		if($this->factionExists($faction)){
			$this->faction->exec("UPDATE claim SET x1 = $x1 WHERE faction ='$faction';");
			$this->faction->exec("UPDATE claim SET x2 = $x2 WHERE faction ='$faction';");
			$this->faction->exec("UPDATE claim SET z1 = $z1 WHERE faction ='$faction';");
			$this->faction->exec("UPDATE claim SET z2 = $z2 WHERE faction ='$faction';");
		}
		$this->faction->exec("INSERT OR REPLACE INTO claim(faction, x1, x2, z1, z2)VALUES('$faction' ,$x1, $x2, $z1, $z2);");
	}

	public function getLeader(string $faction)
	{
		$rank = self::LEADER;
		$array = $this->faction->query("SELECT rank FROM players WHERE faction ='$faction' WHERE rank = $rank;");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['player'] ?? null;
	}

	public function getOfficer(string $faction)
	{
		$rank = self::OFFICER;
		$array = $this->faction->query("SELECT player FROM players WHERE faction ='$faction' WHERE rank = $rank;");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['player'] ?? "null";
	}

	public function getCoLeader(string $faction)
	{
		$rank = self::COLEADER;
		$array = $this->faction->query("SELECT rank FROM players WHERE faction ='$faction' WHERE rank = $rank;");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['player'] ?? "null";
	}

	public function setHQ(string $faction, $x, $y, $z)
	{
		$this->faction->exec("INSERT INTO fhome(faction, x, y, z)VALUE('$faction', $x, $y, $z);");
	}

	public function inSpawnClaim(Vector3 $pos) : bool
	{
		$array = $this->faction->query("SELECT * FROM claim WHERE faction ='Spawn';");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		$x1 = $result['x1'];
		$x2 = $result['x2'];
		$z1 = $result['z1'];
		$z2 = $result['z2'];
		if ($x1 > 0) $x1 = -$x1;
		if ($x2 > 0) $x2 = -$x2;
		if ($z1 > 0) $z1 = -$z1;
		if ($z2 > 0) $z2 = -$z2;
		$x1 = max(intval($x1), intval(abs($x1)));
		$z1 = max(intval($z1), intval(abs($z1)));
		$x2 = min(intval($x2), intval(abs($x2)));
		$z2 = min(intval($z2), intval(abs($z2)));
		$x = $pos->getX();
		$z = $pos->getZ();
		if($x <= $x1 && $x >= $x2 && $z <= $z1 && $z >= $z2){
				return true;
			}
		return false;
	}

	public function inClaim(Vector3 $pos) {
		$x = $pos->getX();
		$z = $pos->getZ();
		$array = $this->faction->query("SELECT faction FROM claim WHERE $x <= x1 AND $x >= x2 AND $z <= z1 AND $z >= z2;");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['faction'] ?? null;
	}

}