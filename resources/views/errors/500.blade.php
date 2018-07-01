<div class="content">
    <div class="title">Something went wrong.</div>

    @if(app()->bound('sentry') && !empty(Sentry::getLastEventID()))
        <div class="subtitle">Error ID: {{ Sentry::getLastEventID() }}</div>

        <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

        <script>
			Raven.showReportDialog({
				eventId: '{{ Sentry::getLastEventID() }}',
				// use the public DSN (dont include your secret!)
				dsn: 'https://ac9460f76b284b708585f9792aa65230@sentry.io/277077',
				user: {
					'name': 'Jane Doe',
					'email': 'jane.doe@example.com',
				}
			});
        </script>
    @endif
</div>
