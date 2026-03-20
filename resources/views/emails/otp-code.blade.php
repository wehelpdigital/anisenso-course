<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 480px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #4a7c2a 0%, #3d6b1f 100%); padding: 32px 24px; text-align: center;">
                            <span style="font-size: 32px;">🌾</span>
                            <h1 style="margin: 8px 0 0; color: #ffffff; font-size: 24px; font-weight: 700;">
                                <span style="color: #f5c518;">Ani</span><span style="color: #ffffff;">Senso</span>
                            </h1>
                            <p style="margin: 4px 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">Academy</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 32px 24px;">
                            <h2 style="margin: 0 0 16px; color: #1a1a1a; font-size: 20px; font-weight: 600;">
                                Password Reset Request
                            </h2>

                            <p style="margin: 0 0 24px; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                Hi {{ $userName }},
                            </p>

                            <p style="margin: 0 0 24px; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                We received a request to reset your password. Use the verification code below to continue:
                            </p>

                            <!-- OTP Code Box -->
                            <div style="background-color: #fef9e7; border: 2px solid #f5c518; border-radius: 12px; padding: 24px; text-align: center; margin: 0 0 24px;">
                                <p style="margin: 0 0 8px; color: #6b7280; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                                    Your Verification Code
                                </p>
                                <p style="margin: 0; color: #1a1a1a; font-size: 36px; font-weight: 700; letter-spacing: 8px; font-family: 'Courier New', monospace;">
                                    {{ $otpCode }}
                                </p>
                            </div>

                            <p style="margin: 0 0 16px; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                <strong style="color: #dc2626;">⏱ This code expires in {{ $expiryMinutes }} minutes.</strong>
                            </p>

                            <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                If you didn't request a password reset, please ignore this email or contact support if you have concerns.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 24px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 8px; color: #6b7280; font-size: 13px;">
                                Ani-Senso Academy
                            </p>
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                Dragon Scale Web Company
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Security Notice -->
                <p style="max-width: 480px; margin: 24px auto 0; color: #9ca3af; font-size: 12px; text-align: center; line-height: 1.5;">
                    For security reasons, never share this code with anyone. Ani-Senso Academy staff will never ask for your verification code.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
