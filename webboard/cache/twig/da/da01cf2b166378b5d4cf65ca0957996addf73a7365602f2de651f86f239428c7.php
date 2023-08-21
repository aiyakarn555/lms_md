<?php

/* navbar_top.html */
class __TwigTemplate_4188af2b049804d7e8c65816e7acd1bf497dcb5991d8bdf1562f6faa4adf0103 extends Twig_Template
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
        echo "<div class=\"navbar\" >
\t<div class=\"navbar-container\">
\t\t<ul id=\"nav-main\" class=\"linklist bulletin\" role=\"menubar\">

\t\t\t<li id=\"quick-links\" class=\"small-icon responsive-menu dropdown-container";
        // line 5
        if (( !(isset($context["S_DISPLAY_QUICK_LINKS"]) ? $context["S_DISPLAY_QUICK_LINKS"] : null) &&  !(isset($context["S_DISPLAY_SEARCH"]) ? $context["S_DISPLAY_SEARCH"] : null))) {
            echo " hidden";
        }
        echo "\" data-skip-responsive=\"true\">
\t\t\t\t<a href=\"#\" class=\"responsive-menu-link dropdown-trigger\">";
        // line 6
        echo $this->env->getExtension('phpbb')->lang("QUICK_LINKS");
        echo "</a>
\t\t\t\t<div class=\"dropdown hidden\">
\t\t\t\t\t<div class=\"pointer\"><div class=\"pointer-inner\"></div></div>
\t\t\t\t\t<ul class=\"dropdown-contents\" role=\"menu\">
\t\t\t\t\t\t";
        // line 10
        // line 11
        echo "
\t\t\t\t\t\t";
        // line 12
        if ((isset($context["S_DISPLAY_SEARCH"]) ? $context["S_DISPLAY_SEARCH"] : null)) {
            // line 13
            echo "\t\t\t\t\t\t\t<li class=\"separator\"></li>
\t\t\t\t\t\t\t";
            // line 14
            if ((isset($context["S_REGISTERED_USER"]) ? $context["S_REGISTERED_USER"] : null)) {
                // line 15
                echo "\t\t\t\t\t\t\t\t<li class=\"small-icon icon-search-self\"><a href=\"";
                echo (isset($context["U_SEARCH_SELF"]) ? $context["U_SEARCH_SELF"] : null);
                echo "\" role=\"menuitem\">";
                echo $this->env->getExtension('phpbb')->lang("SEARCH_SELF");
                echo "</a></li>
\t\t\t\t\t\t\t";
            }
            // line 17
            echo "\t\t\t\t\t\t\t";
            if ((isset($context["S_USER_LOGGED_IN"]) ? $context["S_USER_LOGGED_IN"] : null)) {
                // line 18
                echo "\t\t\t\t\t\t\t\t<li class=\"small-icon icon-search-new\"><a href=\"";
                echo (isset($context["U_SEARCH_NEW"]) ? $context["U_SEARCH_NEW"] : null);
                echo "\" role=\"menuitem\">";
                echo $this->env->getExtension('phpbb')->lang("SEARCH_NEW");
                echo "</a></li>
\t\t\t\t\t\t\t";
            }
            // line 20
            echo "\t\t\t\t\t\t\t";
            if ((isset($context["S_LOAD_UNREADS"]) ? $context["S_LOAD_UNREADS"] : null)) {
                echo " 
\t\t\t\t\t\t\t\t<li class=\"small-icon icon-search-unread\"><a href=\"";
                // line 21
                echo (isset($context["U_SEARCH_UNREAD"]) ? $context["U_SEARCH_UNREAD"] : null);
                echo "\" role=\"menuitem\">";
                echo $this->env->getExtension('phpbb')->lang("SEARCH_UNREAD");
                echo "</a></li>
\t\t\t\t\t\t\t";
            }
            // line 23
            echo "\t\t\t\t\t\t\t<li class=\"small-icon icon-search-unanswered\"><a href=\"";
            echo (isset($context["U_SEARCH_UNANSWERED"]) ? $context["U_SEARCH_UNANSWERED"] : null);
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("SEARCH_UNANSWERED");
            echo "</a></li>
\t\t\t\t\t\t\t<li class=\"small-icon icon-search-active\"><a href=\"";
            // line 24
            echo (isset($context["U_SEARCH_ACTIVE_TOPICS"]) ? $context["U_SEARCH_ACTIVE_TOPICS"] : null);
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("SEARCH_ACTIVE_TOPICS");
            echo "</a></li>
\t\t\t\t\t\t\t<li class=\"separator\"></li>
\t\t\t\t\t\t\t<li class=\"small-icon icon-search\"><a href=\"";
            // line 26
            echo (isset($context["U_SEARCH"]) ? $context["U_SEARCH"] : null);
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("SEARCH");
            echo "</a></li>
\t\t\t\t\t\t";
        }
        // line 28
        echo "
