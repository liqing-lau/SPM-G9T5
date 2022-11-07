<?php
class User {
    private $staff_ID;
    private $firstName;
    private $lastName;
    private $dept;
    private $email;
    private $role;

    public function __construct($staff_ID,$firstName,$lastName,$dept,$email,$role) {
        $this->staff_ID = $staff_ID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dept = $dept;
        $this->email = $email;
        $this->role = $role;
    }

    public function getStaffID(){
        return $this->staff_ID;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getDept(){
        return $this->dept;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getRole(){
        return $this->role;
    }
}

?>