<?php

/* overall_footer.html */
class __TwigTemplate_2896f646f62d2fd5ff2b5766b574e39349afc99e7adf34f97929f463b2c1bcb2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "\t\t";
        // line 2
        echo "\t</div> <!-- #page-body -->

";
        // line 4
        // line 5
        echo "

\t
</div><!-- #wrap -->

<div id=\"page-footer\" role=\"contentinfo\">
";
        // line 11
        $location = "navbar_footer.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("navbar_footer.html", "overall_footer.html", 11)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 12
        echo "
\t<div class=\"footerbar\">
\t<div class=\"footerbar-container\">
\t\t<div class=\"copyright\">
\t\t\t";
        // line 16
        // line 17
        echo "\t\t\t";
        echo (isset($context["CREDIT_LINE"]) ? $context["CREDIT_LINE"] : null);
        echo "
\t\t\t";
        // line 18
        if ((isset($context["TRANSLATION_INFO"]) ? $context["TRANSLATION_INFO"] : null)) {
            echo "<br />";
            echo (isset($context["TRANSLATION_INFO"]) ? $context["TRANSLATION_INFO"] : null);
        }
        // line 19
        echo "\t\t\t";
        // line 20
        echo "\t\t\t";
        if ((isset($context["DEBUG_OUTPUT"]) ? $context["DEBUG_OUTPUT"] : null)) {
            echo "<br />";
            echo (isset($context["DEBUG_OUTPUT"]) ? $context["DEBUG_OUTPUT"] : null);
        }
        // line 21
        echo "\t\t\t<br />Style proflat &copy; 2016 <a href=\"http://www.phpbb-fr.com/customise/db/author/mazeltof/\">Mazeltof</a>
\t\t\t";
        // line 22
        if ((isset($context["U_ACP"]) ? $context["U_ACP"] : null)) {
            echo "<br /><strong><a href=\"";
            echo (isset($context["U_ACP"]) ? $context["U_ACP"] : null);
            echo "\">[ ";
            echo $this->env->getExtension('phpbb')->lang("ACP");
            echo " ]</a></strong>";
        }
        // line 23
        echo "\t\t</div>
\t\t<div class=\"socialinks\">
\t\t\t<ul>
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"www.blogger.com\" class=\"icon-blogger\" title=\"Blogger\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"http://www.dailymotion.com/fr\" class=\"icon-dailymotion\" title=\"Dailymotion\"></a></li> -->
\t\t\t\t<li class=\"socialicon\"><a href=\"https://fr-fr.facebook.com/\" class=\"icon-facebook\" title=\"Facebook\"></a></li>
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://www.flickr.com/\" class=\"icon-flickr\" title=\"Flickr\"></a></li> -->
\t\t\t\t<li class=\"socialicon\"><a href=\"https://plus.google.com/\" class=\"icon-googleplus\" title=\"Google plus\"></a></li>
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://www.instagram.com/\" class=\"icon-instagram\" title=\"Instagram\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"http://line.me/fr/\" class=\"icon-line\" title=\"Line messenger\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://fr.linkedin.com/\" class=\"icon-linkedin\" title=\"Linked in\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://myspace.com/\" class=\"icon-myspace\" title=\"Myspace\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://fr.pinterest.com/\" class=\"icon-pinterest\" title=\"Pinterest\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://www.reddit.com/\" class=\"icon-reddit\" title=\"Reddit\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://www.skype.com/fr/\" class=\"icon-skype\" title=\"Skype\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://www.snapchat.com/l/fr-fr/\" class=\"icon-snapchat\" title=\"Snapchat\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://soundcloud.com/\" class=\"icon-soundcloud\" title=\"Soundcloud\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"http://store.steampowered.com/\" class=\"icon-steam\" title=\"Steam\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://www.tumblr.com/\" class=\"icon-tumblr\" title=\"Tumblr\"></a></li> -->
\t\t\t\t<li class=\"socialicon\"><a href=\"https://twitter.com/?lang=fr\" class=\"icon-twitter\" title=\"Twitter\"></a></li>
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://www.viber.com/fr/\" class=\"icon-viber\" title=\"Viber\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://www.whatsapp.com/?l=fr\" class=\"icon-whatsapp\" title=\"Whatsapp\"></a></li> -->
\t\t\t\t<!-- <li class=\"socialicon\"><a href=\"https://fr.wordpress.com/\" class=\"icon-wordpress\" title=\"Wordpress\"></a></li> -->
\t\t\t\t<li class=\"socialicon\"><a href=\"https://www.youtube.com/\" class=\"icon-youtube\" title=\"Youtube\"></a></li>
\t\t\t</ul>
\t\t</div>
\t</div>
\t</div>

