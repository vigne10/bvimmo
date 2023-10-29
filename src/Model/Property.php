<?php

namespace App\Model;

use App\Helpers\TextHelper;

class Property
{

    private ?int $id;
    private ?int $isSold;
    private ?string $label;
    private ?string $description;
    private ?float $price;
    private ?string $image = null;
    private ?string $oldImage;
    private ?string $energyClass;
    private ?int $bedroom;
    private ?int $bathroom;
    private ?int $toilet;
    private ?int $totalArea;
    private ?int $livingArea;
    private ?int $user;
    private ?int $propertyType;
    private ?int $adType;

    private bool $pendingUpload = false; // Check if property is pending to update image

    public function __construct(
        ?int $id = null,
        ?int $isSold = null,
        ?string $label = null,
        ?string $description = null,
        ?float $price = null,
        ?string $image = null,
        ?string $energyClass = null,
        ?int $bedroom = null,
        ?int $bathroom = null,
        ?int $toilet = null,
        ?int $totalArea = null,
        ?int $livingArea = null,
        ?int $user = null,
        ?int $propertyType = null,
        ?int $adType = null
    ) {
        $this->id = $id;
        $this->isSold = $isSold;
        $this->label = $label;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->energyClass = $energyClass;
        $this->bedroom = $bedroom;
        $this->bathroom = $bathroom;
        $this->toilet = $toilet;
        $this->totalArea = $totalArea;
        $this->livingArea = $livingArea;
        $this->user = $user;
        $this->propertyType = $propertyType;
        $this->adType = $adType;
    }

    public function getID(): ?int
    {
        return $this->id;
    }

    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getIsSold(): ?int
    {
        return $this->isSold;
    }

    public function setIsSold(int $isSold): self
    {
        $this->isSold = $isSold;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDecription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getExcerpt(): ?string
    {
        if ($this->description === null) {
            return null;
        }
        return nl2br(htmlentities(TextHelper::excerpt($this->description, 60)));
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage($newImage): self
    {
        if (is_array($newImage) && !empty($newImage['tmp_name'])) {
            if (!empty($this->image)) {
                $this->oldImage = $this->image;
            }
            $this->pendingUpload = true;
            $this->image = $newImage['tmp_name'];
        }
        if (is_string($newImage) && !empty($newImage)) {
            $this->image = $newImage;
        }
        return $this;
    }

    public function getOldImage(): ?string
    {
        if (!empty($this->oldImage)) {
            return $this->oldImage;
        }
        return null;
    }

    public function getImageURL(): ?string
    {
        if (empty($this->image)) {
            return null;
        }
        return "/img/properties/" . $this->image;
    }

    public function shouldUpload(): bool
    {
        return $this->pendingUpload;
    }

    public function getEnergyClass(): ?string
    {
        return $this->energyClass;
    }

    public function setEnergyClass(string $energyClass): self
    {
        $this->energyClass = $energyClass;
        return $this;
    }

    public function getBedroom(): ?int
    {
        return $this->bedroom;
    }

    public function setBedroom(int $bedroom): self
    {
        $this->bedroom = $bedroom;
        return $this;
    }

    public function getBathroom(): ?int
    {
        return $this->bathroom;
    }

    public function setBathroom(int $bathroom): self
    {
        $this->bathroom = $bathroom;
        return $this;
    }

    public function getToilet(): ?int
    {
        return $this->toilet;
    }

    public function setToilet(int $toilet): self
    {
        $this->toilet = $toilet;
        return $this;
    }

    public function getTotalArea(): ?int
    {
        return $this->totalArea;
    }

    public function setTotalArea(int $totalArea): self
    {
        $this->totalArea = $totalArea;
        return $this;
    }

    public function getLivingArea(): ?int
    {
        return $this->livingArea;
    }

    public function setLivingArea(int $livingArea): self
    {
        $this->livingArea = $livingArea;
        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getPropertyType(): ?int
    {
        return $this->propertyType;
    }

    public function setPropertyType(int $propertyType): self
    {
        $this->propertyType = $propertyType;
        return $this;
    }

    public function getAdType(): ?int
    {
        return $this->adType;
    }

    public function setAdType(int $adType): self
    {
        $this->adType = $adType;
        return $this;
    }

    public function getStatus(): ?string
    {
        if ($this->isSold === 0 && $this->adType === AdType::SALE) {
            return "En Vente";
        } else if ($this->isSold === 0 && $this->adType === AdType::RENTAL) {
            return "En Location";
        } else if ($this->isSold === 1) {
            return "Vendu/Loué";
        }
    }
}
