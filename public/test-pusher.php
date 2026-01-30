<!DOCTYPE html>
<html>
<head>
    <title>Pusher Connection Test</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<body>
    <h1>Pusher Connection Test</h1>
    <div id="status">Connecting...</div>
    <div id="logs"></div>

    <script>
        const logs = document.getElementById('logs');
        const status = document.getElementById('status');
        
        function log(message) {
            console.log(message);
            logs.innerHTML += '<p>' + new Date().toLocaleTimeString() + ': ' + message + '</p>';
        }

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }

        function getXsrfToken() {
            const raw = getCookie('XSRF-TOKEN');
            if (!raw) {
                return null;
            }

            try {
                return decodeURIComponent(raw);
            } catch (e) {
                return raw;
            }
        }

        // Test with your actual working Pusher credentials
        const xsrfToken = getXsrfToken();

        const pusher = new Pusher('d492d0b8be159c3dec06', {
            cluster: 'ap2',
            forceTLS: true,
            // Laravel default broadcasting auth endpoint:
            // Broadcast::routes() => /broadcasting/auth
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: xsrfToken ? {
                    'X-CSRF-TOKEN': xsrfToken,
                    'X-XSRF-TOKEN': xsrfToken,
                } : {},
            },
        });

        pusher.connection.bind('connected', () => {
            status.textContent = '✅ Connected to Pusher!';
            status.style.color = 'green';
            log('Connected to Pusher successfully');
        });

        pusher.connection.bind('error', (err) => {
            status.textContent = '❌ Connection Error: ' + err.error.message;
            status.style.color = 'red';
            log('Connection error: ' + JSON.stringify(err));
        });

        pusher.connection.bind('disconnected', () => {
            status.textContent = '⚠️ Disconnected';
            status.style.color = 'orange';
            log('Disconnected from Pusher');
        });

        // Test subscribing to a channel
        const channel = pusher.subscribe('private-chat.1');
        
        channel.bind('pusher:subscription_succeeded', () => {
            log('Successfully subscribed to private-chat.1');
        });

        channel.bind('pusher:subscription_error', (err) => {
            log('Subscription error: ' + JSON.stringify(err));
            log('Note: private channels require being logged in to the Laravel app (session cookie) and an XSRF token cookie.');
        });
    </script>
</body>
</html>
