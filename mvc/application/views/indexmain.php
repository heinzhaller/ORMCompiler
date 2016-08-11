<!DOCTYPE html>
<html lang="DE">
	<head>

		<title>OBM - Online Boxing Manager | Boxen Browsergame kostenlos spielen</title>

		<link type="text/css" rel="stylesheet" href="/assets/css/core.css" />

		<!--<link type="text/css" rel="stylesheet/less" href="styles.less" />-->
		<link type="text/css" rel="stylesheet" href="/assets/css/styles.css" />

		<link type="text/css" rel="stylesheet" href="/assets/css/start.css" />

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link href='//fonts.googleapis.com/css?family=Open+Sans:200,300,400,600,700,800' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="main">
			<div class="website">

				<div class="website-header">

					<div class="bar">
						<div class="website-inner infobar">
							<div class="row">
								<div class="col-sm-2 hide-on-xs">
									<?=date('d.m.Y H:i');?>
								</div>

								<div class="col-sm-2 hide-on-xs">
								</div>

								<div class="col-xs-12 col-sm-8 text-right">
									<div class="laender bold">

										<img src="/assets/images/custom/ingame/flags/flag_th.jpg" height="18" alt="TH">
										<img src="/assets/images/custom/ingame/flags/flag_de.jpg" height="18" alt="DE">
										<img src="/assets/images/custom/ingame/flags/flag_mx.jpg" height="18" alt="MX">
										<img src="/assets/images/custom/ingame/flags/flag_cu.jpg" height="18" alt="CU">
										<img src="/assets/images/custom/ingame/flags/flag_ru.jpg" height="18" alt="RU">
										<img src="/assets/images/custom/ingame/flags/flag_cn.jpg" height="18" alt="CN">
										<img src="/assets/images/custom/ingame/flags/flag_us.jpg" height="18" alt="US">
										<img src="/assets/images/custom/ingame/flags/flag_pl.jpg" height="18" alt="PL">
										<img src="/assets/images/custom/ingame/flags/flag_uk.jpg" height="18" alt="UK">
										<img src="/assets/images/custom/ingame/flags/flag_ie.jpg" height="18" alt="IE">
										<img src="/assets/images/custom/ingame/flags/flag_tr.jpg" height="18" alt="TR">
										<img src="/assets/images/custom/ingame/flags/flag_ua.jpg" height="18" alt="UA">
										<img src="/assets/images/custom/ingame/flags/flag_jp.jpg" height="18" alt="JP">
										<img src="/assets/images/custom/ingame/flags/flag_fr.jpg" height="18" alt="FR">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="website-inner">

						<img src="/assets/images/custom/public/header_bg_boxer.png" class="logo-boxer" />

						<a class="block absolute website-logo" href="/">
							<img src="/assets/images/custom/public/obm_header_logo.png" alt="OBM" title="OBM - Online Boxing Manager" />
						</a>

						<div class="row navigation hide-on-xs">
							<div <?=( WebsiteManager::getPage() == WebsiteManager::PUBLIC_MAIN ? 'class="selected"' : null)?>>
								<a href="/"><i class="fa fa-home"></i> <?=getTrans('LANG_MAIN')?></a>
							</div>
							<div <?=( WebsiteManager::getPage() == WebsiteManager::PUBLIC_REGISTER ? 'class="selected"' : null)?>>
								<a href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_REGISTER'))?>" class=""><i class="fa fa-pencil-square-o"></i> <?=getTrans('LANG_REGISTER')?></a>
							</div>
							<div <?=( WebsiteManager::getPage() == WebsiteManager::PUBLIC_TUTORIAL ? 'class="selected"' : null)?>>
								<a href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_TUTORIAL'))?>" class=""><i class="fa fa-book"></i> <?=getTrans('LANG_TUTORIAL')?></a>
							</div>
							<div <?=( WebsiteManager::getPage() == WebsiteManager::GAME_LEAGUE ? 'class="selected"' : null)?>>
								<a href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_LEAGUE'))?>"><i class="fa fa-sitemap"></i> <?=getTrans('LANG_LEAGUE')?></a>
							</div>
							<div <?=( in_array(WebsiteManager::getPage(), array(WebsiteManager::PUBLIC_RANKING, WebsiteManager::PUBLIC_RANKINGLIST_WORLD) ) ? 'class="selected"' : null)?>>
								<a href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_RANKINGLIST'))?>"><i class="fa fa-signal"></i> <?=getTrans('LANG_RANKINGLIST')?></a>
								<div class="submenu">
									<a href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_RANKINGLIST'))?>"><i class="fa fa-tags"></i> <?=getTrans('LANG_ASSOCIATIONS')?></a>
									<a href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_RANKINGLIST_WORLD'))?>"><i class="fa fa-globe"></i> <?=getTrans('LANG_RANKING_WORLD_COUNTRY')?></a>
								</div>
							</div>
						</div>

					</div>

				</div>

				<? if( WebsiteManager::getPage() != WebsiteManager::PUBLIC_MAIN  ){ ?>
				<div class="website-breadcrumbs">
					<div class="container website-inner">
						<h1 class="pull-left"><?=WebsiteManager::getPageTitle()?></h1>
						<ul class="pull-right breadcrumb">
							<li class="inline-block"><a href="index.html">Home</a></li>
							<li class="inline-block"><a href="">Features</a></li>
							<li class="inline-block active">General Buttons</li>
						</ul>
					</div>
				</div>
				<? } else{ ?>
					<?
					$myStage = new StartController();
					echo $myStage->Layout()->load('start/stage')->show(true);
					?>
				<? } ?>


				<div class="website-content">
					<div class="website-inner">
						<?=$output;?>
					</div>
				</div>

				<div class="bar"></div>
				<div class="website-footer">

					<div class="website-inner">
						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-4 text-center">
								<img src="http://www.onlineboxingmanager.de/images/custom/public/obm_logo.png" class="" />
								<ul>
									<li class="logo"><div class="version center"><?=getTrans('LANG_WEBSITE_VERSION')?></div></li>
								</ul>
							</div>

							<div class="col-xs-6 col-sm-3 col-md-2 hide-on-xs">
								<div class="headline">
									<h3><?=getTrans('LANG_TUTORIAL')?></h3>
								</div>
								<ul class="links">
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_TUTORIAL') . '/' . getTrans('LANG_FIRSTSTEPS'))?>"><?=getTrans('LANG_FIRSTSTEPS')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_TUTORIAL') . '/' . getTrans('LANG_CLUB'))?>"><?=getTrans('LANG_CLUB')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_TUTORIAL') . '/' . getTrans('LANG_BOXER'))?>"><?=getTrans('LANG_BOXER')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_TUTORIAL') . '/' . getTrans('LANG_TRANSFERMARKET'))?>"><?=getTrans('LANG_TRANSFERMARKET')?></a></li>
								</ul>
							</div>

							<div class="col-xs-6 col-sm-3 col-md-2 hide-on-xs">
								<div class="headline">
									<h3><?=getTrans('LANG_STATISTICS')?></h3>
								</div>
								<ul class="links">
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_TEAMS_AND_MANAGER'))?>"><?=getTrans('LANG_TEAMS_AND_MANAGER')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_BOXER_AND_COUNTRIES'))?>"><?=getTrans('LANG_BOXER')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_CLUBS'))?>"><?=getTrans('LANG_CLUBS')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_ASSOCIATIONS'))?>"><?=getTrans('LANG_ASSOCIATIONS')?></a></li>
								</ul>
							</div>

							<div class="col-xs-6 col-sm-3 col-md-2 hide-on-xs">
								<div class="headline">
									<h3><?=getTrans('LANG_PUBLIC')?></h3>
								</div>
								<ul class="links">
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_RSS_NEWS'))?>"><?=getTrans('LANG_RSS_NEWS')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_JOBS'))?>"><?=getTrans('LANG_JOBS')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_PRESS'))?>"><?=getTrans('LANG_PRESS')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_PARTNER'))?>"><?=getTrans('LANG_PARTNER')?></a></li>
								</ul>
							</div>

							<div class="col-xs-6 col-sm-3 col-md-2 hide-on-xs">
								<div class="headline">
									<h3><?=getTrans('LANG_OBM_SHORT')?></h3>
								</div>
								<ul class="links">
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_OBMTEAM'))?>"><?=getTrans('LANG_OBMTEAM')?></a></li>
									<?
									$forumid = ( WebsiteManager::getLanguage() == 'DE' ? 17 : 37 );
									$support = WebsiteManager::makeLink(null, WebsiteManager::PUBLIC_FORUM, array('forum' => $forumid ));
									?>
									<li><a class="block" href="<?=$support?>"><?=getTrans('LANG_SUPPORT_HELP')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_IMPRINT'))?>"><?=getTrans('LANG_IMPRINT')?></a></li>
									<li><a class="block" href="<?=WebsiteManager::makeSeoLink(getTrans('LANG_FORUM'))?>"><?=getTrans('LANG_FORUM')?></a></li>
								</ul>
							</div>



						</div>
					</div>

				</div>
				<div class="website-copyright">

					<div class="website-inner ">
						<div class="row">
							<div class="col-xs-6 copyright">
								Copyright © 2016 - (OBM) Online Boxing Manager
							</div>
							<div class="col-xs-6 text-right social">

								<a href=""><i class="fa fa-facebook"></i></a>
								<a href=""><i class="fa fa-twitter"></i></a>
								<a href=""><i class="fa fa fa-google-plus"></i></a>
								<a href=""><i class="fa fa fa-youtube"></i></a>

							</div>
						</div>
					</div>

				</div>
			</div>

		</div>

		<div class="quest-arrow"></div>
		<div class="overlay_bg "></div>
		<div class="overlaybox overlay " id="overlaybox"></div>
		<div class="mercure-area"></div>
		<div class="website-topscroller"><i class="fa fa-angle-up"></i></div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.12.0-rc.1/jquery-ui.min.js"></script>

		<script src="/assets/js/class.WebsiteStage.js"></script>
		<script src="/assets/js/website.js"></script>
	</body>
</html>