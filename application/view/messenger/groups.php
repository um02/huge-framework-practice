<style>
.groups-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 30px 20px;
}
.groups-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}
.groups-header h1 {
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
.btn-secondary {
    background: #f0f2ff;
    color: #667eea;
}
.btn-secondary:hover {
    background: #667eea;
    color: #fff;
}
.group-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.group-card {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.2s ease;
}
.group-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
.group-card .group-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 20px;
    margin-right: 14px;
    flex-shrink: 0;
}
.group-card .group-info {
    flex: 1;
}
.group-card .group-info .group-name {
    font-weight: 600;
    font-size: 15px;
    color: #1a1a2e;
}
.group-card .group-info .group-meta {
    font-size: 13px;
    color: #888;
    margin-top: 2px;
}
.group-card .group-actions {
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
.btn-open {
    padding: 8px 16px;
    background: #f0f2ff;
    color: #667eea;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-open:hover {
    background: #667eea;
    color: #fff;
}
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #888;
}
.empty-state .empty-icon {
    font-size: 48px;
    margin-bottom: 12px;
}
.empty-state p {
    font-size: 15px;
}
</style>

<div class="groups-container">

    <?php $this->renderFeedbackMessages(); ?>

    <div class="groups-header">
        <h1>👥 Group Chats</h1>
        <div style="display:flex; gap:10px;">
            <a href="<?= Config::get('URL'); ?>messenger/index" class="btn btn-secondary">← Messenger</a>
            <a href="<?= Config::get('URL'); ?>group/create" class="btn btn-primary">+ New Group</a>
        </div>
    </div>

    <?php if (empty($this->groups)): ?>
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <p>You are not in any group yet.<br>Create one to get started!</p>
        </div>
    <?php else: ?>
        <div class="group-list">
            <?php foreach ($this->groups as $group): ?>
                <div class="group-card">
                    <div class="group-icon">👥</div>
                    <div class="group-info">
                        <div class="group-name"><?= htmlspecialchars($group->group_name); ?></div>
                        <div class="group-meta"><?= $group->member_count; ?> members</div>
                    </div>
                    <div class="group-actions">
                        <?php if (!empty($this->unreadCounts[$group->id])): ?>
                            <span class="badge-unread"><?= $this->unreadCounts[$group->id]; ?></span>
                        <?php endif; ?>
                        <a href="<?= Config::get('URL'); ?>group/chat/<?= $group->id; ?>" class="btn-open">Open Chat</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
