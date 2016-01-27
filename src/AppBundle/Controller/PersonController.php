<?php
// src/AppBundle/Controller/PersonController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\PersonType; // A�ado esta nueva declaraci�n para la creaci�n de forms

class PersonController extends Controller
{
	# *****************************************************************************************************
	# T6. [Symfony] Formularios y validaci�n. Actividad 2
	# *****************************************************************************************************
	
	# Muestra un formulario de person atrav�s del cual permita persistir la informaci�n enviada.
	# El formulario tendr� dos botones (�guardar� y �guardar y continuar�) con el comportamiento esperado.
	public function newAction(Request $request)
	{
		// ... Creo persona
		$person = new Person();
		$form = $this->createForm(new PersonType(), $person);
	
		$form->handleRequest($request);					# Manejador de envios de formularios
	
		if ($form->isValid()) {			// Si solo quisiera enviarlo sin validar podria utilizar el mtd ->isSubmitted()
			// en el mtd isValid(), lo que importa es que el objeto $product contenga informaci�n v�lida.
			// El m�todo $form->isValid() en realidad es un atajo que pregunta al objeto $product si
			// tiene datos v�lidos o no.
			// Aqui compruebo si el bot�n que se ha pulsado es el save, si no ha sido ese es el continue
			if ($form->get('save')->isClicked()) { # si isClicked() es cierto se pulsa el save
				$em = $this->getDoctrine()->getManager();
				$em->persist($person);
				$em->flush();                    // ... el flush actua haciendo un INSERT con todo los obj que tenga el Doctrine en memoria
				// ... as� si persisto 'n' objetos con $em->persist($product);
				// ... flush har� 'n' INSERT usando un s�lo objeto em
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
	
	// Listado reducido de las personas existentes con opci�n de mostrar detalles y eliminar
	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Person');
		// find *all* persons
		$personas = $repository->findAll();
		// Renderizo enviando el conjunto de personas (el array retornado por findAll()) a la plantilla T5b_all_person.html.twig para su representacion
		return $this->render('T5b/T5b_all_persons.html.twig', array('listado_personas' => $personas));
	}
	
	# Muestra informaci�n detallada de la persona
	public function showAction($id)
	{
		$persona = $this->getDoctrine()->getRepository('AppBundle:Person')->find($id);
		if (!$persona) {
			throw $this->createNotFoundException('Ninguna persona tiene esa id '.$id);
		}else{
			// ... Una vez tengo el obj $person, puedo hacer cosas con �l como p.e. pasarlo a una plantilla para visualizarlo
			// Primero saco toda la innformaci�n del obj con sus respectivos gets
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
			// Y ahora lo tiro a la visualizaci�n renderizando con plantilla personalizada
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
			// ... Una vez tengo el obj $persona, puedo hacer cosas con �l, en este caso borrarlo
			$em = $this->getDoctrine()->getManager();
			$em->remove($persona);     // primero lo elimino de la memoria
			$em->flush();              // ... el flush actua haciendo el commit del DELETE
			return new Response('Persona eliminada');
		}
	}
	
}