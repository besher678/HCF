<?php


namespace Besher\HCF\Manager;

use Besher\HCF\Main;
use pocketmine\Player;

class PexManager
{
	private $plugin;
	private $pex;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
		$this->pex = new \SQLite3($this->plugin->getDataFolder() . "db/"  . "Pex.db");
		$this->pex->query("CREATE TABLE IF NOT EXISTS pexplayer(player TEXT PRIMARY KEY, ranks);");
		$this->pex->query("CREATE TABLE IF NOT EXISTS pex(ranks TEXT PRIMARY KEY, inheritance TEXT, permissions TEXT);");
	}

	public function createGroup(string $group)
	{
		$this->pex->exec("INSERT OR REPLACE INTO pex (ranks)VALUES('$group');");
	}

	public function addPermissionToGroup(string $group, string $permission)
	{
		$perms = $this->getPermissions($group);
		$this->pex->exec("UPDATE pex SET permissions = '$permission, $perms' WHERE ranks = '$group';");
	}

	public function addPlayerToGroup(string $name, string $group)
	{
		$this->pex->exec("INSERT OR REPLACE INTO pexplayer(player, ranks)VALUES('$name', '$group');");
	}

	public function addInheritanceToGroup(string $group, string $inheritance)
	{
		$this->pex->exec("UPDATE pex SET inheritance = '$inheritance' WHERE ranks = '$group';");
	}

	public function getPermissions(string $group)
	{
		$array = $this->pex->query("SELECT permissions FROM pex WHERE ranks = '$group';");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['permissions'] ?? null;
	}

	public function getGroups()
	{
		$array = $this->pex->query("SELECT * FROM pex");
		while($result = $array->fetchArray(SQLITE3_ASSOC)){
			return $result['group'] ?? null;
		}
	}

	public function getPlayersGroup(string $group)
	{
		$array = $this->pex->query("SELECT * FROM pex WHERE ranks = '$group';");
		while($result = $array->fetchArray(SQLITE3_ASSOC)){
			return $result['players'] ?? null;
		}
	}

	public function groupExists(string $group){
		$array = $this->pex->query("SELECT * FROM pex WHERE ranks = '$group'");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		if($result == null){
			return false;
		}
		return true;
	}

	public function getPlayerRank(string $name)
	{
		$array = $this->pex->query("SELECT ranks FROM pexplayer WHERE player = '$name'");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['ranks'] ?? "Default";
	}

	public function getServerStaff(string $name) : bool
	{
		$rank = $this->getPlayerRank($name);
		$array = $this->pex->query("SELECT permissions FROM pex WHERE ranks = '$rank'");
		$lol = $array->fetchArray(SQLITE3_ASSOC);
		$result = explode(", " ,$lol['permissions'] ?? null);
		foreach ($result as $perm){
			if($perm == "staff.see"){
				return true;
			}
			return false;
		}
	}
}