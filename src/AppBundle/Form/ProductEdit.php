<?php
// src/AppBundle/Form/ProductEdit.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;

use AppBundle\Form\ProductEdit; // Añado esta nueva declaración para la creación de forms

class ProductEdit extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{	
		$builder
		->add('name', 'text', array('label' => 'product.name', 'translation_domain' => 'AppBundle'))					# type="string"
		->add('price', 'text', array('label' => 'product.price', 'translation_domain' => 'AppBundle'))					# type="decimal"
		->add('description', 'text', array('label' => 'product.description', 'translation_domain' => 'AppBundle'))		# type="text"
		->add('category', 'entity', array('class' => 'product.category', 'translation_domain' => 'AppBundle', 'choice_label'=> 'name'))
		->add('save', 'submit', array('label' => 'product.form.save', 'translation_domain' => 'AppBundle'));	
	}

	public function getName()
	{
		return 'name';
	}

}
