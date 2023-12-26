<body>

    <script 
        async 
        type="application/javascript"
        src="https://telegram.org/js/telegram-widget.js?7"
        data-telegram-login="{{ config('services.telegram-bot-api.name') }}" 
        data-size="large" 
        data-auth-url="/fcm" 
        data-request-access="write">
    ></script>
</body>