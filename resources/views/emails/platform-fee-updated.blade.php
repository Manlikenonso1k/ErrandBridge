<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1f2937;">
    <p>Hi {{ $user->name }},</p>

    <p>We wanted to keep you informed about a recent update to ErrandBridge's fee policy.</p>

    @if ($enabled)
        <p>Effective immediately, ErrandBridge will apply a {{ $percentage }}% platform service fee on completed errands. This fee is deducted from the errand budget before payment is released to the runner. The fee breakdown is always shown to both parties before confirmation.</p>
    @else
        <p>Great news — ErrandBridge is currently not charging any platform fees on completed errands. You keep 100% of your agreed errand value.</p>
    @endif

    <p>If you have any questions, reply to this email.</p>
    <p>— The ErrandBridge Team</p>
</body>
</html>