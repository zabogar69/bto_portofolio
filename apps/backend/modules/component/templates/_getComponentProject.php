<?php use_helper('Form', 'Object', 'JavascriptBase', 'Javascript') ?>
<?php
	echo object_select_tag('', '',
						array('related_class' => 'Company',
							'peer_method' => 'getAllItems',
							'peer_method_parameter' => 'true',
							'control_name' => 'company',
							'text_method' => 'getName',
							'key_method'=>'getPrimaryKey',
							'include_blank'=>true,
							'onchange'=>remote_function(array('update' => 'componentProject',
												'url' => 'component/getComponentProject',
												'with' => "'company=' + this.value",))));
	echo "<div id='componentProject'>";
	echo object_select_tag('', '',
						array('related_class' => 'Btoproject',
							'peer_method' => 'retrieveByCompany',
							'peer_method_parameter' => null,
							'control_name' => 'component[btoproject_id]',
							'text_method' => 'getName',
							'key_method'=>'getPrimaryKey',
							'include_blank'=>true,));
	echo "</div>";
?>
