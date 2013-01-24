<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* window.php - View
* This software is copy righted by Etherton Technologies Ltd. 2013
* Writen by John Etherton <john@ethertontech.com> Tino also did some work on this back in the day
* Started on 2013-01-21
*************************************************************/
?>
	
<div class="shareWindow" id="shareWindow_<?php echo $map->id;?>">
<h2><?php echo __('Sharing Settings:');?> <?php echo $map->title;?></h2>
<?php echo __('Sharing Settings:');?>


	<?php echo __('Code to embed map')?><br/>
	<input readonly="readonly" type="text" value="<iframe src=&quot;<?php echo URL::site(NULL, TRUE)?>public/view?id=<?php echo $map->id?>&quot; width=&quot;800&quot; height=&quot;600&quot;/>"/>
	<br/>
	<br/>

	<?php echo __('Link to share map')?><br/>
	<input readonly="readonly" type="text" value="<?php echo URL::site(NULL, TRUE)?>public/view?id=<?php echo $map->id?>"/>
	<?php
		$body = __('I want to share this map with you:').' '.URL::site(NULL, TRUE).'public/view?id='.$map->id;
		$body = rawurlencode($body); 
		$subject = rawurlencode(__('Sharing'). ' '.$map->title. ' '.__('map'));
	?>
	<ul class="sharingTasks">
		<li>
			<a href="mailto:?subject=<?php echo $subject;?>&body=<?php echo $body;?>">
				<img class="emailShare" src="<?php echo URL::base();?>media/img/img_trans.gif" width="1" height="1">
			</a>
		</li>
		<li>
			<a href="" onclick="postMapLinkToFacebookFeed(); return false;">
				<img class="fbShare" src="<?php echo URL::base();?>media/img/img_trans.gif" width="1" height="1">
			</a>
		</li>
	</ul>
	
	<br/>
	<br/>
	<div id="indicatorLink" style="display:none;">
		<?php echo __('Link to share this indicator')?><br/>
		<input readonly="readonly" type="text" value="<?php echo URL::site(NULL, TRUE)?>public/view?id=<?php echo $map->id?>#/?indicator="/>
		<ul class="sharingTasks">
			<li>
				<a href="" id="indicatorEmail">
					<img class="emailShare" src="<?php echo URL::base();?>media/img/img_trans.gif" width="1" height="1">
				</a>
			</li>
			<li>
				<a href="" onclick="postIndicatorLinkToFacebookFeed(); return false;">
					<img class="fbShare" src="<?php echo URL::base();?>media/img/img_trans.gif" width="1" height="1">
				</a>
			</li>
		</ul>
	</div>
	
	<script type="text/javascript">
		//make this global
		var mapShareIndicatorURL = null;
		if( typeof $.address != 'undefined')
		{
			var mapShareIndicator = $.address.parameter("indicator");
			if(typeof indicator != 'undefined')
			{

				var indicatorLink = $("#indicatorLink input").val() + mapShareIndicator;
				mapShareIndicatorURL = indicatorLink;
				$("#indicatorLink input").val(indicatorLink);
				$("#indicatorLink").show();
				var body = encodeURIComponent("<?php echo __('I want to share this map with you:');?> " + indicatorLink);
				var subject = "<?php echo rawurlencode(__('Sharing'). ' '.$map->title. ' '.__('map')); ?>";
				$("#indicatorEmail").attr("href","mailto:?subject="+subject+"&body="+body);
			}
			
		}

		function postMapLinkToFacebookFeed()
		{
			postToFacebookFeed($("#indicatorLink input").val(),
					'<?php echo str_replace("'", "\'", $map->title);?>',
					'<?php echo __('By KoboMaps');?>',
					'<?php echo str_replace("'", "\'", $map->description);?>',
					null);
			return false;
		}

		function postIndicatorLinkToFacebookFeed()
		{
			postToFacebookFeed(mapShareIndicatorURL,
					'<?php echo str_replace("'", "\'", $map->title);?> - ' + $("#indicatorSpanId_"+indicator).text(),
					'<?php echo __('By KoboMaps');?>',
					'<?php echo str_replace("'", "\'", $map->description);?>',
					null);
			return false;
		}
			
		
	</script> 

</div>