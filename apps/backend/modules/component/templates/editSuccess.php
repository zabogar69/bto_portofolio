<?php use_helper('I18N', 'Date', 'JavascriptBase', 'Javascript' ,'Object') ?>
<script language="javascript">
	$(document).ready(function(){
		
			$('#company').chainSelect('#component_btoproject_id','<?php echo url_for('component/getProject')?>',
			{ 				
				before:function (target)
				{
					//alert('test'); 
					$(target).attr("disabled","disabled");
					$(target).parent().addClass("disabled");
				},
				after:function (target)
				{ 					
					$(target).removeAttr("disabled");
					$(target).parent().removeClass("disabled");
				}
			});		
	});
</script>
<h1>Nieuw projectonderdeel</h1>
					<hr>
					
					<?php echo form_tag_for($form, '@component', array('name'=>'editForm')) ?>
						<?php echo $form->renderHiddenFields(false) ?>
						<?php if($isSuperAdmin):?>
							<div class="formrow">
								<label for="company"><?php echo 'Bedrijf';?></label>
								<?php
							  		$object = BtoprojectPeer::retrieveByPK($form['btoproject_id']->getValue());
									$companyObj = '';
									if($object):
										$companyObj = $object->getCompanyId();
									endif;	
									echo object_select_tag($companyObj, '',
														array('related_class' => 'Company',
															'peer_method' => 'getAllItems',
															'peer_method_parameter' => 'true',
															'control_name' => 'company',
															'text_method' => 'getName',
															'key_method'=>'getPrimaryKey',));
								?>
							</div>
						<?php else:?>
							<input type='hidden' name='company' id='company' value='<?php echo $userProfile->getCompanyId();?>'>
						<?php endif;?>
						<div class="formrow">
							<label for="company"><?php echo 'Project';?></label>
							<?php
						  		if($userProfile):
						  			echo object_select_tag($form['btoproject_id']->getValue(), '',
													array('related_class' => 'Btoproject',
														'peer_method' => 'retrieveByCompany',
														'peer_method_parameter' => $userProfile->getCompanyId(),
														'control_name' => 'component[btoproject_id]',
														'text_method' => 'getName',
														'key_method'=>'getPrimaryKey',));
								elseif($object):
									echo object_select_tag($form['btoproject_id']->getValue(), '',
													array('related_class' => 'Btoproject',
														'peer_method' => 'retrieveByCompany',
														'peer_method_parameter' => $object->getCompanyId(),
														'control_name' => 'component[btoproject_id]',
														'text_method' => 'getName',
														'key_method'=>'getPrimaryKey',));
								else:
									echo object_select_tag($form['btoproject_id']->getValue(), '',
													array('related_class' => 'Btoproject',
														'peer_method' => 'retrieveAll',
														'peer_method_parameter' => 'true',
														'control_name' => 'component[btoproject_id]',
														'text_method' => 'getName',
														'key_method'=>'getPrimaryKey',));
								endif;
							?>
						</div>
						
						<div class="formrow">
							<label for="projectonderdeel"><?php echo $form['name']->renderLabel('Naam projectonderdeel *') ?></label>
							<?php echo $form['name']->render(array('required'=>'true')); ?>
						</div>
						<div class="formrow">
							<label for="description"><?php echo $form['description']->renderLabel('Korte Omschrijving') ?></label>
							<?php echo $form['description']->render(array('required'=>'false')); ?>
						</div>
						<div class="formrow">
							<label>&nbsp;</label>
							<button type="submit">Opslaan</button> <a class="cancel" href="home.php">Annuleren</a>
							<br class="close">
						</div>
					</form>