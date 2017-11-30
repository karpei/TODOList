<?php

namespace star\TODOBundle\Controller;

use star\TODOBundle\Entity\Tasks;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * Task controller.
 *
 */
class TasksController extends Controller
{
    /**
     * Lists all task entities.
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUsername();
        $tasks = $em->getRepository('starTODOBundle:Tasks')->findBy(array('user'=> $user));
        //$tasks = $em->getRepository('starTODOBundle:Tasks')->findAll();
        return $this->render('Tasks/index.html.twig', array(
            'tasks' => $tasks
        ));
    }

    /**
     * Creates a new task entity.
     *
     */
    public function newAction(Request $request)
    {
        $task = new Tasks();
        $form = $this->createForm('star\TODOBundle\Form\TasksType', $task);
        $form->handleRequest($request);
        $task->setStatus(0)->setUser($this->get('security.token_storage')->getToken()->getUsername())->setCreateat(new \DateTime('now'));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('tasks_show', array('id' => $task->getId()));
        }

        return $this->render('Tasks/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a task entity.
     *
     */
    public function showAction(Tasks $task)
    {
        if($task->getUser() == $this->get('security.token_storage')->getToken()->getUsername()) {
            $deleteForm = $this->createDeleteForm($task);
            return $this->render('Tasks/show.html.twig', array(
                'task' => $task,
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirectToRoute('tasks_index');
        }
    }

    /**
     * Displays a form to edit an existing task entity.
     *
     */
    public function editAction(Request $request, Tasks $task)
    {
        if($task->getUser() == $this->get('security.token_storage')->getToken()->getUsername()) {
            $deleteForm = $this->createDeleteForm($task);
            $editForm = $this->createForm('star\TODOBundle\Form\EditType', $task);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('tasks_edit', array('id' => $task->getId()));
            }

            return $this->render('Tasks/edit.html.twig', array(
                'task' => $task,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirectToRoute('tasks_index');
        }
    }

    /**
     * Deletes a task entity.
     *
     */
    public function deleteAction(Request $request, Tasks $task)
    {
        if($task->getUser() == $this->get('security.token_storage')->getToken()->getUsername()) {
            $form = $this->createDeleteForm($task);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($task);
                $em->flush();
            }
        }
        return $this->redirectToRoute('tasks_index');
    }

    /**
     * Creates a form to delete a task entity.
     *
     * @param Tasks $task The task entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tasks $task)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tasks_delete', array('id' => $task->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
