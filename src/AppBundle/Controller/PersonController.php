<?php
// src/AppBundle/Controller/PersonController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\PersonType; // Añado esta nueva declaración para la creación de forms

class PersonController extends Controller
{
	# *****************************************************************************************************
	# T6. [Symfony] Formularios y validación. Actividad 2
	# *****************************************************************************************************
	
	# Muestra un formulario de person através del cual permita persistir la información enviada.
	# El formulario tendrá dos botones (‘guardar’ y ’guardar y continuar’) con el comportamiento esperado.
	public function newAction(Request $request)
	{
		// ... Creo persona
		$person = new Person();
		$form = $this->createForm(new PersonType(), $person);
	
		$form->handleRequest($request);					# Manejador de envios de formularios
	
		if ($form->isValid()) {			// Si solo quisiera enviarlo sin validar podria utilizar el mtd ->isSubmitted()
			// en el mtd isValid(), lo que importa es que el objeto $product contenga información válida.
			// El método $form->isValid() en realidad es un atajo que pregunta al objeto $product si
			// tiene datos válidos o no.
			// Aqui compruebo si el botón que se ha pulsado es el save, si no ha sido ese es el continue
			if ($form->get('save')->isClicked()) { # si isClicked() es cierto se pulsa el save
				$em = $this->getDoctrine()->getManager();
				$em->persist($person);
				$em->flush();                    // ... el flush actua haciendo un INSERT con todo los obj que tenga el Doctrine en memoria
				// ... así si persisto 'n' objetos con $em->persist($product);
				// ... flush hará 'n' INSERT usando un sólo objeto em
				return new Response('Persona creada id '.$person->getId().' y con nombre: '.$person->getName());
			}else{ 								   # Pulsado el continue
				if ($form->get('continue')->isClicked()) {
					$em = $this->getDoctrine()->getManager();
					$em->persist($person);
					$em->flush();
					return $this->redirectToRoute('form_nuevaPersona');
				}
			}
		} // del if ($form->isValid())
	
		# Renderizo el form en una plantilla por defecto
		return $this->render('default/new.html.twig', array(
		'form' => $form->createView(),
		));
	
	}
	
	// Listado reducido de las personas existentes con opción de mostrar detalles y eliminar
	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Person');
		// find *all* persons
		$personas = $repository->findAll();
		// Renderizo enviando el conjunto de personas (el array retornado por findAll()) a la plantilla T5b_all_person.html.twig para su representacion
		return $this->render('T5b/T5b_all_persons.html.twig', array('listado_personas' => $personas));
	}
	
	# Muestra información detallada de la persona
	public function showAction($id)
	{
		$persona = $this->getDoctrine()->getRepository('AppBundle:Person')->find($id);
		if (!$persona) {
			throw $this->createNotFoundException('Ninguna persona tiene esa id '.$id);
		}else{
			// ... Una vez tengo el obj $person, puedo hacer cosas con él como p.e. pasarlo a una plantilla para visualizarlo
			// Primero saco toda la innformación del obj con sus respectivos gets
			$nombre = $persona->getName();
			$age = $persona->getAge();
			$birthDate = $persona->getBirthDate();
			$height = $persona->getHeight();
			$email = $persona->getEmail();
			$phone = $persona->getPhone();
			if ($persona->getGender() == 'm') {
				$gender = "Masculino";
			} else {
				$gender = "Femenino";
			}
			$descends = $persona->getDescends();
			// Vehiculo es integer pero lo trato como bollean al ser 0 o 1
			if ($persona->getVehicle()) {
				$vehicle = "SI";
			} else {
				$vehicle = "NO";
			}
			// Lengua preferida
			$preferredLanguage = $persona->getPreferredLanguage();
			switch ($preferredLanguage){
				case'vlc':
					$lenguaPreferida = 'Valenciano';	
					break;
				case'cs':
					$lenguaPreferida = 'Castellano';
					break;
				case'uk':
					$lenguaPreferida = 'Ingles';
					break;
				case'gr':
					$lenguaPreferida = 'Aleman';
					break;
				case'fr':
					$lenguaPreferida = 'Frances';
					break;
				case'it':
					$lenguaPreferida = 'Italiano';
					break;
			}
			// Nivel de ingles
			$englishLevel = $persona->getEnglishLevel();
			switch ($englishLevel){
				case 1:
					$nivelIngles = 'A1';
					break;
				case 2:
					$nivelIngles = 'A2';
					break;
				case 3:
					$nivelIngles = 'B1';
					break;
				case 4:
					$nivelIngles = 'B2';
					break;
				case 5:
					$nivelIngles = 'C1';
					break;
				case 6:
					$nivelIngles = 'C2';
					break;
			}
			$personalWebSite = $persona->getPersonalWebSite();
			$cardNumber = $persona->getCardNumber();
			$IBAN = $persona->getIBAN();
			// Y ahora lo tiro a la visualización renderizando con plantilla personalizada
			return $this->render('T5b/T5b_id_person.html.twig', 
					array('identificador' => $id, 'nombre' => $nombre, 'edad' => $age, 'fecha_nacimiento' => $birthDate,
						  'altura' => $height, 'email' => $email, 'telefono' => $phone, 'sexo' => $gender,
						  'descendientes' => $descends, 'vehiculo' => $vehicle, 'lenguage' => $lenguaPreferida,
						  'nivel_ingles' => $nivelIngles, 'web' => $personalWebSite, 'targeta' => $cardNumber, 'iban' => $IBAN));
		}
	}
	
	# Borra la persona pasada por parametro
	public function deleteAction($id){
		$persona = $this->getDoctrine()->getRepository('AppBundle:Person')->find($id);
		if (!$persona) {
			throw $this->createNotFoundException('Ninguna persona tiene esa id '.$id);
		}else{
			// ... Una vez tengo el obj $persona, puedo hacer cosas con él, en este caso borrarlo
			$em = $this->getDoctrine()->getManager();
			$em->remove($persona);     // primero lo elimino de la memoria
			$em->flush();              // ... el flush actua haciendo el commit del DELETE
			return new Response('Persona eliminada');
		}
	}
	
}