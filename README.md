RabbitMQ Queue Driver 
=====================

[![Build Status](https://travis-ci.org/kanboard/plugin-rabbitmq.svg?branch=master)](https://travis-ci.org/kanboard/plugin-rabbitmq)

This plugin use [RabbitMQ](http://www.rabbitmq.com) to process background jobs for Kanboard.

Author
------

- Frederic Guillot
- License MIT

Requirements
------------

- Kanboard >= 1.0.29
- PHP >= 5.3.3
- RabbitMQ

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/RabbitMQ`
3. Clone this repository into the folder `plugins/RabbitMQ`

Note: Plugin folder is case-sensitive.

Configuration
-------------

By default this plugin assume that RabbitMQ is running on `localhost`.
To change the default values, define those parameters in your config file:

```php
define('RABBITMQ_QUEUE', 'kanboard_queue');
define('RABBITMQ_EXCHANGE', 'kanboard_exchange');
define('RABBITMQ_HOSTNAME', '127.0.0.1');
define('RABBITMQ_PORT', 5672);
define('RABBITMQ_USERNAME', 'guest');
define('RABBITMQ_PASSWORD', 'guest');
```

You also need to run the Kanboard's worker:

```bash
./kanboard worker
```

The worker must have the same permissions as the web application (same user).
You should run the worker with a process manager like [supervisord](http://supervisord.org) or similar.