</div>

\t<div id=\"darkenwrapper\" data-ajax-error-title=\"";
        // line 54
        echo $this->env->getExtension('phpbb')->lang("AJAX_ERROR_TITLE");
        echo "\" data-ajax-error-text=\"";
        echo $this->env->getExtension('phpbb')->lang("AJAX_ERROR_TEXT");
        echo "\" data-ajax-error-text-abort=\"";
        echo $this->env->getExtension('phpbb')->lang("AJAX_ERROR_TEXT_ABORT");
        echo "\" data-ajax-error-text-timeout=\"";
        echo $this->env->getExtension('phpbb')->lang("AJAX_ERROR_TEXT_TIMEOUT");
        echo "\" data-ajax-error-text-parsererror=\"";
        echo $this->env->getExtension('phpbb')->lang("AJAX_ERROR_TEXT_PARSERERROR");
        echo "\">
\t\t<div id=\"darken\">&nbsp;</div>
\t</div>

\t<div id=\"phpbb_alert\" class=\"phpbb_alert\" data-l-err=\"";
        // line 58
        echo $this->env->getExtension('phpbb')->lang("ERROR");
        echo "\" data-l-timeout-processing-req=\"";
        echo $this->env->getExtension('phpbb')->lang("TIMEOUT_PROCESSING_REQ");
        echo "\">
\t\t<a href=\"#\" class=\"alert_close\"></a>
\t\t<h3 class=\"alert_title\">&nbsp;</h3><p class=\"alert_text\"></p>
\t</div>
\t<div id=\"phpbb_confirm\" class=\"phpbb_alert\">
\t\t<a href=\"#\" class=\"alert_close\"></a>
\t\t<div class=\"alert_text\"></div>
\t</div>

<div>
\t<a id=\"bottom\" class=\"anchor\" accesskey=\"z\"></a>
\t";
        // line 69
        if ( !(isset($context["S_IS_BOT"]) ? $context["S_IS_BOT"] : null)) {
            echo (isset($context["RUN_CRON_TASK"]) ? $context["RUN_CRON_TASK"] : null);
        }
        // line 70
        echo "</div>

<script type=\"text/javascript\" src=\"";
        // line 72
        echo (isset($context["T_JQUERY_LINK"]) ? $context["T_JQUERY_LINK"] : null);
        echo "\"></script>
";
        // line 73
        if ((isset($context["S_ALLOW_CDN"]) ? $context["S_ALLOW_CDN"] : null)) {
            echo "<script type=\"text/javascript\">window.jQuery || document.write('\\x3Cscript src=\"";
            echo (isset($context["T_ASSETS_PATH"]) ? $context["T_ASSETS_PATH"] : null);
            echo "/javascript/jquery.min.js?assets_version=";
            echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
            echo "\">\\x3C/script>');</script>";
        }
        // line 74
        echo "<script type=\"text/javascript\" src=\"";
        echo (isset($context["T_ASSETS_PATH"]) ? $context["T_ASSETS_PATH"] : null);
        echo "/javascript/core.js?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\"></script>
