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

class MonologAuditLogServiceProvider implements ServiceProviderInterface
{
	public function register(Container $pimple)
	{
		$pimple[ 'audit_log' ] = function ($pimple) {

			$settings = $pimple->get('settings');
			$loggerName = $settings->get('audit_log')[ 'name' ];
			$loggerPath = $settings->get('audit_log')[ 'audit_path' ];
            $audit_log = new Logger($loggerName);
			# PSR 3 log message formatting for all handlers
            $audit_log->pushProcessor(new PsrLogMessageProcessor());

			$filename = sprintf($loggerPath . "%s", $audit_log->getName());
			$handler = new RotatingFileHandler($filename, 24, Logger::INFO, true, 0777, true);

			$handler->setFilenameFormat('{filename}-{date}.log', 'Y-m-d');

			$format = "[%datetime%][%channel%][%level_name%][%extra.file%][%extra.line%][%extra.ip%][M:%message%][ID:%extra.uid%][C:%context%][E:%extra%]\n\n";
			$handler->pushProcessor(new UidProcessor(24));
			$handler->pushProcessor(new MemoryUsageProcessor());
			$handler->pushProcessor(new MemoryPeakUsageProcessor());
			$handler->pushProcessor(new ProcessIdProcessor());
			$handler->pushProcessor(new WebProcessor());
			$handler->pushProcessor(new IntrospectionProcessor());
			$handler->setFormatter(new LineFormatter($format, 'H:i:s'));
            $audit_log->pushHandler(new BufferHandler($handler));

			return $audit_log;
		};
	}
}
