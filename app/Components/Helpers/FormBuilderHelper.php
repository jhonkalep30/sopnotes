<?php

namespace App\Components\Helpers;

/**
 * 
 */
class FormBuilderHelper
{
	public static function setupDefaultConfig($name, $attributes)
	{
		$default = config('formbuilder');
		$config = array_merge($default, $attributes);
		$config['elOptions'] = array_merge($default['elOptions'], $attributes['elOptions'] ?? []);
		$config['addons'] = empty($attributes['addons']) ? [] : array_merge($default['addons'], $attributes['addons']);

		// SETUP LABEL
		$config['textFormat'] = implode(' ', explode('_', $name));
		$config['labelText'] = $config['customLabel'] = $config['labelText'] ?? ucwords($config['textFormat']);
		$config['labelText'] = isset($config['elOptions']['required']) ? $config['labelText'] . ' ' . $config['requiredLabelText'] : $config['labelText'];
		$config['labelText'] = $config['boldLabel'] ? '<span class="fw-semibold fs-6">' . $config['labelText'] . '</span>' : $config['labelText'];

		// SETUP INFO
		if (!empty($config['info'])) {
			$config['info'] = str_replace('<<field>>', $config['info'], $config['infoTemplate']);
		}

		// SETUP FORM ALIGNMENT
		$config['labelContainerClass'] = $config['formAlignment'] === 'vertical' ? $config['labelContainerClassVertical'] : $config['labelContainerClass'] ?? $config['labelContainerClassHorizontal'];
		$config['inputContainerClass'] = $config['formAlignment'] === 'vertical' ? $config['inputContainerClassVertical'] : $config['inputContainerClass'] ?? $config['inputContainerClassHorizontal'];

		// SETUP ADDONS
		$config['addonsConfig'] = $config['addons'];

		// FOR ELEMENT PROPERTY
		$config['elOptions']['id'] = $config['elOptions']['id'] ?? $name;
		$config['elOptions']['placeholder'] = $config['elOptions']['placeholder'] ?? 'Please enter ' . $config['customLabel']. ' here';

		// FOR FORMATING ARRAY elOptions INTO HTML ATTRIBUTES
		foreach ($config['elOptions'] as $attribute => $attributeValue) {
			$config['htmlOptions'] .= $attribute . '="' . $attributeValue . '" ';
		}

		return $config;
	}

	public static function arrayToHtmlAttribute(Array $elOptions) {
		$htmlAttributes = 'test ';
		foreach ($elOptions as $attribute => $attributeValue) {
			$htmlAttributes .= $attribute . '="' . $attributeValue . '" ';
		}
		return $htmlAttributes;
	}

}
