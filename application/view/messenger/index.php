<style>
.messenger-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 30px 20px;
}
.messenger-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}
.messenger-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}
.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}
.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
.user-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.user-card {
    display: flex;
    align-items: center;
    padding: 14px 18px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.2s ease;
    text-decoration: none;
    color: inherit;
    position: relative;
}
.user-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
.user-card .user-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 600;
    font-size: 16px;
    margin-right: 14px;
    overflow: hidden;
    flex-shrink: 0;
}
.user-card .user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.user-card .user-info {
    flex: 1;
}
.user-card .user-info .user-name {
    font-weight: 600;
    font-size: 15px;
    color: #1a1a2e;
}
.user-card .user-info .user-email {
    font-size: 13px;
    color: #888;
    margin-top: 2px;
}
.user-card .user-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.badge-unread {
    background: #ff4757;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 12px;
    min-width: 22px;
    text-align: center;
}
.btn-chat {
    padding: 8px 16px;
    background: #f0f2ff;
    color: #667eea;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-chat:hover {
    background: #667eea;
    color: #fff;
}
.btn-profile {
    padding: 8px 16px;
    background: #f5f5f5;
    color: #555;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-profile:hover {
    background: #e0e0e0;
}
</style>

<div class="messenger-container">

    <?php $this->renderFeedbackMessages(); ?>

    <div class="messenger-header">
        <h1>💬 Messenger</h1>
        <a href="<?= Config::get('URL'); ?>group/index" class="btn btn-primary">👥 Group Chats</a>
    </div>

    <div class="user-list">
        <?php foreach ($this->users as $user): ?>
            <div class="user-card">
                <div class="user-avatar">
                    <?php if (isset($user->user_avatar_link)): ?>
                        <img src="<?= $user->user_avatar_link; ?>" />
                    <?php else: ?>
                        <?= strtoupper(substr($user->user_name, 0, 1)); ?>
                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <div class="user-name"><?= htmlspecialchars($user->user_name); ?></div>
                    <div class="user-email"><?= htmlspecialchars($user->user_email); ?></div>
                </div>
                <div class="user-actions">
                    <?php if (!empty($this->unreadCounts[$user->user_id])): ?>
                        <span class="badge-unread"><?= $this->unreadCounts[$user->user_id]; ?></span>
                    <?php endif; ?>
                    <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>" class="btn-profile">Profile</a>
                    <a href="<?= Config::get('URL') . 'messenger/chatWindow/' . $user->user_id; ?>" class="btn-chat">Chat</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
