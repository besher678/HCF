<?php


namespace Besher\HCF\Manager;

use Besher\HCF\Main;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;
use SQLite3;

class CrateManager
{

	public $info;

	public $plugin;

	private $crate;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
		$this->crate = new SQLite3($this->plugin->getDataFolder() . "db/" . "Crate.db");
		$this->crate->query("CREATE TABLE IF NOT EXISTS crates(crate TEXT PRIMARY KEY, display TEXT, hologram TEXT, openMessage TEXT, openBroadcast TEXT, item int, itemName TEXT, itemLore TEXT, x int, y int, z int);");
	}

	public function createCrate(string $crate)
	{
		$this->crate->exec("INSERT OR REPLACE INTO crates(crate) VALUES ('$crate');");
	}

	public function addX(string $crate, $x)
	{
		$this->crate->exec("UPDATE crates SET x = $x WHERE crate = '$crate';");
	}

	public function addY(string $crate, $y)
	{
		$this->crate->exec("UPDATE crates SET y = $y WHERE crate = '$crate';");
	}

	public function addZ(string $crate, $z)
	{
		$this->crate->exec("UPDATE crates SET z = $z WHERE crate = '$crate';");
	}

	public function addDisplay(string $crate, string $display)
	{
		$this->crate->exec("UPDATE crates SET display = '$display' WHERE crate = '$crate';");
	}

	public function addHologram(string $crate, string $hologram)
	{
		$this->crate->exec("UPDATE crates SET hologram = '$hologram' WHERE crate = '$crate';");
	}

	public function getAllLocations()
	{

	}

	public function crateExists(string $crate): bool
	{
		$array = $this->crate->query("SELECT * FROM crates WHERE crate = '$crate'");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		if ($result == null) {
			return false;
		}
		return true;
	}

	public function loadFloatingText()
	{
		foreach ($this->getCrates() as $crate) {
			$loc = $this->getLocation($crate);
			$level = $this->plugin->getServer()->getLevelByName("stop");
			$this->plugin->getServer()->loadLevel("stop");
			$x = $loc["{$crate}x"] + 0.5; //+ to center to block
			$y = $loc["{$crate}y"] + 0.7; //+ to center to block
			$z = $loc["{$crate}z"] + 0.5; //+ to center to block
			$display = $this->getDisplay($crate); //Display name
			$hologram = $this->getHologram($crate); //ex. "Right click to open crate\nLeft click to preview rewards"
			$level->addParticle(new FloatingTextParticle(new Vector3($x, $y, $z), str_replace("{line}", TextFormat::EOL, $hologram), $display));
		}
	}

	public function getCrates()
	{
		$crate = [];
		$array = $this->crate->query("SELECT * FROM crates;");
		while ($result = $array->fetchArray(SQLITE3_ASSOC)) {
			$crate[] = $result['crate'];
		}
		return $crate;
	}

	public function getLocation(string $crate)
	{
		$pos = [];
		$array = $this->crate->query("SELECT * FROM crates WHERE crate = '$crate';");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		$pos["{$crate}x"] = $result['x'];
		$pos["{$crate}y"] = $result['y'];
		$pos["{$crate}z"] = $result['z'];
		return $pos;
	}

	public function getDisplay(string $crate): string
	{
		$array = $this->crate->query("SELECT display FROM crates WHERE crate = '$crate';");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return $result['display'] ?? "test";
	}

	public function getHologram(string $crate): string
	{
		$array = $this->crate->query("SELECT hologram FROM crates WHERE crate = '$crate';");
		$result = $array->fetchArray(SQLITE3_ASSOC);
		return (string)$result['hologram'] ?? "Test";
	}
}