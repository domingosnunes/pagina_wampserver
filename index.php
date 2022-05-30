<?php

$wampConfFile = '../wampmanager.conf';

$aliasDir = '../alias/';

if (!is_file($wampConfFile))
    die ('Unable to open WampServer\'s config file, please change path in index.php file');

$fp = fopen($wampConfFile,'r');
$wampConfFileContents = fread ($fp, filesize ($wampConfFile));
fclose ($fp);


// repertoires  gnorer dans les projets
$projectsListIgnore = array ('.','..');

// textes
$langues = array(
	'en' => array(
		'langue' => 'English',
		'autreLangue' => 'Version Fran&ccedil;aise',
		'autreLangueLien' => 'fr',
		'titreHtml' => 'WAMPSERVER Homepage',
		'titreConf' => 'Server Configuration',
		'versa' => 'Apache Version :',
		'versp' => 'PHP Version :',
		'versm' => 'MySQL Version :',
		'phpExt' => 'Loaded Extensions : ',
		'titrePage' => 'Ferramentas',
		'txtProjet' => 'Meus Projetos',
		'txtNoProjet' => 'No projects yet.<br />To create a new one, just create a directory in \'www\'.',
		'txtAlias' => 'Your Aliases',
		'txtNoAlias' => 'No Alias yet.<br />To create a new one, use the WAMPSERVER menu.',
		'faq' => 'http://www.en.wampserver.com/faq.php'
	),
	'fr' => array(
		'langue' => 'Fran?s',
		'autreLangue' => 'English Version',
		'autreLangueLien' => 'en',
		'titreHtml' => 'Accueil WAMPSERVER',
		'titreConf' => 'Configuration Serveur',
		'versa' => 'Version de Apache:',
		'versp' => 'Version de PHP:',
		'versm' => 'Version de MySQL:',
		'phpExt' => 'Extensions Charg&eacute;es: ',
		'titrePage' => 'Outils',
		'txtProjet' => 'Vos Projets',
		'txtNoProjet' => 'Aucun projet.<br /> Pour en ajouter un nouveau, cr&eacute;ez simplement un r&eacute;pertoire dans \'www\'.',
		'txtAlias' => 'Vos Alias',
		'txtNoAlias' => 'Aucun alias.<br /> Pour en ajouter un nouveau, utilisez le menu de WAMPSERVER.',
		'faq' => 'http://www.wampserver.com/faq.php'
	),
	'pt' => array(
		'langue' => 'Português',
		'autreLangue' => 'Versão Português',
		'autreLangueLien' => 'en',
		'titreHtml' => 'WAMPSERVER Homepage',
		'titreConf' => 'Configuração do servidor',
		'versa' => 'Versão do Apache :',
		'versp' => 'Versão PHP:',
		'versm' => 'Versão MySQL:',
		'phpExt' => 'Loaded Extensions : ',
		'titrePage' => 'Ferramentas',
		'txtProjet' => 'Meus Projetos',
		'txtNoProjet' => 'No projects yet.<br />Para criar um novo projeto, crie em  \'www\'.',
		'txtAlias' => 'Suas Alias',
		'txtNoAlias' => 'No Alias yet.<br />To create a new one, use the WAMPSERVER menu.',
		'faq' => 'http://www.en.wampserver.com/faq.php'
	)
);	




//affichage du phpinfo
if (isset($_GET['phpinfo']))
{
	phpinfo();
	exit();
}



// D?nition de la langue et des textes 

