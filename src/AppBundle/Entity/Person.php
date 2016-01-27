<?php
// src/AppBundle/Entity/Person.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 */
class Person {
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;		
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *    message = "Valor Edad requerit."
     * )
     * @Assert\Range(
     *     min = 18,
     *     max = 90,
     *     minMessage= "Massa jovenet, ha  de ser major d'edat",
     *     maxMessage= "Massa matjor, ha  de ser menor de 90 anys"
     * )
     */
    protected $age;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $birthDate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *     message = "Valor Alçada requerit."
     * )
     * @Assert\Range(
     *     min = 100,
     *     max = 200,
     *     minMessage= "Massa baixet, ha  de ser mes alt de 100 cm",
     *     maxMessage= "Massa alt, ha  de ser mes baixet de 300 cm"
     * )
     */
    protected $height;
    
    /**
     * @ORM\Column(type="string", length=75)
     * @Assert\NotBlank(
     *     message = "Valor correu electronic requerit."
     * )
     * @Assert\Email(
     *     message = "El email no es valid.",
     * )
     * 
     */
    protected $email;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *    message = "Valor Telefon requerit."
     * )
     * @Assert\Regex("/\d{9,12}/")
     */
    protected $phone;
    
    /**
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank(
     *    message = "Valor Sexe requerit."
     * )
     */
    protected $gender;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *     min = 0,
     *     max = 20,
     *     minMessage= "No es pot tindre fills en nombre negatiu",
     *     maxMessage= "Massa fills, no es recomana tindre mes de 20"
     * )
     */
    protected $descends;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $vehicle;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $preferredLanguage;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $englishLevel;
    
    /**
     * @ORM\Column(type="string", length=75)
     *
     * @Assert\Url(
     *      protocols = {"http", "https", "ftp"},
     *      message="La URL introduida no es valida. Recorda introuir el protocol i les barres, http o https."
     * )
     */
    protected $personalWebSite;
    
    /**
     * @ORM\Column(type="string", length=25)
     *
     * @Assert\CardScheme(
     *     schemes={"VISA", "MAESTRO", "MASTERCARD"},
     *     message="El nombre de tarjeta introduit no es valid per a  VISA, MAESTRO, MASTERCARD."
     * )
     */
    protected $cardNumber;
    
    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\Iban(
     *     message="El nombre de IBAN introduit no es valid."
     * )
     */
    protected $IBAN;
    
    
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Person
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set age
     *
     * @param int $age
     *
     * @return Person
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set birthDate
     *
     * @param Date $birthDate
     *
     * @return Person
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return Date
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }
    
    /**
     * Set height
     *
     * @param int $height
     *
     * @return Person
     */
    public function setHeight($height)
    {
    	$this->height = $height;
    
    	return $this;
    }
    
    /**
     * Get height
     *
     * @return int
     */
    public function getHeight()
    {
    	return $this->height;
    }
    
    /**
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
    	$this->email = $email;
    
    	return $this;
    }
    
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
    	return $this->email;
    }
    
    /**
     * Set phone
     *
     * @param int $phone
     *
     * @return Person
     */
    public function setPhone($phone)
    {
    	$this->phone = $phone;
    
    	return $this;
    }
    
    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
    	return $this->phone;
    }
    
    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Person
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
     * Set descends
     *
     * @param int $descends
     *
     * @return Person
     */
    public function setDescends($descends)
    {
    	$this->descends = $descends;
    
    	return $this;
    }
    
    /**
     * Get descends
     *
     * @return int
     */
    public function getDescends()
    {
    	return $this->descends;
    }
    
    
    /**
     * Set vehicle
     *
     * @param int $vehicle
     *
     * @return Person
     */
    public function setVehicle($vehicle)
    {
    	$this->vehicle = $vehicle;
    
    	return $this;
    }
    
    /**
     * Get vehicle
     *
     * @return int
     */
    public function getVehicle()
    {
    	return $this->vehicle;
    }
    
    
    /**
     * Set preferredLanguage
     *
     * @param string $preferredLanguage
     *
     * @return Person
     */
    public function setPreferredLanguage($preferredLanguage)
    {
    	$this->preferredLanguage = $preferredLanguage;
    
    	return $this;
    }
    
    /**
     * Get preferredLanguage
     *
     * @return string
     */
    public function getPreferredLanguage()
    {
    	return $this->preferredLanguage;
    }
    
    /**
     * Set englishLevel
     *
     * @param int $englishLevel
     *
     * @return Person
     */
    public function setEnglishLevel($englishLevel)
    {
    	$this->englishLevel = $englishLevel;
    
    	return $this;
    }
    
    /**
     * Get englishLevel
     *
     * @return int
     */
    public function getEnglishLevel()
    {
    	return $this->englishLevel;
    }
    
    /**
     * Set personalWebSite
     *
     * @param int $personalWebSite
     *
     * @return Person
     */
    public function setpersonalWebSite($personalWebSite)
    {
    	$this->personalWebSite = $personalWebSite;
    
    	return $this;
    }
    
    /**
     * Get personalWebSite
     *
     * @return int
     */
    public function getpersonalWebSite()
    {
    	return $this->personalWebSite;
    }
    
    /**
     * Set cardNumber
     *
     * @param int $cardNumber
     *
     * @return Person
     */
    public function setCardNumber($cardNumber)
    {
    	$this->cardNumber = $cardNumber;
    
    	return $this;
    }
    
    /**
     * Get cardNumber
     *
     * @return int
     */
    public function getcardNumber()
    {
    	return $this->cardNumber;
    }
    
    /**
     * Set IBAN
     *
     * @param int $IBAN
     *
     * @return Person
     */
    public function setIBAN($IBAN)
    {
    	$this->IBAN = $IBAN;
    
    	return $this;
    }
    
    /**
     * Get IBAN
     *
     * @return int
     */
    public function getIBAN()
    {
    	return $this->IBAN;
    }
    
}
