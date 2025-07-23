<?php

namespace FrugalPhpPlugin\Jwt\Commands;

use Frugal\Core\Commands\AbstractCommand;
use Frugal\Core\Services\FrugalContainer;

use function React\Async\await;

class InitJwtDatabase extends AbstractCommand
{
    public static function run() 
    { 
        $sql = file_get_contents(__DIR__."/../../database/schema.sql");
        await(FrugalContainer::getInstance()->get('tokenOrm')->execute($sql)->then(function() {
            FrugalContainer::getInstance()->get('tokenOrm')->close();
        }));
    }
    
}