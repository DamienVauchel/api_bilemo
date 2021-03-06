<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation as Serializer;

/**
 * Client
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 *
 * @ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href= @Hateoas\Route(
 *          "app_customer_show",
 *          parameters={ "id" = "expr(object.getId())" },
 *          absolute=true)
 * )
 *
 * @Hateoas\Relation(
 *     "create",
 *     href= @Hateoas\Route(
 *          "app_customer_creation",
 *          absolute=true)
 * )
 *
 * @Hateoas\Relation(
 *     "list",
 *     href= @Hateoas\Route(
 *          "app_customer_list",
 *          absolute=true)
 * )
 *
 * @Hateoas\Relation(
 *     "delete",
 *     href= @Hateoas\Route(
 *          "app_customer_delete",
 *          parameters={ "id" = "expr(object.getId())" },
 *          absolute=true)
 * )
 *
 * @Hateoas\Relation(
 *     "authenticated_user",
 *     embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())")
 * )
 */
class Customer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", unique=true, nullable=false)
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=false)
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", nullable=false)
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string")
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string")
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $last_name;

    /**
     * @ORM\ManyToOne(targetEntity="FacebookConnectionBundle\Entity\User", inversedBy="customers")
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return Customer
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set user.
     *
     * @param \FacebookConnectionBundle\Entity\User|null $user
     *
     * @return Customer
     */
    public function setUser(\FacebookConnectionBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \FacebookConnectionBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
