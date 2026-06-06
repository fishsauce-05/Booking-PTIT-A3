<?php

namespace App\Core;

class View
{
    public static function render(string $template, array $data = [], string $layout = 'app'): string
    {
        $viewFile = base_path('src/Views/' . $template . '.php');
        if (!is_file($viewFile)) {
            throw new \RuntimeException("View {$template} not found.");
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout === '') {
            return $content;
        }

        $layoutFile = base_path("src/Views/layouts/{$layout}.php");
        if (!is_file($layoutFile)) {
            return $content;
        }

        ob_start();
        require $layoutFile;
        return ob_get_clean();
    }
}
