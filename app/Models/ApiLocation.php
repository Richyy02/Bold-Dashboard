<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * @property string $uri
 * @property string $api_key
 * @property string $slug
 */
class ApiLocation extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return "slug";
    }

    /**
     * @return array|stdClass
     */
    public function getData(): null
    {
        return null;
//        ');
//    }
    }
}
