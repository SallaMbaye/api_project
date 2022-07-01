<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComplementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource]
class Complement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'complement', targetEntity: PortionFrite::class)]
    private $portionFrites;

    #[ORM\OneToMany(mappedBy: 'complement', targetEntity: Boisson::class)]
    private $boissons;

    public function __construct()
    {
        $this->portionFrites = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortionFrites(): Collection
    {
        return $this->portionFrites;
    }

   /*  public function addPortionFrite(PortionFrite $portionFrite): self
    {
        if (!$this->portionFrites->contains($portionFrite)) {
            $this->portionFrites[] = $portionFrite;
            $portionFrite->setComplement($this);
        }

        return $this;
    } */

    public function removePortionFrite(PortionFrite $portionFrite): self
    {
        if ($this->portionFrites->removeElement($portionFrite)) {
            // set the owning side to null (unless already changed)
            if ($portionFrite->getComplement() === $this) {
                $portionFrite->setComplement(null);
            }
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
            $boisson->setComplement($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            // set the owning side to null (unless already changed)
            if ($boisson->getComplement() === $this) {
                $boisson->setComplement(null);
            }
        }

        return $this;
    }
}
