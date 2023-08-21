<?php

/* navbar_footer.html */
class __TwigTemplate_594a90e2b85a6a330735ae82199ed204188c0c76ed1b919a9ccd27a451d2311a extends Twig_Template
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
        echo "<div class=\"navbar\" role=\"navigation\">
<div class=\"navbar-container\" role=\"navigation\">
\t<div class=\"inner\">

\t\t<ul id=\"nav-footer\" class=\"linklist bulletin\" role=\"menubar\">
\t\t\t<li class=\"small-icon\">
\t\t\t";
        // line 7
        // line 8
        echo "\t\t\t";
        // line 9
        echo "\t\t\t</li>
\t\t\t";
        // line 10
        // line 11
        echo "\t\t\t<li class=\"rightside\">";
        echo (isset($context["S_TIMEZONE"]) ? $context["S_TIMEZONE"] : null);
        echo "</li>
\t\t\t";
        // line 12
        // line 13
        echo "\t\t\t";
        if ( !(isset($context["S_IS_BOT"]) ? $context["S_IS_BOT"] : null)) {
            // line 14
            echo "\t\t\t\t<li class=\"small-icon icon-delete-cookies rightside\"><a href=\"";
            echo (isset($context["U_DELETE_COOKIES"]) ? $context["U_DELETE_COOKIES"] : null);
            echo "\" data-ajax=\"true\" data-refresh=\"true\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("DELETE_COOKIES");
            echo "</a></li>
\t\t\t\t";
            // line 15
            if ((isset($context["S_DISPLAY_MEMBERLIST"]) ? $context["S_DISPLAY_MEMBERLIST"] : null)) {
                echo "<li class=\"small-icon icon-members rightside\" data-last-responsive=\"true\"><a href=\"";
                echo (isset($context["U_MEMBERLIST"]) ? $context["U_MEMBERLIST"] : null);
                echo "\" title=\"";
                echo $this->env->getExtension('phpbb')->lang("MEMBERLIST_EXPLAIN");
                echo "\" role=\"menuitem\">";
                echo $this->env->getExtension('phpbb')->lang("MEMBERLIST");
                echo "</a></li>";
            }
            // line 16
            echo "\t\t\t";
        }
        // line 17
        echo "\t\t\t";
        // line 18
        echo "\t\t\t";
        if ((isset($context["U_TEAM"]) ? $context["U_TEAM"] : null)) {
            echo "<li class=\"small-icon icon-team rightside\" data-last-responsive=\"true\"><a href=\"";
            echo (isset($context["U_TEAM"]) ? $context["U_TEAM"] : null);
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("THE_TEAM");
            echo "</a></li>";
        }
        // line 19
        echo "\t\t\t";
        // line 20
        echo "\t\t\t";
        if ((isset($context["U_CONTACT_US"]) ? $context["U_CONTACT_US"] : null)) {
            echo "<li class=\"small-icon icon-contact rightside\" data-last-responsive=\"true\"><a href=\"";
            echo (isset($context["U_CONTACT_US"]) ? $context["U_CONTACT_US"] : null);
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("CONTACT_US");
            echo "</a></li>";
        }
        // line 21
        echo "\t\t</ul>
\t\t
\t</div>
</div>
</div>";
    }

    public function getTemplateName()
    {
        return "navbar_footer.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 21,  76 => 20,  74 => 19,  65 => 18,  63 => 17,  60 => 16,  50 => 15,  43 => 14,  40 => 13,  39 => 12,  34 => 11,  33 => 10,  30 => 9,  28 => 8,  27 => 7,  19 => 1,);
    }
}
/* <div class="navbar" role="navigation">*/
/* <div class="navbar-container" role="navigation">*/
/* 	<div class="inner">*/
/* */
/* 		<ul id="nav-footer" class="linklist bulletin" role="menubar">*/
/* 			<li class="small-icon">*/
/* 			<!-- EVENT overall_footer_breadcrumb_prepend -->*/
/* 			<!-- EVENT overall_footer_breadcrumb_append -->*/
/* 			</li>*/
/* 			<!-- EVENT overall_footer_timezone_before -->*/
/* 			<li class="rightside">{S_TIMEZONE}</li>*/
/* 			<!-- EVENT overall_footer_timezone_after -->*/
/* 			<!-- IF not S_IS_BOT -->*/
/* 				<li class="small-icon icon-delete-cookies rightside"><a href="{U_DELETE_COOKIES}" data-ajax="true" data-refresh="true" role="menuitem">{L_DELETE_COOKIES}</a></li>*/
/* 				<!-- IF S_DISPLAY_MEMBERLIST --><li class="small-icon icon-members rightside" data-last-responsive="true"><a href="{U_MEMBERLIST}" title="{L_MEMBERLIST_EXPLAIN}" role="menuitem">{L_MEMBERLIST}</a></li><!-- ENDIF -->*/
/* 			<!-- ENDIF -->*/
/* 			<!-- EVENT overall_footer_teamlink_before -->*/
/* 			<!-- IF U_TEAM --><li class="small-icon icon-team rightside" data-last-responsive="true"><a href="{U_TEAM}" role="menuitem">{L_THE_TEAM}</a></li><!-- ENDIF -->*/
/* 			<!-- EVENT overall_footer_teamlink_after -->*/
/* 			<!-- IF U_CONTACT_US --><li class="small-icon icon-contact rightside" data-last-responsive="true"><a href="{U_CONTACT_US}" role="menuitem">{L_CONTACT_US}</a></li><!-- ENDIF -->*/
/* 		</ul>*/
/* 		*/
/* 	</div>*/
/* </div>*/
/* </div>*/
