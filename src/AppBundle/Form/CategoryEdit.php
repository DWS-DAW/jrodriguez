<?php
// src/AppBundle/Form/CategoryEdit.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryEdit extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('name', 'text', array('label' => 'Category: '))
		->add('save', 'submit', array('label' => 'Guardar'));
	}

	public function getName()
	{
		return 'category';
	}
}
