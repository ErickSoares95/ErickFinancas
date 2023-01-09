<?php

namespace ErickFinancas\Auth;

use ErickFinancas\Repository\RepositoryInterface;
use Jasny\Auth;
use Jasny\Auth\Sessions;

class JasnyAuth extends Auth
{
    use Sessions;

    private $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
	public function fetchUserById($id) 
    {
        return $this->repository->find($id, false);
	}
	
	/**
	 * Fetch a user by username
	 *
	 * @param string $username
	 * @return Auth\User|null
	 */
	public function fetchUserByUsername($username) 
    {
        return $this->repository->findByField('email', $username)[0];
	}

}