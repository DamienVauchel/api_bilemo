<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

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
 */
class Customer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", nullable=true, unique=true)
     * @Assert\NotBlank()
     *
     * @Expose()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @Expose()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @Expose()
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @Expose()
     */
    private $last_name;

    /**
     * @ORM\ManyToOne(targetEntity="FacebookConnectionBundle\Entity\User", inversedBy="customers")
     *
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
     * @param string|null $username
     *
     * @return Customer
     */
    public function setUsername($username = null)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Customer
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return Customer
     */
    public function setFirstName($firstName = null)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName.
     *
     * @param string|null $lastName
     *
     * @return Customer
     */
    public function setLastName($lastName = null)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string|null
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
