<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc - Invitation</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Rubik', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            background-color: #f8f8f8;
            color: #4F5665;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background-color: #0B132A;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 24px;
            font-weight: 700;
            color: #0B132A;
            margin-bottom: 15px;
        }
        .description {
            font-size: 15px;
            color: #4F5665;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .cta-button {
            display: inline-block;
            background-color: #F53855;
            color: #ffffff;
            padding: 14px 40px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 30px 0;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            background-color: #e02a47;
            box-shadow: 0px 20px 20px -15px rgba(245,56,56,0.81);
        }
        .token-box {
            background-color: #FFECEC;
            border-left: 4px solid #F53855;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .token-label {
            font-size: 12px;
            color: #AFB5C0;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .token-value {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: 700;
            color: #F53855;
            word-break: break-all;
        }
        .link-section {
            margin: 30px 0;
            padding: 20px;
            background-color: #F8F8F8;
            border-radius: 8px;
            border: 1px solid #EEEFF2;
        }
        .link-label {
            font-size: 12px;
            color: #AFB5C0;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .link-value {
            font-size: 13px;
            color: #F53855;
            word-break: break-all;
            font-family: 'Courier New', monospace;
        }
        .expiry-notice {
            background-color: #FFF3CD;
            border-left: 4px solid #FFC107;
            padding: 15px 20px;
            margin: 30px 0;
            border-radius: 8px;
            font-size: 14px;
            color: #856404;
        }
        .expiry-notice strong {
            display: block;
            margin-bottom: 5px;
            color: #0B132A;
        }
        .divider {
            height: 1px;
            background-color: #EEEFF2;
            margin: 30px 0;
        }
        .benefits {
            margin: 20px 0;
        }
        .benefits-title {
            font-size: 14px;
            font-weight: 600;
            color: #0B132A;
            margin-bottom: 12px;
        }
        .benefits ul {
            list-style: none;
            padding: 0;
        }
        .benefits li {
            font-size: 14px;
            color: #4F5665;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }
        .benefits li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #2FAB73;
            font-weight: 700;
        }
        .footer {
            background-color: #F8F8F8;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #EEEFF2;
        }
        .footer-text {
            font-size: 12px;
            color: #AFB5C0;
            margin: 0;
        }
        .footer-link {
            color: #F53855;
            text-decoration: none;
        }
        .footer-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏠 EasyColoc</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p class="greeting">You're Invited!</p>
            
            <p class="description">
                Great news! You've been invited to join a colocation community on EasyColoc. 
                Click the button below to accept the invitation and start managing your shared living space.
            </p>

            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="{{ $link }}" class="cta-button">Accept Invitation</a>
            </div>

            <!-- Token Box -->
            <div class="token-box">
                <div class="token-label">Invitation Token</div>
                <div class="token-value">{{ $invitation->token }}</div>
            </div>

            <!-- Link Section -->
            <div class="link-section">
                <div class="link-label">Or use this link</div>
                <div class="link-value">{{ $link }}</div>
            </div>

            <!-- Expiry Notice -->
            @if($invitation->expires_at)
            <div class="expiry-notice">
                <strong>⏰ Invitation Expires</strong>
                {{ $invitation->expires_at->format('F d, Y \a\t H:i') }}
            </div>
            @endif

            <div class="divider"></div>

            <!-- Benefits -->
            <div class="benefits">
                <p class="benefits-title">What you can do with EasyColoc:</p>
                <ul>
                    <li>Manage shared expenses easily</li>
                    <li>Track payments and settlements</li>
                    <li>Communicate with colocation members</li>
                    <li>Organize shared tasks and responsibilities</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                If you didn't expect this invitation, you can safely ignore this email.
            </p>
            <p class="footer-text" style="margin-top: 15px;">
                © {{ now()->year }} EasyColoc. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
