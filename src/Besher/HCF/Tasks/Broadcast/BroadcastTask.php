<?php


namespace Besher\HCF\Tasks\Broadcast;

use Besher\HCF\Main;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class BroadcastTask extends Task
{

	public $message;
	public $time;

	/** @var Register */
	public $register;

	private $plugin;

	public function __construct($message, $time, Main $pg)
	{
		$this->message = $message;
		$this->time = $time;
		$this->plugin = $pg;
	}

	public function onRun(int $currentTick)
	{
		$message = $this->message;
		$time = $this->time;
		Server::getInstance()->broadcastMessage($message);
		$this->plugin->getScheduler()->scheduleDelayedRepeatingTask(new BroadcastTask($message, $time, $this->plugin), $this->secToTick($time), 20);
		$this->plugin->getScheduler()->cancelTask($this->getTaskId());
	}
	public function secToTick(int $sec): int
	{
		return $sec * 20;
	}
}
