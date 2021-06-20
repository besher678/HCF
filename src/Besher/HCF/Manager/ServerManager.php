<?php


namespace Besher\HCF\Manager;


use Besher\HCF\Main;

class ServerManager
{

	private $plugin;
	private $server;

	public function __construct(Main $pg)
	{
		$this->plugin = $pg;
		$this->server = new \SQLite3($this->plugin->getDataFolder() . "db/"  . "Server.db");
		$this->server->query("CREATE TABLE IF NOT EXISTS server(border int);");
	}

	public function setBorder($border)
	{
		$this->server->exec("INSERT OR REPLACE INTO server(border) VALUES ($border);");
	}

	public function getBorder()
	{
		$array = $this->server->query("SELECT border FROM server");
		$result =  $array->fetchArray(SQLITE3_ASSOC);
		return $result['border'] ?? 1;
	}

}