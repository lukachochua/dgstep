<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactPageResource\Pages;
use App\Models\ContactPage;
use Illuminate\Support\HtmlString;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactPageResource extends Resource
{
    protected static ?string $model = ContactPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = 'Contact Page';
    protected static ?string $pluralModelLabel = 'Contact Page';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Runtime Status')
                ->description('These values come from runtime config, not from the CMS fields below.')
                ->schema([
                    Forms\Components\Placeholder::make('delivery_runtime')
                        ->label('Contact form health')
                        ->content(fn () => new HtmlString(static::runtimeStatusSummary())),
                ]),

            Forms\Components\Fieldset::make('Headline & Description')->schema([
                Forms\Components\TextInput::make('headline.en')->label('Headline (EN)')->required(),
                Forms\Components\TextInput::make('headline.ka')->label('Headline (KA)')->required(),
                Forms\Components\Textarea::make('description.en')->label('Description (EN)')->rows(3)->required(),
                Forms\Components\Textarea::make('description.ka')->label('Description (KA)')->rows(3)->required(),
            ])->columns(2),

            Forms\Components\Fieldset::make('Feature Badges')->schema([
                Forms\Components\TextInput::make('feature_professional.en')->label('Professional (EN)')->required(),
                Forms\Components\TextInput::make('feature_professional.ka')->label('Professional (KA)')->required(),
                Forms\Components\TextInput::make('feature_guarantees.en')->label('Guarantees (EN)')->required(),
                Forms\Components\TextInput::make('feature_guarantees.ka')->label('Guarantees (KA)')->required(),
            ])->columns(2),

            Forms\Components\Fieldset::make('CTA')->schema([
                Forms\Components\TextInput::make('cta_button.en')->label('CTA Button (EN)')->required(),
                Forms\Components\TextInput::make('cta_button.ka')->label('CTA Button (KA)')->required(),
                Forms\Components\TextInput::make('cta_phone_href')->label('CTA Phone (href)')->helperText('Used in tel: link')->tel(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('headline')
                    ->label('Headline (EN)')
                    ->formatStateUsing(fn(ContactPage $r) => $r->getTranslation('headline', 'en'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_phone_href')->label('Phone'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->since(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactPages::route('/'),
            'create' => Pages\CreateContactPage::route('/create'),
            'edit' => Pages\EditContactPage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $record = ContactPage::singleton();

        return static::getUrl('edit', ['record' => $record]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    protected static function runtimeStatusSummary(): string
    {
        $recaptchaSiteKey = trim((string) config('services.recaptcha.site_key'));
        $recaptchaSecret = trim((string) config('services.recaptcha.secret_key'));
        $opsTo = trim((string) config('mail.ops_to'));
        $mailer = trim((string) config('mail.default'));
        $resendKey = trim((string) config('services.resend.key'));
        $fromAddress = trim((string) config('mail.from.address'));
        $appHost = (string) parse_url((string) config('app.url'), PHP_URL_HOST);

        $lines = [
            static::statusLine(
                filled($recaptchaSiteKey) && filled($recaptchaSecret),
                'reCAPTCHA',
                filled($recaptchaSiteKey) && filled($recaptchaSecret)
                    ? "Configured for host check against {$appHost}."
                    : 'Missing site key or secret key.',
            ),
            static::statusLine(
                filled($opsTo) && filter_var($opsTo, FILTER_VALIDATE_EMAIL) && ! str_ends_with(strtolower($opsTo), '@example.com'),
                'Company recipient',
                filled($opsTo) ? $opsTo : 'Missing MAIL_OPS_TO value.',
            ),
            static::statusLine(
                static::mailerIsReady($mailer, $resendKey),
                'Mailer',
                static::mailerDetail($mailer, $resendKey, $fromAddress),
            ),
        ];

        return '<div class="space-y-2 text-sm">'.implode('', $lines).'</div>';
    }

    protected static function statusLine(bool $ok, string $label, string $detail): string
    {
        $tone = $ok ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400';
        $state = $ok ? 'OK' : 'Action needed';

        return sprintf(
            '<div><span class="font-semibold %s">%s:</span> <span class="font-medium">%s.</span> %s</div>',
            $tone,
            e($label),
            $state,
            e($detail),
        );
    }

    protected static function mailerIsReady(string $mailer, string $resendKey): bool
    {
        if ($mailer === 'resend') {
            return filled($resendKey);
        }

        return ! in_array($mailer, ['log', 'array'], true) && $mailer !== '';
    }

    protected static function mailerDetail(string $mailer, string $resendKey, string $fromAddress): string
    {
        return match ($mailer) {
            'resend' => filled($resendKey)
                ? "Resend configured. Verify that {$fromAddress} is a sender on your Resend account."
                : 'MAIL_MAILER is set to resend, but RESEND_API_KEY is missing.',
            'failover' => 'Failover is enabled. If the primary transport fails, Laravel can fall back to log.',
            'log', 'array' => "Mailer is {$mailer}, so no real email delivery will happen.",
            '' => 'Missing default mailer.',
            default => $mailer,
        };
    }
}
