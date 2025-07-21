<?php

namespace FrugalPhpPlugin\Jwt\Commands;

use Frugal\Core\Commands\AbstractCommand;
use Frugal\Core\Services\FrugalContainer;
use FrugalPhpPlugin\JWT\Plugin;

class InitJwtDatabase extends AbstractCommand
{
    public static function run() 
    { 
        $sql = file_get_contents(Plugin::PLUGIN_ROOT_PATH."/database/schema.sql");
        FrugalContainer::getInstance()->get('tokenOrm')->execute($sql);
    }
    
}