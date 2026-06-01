<style>
.create-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 30px 20px;
}
.create-header {
    margin-bottom: 25px;
}
.create-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0 0 8px 0;
}
.create-header a {
    font-size: 13px;
    color: #667eea;
    text-decoration: none;
}
.create-card {
    background: #fff;
    border-radius: 14px;
    padding: 28px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.form-group {
    margin-bottom: 20px;
}
.form-group label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #333;
    margin-bottom: 8px;
}
.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    font-size: 14px;
    box-sizing: border-box;
    transition: all 0.2s ease;
}
.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}
.member-list {
    max-height: 280px;
    overflow-y: auto;
    border: 1px solid #e8e8e8;
    border-radius: 10px;
    padding: 10px;
}
.member-option {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s ease;
}
.member-option:hover {
    background: #f5f6fa;
}
.member-option input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 12px;
    accent-color: #667eea;
}
.member-option .member-name {
    font-size: 14px;
    font-weight: 500;
    color: #333;
}
.member-option .member-email {
    font-size: 12px;
    color: #888;
    margin-left: 6px;
}
.btn-submit {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
</style>

<div class="create-container">

    <?php $this->renderFeedbackMessages(); ?>

    <div class="create-header">
        <h1>✨ Create New Group</h1>
        <a href="<?= Config::get('URL'); ?>group/index">← Back to Groups</a>
    </div>

    <div class="create-card">
        <form method="post" action="<?= Config::get('URL'); ?>group/createAction">

            <div class="form-group">
                <label for="group_name">Group Name</label>
                <input type="text" id="group_name" name="group_name" class="form-input" placeholder="Enter group name..." required />
            </div>

            <div class="form-group">
                <label>Add Members</label>
                <div class="member-list">
                    <?php foreach ($this->users as $user): ?>
                        <?php if ($user->user_id == Session::get('user_id')) continue; ?>
                        <label class="member-option">
                            <input type="checkbox" name="members[]" value="<?= $user->user_id; ?>" />
                            <span class="member-name"><?= htmlspecialchars($user->user_name); ?></span>
                            <span class="member-email"><?= htmlspecialchars($user->user_email); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn-submit">Create Group</button>

        </form>
    </div>

</div>
