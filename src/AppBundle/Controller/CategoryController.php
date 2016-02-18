<?php
// src/AppBundle/Controller/CategoryController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\CategoryType; // Añado estas nuevas declaraciones para la creaciones de forms

class CategoryController extends Controller
{
	# Crea una categoria con el valor pasado por parametro, el id automático según consta en AppBundle\Entity\Category.php * @ORM\Id # * @ORM\GeneratedValue(strategy="AUTO")
	public function createAction($name)
	{
		// ... Creo categoria
		$category = new Category();
		$category->setName($name);	
		$em = $this->getDoctrine()->getManager();
		$em->persist($category);
		$em->flush();                    // ... el flush actua haciendo un INSERT con todo los obj que tenga el Doctrine en memoria
		// ... así si persisto 'n' objetos con $em->persist($product);
		// ... flush hará 'n' INSERT usando un sólo objeto em
		return new Response('Categoria creada id '.$category->getId().' y con nombre: '.$category->getName());
	}
	
	# Borra la categoria pasada por parametro
	public function deleteAction($id){
		$category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
		if (!$category) {
			throw $this->createNotFoundException('Ninguna categoria tiene esa id '.$id);
		}else{
			// ... Una vez tengo el obj $category, puedo hacer cosas con él, en este caso borrarlo
			$em = $this->getDoctrine()->getManager();
			$em->remove($category);    // primero lo elimino de la memoria
			$em->flush();              // ... el flush actua haciendo un en este caso el commit del DELETE
			return new Response('Categoria eliminada');
		}
	}
	
	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Category');
		// find *all* products
		$categorys = $repository->findAll();
		// Aqui debo enviarle el conjunto de categorias (el array retornado por findAll()) a la plantilla T5b_all_Cat.html.twig para su representacion
		return $this->render('T5b/T5b_all_cat.html.twig', array('listado_categorias' => $categorys));
	}
	
	
	# *****************************************************************************************************
	# T6. [Symfony] Formularios y validación. Actividad 1
	# *****************************************************************************************************
	
	# Muestra un formulario de categoria através del cual permita persistir la información enviada.
	# El formulario tendrá dos botones (‘guardar’ y ’guardar y continuar’) con el comportamiento esperado.
	public function newCategoryAction(Request $request)
	{
		// ... Creo categoria
		$category = new Category();
		$form = $this->createForm(new CategoryType(), $category);
	
		$form->handleRequest($request);					# Manejador de envios de formularios
	
		if ($form->isValid()) {			// Si solo quisiera enviarlo sin validar podria utilizar el mtd ->isSubmitted()
			// en el mtd isValid(), lo que importa es que el objeto $product contenga información válida.
			// El método $form->isValid() en realidad es un atajo que pregunta al objeto $product si
			// tiene datos válidos o no.
			// Aqui compruebo si el botón que se ha pulsado es el save, si no ha sido ese es el continue
			if ($form->get('save')->isClicked()) { # si isClicked() es cierto se pulsa el save
				$em = $this->getDoctrine()->getManager();
				$em->persist($category);
				$em->flush();                    // ... el flush actua haciendo un INSERT con todo los obj que tenga el Doctrine en memoria
				// ... así si persisto 'n' objetos con $em->persist($product);
				// ... flush hará 'n' INSERT usando un sólo objeto em
				return new Response('Categoria creada id '.$category->getId().' y con nombre: '.$category->getName());
			}else{ 								   # Pulsado el continue
				if ($form->get('continue')->isClicked()) {
				    $em = $this->getDoctrine()->getManager();
				    $em->persist($category);
				    $em->flush();
				    return $this->redirectToRoute('form_nuevaCategoria');
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
	
	# Muestra un formulario de categoria CategoryEdit() através del cual permite la modificacion y persistir la información enviada.
	# El formulario tendrá el boton (‘guardar’) con el comportamiento esperado.
	public function editAction($id, Request $request)
	{
		// Localizo por el id la categoria a modificar
		$category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($id);
		if (!$category) {
			// Si no localiza nada con ese id advierte del error y acaba
			throw $this->createNotFoundException('Ninguna categoria tiene esa id '.$id);
		}else{
			// ... Si encuentra alguna categoria con ese id Creo el form
			$form = $this->createForm(new CategoryType(), $category);
		
			$form->handleRequest($request);					# Manejador de envios de formularios
		
			if ($form->isValid()) {			
				// Aqui compruebo si el botón que se ha pulsado es el save
				if ($form->get('save')->isClicked()) { # si isClicked() es cierto se pulsa el save
					$em = $this->getDoctrine()->getManager();
					$em->persist($category);
					$em->flush();                    
					return new Response('Categoria modificada id '.$category->getId());
				}
			} // del if ($form->isValid())
		
			# Renderizo el form en una plantilla por defecto
			return $this->render('default/new.html.twig', array(
			'form' => $form->createView(),
			));
		} // del else
	} // de function editAction
	
} // del class CategoryController extends Controller

?>