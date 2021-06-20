<?php


namespace Besher\HCF\Manager;


use Besher\HCF\Main;
use pocketmine\Player;

class EconomyManager
{

	public $plugin;

	private $money;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
		$this->money = new \SQLite3($this->plugin->getDataFolder() . "db/"  . "Economy.db");
		$this->money->query("CREATE TABLE IF NOT EXISTS economy(player TEXT PRIMARY KEY, money int, tokens int);");
	}

	public function getMoney(Player $player)
	{
		$name = $player->getName();
		$money = $this->money->query("SELECT money FROM economy WHERE player = '$name';");
		$result = $money->fetchArray(SQLITE3_ASSOC);
		return $result['money'] ?? null;
	}

	public function joinMoney(Player $player){
		$name = $player->getName();
		$this->money->exec("INSERT OR REPLACE INTO economy (player, money) VALUES ('$name', 0);");
	}

	public function setMoney(Player $player, $amount){
		$name = $player->getName();
		$this->money->exec("UPDATE economy SET money = $amount WHERE player = '$name';");
	}

	public function addMoney(Player $player, int $amount){
		$money = $this->getMoney($player);
		$name = $player->getName();
		$this->money->exec("UPDATE economy SET money = $money + $amount WHERE player = '$name';");
	}

	public function reduceMoney(Player $player, int $amount){
		$name = $player->getName();
		$money = $this->getMoney($player);
		$this->money->exec("UPDATE economy SET money = $money - $amount WHERE player = '$name';");

	}

}