<?php

/* AppBundle:BusinessService:edit.html.twig */
class __TwigTemplate_ce35d0eb5c19bd8d561dd2d57319734f6166dd899a282c8986176223acbbfc7d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("::base.html.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 7
        echo "<div class=\"container\">

    <div class=\"page-header\">
        <h1>Edition d'un service</h1>
    </div>

    ";
        // line 13
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["edit_form"]) ? $context["edit_form"] : $this->getContext($context, "edit_form")), 'form');
        echo "


    <ul class=\"record_actions\">
        <li>
            <a class=\"btn btn-default\" role=\"button\" href=\"";
        // line 18
        echo $this->env->getExtension('routing')->getPath("admin_service");
        echo "\">
                Retour à la liste
            </a>
        </li>
        <li>";
        // line 22
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["delete_form"]) ? $context["delete_form"] : $this->getContext($context, "delete_form")), 'form');
        echo "</li>
    </ul>


</div>

";
    }

    public function getTemplateName()
    {
        return "AppBundle:BusinessService:edit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 22,  55 => 18,  47 => 13,  39 => 7,  36 => 4,  11 => 1,);
    }
}