if (isset ($_GET['lang']))
{
	$langue = $_GET['lang'];
}
elseif (isset ($_SERVER['HTTP_ACCEPT_LANGUAGE']) AND preg_match("/^fr/", $_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
	$langue = 'fr';
}
elseif (isset ($_SERVER['HTTP_ACCEPT_LANGUAGE']) AND preg_match("/^pt/", $_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
	$langue = 'pt';
}
else
{
	$langue = 'en';
}

//initialisation
$aliasContents = '';

// recuperation des alias
if (is_dir($aliasDir))
{
    $handle=opendir($aliasDir);
    while ($file = readdir($handle)) 
    {
	    if (is_file($aliasDir.$file) && strstr($file, '.conf'))
	    {		
		    $msg = '';
		    $aliasContents .= '<li><a href="'.str_replace('.conf','',$file).'/">'.str_replace('.conf','',$file).'</a></li>';
	    }
    }
    closedir($handle);
}
if (!isset($aliasContents))
	$aliasContents = $langues[$langue]['txtNoAlias'];


// recuperation des projets
$handle=opendir(".");
$projectContents = '';
while ($file = readdir($handle)) 
{
	if (is_dir($file) && !in_array($file,$projectsListIgnore)) 
	{
		if($file != "assets"):
			$projectContents .= '<li><a href="'.$file.'" target="_blank">'.$file.'</a></li>';
		endif;
	}
}


closedir($handle);
if (!isset($projectContents))
	$projectContents = $langues[$langue]['txtNoProjet'];


//initialisation
$phpExtContents = '';

// recuperation des extensions PHP
$loaded_extensions = get_loaded_extensions();
foreach ($loaded_extensions as $extension)
	$phpExtContents .= "<li>${extension}</li>";

$conteudo_html = <<< EOPAGE
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>CMS - WeDoSites</title>
		
		<!-- Meta -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Domingos Nunes">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/imagens/favicon.ico">
		
		<!-- Web Fonts -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin">
		
		<!-- CSS Global Compulsory -->
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/header-default.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		
	</head>
	<body>			
					
			<div class="wrapper">
				<!--=== Header ===-->
				<div class="header">
					<div class="container">
						<!-- Logo -->
						<a class="logo" href="index.php">
							<img src="assets/imagens/logo.png" alt="Logo">
						</a>
						<!-- End Logo -->
						
						<!-- Toggle get grouped for better mobile display -->
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="fa fa-bars"></span>
						</button>
						<!-- End Toggle -->
					</div><!--/end container-->					
				
					<div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">
						<div class="container">
							<ul class="nav navbar-nav">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
										PROJETOS
									</a>
									<ul class="dropdown-menu">
										$projectContents
									</ul>
								</li>
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
										FERRAMENTAS
									</a>
									<ul class="dropdown-menu">
										<li><a href="phpmyadmin/">Banco MySQL</a></li>
										<li><a href="?phpinfo=-1" title="">Verão do PHP</a></li>
										<li><a href="?disp=bootstrap" title="">PHP Sysinfo</a></li>
										<li><a href="adminer" title="">Adminer</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<!--=== Breadcrumbs ===-->
				<div class="breadcrumbs margin-bottom-40">
					<div class="container">
				        <h1 class="color-green pull-left">Conteiner de projetos</h1>
				        <ul class="pull-right breadcrumb">
				            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
				            <li><a href="">Projetos</a> <span class="divider">/</span></li>
				            <li class="active">Bem-vindo</li>
				        </ul>
				    </div><!--/container-->
				</div><!--/breadcrumbs-->
				<!--=== End Breadcrumbs ===-->

				<!--=== Content Part ===-->
				<div class="container">		
					<div class="row-fluid page-404">
				    	<a href="projetos" class="btn btn-u btn-large btn-block btn-u-blue">Projetos</a>
				    	<a href="phpmyadmin" class="btn btn-u btn-large btn-block btn-u-sea">Banco de dados</a>
				    </div><!--/row-fluid-->        
				</div><!--/container-->		
				<!--=== End Content Part ===-->			

				<!--=== Footer ===-->
				<div id="footer-v1" class="footer-v1 navbar navbar-fixed-bottom">
					<div class="copyright">
						<div class="container">
							<div class="row">
								<div class="col-md-6">
									<p>
										2022 &copy; WeDoSites. Todos os direitos reservados.
										<a href="http://domingosnunes.com.br" target="blank">Domingos Nunes</a> | <a href="http://fazemos.site" target="blank">WeDoSites</a>
									</p>
								</div>
								<div class="col-md-6">
									<a href="index.php">
										<img class="pull-right" id="logo-footer" src="assets/imagens/logo.png" alt="">
									</a>
								</div>
							</div>
						</div>
					</div><!--/copyright-->
				</div>
				<!--=== End Footer ===-->
			</div>
		<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/bootstrap/js/app.js"></script>

		
	</body>
</html>
EOPAGE;

echo $conteudo_html;
?>
