<?php

namespace Modules\Stores\Repositories\Contracts;


interface BaseRepository
{

    public function all($params = null);

    public function find($id);

    public function add($object);

    public function update($object, $id);

    public function delete($id);


}