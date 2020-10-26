<?php
include_once SRC_PATH.'controller/Layout.php';
include_once SRC_PATH.'controller/Error404Controller.php';
include_once SRC_PATH.'model/ContactCardModel.php';


class ContactController extends Layout
{
    public function process()
    {
        if (isset($_POST['id'])) {
            $errors = ContactModel::processContact($_POST);
            if (isset($errors)) {
                return $html = $this->getView('Error', [
                    'errors' => $errors,
                    'redirect' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'
                ]);
            }
        }

        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $contactCardModel = new ContactCardModel();
            $contact = $contactCardModel->getContact($id);
            if ($contact) {
                $html = $this->getView('ContactCard', [
                    'contact' => $contact
                ]);
            }
        }

        if (!isset($html)) {
            $controller = new Error404Controller();
            $html = $controller->process();
        }

        return $html;
    }
}
