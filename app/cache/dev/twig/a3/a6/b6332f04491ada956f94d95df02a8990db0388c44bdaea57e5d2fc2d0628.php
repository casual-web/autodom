<?php

/* AppBundle:BusinessService:new.html.twig */
class __TwigTemplate_a3a6b6332f04491ada956f94d95df02a8990db0388c44bdaea57e5d2fc2d0628 extends Twig_Template
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

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"container\">
        <div class=\"page-header\">
            <h1>Création d'un nouveau service</h1>
        </div>

        ";
        // line 9
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "
        <ul class=\"record_actions\">
            <li>
                <a class=\"btn btn-default\" role=\"button\" href=\"";
        // line 12
        echo $this->env->getExtension('routing')->getPath("admin_service");
        echo "\">
                    Retour à la liste
                </a>
            </li>
        </ul>
    </div>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:BusinessService:new.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 12,  46 => 9,  39 => 4,  36 => 3,  11 => 1,);
    }
}
