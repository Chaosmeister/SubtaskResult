<td class="subtaskResult">
    <div class="subtaskResultDisplay">
        <i class="fa fa-fw fa-edit button subtaskResultEdit" aria-hidden="true"></i>
        <div class="markdown subtaskResultText">
            <?= $this->text->markdown($this->app->subtaskResultModel->GetById($subtask["id"]), isset($is_public) && $is_public) ?>
        </div>
    </div>
</td>