\t\t\t\t\t\t";
        // line 29
        if (( !(isset($context["S_IS_BOT"]) ? $context["S_IS_BOT"] : null) && ((isset($context["S_DISPLAY_MEMBERLIST"]) ? $context["S_DISPLAY_MEMBERLIST"] : null) || (isset($context["U_TEAM"]) ? $context["U_TEAM"] : null)))) {
            // line 30
            echo "\t\t\t\t\t\t\t<li class=\"separator\"></li>
\t\t\t\t\t\t\t";
            // line 31
            if ((isset($context["S_DISPLAY_MEMBERLIST"]) ? $context["S_DISPLAY_MEMBERLIST"] : null)) {
                echo "<li class=\"small-icon icon-members\"><a href=\"";
                echo (isset($context["U_MEMBERLIST"]) ? $context["U_MEMBERLIST"] : null);
                echo "\" role=\"menuitem\">";
                echo $this->env->getExtension('phpbb')->lang("MEMBERLIST");
                echo "</a></li>";
            }
            // line 32
            echo "\t\t\t\t\t\t\t";
            if ((isset($context["U_TEAM"]) ? $context["U_TEAM"] : null)) {
                echo "<li class=\"small-icon icon-team\"><a href=\"";
                echo (isset($context["U_TEAM"]) ? $context["U_TEAM"] : null);
                echo "\" role=\"menuitem\">";
                echo $this->env->getExtension('phpbb')->lang("THE_TEAM");
                echo "</a></li>";
            }
            // line 33
            echo "\t\t\t\t\t\t";
        }
        // line 34
        echo "\t\t\t\t\t\t<li class=\"separator\"></li>

\t\t\t\t\t\t";
        // line 36
        // line 37
        echo "\t\t\t\t\t</ul>
\t\t\t\t</div>
\t\t\t</li>
\t\t\t

\t\t\t";
        // line 42
        // line 43
        echo "\t\t\t<li class=\"small-icon icon-faq\" ";
        if ( !(isset($context["S_USER_LOGGED_IN"]) ? $context["S_USER_LOGGED_IN"] : null)) {
            echo "data-skip-responsive=\"true\"";
        } else {
            echo "data-last-responsive=\"true\"";
        }
        echo "><a href=\"";
        echo (isset($context["U_FAQ"]) ? $context["U_FAQ"] : null);
        echo "\" rel=\"help\" title=\"";
        echo $this->env->getExtension('phpbb')->lang("FAQ_EXPLAIN");
        echo "\" role=\"menuitem\">";
        echo $this->env->getExtension('phpbb')->lang("FAQ");
        echo "</a></li>
