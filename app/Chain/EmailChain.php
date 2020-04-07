<?php


namespace App\Chain;


use App\User\User;
use App\Validation\Validation;

class EmailChain extends AbstractChain
{
    /**
     * @var Validation
     */
    private $validation;

    public function __construct(Validation $validation)
    {

        $this->validation = $validation;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function check(User $user)
    {

        $this->validation->name('email')->value($user->getEmail())->required()->is_email($user->getEmail());
            return parent::check($user);

    }
}