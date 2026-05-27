<?php

class MessengerController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method controls what happens when you move to /overview/index in your app.
     * Shows a list of all users.
     */
    public function index()
    {
        $currentUserId = Session::get('user_id');
        $this->View->render('messenger/index', array(
            'users' => UserModel::getPublicProfilesOfAllUsers(),
            'unreadCounts' => MessengerModel::getUnreadCountsPerUser($currentUserId),
        ));
    }

    public function chatWindow($toUserId)
    {
        $fromUserId = Session::get('user_id');

        MessengerModel::markAsRead($toUserId, $fromUserId);

        $this->View->render('messenger/chatWindow', array(
            'user' => UserModel::getPublicProfileOfUser($toUserId),
            'messages' => MessengerModel::getConversation($fromUserId, $toUserId),
            'fromUserId' => $fromUserId,
        ));
    }

    public function send()
    {
        $fromUserId = Session::get('user_id');
        $toUserId = Request::post('to_user_id');
        $message = Request::post('message');

        if ($toUserId && $message) {
            MessengerModel::sendMessage($fromUserId, $toUserId, $message);
        }

        Redirect::to('messenger/chatWindow/' . $toUserId);
    }

}
