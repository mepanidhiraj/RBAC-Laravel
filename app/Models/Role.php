<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as SpatieRole;

use Spatie\Activitylog\Traits\LogsActivity;

use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends SpatieRolel
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logName = 'role';

    protected static $logAttributes = ['name', 'description']; 


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
