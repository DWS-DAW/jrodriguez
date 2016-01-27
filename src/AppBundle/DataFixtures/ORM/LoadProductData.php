<?php
// src/AppBundle/DataFixtures/ORM/LoadProductData.php

// *********************************************************************************
// 
// ACTIVIDAD 2 T7
// 
// *********************************************************************************

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
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
		$fd = fopen('app/Resources/data/products.csv', "r");  // Lo abro en modo lectura
		$row = 0;
		if ($fd) {											  // Si se ha abierto bien $fd != null
			while (($data = fgetcsv($fd, 1000, ",")) !== false) {		  // Recorro hasta el final línea a línea guardándo en vector data[]
				$row++;
				if($row == 1) continue;                       // Salto la primera linea ya que es la linea de titulos, pasa del resto de 
															  // de	instrucciones del while y sigue con la siguiente iteracion
				$product = new Product();		              // Creo producto
				$product->setName($data[0]);	              // Asigno valor leido dsd el Fixture
				$product->setDescription($data[1]);
				$product->setCategory($this->getReference($data[2]));   // establezco la referencia en tabla productos, para esa tupla
				$product->setPrice($data[3]);
			
				$manager->persist($product);
			}
			$manager->flush();	                                // Hago el flush commit una vez he acabado de leer las 22 tuplas del csv 
			fclose($fd);										// Cierro
		}
	}
	
	public function getOrder(){
		return 1;				  // Establezco el orden de carga
	}							  // cuanto menor es el número, más pronto se carga
								  // Como Category tiene el return 0, la carga de products se realizará a posteriori de las category
								
	
}
