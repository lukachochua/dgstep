<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContactPage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'headline',
        'description',
        'feature_professional',
        'feature_guarantees',
        'cta_button',
        'cta_phone_href',
    ];

    public array $translatable = [
        'headline',
        'description',
        'feature_professional',
        'feature_guarantees',
        'cta_button',
    ];

    public static function defaults(): array
    {
        return [
            'headline' => [
                'en' => 'Contact us to get the service you need.',
                'ka' => 'სასურველი სერვისის მისაღებად დაგვიკავშირდით',
            ],
            'description' => [
                'en' => 'If you run a business and want to simplify your daily operations, contact us, our team will take care of implementing the processes you need.',
                'ka' => 'თუ მართავ ბიზნესს და გჭირდება ყოველდღიური პროცესების გამარტივება, დაგვიკავშირდი და ჩვენი გუნდი იზრუნებს სასურველი პროცესების დანერგვაზე.',
            ],
            'feature_professional' => [
                'en' => 'Professional support',
                'ka' => 'პროფესიონალური მხარდაჭერა',
            ],
            'feature_guarantees' => [
                'en' => 'Qualified Team',
                'ka' => 'გამოცდილი გუნდი',
            ],
            'cta_button' => [
                'en' => 'Contact Us',
                'ka' => 'დაგვიკავშირდით',
            ],
            'cta_phone_href' => '+9955XXXXXXX',
        ];
    }
}
