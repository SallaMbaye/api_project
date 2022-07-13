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

            'denormalization_context' => ['groups' => ["read:menu",'frite','frite:menu']],

            'security' => "is_granted('ROLE_GESTIONNAIRE')",

            'security_message' => "Vous n'avez pas access à cette ressource"

        ]
    
    ],

    itemOperations:["put","get","delete"]
)]
class PortionFrite extends Produit
{

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'portionFrites')]
    #[Groups(["read:menu"])]
    private $menus;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'portionfrites')]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'portionfrite', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'portionfrite', targetEntity: MenuFrite::class)]
    private $menuFrites;

    /* #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'portionFrites')]
    private $complement; */

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
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

   /**
    * @return Collection<int, MenuBurger>
    */
   public function getMenuBurgers(): Collection
   {
       return $this->menuBurgers;
   }

   /* public function addMenuBurger(MenuBurger $menuBurger): self
   {
       if (!$this->menuBurgers->contains($menuBurger)) {
           $this->menuBurgers[] = $menuBurger;
           $menuBurger->setPortionfrite($this);
       }

       return $this;
   }

   public function removeMenuBurger(MenuBurger $menuBurger): self
   {
       if ($this->menuBurgers->removeElement($menuBurger)) {
           // set the owning side to null (unless already changed)
           if ($menuBurger->getPortionfrite() === $this) {
               $menuBurger->setPortionfrite(null);
           }
       }

       return $this;
   } */

   /**
    * @return Collection<int, MenuFrite>
    */
   public function getMenuFrites(): Collection
   {
       return $this->menuFrites;
   }

   public function addMenuFrite(MenuFrite $menuFrite): self
   {
       if (!$this->menuFrites->contains($menuFrite)) {
           $this->menuFrites[] = $menuFrite;
           $menuFrite->setPortionfrite($this);
       }

       return $this;
   }

   public function removeMenuFrite(MenuFrite $menuFrite): self
   {
       if ($this->menuFrites->removeElement($menuFrite)) {
           // set the owning side to null (unless already changed)
           if ($menuFrite->getPortionfrite() === $this) {
               $menuFrite->setPortionfrite(null);
           }
       }

       return $this;
   }
}
