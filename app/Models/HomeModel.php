<?php

namespace app\Models;

use App\Model;

class HomeModel extends Model
{

    public function __construct() {
        parent::__construct();
    }

    public function getRequestsBySpecialties() : array {
        // Запрос возвращает таблицу заявок, сортированную по специальности и баллам у студентов, где также есть счётчик (кто какое место в конкурсе)
        $query = "
            SELECT ROW_NUMBER() OVER (PARTITION BY spec.Id_speciality ORDER BY req.Scores DESC) as Position, spec.Id_speciality, spec.Name_speciality, usrs.Id_user, usrs.Full_name, req.Scores, req.Consent 
            FROM abiturients.Specialties as spec
            LEFT JOIN abiturients.Requests as req
            ON spec.Id_speciality=req.Id_speciality
            LEFT JOIN abiturients.Users usrs
            ON req.Id_user=usrs.Id_user
            ORDER BY spec.Name_speciality DESC, req.Scores DESC;
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}