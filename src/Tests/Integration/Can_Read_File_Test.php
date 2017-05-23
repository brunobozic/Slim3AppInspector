<?php
namespace Tests\Unit;
class FileReadTest extends \PHPUnit_Framework_TestCase
{
	public function test_PHP_reads_file_contents_from_a_file()
	{
		$targetPath = '/home/brunobozic/Projects/ApplicationInspector/public/index.php';

		$this->assertFileExists($targetPath);

		$fileContents = file_get_contents($targetPath, FILE_USE_INCLUDE_PATH);

		$this->assertNotEmpty($fileContents);
	}
}