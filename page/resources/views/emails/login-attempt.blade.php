<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Attempt Notification</title>
</head>
<body>
    <h2>Login Attempt Notification</h2>
    
    <p><strong>Entered Name:</strong> {{ $attempt->entered_name ?? 'N/A' }}</p>
    <p><strong>Entered Email:</strong> {{ $attempt->entered_email ?? 'N/A' }}</p>
    <p><strong>IP Address:</strong> {{ $attempt->ip_address ?? 'N/A' }}</p>
    <p><strong>Browser:</strong> {{ $attempt->browser ?? 'N/A' }}</p>
    <p><strong>Device Info:</strong> {{ $attempt->device_info ?? 'N/A' }}</p>
    <p><strong>User Agent:</strong> {{ $attempt->user_agent ?? 'N/A' }}</p>
    <p><strong>Success:</strong> {{ $attempt->success ? 'Yes' : 'No' }}</p>
    <p><strong>Timestamp:</strong> {{ $attempt->created_at->format('Y-m-d H:i:s') }}</p>
</body>
</html>
