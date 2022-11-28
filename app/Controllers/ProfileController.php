<?php

namespace app\Controllers;

use App\JWT;
use app\Models\ProfileModel;
use app\View;

class ProfileController
{
    public function ProfileView() {
        if (isset($_COOKIE["Token"])) { // Если пользователь имеет на клиенте токен

            try {
                $jwtPayload = JWT::decode($_COOKIE["Token"]); // пытаемся декодировать токен
                // и вытащить payload
            }
            catch (\Exception $exception) { // Если токен не валиден
                unset($_COOKIE["Token"]);
                setcookie("Token", "", time() - 100); //удаление куки
                echo View::create("ErrorView", [
                    "message"=>$exception
                ]);
                die();
            }

            $userId = $jwtPayload["id"];

            $profileModel = new ProfileModel();

            //$userFullName = $profileModel->getUserFullNameByUserId($userId);
            //$userRequests = $profileModel->getUserRequestsByUserId($userId);
            $userEgeResults = $profileModel->getUserEgeResultsByUserId($userId);
            $userName = $profileModel->getUserNameByUserId($userId)["Full_name"];

            $allAcademicSubjects = $profileModel->getAcademicSubjects();

            $allSpecialties = $profileModel->getSpecialties();

            echo View::create("ProfileView", [
                "auth"  =>  true,
                "idUser" => $userId,
                "userFullName" => $userName,
                "profileImgUrl" => $jwtPayload["profileImgUrl"],
                "role"  =>  $jwtPayload["role"],
                "userEgeResults" => $userEgeResults,
                "allAcademicSubjects" => $allAcademicSubjects,
                "allSpecialties" => $allSpecialties
            ]);
            unset($_SESSION["messageError"]);
        }
        else { // Если пользователь не авторизован -> перекидываем на логин
            header("Location: /login");
            die();
        }

    }

    public function changeUsername() {
        if (isset($_COOKIE["Token"])) { // Если пользователь имеет на клиенте токен

            try {
                $jwtPayload = JWT::decode($_COOKIE["Token"]); // пытаемся декодировать токен
                // и вытащить payload
            }
            catch (\Exception $exception) { // Если токен не валиден
                unset($_COOKIE["Token"]);
                setcookie("Token", "", time() - 100); //удаление куки
                echo View::create("ErrorView", [
                    "message"=>$exception
                ]);
                die();
            }

            $userId = $jwtPayload["id"];

            $username = $_POST["userFullName"];
            $profileModel = new ProfileModel();
            $profileModel->setUsernameByUserId($userId, $username);
            header("Location: /profile");
            die();


        }
        else { // Если пользователь не авторизован -> перекидываем на логин
            header("Location: /login");
            die();
        }
    }

    public function addEgeResults() {

        unset($_SESSION["messageError"]);

        if (isset($_COOKIE["Token"])) { // Если пользователь имеет на клиенте токен

            try {
                $jwtPayload = JWT::decode($_COOKIE["Token"]); // пытаемся декодировать токен
                // и вытащить payload
            }
            catch (\Exception $exception) { // Если токен не валиден
                unset($_COOKIE["Token"]);
                setcookie("Token", "", time() - 100); //удаление куки
                echo View::create("ErrorView", [
                    "message"=>$exception
                ]);
                die();
            }

            $userId = $jwtPayload["id"];

            $subject = $_POST["subject"];
            $subjectResults = $_POST["subject_result"];
            $profileModel = new ProfileModel();

            $subjectsFromDb = $profileModel->getAcademicSubjects();
            $subjectInSubjectsFromDbFlag = false;
            foreach ($subjectsFromDb as $subjectFromDb) {
                if (strcmp($subject, $subjectFromDb["Name"]) === 0) {
                    $subjectInSubjectsFromDbFlag = true;
                }
            }

            $subjectId = $profileModel->getSubjectIdBySubjectName($subject);
            if (isset($subjectId[0]["Id_subject"])) {
                $subjectId = $subjectId[0]["Id_subject"];
            }
            else {
                $subjectId = null;
            }
            if ($subjectId !== null
                && !empty($subject) && !empty($subjectResults)
                && $subjectInSubjectsFromDbFlag
                && $subjectResults > 0 && $subjectResults < 100
                && !$profileModel->userSubjectExistByUserIdAndSubjectId($userId, $subjectId)) {

                $profileModel->setExamResultsByUserId($userId, $subjectId, $subjectResults);
            }
            else {
                $_SESSION["messageError"] = "Предмет либо уже существует, либо неверные введённые данные";
            }
            header("Location: /profile");
            die();


        }
        else { // Если пользователь не авторизован -> перекидываем на логин
            header("Location: /login");
            die();
        }


    }

}