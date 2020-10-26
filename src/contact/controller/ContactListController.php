<?php
include_once SRC_PATH . 'controller/Layout.php';
include_once SRC_PATH . 'model/ContactListModel.php';
include_once SRC_PATH . 'model/FilterContactListModel.php';
include_once SRC_PATH . 'model/ContactModel.php';


class ContactListController extends Layout
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


        $filter = new FilterContactListModel($_GET);

        $html = $this->getView('ContactListFilter', [
            'search' => $filter->getSearch()
        ]);


        $contactsModel = new ContactListModel();
        $contacts = array_map(function ($contact) {
            return $this->getView('ContactListItem', [
                'contact' => $contact
            ]);
        }, $contactsModel->getContacts($filter));
        $contacts = implode(null, $contacts);

        $html .= $this->getView('ContactList', [
            'contacts' => $contacts
        ]);


        $html .= $this->getView('ContactListPaginator', [
            'paginator' => $contactsModel->getPaginator($filter)
        ]);

        return $html;
    }
}
