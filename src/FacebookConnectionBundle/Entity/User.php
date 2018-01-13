<?php

namespace FacebookConnectionBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Phone
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="FacebookConnectionBundle\Repository\UserRepository")
 *
 * @ExclusionPolicy("all")
 */
class User implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Since("1.0")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", nullable=false, unique=true)
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
     * @ORM\Column(name="gender", type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
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
     * @ORM\Column(name="last_name", type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="string", nullable=false)
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", nullable=false)
     * @Assert\NotBlank()
     *
     * @Serializer\Since("1.0")
     *
     * @Expose()
     */
    private $facebookId;

    private $accessToken;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Customer", mappedBy="user", cascade={"remove"})
     */
    private $customers;

    public function __construct($facebookId, $username, $gender, $first_name, $last_name, $accessToken)
    {
        $this->facebookId = $facebookId;
        $this->username = $username;
        $this->gender = $gender;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->roles = json_encode(['ROLE_USER']);
        $this->accessToken = $accessToken;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getRoles()
    {
        return json_decode($this->roles);
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set roles
     *
     * @param string $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Add customer.
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return User
     */
    public function addCustomer(\AppBundle\Entity\Customer $customer)
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * Remove customer.
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCustomer(\AppBundle\Entity\Customer $customer)
    {
        return $this->customers->removeElement($customer);
    }

    /**
     * Get customers.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomers()
    {
        return $this->customers;
    }
}
