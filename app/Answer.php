<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Answer;

class Answer extends Model
{
    use Traits\VotableTrait;
    protected $fillable = ['body', 'user_id'];

    protected $appends = [
      'created_date'
    ];

    /**
     * Setup model's lifetime events handling
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        /**
         * Answer cretion callback
         * Incement question's answers count due to
         * new answer created
         * @var App\Answer
         */
        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });

        /**
         * Answer deletion callback
         * Deccrement question's answers count due to
         * answer deletion
         * @var App\Answer
         */
        static::deleted(function ($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    /**
     * Return questions to which answer belongs
     * @return App\Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Return user to whom answer belongs
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Convert markdown stored in database into
     * HTML for human-readable output
     * @return mixed
     */
    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    /**
     * Get human-readable date
     * @return mixed
     */
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get answer's status
     * @return boolval
     */
    public function getStatusAttribute()
    {
        return $this->is_best ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->id == $this->question->best_answer_id;
    }
}
