<?php
declare(strict_types=1);
namespace app;
use app\Exceptions\ViewNotFoundException;
class View
{

    public function __construct(protected string $template, protected array $params) {}

    public static function create(string $template, array $params = []) : static {
        return new static($template, $params);
    }

    public function render() : string {
        $template = __VIEW_PATH__ . $this->template . ".php";

        if (!file_exists($template)) {
            throw new ViewNotFoundException();
        }

        ob_start();

        include $template;

        return (string) ob_get_clean(); //возвращает, например, HomeView.php в виде текста
    }

    public function __toString() : string {
        return $this->render();
    }

}