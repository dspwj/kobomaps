<?php defined('SYSPATH') or die('No direct script access.');
/***********************************************************
* window.php - View
* This software is copy righted by Etherton Technologies Ltd. 2013
* Writen by John Etherton <john@ethertontech.com> Tino also did some work on this back in the day
* Started on 2013-01-21
*************************************************************/
?>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-52d0945017398e4e"></script>
	
<div class="shareWindow" id="shareWindow_<?php echo $map->id;?>">

<h2><?php echo __('Sharing Settings:');?> <?php echo $map->title;?></h2>


	<?php echo __('Code to embed map')?><br/>
	<input readonly="readonly" type="text" value="<iframe src=&quot;<?php echo URL::site(NULL, TRUE)?><?php echo $map->slug?>?fullscreen&quot; width=&quot;800&quot; height=&quot;600&quot;/>"/>
	<br/>
	<br/>

	<?php echo __('Link to share map')?><br/>
	<input readonly="readonly" type="text" value="<?php echo URL::site(NULL, TRUE)?><?php echo $map->slug?>"/>
	<?php
		$body = __('I want to share this map with you:').' '.URL::site(NULL, TRUE).$map->slug;
		$body = rawurlencode($body); 
		$subject = rawurlencode(__('Sharing'). ' '.$map->title. ' '.__('map'));
	?>
	<div class="sharingTasks">
			<a href="mailto:?subject=<?php echo $subject;?>&body=<?php echo $body;?>">
				<img class="emailShare" src="<?php echo URL::base();?>media/img/img_trans.gif" width="1" height="1">
			</a>                                                               
			<!-- AddThis Button BEGIN -->
			<span style="position:relative"class="addthis_toolbox addthis_default_style" addthis:url="<?php echo URL::site(NULL, TRUE)?><?php echo $map->slug?>">
			<a class="addthis_button_preferred_1"></a>
			<a class="addthis_button_preferred_2"></a>
			<a class="addthis_button_preferred_3"></a>
			<a class="addthis_button_preferred_4"></a>
			<a class="addthis_button_compact"></a>
			<a class="addthis_counter addthis_bubble_style"></a>
			</span>&nbsp;&nbsp;&nbsp;&nbsp;
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-52d6a64f3241f4e1"></script>
			<!-- AddThis Button END -->
		<!-- AddThis Button END -->
		 
		<!--
		<li>
			<a href="" onclick="postMapLinkToFacebookFeed(); return false;">
				<img class="fbShare" src="<?php echo URL::base();?>media/img/img_trans.gif" width="1" height="1">
			</a>
		</li>
		-->
	</div>
	
	<br/>
	<br/>
	<div id="indicatorLink" style="display:none;">
		<?php echo __('Link to share this indicator')?><br/>
		<input readonly="readonly" type="text" value="<?php echo URL::site(NULL, TRUE)?><?php echo $map->slug?>#/?indicator="/>
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
	<?php  if($share->permission == Model_Sharing::$owner || $share->permission == Model_Sharing::$edit){?>
	<div id="whoHasAccess" class="section">
		<?php $mapStateView = new view('share/map_state');
		$mapStateView->map = $map;
		echo $mapStateView;
		
		$colaboratorsView = new view('share/map_colaborators');
		$colaboratorsView->colaborators = $colaborators;
		$colaboratorsView->permissions = $permissions;
		echo $colaboratorsView; ?>
		
	</div>
	<div id="addPeople" class="section">
		<?php echo __('Add a user to this map');?>
		<?php echo Form::input('newUserName',null,array('id'=>'newUserName','style'=>'width:300px;','placeholder'=>'User name or email address'))?>
		<?php echo Form::select('newUserPrivildge',$permissions, null, array('id'=>'newUserPrivildge'));?>
		<br/>
		<input type="button" style="width:80px;" value="<?php echo __('Add User')?>" onclick="addNewUser(<?php echo $map->id?>); return false;"/>
		<span id="stateWaitingUser"></span>
	</div>
	<?php }?>
	
	<script type="text/javascript">
	//make this global
	var mapShareIndicatorURL = null;
	if( typeof $.address != 'undefined')
	{
		var mapShareIndicator = $.address.parameter("indicator");
		if(typeof mapShareIndicator != 'undefined')
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
				'<?php echo str_replace("'", "\'", $map->title);?> - ' + $("#indicatorSpanId_"+mapShareIndicator).text(),
				'<?php echo __('By KoboMaps');?>',
				'<?php echo str_replace("'", "\'", $map->description);?>',
				null);
		return false;
	}
	</script> 

</div>