<?php 
    class Contact {
        public $id;
        public $name;
        public $phone;
        public $email;
        public $image;
        public $address;
        public $birthday;
		
		public function __construct($id, $name, $phone, $address = null, $email = null, $birthday = null, $image = null)
		{
			$this->id = htmlspecialchars($id);
            $this->name = htmlspecialchars($name);
            $this->phone = htmlspecialchars($phone);

            $this->image = $image;
            $this->email = empty($email) ? null : htmlspecialchars($email);
            $this->address = empty($address) ? null : htmlspecialchars($address);
            $this->birthday = empty($birthday) ? null : htmlspecialchars($birthday);
        }

        public function isImageExist() {
            if (!isset($this->image)) return false;

            return file_exists($_SERVER['DOCUMENT_ROOT'].'/addressbook/userImages/'.$this->image);
        }
}
?>