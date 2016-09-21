<?
	namespace ClassProviderTest\Cases;


	use ClassProviderTest\Classes\Provider1;
	use ClassProviderTest\Classes\Provider2;
	use ClassProviderTest\Classes\Provider3;
	use ClassProviderTest\Classes\Provider4;
	use ClassProviderTest\Classes\Provider5;

	class AbstractClassProviderTest extends \PHPUnit_Framework_TestCase
	{

		public function testRegistration() {

			Provider1::register('test1', 'testclass1');
			Provider1::register('test2', 'testclass2');

			$this->assertEquals([
				'test1' => 'testclass1',
				'test2' => 'testclass2',
			], Provider1::getAll());
		}

		public function testGet() {

			Provider2::register('test3', 'testclass3');
			Provider2::register('test4', 'testclass4');

			$this->assertEquals('testclass3', Provider2::get('test3'));
			$this->assertEquals('testclass4', Provider2::get('test4'));
			$this->assertNull(Provider2::get('notSet'));
		}

		public function testIndependence() {
			Provider3::register('test5', 'A');
			Provider4::register('test5', 'B');

			$this->assertEquals('A', Provider3::get('test5'));
			$this->assertEquals('B', Provider4::get('test5'));
		}

		public function testInclude() {
			Provider5::addInclude(__DIR__ . '/../Includes/Include*.php');

			$this->assertEquals('i1', Provider5::get('include1'));
			$this->assertEquals('i2', Provider5::get('include2'));
		}

	}