<?php
declare(strict_types=1);

namespace App\Models\LMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lms_stages';

    protected $fillable = ['name', 'course_id'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'stage_id');
    }

    /**
     * @deprecated Создание модулей идёт через CreateModuleHandler + ModuleRepository.
     */
    public static function add($fields, $course)
    {
        $stage = new static();
        $stage->fill($fields);
        $stage->course_id = $course->id;
        $stage->save();

        return $stage;
    }
}
