<style>
.discussion {
	max-width: 600px;
	margin: 0 auto;
	
	display: flex;
	flex-flow: column wrap;
}

.discussion > .bubble {
	border-radius: 1em;
	padding: 0.25em 0.75em;
	margin: 0.0625em;
	max-width: 50%;
}

.discussion > .bubble.sender {
	align-self: flex-start;
	background-color: cornflowerblue;
	color: #fff;
}
.discussion > .bubble.recipient {
	align-self: flex-end;
	background-color: #efefef;
}

.discussion > .bubble.sender.first { border-bottom-left-radius: 0.1em; }
.discussion > .bubble.sender.last { border-top-left-radius: 0.1em; }
.discussion > .bubble.sender.middle {
	border-bottom-left-radius: 0.1em;
 	border-top-left-radius: 0.1em;
}

.discussion > .bubble.recipient.first { border-bottom-right-radius: 0.1em; }
.discussion > .bubble.recipient.last { border-top-right-radius: 0.1em; }
.discussion > .bubble.recipient.middle {
	border-bottom-right-radius: 0.1em;
	border-top-right-radius: 0.1em;
}

.chat-input-wrapper {
    margin-top: 20px;
    border-top: 1px solid #ddd;
    padding-top: 15px;
}

.chat-message-input {
    width: 100%;
    min-height: 90px;

    box-sizing: border-box;

    background-color: #f5f5f5;
    border: 1px solid #ccc;

    padding: 10px;

    font-family: Arial, sans-serif;
    font-size: 14px;

    resize: vertical;
}

.chat-message-input:focus {
    outline: none;
    border-color: #454545;
    background-color: #fff;
}

.chat-send-button {
    margin-top: 10px;

    background-color: #ccc;
    border: 0;

    padding: 8px 15px;

    cursor: pointer;
}

.chat-send-button:hover {
    background-color: #222;
    color: #fff;
}
</style>

<div class="container">

    <h1>Chat with <?= htmlspecialchars($this->user->user_name); ?></h1>

    <section class="discussion">

        <?php foreach ($this->messages as $msg): ?>
            <?php $isSender = ($msg->from_user_id == $this->fromUserId); ?>
            <div class="bubble <?= $isSender ? 'sender' : 'recipient'; ?>">
                <?= htmlspecialchars($msg->message); ?>
            </div>
        <?php endforeach; ?>

        <div class="chat-input-wrapper">

            <form method="post" action="<?= Config::get('URL'); ?>messenger/send">

                <input
                    type="hidden"
                    name="to_user_id"
                    value="<?= $this->user->user_id; ?>"
                >

                <textarea
                    name="message"
                    class="chat-message-input"
                    placeholder="Nachricht eingeben..."
                    required
                ></textarea>

                <button type="submit" class="chat-send-button">
                    Senden
                </button>

            </form>

        </div>

    </section>

</div>