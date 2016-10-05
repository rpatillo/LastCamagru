<?PHP
namespace Core\HTML;

class BootstrapForm extends Form {

    protected function surround($html) {
        return "<div class=\"form-group\">{$html}</div>";
    }

    /**
     * @param $name
     * @param $label
     * @param array $options
     * @return string
     */
    public function input($name, $label, $options = []) {
        $type = isset($options['type']) ? $options['type'] : 'text';
        return $this->surround(
            '<label>' . $label . '</label><input type="' . $type . '" name="' . $name . '" value ="' . $this->getValue($name) . '" class="form-control">'
        );   
    }

    public function submit () {
        return $this->surround('<button type="submit">Envoyer</button>');
    }
}