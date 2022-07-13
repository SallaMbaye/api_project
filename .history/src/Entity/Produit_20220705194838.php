<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\ProduitRepository;

use ApiPlatform\Core\Annotation\ApiResource;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]

#[ORM\InheritanceType("JOINED")]

#[ORM\DiscriminatorColumn(name:"type", type:"string")]

#[ORM\DiscriminatorMap(["produit"=>"Produit","burger"=>"Burger","menu"=>"Menu","boisson"=>"Boisson","portionfrite"=>"PortionFrite"])]

//ASSERT ET PATTERN

#[ApiResource(

    //Normalisation => Format De Sortie

    //DéNormalisation => Format D'Entree

    collectionOperations:[
        
        "get"=>[
        
            'method' => 'get',
        
            'status' => Response::HTTP_OK,

            'normalization_context' => ['groups' => ['simple']]

        ],

        "catalogue"=>[
        
            'method' => 'get',

            "path"=>"/catalogue",
            
            "controller"=>CatalogueController::class,

        ],
        
        "post"=>[

            'method' => 'post',

            'denormalization_context' => ['groups' => ['write']],

            //'denormalization_context' => ['groups' => ['read:menu']]#[Assert\NotBlank(message:"Adresse Obligatoire !!!")]


        ]

    ],

    itemOperations:[
        
        "put" => [

            'denormalization_context' => ['groups' => ['write']]
        ],
    
    "get"=>[

        'method' => 'get',

        'status' => 200,

        'normalization_context' => [ 'groups' => ['details']],

    ],
    
    
    "delete"=>[



        ]
    ]
)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(["read:menu","simple","details","affiche","foobar",'frite:menu','boisson:menu',"read:commande"])]
    #[ORM\Column(type: 'integer')]
    protected $id;

    
    #[Groups(["simple","details",'write',"foobar","frite"])]
    //#[Assert\NotBlank(message:"Nom Produit Obligatoire !!!")]
    #[Assert\NotNull(message:"Blablabla!!!")]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nom;

    //IRI 57 Video3

    #[Groups(["simple","details",'write',"frite"])]
    #[Assert\NotBlank(message:"Image Obligatoire !!!")]
    #[ORM\Column(type: 'string', length: 255)]
    protected $image;

    
    #[Groups(["simple","details",'write',"frite"])]
    #[ORM\Column(type: 'float', nullable: true)]
    protected $prix;


    #[Groups(["details"])]
    #[ORM\Column(type: 'string', length: 255)]  
    protected $etat="Disponible";
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
