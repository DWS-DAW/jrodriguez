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
		->add('name', 'text', array('label' => 'category.form.save', 'translation_domain' => 'AppBundle'))
		->add('save', 'submit', array('label' => 'category.form.saveAndAdd', 'translation_domain' => 'AppBundle'));
	}

	public function getName()
	{
		return 'category';
	}
}
