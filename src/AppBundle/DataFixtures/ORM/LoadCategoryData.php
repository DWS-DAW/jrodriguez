<?php
// src/AppBundle/DataFixtures/ORM/LoadCategoryData.php

// *********************************************************************************
// 
// ACTIVIDAD 2 T7
// 
// Carga a la tabla "category" de las categorias desde el categories.csv
// Carga a la tabla "product" de las productos desde el products.csv ...
// ... con la implementación del interfaz orderedFixtureInterface para establecer el orden 
// de trabajo sobre las tablas de inserción de las tuplas desde el csv en su funcion getOrder();
// también se debe realizar la extensión de la clase AbstractFixture.
// La clase implementa ahora OrderedFixtureInterface, el cual indica a Doctrine que tomamos el control
// de las cargas. Estableceremos el orden de la carga en la funcion getOrder() asignando el valor 2 a los products y el valor 1 
// para las categories que deben existir previemante a la creación de los products.
// En la tabla products se deberá crear una referencia para poder referirnos
// a la tabla de category en la creación de cada una de las tuplas de product.
// *********************************************************************************

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

// El contenedor se inyectará en todas las clases accesorio que implementen la 
// Symfony\Component\DependencyInjection\ContainerAwareInterface.
// En este ejercicio la class LoadCategoryData

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	
	public function load(ObjectManager $manager)
	{
		// Leo el fichero completo de 0 a eof
		$fd = fopen('app/Resources/data/categories.csv', "r");  // Lo abro en modo lectura
		if ($fd) {												// Si se ha abierto bien $fd != null
			while (($data = fgetcsv($fd)) !== false) {			// Recorro hasta el final línea a línea guardándo en vector data[]
				$category = new Category();		                // Creo categoria
				$category->setName($data[0]);	                // Asigno valor leido dsd el Fixture
				$manager->persist($category);
				$manager->flush();	                            // Hago el flush commit para cada categoria
				$this->addReference($data[0], $category);       // Creamos la referencia a la categoria
			}
			fclose($fd);										// Cierro
		}
	}
	
	public function getOrder(){
		return 0;					                            // Establezco el orden de carga
	}															// cuanto menor es el número, más pronto se carga 
	
}