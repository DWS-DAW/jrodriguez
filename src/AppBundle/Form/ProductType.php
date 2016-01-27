<?php
// src/AppBundle/Form/ProductType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;

use AppBundle\Form\ProductType; // Añado esta nueva declaración para la creación de forms

class ProductType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{	
		$builder
		->add('name', 'text', array('label' => 'Name product: '))					# type="string"
		->add('price', 'text', array('label' => 'Price product: '))					# type="decimal"
		->add('description', 'text', array('label' => 'Description product: '))		# type="text"
		->add('category', 'entity', array('class' => 'AppBundle:Category',
				                           'choice_label'=> 'name'))
		->add('save', 'submit', array('label' => 'Guardar'))
		->add('continue', 'submit', array('label' => 'Guardar y Continuar'));	
	}

	public function getName()
	{
		return 'name';
	}

}

