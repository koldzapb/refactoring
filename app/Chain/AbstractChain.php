<?php


namespace App\Chain;


use App\User\User;

abstract class AbstractChain
{
    
    private $next;

    /**
     * @param AbstractChain $next
     * @return AbstractChain
     */
    public function linkNext(self $next)
    {
        $this->next = $next;

        return $next;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function check(User $user)
    {
        return $this->next ? $this->next->check($user) : true;
    }

}