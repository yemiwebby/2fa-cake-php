<?php
?>
<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>Provide One-Time Token</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please provide the token that has been sent to your mobile number') ?></legend>
        <?= $this->Form->control('token', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Verify')); ?>
    <?= $this->Form->end() ?>
</div>
