<?php
class Viewer {
    private $viewerId;
    private $name;
    private $sex;
    private $mailId;
    private $age;
    private $city;
    private $stateAb;

    public function __construct($viewerId, $name, $sex, $mailId, $age, $city, $stateAb) {
        $this->viewerId = $viewerId;
        $this->name = $name;
        $this->sex = $sex;
        $this->mailId = $mailId;
        $this->age = $age;
        $this->city = $city;
        $this->stateAb = $stateAb;
    }

    // GETTERS
    public function getViewerId() { return $this->viewerId; }
    public function getName() { return $this->name; }
    public function getSex() { return $this->sex; }
    public function getMailId() { return $this->mailId; }
    public function getAge() { return $this->age; }
    public function getCity() { return $this->city; }
    public function getStateAb() { return $this->stateAb; }

    // SETTERS (optional)
    public function setName($name) { $this->name = $name; }
    public function setSex($sex) { $this->sex = $sex; }
    public function setMailId($mailId) { $this->mailId = $mailId; }
    public function setAge($age) { $this->age = $age; }
    public function setCity($city) { $this->city = $city; }
    public function setStateAb($stateAb) { $this->stateAb = $stateAb; }
}
?>
