<?php

namespace Kanboard\Plugin\SubtaskResult\Model;

use Kanboard\Core\Base;

class SubtaskResultModel extends Base
{
    protected function getTable()
    {
        return "subtaskResult";
    }

    public function getById($Id)
    {
        $result = $this->db->table($this->getTable())->eq('id', $Id)->findOne();
        if (isset($result['text'])) {
            return $result['text'];
        }
    }

    public function save($Id, $Text)
    {
        $this->db->startTransaction();
        $Entry = $this->db->table($this->getTable())->eq('id', $Id);
        if ($Entry->exists()) {
            $Entry->update(
                array(
                    'text' => $Text
                )
            );
        } else {
            $this->db->table($this->getTable())->insert(
                array(
                    'id' => $Id,
                    'text' => $Text
                )
            );
        }
        $this->db->closeTransaction();

        $this->queueManager->push($this->subtaskEventJob->withParams(
            $Id,
            array('subtask.update'),
            array($Text)
        ));
    }

    public function copy($sourceId, $destinationId)
    {
        $text = $this->getById($sourceId);
        if (isset($text)) {
            $this->save($destinationId, $text);
        }
    }
}
