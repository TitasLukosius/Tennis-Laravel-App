<?php

/**
 * funkcija skirta formos atributam
 * @param array $attributes
 * @return string
 */
if (!function_exists('html_attr')) {
    function html_attr(array $attributes): string
    {
        $result = '';
        foreach ($attributes as $key => $value) {
            $result .= "$key=\"$value\"";
        }

        return $result;
    }
}

/**
 * @param array $field
 * @param $field_id
 * @param $option_id
 * @return string
 */
if (!function_exists('radio_attr')) {
    function radio_attr(array $field, string $field_id, $option_id): string
    {
        $option = $field['options'][$option_id];
        $checked = ($field['value'] ?? null) == $option['value'];
        $attrs = $field['extra']['attr'] ?? [];
        $attrs += [
            'name' => $field_id,
            'type' => 'radio',
            'value' => $option['value'] ?? '',
        ];

        if ($checked) {
            $attrs += [
                'checked' => true
            ];
        }

        return html_attr($attrs);
    }
}

/**
 * @param $field_id
 * @param $field
 * @return string
 */
if (!function_exists('input_attr')) {
    function input_attr(string $field_id, array $field): string
    {
        $attrs = $field['extra']['attr'] ?? [];
        $attrs += [
            'name' => $field_id,
            'type' => $field['type'],
            'value' => $field['value'] ?? '',
        ];

        return html_attr($attrs);
    }
}

/**
 * @param string $field_id
 * @param array $field
 * @return string
 */
if (!function_exists('select_attr')) {
    function select_attr(string $field_id, array $field): string
    {
        $attrs = $field['extra']['attr'] ?? [];
        if (isset($field['extra']['attr']['multiple'])) {
            $attrs += [
                'name' => $field_id . '[]',
            ];
        } else {
            $attrs += [
                'name' => $field_id,
            ];
        }

        return html_attr($attrs);
    }
}

/**
 * @param string $option_id
 * @param array $field
 * @return string
 */
if (!function_exists('option_attr')) {
    function option_attr(string $option_id, array $field): string
    {

        $attrs = [
            'value' => $option_id,
        ];

        if (is_array($field['value'])) {
            foreach ($field['value'] as $value) {
                if ($value == $option_id) {
                    $attrs['selected'] = true;
                }
            }
        } elseif ($field['value'] == $option_id) {
            $attrs['selected'] = true;
        }

        return html_attr($attrs);
    }
}

/**
 * @param string $field_id
 * @param array $field
 * @return string
 */
if (!function_exists('textarea_attr')) {
    function textarea_attr(string $field_id, array $field): string
    {
        $attrs = $field['extra']['attr'] ?? [];
        $attrs += [
            'name' => $field_id,
        ];

        return html_attr($attrs);
    }
}
