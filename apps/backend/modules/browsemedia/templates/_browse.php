<?php use_helper('I18N', 'JavascriptBase') ?>
<?php if ($sf_user->hasFlash('notice')): ?>
	<div class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
	<div class="error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></div>
<?php endif; ?>

<script type="text/javascript">
	function putMedia(textareaId, content)
	{
		tinyMCE.execInstanceCommand(textareaId, 'mceInsertContent', false, content);
		jQuery('#dialog').dialog('close');
	}
	
	function gotoPage(page)
	{
		var ajaxUrl = "<?php echo url_for('browsemedia/index')?>?textareaId=<?php echo $textareaId?>&page="+page;
		
		jQuery.ajax({
	  		url: ajaxUrl,
			cache: false,
			beforeSend: function(){
				jQuery("#dialog").html(jQuery("#dialog_processing").html());
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				jQuery("#dialog").html('Error !');
			},
			success: function(html){
				jQuery("#dialog").html(html);
			}
		});
	}
	
	function gotoFilter(category)
	{
		var ajaxUrl = "<?php echo url_for('browsemedia/filter')?>";
		
		jQuery.ajax({
			type: 'POST',
	  		url: ajaxUrl,
			cache: false,
			data: {textareaId:["<?php echo $textareaId?>"], 'media_filters[mediacategory_id]':[category.value]<?php 
				if ($filters->isCSRFProtected())
					echo ", 'media_filters[_csrf_token]':['".$filters->getCSRFToken()."']";
				?>},
			beforeSend: function(){
				jQuery("#dialog").html(jQuery("#dialog_processing").html());
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				jQuery("#dialog").html('Error !');
			},
			success: function(html){
				jQuery("#dialog").html(html);
			}
		});
	}
</script>    
<div class="sf_admin_list">
    <table width="100%" cellspacing="0" cellpadding="0">
      <thead>
      	<tr>
      		<td colspan="10" align="right">
				
		  	</td>
      	</tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="4">
            <?php if ($pager->haveToPaginate()): ?>
              <div class="sf_admin_pagination">
				  <?php
				  	$image = image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/first.png', array('alt' => __('First page', array(), 'sf_admin'), 'title' => __('First page', array(), 'sf_admin')));
					$function = 'gotoPage("1")';
					echo link_to_function($image, $function);
				  ?>
				  
				  <?php
				  	$image = image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/previous.png', array('alt' => __('Previous page', array(), 'sf_admin'), 'title' => __('Previous page', array(), 'sf_admin')));
					$function = 'gotoPage("'.$pager->getPreviousPage().'")';
					echo link_to_function($image, $function);
				  ?>
				
				  <?php foreach ($pager->getLinks() as $page): ?>
				    <?php if ($page == $pager->getPage()): ?>
				      <?php echo $page ?>
				    <?php else: ?>
					  <?php
					  	$function = 'gotoPage("'.$page.'")';
						echo link_to_function($page, $function);
					  ?>
				    <?php endif; ?>
				  <?php endforeach; ?>
				
				  <?php
				  	$image = image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/next.png', array('alt' => __('Next page', array(), 'sf_admin'), 'title' => __('Next page', array(), 'sf_admin')));
					$function = 'gotoPage("'.$pager->getNextPage().'")';
					echo link_to_function($image, $function);
				  ?>

				  <?php
				  	$image = image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/last.png', array('alt' => __('Last page', array(), 'sf_admin'), 'title' => __('Last page', array(), 'sf_admin')));
					$function = 'gotoPage("'.$pager->getLastPage().'")';
					echo link_to_function($image, $function);
				  ?>
				</div>
            <?php endif; ?>

            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
            <?php endif; ?>
          </th>
        </tr>
      </tfoot>
      <tbody id="table_order">
        <tr>
          	<th class="hdr" colspan="4">
				<?php echo $filters->renderHiddenFields() ?>
				<?php echo $filters['mediacategory_id']->renderLabel('Media Category') ?>
	            <?php echo $filters['mediacategory_id']->render(array('onchange'=>'gotoFilter(this);return false;')) ?>
	            </form>			
		  	</th>
        </tr>
        <?php $x=1;foreach ($pager->getResults() as $i => $item): ?>
          <?php if($x%4==1): ?>
		  <tr>
		  <?php endif ?>
            <td class="white-data" align="center">
			  <?php 
			  		$image = image_tag($item->getThumbUriWebpath(), array('style' => 'max-width: '.sfConfig::get('app_maxThumbSize').'px;max-height: '.sfConfig::get('app_maxThumbSize').'px;'));
					$function = 'putMedia("'.$textareaId.'", "'.$item->getTextareaContent().'")';
					echo link_to_function($image, $function); 
			  ?>
			  <br />
			  <?php echo $item->getTitle() ?>
			</td>
          <?php if($x%4==0):?>
          </tr>
          <?php endif ?>
          <?php $x++;?>
        <?php endforeach; ?>
        
        <?php if($x%4>0): ?>
        	</tr>
        <?php endif ?>
      </tbody>
    </table>
</div>
