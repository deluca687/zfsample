<?php
namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Post\Model\Post;   
use Post\Form\PostForm;

class PostController extends AbstractActionController
{
    protected $postTable;
 
    public function indexAction()
    {
        return new ViewModel(array(
            'posts' => $this->getPostTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new PostForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = new Post();
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $post->exchangeArray($form->getData());
                $this->getPostTable()->savePost($post);

                return $this->redirect()->toRoute('post');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post', array(
                'action' => 'add'
            ));
        }
        $post = $this->getPostTable()->getPost($id);

        $form  = new PostForm();
        $form->bind($post);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getPostTable()->savePost($form->getData());

                return $this->redirect()->toRoute('post');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getPostTable()->deletePost($id);
            }

            return $this->redirect()->toRoute('post');
        }

        return array(
            'id'    => $id,
            'post' => $this->getPostTable()->getPost($id)
        );
    }
    
    public function getPostTable()
    {
        if (!$this->postTable) {
            $sm = $this->getServiceLocator();
            $this->postTable = $sm->get('Post\Model\PostTable');
        }
        return $this->postTable;
    }
}