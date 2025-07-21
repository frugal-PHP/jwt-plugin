<?php

namespace FrugalPhpPlugin\Jwtauth\Repositories;

use DateInterval;
use DateTime;
use FrugalPhpPlugin\Jwtauth\Entities\RefreshTokenEntity;
use FrugalPhpPlugin\Orm\Entities\AbstractEntity;
use FrugalPhpPlugin\Orm\Helpers\HydratorHelper;
use FrugalPhpPlugin\Orm\Repositories\AbstractRepository;
use React\Promise\PromiseInterface;

class RefreshTokenRepository extends AbstractRepository
{
    public function getManagedEntityClass(): string 
    { 
        return RefreshTokenEntity::class;
    }

    /**
     * @param RefreshTokenEntity $entity 
     */
    public function create(AbstractEntity $entity): PromiseInterface
    {
        if($entity->expireAt === null) {
            $entity->expireAt = (new DateTime())->add(new DateInterval('PT2H'))->format("Y-m-d H:i:s");
        }

        return parent::create($entity);
    }

    public function findByUserId(string $userId) : PromiseInterface
    {
        $tableName = $this->getManagedEntityClass()::getTableName();
        $query = "SELECT * FROM ".$tableName." WHERE user_uuid=:userUuid";
        $parameters = ["userUuid" => $userId];

        return $this->db->execute($query, $parameters)
            ->then(function (array $rows) {
                $entities = array();
                $entityClass = $this->getManagedEntityClass();
                foreach($rows as $row) {
                    $entities[] = HydratorHelper::hydrate($row, new $entityClass);
                }

                return $entities;
            });
    }
    
}