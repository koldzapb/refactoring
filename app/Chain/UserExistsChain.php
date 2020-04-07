<?php


namespace App\Chain;


use App\User\User;
use App\Validation\Validation;

class UserExistsChain extends AbstractChain
{


    /**
     * @var Validation
     */
    private $validation;

    /**
     * UserExistsChain constructor.
     * @param Validation $validation
     */
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

        $this->validation->name('email')->is_user_exists($user->getEmail());

        return parent::check($user);

    }

}