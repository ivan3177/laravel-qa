<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
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
        return $this->belongsTo(Question::class);
    }

    /**
     * Convert markdown stored in database into
     * HTML for human-readable output
     * @return html
     */
    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }
}
