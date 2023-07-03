<?php

namespace Kanboard\Plugin\SubtaskResult;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach("template:subtask:table:header:before-timetracking", "subtaskResult:Subtask/show");
        $this->template->hook->attach("template:subtask:table:rows", "SubtaskResult:Subtask/rows");
        $this->template->setTemplateOverride('event/subtask_update', 'SubtaskResult:event/subtask_update');

        $this->hook->on('template:layout:js', array('template' => 'plugins/SubtaskResult/Assets/js/functions.js'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/SubtaskResult/Assets/css/result.css'));

        $this->route->addRoute('SubtaskResult/save', 'SubtaskResultController', 'save', 'SubtaskResult');
        $this->route->addRoute('SubtaskResult/get', 'SubtaskResultController', 'get', 'SubtaskResult');

        $this->hook->on('model:task:project_duplication:aftersave', function ($hook_values) {
            $sourceSubtasks = $this->subtaskModel->getAll($hook_values['source_task_id']);
            $destinationSubtasks = $this->subtaskModel->getAll($hook_values['destination_task_id']);

            foreach ($sourceSubtasks as $index => $unused) {
                $this->subtaskResultModel->copy($sourceSubtasks[$index]['id'], $destinationSubtasks[$index]['id']);
            }
        });
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
            ),
            'Plugin\SubtaskResult\Controller' => array(
                'SubtaskResultController'
            )
        );
    }

    public function getPluginDescription()
    {
        return 'Add a freely editable field in the subtasks to store results or similar things in.
works with Markdown Plus';
    }

    public function getPluginAuthor()
    {
        return 'Tomas Dittmann';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/Chaosmeister/SubtaskResult';
    }
}
