<?php

namespace blackjack200\itemdictionary;


use pocketmine\plugin\PluginBase;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\convert\ItemTypeDictionary;
use ReflectionClass;
use ReflectionProperty;

class Tools extends PluginBase {
	public function onEnable() : void {
		$instance = ItemTypeDictionary::getInstance();
		$klass = new ReflectionClass(ItemTypeDictionary::class);
		$l = $klass->getProperty('intToStringIdMap');
		$l->setAccessible(true);
		$r = $klass->getProperty('stringToIntMap');
		$r->setAccessible(true);
		$path = $this->getDataFolder();
		$this->dump($path, $l, $instance);
		$this->dump($path, $r, $instance);
	}

	private function dump(string $path, ReflectionProperty $l, ItemTypeDictionary $instance) : void {
		$name = sprintf("%s_%s.json", ProtocolInfo::CURRENT_PROTOCOL, $l->getName());
		file_put_contents($path . $name, json_encode($l->getValue($instance), JSON_THROW_ON_ERROR));
		$this->getLogger()->notice("DUMP: $name");
	}
}
