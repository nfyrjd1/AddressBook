<?php
class DB
{
    private $db;
    public $pageSize = 10;
    private $db_name = 'addressbook';
    private $db_user = 'user';
    private $db_pass = '1234';
    private $db_host = 'localhost';

    public function __construct()
    {
        include_once('contact.php');
    }

    public function connect()
    {
        $this->db = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if (mysqli_connect_errno()) {
            throw new Exception('Ошибка при подключении к серверу');
        }
    }

    public function getContacts($pageNum = 1, $pageSize = 10, $search = null)
    {
        $pageSize = $pageSize > 0 ? $pageSize : $this->pageSize;
        $pageNum = $pageNum > 0 ? ($pageNum - 1) * $pageSize : 0;
        $this->pageSize = $pageSize;
        $this->connect();
        $query = 'Select Id_Contact, Name, Phone, Address, Email, Birthday, Image From contact Where Lower(Name) Like Lower(IFNULL(?, Name)) Limit ?,?;';
        $stmt = $this->db->prepare($query);

        if (isset($search)) {
            $search = "%$search%";
        }
        
        $stmt->bind_param('sii', $search, $pageNum, $pageSize);
        $stmt->execute();
        $stmt->store_result();

        $id = null;
        $name = null;
        $phone = null;
        $email = null;
        $address = null;
        $birthday = null;
        $image = null;
        $contacts = [];

        $stmt->bind_result($id, $name, $phone, $email, $address, $birthday, $image);
        while ($stmt->fetch()) {
            array_push($contacts, new Contact($id, $name, $phone, $email, $address, $birthday, $image));
        }

        $stmt->free_result();
        $this->db->close();

        return $contacts;
    }

    public function getContactsCount($search = null)
    {
        $this->connect();
        $query = 'Select Count(Id_Contact) ContactsCount From contact Where Lower(Name) Like Lower(IFNULL(?, Name));';
        $stmt = $this->db->prepare($query);
        if (isset($search)) {
            $search = "%$search%";
        }
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $stmt->store_result();

        $count = 0;
        $stmt->bind_result($count);
        $stmt->fetch();

        $stmt->free_result();
        $this->db->close();

        return $count;
    }

    public function addContact($contact) {
        try {
            $this->connect();
            $query = 'Insert Into contact (Name, Phone, Address, Email, Birthday) Values(?, ?, ?, ?, ?);';

            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssss', $contact->name, $contact->phone, $contact->address, $contact->email, $contact->birthday);
            $stmt->execute();

            $id = mysqli_insert_id($this->db);
            if (isset($contact->image)) {
                $imageName = $id.$contact->image['name'];
                move_uploaded_file($contact->image['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/addressbook/userImages/'.$imageName);

                $query = 'Update contact Set Image = ? Where Id_Contact = ?;';
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('si', $imageName, $id);
                $stmt->execute();
            }
            $this->db->close();

            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function updateContact($contact) {
        try {
            $this->connect();
            $query = 'Update contact Set Name = ?, Phone = ?, Address = ?, 
                Email = ?, Birthday = ?, Image = IFNULL(?, Image) Where Id_Contact = ?;';

            if (isset($contact->image)) {
                $imageName = $contact->id.$contact->image['name'];
                move_uploaded_file($contact->image['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/addressbook/userImages/'.$imageName);
                $contact->image = $imageName;
            }

            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssssssi', $contact->name, $contact->phone, $contact->address, 
            $contact->email, $contact->birthday, $contact->image, $contact->id);
            
            $stmt->execute();
            $this->db->close();

            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function getContact($id) {
        $this->connect();
        $query = 'Select Id_Contact, Name, Phone, Address, Email, Birthday, Image From contact Where Id_Contact = ?;';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();

        $id = null;
        $name = null;
        $phone = null;
        $email = null;
        $address = null;
        $birthday = null;
        $image = null;

        $stmt->bind_result($id, $name, $phone, $email, $address, $birthday, $image);
        $stmt->fetch();
        $contact = new Contact($id, $name, $phone, $email, $address, $birthday, $image);
        $stmt->free_result();
        $this->db->close();

        return $contact;
    }
}

?>
