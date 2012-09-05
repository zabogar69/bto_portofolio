<?php use_helper('Form', 'Object', 'JavascriptBase', 'Javascript') ?>
<?php
switch($menutype)
{
	case 'Article':
		echo object_select_tag('', '',
							array('related_class' => 'Category',
								'peer_method' => 'getAllItems',
								'peer_method_parameter' => 'true',
								'control_name' => 'category',
								'text_method' => 'getTitle',
								'key_method'=>'getPrimaryKey',
								'include_blank'=>true,
								'onchange'=>remote_function(array('update' => 'articleLink2',
													'url' => 'menu/getMenuLinkArticle',
													'with' => "'category=' + this.value",))));
		echo "<div id='articleLink2'>";
		echo object_select_tag('', '',
								array('related_class' => 'Article',
									'peer_method' => 'retrieveByCategory',
									'peer_method_parameter' => null,
									'control_name' => 'menu[link]',
									'text_method' => 'getTitle',
															'key_method'=>'getUrl',));
		echo "</div>";
		break;
	case 'Article2':
		echo object_select_tag('', '',
							array('related_class' => 'Article',
								'peer_method' => 'retrieveByCategory',
								'peer_method_parameter' => $category,
								'control_name' => 'menu[link]',
								'text_method' => 'getTitle',
								'key_method'=>'getUrl',));
		break;
	case 'Category':
		echo object_select_tag('', '',
							array('related_class' => 'Category',
								'peer_method' => 'getAllItems',
								'control_name' => 'menu[link]',
								'text_method' => 'getTitle',
								'key_method'=>'getUrl',));
		break;

	case 'Link':
		echo input_tag("menu[link]");
		break;
	case 'Gallery':
		echo object_select_tag('', '',
							array('related_class' => 'Mediacategory',
								'peer_method' => 'getAllItems',
								'control_name' => 'menu[link]',
								'text_method' => 'getTitle',
								'key_method'=>'getUrl',));
		break;
		
	case 'Archive':
	 	echo object_select_tag('', '',
					array('related_class' => 'Category',
					'peer_method' => 'getAllItems',
					'control_name' => 'menu[link]',
					'text_method' => 'getTitle',
					'key_method'=>'getUrlArchive',));
		break;
	
	case 'Geen':
		echo "<i>n/a</i>";
		break;
	default:
		echo "<i>Kies eerst link type</i>";
		break;
}
