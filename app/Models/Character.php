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
 * @property string $name
 * @property Date $birthday
 * @property string $occupations
 * @property string $img
 * @property string $nickname
 * @property string $portrayed
 *
 * Relationships:
 * @property Quote[] $quotes
 * @property Episode[] $episodes
 */
class Character extends Model
{
    use HasFactory;

    /** @var string  */
    protected $table = 'characters';

    /** @var array */
    protected $fillable = [
        'name',
        'birthday',
        'occupations',
        'img',
        'nickname',
        'portrayed',
    ];

    /**
     * @return HasMany
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class, 'character_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function episodes()
    {
        return $this->belongsToMany(
                                Episode::class,
                                'character_episode',
                                'character_id',
                                'episode_id',
                                'id',
                                'id'
        );
    }
}
