# StatsD
## Testing StatsD for Centra

## What does it do?

This simple app sends various data to given StatsD server. In particular:
- `centra.memory` - script memory profiling
- `centra.home-page` - time used to fetch Centra home page
- `centra.ticks` - always incremented integer
- `centra.gauge` - random integer between 0 and 100
- `centra.random-walk` - integer with random changes from previous value
- `centra.exception.UnexpectedValueException` - on caught exception, 10% chance each time

## Installation

1. Clone the repo
2. `composer install`
3. `php gen-stats.php`, optionally with host and port: `php gen-stats.php localhost 8125` or 
 `STATSD_HOST=localhost STATSD_PORT=8125 php gen-stats.php`
 
 
