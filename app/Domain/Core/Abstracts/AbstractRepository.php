<?php
namespace Sales\Core\Abstracts;

abstract class AbstractRepository
{
    public $entity;
    protected $listName = 'entities';
    protected $itemName = 'entity';
    protected $resourceClass;

    public function create($params): Object
    {
        $params['performed_at'] ??= now();
        return $this->entity->create($params);
    }
    
    public function getAll(): array
    {
        return [$this->listName => $this->resourceClass::collection($this->entity->orderBy('name')->get())];
    }
}