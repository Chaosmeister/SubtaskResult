<?php

namespace Kanboard\Plugin\SubtaskResult;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach("template:subtask:table:header:before-timetracking", "subtaskResult:Subtask/show");
        $this->template->hook->attach("template:subtask:table:rows", "SubtaskResult:Subtask/rows");

        $this->hook->on('template:layout:js', array('template' => 'plugins/SubtaskResult/Assets/js/functions.js'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/SubtaskResult/Assets/css/result.css'));

        $this->route->addRoute('SubtaskResult/save', 'SubtaskResultController', 'save', 'SubtaskResult');
        $this->route->addRoute('SubtaskResult/get', 'SubtaskResultController', 'get', 'SubtaskResult');
    }

    public function getPluginName()
    {
        return 'SubtaskResult';
    }

    public function getClasses()
    {
        return array(
            'Plugin\SubtaskResult\Model' => array(
                'SubtaskResultModel'
            )
        );
    }

    public function getPluginDescription()
    {
        return 'Add a freely editable field in the subtasks to store results or similar things in';
    }

    public function getPluginAuthor()
    {
        return 'Tomas Dittmann';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }
}
