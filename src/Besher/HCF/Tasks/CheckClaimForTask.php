<?php

namespace Besher\HCF\Tasks;

use Besher\HCF\Main;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class CheckClaimForTask extends AsyncTask
{
	private $x1 = 0, $z1 = 0;
	private $x2 = 0, $z2 = 0;
	private $dir = "";
	public CONST FACTION = "§8[§cFaction§8] §7";
	private $player;

	public function __construct(int $x1, int $z1, int $x2, int $z2,string $dir, string $player) {
		$this->setX1($x1);
		$this->setZ1($z1);
		$this->setX2($x2);
		$this->setZ2($z2);
		$this->setPlayer($player);
		$this->setDir($dir);
	}

	public function setZ1(int $z1) {
		$this->z1 = $z1;
	}

	/**
	 * @param int $z2
	 */
	public function setZ2(int $z2) {
		$this->z2 = $z2;
	}

	/**
	 * Actions to execute when run
	 *
	 * @return void
	 */
	public function onRun() {
		$db = new \SQLite3($this->getDir());
		for($x = $this->getX1(); $x <= $this->getX2(); $x++) {
			for($z = $this->getZ1(); $z <= $this->getZ2(); $z++) {
				$result = $db->query("SELECT * FROM claim WHERE $x <= x1 AND $x >= x2 AND $z <= z1 AND $z >= z2;");
				$array = $result->fetchArray(SQLITE3_ASSOC);
				if(empty($array) == false) {
					$this->setResult(["claim" => false]);

					return;
					break;
				}
			}
		}
		$this->setResult(["claim" => true, "blocks" => 0, "cost" => 0]);
	}

	public function onCompletion(Server $server) {
		$f = Main::getFactionsManager();
		$player = $server->getPlayer($this->getPlayer());
		if($this->getResult()["claim"] == false) {

			$player->sendMessage(self::FACTION."You can't claim on another factions claims!");
		}else {
			$count = $this->getResult()["blocks"];
			$cost = $this->getResult()["cost"];

			$f->confirm[$player->getName()] = $f->claimSetup[$player->getName()];
			$f->cost[$player->getName()] = $cost;
			$player->sendMessage(self::FACTION."Set §esecond §7claim position. (§a{$cost}§7)\nto cancel claim type 'cancel' in chat");
			$player->sendMessage(TextFormat::GRAY."to cancel it, type in the chat 'cancel'.");
		}
	}

	public function getDir() : string {
		return $this->dir;
	}

	/**
	 * @param string $dir
	 */
	public function setDir(string $dir) {
		$this->dir = $dir;
	}

	public function getX1() : int {
		return $this->x1;
	}

	/**
	 * @param int $x1
	 */
	public function setX1(int $x1) {
		$this->x1 = $x1;
	}

	/**
	 * @return int
	 */
	public function getX2() : int {
		return $this->x2;
	}

	/**
	 * @param int $x2
	 */
	public function setX2(int $x2) {
		$this->x2 = $x2;
	}

	/**
	 * @return int
	 */
	public function getZ1() : int {
		return $this->z1;
	}

	/**
	 * @return int
	 */
	public function getZ2() : int {
		return $this->z2;
	}

	public function getPlayer() : string {
		return $this->player;
	}

	/**
	 * @param string $player
	 */
	public function setPlayer(string $player) {
		$this->player = $player;
	}

}