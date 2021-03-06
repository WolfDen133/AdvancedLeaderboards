<?php

namespace Rushil13579\AdvancedLeaderboards\Commands;

use pocketmine\{
    Server,
    Player
};

use pocketmine\command\{
    Command,
    CommandSender
};

use Rushil13579\AdvancedLeaderboards\Main;

class StatsCommand extends Command {

    private $main;

    public function __construct(Main $main){
        $this->main = $main;

        parent::__construct('stats', 'Shows your server statistics');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player){
            $sender->sendMessage($this->main->formatMessage($this->main->cfg->get('not-player-msg')));
            return false;
        }

        if(!isset($args[0])){
            $msg = $this->main->formatMessage($this->main->cfg->get('stats-msg'));
            $sender->sendMessage($this->main->generateStatsMsg($sender, $msg));
            return false;
        }

        if($this->main->getServer()->getPlayer($args[0]) === null or !$this->main->getServer()->getPlayer($args[0])->isOnline()){
            $sender->sendMessage($this->main->formatMessage($this->main->cfg->get('invalid-player-msg')));
            return false;
        }

        $player = $this->main->getServer()->getPlayer($args[0]);

        $msg = $this->main->formatMessage($this->main->cfg->get('stats-msg'));
        $sender->sendMessage($this->main->generateStatsMsg($player, $msg));
    }
}