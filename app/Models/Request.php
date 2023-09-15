<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Request extends Model
{
    use HasFactory;

    public const ACTIVE = 'active';
    public const RESOLVED = 'resolved';

    protected $fillable = [
        'message',
    ];

    private function isAnswerResolved()
    {
        return $this->status === self::RESOLVED;
    }

    public function addAnswer($answer)
    {
        if(!Gate::allows('canAddAnswer', Auth::user())) {
            throw new Exception('Вы не имеете право добавить ответ');
        }

        if($this->isAnswerResolved()) {
            throw new Exception('Ответ уже добавлен');
        }

        $this->status = self::RESOLVED;
        $this->answer = $answer;
        $this->save();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
