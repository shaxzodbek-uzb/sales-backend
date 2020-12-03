<?php
namespace Sales\Core\Abstracts;

abstract class AbstractService {
    
    protected $repo;

    public function getById(int $id): Object
    {
        return $this->repo->getById($id);
    }
    
    public function getAll(): array
    {
        return $this->repo->getAll();
    }

}