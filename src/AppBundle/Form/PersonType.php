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
		->add('name', 'text', array('label' => 'Name person: '))					# type="string"
		->add('age', 'integer', array('label' => 'Age person: '))	    				# type="decimal"
		->add('birthDate', 'date', array('label' => 'Birth date person: '))        	# type="date"
		->add('height', 'integer', array('label' => 'Height person: '))
		->add('email', 'text', array('label' => '@ person: '))
		->add('phone', 'integer', array('label' => 'Phone person: '))
		// Lista desplegable con sólo las opciones de masculino y femenino
		->add('gender', 'choice', array('choices' => array(
				                           'Masculino' => 'm',
				                           'Femenino' => 'f',
		                               ),
			'choices_as_values' => true,	
		))
		->add('descends', 'text', array('label' => 'Descends person: '))
		// Checkbox de si tiene vehiculo o no 
		->add('vehicle', 'checkbox', array('label' => 'Have vehicle? Check if yes: ', 'required' => false))
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
		->add('personalWebSite', 'text', array('label' => 'Personal Web: '))
		->add('cardNumber', 'text', array('label' => 'Card Number: '))
		->add('IBAN', 'text', array('label' => 'IBAN: '))
		->add('save', 'submit', array('label' => 'Guardar'))
		->add('continue', 'submit', array('label' => 'Guardar y Continuar'));	
	}

	public function getName()
	{
		return 'name';
	}

}