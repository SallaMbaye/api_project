<?php

namespace App\Entity;

use DateTime;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;




#[ORM\Entity(repositoryClass: UserRepository::class)]

#[ORM\InheritanceType("JOINED")]

#[ORM\DiscriminatorColumn(name:"discr", type:"string")]

#[ORM\DiscriminatorMap(["user"=>"User","client"=>"Client","gestionnaire"=>"Gestionnaire"])]

#[ApiResource(

    collectionOperations:[
        
    "get"=>[

    ],
    
    "mail"=>[

        'method'=>'get',

        'path'=>'/send',

        'controller'=> \App\Controller\UserController::class,
    ],

    "post_register" => [
        
        "method"=>"post",
        
        'path'=>'register/',
        
        'denormalization_context' => ['groups' => ['user:write']],
        
        'normalization_context' => ['groups' => ['user:read:simple']]
    ],

    'post'=>[

        'method' => 'post',

        'denormalization_context' => ['groups' => ['write','gestion']]

    ]




    ],

    itemOperations:[

        "put"=>[
        
            'denormalization_context' => ['groups' => ['write']]
        ],
        
        "get"=>[




        ]
        
        
        
        
    ]

        //Provider : Redefinition des requetes SELECT
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["read","write","user:write"])]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[Groups(["user:write","gestion","affiche"])]
    #[ORM\Column(type: 'string', length: 180, unique: true)] 
    protected $login;


    #[ORM\Column(type: 'json')]
    protected $roles = [];


    #[Groups(["user:write","gestion"])]
    #[ORM\Column(type: 'string')]
    protected $password;


    
    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantee every user at least has ROLE_USER
        
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
   

    

   
}
