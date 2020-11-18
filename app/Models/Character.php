<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 */
class Character extends Model
{
    use HasFactory;

    protected $table = 'characters';

    protected $fillable = [
        'name',
        'birthday',
        'occupations',
        'img',
        'nickname',
        'portrayed',
    ];
}