";
        // line 75
        $asset_file = "forum_fn.js";
        $asset = new \phpbb\template\asset($asset_file, $this->getEnvironment()->get_path_helper());
        if (substr($asset_file, 0, 2) !== './' && $asset->is_relative()) {
            $asset_path = $asset->get_path();            $local_file = $this->getEnvironment()->get_phpbb_root_path() . $asset_path;
            if (!file_exists($local_file)) {
                $local_file = $this->getEnvironment()->findTemplate($asset_path);
                $asset->set_path($local_file, true);
            $asset->add_assets_version('1');
            $asset_file = $asset->get_url();
            }
        }
        $context['definition']->append('SCRIPTS', '<script type="text/javascript" src="' . $asset_file. '"></script>

');
        // line 76
        $asset_file = "ajax.js";
        $asset = new \phpbb\template\asset($asset_file, $this->getEnvironment()->get_path_helper());
        if (substr($asset_file, 0, 2) !== './' && $asset->is_relative()) {
            $asset_path = $asset->get_path();            $local_file = $this->getEnvironment()->get_phpbb_root_path() . $asset_path;
            if (!file_exists($local_file)) {
                $local_file = $this->getEnvironment()->findTemplate($asset_path);
                $asset->set_path($local_file, true);
            $asset->add_assets_version('1');
            $asset_file = $asset->get_url();
            }
        }
        $context['definition']->append('SCRIPTS', '<script type="text/javascript" src="' . $asset_file. '"></script>

');
        // line 77
        echo "
";
        // line 78
        // line 79
        echo "
";
        // line 80
        if ((isset($context["S_PLUPLOAD"]) ? $context["S_PLUPLOAD"] : null)) {
            $location = "plupload.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("plupload.html", "overall_footer.html", 80)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
        }
        // line 81
        echo "
";
        // line 82
        echo $this->getAttribute((isset($context["definition"]) ? $context["definition"] : null), "SCRIPTS", array());
        echo "

";
        // line 84
        // line 85
        echo "
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "overall_footer.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  233 => 85,  232 => 84,  227 => 82,  224 => 81,  210 => 80,  207 => 79,  206 => 78,  203 => 77,  188 => 76,  173 => 75,  166 => 74,  158 => 73,  154 => 72,  150 => 70,  146 => 69,  130 => 58,  115 => 54,  82 => 23,  74 => 22,  71 => 21,  65 => 20,  63 => 19,  58 => 18,  53 => 17,  52 => 16,  46 => 12,  34 => 11,  26 => 5,  25 => 4,  21 => 2,  19 => 1,);
    }
}
/* 		<!-- EVENT overall_footer_content_after -->*/
/* 	</div> <!-- #page-body -->*/
/* */
/* <!-- EVENT overall_footer_page_body_after -->*/
/* */
/* */
/* 	*/
/* </div><!-- #wrap -->*/
/* */
/* <div id="page-footer" role="contentinfo">*/
/* <!-- INCLUDE navbar_footer.html -->*/
/* */
/* 	<div class="footerbar">*/
/* 	<div class="footerbar-container">*/
/* 		<div class="copyright">*/
/* 			<!-- EVENT overall_footer_copyright_prepend -->*/
/* 			{CREDIT_LINE}*/
/* 			<!-- IF TRANSLATION_INFO --><br />{TRANSLATION_INFO}<!-- ENDIF -->*/
/* 			<!-- EVENT overall_footer_copyright_append -->*/
/* 			<!-- IF DEBUG_OUTPUT --><br />{DEBUG_OUTPUT}<!-- ENDIF -->*/
/* 			<br />Style proflat &copy; 2016 <a href="http://www.phpbb-fr.com/customise/db/author/mazeltof/">Mazeltof</a>*/
/* 			<!-- IF U_ACP --><br /><strong><a href="{U_ACP}">[ {L_ACP} ]</a></strong><!-- ENDIF -->*/
/* 		</div>*/
/* 		<div class="socialinks">*/
/* 			<ul>*/
/* 				<!-- <li class="socialicon"><a href="www.blogger.com" class="icon-blogger" title="Blogger"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="http://www.dailymotion.com/fr" class="icon-dailymotion" title="Dailymotion"></a></li> -->*/
/* 				<li class="socialicon"><a href="https://fr-fr.facebook.com/" class="icon-facebook" title="Facebook"></a></li>*/
/* 				<!-- <li class="socialicon"><a href="https://www.flickr.com/" class="icon-flickr" title="Flickr"></a></li> -->*/
/* 				<li class="socialicon"><a href="https://plus.google.com/" class="icon-googleplus" title="Google plus"></a></li>*/
/* 				<!-- <li class="socialicon"><a href="https://www.instagram.com/" class="icon-instagram" title="Instagram"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="http://line.me/fr/" class="icon-line" title="Line messenger"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://fr.linkedin.com/" class="icon-linkedin" title="Linked in"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://myspace.com/" class="icon-myspace" title="Myspace"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://fr.pinterest.com/" class="icon-pinterest" title="Pinterest"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://www.reddit.com/" class="icon-reddit" title="Reddit"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://www.skype.com/fr/" class="icon-skype" title="Skype"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://www.snapchat.com/l/fr-fr/" class="icon-snapchat" title="Snapchat"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://soundcloud.com/" class="icon-soundcloud" title="Soundcloud"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="http://store.steampowered.com/" class="icon-steam" title="Steam"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://www.tumblr.com/" class="icon-tumblr" title="Tumblr"></a></li> -->*/
/* 				<li class="socialicon"><a href="https://twitter.com/?lang=fr" class="icon-twitter" title="Twitter"></a></li>*/
/* 				<!-- <li class="socialicon"><a href="https://www.viber.com/fr/" class="icon-viber" title="Viber"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://www.whatsapp.com/?l=fr" class="icon-whatsapp" title="Whatsapp"></a></li> -->*/
/* 				<!-- <li class="socialicon"><a href="https://fr.wordpress.com/" class="icon-wordpress" title="Wordpress"></a></li> -->*/
/* 				<li class="socialicon"><a href="https://www.youtube.com/" class="icon-youtube" title="Youtube"></a></li>*/
/* 			</ul>*/
/* 		</div>*/
/* 	</div>*/
/* 	</div>*/
/* */
/* </div>*/
/* */
/* 	<div id="darkenwrapper" data-ajax-error-title="{L_AJAX_ERROR_TITLE}" data-ajax-error-text="{L_AJAX_ERROR_TEXT}" data-ajax-error-text-abort="{L_AJAX_ERROR_TEXT_ABORT}" data-ajax-error-text-timeout="{L_AJAX_ERROR_TEXT_TIMEOUT}" data-ajax-error-text-parsererror="{L_AJAX_ERROR_TEXT_PARSERERROR}">*/
/* 		<div id="darken">&nbsp;</div>*/
/* 	</div>*/
/* */
/* 	<div id="phpbb_alert" class="phpbb_alert" data-l-err="{L_ERROR}" data-l-timeout-processing-req="{L_TIMEOUT_PROCESSING_REQ}">*/
/* 		<a href="#" class="alert_close"></a>*/
/* 		<h3 class="alert_title">&nbsp;</h3><p class="alert_text"></p>*/
/* 	</div>*/
/* 	<div id="phpbb_confirm" class="phpbb_alert">*/
/* 		<a href="#" class="alert_close"></a>*/
/* 		<div class="alert_text"></div>*/
/* 	</div>*/
/* */
/* <div>*/
/* 	<a id="bottom" class="anchor" accesskey="z"></a>*/
/* 	<!-- IF not S_IS_BOT -->{RUN_CRON_TASK}<!-- ENDIF -->*/
/* </div>*/
/* */
/* <script type="text/javascript" src="{T_JQUERY_LINK}"></script>*/
/* <!-- IF S_ALLOW_CDN --><script type="text/javascript">window.jQuery || document.write('\x3Cscript src="{T_ASSETS_PATH}/javascript/jquery.min.js?assets_version={T_ASSETS_VERSION}">\x3C/script>');</script><!-- ENDIF -->*/
/* <script type="text/javascript" src="{T_ASSETS_PATH}/javascript/core.js?assets_version={T_ASSETS_VERSION}"></script>*/
/* <!-- INCLUDEJS forum_fn.js -->*/
/* <!-- INCLUDEJS ajax.js -->*/
/* */
/* <!-- EVENT overall_footer_after -->*/
/* */
/* <!-- IF S_PLUPLOAD --><!-- INCLUDE plupload.html --><!-- ENDIF -->*/
/* */
/* {$SCRIPTS}*/
/* */
/* <!-- EVENT overall_footer_body_after -->*/
/* */
/* </body>*/
/* </html>*/
/* */
