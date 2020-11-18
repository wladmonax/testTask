<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Notification.
 *
 * @package namespace App\Entities;
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $imageName
 * @property string $imagePath
 */
class Notification extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'imageName'
    ];

    /**
     * @return string|null
     */
    public function getImagePathAttribute()
    {
        if (File::exists(storage_path('app/public/images/' .$this->id.'/'. $this->imageName))) {
            return '/storage/images/'.$this->id.'/'. $this->imageName;
        }
        return '/assets/images/default-placeholder.png';
    }


}
