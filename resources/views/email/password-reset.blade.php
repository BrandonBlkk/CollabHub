<div style="max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px;">
    <h2 style="color: #1a202c; font-size: 24px; margin-bottom: 20px;">
        Reset Your Password
    </h2>

    <p style="color: #4a5568; line-height: 1.6; margin-bottom: 24px;">
        You are receiving this email because we received a password reset request for your account.
        If you did not request a password reset, no further action is required.
    </p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $resetUrl }}"
            style="background: #3182ce; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: 500; display: inline-block;">
            Reset Password
        </a>
    </div>

    <p style="color: #718096; font-size: 14px; line-height: 1.5;">
        This password reset link will expire in 60 minutes.<br>
        If you're having trouble clicking the button, copy and paste this URL into your browser:
    </p>

    <p
        style="background: #f7fafc; padding: 12px; border-radius: 4px; word-break: break-all; font-family: monospace; font-size: 13px; color: #2d3748;">
        {{ $resetUrl }}
    </p>

    <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">

    <p style="color: #718096; font-size: 14px;">
        If you didn't request this, please ignore this email.<br>
        This is an automated message, please do not reply.
    </p>
</div>
