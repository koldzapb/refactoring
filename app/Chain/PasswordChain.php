<?php


namespace App\Chain;


use App\User\User;
use App\Validation\Validation;

class PasswordChain extends AbstractChain
{
    /**
     * @var Validation
     */
    private $validation;

    /**
     * PasswordChain constructor.
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

        $this->validation->name('password')->value($user->getPassword())->required()->min(8)->equal($user->getPassword2());
        $this->validation->name('password2')->value($user->getPassword2())->required()->min(8);
        return parent::check($user);

    }

}