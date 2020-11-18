<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Quote
 * @package App\Models
 *
 * @property int $character_id
 * @property int $episode_id
 * @property string $quote
 *
 * Relationships:
 * @property Character $character
 * @property Episode $episode
 */
class Quote extends Model
{
    use HasFactory;

    /** @var string  */
    protected $table = 'quotes';

    /** @var array */
    protected $fillable = [
        'character_id',
        'episode_id',
        'quote',
    ];

    /** @var bool  */
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function episode()
    {
        return $this->belongsTo(Episode::class, 'episode_id', 'id');
    }
}
