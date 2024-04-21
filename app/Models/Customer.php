<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function route($name, $parameters = [], $absolute = true) {
        return app('url')->route($name, array_merge([$this->slug], $parameters), $absolute);
    }

    

}