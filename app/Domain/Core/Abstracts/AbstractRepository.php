<?php
namespace Sales\Core\Abstracts;

abstract class AbstractRepository
{
    public $entity;
    protected $listName = 'entities';
    protected $itemName = 'entity';
    protected $orderBy = 'id';
    protected $resourceClass;
    protected $orderType = 'asc';
    protected $withRelation = null;

    public function create($params): Object
    {
        $params['performed_at'] ??= now();
        return $this->entity->create($params);
    }
    
    public function getAll(): array
    {
        if($this->withRelation)
            $this->entity = $this->entity->with($this->withRelation);

        return [$this->listName => $this->resourceClass::collection($this->entity->orderBy($this->orderBy, $this->orderType)->get())];
    }
}