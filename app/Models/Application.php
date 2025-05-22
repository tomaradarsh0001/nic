<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['applicationData'];

    public function applicationData()
    {
        $modelClass = '\\App\\Models\\' . $this->model_name;
        if (!class_exists($modelClass)) {
            throw new \Exception("The model class {$modelClass} does not exist.");
        }

        return $this->hasOne($modelClass, 'id', 'model_id');
    }

    public function applicationStatuses()
    {
        return $this->hasOne(ApplicationStatus::class, 'reg_app_no', 'application_no');
    }
}
