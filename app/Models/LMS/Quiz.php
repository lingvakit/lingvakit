<?php

declare(strict_types=1);

namespace App\Models\LMS;

use App\Models\MediaFile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Lang;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lms_quizzes';

    protected $fillable = ['uuid', 'title', 'description', 'image', 'audio', 'video',
        'type', 'duration', 'passing_score', 'topic_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id', 'lms_topics');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function audio()
    {
        return $this->hasOne(MediaFile::class, 'id', 'audio');
    }

    public function image()
    {
        return $this->hasOne(MediaFile::class, 'id', 'image');
    }

    public function video()
    {
        return $this->hasOne(MediaFile::class, 'id', 'video');
    }

    public function getImage() : string
    {
        if($this->image) {
            return $this->image()->first()->getPath();
        }
        return '/assets/cms/img/no-image.jpg';
    }

    public function getAudio() : bool|string
    {
        $audio = $this->audio()->first();
        if ($audio) {
            return $audio->getPath();
        }
        return false;
    }

    public function getVideoId() : string
    {
        $videoArr = explode('/', $this->video);
        return end($videoArr);
    }

    /**
     * @deprecated
     */
    public function getDuration() : string
    {
        return formatDuration($this);
    }

    public function getResult($user)
    {
        return Result::where([
            ['user_id', $user->id],
            ['topic_id', $this->topic->id],
        ])->first();
    }

    public function getTotalQuestions() : int
    {
        $totalQuestions = 0;

        $questions = $this->questions;

        foreach ($questions as $question) {
            if ($question->type !== 'matching') { $totalQuestions += count($question->conformities); }
            else { $totalQuestions += 1; }
        }

        return $totalQuestions;
    }

    public function getTotalPoints() : int
    {
        $total = 0;

        foreach ($this->questions as $question) {
            foreach ($question->conformities as $conformity) {
                $total += $conformity->points;
            }
        }
        return (int)$total;
    }

    public function getTotalScore($user) : float
    {
        $totalScore = false;
        $totalPoints = $this->getTotalPoints();
        $userPoints = 0;

        $result = $this->getResult($user);

        if ($result) {
            $resultPoints = ResultPoint::where('result_id', $result->id)->get();
            foreach ($resultPoints as $resultPoint) {
                $userPoints += $resultPoint->points;
            }
        }

        if ($userPoints) {
            $totalScore = round(($userPoints*100)/$totalPoints);
        }

        return $totalScore;
    }

    public function getUserScore($user) : float
    {
        $points = 0;
        $result = $this->getResult($user);

        if ($result) {
            $points = $result->points;
        }

        return round($points);
    }

    public function showUserScore($user) : string
    {
        $class = $this->getClassByResult($user);
        return '<span class="'.$class.'">'.$this->getUserScore($user).'</span> / '.$this->getTotalPoints();
    }

    public function getPassing($user) : string
    {
        $result = $this->getResult($user);

        if ($result) {
            return __('site-pages.'.$result->status). ' (' .$this->getTotalScore($user) . '%)';
        }

        return 'Вы еще не проходили этот тест!';
    }

    public function quizPassed($user) : bool
    {
        $result = $this->getResult($user);

        if ($result) { return true; }
        return false;
    }

    public function showTotalQuestions() : string
    {
        $num = $this->getTotalQuestions();

        $locale = Lang::getLocale();
        $word = __("site-pages.question");

        $words = [$word, $word.'s', $word.'s'];

        if ($locale === 'ru') {
            $words = [$word, $word.'а', $word.'ов'];
        }

        $questionQty = changeWordEnding($num, $words);

        return $num. ' ' .$questionQty;
    }

    public function getTotalTime()
    {
        return $this->duration*60;
    }

    public function getSpentTime($user) {

        $result = $this->getResult($user);
        if (!$result) { return false; }

        $startedAt = Carbon::parse($result->started_at);
        $finishedAt = Carbon::parse($result->finished_at);

        return $startedAt->diffInSeconds($finishedAt, false);
    }

    public function showSpentTime($user) : string
    {
        $totalSeconds = $this->getSpentTime($user);

        if ($totalSeconds) {
            $seconds = $totalSeconds % 60;
            $minutes = floor($totalSeconds / 60);
            if ($seconds < 10) { $seconds = '0' . $seconds; }

            return $minutes . ':' . $seconds;
        }
        return '0:00';
    }

    public function getClassByResult($user) : string
    {
        $totalPoints = $this->getTotalPoints();
        $passingPercent = $this->passing_score;
        $userPoints = $this->getTotalScore($user);
        $passingPoints = ($totalPoints * $passingPercent)/100;

        if ($userPoints < $passingPoints) {
            return 'text-danger';
        }
        return 'text-success';
    }
}
