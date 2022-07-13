<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    
    collectionOperations:[
        
        'get' => [
            
                'method' => 'get',

                'normalization_context' => ['groups' => ['affiche']]
            
            ],
    
        "post"=>[

            'method'=>'post',
       
            'denormalization_context' => ['groups' => ['read:menu','write','frite:menu',"boisson:menu"]]

        ]
    ],

    subresourceOperations : [

        [
            'burgersmenu' => [

                'method' => 'get',
                
                'normalization_context' => ['groups' => ['foobar']],

                'security' => "is_granted('ROLE_GESTIONNAIRE')"


            ],
        ],

      
    ],
    itemOperations:["put"=>[

        'method'=>'put',
       
        'denormalization_context' => ['groups' => ['read:menu','write','frite:menu',"boisson:menu"]]


    ],"get","delete"]
)]
class Menu extends Produit
{
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    #[ApiSubresource]
    #[Groups(["read:menu","affiche"])]
    private $gestionnaire;


    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    #[ApiSubresource]
    #[Groups(["read:menu","affiche","foobar"])]
    private $burgers; 


    #[ORM\ManyToMany(targetEntity: PortionFrite::class, mappedBy: 'menus')]
    #[ApiSubresource]
    #[Groups(["read:menu","affiche"])]
    private $portionFrites;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    #[ApiSubresource]
    #[Groups(["boisson:menu"])]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'menus')]
    #[ApiSubresource]
    #[Groups(["boisson:menu"])]
    private $;

   

    

    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->portionFrites = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortionFrites(): Collection
    {
        return $this->portionFrites;
    }

    public function addPortionFrite(PortionFrite $portionFrite): self
    {
        if (!$this->portionFrites->contains($portionFrite)) {
            $this->portionFrites[] = $portionFrite;
            $portionFrite->addMenu($this);
        }

        return $this;
    }

    public function removePortionFrite(PortionFrite $portionFrite): self
    {
        if ($this->portionFrites->removeElement($portionFrite)) {
            $portionFrite->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {

            $this->burgers[] = $burger;
            
            $burger->addMenu($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            $burger->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }

    
    
}
