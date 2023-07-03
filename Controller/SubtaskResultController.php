<?php

namespace Kanboard\Plugin\SubtaskResult\Controller;

use Kanboard\Controller\BaseController;

class SubtaskResultController extends BaseController
{
    public function get()
    {
        $subtaskId = $this->request->getIntegerParam("Id");
        if (isset($subtaskId)) {
            $this->response->text($this->subtaskResultModel->getById($subtaskId));
        }
    }

    public function save()
    {
        $values = $this->request->getJson();

        if (isset($values)) {
            $subTask = $this->subtaskModel->getById(key($values));
            $taskId = $subTask['task_id'];

            if ($taskId != 0) {
                foreach ($values as $subtaskId => $Text) {
                    $this->subtaskResultModel->save($subtaskId,  $Text);
                }
                $this->flash->success(t("Updated successfully"));
                $this->response->redirect($this->helper->url->to('TaskViewController', 'show', array('task_id' => $taskId)), true);
            }
        }
    }

    public function edit()
    {
        $subtask_id = $this->request->getIntegerParam('subtask_id');

        $html = '<div class="subtaskResultEdit">';
        $html .= '<textarea class="subtaskResultInput" id="' . $subtask_id . '">' . $this->subtaskResultModel->getById($subtask_id) . '</textarea>';
        $html .= '<div style="display:flex">';
        $html .= '<i class="fa fa-fw fa-save js-subtask-result-save" aria-hidden="true" style="cursor: pointer;"></i>';
        $html .= '<i class="fa fa-fw fa-close js-subtask-result-close" aria-hidden="true" style="cursor: pointer;"></i>';
        $html .= '</div>';
        $html .= '</div>';

        $this->response->html($html);
    }

    public function render($subtask_id)
    {
        $editButton = $this->helper->url->icon('edit', '', 'SubtaskResultController', 'edit', array('subtask_id' => $subtask_id, 'plugin' => 'SubtaskResult'), false, 'js-subtask-result-edit');
        $text = $this->helper->text->markdown($this->helper->app->subtaskResultModel->getById($subtask_id), isset($is_public) && $is_public);

        $html = '<div class="subtaskResultDisplay">';
        $html .= '<div class="pull-right">' . $editButton . '</div>';
        $html .= '<div class="markdown subtaskResultText">' . $text . '</div>';
        $html .= '</div>';

        return $html;
    }
}
