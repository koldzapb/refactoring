<?php


namespace App\Chain;


use App\User\User;

class Authenticate
{

    private $chain;

    /**
     * Authenticate constructor.
     * @param AbstractChain $chain
     */
    public function __construct(AbstractChain $chain)
    {
        $this->chain = $chain;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function checked(User $user)
    {
        return $this->chain->check($user);
    }

}