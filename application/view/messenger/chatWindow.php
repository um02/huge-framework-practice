<style>
.chat-container {
    max-width: 700px;
    margin: 0 auto;
    padding: 30px 20px;
}
.chat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 16px 20px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.chat-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.chat-header-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 600;
    font-size: 16px;
}
.chat-header h1 {
    font-size: 18px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}
.chat-header-actions a {
    font-size: 13px;
    color: #667eea;
    text-decoration: none;
    padding: 6px 14px;
    border-radius: 6px;
    background: #f0f2ff;
    transition: all 0.2s ease;
}
.chat-header-actions a:hover {
    background: #667eea;
    color: #fff;
}
.discussion {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 24px 16px;
    background: #f8f9fd;
    border-radius: 16px;
    min-height: 300px;
    max-height: 500px;
    overflow-y: auto;
}
.discussion .bubble {
    border-radius: 18px;
    padding: 10px 16px;
    max-width: 65%;
    font-size: 14px;
    line-height: 1.5;
    word-wrap: break-word;
    position: relative;
}
.discussion .bubble.sender {
    align-self: flex-end;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border-bottom-right-radius: 4px;
}
.discussion .bubble.recipient {
    align-self: flex-start;
    background: #fff;
    color: #333;
    border-bottom-left-radius: 4px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
.discussion .bubble .sender-name {
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 3px;
    opacity: 0.8;
}
.discussion .bubble.sender .sender-name {
    color: rgba(255,255,255,0.8);
}
.discussion .bubble.recipient .sender-name {
    color: #667eea;
}
.chat-input-wrapper {
    margin-top: 16px;
    padding: 16px 20px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.chat-input-form {
    display: flex;
    gap: 12px;
    align-items: flex-end;
}
.chat-message-input {
    flex: 1;
    min-height: 44px;
    max-height: 120px;
    box-sizing: border-box;
    background-color: #f5f6fa;
    border: 1px solid transparent;
    border-radius: 12px;
    padding: 12px 16px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 14px;
    resize: none;
    transition: all 0.2s ease;
}
.chat-message-input:focus {
    outline: none;
    border-color: #667eea;
    background-color: #fff;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}
.chat-send-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: 0;
    color: #fff;
    padding: 12px 24px;
    border-radius: 12px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.chat-send-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
</style>

<div class="chat-container">

    <div class="chat-header">
        <div class="chat-header-left">
            <?php if (!empty($this->isGroupChat)): ?>
                <div class="chat-header-avatar">👥</div>
                <h1><?= htmlspecialchars($this->group->group_name); ?></h1>
            <?php else: ?>
                <div class="chat-header-avatar">
                    <?= strtoupper(substr($this->user->user_name, 0, 1)); ?>
                </div>
                <h1><?= htmlspecialchars($this->user->user_name); ?></h1>
            <?php endif; ?>
        </div>
        <div class="chat-header-actions">
            <?php if (!empty($this->isGroupChat)): ?>
                <a href="<?= Config::get('URL'); ?>group/index">← Back</a>
                <a href="<?= Config::get('URL'); ?>group/members/<?= $this->group->id; ?>">Members</a>
            <?php else: ?>
                <a href="<?= Config::get('URL'); ?>messenger/index">← Back</a>
            <?php endif; ?>
        </div>
    </div>

    <section class="discussion">
        <?php foreach ($this->messages as $msg): ?>
            <?php $isSender = ($msg->from_user_id == $this->fromUserId); ?>
            <div class="bubble <?= $isSender ? 'sender' : 'recipient'; ?>">
                <?php if (!empty($this->isGroupChat)): ?>
                    <div class="sender-name"><?= htmlspecialchars($msg->user_name); ?></div>
                <?php endif; ?>
                <?= htmlspecialchars($msg->message); ?>
            </div>
        <?php endforeach; ?>
    </section>

    <div class="chat-input-wrapper">
        <?php if (!empty($this->isGroupChat)): ?>
            <form method="post" action="<?= Config::get('URL'); ?>group/send" class="chat-input-form">
                <input type="hidden" name="group_id" value="<?= $this->group->id; ?>" />
        <?php else: ?>
            <form method="post" action="<?= Config::get('URL'); ?>messenger/send" class="chat-input-form">
                <input type="hidden" name="to_user_id" value="<?= $this->user->user_id; ?>" />
        <?php endif; ?>

                <textarea
                    name="message"
                    class="chat-message-input"
                    placeholder="Type a message..."
                    required
                ></textarea>

                <button type="submit" class="chat-send-button">Send</button>
            </form>
    </div>

</div>