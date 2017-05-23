<?php

namespace App\ServiceProviders;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsServiceProvider implements ServiceProviderInterface
{
	public function register(Container $pimple)
	{
		# Setting up Whoops
		$pimple[ 'whoops' ] = function ($pimple) {
			# stop PHP from polluting exception messages
			# with html that Whoops escapes and prints.
			ini_set('html_errors', false);

			$whoops = new Run();

			$prettyPageHandler = new PrettyPageHandler();
			$prettyPageHandler->addEditor('edit', 'edit://open/?url=file://%file&line=%line');
			$prettyPageHandler->setEditor('xdebug');

			$whoops->pushHandler($prettyPageHandler);

			$plainTextHandler = new PlainTextHandler();
			$plainTextHandler->loggerOnly(true);
			$plainTextHandler->setLogger($pimple[ 'logger' ]);

			$whoops->pushHandler($plainTextHandler);

			return $whoops;
		};

//		# Responds to AJAX requests with JSON formatted exceptions
//		$pimple->extend('whoops', function ($whoops, $pimple) {
//			$handler = new JsonResponseHandler();
//			$handler->addTraceToOutput(true);
//			$whoops->pushHandler($handler);
//
//			return $whoops;
//		});

		$whoops = $pimple[ 'whoops' ];
		$whoops->register();
	}
}