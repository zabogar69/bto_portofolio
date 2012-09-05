<table width="100%">
	<tr>
		<td align="center" valign="middle" class="white-data">
		<?php echo image_tag($item->getThumbUriWebpath(), array('style' => 'max-width: '.sfConfig::get('app_maxThumbSize').'px;max-height: '.sfConfig::get('app_maxThumbSize').'px;')); ?>
		</td>
	</tr>
</table>