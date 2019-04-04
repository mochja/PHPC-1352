<?php

namespace App\Presenters;

use Nette;
use App\Model;
use MongoDB;

class Foo {

	public $a;

	public function __construct() {
		$this->a = base64_encode(file_get_contents(__DIR__ . '/beauty-bloom-blue-67636.jpg'));
	}
}

class FooExtension extends Nette\DI\CompilerExtension
{
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        for ($i = 0; $i < 20; $i++) {
        	$builder->addDefinition($this->prefix('a' . $i))
            	->setFactory(Foo::class, [])
            	->setAutowired(false);
        }
    }
}


class HomepagePresenter extends BasePresenter
{
	public function __construct(MongoDB\Client $c) {

	}

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

	public function actionJson()
	{
		for ($i = 0; $i < 20; $i++) {
			$this->context->getService('f.a' . $i);
        }
		$this->sendJson([
			'image' => base64_encode(file_get_contents(__DIR__ . '/beauty-bloom-blue-67636.jpg'))
		]);
	}

}
