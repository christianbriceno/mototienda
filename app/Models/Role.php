<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    const NAME_SUPER_ADMIN   = "Super Admin";
    const NAME_ADMIN         = "Administrador";
    const NAME_SELLER        = "Vendedor";
    const NAME_CLIENT        = "Cliente";
    const NAME_GUEST         = "Invitado";

    const LEVEL_SUPER_ADMIN   = 0;
    const LEVEL_ADMIN         = 1;
    const LEVEL_SELLER        = 2;
    const LEVEL_CLIENT        = 3;
    const LEVEL_GUEST         = 4;
}
