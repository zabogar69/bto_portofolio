<?php use_helper('I18N', 'Date') ?>
<div id="contentRight">
	<?php if ($sf_user->hasFlash('notice')): ?>
		<div class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></div>
	<?php endif; ?>
	
	<?php if ($sf_user->hasFlash('error')): ?>
		<div class="error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></div>
	<?php endif; ?>

  <div id="container">
	<script type="text/javascript">
	/* <![CDATA[ */
	function submitForm(action)
	{
		var form = document.getElementById('listForm')
		var m = document.createElement('input'); 
		m.setAttribute('type', 'hidden'); 
		m.setAttribute('name', 'batch_action'); 
		m.setAttribute('value', action); 
		form.appendChild(m);
		
		form.submit();
	}	
	 
	function checkAll()
	{
	  var boxes = document.getElementsByTagName('input'); 
	  for(var index = 0; index < boxes.length; index++) 
	  { 
	  	box = boxes[index]; 
		if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') 
			box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked 
	  } 
	  return true;
	}
	/* ]]> */
	</script>    
    	<div class="sf_admin_list">
		    <table width="100%" cellspacing="0" cellpadding="0">
		  	  <caption><?php echo __('Menu Trash Bin') ?></caption>
		      <thead>
		      	<tr>
		      		<td align="left" colspan="3">
		      		<?php echo $trashbinSelectorHTML;?>			    
					</td>
		      		<td colspan="2" align="right">
					<input type="button" value="<?php echo __('Restore Batch') ?>" onclick="submitForm('batchRestore')" />
					<input type="button" value="<?php echo __('Destroy Batch') ?>" onclick="submitForm('batchDestroy')" />
				  	</td>
		      	</tr>
		      </thead>
		      <tfoot>
		        <tr>
		          <th colspan="5">
		          	<?php echo $filters->getMaxPerPageHtml(__("Display"), url_for('menu/indexTrashBin'), $displayNumber) ?>
		            <?php if ($pager->haveToPaginate()): ?>
		              <div class="sf_admin_pagination">
						  <a href="<?php echo url_for('menu/indexTrashBin') ?>?page=1">
						    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/first.png', array('alt' => __('First page', array(), 'sf_admin'), 'title' => __('First page', array(), 'sf_admin'))) ?>
						  </a>
						
						  <a href="<?php echo url_for('menu/indexTrashBin') ?>?page=<?php echo $pager->getPreviousPage() ?>">
						    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/previous.png', array('alt' => __('Previous page', array(), 'sf_admin'), 'title' => __('Previous page', array(), 'sf_admin'))) ?>
						  </a>
						
						  <?php foreach ($pager->getLinks() as $page): ?>
						    <?php if ($page == $pager->getPage()): ?>
						      <?php echo $page ?>
						    <?php else: ?>
						      <a href="<?php echo url_for('menu/indexTrashBin') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
						    <?php endif; ?>
						  <?php endforeach; ?>
						
						  <a href="<?php echo url_for('menu/indexTrashBin') ?>?page=<?php echo $pager->getNextPage() ?>">
						    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/next.png', array('alt' => __('Next page', array(), 'sf_admin'), 'title' => __('Next page', array(), 'sf_admin'))) ?>
						  </a>
						
						  <a href="<?php echo url_for('menu/indexTrashBin') ?>?page=<?php echo $pager->getLastPage() ?>">
						    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/last.png', array('alt' => __('Last page', array(), 'sf_admin'), 'title' => __('Last page', array(), 'sf_admin'))) ?>
						  </a>
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
		        <form action="<?php echo url_for('menu_collection', array('action' => 'batch')) ?>" method="post" id="listForm">
				<?php 
					$form = new BaseForm(); 
					if ($form->isCSRFProtected()): 
				?>
					<input type="hidden" name="<?php echo $form->getCSRFFieldName() ?>" value="<?php echo $form->getCSRFToken() ?>" />
				<?php endif; ?>
				<tr>
		          	<th class="hdr chkCol" nowrap="" align="left">
					  <input id="sf_admin_list_batch_checkbox" type="checkbox" onclick="checkAll();" />
  					</th>
					<th class="hdr idCol">
					    <?php echo __('Id') ?>
					</th>
					<th class="hdr">
					    <?php echo __('Title') ?>
					</th>
					<th class="hdr">
					    <?php echo __('Super Menu') ?>
					</th>
					<th class="hdr actieCol">
						<?php echo __('Actions') ?>
					</th>
		        </tr>
		        <?php foreach ($pager->getResults() as $i => $item): ?>
		          <tr class="highlight" id="<?php echo "item_".$item->getId() ?>">
		            <td class="tdata">
					  <input type="checkbox" name="ids[]" value="<?php echo $item->getPrimaryKey() ?>" class="sf_admin_batch_checkbox" />
					</td>
		            <td class="tdata">
					  <?php echo $item->getId() ?>
					</td>
					<td class="tdata">
					  <?php echo $item->getTitle() ?>
					</td>
					<td class="tdata">
					  <?php 
					  	$superItem = $item->getMenuRelatedBySuperMenu();
						echo empty($superItem)?'&nbsp;':$superItem; 
					  ?>
					</td>
					<td class="tdata">
		            	<?php echo link_to(__('Restore'), 'menu_restore', $item) ?>
    					|
    					<?php echo link_to(__('Destroy'), 'menu_destroy', $item, array('confirm' => __('Are you sure?')))?>
		            </td>
		          </tr>
		        <?php endforeach; ?>
				</form>
		      </tbody>
		    </table>
		</div>
  </div>

</div>