<?php

return [
	'elOptions' => [
		'class' => "table align-middle table-row-dashed fs-6 gy-5",
        'style' => 'width:100% !important;',
	],
	'pluginOptions' => [
		"pagingType" => "numbers",
		"ajax" => [
			"type" => "POST"
		],
		"language" => [
			"lengthMenu" => "_MENU_",
		],
		'dom' => '<"top">rt<"bottom"<"d-flex align-items-center"li>p><"clear">',
	],
	'buttonTemplates' => [
		'edit' => '<a href="<<url>>" class="btn btn-primary" title="Edit details"> Edit </a>',
		'delete' => '<a href="<<url>>" class="btn btn-danger" title="Delete"> Delete </a>',
		'view' => '<a href="<<url>>" class="btn btn-success" title="View"> View </a>'
	]
];