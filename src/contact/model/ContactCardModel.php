<?php
include_once 'ContactModel.php';
include_once DB_PATH;

class ContactCardModel {
    public function getContact($id) {
        $db = mysql::getContext();
        $query = 'Select Id_Contact, Name, Phone, Address, Email, Birthday, Image From contact Where Id_Contact = ?;';
        $db->execute($query, ['i', &$id]);
        $contact = $db->fetch_result();
        
        return ContactModel::setContact($contact);
    }
}