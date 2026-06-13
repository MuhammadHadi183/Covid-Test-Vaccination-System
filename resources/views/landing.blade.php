<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COVID Vaccination</title>
  <style>
    body { font-family: system-ui, sans-serif; max-width: 560px; margin: 48px auto; padding: 0 20px; line-height: 1.5; }
    .ok { background: #e8f8ef; color: #1a6b3c; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.95rem; }
    a { color: #3498db; font-weight: 600; }
  </style>
</head>
<body>
  @if(session('success'))
    <div class="ok">{{ session('success') }}</div>
  @endif
  <p><a href="/login">Login</a> · <a href="/register">Register</a></p>
</body>
</html>
