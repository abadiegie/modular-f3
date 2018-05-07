<?php
namespace Modules\Main\Model;

use App\Core\F3\BaseModel;


class UserModel extends BaseModel
{
    protected $table = 'user';

    public function getAll()
    {
        return $this->mapper()->load();
    }
}
