<?php
namespace App\ServiceProviders;

use Monolog\ErrorHandler as LoggerErrorHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\BufferHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;
use Monolog\Registry as LoggerRegistry;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MonologServiceProvider implements ServiceProviderInterface
{
	public function register(Container $pimple)
	{
		$pimple[ 'logger' ] = function ($pimple) {

			$settings = $pimple->get('settings');
			$loggerName = $settings->get('logger')[ 'log_name' ];
			$loggerPath = $settings->get('logger')[ 'log_path' ];
			$logger = new Logger($loggerName);
			# PSR 3 log message formatting for all handlers
			$logger->pushProcessor(new PsrLogMessageProcessor());

			$filename = sprintf($loggerPath . "%s", $logger->getName());
			$handler = new RotatingFileHandler($filename, 24, Logger::INFO, true, 0777, true);

			$handler->setFilenameFormat('{filename}-{date}.log', 'Y-m-d');

			$format = "[%datetime%][%channel%][%level_name%][%extra.file%][%extra.line%][%extra.ip%][M:%message%][ID:%extra.uid%][C:%context%][E:%extra%]\n";
			$handler->pushProcessor(new UidProcessor(24));
			$handler->pushProcessor(new MemoryUsageProcessor());
			$handler->pushProcessor(new MemoryPeakUsageProcessor());
			$handler->pushProcessor(new ProcessIdProcessor());
			$handler->pushProcessor(new WebProcessor());
			$handler->pushProcessor(new IntrospectionProcessor());
			$handler->setFormatter(new LineFormatter($format, 'H:i:s'));
			$logger->pushHandler(new BufferHandler($handler));

			LoggerRegistry::addLogger($logger, $loggerName, true);
			LoggerErrorHandler::register($logger);

			return $logger;
		};
	}
}
