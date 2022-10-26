<?php
class User {
    private $empId;
    private $firstName;
    private $lastName;
    private $dept;
    private $email;
    private $role;

    public function __construct($empId,$firstName,$lastName,$dept,$email,$role) {
        $this->empId = $empId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dept = $dept;
        $this->email = $email;
        $this->role = $role;
    }

    public function getEmpId(){
        return $this->empId;
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