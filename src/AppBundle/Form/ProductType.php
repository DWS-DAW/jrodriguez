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
		->add('name', 'text', array('label' => 'product.name', 'translation_domain' => 'AppBundle'))					# type="string"
		->add('price', 'money', array('label' => 'product.price', 'translation_domain' => 'AppBundle'))					# type="decimal"
		->add('description', 'text', array('label' => 'product.description', 'translation_domain' => 'AppBundle'))		# type="text"
		->add('category', 'entity', array('class' => 'AppBundle:Category', 'choice_label'=> 'name'))
		->add('save', 'submit', array('label' => 'product.form.save', 'translation_domain' => 'AppBundle'))
		->add('continue', 'submit', array('label' => 'product.form.saveAndAdd', 'translation_domain' => 'AppBundle'));	
	}

	public function getName()
	{
		return 'name';
	}

}

