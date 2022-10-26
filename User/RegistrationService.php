<?php
require_once("../DAO/common.php");
class RegistrationService {

    private jobRoleDAO $_courseDAO;

    function __construct()
    {
        $this->init();
    }

    private function init() {
        $this->_courseDAO = new jobRoleDAO();
    }

    public function registrationDataByJobRoleId($jobRoleId, $userId) {
        $allCourses = $this -> _courseDAO->getIndividualCourseSkill($jobRoleId);
        $userRegistration = $this -> _courseDAO->getCourseTaken($userId);
        $result = $this -> processCourseSkillRegistrationData($allCourses,$userRegistration);

        return $result;
    }

    private function processCourseSkillRegistrationData($courses, $registration) {
        $coursesRegistration = [];

        foreach($courses as $c) {
            $combined = [
                'skill' => $c[
                    'Skill_Name'
                ],
                'course' => $c['Course_ID'],
                'registered' => '',
                'completed' => ''
            ];
            
            foreach($registration as $r) {
                if($c['Course_ID'] == $r['Course_ID']) {
                    $combined['registered' ]= $r['Reg_Status'];
                    $combined['completed'] = $r['Completion_Status'];
                }    
            }
            array_push($coursesRegistration, $combined);
        }

        return $coursesRegistration;
    }
}
?>