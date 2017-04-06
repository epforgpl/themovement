<?php
	$this->assign('title', $item->name . ' | The Movement');
	echo $this->Less->less('less/page.less');
	echo $this->Less->less('less/items.less');
	echo $this->Less->less('less/manager.less');
	
	$this->prepend('script', $this->Html->script('page'));
	
	echo $this->element('Items/Events/header', [
		'item' => $item
	]);
?>


<div class="row">
	<div class="col-md-12">
		
		<header class="item_header overflow-auto">
			<h1 class="pull-left">Code of Conduct</h1>
			
		</header>
		
		<div class="block">
			<div class="content">
				
				<p class="c1"><span class="c0"></span></p><p class="c3"><span class="c0">Personal Democracy Forum CEE 17 is an open event for activists from all over the world whose aim is to develop tools and policies for social good and good governance. </span></p><p class="c3"><span class="c6">As organizers we would like to all participants to follow the below mentioned rules</span><span class="c0">:</span></p><ul class="c10 lst-kix_gusumisddqr6-0 start"><li class="c2"><span class="c0">Act fairly, honestly, and in good faith with other participants;</span></li><li class="c2"><span class="c0">Listen actively (especially if you have the loudest voice);</span></li><li class="c2"><span class="c0">Engage in conversations which challenge your world views;</span></li><li class="c2"><span class="c0">Act with integrity and respect even when you disagree;</span></li><li class="c2"><span class="c0">Facilitate transparency and openness as much as possible;</span></li><li class="c2"><span class="c0">Assist in creating a welcoming and respectful environment, by following instructions from our staff and volunteers;</span></li><li class="c2"><span class="c0">Respect the privacy rights of participants that do not wish to be photographed or quoted;</span></li><li class="c2"><span class="c0">Everyone attending Personal Democracy CEE 17, irrespective of nationality, gender, racial or ethnic origin, religion or beliefs, disability, age, or sexual orientation, has the right to be free from harassment</span></li></ul><p class="c1"><span class="c0"></span></p><p class="c3"><span class="c6">&nbsp;Anti-Harassment Policy</span><span class="c0">&nbsp;</span></p><ul class="c10 lst-kix_8g47f71lypi7-0 start"><li class="c2"><span class="c0">Harassment of any kind will not be tolerated;</span></li><li class="c2"><span class="c0">Any harassing or disrespectful behaviour, comments, messages, images or interactions by any participant will not be tolerated;</span></li><li class="c2"><span class="c0">You should report any unusual or inappropriate activity directly to one of our staff or to the contact below;</span></li><li class="c2"><span class="c0">Personal Democracy Forum CEE 17 organizers reserves the right to revoke the attendance privileges of any offending individual or party and determine on what basis this decision is made;</span></li></ul><p class="c9"><span class="c0"></span></p><p class="c1"><span class="c0"></span></p><p class="c3"><span class="c6">Code of Conduct and Anti-Harassment Policy Response Process</span><span class="c0">&nbsp;</span></p><p class="c1"><span class="c0"></span></p><p class="c3"><span class="c0">When there has been an incident or breach of this code, the Personal Democracy Forum CEE 17 team will confidentially review and respond to any participant who has experienced harassment, inappropriate behavior, or a violation of the code of conduct. The final decision on any disciplinary action will be made by Fundacja ePa&#324;stwo Board and communicated to those involved. </span></p><p class="c3"><span class="c4">Please contact us at </span><span class="c5"><a class="c11" href="mailto:biuro@epf.org.pl">biuro@epf.org.pl</a></span><span class="c4">&nbsp;or contact Aleksandra Kami&#324;ska at: aleksandra.kamin</span><span class="c5"><a class="c11" href="mailto:ska@epf.org.pl">ska@epf.org.pl</a></span><span class="c4">&nbsp;or (+48) 698 899 100</span></p><p class="c1"><span class="c0"></span></p><p class="c1"><span class="c0"></span></p><p class="c1"><span class="c0"></span></p><p class="c3"><span class="c0">Thanks AccessNow, organizators of RightsCon for inspiring us to implement similar code of conduct.</span></p><p class="c1"><span class="c0"></span></p><p class="c1"><span class="c0"></span></p><p class="c1"><span class="c0"></span></p><p class="c1"><span class="c0"></span></p><p class="c1"><span class="c0"></span></p>				
			</div>
		</div>		
	</div>
</div>