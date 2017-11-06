<?php

namespace Tests\AppBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ClassTest extends TestCase
{
    public function testExemple () {
		$request = new Request();

		$client = $this->createMock('GuzzleHttp\Client');
		$client->expects($this->once())->method('get')->willReturn($request);
		// Avec once() on verifie que la méthode est appelée au moins une fois (en plus de renvoyer un objet request) dans le code à tester. Cette attente est considerée comme une assertion
	}}