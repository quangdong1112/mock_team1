<?php

namespace App\Services;

abstract class BaseService
{
    protected $repo;

    public function __construct()
    {
        $this->setRepository();
    }

    abstract public function getRepository();

    public function setRepository()
    {
        $this->repo = app()->make(
            $this->getRepository()
        );
    }

    public function index()
    {
        return $this->repo->index();
    }

    public function create($data = [])
    {
        return $this->repo->create($data);
    }

    public function model()
    {
        return $this->repo->model();
    }

    public function findOrFail($id)
    {
        return $this->repo->findOrFail($id);
    }

    public function update($id, $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
