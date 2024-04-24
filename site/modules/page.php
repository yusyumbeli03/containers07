<?php

class Page {
    private $template;

    public function __construct($template) {
        // Устанавливаем путь к шаблону страницы
        $this->template = $template;
    }

    public function Render($data) {
        // Отображаем страницу, подставляя данные из ассоциативного массива в шаблон
        extract($data); // Извлекаем переменные из массива
        include($this->template); // 
    }
}

?>
