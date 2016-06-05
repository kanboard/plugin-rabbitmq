<?php

namespace Kanboard\Plugin\RabbitMQ;

use Exception;
use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use SimpleQueue\Adapter\AmqpQueueAdapter;
use SimpleQueue\Queue;

require_once __DIR__.'/vendor/autoload.php';

defined('RABBITMQ_QUEUE') or define('RABBITMQ_QUEUE', 'kanboard_queue');
defined('RABBITMQ_EXCHANGE') or define('RABBITMQ_EXCHANGE', 'kanboard_exchange');
defined('RABBITMQ_HOSTNAME') or define('RABBITMQ_HOSTNAME', '127.0.0.1');
defined('RABBITMQ_PORT') or define('RABBITMQ_PORT', 5672);
defined('RABBITMQ_USERNAME') or define('RABBITMQ_USERNAME', 'guest');
defined('RABBITMQ_PASSWORD') or define('RABBITMQ_PASSWORD', 'guest');

class Plugin extends Base
{
    public function initialize()
    {
        try {
            $connection = new AMQPStreamConnection(RABBITMQ_HOSTNAME, RABBITMQ_PORT, RABBITMQ_USERNAME, RABBITMQ_PASSWORD);
            $channel = $connection->channel();
            $channel->queue_declare(RABBITMQ_QUEUE, false, true, false, false);
            $channel->exchange_declare(RABBITMQ_EXCHANGE, 'direct', false, true, false);
            $channel->queue_bind(RABBITMQ_QUEUE, RABBITMQ_EXCHANGE);

            $queue = new Queue(new AmqpQueueAdapter($channel, RABBITMQ_QUEUE, RABBITMQ_EXCHANGE));
            $this->queueManager->setQueue($queue);
        } catch (Exception $e) {
            $this->logger->error('RabbitMQ Plugin error: '.$e->getMessage());
        }
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'RabbitMQ';
    }

    public function getPluginDescription()
    {
        return t('Use RabbitMQ to process background jobs');
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-rabbitmq';
    }
}
