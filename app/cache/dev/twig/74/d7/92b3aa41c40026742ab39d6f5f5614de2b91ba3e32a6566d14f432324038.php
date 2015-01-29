<?php

/* AppBundle:BusinessService:show.html.twig */
class __TwigTemplate_74d792b3aa41c40026742ab39d6f5f5614de2b91ba3e32a6566d14f432324038 extends Twig_Template
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
        // line 6
        echo "<div class=\"container\">

        <div class=\"page-header\">
            <h1>Service #";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "ref", array()), "html", null, true);
        echo "</h1>
        </div>

        <table class=\"record_properties table\">
            <tbody>
            <tr>
                <th>Id</th>
                <td>";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id", array()), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Référence</th>
                <td>";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "ref", array()), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Nom</th>
                <td>";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "name", array()), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "description", array()), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Actif</th>
                <td> ";
        // line 32
        if (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "enabled", array()) == 1)) {
            // line 33
            echo "                        <span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>
                    ";
        }
        // line 34
        echo "</td>
            </tr>
            </tbody>
        </table>

        <ul class=\"record_actions\">
            <li>
                <a class=\"btn btn-default\" href=\"";
        // line 41
        echo $this->env->getExtension('routing')->getPath("admin_service");
        echo "\">
                    Back to the list
                </a>
            </li>
            <li>
                <a class=\"btn btn-default\" href=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_service_edit", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id", array()))), "html", null, true);
        echo "\">
                    Edit
                </a>
            </li>
            <li>";
        // line 50
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["delete_form"]) ? $context["delete_form"] : $this->getContext($context, "delete_form")), 'form');
        echo "</li>
        </ul>

    </div>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:BusinessService:show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 50,  105 => 46,  97 => 41,  88 => 34,  84 => 33,  82 => 32,  75 => 28,  68 => 24,  61 => 20,  54 => 16,  44 => 9,  39 => 6,  36 => 3,  11 => 1,);
    }
}
