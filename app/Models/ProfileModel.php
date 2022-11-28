<?php

declare(strict_types=1);

namespace app\Models;

use App\Model;

class ProfileModel extends Model
{

    public function __construct() {
        parent::__construct();
    }

    public function getAcademicSubjects() : array
    {
        $query = 'SELECT Name FROM abiturients.Academic_subjects;';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function setExamResultsByUserId(string $userId, string $subjectId, string $subjectResults)
    {
        $query = "INSERT INTO abiturients.Exam_results 
        (Id_user, Id_subject, Points) 
        VALUES (:userId, :subjectId, :subjectResults)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            "userId"=>$userId,
            "subjectId"=>$subjectId,
            "subjectResults"=>$subjectResults
        ]);
    }

    public function getSubjectIdBySubjectName(string $subjectName) {
        $query = 'SELECT Id_subject 
                  FROM abiturients.Academic_subjects as acs
                  WHERE Name = :subjectName';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            "subjectName"=>$subjectName
        ]);
        return $stmt->fetchAll();
    }

    //чтобы пользователь не добавил уже добавленный предмет *Пользователь уже добавил предмет?*
    public function userSubjectExistByUserIdAndSubjectId(string $userId, string $subjectId)
    {
        $query = 'SELECT * FROM abiturients.Exam_results AS es
                  WHERE Id_user = :userId AND Id_subject = :subjectId;';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            "userId"=>$userId,
            "subjectId"=>$subjectId
        ]);
        $results = $stmt->fetchAll();
        return count($results) !== 0;
    }

    public function getUserEgeResultsByUserId(string $userId)
    {
        $query = 'SELECT aas.Name, aer.Points 
                  FROM abiturients.Exam_results AS aer 
                  LEFT JOIN abiturients.Academic_subjects as aas 
                  ON aer.Id_subject=aas.Id_subject 
                  WHERE aer.Id_user = :userId';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            "userId"=>$userId
        ]);
        return $stmt->fetchAll();
    }

    public function getSpecialties()
    {
        $query = 'SELECT Name_speciality
                  FROM abiturients.Specialties;';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserNameByUserId(string $userId)
    {
        $query = 'SELECT Full_name
                  FROM abiturients.Users
                  WHERE Id_user = :userId;';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            "userId" => $userId
        ]);
        return $stmt->fetchAll()[0];
    }

    public function setUsernameByUserId(string $userId, string $username)
    {
        $query = 'UPDATE abiturients.Users
                  SET Full_name = :username
                  WHERE Id_user = :userId;';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            "userId" => $userId,
            "username" => $username
        ]);
    }
}