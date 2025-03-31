<?php

class FroalaEditor {
    private $config;
    private $content;

    public function __construct($options = []) {
        $this->config = array_merge([
            'selector' => '#froala-editor',
            'height' => 300,
            'theme' => 'default',
            'placeholder' => 'Metninizi buraya yazın...',
            'toolbar' => ['bold', 'italic', 'underline', 'strikeThrough', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'undo', 'redo'],
            'imageUpload' => false,
            'videoUpload' => false,
            'fileUpload' => false,
        ], $options);
        $this->content = isset($options['content']) ? $options['content'] : '';
    }

    public function loadAssets() {
        return "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/froala-editor/css/froala_editor.pkgd.min.css'>
                <script src='https://cdn.jsdelivr.net/npm/froala-editor/js/froala_editor.pkgd.min.js'></script>";
    }

    public function render() {
        $jsonConfig = json_encode($this->config);
        return "<script>
document.addEventListener('DOMContentLoaded', function() {
    new FroalaEditor('" . $this->config['selector'] . "', $jsonConfig);
});
</script>";
    }

    public function text($inputName) {
        return isset($_POST[$inputName]) ? trim($_POST[$inputName]) : $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function renderInput($name = 'editor_content', $type = 'textarea') {
        $value = htmlspecialchars($this->text($name));
        if ($type === 'textarea') {
            return "<textarea id='froala-editor' name='$name'>$value</textarea>";
        } elseif ($type === 'input') {
            return "<input id='froala-editor' type='text' name='$name' value='$value'>";
        }
        return '';
    }
}

?>
