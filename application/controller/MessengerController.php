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
        $this->View->render('messenger/index', array(
            'users' => UserModel::getPublicProfilesOfAllUsers())
        );
    }

    public function chatWindow()
    {
        $this->View->render('messenger/chatWindow');
    }

}
