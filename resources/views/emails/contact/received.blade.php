@php
    $s = $submission;
    $fontFamily = "'Calibri', 'Segoe UI', system-ui, sans-serif";
    $rows = [
        [
            'label' => 'When',
            'value' => optional($s->created_at)->format('Y-m-d H:i:s') ?? 'n/a',
        ],
        [
            'label' => 'Name',
            'value' => trim(collect([$s->name, $s->surname])->filter()->implode(' ')) ?: 'n/a',
        ],
        [
            'label' => 'Phone',
            'value' => $s->phone ?: 'n/a',
        ],
        [
            'label' => 'Locale',
            'value' => $s->locale ?: 'n/a',
        ],
        [
            'label' => 'IP Address',
            'value' => $s->ip_address ?: 'n/a',
        ],
    ];
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0;padding:0;background-color:#f3f4f6;">
    <tr>
        <td align="center" style="padding:32px 16px;font-family:{{ $fontFamily }};">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;width:100%;background-color:#ffffff;border-radius:16px;border:1px solid #e5e8ea;overflow:hidden;box-shadow:0 24px 64px rgba(91,86,214,0.14);color:#111827;">
                <tr>
                    <td style="padding:24px 28px 20px;background-color:#5b56d6;color:#ffffff;">
                        <p style="margin:0;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;opacity:0.85;">DGstep</p>
                        <h1 style="margin:6px 0 0;font-size:22px;line-height:1.3;font-weight:700;">New Contact Submission</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px 28px 24px;">
                        <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#475569;">
                            A new inquiry just came in through the website contact form. Here is a quick summary so you can follow up without logging in.
                        </p>

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0 0 4px;">
                            @foreach ($rows as $index => $row)
                                <tr>
                                    <td style="padding:10px 0;width:180px;font-size:12px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:#64748b;{{ $index < count($rows) - 1 ? 'border-bottom:1px solid #e5e8ea;' : '' }}">
                                        {{ $row['label'] }}
                                    </td>
                                    <td style="padding:10px 0;font-size:15px;color:#111827;{{ $index < count($rows) - 1 ? 'border-bottom:1px solid #e5e8ea;' : '' }}">
                                        {{ $row['value'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        @if ($s->comments)
                            <div style="margin:24px 0 0;padding:18px 20px;border-radius:12px;background-color:#f0effd;border:1px solid #dcd8fb;">
                                <p style="margin:0 0 8px;font-size:12px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:#5b56d6;">Comments</p>
                                <p style="margin:0;font-size:15px;line-height:1.6;color:#1f2937;white-space:pre-line;">
                                    {{ $s->comments }}
                                </p>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 28px 24px;background-color:#f8f7ff;border-top:1px solid rgba(91,86,214,0.18);">
                        <p style="margin:0;font-size:13px;line-height:1.5;color:#61646f;">
                            DGstep · Automated notification — You are receiving this because your address is configured for contact form alerts.
                        </p>
                        <p style="margin:8px 0 0;font-size:12px;color:#9aa0a6;">
                            Need to change these emails? Update your notification preferences in the admin dashboard.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
