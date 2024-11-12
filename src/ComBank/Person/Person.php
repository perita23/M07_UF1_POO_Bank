<?php
namespace ComBank\Person;

use ComBank\Person\Exceptions\InvalidEmailException;
use ComBank\Support\Traits\ApiTrait;
class Person
{
    use ApiTrait;
    private string $name;
    private string $idCard;
    private string $email;


    public function __construct($name, $idCard, $email)
    {
        if ($this->validateEmail($email)) {
            $this->name = $name;
            $this->idCard = $idCard;
            $this->email = $email;
        } else {
            throw new InvalidEmailException("Invalid person email", 1);
        }
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of idCard
     */
    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * Set the value of idCard
     *
     * @return  self
     */
    public function setIdCard($idCard)
    {
        $this->idCard = $idCard;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}