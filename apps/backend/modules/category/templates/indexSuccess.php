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
	function submitFormPublish(action, publish)
	{
		var form = document.getElementById('listForm')
		var m = document.createElement('input'); 
		m.setAttribute('type', 'hidden'); 
		m.setAttribute('name', 'publish'); 
		m.setAttribute('value', publish); 
		form.appendChild(m);
		
		submitForm(action);
	}
	
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
	      <caption><?php echo __('Category List') ?></caption>
		  <thead>
	      	<tr>
	      		<td colspan="7">
	      			<table width="100%">
	      				<tr>
	      					<td align="left">
				      			<form action="<?php echo url_for('category_collection', array('action' => 'filter')) ?>" method="post" id="filterForm">
				      			<?php echo $filters->renderHiddenFields() ?>
				      			<?php echo $filters['title']->render() ?>
					            <?php echo $filters['title']->renderError() ?>
								<?php echo $filters['state']->renderLabel(__('State')) ?>
					            <?php echo $filters['state']->render() ?>
					            <?php echo $filters['state']->renderError() ?>
								<?php echo $filters['super_cat']->renderLabel(__('Parent')) ?>
					            <?php echo $filters['super_cat']->render(array('style' => 'width: 150px;')) ?>
					            <?php echo $filters['super_cat']->renderError() ?>
								<?php echo link_to(__('Reset', array(), 'sf_admin'), 'category_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?>
					            <input type="submit" value="<?php echo __('Filter', array(), 'sf_admin') ?>" />
				      			</form>
	      					</td>
	      					<td align="right">
								<?php echo button_to(__('New', array(), 'sf_admin'), '@category_new')?>
								<input type="button" value="<?php echo __('Delete Batch') ?>" onclick="submitForm('batchDelete')" />
								<input type="button" value="<?php echo __('Publish Batch') ?>" onclick="submitFormPublish('batchPublish', '1')" />
								<input type="button" value="<?php echo __('Unpublish Batch') ?>" onclick="submitFormPublish('batchPublish', '0')" />
			  				</td>
		  				</tr>
					</table>
				</td>
	      	</tr>
	      </thead>
	      <tfoot>
	        <tr>
	          <th colspan="7">
	            <?php echo $filters->getMaxPerPageHtml(__("Display"), url_for('@category'), $displayNumber) ?> 
				<?php if ($pager->haveToPaginate()): ?>
	              <div class="sf_admin_pagination">
					  <a href="<?php echo url_for('@category') ?>?page=1">
					    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/first.png', array('alt' => __('First page', array(), 'sf_admin'), 'title' => __('First page', array(), 'sf_admin'))) ?>
					  </a>
					
					  <a href="<?php echo url_for('@category') ?>?page=<?php echo $pager->getPreviousPage() ?>">
					    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/previous.png', array('alt' => __('Previous page', array(), 'sf_admin'), 'title' => __('Previous page', array(), 'sf_admin'))) ?>
					  </a>
					
					  <?php foreach ($pager->getLinks() as $page): ?>
					    <?php if ($page == $pager->getPage()): ?>
					      <?php echo $page ?>
					    <?php else: ?>
					      <a href="<?php echo url_for('@category') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
					    <?php endif; ?>
					  <?php endforeach; ?>
					
					  <a href="<?php echo url_for('@category') ?>?page=<?php echo $pager->getNextPage() ?>">
					    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/next.png', array('alt' => __('Next page', array(), 'sf_admin'), 'title' => __('Next page', array(), 'sf_admin'))) ?>
					  </a>
					
					  <a href="<?php echo url_for('@category') ?>?page=<?php echo $pager->getLastPage() ?>">
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
	        <form action="<?php echo url_for('category_collection', array('action' => 'batch')) ?>" method="post" id="listForm">
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
				  <?php if ('id' == $sort[0]): ?>
				    <?php echo link_to(__('Id'), '@category', array('query_string' => 'sort=id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
				    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
				  <?php else: ?>
				    <?php echo link_to(__('Id'), '@category', array('query_string' => 'sort=id&sort_type=asc')) ?>
				  <?php endif; ?>
				</th>
				<th class="hdr actCol">
				  <?php if ('state' == $sort[0]): ?>
				    <?php echo link_to(__('State'), '@category', array('query_string' => 'sort=state&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
				    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
				  <?php else: ?>
				    <?php echo link_to(__('State'), '@category', array('query_string' => 'sort=state&sort_type=asc')) ?>
				  <?php endif; ?>
				</th>
				<th class="hdr">
				  <?php if ('title' == $sort[0]): ?>
				    <?php echo link_to(__('Title'), '@category', array('query_string' => 'sort=title&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
				    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
				  <?php else: ?>
				    <?php echo link_to(__('Title'), '@category', array('query_string' => 'sort=title&sort_type=asc')) ?>
				  <?php endif; ?>
				</th>
				<th class="hdr">
				    <?php echo __('Super Category') ?>
				</th>
				<th class="hdr">
				    <?php echo __('Author') ?>
				</th>
				<th class="hdr actieCol">
					<?php echo __('Actions', array(), 'sf_admin') ?>
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
				  <?php echo link_to($item->getStateHtml(), 'category/publish?id='.$item->getId().'&publish='.($item->getState()=='A'?'0':'1'))?>
				</td>
				<td class="tdata">
				  <?php echo link_to($item->getTitle(), 'category_edit', $item) ?>
				</td>
				<td class="tdata">
				  <?php 
				  	$superItem = $item->getCategoryRelatedBySuperCat();
					echo empty($superItem)?'&nbsp;':$superItem; 
				  ?>
				</td>
				<td class="tdata">
				  <?php echo $item->getsfGuardUser()->getUsername() ?>
				</td>
				<td class="tdata" style="white-space: nowrap;">
	            	<?php echo link_to(__('Edit', array(), 'sf_admin'), 'category_edit', $item) ?>
					|
					<?php echo link_to(__('Delete', array(), 'sf_admin'), 'category_delete', $item, array('method' => 'delete', 'confirm' => __('Are you sure?')))?>
	            </td>
	          </tr>
	          <?php if(!$hasFilterValues) displayTree($item, $criteria) ?>
	        <?php endforeach; ?>
			  </form>
	      </tbody>
	    </table>
	</div>
  </div>
</div>
<?php
function displayTree($item, Criteria $criteria, $spaces='<sup class="superscript">|_</sup>&nbsp;')
{
	$children = $item->getCategorysRelatedBySuperCat($criteria);
	if(count($children) == 0)
		return;
	
	?>
		<?php foreach($children as $i => $item): ?>
			<tr class="highlight" id="<?php echo "item_".$item->getId() ?>">
	            <td class="tdata">
				  <input type="checkbox" name="ids[]" value="<?php echo $item->getPrimaryKey() ?>" class="sf_admin_batch_checkbox" />
				</td>
	            <td class="tdata">
				  <?php echo $item->getId() ?>
				</td>
				<td class="tdata">
				  <?php echo link_to($item->getStateHtml(), 'category/publish?id='.$item->getId().'&publish='.($item->getState()=='A'?'0':'1'))?>
				</td>
				<td class="tdata">
				  <?php echo link_to($spaces.$item->getTitle(), 'category_edit', $item) ?>
				</td>
				<td class="tdata">
				  <?php 
				  	$superItem = $item->getCategoryRelatedBySuperCat();
					echo empty($superItem)?'&nbsp;':$superItem; 
				  ?>
				</td>
				<td class="tdata">
				  <?php echo $item->getsfGuardUser()->getUsername() ?>
				</td>
				<td class="tdata" style="white-space: nowrap;">
	            	<?php echo link_to(__('Edit', array(), 'sf_admin'), 'category_edit', $item) ?>
					|
					<?php echo link_to(__('Delete', array(), 'sf_admin'), 'category_delete', $item, array('method' => 'delete', 'confirm' => __('Are you sure?')))?>
	            </td>
	          </tr>
	          <?php displayTree($item, $criteria, "&nbsp;&nbsp;&nbsp;&nbsp;".$spaces)?>
		<?php endforeach; ?>
	<?php
}