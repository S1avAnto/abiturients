<?php

namespace app\Models;

use App\Model;

class AuthModel extends Model
{

    public function __construct() {
        parent::__construct();
    }

    // Работает
    public function userRegistration(string $mail, string $password, string $profileImgUrl, string $now_date) {
        $query = "
            INSERT INTO abiturients.Users 
            (Id_user, Mail, Password, Profile_img_url, Registration_date)
            VALUES (NULL, :mail, :password, :profile_img_url, :now_date);
            ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'mail' => $mail,
            'password' => $password,
            'profile_img_url' => $profileImgUrl,
            'now_date' => $now_date
        ]);
    }

    public function userExists(string $mail) {
        $query = "SELECT Id_User FROM abiturients.Users WHERE Mail = :mail;";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'mail'=>$mail
        ]);
        $arr = $stmt->fetchAll();
        return count($arr) > 0;
    }

    public function getUserIdByEmail(string $mail) {
        $query = "SELECT Id_User FROM abiturients.Users WHERE Mail = :mail;";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'mail'=>$mail
        ]);
        $arr = $stmt->fetchAll();
        return $arr[0]["Id_User"];
    }

    public function userSetRole(string $userId, string $userRole)
    {
        $query = "
            INSERT INTO abiturients.Roles 
            (Id_user, Role)
            VALUES (:id, :user_role)
            ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id'=>$userId,
            'user_role'=>$userRole
        ]);
    }

    public function checkUserPassword(string $mail, string $password) : bool
    {
        $query = "SELECT COUNT(Id_user) FROM abiturients.Users WHERE Mail = :mail AND Password = :password;";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'mail'=>$mail,
            'password'=>$password
            ]);
        $arr = $stmt->fetchAll();
        return count($arr) > 0;
    }

    public function getInfoForJWTByUserEmail(string $mail)
    {
        $query = "
            SELECT usrs.Id_user, usrs.Profile_img_url, rls.Role
            FROM abiturients.Users as usrs
            LEFT JOIN abiturients.Roles as rls
            ON usrs.Id_user = rls.Id_user
            WHERE usrs.Mail = :mail;
            ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'mail'=>$mail
        ]);
        return $stmt->fetchAll();
    }
}