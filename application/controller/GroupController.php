<?php

class GroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Shows all groups the user is a member of, with option to create new groups.
     */
    public function index()
    {
        $userId = Session::get('user_id');
        $this->View->render('messenger/groups', array(
            'groups' => GroupModel::getGroupsOfUser($userId),
            'unreadCounts' => GroupModel::getUnreadCountsPerGroup($userId),
        ));
    }

    /**
     * Show the create group form.
     */
    public function create()
    {
        $this->View->render('messenger/groupCreate', array(
            'users' => UserModel::getPublicProfilesOfAllUsers(),
        ));
    }

    /**
     * Handle group creation.
     */
    public function createAction()
    {
        $userId = Session::get('user_id');
        $groupName = Request::post('group_name');
        $memberIds = Request::post('members'); // array of user_ids

        if (!$groupName) {
            Redirect::to('group/create');
            return;
        }

        $groupId = GroupModel::createGroup($groupName, $userId);

        if ($memberIds && is_array($memberIds)) {
            foreach ($memberIds as $memberId) {
                if ($memberId != $userId) {
                    GroupModel::addMember($groupId, $memberId);
                }
            }
        }

        Redirect::to('group/chat/' . $groupId);
    }

    /**
     * Group chat window.
     */
    public function chat($groupId)
    {
        $userId = Session::get('user_id');

        if (!GroupModel::isMember($groupId, $userId)) {
            Redirect::to('group/index');
            return;
        }

        GroupModel::markAsRead($groupId, $userId);

        $this->View->render('messenger/chatWindow', array(
            'isGroupChat' => true,
            'group' => GroupModel::getGroup($groupId),
            'messages' => GroupModel::getMessages($groupId),
            'fromUserId' => $userId,
        ));
    }

    /**
     * Send a message to the group.
     */
    public function send()
    {
        $userId = Session::get('user_id');
        $groupId = Request::post('group_id');
        $message = Request::post('message');

        if ($groupId && $message && GroupModel::isMember($groupId, $userId)) {
            GroupModel::sendMessage($groupId, $userId, $message);
        }

        Redirect::to('group/chat/' . $groupId);
    }

    /**
     * Show manage members page (only for group creator).
     */
    public function members($groupId)
    {
        $userId = Session::get('user_id');

        if (!GroupModel::isCreator($groupId, $userId)) {
            Redirect::to('group/chat/' . $groupId);
            return;
        }

        $this->View->render('messenger/groupMembers', array(
            'group' => GroupModel::getGroup($groupId),
            'members' => GroupModel::getMembers($groupId),
            'users' => UserModel::getPublicProfilesOfAllUsers(),
        ));
    }

    /**
     * Add a member to the group.
     */
    public function addMember()
    {
        $userId = Session::get('user_id');
        $groupId = Request::post('group_id');
        $newMemberId = Request::post('user_id');

        if ($groupId && $newMemberId && GroupModel::isCreator($groupId, $userId)) {
            GroupModel::addMember($groupId, $newMemberId);
        }

        Redirect::to('group/members/' . $groupId);
    }

    /**
     * Remove a member from the group.
     */
    public function removeMember()
    {
        $userId = Session::get('user_id');
        $groupId = Request::post('group_id');
        $removeMemberId = Request::post('user_id');

        if ($groupId && $removeMemberId && GroupModel::isCreator($groupId, $userId)) {
            GroupModel::removeMember($groupId, $removeMemberId);
        }

        Redirect::to('group/members/' . $groupId);
    }
}
