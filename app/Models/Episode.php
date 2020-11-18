<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;

/**
 * Class Character
 * @package App\Models
 *
 * @property string $title
 * @property Date $air_date
 *
 * Relationships:
 * @property Quote[] $quotes
 * @property Character[] $characters
 */
class Episode extends Model
{
    use HasFactory;

    /** @var string */
    protected $table = 'episodes';

    /** @var array */
    protected $fillable = [
        'title',
        'air_date',
    ];

    /**
     * @return HasMany
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class, 'episode_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function characters()
    {
        return $this->belongsToMany(
                                Character::class,
                                'character_episode',
                                'episode_id',
                                'character_id',
                                'id',
                                'id'
        );
    }
}
