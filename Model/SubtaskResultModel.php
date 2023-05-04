<?php

namespace Kanboard\Plugin\SubtaskResult\Model;

use Kanboard\Core\Base;

class SubtaskResultModel extends Base
{
    protected function getTable()
    {
        return "subtaskResult";
    }

    public function GetById($Id)
    {
        $result = $this->db->table($this->getTable())->eq('id', $Id)->findOne();
        if (isset($result['text'])) {
            return $result['text'];
        }
    }

    public function Save($Id, $Text)
    {
        if ($this->GetById($Id) == "") {
            $this->db->table($this->getTable())->insert(
                array(
                    'id' => $Id,
                    'text' => $Text
                )
            );
        } else {
            $this->db->table($this->getTable())->eq('id', $Id)->update(
                array(
                    'text' => $Text
                )
            );
        }
    }
}
