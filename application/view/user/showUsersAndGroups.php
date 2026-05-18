<div class="container">
    <h1>Users / Groups</h1>
    <p>This page shows all users and the group that they are in.</p>
    <div class="box">
        <table id="users-groups-table" class="overview-table">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>User Group</td>
                    <td>Profile</td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($this->users as $user) { ?>
                <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                    <td><?= $user->user_id; ?></td>
                    <td class="avatar">
                        <?php if (isset($user->user_avatar_link)) { ?>
                            <img src="<?= $user->user_avatar_link; ?>">
                        <?php } ?>
                    </td>
                    <td><?= $user->user_name; ?></td>
                    <td><?= $user->user_email; ?></td>
                    <td><?= $user->account_type_name; ?></td>
                    <td>
                        <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>">
                            View
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#users-groups-table').DataTable();
    });
</script>