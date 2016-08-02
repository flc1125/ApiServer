<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Apps应用表模型
 *
 * @author Flc <2016-8-1 10:22:05>
 */
class App extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'apps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'app_id', 'app_secret', 'app_name', 'app_desc', 'status', 'created_at', 'updated_at'
    ];

}
