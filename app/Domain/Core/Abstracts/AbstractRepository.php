<?php
namespace Sales\Core\Abstracts;

abstract class AbstractRepository
{
    public $entity;

    public function create($params): Object
    {
        $params['performed_at'] = now();
        return $this->entity->create($params);
    }
}