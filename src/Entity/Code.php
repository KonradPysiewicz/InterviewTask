<?php

namespace App\Entity;

use App\Repository\CodeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CodeRepository::class)
 */
class Code
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeNr;

    /**
     * @ORM\Column(type="boolean")
     */
    private $flag;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


    /**
     * W tej funkcji znajduje się walidacja kodu.
     * @param ClassMetadata $metadata
     */

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        /** Sprawdzenie, czy kod ma poprawny pattern */

        $metadata->addPropertyConstraint('codeNr', new Assert\Regex([
            'pattern' => '/^0000[0-9]+[A-Z0-9]$/',
            'message' => 'Niepoprawny kod',
        ]));



        /** Sprawdzenie, czy kod ma odpowiednią długość */

        $metadata->addPropertyConstraint('codeNr', new Assert\Length([
            'min' => 15,
            'max' => 15,
        ]));



        /** Sprawdzenie, czy kod nie jest konkretnym, złym kodem */

        $metadata->addPropertyConstraint('codeNr', new Assert\NotEqualTo([
            'value' => '00001236256212M',
            'message' => 'Niepoprawny kod',
        ]));

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeNr(): ?string
    {
        return $this->codeNr;
    }

    public function setCodeNr(string $codeNr): self
    {
        $this->codeNr = $codeNr;

        return $this;
    }

    public function getFlag(): ?bool
    {
        return $this->flag;
    }

    public function setFlag(bool $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
