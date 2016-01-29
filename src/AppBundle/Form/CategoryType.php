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
		->add('name', 'text', array('label' => 'category.name', 'translation_domain' => 'AppBundle'))
		->add('save', 'submit', array('label' => 'category.save', 'translation_domain' => 'AppBundle'))
		->add('continue', 'submit', array('label' => 'category.saveAndAdd', 'translation_domain' => 'AppBundle'));
	}

	public function getName()
	{
		return 'category';
	}
}

