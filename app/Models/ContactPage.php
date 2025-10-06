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
                'en' => 'Let’s talk about your operations',
                'ka' => 'მოდით, ვისაუბროთ თქვენს ოპერაციებზე',
            ],
            'description' => [
                'en' => 'Whether you run a pawnshop or a growing SMB, we help you streamline workflows, automate paperwork, and stay compliant.',
                'ka' => 'თუკი მართავთ ლომბარდს ან მზარდ SMB-ს, დაგეხმარებით პროცესების გამარტივებაში, დოკუმენტაციის ავტომატიზაციაში და რეგულაციებთან შესაბამისობაში.',
            ],
            'feature_professional' => [
                'en' => 'Professional support',
                'ka' => 'პროფესიონალური მხარდაჭერა',
            ],
            'feature_guarantees' => [
                'en' => 'Clear guarantees',
                'ka' => 'მკაფიო გარანტიები',
            ],
            'cta_button' => [
                'en' => 'Call DGstep',
                'ka' => 'დარეკეთ DGstep-ში',
            ],
            'cta_phone_href' => '+9955XXXXXXX',
        ];
    }
}
