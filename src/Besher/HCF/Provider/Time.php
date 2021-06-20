<?php

namespace Besher\HCF\Provider;

class Time{

	public static function intToTime(int $int): string {
		$days = 0;
		$hours = 0;
		$minutes = 0;
		$seconds = floor($int % 60);
		if($int >= 60){
			$minutes = floor(($int % 3600) / 60);
			if($int >= 3600){
				$hours = floor(($int % (3600 * 24)) / 3600);
				if($int >= 3600 * 24){
					$days = floor($int / (3600 * 24));
				}
			}
		}
		return $days . "d, " . $hours . "h, " . $minutes . "m, " . $seconds . "s";
	}
	/**
	 * @param int $int
	 * @return string
	 */
	public static function intToString(int $int): string {
		$minutes = floor($int / 60);
		$seconds = floor($int % 60);
		return (($minutes < 10 ? "0" : "") . $minutes . ":" . ($seconds < 10 ? "0" : "").  $seconds);
	}
	/**
	 * @param int $time
	 * @return string
	 */
	public static function intToFullString(int $time): string {
		$hours = null;
		$minutes = null;
		$seconds = floor($time % 60);
		if($time >= 60){
			$minutes = floor(($time % 3600) / 60);
			if($time >= 3600){
				$hours = floor(($time % (3600 * 24)) / 3600);
			}
		}
		return ($minutes !== null ? ($hours !== null ? ($hours < 10 ? "0" : "") . "$hours" . ":" : "") . ($minutes < 10 ? "0" : "") . "$minutes" . ":" : "") . ($seconds < 10 ? "0" : "") . "$seconds";
	}
}