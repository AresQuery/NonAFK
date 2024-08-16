<?php

namespace AresQuery\NonAFK\tasks;

use AresQuery\NonAFK\Main;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class nonAFKTask extends Task {

    private Main $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onRun(): void { 
        foreach ($this->main->afkTime as $playername => $time) {
            $player = Server::getInstance()->getPlayerExact($playername);
            if($player !== null) {
                $now = new \DateTime("now", new \DateTimeZone($this->main->getConfig()->get('time.zone')));
                if ($time < $now) {
                    if(!$player->hasPermission("nonafk.bypass")) {
                        $player->kick($this->main->getConfig()->get('kick.message'));
                    }
                }
            }
        }
    }
}
