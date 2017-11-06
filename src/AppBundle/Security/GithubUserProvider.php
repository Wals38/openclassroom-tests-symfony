<?php

namespace AppBundle\Security;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GithubUserProvider extends UserProviderInterface {

	public function __construct(Client $client) {
		$this->client = $client;
	}

	public function loadUserByUsername ($username) {
		$response = $this->client->get('https://api.github.com/user?access_token=' . $username);
	}
}