\t\t\t";
        // line 44
        // line 45
        echo "\t\t\t";
        if ((isset($context["U_ACP"]) ? $context["U_ACP"] : null)) {
            echo "<li class=\"small-icon icon-acp\" data-last-responsive=\"true\"><a href=\"";
            echo (isset($context["U_ACP"]) ? $context["U_ACP"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("ACP");
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("ACP_SHORT");
            echo "</a></li>";
        }
        // line 46
        echo "\t\t\t";
        if ((isset($context["U_MCP"]) ? $context["U_MCP"] : null)) {
            echo "<li class=\"small-icon icon-mcp\" data-last-responsive=\"true\"><a href=\"";
            echo (isset($context["U_MCP"]) ? $context["U_MCP"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("MCP");
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("MCP_SHORT");
            echo "</a></li>";
        }
        // line 47
        echo "
\t\t\t<style>
\t\t\t\tli.boardla{
\t\t\t\t\tlist-style:none;
\t\t\t\t}

\t\t\t\tli.boardla::before{
\t\t\t\t\tcontent: none !important;
\t\t\t\t}
\t\t\t\t.boarden-th{
\t\t\t\t\tlist-style: none;
\t\t\t\t\tmargin: 0;
\t\t\t\t    padding: 0;
\t\t\t\t    overflow: hidden;
\t\t\t\t}
\t\t\t\tli.flag{
\t\t\t\t\tfloat: left;
\t\t\t\t\tpadding: 0 5px;
\t\t\t\t\tmargin: 0 3px;
\t\t\t\t}
\t\t\t\t.activeflag{
\t\t\t\t\tborder-bottom: 3px solid #959595;
\t\t\t\t}

\t\t\t\t:target {
\t\t\t\t  color: red;
\t\t\t\t}

\t\t\t\t.activeLang{
\t\t\t\t\tcolor: red;
\t\t\t\t}

\t\t\t</style>
\t\t\t<script src=\"https://code.jquery.com/jquery-1.9.1.min.js\"></script>
\t\t\t<li class=\"boardla\">
<!--                               <ul class=\"boarden-th\">
                                <li class=\"flag activeflag\"><a href=\"?lang=1\"><img src=\"https://upload.wikimedia.org/wikipedia/en/thumb/a/ae/Flag_of_the_United_Kingdom.svg/1280px-Flag_of_the_United_Kingdom.svg.png\" width=\"30px\" alt=\"\"></a></li>
                                <li class=\"flag\"><a href=\"?lang=2\"><img src=\"https://i.pinimg.com/originals/93/89/28/938928e41dd1ff657c396cd2cb45d652.jpg\"  width=\"30px\" alt=\"\"></a></li>
                              </ul>  -->

                             <a href=\"javascript:void(0)\" id='target1' class='target' onclick=\"re('1')\">EN</a> | <a href=\"javascript:void(0)\" id='target2' class='target' onclick=\"re('2')\">TH</a>
\t\t\t\t\t\t\t
            </li>
            <script>
            \t\t\$( document ).ready(function() {
\t\t\t\t        console.log( \"document loaded\" );
\t\t\t\t        activeLang();
\t\t\t\t    });

\t\t\t\tfunction activeLang(){
\t\t\t\t\t\$(document).ready(function(){
\t\t\t\t\t\tvar url_string = window.location.href;
\t\t\t\t\t\tvar url = new URL(url_string);
\t\t\t\t\t\tvar getValue = url.searchParams.get(\"lang\");
\t\t\t\t\t\tvar x = document.getElementsByClassName(\"target\");
\t\t\t\t\t 
\t\t\t\t\t    \tif(getValue == 1){
\t\t\t\t\t    \t\t\$(\"#target1\").addClass(\"activeLang\");
\t\t\t\t\t    \t\t\$(\"#target2\").removeClass(\"activeLang\");
\t\t\t\t\t    \t\tconsole.log(\"add target1\");
\t\t\t\t\t    \t}else{
\t\t\t\t\t    \t\t\$(\"#target2\").addClass(\"activeLang\");
\t\t\t\t\t    \t\t\$(\"#target1\").removeClass(\"activeLang\");
\t\t\t\t\t    \t\tconsole.log(\"add target2\");
\t\t\t\t\t    \t}
\t\t\t\t\t        
\t\t\t\t\t\t   
\t\t\t\t\t\t});
\t\t\t\t\t}    

\t\t\t\tfunction re(langId) {
\t\t\t\t    // location.reload();
\t\t\t\t    var url = window.location.href;
\t\t\t\t    // console.log(url);    
\t\t\t\t\t   // url += '?lang='+langId;
\t\t\t\t\tvar searchUrl = url.search(\"lang\");
\t\t\t\t\t// console.log(searchUrl);
\t\t\t\t\tif(searchUrl <= -1){
\t\t\t\t\t\turl += \"&lang=\"+langId;
\t\t\t\t\t}else{

\t\t\t\t\t   if(langId == 1){
\t\t\t\t\t   \t url = url.replace(/lang=2/g , \"lang=\"+langId);
\t\t\t\t\t   }else{
\t\t\t\t\t   \t url = url.replace(/lang=1/g , \"lang=\"+langId);
\t\t\t\t\t   }
\t\t\t\t\t}
\t\t\t\t\t// console.log(url);

\t\t\t\t\twindow.location.href = url;
\t\t\t\t}

\t\t\t</script>

\t";
        // line 141
        if ((isset($context["S_REGISTERED_USER"]) ? $context["S_REGISTERED_USER"] : null)) {
            // line 142
            echo "\t\t";
            // line 143
            echo "\t\t\t<li id=\"username_logged_in\" class=\"rightside ";
            if ((isset($context["CURRENT_USER_AVATAR"]) ? $context["CURRENT_USER_AVATAR"] : null)) {
                echo " no-bulletin";
            }
            echo "\" data-skip-responsive=\"true\">
\t\t\t\t";
            // line 144
            // line 145
            echo "\t\t\t\t<div class=\"header-profile dropdown-container\">
\t\t\t\t\t<a href=\"";
            // line 146
            echo (isset($context["U_PROFILE"]) ? $context["U_PROFILE"] : null);
            echo "\" class=\"header-avatar dropdown-trigger\">";
            if ((isset($context["CURRENT_USER_AVATAR"]) ? $context["CURRENT_USER_AVATAR"] : null)) {
                echo (isset($context["CURRENT_USER_AVATAR"]) ? $context["CURRENT_USER_AVATAR"] : null);
                echo " ";
            }
            echo (isset($context["CURRENT_USERNAME_SIMPLE"]) ? $context["CURRENT_USERNAME_SIMPLE"] : null);
            echo "</a>
\t\t\t\t\t<div class=\"dropdown hidden\">
\t\t\t\t\t\t<div class=\"pointer\"><div class=\"pointer-inner\"></div></div>
\t\t\t\t\t\t<ul class=\"dropdown-contents\" role=\"menu\">
\t\t\t\t\t\t\t";
            // line 150
            if ((isset($context["U_RESTORE_PERMISSIONS"]) ? $context["U_RESTORE_PERMISSIONS"] : null)) {
                echo "<li class=\"small-icon icon-restore-permissions\"><a href=\"";
                echo (isset($context["U_RESTORE_PERMISSIONS"]) ? $context["U_RESTORE_PERMISSIONS"] : null);
                echo "\">";
                echo $this->env->getExtension('phpbb')->lang("RESTORE_PERMISSIONS");
                echo "</a></li>";
            }
            // line 151
            echo "\t
\t\t\t\t\t\t\t";
            // line 152
            // line 153
            echo "\t
\t\t\t\t\t\t\t<li class=\"small-icon icon-ucp\"><a href=\"";
            // line 154
            echo (isset($context["U_PROFILE"]) ? $context["U_PROFILE"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("PROFILE");
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("PROFILE");
            echo "</a></li>
\t\t\t\t\t\t\t<li class=\"small-icon icon-profile\"><a href=\"";
            // line 155
            echo (isset($context["U_USER_PROFILE"]) ? $context["U_USER_PROFILE"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("READ_PROFILE");
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("READ_PROFILE");
            echo "</a></li>
\t
\t\t\t\t\t\t\t";
            // line 157
            // line 158
            echo "\t
\t\t\t\t\t\t\t<li class=\"separator\"></li>
\t\t\t\t\t\t\t<li class=\"small-icon icon-logout\"><a href=\"";
            // line 160
            echo (isset($context["U_LOGIN_LOGOUT"]) ? $context["U_LOGIN_LOGOUT"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("LOGIN_LOGOUT");
            echo "\" accesskey=\"x\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("LOGIN_LOGOUT");
            echo "</a></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t";
            // line 164
            // line 165
            echo "\t\t\t</li>
\t\t\t";
            // line 166
            if ((isset($context["S_DISPLAY_PM"]) ? $context["S_DISPLAY_PM"] : null)) {
                // line 167
                echo "\t\t\t\t<li class=\"small-icon icon-pm rightside\" data-skip-responsive=\"true\">
\t\t\t\t\t<a href=\"";
                // line 168
                echo (isset($context["U_PRIVATEMSGS"]) ? $context["U_PRIVATEMSGS"] : null);
                echo "\" role=\"menuitem\"><span>";
                echo $this->env->getExtension('phpbb')->lang("PRIVATE_MESSAGES");
                echo " </span><strong class=\"badge";
                if ( !(isset($context["PRIVATE_MESSAGE_COUNT"]) ? $context["PRIVATE_MESSAGE_COUNT"] : null)) {
                    echo " hidden";
                }
                echo "\">";
                echo (isset($context["PRIVATE_MESSAGE_COUNT"]) ? $context["PRIVATE_MESSAGE_COUNT"] : null);
                echo "</strong></a>
\t\t\t\t</li>
\t\t\t";
            }
            // line 171
            echo "\t\t\t";
            if ((isset($context["S_NOTIFICATIONS_DISPLAY"]) ? $context["S_NOTIFICATIONS_DISPLAY"] : null)) {
                // line 172
                echo "\t\t\t\t<li class=\"small-icon icon-notification dropdown-container dropdown-";
                echo (isset($context["S_CONTENT_FLOW_END"]) ? $context["S_CONTENT_FLOW_END"] : null);
                echo " rightside\" data-skip-responsive=\"true\">
\t\t\t\t\t<a href=\"";
                // line 173
                echo (isset($context["U_VIEW_ALL_NOTIFICATIONS"]) ? $context["U_VIEW_ALL_NOTIFICATIONS"] : null);
                echo "\" id=\"notification_list_button\" class=\"dropdown-trigger\"><span>";
                echo $this->env->getExtension('phpbb')->lang("NOTIFICATIONS");
                echo " </span><strong class=\"badge";
                if ( !(isset($context["NOTIFICATIONS_COUNT"]) ? $context["NOTIFICATIONS_COUNT"] : null)) {
                    echo " hidden";
                }
                echo "\">";
                echo (isset($context["NOTIFICATIONS_COUNT"]) ? $context["NOTIFICATIONS_COUNT"] : null);
                echo "</strong></a>
\t\t\t\t\t";
                // line 174
                $location = "notification_dropdown.html";
                $namespace = false;
                if (strpos($location, '@') === 0) {
                    $namespace = substr($location, 1, strpos($location, '/') - 1);
                    $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                    $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
                }
                $this->loadTemplate("notification_dropdown.html", "navbar_top.html", 174)->display($context);
                if ($namespace) {
                    $this->env->setNamespaceLookUpOrder($previous_look_up_order);
                }
                // line 175
                echo "\t\t\t\t</li>
\t\t\t";
            }
            // line 177
            echo "\t\t\t";
            // line 178
            echo "\t\t";
        } else {
            // line 179
            echo "\t\t\t<li class=\"small-icon icon-logout rightside\"  data-skip-responsive=\"true\"><a href=\"";
            echo (isset($context["U_LOGIN_LOGOUT"]) ? $context["U_LOGIN_LOGOUT"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("LOGIN_LOGOUT");
            echo "\" accesskey=\"x\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("LOGIN_LOGOUT");
            echo "</a></li>
\t\t\t";
            // line 180
            if (((isset($context["S_REGISTER_ENABLED"]) ? $context["S_REGISTER_ENABLED"] : null) &&  !((isset($context["S_SHOW_COPPA"]) ? $context["S_SHOW_COPPA"] : null) || (isset($context["S_REGISTRATION"]) ? $context["S_REGISTRATION"] : null)))) {
                // line 181
                echo "\t\t\t\t<li class=\"small-icon icon-register rightside\" data-skip-responsive=\"true\"><a href=\"";
                echo (isset($context["U_REGISTER"]) ? $context["U_REGISTER"] : null);
                echo "\" role=\"menuitem\">";
                echo $this->env->getExtension('phpbb')->lang("REGISTER");
                echo "</a></li>
\t\t\t";
            }
            // line 183
            echo "\t\t\t";
            // line 184
            echo "\t\t";
        }
        // line 185
        echo "\t\t</ul>
\t</div>
</div>";
    }

    public function getTemplateName()
    {
        return "navbar_top.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  440 => 185,  437 => 184,  435 => 183,  427 => 181,  425 => 180,  416 => 179,  413 => 178,  411 => 177,  407 => 175,  395 => 174,  383 => 173,  378 => 172,  375 => 171,  361 => 168,  358 => 167,  356 => 166,  353 => 165,  352 => 164,  341 => 160,  337 => 158,  336 => 157,  327 => 155,  319 => 154,  316 => 153,  315 => 152,  312 => 151,  304 => 150,  291 => 146,  288 => 145,  287 => 144,  280 => 143,  278 => 142,  276 => 141,  180 => 47,  169 => 46,  158 => 45,  157 => 44,  142 => 43,  141 => 42,  134 => 37,  133 => 36,  129 => 34,  126 => 33,  117 => 32,  109 => 31,  106 => 30,  104 => 29,  101 => 28,  94 => 26,  87 => 24,  80 => 23,  73 => 21,  68 => 20,  60 => 18,  57 => 17,  49 => 15,  47 => 14,  44 => 13,  42 => 12,  39 => 11,  38 => 10,  31 => 6,  25 => 5,  19 => 1,);
    }
}
/* <div class="navbar" >*/
/* 	<div class="navbar-container">*/
/* 		<ul id="nav-main" class="linklist bulletin" role="menubar">*/
/* */
/* 			<li id="quick-links" class="small-icon responsive-menu dropdown-container<!-- IF not S_DISPLAY_QUICK_LINKS and not S_DISPLAY_SEARCH --> hidden<!-- ENDIF -->" data-skip-responsive="true">*/
/* 				<a href="#" class="responsive-menu-link dropdown-trigger">{L_QUICK_LINKS}</a>*/
/* 				<div class="dropdown hidden">*/
/* 					<div class="pointer"><div class="pointer-inner"></div></div>*/
/* 					<ul class="dropdown-contents" role="menu">*/
/* 						<!-- EVENT navbar_header_quick_links_before -->*/
/* */
/* 						<!-- IF S_DISPLAY_SEARCH -->*/
/* 							<li class="separator"></li>*/
/* 							<!-- IF S_REGISTERED_USER -->*/
/* 								<li class="small-icon icon-search-self"><a href="{U_SEARCH_SELF}" role="menuitem">{L_SEARCH_SELF}</a></li>*/
/* 							<!-- ENDIF -->*/
/* 							<!-- IF S_USER_LOGGED_IN -->*/
/* 								<li class="small-icon icon-search-new"><a href="{U_SEARCH_NEW}" role="menuitem">{L_SEARCH_NEW}</a></li>*/
/* 							<!-- ENDIF -->*/
/* 							<!-- IF S_LOAD_UNREADS --> */
/* 								<li class="small-icon icon-search-unread"><a href="{U_SEARCH_UNREAD}" role="menuitem">{L_SEARCH_UNREAD}</a></li>*/
/* 							<!-- ENDIF -->*/
/* 							<li class="small-icon icon-search-unanswered"><a href="{U_SEARCH_UNANSWERED}" role="menuitem">{L_SEARCH_UNANSWERED}</a></li>*/
/* 							<li class="small-icon icon-search-active"><a href="{U_SEARCH_ACTIVE_TOPICS}" role="menuitem">{L_SEARCH_ACTIVE_TOPICS}</a></li>*/
/* 							<li class="separator"></li>*/
/* 							<li class="small-icon icon-search"><a href="{U_SEARCH}" role="menuitem">{L_SEARCH}</a></li>*/
/* 						<!-- ENDIF -->*/
/* */
/* 						<!-- IF not S_IS_BOT and (S_DISPLAY_MEMBERLIST or U_TEAM) -->*/
/* 							<li class="separator"></li>*/
/* 							<!-- IF S_DISPLAY_MEMBERLIST --><li class="small-icon icon-members"><a href="{U_MEMBERLIST}" role="menuitem">{L_MEMBERLIST}</a></li><!-- ENDIF -->*/
/* 							<!-- IF U_TEAM --><li class="small-icon icon-team"><a href="{U_TEAM}" role="menuitem">{L_THE_TEAM}</a></li><!-- ENDIF -->*/
/* 						<!-- ENDIF -->*/
/* 						<li class="separator"></li>*/
/* */
/* 						<!-- EVENT navbar_header_quick_links_after -->*/
/* 					</ul>*/
/* 				</div>*/
/* 			</li>*/
/* 			*/
/* */
/* 			<!-- EVENT overall_header_navigation_prepend -->*/
/* 			<li class="small-icon icon-faq" <!-- IF not S_USER_LOGGED_IN -->data-skip-responsive="true"<!-- ELSE -->data-last-responsive="true"<!-- ENDIF -->><a href="{U_FAQ}" rel="help" title="{L_FAQ_EXPLAIN}" role="menuitem">{L_FAQ}</a></li>*/
/* 			<!-- EVENT overall_header_navigation_append -->*/
/* 			<!-- IF U_ACP --><li class="small-icon icon-acp" data-last-responsive="true"><a href="{U_ACP}" title="{L_ACP}" role="menuitem">{L_ACP_SHORT}</a></li><!-- ENDIF -->*/
/* 			<!-- IF U_MCP --><li class="small-icon icon-mcp" data-last-responsive="true"><a href="{U_MCP}" title="{L_MCP}" role="menuitem">{L_MCP_SHORT}</a></li><!-- ENDIF -->*/
/* */
/* 			<style>*/
/* 				li.boardla{*/
/* 					list-style:none;*/
/* 				}*/
/* */
/* 				li.boardla::before{*/
/* 					content: none !important;*/
/* 				}*/
/* 				.boarden-th{*/
/* 					list-style: none;*/
/* 					margin: 0;*/
/* 				    padding: 0;*/
/* 				    overflow: hidden;*/
/* 				}*/
/* 				li.flag{*/
/* 					float: left;*/
/* 					padding: 0 5px;*/
/* 					margin: 0 3px;*/
/* 				}*/
/* 				.activeflag{*/
/* 					border-bottom: 3px solid #959595;*/
/* 				}*/
/* */
/* 				:target {*/
/* 				  color: red;*/
/* 				}*/
/* */
/* 				.activeLang{*/
/* 					color: red;*/
/* 				}*/
/* */
/* 			</style>*/
/* 			<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>*/
/* 			<li class="boardla">*/
/* <!--                               <ul class="boarden-th">*/
/*                                 <li class="flag activeflag"><a href="?lang=1"><img src="https://upload.wikimedia.org/wikipedia/en/thumb/a/ae/Flag_of_the_United_Kingdom.svg/1280px-Flag_of_the_United_Kingdom.svg.png" width="30px" alt=""></a></li>*/
/*                                 <li class="flag"><a href="?lang=2"><img src="https://i.pinimg.com/originals/93/89/28/938928e41dd1ff657c396cd2cb45d652.jpg"  width="30px" alt=""></a></li>*/
/*                               </ul>  -->*/
/* */
/*                              <a href="javascript:void(0)" id='target1' class='target' onclick="re('1')">EN</a> | <a href="javascript:void(0)" id='target2' class='target' onclick="re('2')">TH</a>*/
/* 							*/
/*             </li>*/
/*             <script>*/
/*             		$( document ).ready(function() {*/
/* 				        console.log( "document loaded" );*/
/* 				        activeLang();*/
/* 				    });*/
/* */
/* 				function activeLang(){*/
/* 					$(document).ready(function(){*/
/* 						var url_string = window.location.href;*/
/* 						var url = new URL(url_string);*/
/* 						var getValue = url.searchParams.get("lang");*/
/* 						var x = document.getElementsByClassName("target");*/
/* 					 */
/* 					    	if(getValue == 1){*/
/* 					    		$("#target1").addClass("activeLang");*/
/* 					    		$("#target2").removeClass("activeLang");*/
/* 					    		console.log("add target1");*/
/* 					    	}else{*/
/* 					    		$("#target2").addClass("activeLang");*/
/* 					    		$("#target1").removeClass("activeLang");*/
/* 					    		console.log("add target2");*/
/* 					    	}*/
/* 					        */
/* 						   */
/* 						});*/
/* 					}    */
/* */
/* 				function re(langId) {*/
/* 				    // location.reload();*/
/* 				    var url = window.location.href;*/
/* 				    // console.log(url);    */
/* 					   // url += '?lang='+langId;*/
/* 					var searchUrl = url.search("lang");*/
/* 					// console.log(searchUrl);*/
/* 					if(searchUrl <= -1){*/
/* 						url += "&lang="+langId;*/
/* 					}else{*/
/* */
/* 					   if(langId == 1){*/
/* 					   	 url = url.replace(/lang=2/g , "lang="+langId);*/
/* 					   }else{*/
/* 					   	 url = url.replace(/lang=1/g , "lang="+langId);*/
/* 					   }*/
/* 					}*/
/* 					// console.log(url);*/
/* */
/* 					window.location.href = url;*/
/* 				}*/
/* */
/* 			</script>*/
/* */
/* 	<!-- IF S_REGISTERED_USER -->*/
/* 		<!-- EVENT navbar_header_user_profile_prepend -->*/
/* 			<li id="username_logged_in" class="rightside <!-- IF CURRENT_USER_AVATAR --> no-bulletin<!-- ENDIF -->" data-skip-responsive="true">*/
/* 				<!-- EVENT navbar_header_username_prepend -->*/
/* 				<div class="header-profile dropdown-container">*/
/* 					<a href="{U_PROFILE}" class="header-avatar dropdown-trigger"><!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR} <!-- ENDIF -->{CURRENT_USERNAME_SIMPLE}</a>*/
/* 					<div class="dropdown hidden">*/
/* 						<div class="pointer"><div class="pointer-inner"></div></div>*/
/* 						<ul class="dropdown-contents" role="menu">*/
/* 							<!-- IF U_RESTORE_PERMISSIONS --><li class="small-icon icon-restore-permissions"><a href="{U_RESTORE_PERMISSIONS}">{L_RESTORE_PERMISSIONS}</a></li><!-- ENDIF -->*/
/* 	*/
/* 							<!-- EVENT navbar_header_profile_list_before -->*/
/* 	*/
/* 							<li class="small-icon icon-ucp"><a href="{U_PROFILE}" title="{L_PROFILE}" role="menuitem">{L_PROFILE}</a></li>*/
/* 							<li class="small-icon icon-profile"><a href="{U_USER_PROFILE}" title="{L_READ_PROFILE}" role="menuitem">{L_READ_PROFILE}</a></li>*/
/* 	*/
/* 							<!-- EVENT navbar_header_profile_list_after -->*/
/* 	*/
/* 							<li class="separator"></li>*/
/* 							<li class="small-icon icon-logout"><a href="{U_LOGIN_LOGOUT}" title="{L_LOGIN_LOGOUT}" accesskey="x" role="menuitem">{L_LOGIN_LOGOUT}</a></li>*/
/* 						</ul>*/
/* 					</div>*/
/* 				</div>*/
/* 				<!-- EVENT navbar_header_username_append -->*/
/* 			</li>*/
/* 			<!-- IF S_DISPLAY_PM -->*/
/* 				<li class="small-icon icon-pm rightside" data-skip-responsive="true">*/
/* 					<a href="{U_PRIVATEMSGS}" role="menuitem"><span>{L_PRIVATE_MESSAGES} </span><strong class="badge<!-- IF not PRIVATE_MESSAGE_COUNT --> hidden<!-- ENDIF -->">{PRIVATE_MESSAGE_COUNT}</strong></a>*/
/* 				</li>*/
/* 			<!-- ENDIF -->*/
/* 			<!-- IF S_NOTIFICATIONS_DISPLAY -->*/
/* 				<li class="small-icon icon-notification dropdown-container dropdown-{S_CONTENT_FLOW_END} rightside" data-skip-responsive="true">*/
/* 					<a href="{U_VIEW_ALL_NOTIFICATIONS}" id="notification_list_button" class="dropdown-trigger"><span>{L_NOTIFICATIONS} </span><strong class="badge<!-- IF not NOTIFICATIONS_COUNT --> hidden<!-- ENDIF -->">{NOTIFICATIONS_COUNT}</strong></a>*/
/* 					<!-- INCLUDE notification_dropdown.html -->*/
/* 				</li>*/
/* 			<!-- ENDIF -->*/
/* 			<!-- EVENT navbar_header_user_profile_append -->*/
/* 		<!-- ELSE -->*/
/* 			<li class="small-icon icon-logout rightside"  data-skip-responsive="true"><a href="{U_LOGIN_LOGOUT}" title="{L_LOGIN_LOGOUT}" accesskey="x" role="menuitem">{L_LOGIN_LOGOUT}</a></li>*/
/* 			<!-- IF S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) -->*/
/* 				<li class="small-icon icon-register rightside" data-skip-responsive="true"><a href="{U_REGISTER}" role="menuitem">{L_REGISTER}</a></li>*/
/* 			<!-- ENDIF -->*/
/* 			<!-- EVENT navbar_header_logged_out_content -->*/
/* 		<!-- ENDIF -->*/
/* 		</ul>*/
/* 	</div>*/
/* </div>*/
