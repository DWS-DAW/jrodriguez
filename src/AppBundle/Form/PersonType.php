<?php
// src/AppBundle/Form/PersonType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class PersonType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{	
		$builder
		->add('name', 'text', array('label' => 'person.name', 'translation_domain' => 'AppBundle'))					# type="string"
		->add('age', 'integer', array('label' => 'person.age', 'translation_domain' => 'AppBundle'))	    				# type="decimal"
		->add('birthDate', 'date', array('label' => 'person.birthDate', 'translation_domain' => 'AppBundle'))        	# type="date"
		->add('height', 'integer', array('label' => 'person.height', 'translation_domain' => 'AppBundle'))
		->add('email', 'text', array('label' => 'person.email', 'translation_domain' => 'AppBundle'))
		->add('phone', 'integer', array('label' => 'person.phone', 'translation_domain' => 'AppBundle'))
		// Lista desplegable con sólo las opciones de masculino y femenino
		->add('gender', 'choice', array('choices' => array(
				                           'M' => 'm',
				                           'F' => 'f',
		                               ),
			'choices_as_values' => true,	
		))
		->add('descends', 'text', array('label' => 'person.descends', 'translation_domain' => 'AppBundle'))
		// Checkbox de si tiene vehiculo o no 
		->add('vehicle', 'checkbox', array('label' => 'person.vehicle', 'translation_domain' => 'AppBundle', 'required' => false))
		// Lista de todos los lenguajes posibles para seleccionar el preferido
		->add('preferredLanguage', 'choice', array('choices' => array(
				                           'Valenciano' => 'vlc',
				                           'Castellano' => 'cs',
				                           'Ingles' => 'uk',
				                           'Aleman' => 'gr',
				                           'Frances' => 'fr',
				                           'Italiano' => 'it',
		                               ),
			'choices_as_values' => true,	
		))
		// RadioButtons para establecer el nivel de inglés		
		->add('englishLevel', 'choice', array('choices' => array(
                                                             1 => 'A1',
                                                             2 => 'A2',
				                                             3 => 'B1',
				                                             4 => 'B2',
				                                             5 => 'C1',
				                                             6 => 'C2',
                                                             ),
                          'expanded' => true,
                          'multiple' => false,
                          'required' => true,
                          'label' => 'English Level: ',
        ))	
		->add('personalWebSite', 'text', array('label' => 'person.personalWebSite', 'translation_domain' => 'AppBundle'))
		->add('cardNumber', 'text', array('label' => 'person.cardNumber', 'translation_domain' => 'AppBundle'))
		->add('IBAN', 'text', array('label' => 'person.IBAN', 'translation_domain' => 'AppBundle'))
		->add('save', 'submit', array('label' => 'person.form.save', 'translation_domain' => 'AppBundle'))
		->add('continue', 'submit', array('label' => 'person.form.saveAndAdd', 'translation_domain' => 'AppBundle'));	
	}

	public function getName()
	{
		return 'name';
	}

}