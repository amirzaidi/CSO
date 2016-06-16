<?php
$ip = router::ip();
$ipvote = new vote($ip);

if ($ipvote->found())
{
	$msg = '[previousvote] ' . $ipvote->country->name . ' (' . cron::timeUntil('clearvotes') . ' [timetovote])';
}
else if (isset($uri[0]))
{
	$votecountry = new country(intval($uri[0]));

	if ($votecountry->found() && $votecountry->state == country::voteable()->state)
	{
		new vote([
			'ip' => $ip,
			'country#' => $votecountry->id
		]);

		$votecountry->add('votes', 1);
		$votecountry->update();
		$msg = '[newvote] ' . $votecountry->name;
	}
	else
	{
		$msg = '[invalidvote]';
	}
}
?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<?php
$state = null;
$country = country::voteable();
$imgs = [];

while ($country->found())
{
	$state = $country->state;
	$img = '/style/images/bg' . $country->id . '.jpg';
	if (file_exists(root . $img))
	{
		$imgs[] = "'" . $img . "'";
	}
}

if (!isset($imgs[0]))
{
	$imgs[0] = '/style/images/bg0.jpg';
}

$c = 0;
$color = ['whiterow', 'greyrow'];
?>
	<script type="text/javascript">

	  $(window).load(function() {          
	  var i = 1;
	  var images = [<?php echo implode(',', $imgs); ?>];
	  var image = $('header');

	                //Initial Background image setup
	  //image.css('background-image', "url(<?php echo $imgs[0]; ?>)");
	                //Change image at regular intervals

	  setInterval(function(){  
	   image.fadeOut(600, function () {
	   image.css('background-image', 'url(' + images [i++] +')');
	   image.fadeIn(600);
	   });
	   if(i == images.length)
	    i = 0;
	  }, 5000);           
	 });

	</script>

<?php require 'inc.nav.php'; ?>

<header style="background-image: url(<?php echo $imgs[0]; ?>)">
	<div class="stylelayer">
		<div class="headcon" id="headerfixedcon">

		<div class="webstar">

			<h2> <a href="#"><?php echo ($state == 'finale') ? '[infinale]' : '[preround]'; ?></a> </br></h2>

		</div>

		<div class="webstarinfo">

		<p>Vote for a country by clicking on its name</p>
		<p style="color: red;">([endat] <?php echo date('d/m H:i:s', time() + cron::timeUntil('pickrandom')); ?> [timezone])</p>
		<p id="result"> <?php if (isset($msg)) echo $msg; ?> </p>
		<a href="/ads">[advertisehere]</a>

		</div>

		</div>
	</div>
</header>

<div class="<?php echo $color[$c++ % 2]; ?>">
	<div class="headconbody">
		<div class="row">
			<div class="description">
				<p><a href="/ads">[advertisehere]</a></p>
			</div>
		</div>
	</div>
</div>

<div class="bodycontent" id="vote">
<?php
while ($country->found())
{
?>
<div class="<?php echo $color[$c++ % 2]; ?>">
	<div class="headconbody">
		<div class="row">
			<div class="description">
				<h3> <a href="/index/<?php echo $country->id; ?>"><?php echo $country->name; ?></a> (<?php echo $country->votes; ?> [votes]) </h3>
				<p> [whyvote] </p>
			</div>
			<div class="contentrow">
			<?php
			$i = 0;
			$reason = $country->reason();
			while ($reason->found() && $i++ < 4)
			{
			?>
				<div class="ex<?php echo $i; ?>" id="exfixed">
					<img src="/style/images/reason_<?php echo strtolower(str_replace(' ', '', $reason->name)); ?>.jpg"/>
					<div class="imgtitle">
						<h4><?php echo ucwords($reason->name); ?></h4>
					</div>
				
					<div class="imgtext">
						<p><?php echo $reason->desc; ?></p>
					</div>

					<div class="imglink">
						<a href="/ads">Advertise for your country</a>
					</div>
				</div>
			<?php
			}
			?>
			</div>
		</div>
	</div>
</div>
<?php
}
?>

<div class="<?php echo $color[$c++ % 2]; ?>">
	<div class="headconbody">
		<div class="row">
			<div class="description">
				<p><a href="/ads">[advertisehere]</a></p>
			</div>
		</div>
	</div>
</div>

