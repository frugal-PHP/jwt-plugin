<?php

namespace FrugalPhpPlugin\JWT;

use Exception;
use Frugal\Core\Plugins\AbstractPlugin;
use Frugal\Core\Services\FrugalContainer;
use FrugalPhpPlugin\Jwtauth\Commands\InitJwtDatabase;
use FrugalPhpPlugin\Orm\Services\SqliteDatabase;

class Plugin extends AbstractPlugin
{
    public const PLUGIN_NAME = "JWT plugin";

    public static function init() : void
    {
        parent::init();
        self::checkEnvironmentVariables(["DATABASE_STORAGE_PATH"]);
        self::loadCommands([InitJwtDatabase::class]);
        
         // Check si tout est en place
        if(!file_exists(getenv('ROOT_DIR')."/".getenv('DATABASE_STORAGE_PATH'))) {
            throw new Exception("Le répertoire de stockage de la base de donnée n'est pas accessible");
        }
    }

    protected static function registerServices(): void
    {
        FrugalContainer::getInstance()->set('tokenOrm', fn() => new SqliteDatabase(getenv('ROOT_DIR').'/'.getenv('DATABASE_STORAGE_PATH').'/tokens.sqlite'));
    }
}