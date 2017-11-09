<?php

namespace Tests\AppBundle\Security;
use AppBundle\Entity\User;
use AppBundle\Security\GithubUserProvider;
use PHPUnit\Framework\TestCase;

class GithubUserProviderTest extends TestCase {

	private $client;
	private $serializer;
	private $streamedResponse;
	private $response;

	public function setUp() {
		$this->client = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->setMethods(['get'])->getMock();
		$this->serializer = $this->getMockBuilder('JMS\Serializer\Serializer')->disableOriginalConstructor()->getMock();
		$this->streamedResponse = $this->getMockBuilder('Psr\Http\Message\StreamInterface')->getMock();
		$this->response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->getMock();
	}

	public function testLoadUserByUsernameReturningAnUser () {
		$this->client->expects($this->once())->method('get')->willReturn($this->response);
		$this->response->expects($this->once())->method('getBody')->willReturn($this->streamedResponse);

		$userData = ['login' => 'a login', 'name' => 'user name', 'email' => 'user@mail.com', 'avatar_url' =>'url to the avatar', 'html_url' => 'url to profile'];
		$this->serializer->expects($this->once())->method('deserialize')->willReturn($userData);
		// On remplit arbitrairement la variable userData qui sera renvoyée lorsque la methode deserialize sera appelée (elle doit l'être au moins une fois)
		

		$githubUserProvider = new GithubUserProvider($this->client, $this->serializer);
		// On passe nos doublures au constructeur de la classe qu'on veut tester
		$user = $githubUserProvider->loadUserByUserName('an-access-token');
		// On ne fait pas reelement appel à Github, le token passé n'a donc aucune importance

		$expectedUser = new User($userData['login'], $userData['name'], $userData['email'], $userData['avatar_url'], $userData['html_url']);
		// On crée une variable expectedUser qu'on passera en argument à assertEquals() pour tester le code

		$this->assertEquals($expectedUser, $user);
		$this->assertEquals('AppBundle\Entity\User', get_class($user));
		// On test si $user est bien une instance de User et si sa valeur correspond bien à ce qu'on attend ($expectedUser)
	}

	public function testLoadUserByUsernameReturningAnExeption () {
		$this->client->expects($this->once())->method('get')->willReturn($this->response);
		$this->response->expects($this->once())->method('getBody')->willReturn($this->streamedResponse);
		$this->serializer->expects($this->once())->method('deserialize')->willReturn([]);

		$this->expectException('LogicException');
		$githubUserProvider = new GithubUserProvider($this->client, $this->serializer);
		$githubUserProvider->loadUserByUserName('an-access-token');
	}

	public function tearDpwn() {
		$this->client = null;
		$this->serializer = null;
		$this->streamedResponse = null;
		$this->response = null;
	}	// Il est important de remettre l'ensemble des variables à null après les test de manière à ne pas encombrer la mémoire du système
}