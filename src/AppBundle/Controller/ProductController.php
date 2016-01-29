<?php
// src/AppBundle/Controller/ProductController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;

use AppBundle\Form\ProductType; // Añado estas nuevas declaraciones para la creación de forms
use AppBundle\Form\ProductEdit;

use Symfony\Component\HttpFoundation\Request;

# *****************************************************************************************************
# T5. [Symfony] Persistencia de la información, Doctrine ORM
# *****************************************************************************************************

class ProductController extends Controller
{
	# Crea un producto con datos estáticos y lo almacena en la base de datos
	public function createStaticAction()
		{
		// ... De momento sólo un único objeto
		$product = new Product();
		$product->setName('Mesa de centro');
		$product->setPrice('90.00');
		$product->setDescription('Mesa lacada en blanco');
		
		$category = new Category();
		$category->setName('prueba1');    //  
		
		$product->setCategory($category);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($category);
		$em->persist($product);
		
		$em->flush();                    // ... el flush actua haciendo un INSERT con todo los obj que tenga el Doctrine en memoria
		                                 // ... así si persisto 'n' objetos de tipo producto con $em->persist($product);
		                                 // ... flush hará 'n' INSERT usando un sólo objeto em
		return new Response('Producto creado id '.$product->getId());
	}
	
	
	# Lista un producto cuyo identificador se pase por parámetro.
	public function showAction($id)
	{
		$product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
		if (!$product) {
			throw $this->createNotFoundException('Ningun producto tiene esa id '.$id);
		}else{
		    // ... Una vez tengo el obj $product, puedo hacer cosas con él como p.e. pasarlo a una plantilla para visualizarlo
		    $nombre = $product->getName();
		    $precio = $product->getPrice();
		    $descripcion = $product->getDescription();
		    return $this->render('T5b/T5b_id.html.twig', array('identificador' => $id, 'nombre' => $nombre, 'precio' => $precio, 'descripcion' => $descripcion));
		}
	}
	
	
	# Lista todos los productos existentes
	/*	Al realizar una consulta por un determinado objeto, Doctrine siempre utiliza lo que se conoce como "repositorio".
	 *  Estos repositorios son como clases PHP cuyo trabajo consiste en ayudarte a buscar las entidades de una determinada clase.
	 *  Puedes acceder al repositorio de la entidad de una clase mediante el código
	    $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
	*/
	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Product');
		// find *all* products
		$products = $repository->findAll();
		// Aqui debo enviarle el conjunto de productos (el array retornado por findAll()) a la plantilla T5b_all.html.twig para su representacion
		return $this->render('T5b/T5b_all.html.twig', array('listado_productos' => $products));
	}
	
	
	# Crea y almacena un producto con los datos pasados por parámetro, la descripción será la misma que el nombre.
	# y tambien la categoria como ampliación al final de la practica para la relación
	public function createParamAction($name, $price)
	{
		// Añado estas 2 lineas para incorporar la categoria al producto
		$category = new Category();  
		$category->setName(sprintf("Categoria%d",rand(0,10)));
		
		$product = new Product();
		$product->setName($name);
		$product->setPrice($price);
		$product->setDescription($name);
		
		// La siguiente linea relaciona con categoria
		$product->setCategory($category); 
		
		$em = $this->getDoctrine()->getManager();
		
		// La siguiente linea hace persistencia en memoria de momento la category
		$em->persist($category);
		
		$em->persist($product);
		$em->flush();                    
		return new Response('Producto creado id '.$product->getId().' y su categoria id: '.$category->getId());
		
	}
	
	
	# Lista los productos de una categoria en concreto
	public function listByCategoryAction($category){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery('SELECT prod FROM AppBundle:Product prod  WHERE prod.category = :categoria')->setParameter('categoria', $category);
		$products = $query->getResult();
		// Aqui debo enviarle el conjunto de productos (el array retornado por findAll()) a la plantilla T5b_all.html.twig para su representacion
		return $this->render('T5b/T5b_all.html.twig', array('listado_productos' => $products));
	}
	

	# Lista todos los productos clasificados por categoria
	public function listAllByCategoryAction(){
		$em = $this->getDoctrine()->getManager();
		// En este caso no es necesario que le pase como SQL la consulta de todos los articulos ordenados por category, le pasaré toda la colección
		// de artículos con el findAll() y será en la plnatilla twig donde haré la clasificación por categorias
		//$query = $em->createQuery('SELECT prod FROM AppBundle:Product prod  ORDER BY prod.category ASC');
		//$products = $query->getResult();
		$categorias = $em->getRepository('AppBundle:Category')->findAll();
		// Aqui debo enviarle el conjunto de productos (el array retornado por findAll()) a la plantilla T5b_all.html.twig para su representacion
		return $this->render('T5b/T5b_all_prod_by_cat.html.twig', array('listado_categorias' => $categorias));
	}
	
	
	# Elimina el producto indicado de la bbdd
	function deleteAction($id){
		$producto = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
		if (!$producto) {
			throw $this->createNotFoundException('Ningún producto tiene esa id '.$id);
		}else{
			// ... Una vez tengo el obj $producto, puedo hacer cosas con él, en este caso borrarlo
			$em = $this->getDoctrine()->getManager();
			$em->remove($producto);    // primero lo elimino de la memoria
			$em->flush();              // ... el flush actua haciendo un en este caso el commit del DELETE
			return new Response('Producto eliminado');
		}
	}
	
	
	

	# *****************************************************************************************************
	# T6. [Symfony] Formularios y validación. Actividad 1
	# *****************************************************************************************************
	
	# Muestra un formulario de producto através del cual permita persistir la información enviada. 
    # El formulario tendrá dos botones (‘guardar’ y ’guardar y continuar’) con el comportamiento esperado.
    # El formulario producto, deberá mostrar un desplegable con todas las categorías existentes.
	public function newProductAction(Request $request)
	{
		$product = new Product();		
		$form = $this->createForm(new ProductType(), $product);
		$form->handleRequest($request);					# Manejador de envios de formularios
		if ($form->isValid()) {			// Si solo quisiera enviarlo sin validar podria utilizar el mtd ->isSubmitted()
			                            // en el mtd isValid(), lo que importa es que el objeto $product contenga información válida.
			                            // El método $form->isValid() en realidad es un atajo que pregunta al objeto $product si
			                            // tiene datos válidos o no.
			                            // En otras palabras, no importa si el formulario es válido o no, lo que importa es que el objeto
			                            // $product (en este caso) contenga información válida según las restricciones establecidas
			                            // en el fichero del modelo Entity/Product.php
			// Aqui compruebo si el botón que se ha pulsado es el save, si no ha sido ese es el continue
			if ($form->get('save')->isClicked()) { # si isClicked() es cierto se pulsa el save
				// Grabamos el producto
				$em = $this->getDoctrine()->getManager();				
				$em->persist($product);
				$em->flush();
				return new Response('Pulsado save y Producto creado id '.$product->getId());
			}else{ 								   # Pulsado el continue
				if ($form->get('continue')->isClicked()) {
				   $em = $this->getDoctrine()->getManager();
				   $em->persist($product);
				   $em->flush();
				   return $this->redirectToRoute('form_prueba');
				}
			}
		} // del if ($form->isValid())
		
		# Renderizo el form en una plantilla por defecto
		return $this->render('default/new.html.twig', array(
				'form' => $form->createView(),
		));	
	}
	
	
	# *****************************************************************************************************
	# T8. [Symfony] Seguridad. Actividad 1
	# *****************************************************************************************************
	
	# Muestra un formulario de producto ProductEdit() através del cual permite la modificacion y persistir la información enviada.
	# El formulario tendrá el boton (‘guardar’) con el comportamiento esperado.
	public function editAction($id, Request $request)
	{
		// Localizo por el id el Product a modificar
		$product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
		if (!$product) {
			// Si no localiza nada con ese id advierte del error y acaba
			throw $this->createNotFoundException('Ningun producto tiene esa id '.$id);
		}else{
			// ... Si encuentra alguna categoria con ese id Creo el form
			$form = $this->createForm(new ProductEdit(), $product);
	
			$form->handleRequest($request);					# Manejador de envios de formularios
	
			if ($form->isValid()) {
				// Aqui compruebo si el botón que se ha pulsado es el save, si no ha sido ese es el continue
				if ($form->get('save')->isClicked()) { # si isClicked() es cierto se pulsa el save
					$em = $this->getDoctrine()->getManager();
					$em->persist($product);
					$em->flush();
					return new Response('Producto modificado id '.$product->getId());
				}
			} // del if ($form->isValid())
	
			# Renderizo el form en una plantilla por defecto
			return $this->render('default/new.html.twig', array(
			'form' => $form->createView(),
			));
		} // del else
	} // de function editAction
	
}  // del class ProductController extends Controller

?>