<style>
.members-container {
    max-width: 700px;
    margin: 0 auto;
    padding: 30px 20px;
}
.members-header {
    margin-bottom: 25px;
}
.members-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 8px 0;
}
.members-header a {
    font-size: 13px;
    color: #667eea;
    text-decoration: none;
}
.members-card {
    background: #fff;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    margin-bottom: 16px;
}
.members-card h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 16px 0;
}
.member-row {
    display: flex;
    align-items: center;
    padding: 12px 14px;
    border-radius: 10px;
    margin-bottom: 6px;
    background: #f8f9fd;
}
.member-row .member-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    margin-right: 12px;
    flex-shrink: 0;
}
.member-row .member-info {
    flex: 1;
}
.member-row .member-info .name {
    font-weight: 500;
    font-size: 14px;
    color: #333;
}
.member-row .member-info .email {
    font-size: 12px;
    color: #888;
}
.member-row .member-action {
    flex-shrink: 0;
}
.badge-you {
    font-size: 12px;
    color: #667eea;
    background: #f0f2ff;
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 500;
}
.btn-remove {
    padding: 6px 14px;
    background: #fff0f0;
    color: #ff4757;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-remove:hover {
    background: #ff4757;
    color: #fff;
}
.add-member-form {
    display: flex;
    gap: 10px;
    align-items: center;
}
.add-member-form select {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    background: #f8f9fd;
}
.add-member-form select:focus {
    outline: none;
    border-color: #667eea;
}
.btn-add {
    padding: 10px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
</style>

<div class="members-container">

    <?php $this->renderFeedbackMessages(); ?>

    <div class="members-header">
        <h1>👥 <?= htmlspecialchars($this->group->group_name); ?></h1>
        <a href="<?= Config::get('URL'); ?>group/chat/<?= $this->group->id; ?>">← Back to Chat</a>
    </div>

    <div class="members-card">
        <h3>Current Members</h3>
        <?php foreach ($this->members as $member): ?>
            <div class="member-row">
                <div class="member-avatar">
                    <?= strtoupper(substr($member->user_name, 0, 1)); ?>
                </div>
                <div class="member-info">
                    <div class="name"><?= htmlspecialchars($member->user_name); ?></div>
                    <div class="email"><?= htmlspecialchars($member->user_email); ?></div>
                </div>
                <div class="member-action">
                    <?php if ($member->user_id != Session::get('user_id')): ?>
                        <form method="post" action="<?= Config::get('URL'); ?>group/removeMember" style="display:inline;">
                            <input type="hidden" name="group_id" value="<?= $this->group->id; ?>" />
                            <input type="hidden" name="user_id" value="<?= $member->user_id; ?>" />
                            <button type="submit" class="btn-remove" onclick="return confirm('Really remove?');">Remove</button>
                        </form>
                    <?php else: ?>
                        <span class="badge-you">You</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="members-card">
        <h3>Add Member</h3>
        <form method="post" action="<?= Config::get('URL'); ?>group/addMember" class="add-member-form">
            <input type="hidden" name="group_id" value="<?= $this->group->id; ?>" />
            <select name="user_id">
                <?php
                $memberIds = array_map(function($m) { return $m->user_id; }, $this->members);
                foreach ($this->users as $user):
                    if (in_array($user->user_id, $memberIds)) continue;
                ?>
                    <option value="<?= $user->user_id; ?>">
                        <?= htmlspecialchars($user->user_name); ?> (<?= htmlspecialchars($user->user_email); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-add">Add</button>
        </form>
    </div>

</div>
