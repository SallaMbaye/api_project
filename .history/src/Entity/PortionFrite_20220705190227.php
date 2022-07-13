<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(

    collectionOperations:[
        "get"=>[



        ],
        
        "post"=>[

            'method' => 'post',

            'denormalization_context' => ['groups' => ["read:menu" 'frite','frite:menu']],

            'security' => "is_granted('ROLE_GESTIONNAIRE')",

            'security_message' => "Vous n'avez pas access à cette ressource"

        ]
    
    ],

    itemOperations:["put","get","delete"]
)]
class PortionFrite extends Produit
{

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'portionFrites')]
    #[Groups(["frite:menu"])]
    private $menus;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'portionfrites')]
    private $commandes;

    /* #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'portionFrites')]
    private $complement; */

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }
    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {

            $this->menus[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }

   /*  public function getComplement(): ?Complement
    {
        return $this->complement;
    }

    public function setComplement(?Complement $complement): self
    {
        $this->complement = $complement;

        return $this;
    } */

   /**
    * @return Collection<int, Commande>
    */
   public function getCommandes(): Collection
   {
       return $this->commandes;
   }

   public function addCommande(Commande $commande): self
   {
       if (!$this->commandes->contains($commande)) {
           $this->commandes[] = $commande;
           $commande->addPortionfrite($this);
       }

       return $this;
   }

   public function removeCommande(Commande $commande): self
   {
       if ($this->commandes->removeElement($commande)) {
           $commande->removePortionfrite($this);
       }

       return $this;
   }
}
