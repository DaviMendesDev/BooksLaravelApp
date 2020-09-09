<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use DateTime;

class Books extends Model
{
    use SoftDeletes;
    public $table = 'books';

    public $fillable = [
        'id_publisher',
        'title',
        'cover',
        'synopsis',
        'category',
        'publishing_company',
        'author',
        'edition',
        'year',
        'page_numbers',
        'favorites'
    ];

    public $timestamps = true;

    public static function creationRules() {
        $current_date = new DateTime('now');
        $current_year = $current_date->format('Y');

        return [
            'id_publisher' => ['numeric', 'required', 'exists:users,id'],
            'title' => ['string', 'required', 'max:50', 'min:3'],
            'cover'=> ['file', 'nullable'],
            'synopsis' => ['string', 'required', 'max:500', 'min:3'],
            'category' => ['string', 'required', 'max:30', 'min:3'],
            'publishing_company' => ['string', 'required', 'max:40', 'min:3'],
            'author' => ['string', 'required', 'max:50', 'min:3'],
            'edition' => ['string', 'required', 'max:20', 'min:1'],
            'year' => ['numeric', 'required', 'max:' . $current_year, 'min:1960'],
            'page_numbers' => ['numeric', 'required', 'min:1']
        ];
    }

    public static function editRules() {
        $current_date = new DateTime('now');
        $current_year = $current_date->format('Y');

        return [
            'id_publisher' => ['numeric', 'exists:users,id'],
            'title' => ['string', 'max:50', 'min:3'],
            'cover'=> ['file', 'nullable'],
            'synopsis' => ['string', 'max:500', 'min:3'],
            'category' => ['string', 'max:30', 'min:3'],
            'publishing_company' => ['string', 'max:40', 'min:3'],
            'author' => ['string', 'max:50', 'min:3'],
            'edition' => ['string', 'max:20', 'min:1'],
            'year' => ['numeric', 'max:' . $current_year, 'min:1960'],
            'page_numbers' => ['numeric', 'min:1']
        ];
    }

    public static function creationValidator(array $values) {
        return Validator::make($values, self::creationRules());
    }

    public static function editValidator(array $values) {
        return Validator::make($values, self::editRules());
    }

    public static function getMostTrendedBooks(int $limit = 20) {
        return Books::select()->orderBy('favorites', 'DESC')
                              ->orderBy('created_at', 'DESC')
                              ->limit($limit);
    }

    public function getCreatorId() {
        return $this->id_publisher;
    }

    public function isThisUserThePublisher(User $user) {
        return $user->id == $this->getCreatorId();
    }

    public function isNotThisUserThePublisher(User $user) {
        return ! $this->isThisUserThePublisher($user);
    }
}
