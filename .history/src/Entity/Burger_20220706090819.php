<?php

namespace App\Entity;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Entity\Gestionnaire;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\BurgerRepository;

use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(


   

    
    // object ==> array() Normaliser (Visuel)
    // array =>>> json ()
    // json   =>>> object()
    // DeNormaliser (Envoi)

    collectionOperations:[

        "get" => [

        'method' => 'get',

        'normalization_context' => [ 'groups' => ['simple',"affiche"]],

        //'security' => "is_granted('ROLE_CLIENT','ROLE_GESTIONNAIRE','ROLE_VISITEUR')"
        
        ],
        
        "post" => [

            'method' => 'post',

            'denormalization_context' => ['groups' => ['write','gestionnaire','read:menu',"read:commande"]],

            'security' => "is_granted('ROLE_GESTIONNAIRE')",

            'security_message' => "Vous n'avez pas access à cette ressource"
        ],
        
    
    ],

    subresourceOperations : [

        [
            'burgersmenu' => [

                'method' => 'get',
                
                'normalization_context' => ['groups' => ['foobar']],

                'security' => "is_granted('ROLE_GESTIONNAIRE')"


            ],
        ]
    ],

    itemOperations:[
        
        "put"=>[

            'method'=>'put',

            'security' => "is_granted('ROLE_GESTIONNAIRE')",

            'security_message' => "Vous n'avez pas access à cette ressource",

            'denormalization_context' => ['groups' => ['write']]
        ]
    
    
    ,"get"=>[

        'method' => 'get',

        'status' => 200,

        'normalization_context' => [ 'groups' => ['details']],

        //'security' => "is_granted('ROLE_CLIENT','ROLE_GESTIONNAIRE','ROLE_VISITEUR')"

    ]
    
    ,"delete"=>[
        
        
        
    ]],
    attributes:["pagination_items_per_page"=>5]

    
)]
class Burger extends Produit
{
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    private $gestionnaire;

    /* #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'burgers')]
    private $menus; */

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'burgers')]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;

   

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
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

    
   /*  public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
        }

        return $this;
    } */

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }

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
            $commande->addBurger($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeBurger($this);
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

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }

   
}
