<?php

declare(strict_types=1);

namespace Besher\HCF\Tasks;

use Besher\HCF\Main;
use pocketmine\scheduler\Task;

class ScoreBoardTask extends Task{

	public $plugin;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
	}

	public function onRun(int $currentTick) : void
	{
		$this->plugin->scoreboard();
	}

}