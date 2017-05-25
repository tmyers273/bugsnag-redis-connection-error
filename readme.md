## Setup

Git clone + composer install like normal

Ensure you are using Redis as the queue  
`QUEUE_DRIVER=redis`

And that you have a valid bugsnag key in the .env  
`BUGSNAG_API_KEY=xxxxxxxxxxxxxxxxxx`

## Testing 

Create some test jobs with  
`php artisan dispatch:jobs`

Run a worker with  
`php artisan queue:work --queue=queue`

Watch the connection count climb.

Now comment out the bugsnag related code (lines 45-53 in App\Jobs\TestJob) and watch the client count remain the same
