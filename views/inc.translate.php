<?php
if (isset($uri[0]) && $uri[0] == 'toggletranslate')
{
	$session->translate = !$session->translate;
}

if ($session->translate)
{
?>
<div id="google_translate_element" style="position: fixed; bottom: 0; right: 0;"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: '<?php echo $session->language; ?>', layout: google.translate.TranslateElement.FloatPosition.BOTTOM_RIGHT, autoDisplay: false, multilanguagePage: true}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<style type="text/css">body { top: 0 !important; } div.skiptranslate > iframe { display: none !important; }</style>
<?php
}
?>