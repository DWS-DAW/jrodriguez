<?php
// src/AppBundle/Entity/Category.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 * 
 * @ORM\Table()
 * @ORM\Entity
 *
 */
class Category {
	/**
	 * @var Integer
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	/**
	 * @var String
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

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
     * @return Category
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
    
    
   
    /* 1:M
       Category 1 to M products
     En el lado de uno Category,crearemos una variable de tipo ArrayCollection ($products) ya que una categoría
     está relacionada con muchos productos (Collection of Product). Indicaremos la relación con la anotación correspondiente.
     Entidad Muchos es Product y se referencia como targetEntity="Product", mappeada por el atributo clave foranea mappedBy="category"  
     Además se añade una segunda politica que es para permitir que cuando eliminemos una categoría, se eliminen los productos asociados en cascada cascade={"persist", "remove"}
     */
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category", cascade={"persist", "remove"})
     */
    protected $products;
    
    public function __construct()
    {
    	$this->products = new ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Category
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    /* Esta es la funcion toString que trae el Symfony implementada en el framework y que trabaja con el método "magico" precedido como tal con dos subrayados en su nombre
     * y como tal funcion transforma a string el atributo (en este caso name) del objeto que se le pasa en la llamada, referenciado en este caso con el this
     * */
    public function __toString()
    {
    	return $this->name;
    }
}
