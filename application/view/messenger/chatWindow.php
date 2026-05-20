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
</style>

<div class="container">
    
    <h1>Messenger Chat Bubbles</h1>


<section class="discussion">
	
	<div class="bubble sender first">Hello</div>
	<div class="bubble sender last">This is a CSS demo of the Messenger chat bubbles, that merge when stacked together.</div>
	
	<div class="bubble recipient first">Oh that's cool!</div>
	<div class="bubble recipient last">Did you use JavaScript to perform that kind of effect?</div>
	
	<div class="bubble sender first">No, that's full CSS3!</div>
	<div class="bubble sender middle">Take a look to the 'JS' section of this Pen... it's empty! 😃</div>
	<div class="bubble sender last">And it's also really lightweight!</div>
	
	<div class="bubble recipient">Dope!</div>
	
	<div class="bubble sender first">Yeah, but I still didn't succeed to get rid of these stupid .first and .last classes.</div>
	<div class="bubble sender middle">The only solution I see is using JS, or a &lt;div&gt; to group elements together, but I don't want to ...</div>
	<div class="bubble sender last">I think it's more transparent and easier to group .bubble elements in the same parent.</div>
	
</section>

</div>