<div class="specialrow">
	<div class="headconbody">
		<div class="row">
			<div class="description" id="specialdesc">
				<h5>Explanation</h5>
				<p id="explp">We will explain you what this site is and what we do on this site</p>

				<div class="contentrow">
					<div class="col-md-18">
						<div class="exptxt">
							<h1> [qwhatisthis] <a href="#dp1"><img id="dpexp" src="/style/images/dpimg.png"></img></a></h1>
							<div id="dp1"><p id="dpp"> [exp_whatisthis] </p></div>
						</div>
					</div>	
					<div class="col-md-18">
						<div class="exptxt">
							<h1> [qhowdoesthiswork] <a href="#dp2"><img id="dpexp" src="/style/images/dpimg.png"></img></a></h1>
							<div id="dp2"><p id="dpp"> [exp_howdoesthiswork] </p></div>
						</div>
					</div>
					<div class="col-md-18">
						<div class="exptxt">
							<h1> [qwhatisthegoalofthis] <a href="#dp3"><img id="dpexp" src="/style/images/dpimg.png"></img></a></h1>
							<div id="dp3"><p id="dpp"> [exp_whatisthegoalofthis] </p></div>
						</div>
					</div>	
					<div class="col-md-18">
						<div class="exptxt">
							<h1> [qhowdoestheleaderboardwork] <a href="#dp4"><img id="dpexp" src="/style/images/dpimg.png"></img></a></h1>
							<div id="dp4"><p id="dpp"> [exp_howdoestheleaderboardwork] </p></div>
						</div>
					</div>	
					<div class="col-md-18">
						<div class="exptxt">
							<h1> [qhowdoesvotingwork] <a href="#dp5"><img id="dpexp" src="/style/images/dpimg.png"></img></a></h1>
							<div id="dp5"><p id="dpp"> [exp_howdoesvotingwork] </p></div>
						</div>
					</div>	
					<div class="col-md-18">
						<div class="exptxt">
							<h1> [qwhatnow] <a href="#dp6"><img id="dpexp" src="/style/images/dpimg.png"></img></a></h1>
							<div id="dp6"><p id="dpp"> [exp_whatnow] </p></div>
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>
</div>

<div class="<?php echo $color[$c++ % 2]; ?>">
	<div class="headconbody">
		<div class="row">
			<div class="description">
				<p><a href="/ads">[advertisehere]</a></p>
			</div>
		</div>
	</div>
</div>

<div class="<?php echo $color[$c++ % 2]; ?>">

	<div class="headconbody">

		<div class="row">
			
			<div class="description">

				<h3>Leaderboard</h3>
				<p>Here you will be informed about the amount of medals each countries has won!</p>

				<div class="contentrow">
					<?php
					$country = new country(false);
					while ($country->found())
					{
					?>

					<div class="col-md-4">

						<div class="conx">
							<h1><?php echo $country->name; ?> </h1>

							<div class="medals">
								<p><?php echo $country->medal()->count(); ?> medal(s) in total</p>

						<?php
						if ($country->medal()->count() > 0)
						{
						?>
							<p id="topmdld">Of which</p>

							<div class="medaldetails">
								<p><?php
								$medalCounts = $country->medal()->typeCounts();
								if ($medalCounts[0] > 0)
								{
									echo '<img src="/style/images/medal_gold.png" />', $medalCounts[0];
								}
								if ($medalCounts[1] > 0)
								{
									echo '<img src="/style/images/medal_silver.png" />', $medalCounts[1];
								}
								if ($medalCounts[2] > 0)
								{
									echo '<img src="/style/images/medal_bronze.png" />', $medalCounts[2];
								}
								?></p>
							</div>
						<?php
						}
						?>

							</div>
						</div>
					</div>

					<?php
					}
					?>

					<!--
					<div class="col-md-12">

						<h3> Caption </h3>

						<div class="contentrow">

							<div class="col-md-24">
								<h1>Versus</h1><img src="/style/images/vs.png"></img><p>The Standoff</p>
							</div>

							<div class="col-md-24">
								<h1>Medal</h1><img src="/style/images/winvoting.png"></img><p>Won a voting contest</p>
							</div>

							<div class="col-md-24">
								<h1>Trophy </br> Rookie </h1><img src="/style/images/trophy.png"></img><p>Won a year of voting</p>
							</div>

							<div class="col-md-24">
								<h1>Honour </br> Veteran </h1><img src="/style/images/honour.png"></img><p>Won two years of voting</p>
							</div>

							<div class="col-md-24">
								<h1>Crown </br> Emperor of cso.com</h1><img src="/style/images/win4years.png"></img><p>Won four years of voting</p>
							</div>

						</div>

					</div>
					-->

				</div>

			</div>

		</div>

	</div>

</div>

<div class="<?php echo $color[$c++ % 2]; ?>">
	<div class="headconbody">
		<div class="row">
			<div class="description">
				<p><a href="/ads">[advertisehere]</a></p>
			</div>
		</div>
	</div>
</div>
<?php require 'inc.footer.php'; ?>