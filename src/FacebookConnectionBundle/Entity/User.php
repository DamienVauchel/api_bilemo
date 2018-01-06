<?php

namespace FacebookConnectionBundle\Entity;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Phone
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="FacebookConnectionBundle\Repository\UserRepository")
 *
 * @ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href= @Hateoas\Route(
 *          "app_user_show",
 *          parameters={ "username" = "expr(object.getUsername())" },
 *          absolute=true)
 * )
 *
 * @Hateoas\Relation(
 *     "create",
 *     href= @Hateoas\Route(
 *          "app_user_creation",
 *          absolute=true)
 * )
 *
 * @Hateoas\Relation(
 *     "list",
 *     href= @Hateoas\Route(
 *          "app_users_list",
 *          absolute=true)
 * )
 *
 * @Hateoas\Relation(
 *     "delete",
 *     href= @Hateoas\Route(
 *          "app_user_delete",
 *          parameters={ "username" = "expr(object.getUsername())" },
 *          absolute=true)
 * )
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
     * @Expose()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", nullable=true, unique=true)
     * @Assert\NotBlank(groups={"Create"})
     *
     * @Expose()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=true)
     * @Assert\NotBlank(groups={"Create"})
     *
     * @Expose()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", nullable=true)
     *
     * @Expose()
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
     *
     * @Expose()
     */
    private $first_name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", nullable=true)
     *
     * @Expose()
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="string")
     * @Assert\NotBlank(groups={"Create"})
     *
     * @Expose()
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", nullable=true)
     *
     * @Expose()
     */
    private $facebookId;

    private $accessToken;

    public function __construct($facebookId, $username, $email, $gender, $first_name, $last_name, $accessToken)
    {
        $this->facebookId = $facebookId;
        $this->username = $username;
        $this->email = $email;
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

    public function getEmail()
    {
        return $this->email;
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

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
}
