<!DOCTYPE html>
<html>
<head>
    <title>Two-Factor Authentication Code</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2>Authentication Code</h2>
    <p>Please use the following 6-digit code to complete your login:</p>
    
    <div style="background-color: #f4f6f8; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0;">
        <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #2C3E50;"><?php echo e($code); ?></span>
    </div>
    
    <p>This code will expire in 10 minutes.</p>
    <p>If you did not attempt to log in, please secure your account immediately.</p>
    <br>
    <p>Regards,<br>Apex Immunity Partners</p>
</body>
</html>
<?php /**PATH D:\Aptech\Eprojects\Code\Covid Vacination\resources\views/emails/two-factor-email.blade.php ENDPATH**/ ?>