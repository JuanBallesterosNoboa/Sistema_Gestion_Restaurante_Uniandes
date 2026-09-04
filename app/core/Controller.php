<?php
class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }

    protected function redirect(string $url): never {
        header("Location: $url");
        exit;
    }
}
