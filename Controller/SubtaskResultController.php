<?php

namespace Kanboard\Plugin\SubtaskResult\Controller;

use Kanboard\Controller\BaseController;

class SubtaskResultController extends BaseController
{
    public function get()
    {
        $subtaskId = $this->request->getIntegerParam("Id");
        if (isset($subtaskId)) {
            $this->response->text($this->subtaskResultModel->GetById($subtaskId));
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
}
