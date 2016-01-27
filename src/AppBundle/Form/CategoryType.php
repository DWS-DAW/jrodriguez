<?php
// src/AppBundle/Form/CategoryType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('name', 'text', array('label' => 'Category: '))
		->add('save', 'submit', array('label' => 'Guardar'))
		->add('continue', 'submit', array('label' => 'Guardar y Continuar'));
	}

	public function getName()
	{
		return 'category';
	}
}

