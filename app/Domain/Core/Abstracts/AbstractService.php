<?php
namespace Sales\Core\Abstracts;

abstract AbstractService {
    
    protected $repo;

    public function getById(int $id): Object
    {
        return $this->repo->getById($id);
    }

}