<?php

namespace Tests\AppBunle\Folder;
use PHPUnit\Framework\TestCase;
use AppBundle\Security\GithubUserProvider;

class GithubUserProviderTest extends TestCase {

	public function testLoadUserByUserName() {

		$response = "Okay !";
		// Ce que l'on souhaite recevoir
	
		$client = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->setMethods(['get'])->getMock();

		$client->method('get')->willReturn($response);

		$githubUserProvider = new GithubUserProvider($client);
		$githubUserProvider->loadUserByUserName('xxx');
	}
}