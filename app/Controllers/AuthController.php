<?php

namespace app\Controllers;

use App\JWT;
use app\Models\AuthModel;
use app\View;


class AuthController
{
    public function registerView() {
        if (isset($_COOKIE["Token"])) {

            if (JWT::validateToken($_COOKIE["Token"])) { // Если токен валиден, то перекидываем на страницу со списками
                header("Location: /");
                die();
            }

            unset($_COOKIE["Token"]); // Если не валиден, то удаляем токен и выводим страницу регистрации
            setcookie("Token", "", time() - 100); // Удаление на стороне клиента
        }
        echo View::create("RegistrationView", [
            "auth" => false
        ]);
        die();
    }

    public function register () {

        $mail = $_POST["mail"];

        $authModel = new AuthModel();

        if ($authModel->userExists($mail)) {
            $_SESSION["messageError"] = "Данная почта занята";
            header("Location: /registration"); //решает проблему повторной отправки формы при обновлении
            die();
        }

        $password = password_hash($_POST["password_1"], PASSWORD_BCRYPT, ['cost' => 12]);

        $authModel->userRegistration($mail, $password, "./img/default.jpg", date('Y-m-d'));

        $userId = $authModel->getUserIdByEmail($mail);

        $authModel->userSetRole($userId, __USER__);

        $jwt = JWT::encode($userId, "default.jpg", __ADMIN__);

        setcookie("Token", $jwt);

        header("Location: /profile");
        die();
    }

    public function loginView() {
        if (isset($_COOKIE["Token"])) {

            if (JWT::validateToken($_COOKIE["Token"])) { //Если токен валиден, то перекидываем на страницу со списками
                header("Location: /");
                die();
            }

            unset($_COOKIE["Token"]); // Если не валиден, то удаляем токен и выводим страницу логина
            setcookie("Token", "", time() - 100);
        }

        echo View::create("LoginView", [
            "auth" => false
        ]);
        die();
    }

    public function login () {

        $mail = $_POST["mail"];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT, ['cost' => 12]);
        $authModel = new AuthModel();

        if (!$authModel->userExists($mail) | !$authModel->checkUserPassword($mail, $password)) {
            $_SESSION["messageError"] = "Не верный логин или пароль";
            header("Location: /login"); //решает проблему повторной отправки формы при обновлении
            die();
        }

        $userJWTInfo = $authModel->getInfoForJWTByUserEmail($mail);
        $jwt = JWT::encode($userJWTInfo[0]["Id_user"], $userJWTInfo[0]["Profile_img_url"], $userJWTInfo[0]["Role"]);

        setcookie("Token", $jwt);

        header("Location: /");
        die();
    }

    public function logout() {
        unset($_COOKIE["Token"]);
        setcookie("Token", "", time() - 100);
        header("Location: /login");
    }

}