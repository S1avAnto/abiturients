<?php

namespace app\Controllers;

use App\JWT;
use app\View;
use app\Models\HomeModel;

class HomeController
{

    public function index() {

        //var_dump($_COOKIE["Token"]);
        // Сортированные списки абитуриентов по специальностям и балалм егэ
        $homeModel = new HomeModel();

        $allRequestsAndSpecialties = $homeModel->getRequestsBySpecialties();

        $requestsBySpecialties = array();

        foreach ($allRequestsAndSpecialties as $request) {
            // Для каждого направления присваиваем массив заявок
            $requestsBySpecialties[$request["Name_speciality"]][] = [
                "Position" => $request["Position"],
                "Full_name" => $request["Full_name"],
                "Scores" => $request["Scores"],
                "Consent" => $request["Consent"] === 0 ? "Нет" : "Да"
            ];
        }

        if (isset($_COOKIE["Token"])) { // Если пользователь "авторизован"

            try {
                $jwtPayload = JWT::decode($_COOKIE["Token"]); // пытаемся декодировать токен
                                                              // и вытащить payload
            }
            catch (\Exception $exception) { //
                unset($_COOKIE["Token"]);
                setcookie("Token", "", time() - 100); //удаление куки
                echo View::create("ErrorView", [
                    "message"=>$exception
                ]);
                die();
            }

            echo View::create("HomeView", [
                "auth"  =>  true,
                "idUser" => $jwtPayload["id"],
                "profileImgUrl" => $jwtPayload["profileImgUrl"],
                "role"  =>  $jwtPayload["role"],

                "requestsBySpecialties" => $requestsBySpecialties
            ]);


        }
        else {
            echo View::create("HomeView", [
                "auth"=>false,
                "requestsBySpecialties" => $requestsBySpecialties
            ]);
            die();
        }
    }
}